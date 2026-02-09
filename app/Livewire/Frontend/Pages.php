<?php

namespace App\Livewire\Frontend;

use App\Models\NewModels\Pages as PageModel;
use App\Models\Educationtype;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('Layouts.frontend')]
class Pages extends Component
{
    public ?PageModel $page;
    public ?Educationtype $educationType;
    public $classes = [];

    public function mount(string $slug)
    {
        if (!$slug) {
            return redirect('/');
        }

        if ($page = PageModel::where('slug', $slug)->first()) {
            $this->page = $page;
        } elseif ($educationType = Educationtype::where('slug', $slug)->first()) {
            $this->educationType = $educationType;
            $this->classes = $educationType->class_exam()->get();
        } else {
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.frontend.pages');
    }
}
