<?php

namespace App\Livewire\Forms\Frontend;

use App\Models\NewModels\ContactQuery;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactUsForm extends Form
{
    #[Validate('required', message: 'Please enter your name.')]
    #[Validate('min:2', message: 'Name must be minimum of 2 characters.')]
    public $name = '';

    #[Validate('required', message: 'Please enter your phone number.')]
    #[Validate('min_digits:10', message: 'Phone number must be minimum of 10 digits.')]
    #[Validate('max_digits:10', message: 'Phone number must not exceeds 10 digits.')]
    public $phone;

    #[Validate('required', message: 'Please enter your email.')]
    #[Validate('email', message: 'Please enter valid email address')]
    public $email;

    #[Validate('required', message: 'Please enter your city/district/state.')]
    #[Validate('min:2', message: 'Must be minimum of 2 characters.')]
    public $city = '';

    #[Validate('required', message: 'Please select the subject.')]
    public $subject = '';

    #[Validate('required', message: 'Please enter your query.')]
    public $query = '';

    public function saveContact()
    {
        $this->validate();
        try {
            $contactQuery = ContactQuery::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'city' => $this->city,
                'subject' => $this->subject,
                'query' => $this->query,
            ]);

            return $contactQuery;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
