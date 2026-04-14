<?php

namespace App\Livewire\Student\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.student-mary')]
class ResetPasswordPage extends Component
{
    use Toast;

    #[Rule('required|min:6')]
    public string $new_password = '';

    #[Rule('required|same:new_password')]
    public string $confirm_password = '';

    public function resetPassword(): void
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();
        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->new_password = '';
        $this->confirm_password = '';

        $this->success('Password changed successfully!', position: 'toast-bottom toast-end');
    }

    public function render()
    {
        return view('livewire.student.auth.reset-password-page');
    }
}
