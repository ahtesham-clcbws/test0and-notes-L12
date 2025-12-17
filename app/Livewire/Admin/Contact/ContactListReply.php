<?php

namespace App\Livewire\Admin\Contact;

use App\Models\NewModels\ContactQuery;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('Layouts.admin')]
class ContactListReply extends Component
{
    public ContactQuery $contact;

    #[Validate('required')]
    public $message = '';

    public function mount($id)
    {
        $this->contact = ContactQuery::find($id);
    }

    public function render()
    {
        return view('livewire.admin.contact.contact-list-reply');
    }

    public function save()
    {
        if ($this->validate()) {
            try {
                $this->contact->replies()->create([
                    'message' => $this->message
                ]);
                // $this->contact->notify(new ContactInfoReplyMail($this->contact, $this->message));
                $this->contact->update(['status' => true]);
                $this->js('success("Reply message sent successfully.")');
                return redirect()->route('administrator.manage.contactRelpiesList', $this->contact->id);
            } catch (\Throwable $th) {
                $this->js('error("Failed to send reply message. ' . $th->getMessage() . '")');
            }
        }
    }
}
