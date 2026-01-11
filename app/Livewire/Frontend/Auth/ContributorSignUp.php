<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\ClassGoupExamModel;
use App\Models\CorporateEnquiry;
use App\Models\Educationtype;
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
                \Illuminate\Validation\Rule::unique('corporate_enquiries', 'email')
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
                'required',
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
            'institute_code.required' => 'Institute Code is required.',
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
                    $this->addError('mobile', 'OTP already sent');
                } else {
                    OtpVerifications::create([
                        'type' => 'mobile',
                        'credential' => $this->mobile,
                        'otp' => $otp,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                $this->isOtpSend = true;
                $this->js('success("OTP sent successfully.")');
            } else {
                $this->addError('mobile', 'Invalid mobile number');
                $this->isOtpSend = false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public $institute_name = '';

    public function verifyInstitute()
    {
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
                $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
                $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $this->mobile], ['created_at', '>', $time]])->first();
                if ($otpData) {
                    $this->otpVerificationStatus = true;
                    $this->resetValidation('mobile_otp');
                    $this->resetValidation('mobile');
                } else {
                    $this->addError('mobile_otp', 'Invalid OTP');
                    $this->otpVerificationStatus = false;
                }
            } else {
                $this->otpVerificationStatus = false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        $education_types = Educationtype::all();
        $classes_groups_exams = ClassGoupExamModel::all();

        return view('livewire.frontend.auth.contributor-sign-up', [
            'education_types' => $education_types,
            'classes_groups_exams' => $classes_groups_exams
        ]);
    }


    public function register()
    {
        $this->validate();
        try {

            $userDb         = new User();
            $userDetailsDb  = new UserDetails();

            $userDb->status     = 'unread';
            $userDb->username   = $this->email;
            $userDb->name       = $this->name;
            $userDb->email      = $this->email;
            $userDb->mobile     = $this->mobile;

            $userDb->is_staff       =  1;
            $userDb->is_franchise   =  0;

            $userDb->in_franchise           =  ($this->institute_code == '') ? 0 : 1;
            $userDb->franchise_code         =  $this->institute_code;
            $userDetailsDb->institute_code  =  filter_var($this->institute_code);

            $userDb->password        = Hash::make($this->password);

            if ($userDb->save()) {
                $userDetailsDb->user_id =  $userDb->id;

                if ($this->user_logo) {
                    $userDetailsDb->photo_url = $this->user_logo->store('contributor_uploads/' . $userDb->id, 'public');
                }

                $userDetailsDb->save();
                $this->js('success("Thank you, we will active your request soon.")');
                $this->reset();
                return $this->redirect('/');
            } else {
                $this->js('error("Unable to register, please try again later.")');
            }

        } catch (\Throwable $th) {
            throw $th;
            $this->js('error("Server Error, please try again later.")');
        }
    }
}
