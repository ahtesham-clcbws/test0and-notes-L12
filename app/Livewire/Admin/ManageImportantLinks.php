<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\ImportantLinkForm;
use App\Models\NewModels\ImportantLink;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('Layouts.admin')]
class ManageImportantLinks extends Component
{
    use WithFileUploads;

    public $length = 2;
    public $search = '';
    public ImportantLinkForm $form;
    
    public function render()
    {
        $important_links = ImportantLink::orderByDesc('id')
            ->when($this->search, function ($q) {
                $searchString = '%' . $this->search . '%';
                return $q
                    ->where('title', 'LIKE', $searchString)
                    ->orWhere('url', 'LIKE', $searchString);
            })
            ->get();
            // ->pagina

        return view('livewire.admin.manage-important-links', [
            'important_links' => $important_links
        ]);
    }


    public function saveLink()
    {
        try {
            $this->form->save();
            $this->form->reset();
            $this->js('window.location.reload()');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editLink($id)
    {
        try {
            $important_link = ImportantLink::find($id);
            $this->form->setData($important_link);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
