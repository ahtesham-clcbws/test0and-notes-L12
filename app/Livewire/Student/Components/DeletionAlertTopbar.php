<?php

namespace App\Livewire\Student\Components;

use App\Models\AccountDeletionRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeletionAlertTopbar extends Component
{
    public $hasPendingRequest = false;

    public $remainingTime = '';

    public $requestId;

    public function mount()
    {
        $this->checkRequest();
    }

    public function checkRequest()
    {
        $user = Auth::user();
        if (! $user) {
            $this->hasPendingRequest = false;

            return;
        }

        $request = AccountDeletionRequest::where('status', 'pending')
            ->where(function ($q) use ($user) {
                if (! empty($user->email)) {
                    $q->where('email', $user->email);
                }
                if (! empty($user->mobile)) {
                    $q->orWhere('mobile', $user->mobile);
                }
            })
            ->first();

        if ($request) {
            $deadline = $request->created_at->addHours(72);
            if (now()->lessThan($deadline)) {
                $this->hasPendingRequest = true;
                $this->requestId = $request->id;

                $diff = now()->diff($deadline);
                $this->remainingTime = sprintf('%02d hours, %02d minutes', ($diff->days * 24) + $diff->h, $diff->i);
            } else {
                $this->hasPendingRequest = false;
            }
        } else {
            $this->hasPendingRequest = false;
        }
    }

    public function cancelRequest()
    {
        $user = Auth::user();
        if (! $user || ! $this->requestId) {
            return;
        }

        $request = AccountDeletionRequest::where('id', $this->requestId)
            ->where('status', 'pending')
            ->first();

        if ($request) {
            $deadline = $request->created_at->addHours(72);
            if (now()->greaterThanOrEqualTo($deadline)) {
                $this->js("error('The 72-hour cancellation window has expired.')");

                return;
            }

            $request->update(['status' => 'cancelled']);
            $this->hasPendingRequest = false;
            $this->js("success('Your account deletion request has been cancelled.')");

            // Redirect or refresh
            return redirect(request()->header('Referer'));
        }
    }

    public function render()
    {
        $this->checkRequest();

        return view('livewire.student.components.deletion-alert-topbar');
    }
}
