<?php

namespace App\Livewire\Admin\Settings;

use App\Models\OtpVerifications;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class OtpManager extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteOtp($id)
    {
        $otp = OtpVerifications::find($id);
        if ($otp) {
            $otp->delete();
            session()->flash('success', 'OTP Record deleted successfully.');
        }
    }

    public function clearExpired()
    {
        // OTPs are valid for 10 minutes in the backend logic, so older ones are expired.
        // We delete anything older than 15 minutes to be safe.
        $time = date('Y-m-d H:i:s', strtotime('-15 minutes'));
        OtpVerifications::where('created_at', '<', $time)->delete();
        session()->flash('success', 'All expired OTPs have been cleared.');
        $this->resetPage();
    }

    public function render()
    {
        $otps = OtpVerifications::query()
            ->when($this->search, function ($query) {
                $query->where('credential', 'like', "%{$this->search}%")
                    ->orWhere('otp', 'like', "%{$this->search}%")
                    ->orWhere('type', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.settings.otp-manager', [
            'otps' => $otps,
        ]);
    }
}
