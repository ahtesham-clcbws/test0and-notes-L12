<?php

namespace App\Livewire\Frontend;

use App\Models\AccountDeletionRequest;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AccountDeletePage extends Component
{
    public $email;

    public $mobile;

    public $delete_all_data = false;

    public $backup_data = false;

    public $isVerified = false;

    #[Layout('Layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.account-delete-page');
    }

    public function verifyUser()
    {
        $this->isVerified = false;
        $this->resetErrorBag();

        if (empty($this->email) && empty($this->mobile)) {
            $this->addError('verification', 'Please enter at least email or mobile number.');

            return;
        }

        $query = User::query()->where('roles', 'student');

        if (! empty($this->email) && ! empty($this->mobile)) {
            $query->where(function ($q) {
                $q->where('email', $this->email)
                    ->orWhere('mobile', $this->mobile);
            });
        } elseif (! empty($this->email)) {
            $query->where('email', $this->email);
        } else {
            $query->where('mobile', $this->mobile);
        }

        $user = $query->first();

        if (! $user) {
            $this->addError('verification', 'Student not found.');

            return;
        }

        // Auto-populate
        if (empty($this->email) && ! empty($user->email)) {
            $this->email = $user->email;
        }
        if (empty($this->mobile) && ! empty($user->mobile)) {
            $this->mobile = $user->mobile;
        }

        $this->isVerified = true;
        $this->js("success('Student verified successfully! Please review the options below.')");
    }

    public function submitRequest()
    {
        if (! $this->isVerified) {
            $this->addError('verification', 'Please verify your credentials first.');

            return;
        }

        // Check if pending request already exists
        $exists = AccountDeletionRequest::where('status', 'pending')
            ->where(function ($q) {
                if (! empty($this->email)) {
                    $q->where('email', $this->email);
                }
                if (! empty($this->mobile)) {
                    $q->orWhere('mobile', $this->mobile);
                }
            })->exists();

        if ($exists) {
            $this->addError('verification', 'An active deletion request already exists for these credentials.');

            return;
        }

        AccountDeletionRequest::create([
            'email' => $this->email,
            'mobile' => $this->mobile,
            'delete_all_data' => $this->delete_all_data,
            'backup_data' => $this->backup_data,
            'status' => 'pending',
        ]);

        $this->reset(['email', 'mobile', 'delete_all_data', 'backup_data', 'isVerified']);
        $this->js("success('Account deletion request submitted successfully. You have 72 hours to cancel this request from your dashboard.')");
    }
}
