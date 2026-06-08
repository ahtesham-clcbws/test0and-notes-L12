<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\CorporateEnquiry;
use App\Models\OtpVerifications;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContributorSignUp extends Component
{
    use WithFileUploads;

    public $name;

    public $email;

    public $mobile;

    public $mobile_otp;

    public $password;

    public $confirm_password;

    public $institute_code;

    public $user_logo;

    public $required_check_registration;

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users', 'email'),
                \Illuminate\Validation\Rule::unique('corporate_enquiries', 'email'),
            ],
            'mobile' => 'required|digits:10|unique:users,mobile',
            'mobile_otp' => [
                'required',
                'digits:6',
                \Illuminate\Validation\Rule::exists('otp_verifications', 'otp')->where(function ($query) {
                    return $query->where('credential', $this->mobile);
                }),
            ],
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'institute_code' => [
                'nullable',
                \Illuminate\Validation\Rule::exists('corporate_enquiries', 'branch_code')->where(function ($query) {
                    return $query->where('status', 'activated');
                }),
            ],
            'user_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:200',
            'required_check_registration' => 'required|accepted',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile Number is required.',
            'mobile.digits' => 'Mobile Number must be 10 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
            'mobile_otp.required' => 'OTP is required.',
            'mobile_otp.digits' => 'OTP must be 6 digits.',
            'mobile_otp.exists' => 'Invalid OTP.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'confirm_password.required' => 'Confirm Password is required.',
            'confirm_password.min' => 'Confirm Password must be at least 8 characters.',
            'confirm_password.same' => 'Password and Confirm Password must match.',

            'institute_code.exists' => 'Invalid Institute Code or Institute is not active.',
            'user_logo.mimes' => 'Profile Image must be a file of type: jpeg, png, jpg.',
            'user_logo.max' => 'Profile Image must not be greater than 200 kilobytes.',
            'required_check_registration.accepted' => 'You must agree to the Terms of Services.',
            'required_check_registration.required' => 'You must agree to the Terms of Services.',
        ];
    }

    public $isOtpSend = false;

    public $otpVerificationStatus = false;

    public function getOtp()
    {
        try {
            if ($this->validateOnly('mobile')) {
                $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
                $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $this->mobile], ['created_at', '>', $time]])->first();
                $otp = getMobileOtp($this->mobile);
                if ($otpData) {
                    $this->isOtpSend = true;
                    $this->js('success("OTP already sent to this mobile number.")');
                } else {
                    OtpVerifications::create([
                        'type' => 'mobile',
                        'credential' => $this->mobile,
                        'otp' => $otp,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    if (config('app.live_laravel_otp')) {
                        // Send SMS OTP via MSG91
                        try {
                            $smsSent = app(\App\Services\Msg91Service::class)->sendSms($this->mobile, $otp);
                            if ($smsSent) {
                                $this->isOtpSend = true;
                                $this->js('success("OTP sent successfully to your mobile number.")');
                            } else {
                                $this->isOtpSend = false;
                                $this->addError('mobile', 'Failed to send OTP.');
                                $this->js('error("Failed to send OTP. Please try again.")');
                            }
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error('Error sending contributor signup OTP SMS: '.$e->getMessage());
                            $this->isOtpSend = false;
                            $this->addError('mobile', 'Error sending OTP.');
                            $this->js('error("Error sending OTP. Please try again.")');
                        }
                    } else {
                        $this->isOtpSend = true;
                        $this->js('success("OTP sent successfully to your mobile number.")');
                    }
                }
            } else {
                $this->addError('mobile', 'Invalid mobile number');
                $this->isOtpSend = false;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->isOtpSend = false;
            $this->js('error("'.$e->validator->errors()->first('mobile').'")');
            throw $e;
        } catch (\Throwable $th) {
            $this->isOtpSend = false;
            throw $th;
        }
    }

    public $institute_name = '';

    public function verifyInstitute()
    {
        if (empty($this->institute_code)) {
            $this->institute_name = '';
            $this->resetValidation('institute_code');

            return;
        }

        $this->validateOnly('institute_code');

        $institute = CorporateEnquiry::where('branch_code', $this->institute_code)
            ->where('status', 'activated')
            ->first();

        if ($institute) {
            $this->institute_name = $institute->institute_name;
        } else {
            $this->addError('institute_code', 'Invalid Institute Code');
            $this->institute_name = '';
        }
    }

    public function verifyOtp()
    {
        try {
            if ($this->validateOnly('mobile_otp')) {
                if (verifyOtp($this->mobile_otp, $this->mobile)) {
                    $this->otpVerificationStatus = true;
                    $this->resetValidation('mobile_otp');
                    $this->resetValidation('mobile');
                    $this->js('success("OTP verified successfully.")');
                } else {
                    $this->otpVerificationStatus = false;
                    $this->addError('mobile_otp', 'Invalid OTP or expired.');
                    $this->js('error("Invalid OTP or expired.")');
                }
            } else {
                $this->otpVerificationStatus = false;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->otpVerificationStatus = false;
            $this->js('error("'.$e->validator->errors()->first('mobile_otp').'")');
            throw $e;
        } catch (\Throwable $th) {
            $this->otpVerificationStatus = false;
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.contributor-sign-up');
    }

    public function register()
    {
        // first verify if mobile otp is verified
        if (! $this->otpVerificationStatus) {
            $this->addError('mobile_otp', 'Please verify your mobile number first.');
            $this->js('error("Please verify your mobile number first.")');

            return;
        }

        $this->validate();
        try {

            $userDb = new User;
            $userDetailsDb = new UserDetails;

            $userDb->status = 'unread';
            $userDb->username = $this->email;
            $userDb->name = $this->name;
            $userDb->email = $this->email;
            $userDb->mobile = $this->mobile;

            $userDb->is_staff = 1;
            $userDb->is_franchise = 0;
            $userDb->roles = 'contributor';

            $userDb->in_franchise = ($this->institute_code == '') ? 0 : 1;
            $userDb->franchise_code = $this->institute_code;
            $userDetailsDb->institute_code = filter_var($this->institute_code);

            $userDb->password = Hash::make($this->password);

            if ($userDb->save()) {
                $userDetailsDb->user_id = $userDb->id;

                if ($this->user_logo) {
                    $fullPath = app(\App\Services\ImageService::class)->handleUpload($this->user_logo, 'contributor_uploads/'.$userDb->id, 400);
                    $userDetailsDb->photo_url = $fullPath;
                }

                $userDetailsDb->save();
                $this->js('success("Thank you, we will active your request soon.")');
                $this->reset();
                $this->js("setTimeout(() => window.location.href = '/', 1500)");
            } else {
                $this->js('error("Unable to register, please try again later.")');
            }

        } catch (\Throwable $th) {
            throw $th;
            $this->js('error("Server Error, please try again later.")');
        }
    }
}
