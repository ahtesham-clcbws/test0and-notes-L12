<?php

namespace App\Livewire\Frontend;

use App\Livewire\Forms\Frontend\ContactUsForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layouts.frontend')]
class ContactUsPage extends Component
{
    public ContactUsForm $form;

    public function render()
    {
        return view('livewire.frontend.contact-us-page');
    }

    public function sendContact()
    {
        $this->form->validate();
        try {
            $this->form->saveContact();
            $this->form->reset();
            $this->js("success('Your Enquiry Form Submitted Successfully, we will contact you, if needed')");
        } catch (\Throwable $th) {
            $this->js("error('Failed to send contact')");
            throw $th;
        }
    }
}
