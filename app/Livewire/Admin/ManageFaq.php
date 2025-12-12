<?php

namespace App\Livewire\Admin;

use App\Models\NewModels\FrequentlyAskedQuestion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class ManageFaq extends Component
{
    // use WithPagination;
    #[Url('limit')]
    public $limit = 5;
    #[Url('search')]
    public $search = '';

    public function render()
    {
        $query = FrequentlyAskedQuestion::query();
        if ($this->search) {
            $query->where('question', 'LIKE', '%' . $this->search . '%')->orWhere('answer', 'LIKE', '%' . $this->search . '%');
        }
        $faqs = $query->orderByDesc('id')->paginate($this->limit);
        return view('livewire.admin.manage-faq', [
            'faqs' => $faqs
        ]);
    }

    public bool $formState = false;
    public ?int $faqId = null;

    #[Validate('required')]
    #[Validate('min:10')]
    public ?string $question = null;
    #[Validate('required')]
    #[Validate('min:10')]
    public ?string $answer = null;

    public function editFaq(int $faqId, string $question, string $answer)
    {
        $this->faqId = $faqId;
        $this->question = $question;
        $this->answer = $answer;
        $this->formState = true;
    }

    public function save()
    {
        $this->validate();
        try {
            if ($this->faqId) {
                FrequentlyAskedQuestion::where('id', $this->faqId)
                    ->update([
                        'question' => $this->question,
                        'answer' => $this->answer,
                        'status' => true
                    ]);
            } else {
                FrequentlyAskedQuestion::create([
                    'question' => $this->question,
                    'answer' => $this->answer,
                ]);
            }
            $this->formState = false;
            $this->reset();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function toggleForm()
    {
        if ($this->formState) {
            $this->formState = false;
            $this->reset();
        } else {
            $this->formState = true;
        }
    }

    public function deleteFaq($id)
    {
        try {
            FrequentlyAskedQuestion::destroy($id);
        } catch (\Throwable $th) {
            //throw $th;
            $this->js('alert(' . $th->getMessage() . ')');
        }
    }

    public function changeStatus($id, string $status)
    {
        try {
            FrequentlyAskedQuestion::where('id', $id)->update(['status' => $status == 'true' ? false : true]);
        } catch (\Throwable $th) {
            //throw $th;
            $this->js('alert(' . $th->getMessage() . ')');
        }
    }
}
