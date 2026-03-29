<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\NotifyAdminStudentSignup;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry;
use App\Models\FranchiseDetails;
use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackageTransaction;
use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
use App\Models\OtpVerifications;
use App\Models\QuestionBankModel;
use App\Models\Studymaterial;
use App\Models\TestModal;
use App\Models\User;
use App\Models\UserDetails;
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
    public $returnResponse;

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

        if (filter_var($data['mobile'], FILTER_VALIDATE_EMAIL)) {

            $user = User::get()->where('email', $data['mobile'])->where('status', 'active')->where('roles', 'student')->first();
        } else {
            $user = User::get()->where('mobile', $data['mobile'])->where('status', 'active')->where('roles', 'student')->first();
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
                $user['institute_name'] = $user->myInstitute['institute_name'];
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
        Auth::user()->myInstitute->test();

        return response()->json(['status' => 1, 'user_details' => $user]);
    }

    public function instituteTest(Request $request)
    {
        $testTableData = Auth::user()->myInstitute->test()->get();
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
            $testTableData[$key]['created_by'] = Auth::user()->name;
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
            $testTableData[$key]['created_by'] = Auth::user()->name;
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
                $test_response = Gn_Test_Response::where('student_id', $testTableData[$key]['student_id'])->where('test_id', $testTableData[$key]['test_id'])->orderBy('question_id', 'asc')->get();
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
            'id' => 'required|exists:studymaterial,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $material = DB::table('studymaterial')
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
        $old_test_response = Gn_Test_Response::where('student_id', Auth::user()->id)->where('test_id', $request->test_id);

        if (! empty($old_test_response->get())) {
            $old_test_response->delete();
        }

        foreach ($request->attemted_questions as $value) {
            $test_response = new Gn_Test_Response;
            $test_response->student_id = Auth::user()->id;
            $test_response->test_id = $request->test_id;
            if ($value['answer'] == '') {
                $test_response->question_id = $value['question_id'];
            } else {
                $test_response->question_id = $value['question_id'];
                $test_response->answer = $value['answer'];
            }
            $test_response->save();
        }

        $old_student_test = Gn_StudentTestAttempt::where('student_id', Auth::user()->id)->where('test_id', $request->test_id);

        if (! empty($old_student_test->get())) {
            $old_student_test->delete();
        }

        $student_test = new Gn_StudentTestAttempt;
        $student_test->student_id = Auth::user()->id;
        $student_test->test_id = $request->test_id;
        $student_test->test_attempt = 1;
        $student_test->save();

        // if ($test == 1) {
        //     return  response()->json(['status' => 1, 'msg' => 'Save Successfully']);
        // } else {
        //     return  response()->json(['status' => 1, 'msg' => 'Save Sucessfully']);
        // }
        $result = [];
        foreach ($request->attemted_questions as $value) {
            $solution = DB::table('question_bank')->where('id', $value['question_id'])->first()->solution;
            $mcq_answer = DB::table('question_bank')->where('id', $value['question_id'])->first()->mcq_answer;
            $result[] = [
                'question_id' => $value['question_id'],
                'answer' => $value['answer'],
                'solution' => $solution,
                'mcq_answer' => $mcq_answer,
            ];
        }

        return response()->json(['status' => 1, 'msg' => 'Save Successfully', 'result' => $result]);
    }

    public function studentSignup(Request $request)
    {

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
        DB::table('otp_verifications')->updateOrInsert(
            ['mobile' => $user->mobile],
            [
                'otp' => $otp,
                'created_at' => now(),
                'status' => 'pending',
            ]
        );

        // In a real app, send SMS/Email here.
        // For now, returning status 1.
        return response()->json([
            'status' => 1,
            'message' => 'OTP sent successfully',
            'otp' => $otp, // REMOVE THIS in production, added for testing as requested
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
        // $mobileMessage  = 'Dear user, Your OTP for sign up to Test and Notes portal is ' . $otp . '. Valid for 10 minutes. Please do not share this OTP. Regards, Test and Notes Team';
        // $templateId     = 1207163026060776390;
        // $url            = 'http://198.24.149.4/API/pushsms.aspx?loginID=rajji1&password=kanpureduup78&mobile=' . $mobileNumber . '&text=' . $mobileMessage . '&senderid=GYNLGY&route_id=2&Unicode=0&Template_id=' . $templateId;
        // $response       = Http::get($url);

        // $message    = rawurlencode('Dear user%nYour OTP for sign up to Test and Notes portal is ' . $otp . '.%nValid for 10 minutes. Please do not share this OTP.%nRegards%nTest and Notes Team');
        // $sender     = urlencode("GYNLGY");
        // $apikey     = urlencode("MzQ0YzZhMzU2ZTY2NjI0YjU4Mzc0NDMxNmU3MjYzNmM=");
        // $url        = 'https://api.textlocal.in/send/?apikey=' . $apikey . '&numbers=' . $mobileNumber . '&sender=' . $sender . '&message=' . $message;

        // $ch         = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response   = curl_exec($ch);
        // curl_close($ch);
        // $response   = json_decode($response);
        // if ($response) {
        $otpVerifications = new OtpVerifications;
        $otpVerifications->type = 'mobile';
        $otpVerifications->credential = $mobileNumber;
        $otpVerifications->otp = $otp;
        $saveToDb = $otpVerifications->save();

        // if ($saveToDb && $response->status == 'success') {
        if ($saveToDb) {
            $returnResponse['success'] = true;
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
                'user' => $user->load('userDetails'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    public function verifyOTP(Request $request)
    {
        $mobile = $request->input('mobile');
        if (defaultNumberCheck($mobile)) {
            return response()->json(['status' => 1, 'message' => 'OTP verified (Default)']);
        }

        $otp = $request->input('otp');
        $type = $request->input('type') ?? 'mobile'; // Default to mobile
        $time = date('Y-m-d H:i:s', strtotime('-11 minutes'));

        $otpData = OtpVerifications::where([
            ['type', '=', $type],
            ['credential', '=', $mobile],
            ['otp', '=', $otp],
            ['created_at', '>', $time],
        ])->first();

        if ($otpData) {
            return response()->json(['status' => 1, 'message' => 'OTP verified successfully']);
        }

        return response()->json(['status' => 0, 'message' => 'Invalid or expired OTP']);
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
            $userDetails = UserDetails::where('user_id', $user->id)->first();
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_id = $user->myInstitute?->id ?? 0;

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
            $userDetails = UserDetails::where('user_id', $user->id)->first();
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_owner_id = $user->myInstitute?->user_id ?? 0;

            // 1. Categories (Education Types)
            $categories = DB::table('education_type')
                ->where('status', 'active')
                ->get(['id', 'name', 'image']);

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
                ->where('free_test', 1)
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

            return response()->json([
                'status' => 1,
                'data' => [
                    'categories' => $categories,
                    'test_categories' => $test_categories,
                    'featured_tests' => $featured_tests,
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
            $userDetails = UserDetails::where('user_id', $user->id)->first();
            $education_type = $userDetails?->education_type;
            $class = $userDetails?->class;
            $institute_id = $user->myInstitute?->id ?? 0;
            $institute_owner_id = $user->myInstitute?->user_id ?? 0;

            // 1. Premium Packages
            $packages = Gn_PackagePlan::where('status', 1)
                ->where('final_fees', '>', 0)
                ->where('education_type', $education_type)
                ->where('class', $class)
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
                ->where('free_test', 0)
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
            return response()->json(['status' => 0, 'message' => 'This is a free plan.']);
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
            $userDetails = UserDetails::where('user_id', $user->id)->first();
            $education_type = $userDetails?->education_type ?? 0;
            $class = $userDetails?->class ?? 0;
            $institute_owner_id = $user->myInstitute?->user_id ?? 0;

            $query = TestModal::with('EducationClass')
                ->where('published', 1)
                ->where(function ($q) use ($institute_owner_id) {
                    $q->whereIn('user_id', [$institute_owner_id, 1])
                        ->orWhereNull('user_id');
                });

            if ($request->category_id) {
                $query->where('test_cat', $request->category_id);
            }
            // if ($request->education_type_id) {
            //     $query->where('education_type_id', $request->education_type_id);
            // }

            $tests = $query->orderByRaw('CASE WHEN education_type_id = ? AND education_type_child_id = ? THEN 0 ELSE 1 END', [$education_type, $class])
                ->latest()
                ->paginate(20);

            $tests->getCollection()->each(function ($test) use ($education_type, $class) {
                $test->dynamic_duration = $test->testSections->sum(function ($section) {
                    return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
                });
                
                // Flag if this test matches student's class
                $test->is_student_class = ($test->education_type_id == $education_type && $test->education_type_child_id == $class);
                
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
            $test = TestModal::with(['testSections', 'EducationClass'])->find($request->test_id);

            // Get questions grouped by section or just flat
            $questions = $test->getQuestions()->get();

            // Format questions for mobile
            $formatted_questions = $questions->map(function ($q) {
                return [
                    'id' => $q->id,
                    'section_id' => $q->pivot->section_id,
                    'question' => $q->question,
                    'options' => [
                        $q->option_1,
                        $q->option_2,
                        $q->option_3,
                        $q->option_4,
                        $q->option_5,
                    ],
                    'has_solution' => ! empty($q->solution),
                    'question_type' => $q->question_type,
                ];
            });

            $test->dynamic_duration = $test->testSections->sum(function ($section) {
                return ($section->number_of_questions ?? 0) * ($section->duration ?: 1);
            });

            // Ensure sections show duration
            $test->testSections->transform(function ($section) {
                $section->duration = $section->duration ?: 1;
                return $section;
            });

            return response()->json([
                'status' => 1,
                'data' => [
                    'test' => $test,
                    'sections' => $test->testSections,
                    'questions' => $formatted_questions,
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
            $attempts = Gn_StudentTestAttempt::where('student_id', Auth::id())
                ->with(['test'])
                ->latest()
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $attempts,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }
}
