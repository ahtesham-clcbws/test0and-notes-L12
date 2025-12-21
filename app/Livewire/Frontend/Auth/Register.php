<?php

namespace App\Livewire\Frontend\Auth;

use App\Livewire\Forms\Frontend\StudentRegistrationForm;
use App\Models\CorporateEnquiry;
use App\Models\OtpVerifications;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;
    
    public StudentRegistrationForm $form;

    public $isOtpSend = false;
    public $otpVerificationStatus = false;

    public function testFormInput()
    {
        $this->form->full_name = 'Ahtesham';
        $this->form->email = 'ahtesham8@weblies.com';
        $this->form->mobile_number = '9810763320';

        $this->form->password = '23988725';
        $this->form->confirm_password = '23988725';
        $this->form->institute_code = 'ACC16160356';
        // $this->form->education_type_id = '1';
        // $this->form->class_group_exam_id = '1';
        // $this->form->user_logo = '123456';
        $this->form->required_check_registration = true;
    }

    public function updatedFormEducationTypeId($value)
    {
        $this->form->class_group_exam_id = null;
    }

    public function render()
    {
        // $this->testFormInput();
        return view('livewire.frontend.auth.register');
    }

    public function getOtp()
    {
        try {
            if ($this->form->validateOnly('mobile_number')) {
                $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
                $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $this->form->mobile_number], ['created_at', '>', $time]])->first();
                $otp = getMobileOtp($this->form->mobile_number);
                if ($otpData) {
                    $this->addError('form.mobile_number', 'OTP already sent');
                } else {
                    OtpVerifications::create([
                        'type' => 'mobile',
                        'credential' => $this->form->mobile_number,
                        'otp' => $otp,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                $this->isOtpSend = true;
            } else {
                $this->addError('form.mobile_number', 'Invalid mobile number');
                $this->isOtpSend = false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public $institute_name = '';

    public function verifyInstitute()
    {
        $this->validateOnly('form.institute_code');

        $institute = CorporateEnquiry::where('branch_code', $this->form->institute_code)
            ->where('status', 'activated')
            ->first();

        if ($institute) {
            $this->institute_name = $institute->institute_name;
        } else {
            $this->addError('form.institute_code', 'Invalid Institute Code');
            $this->institute_name = '';
        }
    }

    public function verifyOtp()
    {
        try {
            if ($this->form->validateOnly('mobile_otp')) {
                $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
                $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $this->form->mobile_number], ['created_at', '>', $time]])->first();
                if ($otpData) {
                    $this->otpVerificationStatus = true;
                    $this->resetValidation('form.mobile_otp');
                    $this->resetValidation('form.mobile_number');
                } else {
                    $this->addError('form.mobile_otp', 'Invalid OTP');
                    $this->otpVerificationStatus = false;
                }
            } else {
                $this->otpVerificationStatus = false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function register()
    {
        // first verify if mobile otp is verified
        if ($this->form->validate()) {
            $registerUser =  $this->form->register();

            if ($registerUser) {
                if (!empty(trim($this->form->institute_code))) {
                    $this->js('success("Registeration succesfully goes to institute, please contact for activation.")');
                    $this->form->reset();
                    return $this->redirect('/', navigate: true);
                }
                $this->js('success("You are successfully registered, please login to continue.")');
                $this->form->reset();
                return $this->redirect(route('login'), navigate: true);
            } else {
                $this->js('error("Server issue, please try again later.")');
            }
        } else {
            $this->js('error("Details not verified.")');
        }
    }
}
