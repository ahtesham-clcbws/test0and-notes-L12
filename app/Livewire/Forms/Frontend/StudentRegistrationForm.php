<?php

namespace App\Livewire\Forms\Frontend;

use App\Mail\NotifyAdminStudentSignup;
use App\Mail\NotifyFranchiseStudentSignup;
use App\Mail\sendFranchiseEmail;
use App\Models\FranchiseDetails;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Form;
use Illuminate\Support\Facades\Mail;

class StudentRegistrationForm extends Form
{
    public $full_name;
    public $email;
    public $mobile_number;
    public $mobile_otp;
    public $password;
    public $confirm_password;
    public $institute_code;
    public $education_type_id;
    public $class_group_exam_id;
    public $user_logo;
    public $required_check_registration;

    public function rules()
    {
        return [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile_number' => 'required|digits:10|unique:users,mobile',
            'mobile_otp' => [
                'required',
                'digits:6',
                \Illuminate\Validation\Rule::exists('otp_verifications', 'otp')->where(function ($query) {
                    return $query->where('credential', $this->mobile_number);
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
            'education_type_id' => 'required',
            'class_group_exam_id' => 'required',
            'user_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:200',
            // 'user_logo' => 'required|file|mimes:jpeg,png,jpg|max:200',
            'required_check_registration' => 'required|accepted',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full Name is required.',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile_number.required' => 'Mobile Number is required.',
            'mobile_number.digits' => 'Mobile Number must be 10 digits.',
            'mobile_number.unique' => 'This mobile number is already registered.',
            'mobile_otp.required' => 'OTP is required.',
            'mobile_otp.digits' => 'OTP must be 6 digits.',
            'mobile_otp.exists' => 'Invalid OTP or OTP does not match the mobile number.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'confirm_password.required' => 'Confirm Password is required.',
            'confirm_password.min' => 'Confirm Password must be at least 8 characters.',
            'confirm_password.same' => 'Password and Confirm Password must match.',
            'institute_code.required' => 'Institute Code is required.',
            'institute_code.exists' => 'Invalid Institute Code or Institute is not active.',
            'education_type_id.required' => 'Please select an Education Type.',
            'class_group_exam_id.required' => 'Please select a Class/Group/Exam.',
            // 'user_logo.required' => 'Profile Image is required.',
            'user_logo.mimes' => 'Profile Image must be a file of type: jpeg, png, jpg.',
            'user_logo.max' => 'Profile Image must not be greater than 200 kilobytes.',
            'required_check_registration.accepted' => 'You must agree to the Terms of Services.',
            'required_check_registration.required' => 'You must agree to the Terms of Services.',
        ];
    }

    public function register()
    {
        try {
            $user = new User();

            $user->name =  htmlspecialchars($this->full_name);
            $user->roles =  'student';
            if (empty(trim($this->institute_code))) {
                $user->status =  'active';
            } else {
                $user->in_franchise =  '1';
                $user->franchise_code =  filter_var($this->institute_code);
            }
            $user->email =  filter_var($this->email, FILTER_VALIDATE_EMAIL) ? $this->email : null;
            $user->mobile =  filter_var($this->mobile_number, FILTER_SANITIZE_NUMBER_INT);
            $user->password =  Hash::make($this->password);
            $mail_flag = 0;
            // return json_encode($user);
            // $query = $user->save();
            if ($user->save()) {
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path('logs/custom.log'),
                ])->info('from student signup -form_name registration_form user saved ' . $this->email . ' ' . $this->full_name . ' ' . $this->institute_code);

                if ($this->email) {
                    $details = [
                        'fullname' => $this->full_name,
                        'typeMessage' => 'Account updated.',
                        'message' => 'You are succesfully registered.'
                    ];

                    try {
                        //code to send institute student signup notification email
                        if ($this->institute_code != '') {
                            $inst = FranchiseDetails::where('branch_code', $this->institute_code)->get()->first();
                            $inst_email = User::where('id', $inst->user_id)->get(['email'])->first();
                            Log::build([
                                'driver' => 'single',
                                'path' => storage_path('logs/custom.log'),
                            ])->info('Institute email fro student signup ' . $this->institute_code . ' ' . $inst);
                            Log::build([
                                'driver' => 'single',
                                'path' => storage_path('logs/custom.log'),
                            ])->info('Institute email fro student signup ' . $this->institute_code . ' ' . $inst_email);
                            $inst_details = [
                                'inst_name' => $inst->institute_name,
                                'email_id' => $this->email,
                                'institute_code' => $this->institute_code,
                                'fullname' => $this->full_name
                            ];
                            $instMailToSend = new NotifyFranchiseStudentSignup($inst_details);
                            $sendMail = Mail::to($inst_email->email)->send($instMailToSend);
                            Log::build([
                                'driver' => 'single',
                                'path' => storage_path('logs/custom.log'),
                            ])->info('Institute email to ' . $inst_email->email . ' for student ' . $this->email . ' signup' . ' ' . count(Mail::failures()));
                        }
                        //code to send superadmin student signup notification email
                        $admin_details = [
                            'fullname' => $this->full_name,
                            'email_id' => $this->email,
                            'institute_code' => $this->institute_code
                        ];

                        $super_admins = User::where('roles', 'superadmin')->where('status', 'active')->where('deleted_at', null)->get(['email'])->toArray();
                        $emails = [];
                        foreach ($super_admins as $super_admin) {
                            array_push($emails, $super_admin['email']);
                        }
                        $superAdminMailToSend = new NotifyAdminStudentSignup($admin_details);
                        $sendAdminMail = Mail::to($emails)->send($superAdminMailToSend);
                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('student signup super admin ' . implode(" ", $emails) . ' ' . count(Mail::failures()));

                        $mailToSend = new sendFranchiseEmail($details);
                        $sendMail = Mail::to($this->email)->send($mailToSend);
                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('student signup -student ' . $this->email . ' ' . count(Mail::failures()));
                    } catch (\Throwable $th) {

                        $mail_flag = 1;
                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('problem in email sending' . $th);
                    }
                }

                $userDetailsDb = new UserDetails();
                $userDetailsDb->user_id =  $user->id;
                if ($this->institute_code) {
                    $userDetailsDb->institute_code =  filter_var($this->institute_code);
                }
                if ($this->user_logo) {
                    $userDetailsDb->photo_url = $this->user_logo->store('student_uploads/' . $user->id, 'public');
                }

                $userDetailsDb->days = '7';
                $userDetailsDb->education_type =  filter_var($this->education_type_id, FILTER_SANITIZE_NUMBER_INT);
                $userDetailsDb->class =  filter_var($this->class_group_exam_id, FILTER_SANITIZE_NUMBER_INT);
                $userDetailsDb->save();
                // send email here
                User::generateCounts();
            }

            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
