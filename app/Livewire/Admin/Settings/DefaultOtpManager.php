<?php

namespace App\Livewire\Admin\Settings;

use App\Models\DefaultOtp;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class DefaultOtpManager extends Component
{
    use WithPagination;

    public $otp = '';
    public $description = '';
    public $is_active = true;
    public $search = '';

    protected $rules = [
        'otp' => 'required|digits:6|unique:default_otps,otp',
        'description' => 'required|min:3',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        DefaultOtp::create([
            'otp' => $this->otp,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        $this->reset(['otp', 'description', 'is_active']);
        session()->flash('success', 'Master OTP created successfully.');
    }

    public function toggleActive($id)
    {
        $otp = DefaultOtp::findOrFail($id);
        $otp->update(['is_active' => !$otp->is_active]);
    }

    public function delete($id)
    {
        DefaultOtp::findOrFail($id)->delete();
        session()->flash('success', 'Master OTP deleted successfully.');
    }

    public function render()
    {
        $masterOtps = DefaultOtp::query()
            ->when($this->search, function ($query) {
                $query->where('otp', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.settings.default-otp-manager', [
            'masterOtps' => $masterOtps
        ]);
    }
}
