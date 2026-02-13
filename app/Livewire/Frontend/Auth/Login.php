<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required', message: 'Mobile/Email is required')]
    public $username;

    #[Validate('required', message: 'Password is required')]
    public $password;

    public $remember_me = true;

    public function render()
    {
        return view('livewire.frontend.auth.login');
    }

    #[Url]
    public $redirect = '';

    public function login()
    {
        $this->validate();
        try {
            $fieldType = 'username';
            if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
                $fieldType = 'email';
            }
            if (filter_var($this->username, FILTER_VALIDATE_INT) && strlen(filter_var($this->username, FILTER_VALIDATE_INT)) == 10) {
                $fieldType = 'mobile';
            }
            $user = User::where($fieldType, $this->username)->first();
            if(!$user || $user->roles !== 'student' || $user->status !== 'active'){
                $this->addError('username', 'Your account is not active or credentials do not match');
                return;
            }
            if (Auth::attempt([$fieldType => $this->username, 'password' => $this->password], $this->remember_me)) {
                $this->js('success("Login successful")');

                if (!empty($this->redirect)) {
                    return redirect($this->redirect);
                }

                return redirect('/student');
            } else {
                $this->addError('username', 'Credentials do not match');
            }
        } catch (\Throwable $th) {
            $this->js('error("' . $th->getMessage() . '")');
            //throw $th;
        }
    }
}
