<?php

namespace App\Livewire\Admin\Contact;

use App\Models\NewModels\ContactQuery;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('Layouts.admin')]
class ContactRepliesList extends Component
{
    public ContactQuery $contact;

    public function mount($id)
    {
        $this->contact = ContactQuery::find($id);
    }

    public function render()
    {
        return view('livewire.admin.contact.contact-replies-list');
    }
}
