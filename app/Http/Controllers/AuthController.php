<?php

namespace App\Http\Controllers;

use App\Mail\SendPasswordReset;
use App\Models\OtpVerifications;
use App\Models\PasswordResetModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminlogin(Request $request)
    {
        if (request()->isMethod('post')) {
            $returnResponse = [
                'success' => false,
                'type' => 'failed',
                'message' => '',
                'otp' => ''
            ];

            $input = $request->all();

            $user = array('email' => $input['username'], 'isAdminAllowed' => 1);
            $userData = User::where($user)->first();

            if (Auth::attempt([
                'email' => $input['username'],
                'password' => $input['password']
            ])) {
                $returnResponse['success'] = true;
                return json_encode($returnResponse);
            }

            if ($userData) {
                // send OTP request
                $getOtp = $this->getMobileOtp($userData['mobile']);

                if ($getOtp['success']) {
                    if ($getOtp['type'] == 'default') {
                        $returnResponse['otp'] = 121212;
                    }
                    if ($getOtp['type'] == 'already') {
                        $returnResponse['message'] = 'You already request an OTP in last 10 minutes. please wait for another attempt.';
                    }
                    if ($getOtp['type'] == 'success') {
                        $returnResponse['otp'] = $getOtp['message'];
                    }
                    $returnResponse['success'] = $getOtp['success'];
                    $returnResponse['type'] = $getOtp['type'];
                } else {
                    $returnResponse['message'] = 'OTP request failed, please check the credentials.';
                }
            } else {
                $returnResponse['message'] = 'User not found, please check the credentials.';
            }

            return json_encode($returnResponse);
        }
        return view('Auth/superadmin_login');
    }
    public function franchiselogin()
    {
        if (request()->isMethod('post')) {
            $input = request()->all();

            if (request()->input('form_name') && request()->input('form_name') == 'forget_password') {
                $userData = User::where('email', $input['email'])->where('is_franchise', 1)->where('status', 'active')->first();
                if ($userData) {
                    // send email or mobile authentication for resetting password
                    $code = mt_rand(100000, 999999);

                    $resetDb = new PasswordResetModel();
                    $resetDb->user_id = $userData->id;
                    $resetDb->user_type = 'franchise';
                    $resetDb->verify_type = 'email';
                    $resetDb->code = $code;

                    $resetDb->save();

                    // if($resetDb->save()) {
                    $verifyLink = route('franchise.password_reset', [$userData->email, $code]);
                    // $verifyLink = base_url(route_to('admin_password_reset', $userEmail, $code));
                    $details = [
                        'name' => $userData['name'],
                        'verifyLink' => $verifyLink,
                        'resetCode' => $code
                    ];
                    $mailToSend = new SendPasswordReset($details);
                    $sendMail = Mail::to($input['email'])->send($mailToSend);
                    if (!$sendMail) {
                        return back()->withErrors(['franchiseError' => 'Error sending email, please try again later.']);
                        // $returnResponse['success'] = true;
                        // $returnResponse['type'] = 'success';
                        // $returnResponse['message'] = 'Franchise account updated successfully.';
                    } else {
                        return back()->withErrors(['franchiseSuccess' => 'Please check your email and reset your password.']);
                        // return back()->withErrors(['franchiseError' => 'Error sending email, please try again later. Click to reset password now <a href="'.$verifyLink.'">'.$verifyLink.'</a>']);
                        // $returnResponse['type'] = 'warning';
                        // $returnResponse['message'] = 'Franchise details saved, but unable to send email.';
                    }
                    // }
                }
                // return print_r('User not found');
                // return back()->withInput(['input' => 'mobile']);
                return back()->withErrors(['franchiseError' => 'User not found.']);
            }
            if (request()->input('form_name') && request()->input('form_name') == 'login_form') {
                $fieldType = 'username';
                if (filter_var($input['username'], FILTER_VALIDATE_EMAIL)) {
                    $fieldType = 'email';
                }
                if (filter_var($input['username'], FILTER_VALIDATE_INT) && strlen(filter_var($input['username'], FILTER_VALIDATE_INT)) == 10) {
                    $fieldType = 'mobile';
                }
                $data = [
                    $fieldType => $input['username'],
                    'password' => $input['password']
                ];

                if (Auth::attempt($data)) {
                    return redirect()->route('franchise.dashboard')->with('loginSuccess', 'Welcome User');
                }
                return back()->withErrors(['email' => 'Login failed, You are not authorized.']);
            }
        }
        return view('Auth/blacklogin');
    }

    public function adminPasswordReset($email, $code)
    {
        $data = array();
        $data = [
            'email' => $email,
            'code' => $code
        ];
        return view('Dashboard/Admin/Auth/reset_form')->with('data', $data);
    }
    public function franchisePasswordReset($email, $code)
    {
        $data = array();
        $data = [
            'success' => true,
            'email' => $email,
            'code' => $code
        ];
        $resetData = PasswordResetModel::where('code', $code)->where('user_type', 'franchise')->where('status', 0)->first();
        if (request()->isMethod('post')) {
            $input = request()->all();
            // return print_r($input);
            if ($input['password'] !== $input['confirm_password']) {
                return back()->withErrors(['error' => 'Password not matched.']);
            } else {
                $userId = $resetData->user_id;
                $resetData->status = 1;
                $resetData->save();
                $user = User::find($userId);
                $user->password = Hash::make($input['password']);
                $user->save();
                return redirect()->route('franchise.login')->withErrors(['resetSuccess' => 'Password reset successfull, please login.']);
            }
        }
        if (!$resetData) {
            $data = [
                'success' => false
            ];
        }
        return view('Dashboard/Auth/franchise_reset')->with('data', $data);
    }
    public function studentPasswordReset($code) {}
    public function studentRegistration(Request $request)
    {
        $userData = $request->all();
        unset($userData['city']);
        unset($userData['country']);
        unset($userData['password']);
        $userDetails = [
            'city' => $request->input('city'),
            'country' => $request->input('country')
        ];
        // unset if needed
        // password hashing
        $userData['password'] = bcrypt($request->input('password'));
        // assigning roles
        $userData['roles'] = json_encode(["student"]);
        // $userData = [
        //     'name' => $request->input('name'),
        //     'mobile' => $request->input('mobile'),
        //     'city' => $request->input('city'),
        //     'country' => $request->input('country'),
        //     'email' => $request->input('email'),
        //     'password' => bcrypt($request->input('password')),
        //     'roles' => json_encode(["student"]),
        // ];

        $userCreation = User::create($userData);

        return;
    }

    public function getMobileOtp($mobileNumber)
    {
        $returnResponse = [
            'success' => false,
            'type' => 'failed',
            'message' => ''
        ];

        // $returnResponse = [
        //     'success' => true,
        //     'type' => 'failed',
        //     'message' => ''
        // ];

        if (defaultNumberCheck($mobileNumber)) {
            $returnResponse['success'] = true;
            $returnResponse['type'] = 'default';
        } else {
            // return defaultNumberCheck($returnResponse);
            // $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
            // $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $mobileNumber], ['created_at', '>', $time]])->first();
            // send once in only 10 minutes
            // if ($otpData) {
            //     $returnResponse['success'] = true;
            //     $returnResponse['type'] = 'already';
            //     $returnResponse['message'] = 'You already request an OTP in last 10 minutes. please wait for another attempt.';
            //     return $returnResponse;
            // }
            $otp = mt_rand(100000, 999999);
            // $mobileMessage = 'Dear user, Your OTP for sign up to The Gyanology portal is ' . $otp . '. Valid for 10 minutes. Please do not share this OTP. Regards, The Gyanology Team';
            // $templateId = 1207163026060776390;
            // $url = 'http://198.24.149.4/API/pushsms.aspx?loginID=rajji1&password=kanpureduup78&mobile=' . $mobileNumber . '&text=' . $mobileMessage . '&senderid=GYNLGY&route_id=2&Unicode=0&Template_id=' . $templateId;
            // $response = Http::get($url);

            // $data       = "Dear user Your OTP for sign up to The Gyanology portal is $otp. Valid for 10 minutes. Please do not share this OTP. Regards The Gyanology Team";
            // $message    = "Dear user Your OTP for sign up to The Gyanology portal is $otp. Valid for 10 minutes. Please do not share this OTP. Regards The Gyanology Team";
            $message    = rawurlencode('Dear user%nYour OTP for sign up to The Gyanology portal is ' . $otp . '.%nValid for 10 minutes. Please do not share this OTP.%nRegards%nThe Gyanology Team');
            // $message     = rawurlencode('Dear user Your OTP for sign up to The Gyanology portal is '. $otp .'. Valid for 10 minutes. Please do not share this OTP. Regards The Gyanology Team');
            // $message     = rawurlencode('Dear user Your OTP for login/ registered to The Gyanology portal is 111111 Valid for 10 minutes. Please do not share this OTP. Regards The Gyanology Team');
            $sender     = urlencode("GYNLGY");
            $apikey     = urlencode("MzQ0YzZhMzU2ZTY2NjI0YjU4Mzc0NDMxNmU3MjYzNmM=");
            // $url        = 'https://api.textlocal.in/send/?apikey='. $apikey .'&numbers='. $mobileNumber ."&sender=". $sender ."&message=". $message;

            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // if($response === false) {     echo 'Curl error: ' . curl_error($ch); }
            // curl_close($ch);
            // $response = json_decode($response);
            // dd($response);
            $response = true; //added by vishal
            if ($response) {
                $otpVerifications               = new OtpVerifications;
                $otpVerifications->type         = 'mobile';
                $otpVerifications->credential   = $mobileNumber;
                $otpVerifications->otp          = 123456; //$otp; //comment by vishal
                $saveToDb                       = $otpVerifications->save();

                // if ($saveToDb && $response->status == 'success') { //comment by vishal
                if ($saveToDb) {
                    $returnResponse['success']  = true;
                    $returnResponse['type']     = 'success';
                    $returnResponse['message']  = 123456; //$otp; //comment by vishal
                }

            }
        }
        return $returnResponse;
    }

    public function franchiseManagementLogin()
    {
        if (request()->isMethod('post')) {
            $input = request()->all();

            if (request()->input('form_name') && request()->input('form_name') == 'forget_password') {
                $userData = User::where('email', $input['email'])->where('is_franchise', 1)->where('status', 'active')->first();
                if ($userData) {
                    // send email or mobile authentication for resetting password
                    $code = mt_rand(100000, 999999);

                    $resetDb = new PasswordResetModel();
                    $resetDb->user_id = $userData->id;
                    $resetDb->user_type = 'franchise';
                    $resetDb->verify_type = 'email';
                    $resetDb->code = $code;

                    $resetDb->save();

                    // if($resetDb->save()) {
                    $verifyLink = route('franchise.password_reset', [$userData->email, $code]);
                    // $verifyLink = base_url(route_to('admin_password_reset', $userEmail, $code));
                    $details = [
                        'name' => $userData['name'],
                        'verifyLink' => $verifyLink,
                        'resetCode' => $code
                    ];
                    $mailToSend = new SendPasswordReset($details);
                    $sendMail = Mail::to($input['email'])->send($mailToSend);
                    if (count(Mail::failures()) > 0) {
                        return back()->withErrors(['franchiseError' => 'Error sending email, please try again later.']);
                        // $returnResponse['success'] = true;
                        // $returnResponse['type'] = 'success';
                        // $returnResponse['message'] = 'Franchise account updated successfully.';
                    } else {
                        return back()->withErrors(['franchiseSuccess' => 'Please check your email and reset your password.']);
                        // return back()->withErrors(['franchiseError' => 'Error sending email, please try again later. Click to reset password now <a href="'.$verifyLink.'">'.$verifyLink.'</a>']);
                        // $returnResponse['type'] = 'warning';
                        // $returnResponse['message'] = 'Franchise details saved, but unable to send email.';
                    }
                    // }
                }
                // return print_r('User not found');
                // return back()->withInput(['input' => 'mobile']);
                return back()->withErrors(['franchiseError' => 'User not found.']);
            }
            if (request()->input('form_name') && request()->input('form_name') == 'login_form') {
                $fieldType = 'username';
                if (filter_var($input['username'], FILTER_VALIDATE_EMAIL)) {
                    $fieldType = 'email';
                }
                if (filter_var($input['username'], FILTER_VALIDATE_INT) && strlen(filter_var($input['username'], FILTER_VALIDATE_INT)) == 10) {
                    $fieldType = 'mobile';
                }
                $data = [
                    $fieldType => $input['username'],
                    'password' => $input['password']
                ];

                if (Auth::attempt($data)) {
                    return back()->withErrors(['email' => 'Login failed, You are not authorized.']);
                }
                return back()->withErrors(['email' => 'Login failed, You are not authorized.']);
            }
        }
        return view('Auth/Management/management_login');
    }

    // function to reset password
    public function resetPwd(Request $request)
    {
        $validator = Validator::make($request->values, [
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], 200);
        }

        $user = new User();

        $user->exists = true;
        $user->id = Auth::user()->id;; //already exists in database.

        $user->password = bcrypt($request->values['new_password']);

        if ($user->save()) {
            return response()->json(['status' => 200, 'message' => 'Password Changed Successfully!']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Problem In Password Changed!']);
        }
    }
}
