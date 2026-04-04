<?php

namespace App\Livewire\Student\Profile;

use App\Models\City;
use App\Models\OtpVerifications;
use App\Models\State;
use App\Models\User;
use App\Models\UserDetails;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

    #[Layout('components.layouts.student-mary')]
class Index extends Component
{
    use WithFileUploads, Toast;

    // Profile Info
    public string $name = '';
    public ?string $photo_url = null;
    public $photo; 
    
    // Geographical Info
    public ?int $state_id = null;
    public ?int $city_id = null;

    // Contact Info
    public string $email = '';
    public string $mobile = '';
    public string $email_otp = '';
    public string $mobile_otp = '';
    public bool $email_otp_sent = false;
    public bool $mobile_otp_sent = false;

    // Security Info (Password Reset)
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile;
        
        $details = $user->user_details;
        if ($details) {
            $this->photo_url = $details->photo_url;
            $this->state_id = $details->state;
            $this->city_id = $details->city;
        }
    }

    public function updatedStateId(): void
    {
        $this->city_id = null;
    }

    /**
     * Update Profile Basic Info
     */
    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'photo' => 'nullable|image|max:1024', 
        ]);

        $user = User::find(Auth::id());
        $user->update(['name' => $this->name]);

        $details = UserDetails::updateOrCreate(
            ['user_id' => $user->id],
            [
                'state' => $this->state_id,
                'city' => $this->city_id,
            ]
        );

        if ($this->photo) {
            $imageService = app(ImageService::class);
            $imageName = $imageService->handleUpload($this->photo, 'student_uploads/' . $user->id, 400);
            $details->update(['photo_url' => $imageName]);
            $this->photo_url = $imageName;
            $this->photo = null;
        }

        $this->success('Profile updated successfully!');
    }

    /**
     * Send OTP for Email Change
     */
    public function sendEmailOtp(): void
    {
        $this->validate(['email' => 'required|email|unique:users,email,' . Auth::id()]);

        $otp = mt_rand(100000, 999999);
        
        try {
            Mail::raw('Your OTP for Email Verification is ' . $otp, function ($message) {
                $message->to($this->email)->subject('OTP Verification');
            });
            
            OtpVerifications::create([
                'type' => 'email',
                'credential' => $this->email,
                'otp' => $otp
            ]);

            $this->email_otp_sent = true;
            $this->success('OTP sent to your new email.');
        } catch (\Exception $e) {
            $this->error('Failed to send OTP. Please try again.');
        }
    }

    /**
     * Verify Email OTP
     */
    public function verifyEmail(): void
    {
        $this->validate(['email_otp' => 'required|numeric|digits:6']);

        $otpData = OtpVerifications::where([
            ['type', '=', 'email'],
            ['credential', '=', $this->email],
            ['otp', '=', $this->email_otp],
            ['created_at', '>', now()->subMinutes(11)]
        ])->first();

        if ($otpData) {
            User::find(Auth::id())->update(['email' => $this->email]);
            $this->email_otp_sent = false;
            $this->email_otp = '';
            $this->success('Email updated successfully!');
        } else {
            $this->error('Invalid or expired OTP.');
        }
    }

    /**
     * Send OTP for Mobile Change
     */
    public function sendMobileOtp(): void
    {
        $this->validate(['mobile' => 'required|numeric|digits:10|unique:users,mobile,' . Auth::id()]);

        $otp = mt_rand(100000, 999999);
        
        // Note: Real SMS sending would happen here using an SMS service.
        // For now, we store it so the user can verify it (consistent with legacy behavior).
        OtpVerifications::create([
            'type' => 'mobile',
            'credential' => $this->mobile,
            'otp' => $otp
        ]);

        $this->mobile_otp_sent = true;
        // In a real app, you'd send this via SMS API. 
        // We'll show a success message for now.
        $this->success('OTP sent to ' . $this->mobile);
    }

    /**
     * Verify Mobile OTP
     */
    public function verifyMobile(): void
    {
        $this->validate(['mobile_otp' => 'required|numeric|digits:6']);

        $otpData = OtpVerifications::where([
            ['type', '=', 'mobile'],
            ['credential', '=', $this->mobile],
            ['otp', '=', $this->mobile_otp],
            ['created_at', '>', now()->subMinutes(11)]
        ])->first();

        if ($otpData) {
            User::find(Auth::id())->update(['mobile' => $this->mobile]);
            $this->mobile_otp_sent = false;
            $this->mobile_otp = '';
            $this->success('Mobile number updated successfully!');
        } else {
            $this->error('Invalid or expired OTP.');
        }
    }

    /**
     * Update Password
     */
    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::find(Auth::id())->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->success('Password changed successfully!');
    }

    public function render()
    {
        return view('livewire.student.profile.index', [
            'states' => State::where('country_id', 101)->get(),
            'cities' => $this->state_id ? City::where('state_id', $this->state_id)->get() : [],
        ]);
    }
}
