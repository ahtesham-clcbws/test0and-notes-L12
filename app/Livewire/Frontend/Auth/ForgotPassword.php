<?php

namespace App\Livewire\Frontend\Auth;

use App\Mail\OTPMail;
use App\Models\OtpVerifications;
use App\Models\User;
use App\Services\Msg91Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ForgotPassword extends Component
{
    #[Validate('required')]
    public $identifier; // email or mobile

    public $otp;

    public $password;

    public $password_confirmation;

    public $otpSent = false;

    public function sendOTP()
    {
        $this->validateOnly('identifier');

        $user = User::where('mobile', $this->identifier)
            ->orWhere('email', $this->identifier)
            ->first();

        if (! $user) {
            $this->addError('identifier', 'User not found.');

            return;
        }

        $otp = mt_rand(100000, 999999);

        OtpVerifications::updateOrCreate(
            ['credential' => $user->mobile],
            [
                'type' => 'mobile',
                'otp' => $otp,
                'status' => 'pending',
                'created_at' => now(),
            ]
        );

        if ($user->email) {
            try {
                Mail::to($user->email)->send(new OTPMail($otp));
                session()->flash('message', 'OTP sent to your registered email.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error sending OTP email: '.$e->getMessage());
                session()->flash('error', 'Error sending OTP email, but OTP is generated.');
            }
        }

        // Send SMS OTP via MSG91
        if ($user->mobile) {
            try {
                app(Msg91Service::class)->sendSms($user->mobile, $otp);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error sending OTP SMS: '.$e->getMessage());
            }
        }

        $this->otpSent = true;
    }

    public function verifyAndReset()
    {
        $this->validate([
            'otp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('mobile', $this->identifier)
            ->orWhere('email', $this->identifier)
            ->first();

        if ($user && verifyOtp($this->otp, $user->mobile)) {
            $user->password = Hash::make($this->password);
            $user->save();

            session()->flash('message', 'Password reset successfully. Please login.');

            return redirect()->route('login');
        } else {
            $this->addError('otp', 'Invalid or expired OTP.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.forgot-password');
    }
}
