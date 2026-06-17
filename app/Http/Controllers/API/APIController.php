<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\NotifyAdminStudentSignup;
use App\Mail\OTPMail;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry;
use App\Models\FranchiseDetails;
use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackageTransaction;
use App\Models\OtpVerifications;
use App\Models\QuestionBankModel;
use App\Models\Studymaterial;
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestModal;
use App\Models\User;
use App\Models\UserDetails;
use App\Services\Msg91Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

class APIController extends Controller
{
    public array $returnResponse;

    public function __construct()
    {
        $this->returnResponse = ['success' => false, 'type' => 'server', 'message' => 'Server error, please try after some time.'];
    }

    // function for student login
    public function studentLogin(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $identifier = trim($data['mobile'] ?? '');

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $identifier = strtolower($identifier);
            $user = User::query()
                ->whereRaw('LOWER(TRIM(email)) = ?', [$identifier])
                ->where('status', 'active')
                ->where('roles', 'student')
                ->first();
        } else {
            $user = User::query()
                ->where('mobile', $identifier)
                ->where('status', 'active')
                ->where('roles', 'student')
                ->first();
        }

        if (! empty($user)) {
            if (Hash::check($data['password'], $user->password)) {

                if (isset($data['fcm_token'])) {
                    $user->exists = true;
                    $user->id = $user->id; // already exists in database.

                    $user->fcm_token = $data['fcm_token'];
                    $user->save();
                }

                $success['token'] = $user->createToken('authToken')->plainTextToken;
                $user['institute_name'] = $user->myInstitute?->institute_name;
                $success['user_details'] = $user;

                // return $this->BaseController->sendResponse($success);
                return response()->json(['status' => 1, 'data' => $success]);
            } else {
                // return $this->BaseController->sendError('Unauthorised.', ['error'=>'username or password invalid!']);
                return response()->json(['status' => 0, 'message' => 'Wrong password']);
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'No user found']);
        }
    }

    // function to logout student
    public function logout(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['status' => 1, 'message' => 'Logout Successfully!']);
    }

    public function userDetails(Request $request)
    {
        $user = Auth::user();

        return response()->json(['status' => 1, 'user_details' => $user]);
    }

    public function instituteTest(Request $request)
    {
        $user = Auth::user();
        $myInstitute = $user ? $user->myInstitute : null;
        $testTableData = $myInstitute ? $myInstitute->test()->get() : collect([]);
        foreach ($testTableData as $key => $testData) {
            $section_time = $testData->getSection()->select('number_of_questions', 'duration')->get()->toArray();
            $time = [];
            foreach ($section_time as $k => $section) {
                $time[$k] = $section['number_of_questions'] * $section['duration'];
            }
            // return $testData;

            $total_questions = $testData['total_questions'];
            $testTableData[$key]['test_duration'] = array_sum($time);
            $testTableData[$key]['total_questions'] = $testData['total_questions'];
            $testTableData[$key]['total_questions_display'] = $testData['total_questions'].' / '.$testData->getQuestions()->wherePivot('deleted_at', '=', null)->count();
            $testTableData[$key]['created_by'] = $user ? $user->name : 'Admin';
            $testTableData[$key]['created_date'] = date('d-m-Y', strtotime($testData->created_at));
            // $testTableData[$key]['class_name'] = $testData->EducationClass->name;
            $testTableData[$key]['class_name'] = $testData['title'];
        }

        return response()->json(['status' => 1, 'test_list' => $testTableData]);
    }

    // Test and Notes test
    public function testAndNotesTest(Request $request)
    {
        $testTableData = TestModal::where('user_id', null)->get();
        // return $testTableData;
        foreach ($testTableData as $key => $testData) {
            $section_time = $testData->getSection()->select('number_of_questions', 'duration')->get()->toArray();
            $time = [];
            foreach ($section_time as $k => $section) {
                $time[$k] = $section['number_of_questions'] * $section['duration'];
            }

            $total_questions = $testData['total_questions'];
            $testTableData[$key]['test_duration'] = array_sum($time);
            $testTableData[$key]['total_questions'] = $testData['total_questions'];
            $testTableData[$key]['total_questions_display'] = $testData['total_questions'].' / '.$testData->getQuestions()->wherePivot('deleted_at', '=', null)->count();
            $testTableData[$key]['created_by'] = Auth::user() ? Auth::user()->name : 'Admin';
            $testTableData[$key]['created_date'] = date('d-m-Y', strtotime($testData->created_at));
            $testTableData[$key]['class_name'] = $testData['title'];
        }

        return response()->json(['status' => 1, 'test_list' => $testTableData]);
    }

    public function attempttedTest(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        if ($request->test_id) {
            $testTableData = $user->testAttempt()->where('test_id', $request->test_id)->orderBy('id', 'desc')->get();
            $count = $user->testAttempt()->where('test_id', $request->test_id)->count();
        } else {
            $testTableData = $user->testAttempt()->orderBy('id', 'desc')->get();
            $count = $user->testAttempt()->count();
        }

        $ret_data = [];
        foreach ($testTableData as $key => $testData) {
            $r['id'] = $testData->id;
            $r['student_id'] = $testData->student_id;
            $r['test_id'] = $testData->test_id;
            $r['test_attempt'] = $testData->test_attempt;
            $r['title'] = $testData->test->title;
            $r['class_name'] = $testData->test->EducationClass->name;
            $r['test_date'] = date('d-m-Y', strtotime($testData->created_at));
            $r['test_category'] = $testData->test->user_id != null ? 'Institude' : 'Test and Notes';
            $r['total_marks'] = $testData->test->gn_marks_per_questions * $testData->test->total_questions;
            $r['test_sections'] = $testData->test->sections;
            $r['total_question'] = $testData->test->total_questions;
            // test duration
            $section_time = $testData->test->getSection()->get();
            $time = [];
            $sections = [];
            foreach ($section_time as $k => $section) {
                $time[$k] = $section['number_of_questions'] * $section['duration'];
                $sections[$k] = $section;
                $sections[$k]['name'] = $section->sectionSubject->name;
                $sections[$k]['questions'] = $section->getQuestions()->wherePivot('deleted_at', '=', null)->get();
            }
            $r['test_duration'] = array_sum($time);
            // right, wrong counts
            if ($testData->test->show_result == 1) {
                $r['result_status'] = 1;
                $test_response = TestAttemptAnswer::where('student_id', $testTableData[$key]['student_id'])->where('test_id', $testTableData[$key]['test_id'])->orderBy('question_id', 'asc')->get();
                $questions = QuestionBankModel::whereIn('id', $test_response->pluck('question_id')->toArray())->orderBy('id', 'asc')->get();
                $correct_answer = 0;
                $incorrect_answer = 0;
                $not_attempted = 0;

                // $answer['correct_answer']     = collect([]);
                // $answer['incorrect_answer']   = collect([]);
                // $answer['not_attempted']      = collect([]);

                // foreach($questions as $k => $question) {
                //     if ($question->id == $test_response[$k]->question_id) {
                //         if ($test_response[$k]->answer == null) {
                //             $not_attempted+=1;
                //             $answer['not_attempted']->push($test_response[$k]);
                //         }
                //         if($question->mcq_answer == $test_response[$k]->answer){
                //             $correct_answer+=1;
                //             $answer['correct_answer']->push($test_response[$k]);
                //         }
                //         if($question->mcq_answer != $test_response[$k]->answer && $test_response[$k]->answer != null){
                //             $incorrect_answer+=1;
                //             $answer['incorrect_answer']->push($test_response[$k]);
                //         }
                //     }
                // }
                foreach ($sections as $k => $section) {
                    $sec_not_attemp = 0;
                    $sec_correct = 0;
                    $sec_incorrect = 0;
                    foreach ($section->questions as $j => $question) {
                        foreach ($test_response as $test_resp) {
                            if ($test_resp->question_id == $question->id) {
                                if ($test_resp->answer == null) {
                                    $sections[$k]['questions'][$j]['result'] = -1;
                                    $sec_not_attemp += 1;
                                }
                                if ($question->mcq_answer == $test_resp->answer) {
                                    $sections[$k]['questions'][$j]['result'] = 1;
                                    $sec_correct += 1;
                                }
                                if ($question->mcq_answer != $test_resp->answer && $test_resp->answer != null) {
                                    $sections[$k]['questions'][$j]['result'] = 0;
                                    $sec_incorrect += 1;
                                }
                                $sections[$k]['questions'][$j]['response'] = $test_resp->answer;
                            }
                        }
                    }
                    $sections[$k]['not_attempted'] = $sec_not_attemp;
                    $sections[$k]['correct_answer'] = $sec_correct;
                    $sections[$k]['incorrect_answer'] = $sec_incorrect;
                    $sections[$k]['wrong_ans_marks'] = $sec_incorrect * $testData->test->negative_marks * $testData->test->gn_marks_per_questions;
                    $sections[$k]['right_ans_marks'] = $sec_correct * $testData->test->gn_marks_per_questions;
                    $sections[$k]['obtained'] = $sections[$k]['right_ans_marks'] - $sections[$k]['wrong_ans_marks'];
                    $not_attempted += $sec_not_attemp;
                    $correct_answer += $sec_correct;
                    $incorrect_answer += $sec_incorrect;
                }
                $r['not_attempted'] = $not_attempted;
                $r['wrong_ans_marks'] = $incorrect_answer * $testData->test->negative_marks * $testData->test->gn_marks_per_questions;
                $r['right_ans_marks'] = $correct_answer * $testData->test->gn_marks_per_questions;
                $r['obtained_marks'] = $r['right_ans_marks'] - $r['wrong_ans_marks'];
                $r['correct_answer'] = $correct_answer;
                $r['incorrect_answer'] = $incorrect_answer;
                //  $r['answer']           = $answer;
                // $r['test_resonse'] = $test_response;

            } else {
                $r['result_status'] = 0;
            }
            $r['sections'] = $sections;

            array_push($ret_data, $r);
        }

        return response()->json(['status' => 1, 'test_list' => $ret_data, 'count' => $count]);
    }

    public function startTestAndNotesTest(Request $request)
    {
        // return $request->test_id;
        $test = TestModal::find($request->test_id);
        if (empty($test)) {
            return response()->json(['status' => 0, 'msg' => 'No test found!!!', 'test' => $test, 'id' => $request->test_id]);
        }

        // $data['test_start'] = $test;
        // $this->data['questions']  = $test->getQuestions()->wherePivot('deleted_at','=',NULL);
        //  $data['questions']  = $test->getQuestions()->wherePivot('deleted_at', '=', NULL)->get()->groupBy('pivot.section_id');
        $section_time = $test->getSection()->get();
        $time = [];
        $sections = [];
        foreach ($section_time as $key => $section) {
            $time[$key] = $section['number_of_questions'] * $section['duration'];
            $sections[$key]['name'] = $section->sectionSubject->name;
            $sections[$key]['questions'] = $section->getQuestions()->wherePivot('deleted_at', '=', null)->get();
        }
        $test['sections_details'] = $sections;
        $test['test_duration'] = array_sum($time);
        $test['total_marks'] = $test->gn_marks_per_questions * $test->total_questions;
        $data['test'] = $test;

        return response()->json(['status' => 1, 'test_details' => $test]);
    }

    public function getStudyMaterialDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:study_material,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $material = Studymaterial::query()
                ->where('id', $request->id)
                ->first();

            return response()->json([
                'status' => 1,
                'data' => $material,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function endTest(Request $request)
    {
        $test = TestModal::find($request->test_id);
        if (empty($test)) {
            return response()->json(['status' => 0, 'msg' => 'No test found']);
        }

        // 1. Get the active attempt
        $attempt = TestAttempt::where('student_id', Auth::id())
            ->where('test_id', $request->test_id)
            ->where('status', 'running')
            ->latest()
            ->first();

        if (! $attempt) {
            // Fallback for edge cases where attempt wasn't initialized
            $attempt = TestAttempt::create([
                'student_id' => Auth::id(),
                'test_id' => $request->test_id,
                'test_attempt' => 1,
                'status' => 'running',
            ]);
        }

        // 2. Process any final answers sent in the request (if any)
        if ($request->has('attemted_questions')) {
            foreach ($request->attemted_questions as $value) {
                if ($value['answer'] == '') {
                    TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                        ->where('question_id', $value['question_id'])
                        ->delete();
                } else {
                    $ans = $value['answer'];
                    if (is_numeric($ans)) {
                        $ans = 'ans_'.$ans;
                    }
                    TestAttemptAnswer::updateOrCreate(
                        ['test_attempt_id' => $attempt->id, 'question_id' => $value['question_id']],
                        ['answer' => $ans]
                    );
                }
            }
        }

        // 3. Update status to completed
        $attempt->update([
            'status' => 'completed',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Test submitted successfully',
            'test_attempt_id' => $attempt->id,
        ]);
    }

    public function studentSignup(Request $request)
    {
        // Verify OTP if provided
        if ($request->has('otp')) {
            if (! verifyOtp($request->otp, $request->input('mobile_number'))) {
                return response()->json(['status' => 0, 'message' => 'Invalid or expired OTP']);
            }
        }

        // return json_encode($request->all());
        $userDb = new User;

        $userDb->name = htmlspecialchars($request->input('full_name'));
        $userDb->username = htmlspecialchars($request->input('my_username'));
        $userDb->roles = 'student';
        if ($request->input('institute_code') == '') {
            $userDb->status = 'active';
        } else {
            $userDb->in_franchise = '1';
            $userDb->franchise_code = filter_var($request->input('institute_code'));
        }
        $userDb->email = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? $request->input('email') : null;
        // $userDb->mobile =  filter_var($request->input('mobile_number'), FILTER_SANITIZE_NUMBER_INT);
        $userDb->mobile = $request->input('mobile_number');
        $userDb->password = Hash::make($request->input('password'));
        $mail_flag = 0;
        // return json_encode($userDb);
        // $query = $userDb->save();
        if ($userDb->save()) {

            // Create UserDetails
            $userDetailsDb = new UserDetails;
            $userDetailsDb->user_id = $userDb->id;

            if ($request->hasfile('photo_url')) {
                $file = $request->file('photo_url');
                $name = $file->hashName();
                $image_name = $request->file('photo_url')->storeAs('student_uploads/'.$userDb->id, $name, 'public');
                $userDetailsDb->photo_url = $name;
            }

            if ($request->input('institute_code')) {
                $userDetailsDb->institute_code = filter_var($request->input('institute_code'));
            }

            // Academic & Location Info
            $userDetailsDb->education_type = filter_var($request->input('education_type_id'), FILTER_SANITIZE_NUMBER_INT);
            $userDetailsDb->class = filter_var($request->input('class_group_exam_id'), FILTER_SANITIZE_NUMBER_INT);
            $userDetailsDb->state = filter_var($request->input('state_id'), FILTER_SANITIZE_NUMBER_INT);
            $userDetailsDb->city = filter_var($request->input('city_id'), FILTER_SANITIZE_NUMBER_INT);
            $userDetailsDb->days = '7';

            $userDetailsDb->save();

            if ($request->input('email')) {
                $details = [
                    'fullname' => $request->input('full_name'),
                    'typeMessage' => 'Account updated.',
                    'message' => 'You are succesfully registered.',
                ];

                try {
                    if ($request->input('institute_code') != '') {
                        $inst = FranchiseDetails::where('branch_code', $request->input('institute_code'))->get()->first();
                        $inst_email = User::where('id', $inst->id)->get(['email'])->first();
                        $inst_details = [
                            'inst_name' => $inst->institute_name,
                            'email_id' => $request->input('email'),
                            'institute_code' => $request->input('institute_code'),
                            'fullname' => $request->input('full_name'),
                        ];
                        $instMailToSend = new NotifyAdminStudentSignup($inst_details);
                        $sendMail = Mail::to($inst_email->email)->send($instMailToSend);
                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('Institute email to '.$inst_email->email.' for student '.$request->input('email'));
                    }

                    $admin_datails = [
                        'fullname' => $request->input('full_name'),
                        'email_id' => $request->input('email'),
                        'institute_code' => $request->input('institute_code'),
                    ];

                    $super_admins = User::where('roles', 'superadmin')->where('status', 'active')->where('deleted_at', null)->get(['email'])->toArray();
                    $emails = [];
                    foreach ($super_admins as $super_admin) {
                        array_push($emails, $super_admin['email']);
                    }
                    $superAdminMailToSend = new NotifyAdminStudentSignup($admin_datails);
                    $sendAdminMail = Mail::to($emails)->send($superAdminMailToSend);
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/custom.log'),
                    ])->info(json_encode($emails));

                    $mailToSend = new sendFranchiseEmail($details);
                    $sendMail = Mail::to($request->input('email'))->send($mailToSend);
                } catch (\Throwable $th) {
                    $mail_flag = 1;
                }
            }

            // generate counts
            User::generateCounts();
            // generate counts
            User::generateCounts();

            // Auto-login after signup for mobile
            $token = $userDb->createToken('authToken')->plainTextToken;
            $userDb['institute_name'] = $userDb->myInstitute ? $userDb->myInstitute->institute_name : null;

            return response()->json([
                'status' => 1,
                'message' => 'Registration successful',
                'data' => [
                    'token' => $token,
                    'user_details' => $userDb,
                ],
            ]);
        }

        return response()->json(['status' => 0, 'message' => 'Registration failed']);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required', // mobile or email
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => 'Identifier is required']);
        }

        $user = User::where('mobile', $request->identifier)
            ->orWhere('email', $request->identifier)
            ->first();

        if (! $user) {
            return response()->json(['status' => 0, 'message' => 'User not found']);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store in otp_verifications table
        OtpVerifications::updateOrCreate(
            ['credential' => $user->mobile],
            [
                'type' => 'mobile',
                'otp' => $otp,
                'status' => 'pending',
                'created_at' => now(),
            ]
        );

        // Send OTP via Email if available
        if ($user->email) {
            try {
                Mail::to($user->email)->send(new OTPMail($otp));
            } catch (\Exception $e) {
                Log::error('Error sending OTP email: '.$e->getMessage());
            }
        }

        // Send SMS OTP via MSG91
        if ($user->mobile && config('app.live_mobile_otp')) {
            try {
                app(Msg91Service::class)->sendSms($user->mobile, $otp);
            } catch (\Exception $e) {
                Log::error('Error sending ForgotPassword OTP SMS: '.$e->getMessage());
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'OTP sent successfully',
            'otp' => $otp, // Comment out in production
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $user = User::where('mobile', $request->mobile)->first();
        if (! $user) {
            return response()->json(['status' => 0, 'message' => 'User not found']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clear OTP
        DB::table('otp_verifications')->where('mobile', $request->mobile)->delete();

        return response()->json(['status' => 1, 'message' => 'Password reset successful']);
    }

    public function verifyMobile(Request $request)
    {
        $mobileNumber = $request->input('mobile');
        // check for unique
        $query = User::where('mobile', $mobileNumber)->first();
        $query2 = CorporateEnquiry::where('mobile', $mobileNumber)->first();
        if ($query || $query2) {
            $returnResponse['success'] = false;
            $returnResponse['message'] = 'Mobile number already used. Please try with other number';

            return json_encode($returnResponse);
        } else {
            $returnResponse['success'] = true;

            // $returnResponse['message'] = 'Mobile number already used. Please try with other number';
            return json_encode($returnResponse);
        }
    }

    public function getOTP(Request $request)
    {
        $returnResponse = $this->returnResponse;
        $mobileNumber = $request->input('mobile');
        // check for unique
        $query = User::where('mobile', $mobileNumber)->first();
        $query2 = CorporateEnquiry::where('mobile', $mobileNumber)->first();
        if ($query || $query2) {
            $returnResponse['success'] = false;
            $returnResponse['message'] = 'Mobile number already used. Please try with other number';

            return json_encode($returnResponse);
        }
        // check for already sent or not
        $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $mobileNumber], ['created_at', '>', $time]])->first();

        // send once in only 10 minutes
        if ($otpData) {
            $returnResponse['success'] = false;
            $returnResponse['message'] = 'You already request an OTP in last 10 minutes. please wait for another attempt.';

            return json_encode($returnResponse);
        }

        $otp = mt_rand(100000, 999999);

        $otpVerifications = new OtpVerifications;
        $otpVerifications->type = 'mobile'; // Default type for this endpoint
        $otpVerifications->credential = $mobileNumber;
        $otpVerifications->otp = $otp;
        $otpVerifications->status = 'pending';
        $saveToDb = $otpVerifications->save();

        if ($saveToDb) {
            // If the user already exists, try to send to their email as well
            $user = User::where('mobile', $mobileNumber)->first();
            if ($user && $user->email) {
                try {
                    Mail::to($user->email)->send(new OTPMail($otp));
                } catch (\Exception $e) {
                    Log::error('Error sending OTP email in getOTP: '.$e->getMessage());
                }
            }

            // Send SMS OTP via MSG91
            if ($mobileNumber && config('app.live_mobile_otp')) {
                try {
                    app(Msg91Service::class)->sendSms($mobileNumber, $otp);
                } catch (\Exception $e) {
                    Log::error('Error sending Signup OTP SMS: '.$e->getMessage());
                }
            }

            $returnResponse['success'] = true;
            $returnResponse['otp'] = $otp; // Added for development/testing as requested in other methods
        }

        return json_encode($returnResponse);
        // }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['status' => 0, 'message' => 'Unauthorised']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'mobile' => 'sometimes|unique:users,mobile,'.$user->id,
            'education_type' => 'sometimes',
            'class' => 'sometimes',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            DB::beginTransaction();

            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('mobile')) {
                $user->mobile = $request->mobile;
            }
            $user->save();

            $userDetails = UserDetails::firstOrNew(['user_id' => $user->id]);

            if ($request->has('education_type')) {
                $userDetails->education_type = $request->education_type;
            }
            if ($request->has('class')) {
                $userDetails->class = $request->class;
            }

            if ($request->hasFile('photo_url')) {
                $file = $request->file('photo_url');
                $name = $file->hashName();
                $file->storeAs('student_uploads/'.$user->id, $name, 'public');
                $userDetails->photo_url = $name;
            }

            $userDetails->save();

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully',
                'user' => $user->load('user_details'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function verifyOTP(Request $request)
    {
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');

        if (verifyOtp($otp, $mobile)) {
            return response()->json(['status' => 1, 'message' => 'OTP verified successfully']);
        }

        return response()->json(['status' => 0, 'message' => 'Invalid or expired OTP']);
    }

    public function sendProfileMobileOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $mobileNumber = $request->input('mobile');
        $userId = Auth::id();

        if (! \App\Helpers\ProfileValidationHelper::isMobileUnique($mobileNumber, $userId)) {
            return response()->json([
                'status' => 0,
                'message' => 'Mobile number already used. Please try with another number.',
            ]);
        }

        $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $mobileNumber], ['created_at', '>', $time]])->first();

        if ($otpData) {
            return response()->json([
                'status' => 0,
                'message' => 'You already requested an OTP in the last 10 minutes. Please wait.',
            ]);
        }

        $otp = mt_rand(100000, 999999);
        $otpVerifications = new OtpVerifications;
        $otpVerifications->type = 'mobile';
        $otpVerifications->credential = $mobileNumber;
        $otpVerifications->otp = $otp;
        $otpVerifications->status = 'pending';
        $otpVerifications->save();

        try {
            app(\App\Services\Msg91Service::class)->sendSms($mobileNumber, $otp);
        } catch (\Exception $e) {
            Log::error('Error sending Profile Update mobile OTP SMS: '.$e->getMessage());
        }

        return response()->json([
            'status' => 1,
            'message' => 'OTP sent successfully to '.$mobileNumber,
            'otp' => $otp, // for dev/testing
        ]);
    }

    public function verifyProfileMobileOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $mobile = $request->input('mobile');
        $otp = $request->input('otp');

        if (verifyOtp($otp, $mobile)) {
            $user = User::find(Auth::id());
            $user->mobile = $mobile;
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'Mobile number updated successfully',
                'user' => $user->load('user_details'),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalid or expired OTP',
        ]);
    }

    public function sendProfileEmailOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $email = $request->input('email');
        $userId = Auth::id();

        if (! \App\Helpers\ProfileValidationHelper::isEmailUnique($email, $userId)) {
            return response()->json([
                'status' => 0,
                'message' => 'Email address already used. Please try with another email.',
            ]);
        }

        $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'email'], ['credential', '=', $email], ['created_at', '>', $time]])->first();

        if ($otpData) {
            return response()->json([
                'status' => 0,
                'message' => 'You already requested an OTP in the last 10 minutes. Please wait.',
            ]);
        }

        $otp = mt_rand(100000, 999999);
        $otpVerifications = new OtpVerifications;
        $otpVerifications->type = 'email';
        $otpVerifications->credential = $email;
        $otpVerifications->otp = $otp;
        $otpVerifications->status = 'pending';
        $otpVerifications->save();

        try {
            Mail::raw('Your OTP for updating email on Test and Notes is: '.$otp, function ($message) use ($email) {
                $message->to($email)->subject('Email Verification OTP');
            });
        } catch (\Exception $e) {
            Log::error('Error sending Profile Update email OTP: '.$e->getMessage());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to send OTP to email. Please try again.',
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'OTP sent successfully to '.$email,
            'otp' => $otp, // for dev/testing
        ]);
    }

    public function verifyProfileEmailOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $email = $request->input('email');
        $otp = $request->input('otp');

        $time = date('Y-m-d H:i:s', strtotime('-11 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'email'], ['credential', '=', $email], ['otp', '=', $otp], ['created_at', '>', $time]])->first();

        if ($otpData) {
            $user = User::find(Auth::id());
            $user->email = $email;
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'Email updated successfully',
                'user' => $user->load('user_details'),
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalid or expired OTP',
        ]);
    }

    public function verifyBranchCode(Request $request)
    {
        $branch_code = $request->input('branch_code');
        $time = date('Y-m-d');
        $time .= ' 00:00:00';
        $query = FranchiseDetails::where([['branch_code', '=', $branch_code], ['inactive_at', '>', $time]])->first();
        if ($query) {
            return json_encode(['status' => 1, 'msg' => $query['institute_name']]);
        }

        return json_encode(['status' => 0, 'msg' => 'Institute not found']);
    }

    public function uniqueEmailCheck(Request $request)
    {
        $email = $request->input('email');
        $query2 = false;
        $query = User::where('email', $email)->first();

        $query2 = CorporateEnquiry::where('email', $email)->first();

        if ($query || $query2) {
            $returnResponse['success'] = false;
            $returnResponse['message'] = 'Email already used. Please try with other Email ID';

            return json_encode($returnResponse);
        }
        $returnResponse['success'] = true;

        return json_encode($returnResponse);
    }

    public function geteducationtype(Request $request)
    {

        $education_type = DB::table('education_type')->get();

        return $education_type;
    }

    public function getclassbyeducation(Request $request)
    {

        $education_id = $request->input('education_id');
        $class = DB::table('classes_groups_exams')->where('education_type_id', $education_id)->get();

        return $class;
    }

    public function studymaterial(Request $request)
    {
        try {
            $user = Auth::user();
            $userDetails = $user ? UserDetails::where('user_id', $user->id)->first() : null;
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_id = $user ? ($user->myInstitute?->id ?? 0) : 0;

            $query = DB::table('study_material')
                ->select(
                    'study_material.id',
                    'title',
                    'sub_title',
                    'is_featured',
                    'institute_id',
                    'publish_status',
                    'publish_date',
                    'document_type',
                    'created_by',
                    'file',
                    'video_link',
                    'category',
                    'users.name as name',
                    'classes_groups_exams.name as class_group',
                    'study_material.created_at'
                )
                ->leftJoin('users', 'users.id', '=', 'study_material.created_by')
                ->leftJoin('classes_groups_exams', 'classes_groups_exams.id', '=', 'study_material.class')
                ->where('study_material.status', 1)
                ->where('study_material.material_seen', 1)
                ->whereIn('study_material.institute_id', [$institute_id, 0]);

            if ($request->category) {
                $query->where('study_material.category', $request->category);
            }

            if ($request->document_type) {
                $query->where('study_material.document_type', $request->document_type);
            }

            $materials = $query->orderByRaw('CASE WHEN study_material.education_type = ? AND study_material.class = ? THEN 0 ELSE 1 END', [$education_type, $class])
                ->latest('study_material.created_at')
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $materials,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to fetch resources: '.$e->getMessage(),
            ]);
        }
    }

    public function getHomepageData(Request $request)
    {
        try {
            $user = Auth::user();
            $userDetails = $user ? UserDetails::where('user_id', $user->id)->first() : null;
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_owner_id = $user?->myInstitute?->user_id ?? 0;

            // 1. Categories (Education Types)
            $categories = DB::table('education_type')
                ->get(['id', 'name']);

            // 2. Test Categories (For filters)
            $test_categories = DB::table('test_cat')
                ->get(['id', 'cat_name as name', 'cat_image as image']);

            // 3. Featured/Free Tests - Priority sorting
            $featured_tests = TestModal::with(['EducationClass', 'testSections'])
                ->where('published', 1)
                ->where(function ($q) use ($institute_owner_id) {
                    $q->whereIn('user_id', [$institute_owner_id, 1])
                        ->orWhereNull('user_id');
                })
                ->where('test_type', 0)
                ->orderByRaw('CASE WHEN education_type_id = ? AND education_type_child_id = ? THEN 0 ELSE 1 END', [$education_type, $class])
                ->latest()
                ->take(10)
                ->get();

            $featured_tests->each(function ($test) {
                $test->dynamic_duration = $test->testSections->sum(function ($section) {
                    return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
                });
                unset($test->testSections); // Clean up response
            });

            // 4. Slider Packages (is_mobile = 1, status = 1, matching student category/class)
            $slider_packages = Gn_PackagePlan::where('status', 1)
                ->where('is_mobile', 1)
                ->where('class', $class)
                ->latest()
                ->get();

            // 5. Banner Packages (is_mobile = 1, is_featured = 1, status = 1, matching student category/class)
            $banner_packages = Gn_PackagePlan::where('status', 1)
                ->where('is_mobile', 1)
                ->where('is_featured', 1)
                ->where('class', $class)
                ->latest()
                ->get();

            return response()->json([
                'status' => 1,
                'data' => [
                    'categories' => $categories,
                    'test_categories' => $test_categories,
                    'featured_tests' => $featured_tests,
                    'slider_packages' => $slider_packages,
                    'banner_packages' => $banner_packages,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error fetching homepage data: '.$e->getMessage(),
            ], 500);
        }
    }

    public function getPremiumData(Request $request)
    {
        try {
            $user = Auth::user();
            $userDetails = $user ? UserDetails::where('user_id', $user->id)->first() : null;
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_id = $user ? ($user->myInstitute?->id ?? 0) : 0;
            $institute_owner_id = $user ? ($user->myInstitute?->user_id ?? 0) : 0;

            $active_plans = Gn_PackageTransaction::where('student_id', Auth::id())
                ->where('plan_status', 1)
                ->where('plan_end_date', '>=', time())
                ->pluck('plan_id')
                ->toArray();

            // 1. Premium Packages
            $packages = Gn_PackagePlan::where('status', 1)
                ->where('final_fees', '>=', 0)
                ->where('education_type', $education_type)
                ->where('class', $class)
                ->whereNotIn('id', $active_plans)
                ->latest()
                ->get();

            // 2. Premium Study Materials
            $study_materials = Studymaterial::where('status', 1)
                ->where('material_seen', 1)
                ->where('education_type', $education_type)
                ->where('class', $class)
                ->whereIn('institute_id', [$institute_id, 0])
                ->latest()
                ->take(20)
                ->get();

            // 3. Premium Tests (linked to packages or just non-free ones)
            $premium_tests = TestModal::with(['EducationClass', 'testSections'])
                ->where('published', 1)
                ->where('education_type_id', $education_type)
                ->where('education_type_child_id', $class)
                ->where(function ($q) use ($institute_owner_id) {
                    $q->whereIn('user_id', [$institute_owner_id, 1])
                        ->orWhereNull('user_id');
                })
                ->where('test_type', 1)
                ->latest()
                ->take(20)
                ->get();

            $premium_tests->each(function ($test) {
                $test->dynamic_duration = $test->testSections->sum(function ($section) {
                    return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
                });
                unset($test->testSections); // Clean up response
            });

            return response()->json([
                'status' => 1,
                'data' => [
                    'packages' => $packages,
                    'study_materials' => $study_materials,
                    'premium_tests' => $premium_tests,
                    'razorpay_key' => env('RAZORPAY_KEY'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Error fetching premium data: '.$e->getMessage(),
            ], 500);
        }
    }

    public function createRazorpayOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:gn__package_plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        $package_plan = Gn_PackagePlan::find($request->plan_id);

        if ($package_plan->final_fees <= 0) {
            $already_active = Gn_PackageTransaction::where('student_id', Auth::id())
                ->where('plan_id', $package_plan->id)
                ->where('plan_status', 1)
                ->exists();

            if ($already_active) {
                return response()->json([
                    'status' => 1,
                    'is_free' => true,
                    'message' => 'Plan is already active.',
                ]);
            }

            $transaction_id = 'gyn-free-'.uniqid();
            $transaction = new Gn_PackageTransaction;
            $transaction->student_id = Auth::id();
            $transaction->plan_id = $package_plan->id;
            $transaction->plan_amount = 0;
            $transaction->plan_name = $package_plan->plan_name;
            $transaction->plan_duration = $package_plan->duration;
            $transaction->transaction_id = $transaction_id;
            $transaction->transaction_date = time();
            $transaction->plan_start_date = time();
            $transaction->plan_end_date = strtotime('+'.$package_plan->duration.' days');
            $transaction->plan_status = 1; // Active
            $transaction->save();

            return response()->json([
                'status' => 1,
                'is_free' => true,
                'message' => 'Free plan activated successfully!',
            ]);
        }

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $order = $api->order->create([
                'amount' => intval($package_plan->final_fees * 100),
                'currency' => 'INR',
                'receipt' => 'rcpt_'.uniqid(),
            ]);

            // Track transaction as pending
            $transaction = new Gn_PackageTransaction;
            $transaction->student_id = Auth::id();
            $transaction->plan_id = $package_plan->id;
            $transaction->plan_amount = $package_plan->final_fees;
            $transaction->plan_name = $package_plan->plan_name;
            $transaction->plan_duration = $package_plan->duration;
            $transaction->razorpay_order_id = $order['id'];
            $transaction->transaction_id = 'gyn-'.uniqid();
            $transaction->transaction_date = time();
            $transaction->plan_status = 0; // Pending
            $transaction->save();

            return response()->json([
                'status' => 1,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'user' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'mobile' => Auth::user()->mobile,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function verifyRazorpayPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Update transaction
            $transaction = Gn_PackageTransaction::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if (! $transaction) {
                return response()->json(['status' => 0, 'message' => 'Transaction not found.']);
            }

            $transaction->razorpay_payment_id = $request->razorpay_payment_id;
            $transaction->razorpay_signature = $request->razorpay_signature;
            $transaction->plan_start_date = time();
            $transaction->plan_end_date = strtotime('+'.$transaction->plan_duration.' days');
            $transaction->plan_status = 1; // Active
            $transaction->save();

            return response()->json(['status' => 1, 'message' => 'Payment verified and plan activated.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Payment verification failed: '.$e->getMessage()]);
        }
    }

    public function getTests(Request $request)
    {
        try {
            $user = Auth::user();
            $userDetails = $user ? UserDetails::where('user_id', $user->id)->first() : null;
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_owner_id = $user ? ($user->myInstitute?->user_id ?? 0) : 0;

            $query = TestModal::with('EducationClass')
                ->where('published', 1);

            if ($request->source === 'institute') {
                $query->where('user_id', $institute_owner_id);
            } else {
                $query->where(function ($q) {
                    $q->whereNull('user_id')
                        ->orWhere('user_id', 1);
                });
            }

            if ($request->has('test_type')) {
                $query->where('test_type', $request->test_type);
            }

            if ($request->category_id) {
                $query->where('test_cat', $request->category_id);
            }

            $tests = $query->orderByRaw('CASE WHEN education_type_id = ? AND education_type_child_id = ? THEN 0 ELSE 1 END', [$education_type, $class])
                ->latest()
                ->paginate(20);

            $testIds = $tests->getCollection()->pluck('id')->toArray();
            $attempts = TestAttempt::where('student_id', Auth::id())
                ->whereIn('test_id', $testIds)
                ->get()
                ->keyBy('test_id');

            $tests->getCollection()->each(function ($test) use ($education_type, $class, $attempts) {
                $test->dynamic_duration = $test->testSections->sum(function ($section) {
                    return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
                });

                // Flag if this test matches student's class
                $test->is_student_class = ($test->education_type_id == $education_type && $test->education_type_child_id == $class);

                // Add attempt status
                $attempt = $attempts->get($test->id);
                if ($attempt && $attempt->status === 'running') {
                    $attempt->checkAndHandleExpiry();
                }
                $test->attempt_status = $attempt ? $attempt->status : 'not_started';

                unset($test->testSections); // Clean up response
            });

            return response()->json([
                'status' => 1,
                'data' => $tests,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function getTestDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|exists:test,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $test = TestModal::with(['testSections.sectionSubject', 'EducationClass'])->find($request->test_id);

            // Get questions grouped by section or just flat
            $questions = $test->getQuestions()->get();

            // Format questions for mobile
            $formatted_questions = $questions->map(function ($q) {
                return [
                    'id' => $q->id,
                    'section_id' => $q->pivot->section_id,
                    'question' => $q->question,
                    'options' => [
                        $q->ans_1,
                        $q->ans_2,
                        $q->ans_3,
                        $q->ans_4,
                        $q->ans_5,
                    ],
                    'has_solution' => ! empty($q->solution),
                    'question_type' => $q->question_type,
                ];
            });

            $test->dynamic_duration = $test->testSections->sum(function ($section) {
                return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
            });

            // Ensure sections show duration and subject names
            $sections = $test->testSections->map(function ($section) {
                $section->duration = $section->duration ?: 1;
                $section->name = $section->sectionSubject ? $section->sectionSubject->name : 'Section '.$section->section_index;

                return $section;
            });

            // Initialize/Fetch Attempt record (Mirroring OnlineTestRunner.php logic)
            $attempt = TestAttempt::where('student_id', Auth::id())
                ->where('test_id', $request->test_id)
                ->first();

            if ($attempt) {
                $attempt->checkAndHandleExpiry();
            }

            if (! $attempt && $request->input('start') == 1) {
                $attempt = TestAttempt::create([
                    'student_id' => Auth::id(),
                    'test_id' => $request->test_id,
                    'test_attempt' => 1,
                    'status' => 'running',
                ]);
            }

            // Load existing answers and states directly from DB tracking table
            $answers = [];
            $visited_questions = [];
            $marked_questions = [];
            $draft_state = [
                'current_section' => 0,
                'current_question' => 0,
            ];

            if ($attempt && $attempt->status === 'running') {
                $existingResponses = TestAttemptAnswer::where('test_attempt_id', $attempt->id)->get();
                foreach ($existingResponses as $response) {
                    if ($response->answer !== null && $response->answer !== '') {
                        $ans = $response->answer;
                        if (str_starts_with($ans, 'ans_')) {
                            $ans = substr($ans, 4);
                        }
                        $answers[$response->question_id] = (int) $ans;
                    }
                    if ($response->is_visited) {
                        $visited_questions[] = $response->question_id;
                    }
                    if ($response->is_marked_for_review) {
                        $marked_questions[] = $response->question_id;
                    }
                }
                if ($attempt->draft_state && is_array($attempt->draft_state)) {
                    $draft_state = $attempt->draft_state;
                }
            }

            // Calculate precisely time left in seconds
            $totalDuration = $test->time_to_complete;
            if (! $totalDuration) {
                $totalDuration = $test->testSections->sum(function ($section) {
                    return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
                });
            }
            if (! $totalDuration || $totalDuration <= 0) {
                $totalDuration = 60; // 60 minutes default
            }

            if ($attempt) {
                $expiryTime = $attempt->created_at->timestamp + ($totalDuration * 60);
                $timeLeftInSeconds = max(0, $expiryTime - now()->timestamp);
            } else {
                $timeLeftInSeconds = $totalDuration * 60;
            }

            return response()->json([
                'status' => 1,
                'data' => [
                    'test' => $test,
                    'sections' => $sections,
                    'questions' => $formatted_questions,
                    'test_attempt_id' => $attempt ? $attempt->id : null,
                    'status' => $attempt ? $attempt->status : 'not_started',
                    'answers' => $answers,
                    'visited_questions' => $visited_questions,
                    'marked_questions' => $marked_questions,
                    'draft_state' => $draft_state,
                    'time_left' => $timeLeftInSeconds,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function saveAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|exists:test,id',
            'question_id' => 'required|exists:question_bank,id',
            'answer' => 'nullable',
            'current_section' => 'nullable|integer',
            'current_question' => 'nullable|integer',
            'is_visited' => 'nullable|integer',
            'is_marked_for_review' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $attempt = TestAttempt::where('student_id', Auth::id())
                ->where('test_id', $request->test_id)
                ->where('status', 'running')
                ->latest()
                ->first();

            if (! $attempt) {
                return response()->json(['status' => 0, 'message' => 'No active test attempt found.']);
            }

            // Sync answer selection and statuses
            if ($request->answer === null || $request->answer === '') {
                TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                    ->where('question_id', $request->question_id)
                    ->delete();
            } else {
                $ans = $request->answer;
                if (is_numeric($ans)) {
                    $ans = 'ans_'.$ans;
                }
                $updateData = ['answer' => $ans];
                if ($request->has('is_visited')) {
                    $updateData['is_visited'] = (int) $request->is_visited;
                }
                if ($request->has('is_marked_for_review')) {
                    $updateData['is_marked_for_review'] = (int) $request->is_marked_for_review;
                }

                TestAttemptAnswer::updateOrCreate(
                    ['test_attempt_id' => $attempt->id, 'question_id' => $request->question_id],
                    $updateData
                );
            }

            // Save active indices position tracking
            $draft = $attempt->draft_state ?: [];
            if ($request->has('current_section')) {
                $draft['current_section'] = (int) $request->current_section;
            }
            if ($request->has('current_question')) {
                $draft['current_question'] = (int) $request->current_question;
            }
            if (! empty($draft)) {
                $attempt->update(['draft_state' => $draft]);
            }

            return response()->json(['status' => 1, 'message' => 'Answer saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function getTestResult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_id' => 'required|exists:test,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $student_id = Auth::id();
            $test_id = $request->test_id;

            $test = TestModal::with(['testSections.sectionSubject'])->find($test_id);
            if (! $test) {
                return response()->json(['status' => 0, 'message' => 'Test not found']);
            }

            $attempt = null;
            if ($request->has('test_attempt_id')) {
                $attempt = TestAttempt::where('student_id', $student_id)
                    ->where('id', $request->test_attempt_id)
                    ->first();
            }
            if (! $attempt) {
                $attempt = TestAttempt::where('student_id', $student_id)
                    ->where('test_id', $test_id)
                    ->orderBy('id', 'desc')
                    ->first();
            }

            if (! $attempt) {
                return response()->json(['status' => 0, 'message' => 'No test attempt found for this student']);
            }

            $responses = TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                ->get()
                ->keyBy('question_id');

            $allQuestions = $test->getQuestions()->get();

            $correct = 0;
            $incorrect = 0;
            $unattempted = 0;
            $sections_stats = [];

            // Initialize section stats
            foreach ($test->testSections as $section) {
                $sections_stats[$section->id] = [
                    'id' => $section->id,
                    'name' => $section->sectionSubject ? $section->sectionSubject->name : 'Section '.$section->section_index,
                    'correct' => 0,
                    'incorrect' => 0,
                    'unattempted' => 0,
                    'total' => 0,
                ];
            }

            $formatted_questions = [];
            foreach ($allQuestions as $q) {
                $resp = $responses->get($q->id);
                $status = 'unattempted';
                $user_answer = $resp ? $resp->answer : null;

                if ($user_answer === null || $user_answer === '') {
                    $unattempted++;
                    $status = 'unattempted';
                } elseif ($q->mcq_answer == $user_answer) {
                    $correct++;
                    $status = 'correct';
                } else {
                    $incorrect++;
                    $status = 'incorrect';
                }

                $section_id = $q->pivot->section_id;
                if (isset($sections_stats[$section_id])) {
                    $sections_stats[$section_id][$status]++;
                    $sections_stats[$section_id]['total']++;
                }

                $formatted_questions[] = [
                    'id' => $q->id,
                    'question' => $q->question,
                    'options' => [
                        $q->ans_1,
                        $q->ans_2,
                        $q->ans_3,
                        $q->ans_4,
                        $q->ans_5,
                    ],
                    'correct_answer' => $q->mcq_answer,
                    'user_answer' => $user_answer,
                    'status' => $status,
                    'solution' => $q->solution,
                ];
            }

            $marks_per_q = $test->gn_marks_per_questions ?? 1;
            $neg_rate = $test->negative_marks ?? 0;
            $neg_marks_per_q = $neg_rate * $marks_per_q;

            $total_marks = $correct * $marks_per_q;
            $negative_marks = $incorrect * $neg_marks_per_q;
            $final_marks = $total_marks - $negative_marks;
            $out_of_marks = $allQuestions->count() * $marks_per_q;

            $attempted = $correct + $incorrect;
            $accuracy = $attempted > 0 ? ($correct / $attempted) * 100 : 0;

            return response()->json([
                'status' => 1,
                'data' => [
                    'test_name' => $test->title,
                    'duration' => $test->time_to_complete,
                    'completed_at' => $attempt->submitted_at ? $attempt->submitted_at->format('d M Y, h:i A') : ($attempt->updated_at ? $attempt->updated_at->format('d M Y, h:i A') : ''),
                    'total_question' => $allQuestions->count(),
                    'total_marks' => round($total_marks, 2),
                    'correct_answer' => $correct,
                    'incorrect_answer' => $incorrect,
                    'not_attempted' => $unattempted,
                    'negative_marks' => round($negative_marks, 2),
                    'final_marks' => round($final_marks, 2),
                    'out_of_marks' => $out_of_marks,
                    'accuracy' => round($accuracy, 2),
                    'sections' => array_values($sections_stats),
                    'questions' => $formatted_questions,
                    // Legacy support
                    'total_score' => round($final_marks, 2),
                    'max_score' => $out_of_marks,
                    'correct' => $correct,
                    'incorrect' => $incorrect,
                    'unattempted' => $unattempted,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function getMyPackages(Request $request)
    {
        try {
            $packages = Gn_PackageTransaction::where('student_id', Auth::id())
                ->where('plan_status', 1) // Active
                ->where('plan_end_date', '>=', strtotime(date('Y-m-d'))) // Non-expired
                ->latest()
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $packages,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function getAttemptedTests(Request $request)
    {
        try {
            $attempts = TestAttempt::where('student_id', Auth::id())
                ->with(['test'])
                ->latest()
                ->get();

            foreach ($attempts as $attempt) {
                if ($attempt->status === 'running') {
                    $attempt->checkAndHandleExpiry();
                }
            }

            return response()->json([
                'status' => 1,
                'data' => $attempts,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function getPackageDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:gn__package_plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $plan = Gn_PackagePlan::with(['test' => function ($q) {
                $q->where('published', 1);
            }])->find($request->id);

            // Fetch video materials
            $video_ids = array_filter(array_map('intval', explode(',', $plan->video_id)));
            $videos = ! empty($video_ids) ? Studymaterial::whereIn('id', $video_ids)->where('status', 1)->get() : [];

            // Fetch study notes materials
            $notes_ids = array_filter(array_map('intval', explode(',', $plan->study_material_id)));
            $notes = ! empty($notes_ids) ? Studymaterial::whereIn('id', $notes_ids)->where('status', 1)->get() : [];

            // Fetch static GK materials
            $gk_ids = array_filter(array_map('intval', explode(',', $plan->static_gk_id)));
            $gk = ! empty($gk_ids) ? Studymaterial::whereIn('id', $gk_ids)->where('status', 1)->get() : [];

            // Load attempt status for the logged-in student (Matching Livewire packages/details.php)
            $tests = $plan->test;
            if ($tests && $tests->isNotEmpty()) {
                $testIds = $tests->pluck('id')->toArray();
                $attempts = TestAttempt::where('student_id', Auth::id())
                    ->whereIn('test_id', $testIds)
                    ->get()
                    ->keyBy('test_id');

                foreach ($tests as $onetest) {
                    $attempt = $attempts->get($onetest->id);
                    if ($attempt && $attempt->status === 'running') {
                        $attempt->checkAndHandleExpiry();
                    }
                    $onetest->attempt_status = $attempt ? $attempt->status : 'not_started';
                }
            }

            $is_enrolled = false;
            if (Auth::check()) {
                $is_enrolled = Gn_PackageTransaction::where('student_id', Auth::id())
                    ->where('plan_id', $plan->id)
                    ->where('plan_status', 1)
                    ->where('plan_end_date', '>=', strtotime(date('Y-m-d')))
                    ->exists();
            }

            return response()->json([
                'status' => 1,
                'data' => [
                    'plan' => $plan,
                    'is_enrolled' => $is_enrolled,
                    'tests' => $tests,
                    'videos' => $videos,
                    'notes' => $notes,
                    'gk' => $gk,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }
}
