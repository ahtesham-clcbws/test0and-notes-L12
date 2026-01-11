<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\FranchiseDetails;
use App\Models\CorporateEnquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyAdminInstituteSignup;

class CorporateSignupPage extends Component
{
    public $school_code;
    public $mobile_no;
    public $verify_email;
    public $password;
    public $confirm_password;

    public $validSchoolCode = false;
    public $validMobileNo = false;
    public $validVerifyEmail = false;
    public $validPassword = false;
    public $validConfirmPassword = false;

    public function updatedSchoolCode($value)
    {
        $this->validSchoolCode = false;
        $this->validMobileNo = false;
        $this->validVerifyEmail = false;

        if (!empty($value)) {
            $exists = CorporateEnquiry::where('branch_code', $value)
                ->where('status', 'approved')
                ->exists();

            if ($exists) {
                $this->validSchoolCode = true;
            }
        }
    }

    public function updatedMobileNo($value)
    {
        $this->validMobileNo = false;
        $this->validVerifyEmail = false;

        if ($this->validSchoolCode && !empty($value)) {
            $exists = CorporateEnquiry::where('branch_code', $this->school_code)
                ->where('mobile', $value)
                ->where('status', 'approved')
                ->exists();

            if ($exists) {
                $this->validMobileNo = true;
            }
        }
    }

    public function updatedVerifyEmail($value)
    {
        $this->validVerifyEmail = false;

        if ($this->validSchoolCode && $this->validMobileNo && !empty($value)) {
            $exists = CorporateEnquiry::where('branch_code', $this->school_code)
                ->where('mobile', $this->mobile_no)
                ->where('email', $value)
                ->where('status', 'approved')
                ->exists();

            if ($exists) {
                $this->validVerifyEmail = true;
            }
        }
    }

    public function updatedPassword($value)
    {
        $this->validPassword = (strlen($value) >= 5);
        $this->updatedConfirmPassword($this->confirm_password);
    }

    public function updatedConfirmPassword($value)
    {
        $this->validConfirmPassword = (strlen($value) >= 5 && $value === $this->password);
    }

    public function register()
    {
        $this->validate([
            'school_code' => 'required',
            'mobile_no' => 'required',
            'verify_email' => 'required|email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password|min:5',
        ]);

        if (!$this->validSchoolCode || !$this->validMobileNo || !$this->validVerifyEmail) {
             $this->addError('school_code', 'Please ensure all fields are valid and matched with an approved corporate enquiry.');
             return;
        }

        $branch_code = $this->school_code;
        $branch_mobile = $this->mobile_no;
        $branch_email = $this->verify_email;
        $password = $this->password;

        $enquiry = CorporateEnquiry::where('branch_code', $branch_code)
            ->where('email', $branch_email)
            ->where('mobile', $branch_mobile)
            ->first();

        if (!$enquiry) {
            $this->addError('school_code', 'Enquiry not found matching these details.');
            return;
        }

        $userDb = new User();
        $roles = json_encode(["franchise", "franchise_creator", "franchise_publisher", "franchise_manager"]);

        $userDb->name = $enquiry->name;
        $userDb->username = $branch_email;
        $userDb->roles = $roles;
        $userDb->is_franchise = 1;
        $userDb->email = filter_var($branch_email, FILTER_VALIDATE_EMAIL);
        $userDb->mobile = filter_var($branch_mobile, FILTER_SANITIZE_NUMBER_INT);
        $userDb->password = Hash::make($password);

        if ($userDb->save()) {
            $userDetailsDb = new FranchiseDetails();
            $userDetailsDb->user_id = $userDb->id;
            $userDetailsDb->branch_code = $enquiry->branch_code;
            $userDetailsDb->institute_name = $enquiry->institute_name;
            $userDetailsDb->interested_for = $enquiry->interested_for;
            $userDetailsDb->established_year = $enquiry->established_year;
            $userDetailsDb->address = $enquiry->address;
            $userDetailsDb->city_id = $enquiry->city_id;
            $userDetailsDb->state_id = $enquiry->state_id;
            $userDetailsDb->pincode = $enquiry->pincode;
            $userDetailsDb->enquiry_id = $enquiry->id;
            $userDetailsDb->type_of_institution = $enquiry->type_of_institution;
            $userDetailsDb->save();

            $enquiry->status = 'converted';
            $enquiry->save();

            // Send email logic
            try {
                $admin_datails = [
                    'fullname' => $enquiry->name,
                    'email_id' => $branch_email,
                    'institute_code' => $enquiry->branch_code
                ];

                $super_admins = User::where('roles', 'superadmin')
                    ->where('status', 'active')
                    ->whereNull('deleted_at')
                    ->get(['email'])
                    ->pluck('email')
                    ->toArray();

                if (!empty($super_admins)) {
                     try {
                        $superAdminMailToSend = new NotifyAdminInstituteSignup($admin_datails);
                        Mail::to($super_admins)->send($superAdminMailToSend);
                        Log::info('Institute signup email sent to: ' . implode(', ', $super_admins));

                     } catch (\Exception $e) {
                         Log::error('Failed to send institute signup email: ' . $e->getMessage());
                     }
                }

            } catch (\Throwable $th) {
                Log::error('Problem in email sending or logic: ' . $th->getMessage());
            }

            CorporateEnquiry::generateCounts();
            User::generateCounts();

            $this->dispatch('registration-success');
        } else {
            $this->addError('school_code', 'Failed to create user account. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.corporate-signup-page');
    }
}
