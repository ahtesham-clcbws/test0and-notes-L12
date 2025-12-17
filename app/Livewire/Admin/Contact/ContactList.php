<?php

namespace App\Livewire\Admin\Contact;

use App\Models\NewModels\ContactQuery;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('Layouts.admin')]
class ContactList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $dataList = [];

    public $perPage = 10;

    public $searchQuery = '';

    public bool $selectAll = false;

    public $selectedRows = [];

    public ContactQuery $contactDetails;


    public function mount()
    {
        ContactQuery::where('isNew', true)->update(['isNew' => false]);
    }

    public function updated($property)
    {
        if ($property == 'selectAll') {
            $this->selectedRows = $this->selectAll ? $this->dataList : [];
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = ContactQuery::orderBy('id', 'desc')
        ->withCount('replies');

        if (!empty(trim($this->searchQuery))) {
            $query->where('name', 'LIKE', '%' . $this->searchQuery . '%');
            $query->orWhere('email', 'LIKE', '%' . $this->searchQuery . '%');
            $query->orWhere('phone', 'LIKE', '%' . $this->searchQuery . '%');
            $query->orWhere('city', 'LIKE', '%' . $this->searchQuery . '%');
            $query->orWhere('subject', 'LIKE', '%' . $this->searchQuery . '%');
            $query->orWhere('query', 'LIKE', '%' . $this->searchQuery . '%');
        }

        $contactsList = $query->paginate($this->perPage);
        $this->dataList = $contactsList->pluck('id');

        return view('livewire.admin.contact.contact-list', [
            'contactsList' => $contactsList
        ]);
    }


    public function showModal($contactId)
    {
        try {
            $this->contactDetails = ContactQuery::find($contactId);
            $this->js('(new bootstrap.Modal(document.getElementById("exampleModal"))).show()');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteSelected()
    {
        ContactQuery::whereIn('id', $this->selectedRows)->delete();
        $this->js("success('Successfully delete contacts.')");
        $this->selectedRows = [];
        $this->selectAll = false;
    }
    public function delete($id)
    {
        ContactQuery::where('id', $id)->delete();
        $this->js("success('Successfully delete contact')");
    }
}
