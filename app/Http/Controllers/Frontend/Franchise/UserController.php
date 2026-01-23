<?php

namespace App\Http\Controllers\Frontend\Franchise;

use App\Http\Controllers\Controller;
use App\Mail\NotifyAdminStudentAccountChanges;
use App\Mail\NotifyUserAccountChanges;
use App\Models\CorporateEnquiry;
use App\Models\FranchiseDetails;
use App\Models\Educationtype;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\RoleAssign;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\OtpVerifications;
use App\Mail\SendOtpMail;

class UserController extends Controller
{
    public $returnResponse = [];
    public function __construct(){
        $this->returnResponse = [
            'message' => null,
            'success' => false
        ];
    }

    public function index($type = 'all')
    {
        $data = array();
        $id = Auth::user()->id;
        $myDetails = FranchiseDetails::where('user_id', $id)->first();
        $branchCode = $myDetails->branch_code;

        $matchThis = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0'];

        $data = User::where($matchThis);

        if ($type == 'new') {
            $data = $data->where('status', 'unread')->orWhere('status','inactive')->get();
        }
        if ($type == 'students') {
            $data = $data->where('status', 'active')->where('roles', 'student')->get();
        }
        if ($type == 'managers') {
            $data = $data->where('status', 'active')->where('roles', 'manager')->get();
        }
        if ($type == 'creators') {
            $data = $data->where('status', 'active')->where('roles', 'creator')->get();
        }
        if ($type == 'publishers') {
            $data = $data->where('status', 'active')->where('roles', 'publisher')->get();
        }
        if ($type == 'multi') {
            $data = $data->where('status', 'active')->where('roles','like','%,%')->get();
        }

        return view('Dashboard/Franchise/Dashboard/users')->with('data', $data);
    }
    public function new_signup()
    {
        $data = array();

        $id = Auth::user()->id;
        $myDetails = FranchiseDetails::where('user_id', $id)->first();
        $branchCode = $myDetails->branch_code;

        $matchThis = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0'];
        $data = User::where($matchThis)->where('status', 'inactive')->orWhere('status', 'unread')->get();

        return view('Dashboard/Franchise/Dashboard/new_signup')->with('data', $data);
    }
    public function show($id)
    {
        $user = User::find($id);
        $data['user'] = $user;
        $data['details'] = array();
        $data['details'] = UserDetails::where('user_id', $id)->first();

        if (request()->isMethod('post')) {
            $requestData = request()->all();
            $role_id = [];
            if (!empty(request()->role)) {
                foreach (request()->role as $key => $value) {
                    switch ($value) {
                        case 'manager'   : $role_id[$key]   = 6;
                        break;

                        case 'creator'   : $role_id[$key]   = 8;
                        break;

                        case 'publisher' : $role_id[$key]   = 7;
                        break;

                        case 'verifier'  : $role_id[$key]   = 9;
                        break;

                        case 'reviewer'  : $role_id[$key]   = 10;
                        break;

                        default:
                        break;
                    }
                }
            }

            if (request()->input('form_name') == 'set_user') {
                // $userDb = new User();
                $userDb = User::find($id);

                // $userDb->id =  $id;
                $userDb->name =  htmlspecialchars(request()->input('name'));

                if (request()->input('is_staff') == 0) {
                    $userDb->roles              = 'student';
                    $userDb->is_staff           = 0;
                    $userDb->franchise_roles    = null;
                } else {
                    if ($userDb->franchise_code) {
                        $userDb->roles              = implode(',',request()->input('role'));
                        $userDb->is_staff           = 1;
                        $userDb->franchise_roles    = json_encode(request()->input('role'));
                    } else {
                        $userDb->isAdminAllowed     = 1;
                        $userDb->roles              = json_encode(request()->input('role'));
                        $userDb->franchise_roles    = null;
                    }
                }

                $userDetailsDB = UserDetails::where('user_id', $id)->first();
                if ($requestData['status'] !== $userDb['status']) {
                    $userDb->status = $requestData['status'];
                }
                $today = date('Y-m-d');
                if ($userDetailsDB) {
                    if ($requestData['days'] !== $userDetailsDB['days'] || intval($requestData['days']) > 0 && $today < $userDetailsDB['inactive_at']) {
                        $userDetailsDB->days        = $requestData['days'];
                        $days                       = intval($requestData['days'] + 1);
                        $endDate                    = date('Y-m-d', strtotime('+' . $days . ' days'));
                        $userDetailsDB->started_at  = $today;
                        $userDetailsDB->inactive_at = $endDate;
                        $userDetailsDB->education_type = isset($requestData['education_type_id']) ? $requestData['education_type_id'] : 0;
                        $userDetailsDB->class = isset($requestData['class_group_exam_id']) ? $requestData['class_group_exam_id'] : 0;
                        $userDetailsDB->allowed_to_upload = (isset($requestData['allowed_to_upload'])) ? $requestData['allowed_to_upload'] : 0;
                        $userDetailsDB->submit_content = (isset($requestData['submit_content'])) ? $requestData['submit_content'] : 0;
                        $userDetailsDB->allowed_to_package = (isset($requestData['allowed_to_package'])) ? $requestData['allowed_to_package'] : 0;
                        $userDetailsDB->add_package = (isset($requestData['add_package'])) ? $requestData['add_package'] : 0;
                        $userDetailsDB->save();
                    }
                }

                if (request()->input('password')) {
                    $userDb->password =  Hash::make(request()->input('password'));
                }
                $userDb->status =  request()->input('status');

                $diff_role_id = array_diff($userDb->role->pluck('role_id')->toArray(),$role_id);

                if (!empty($role_id)) {
                    foreach ($role_id as $user_role_id) {
                        $userRole           = new RoleAssign();
                        $userRole->user_id  = $userDb->id;
                        $userRole->role_id  = $user_role_id;
                        $userRole->save();
                    }
                }

                if (!empty($diff_role_id)) {
                    RoleAssign::where('user_id',$userDb->id)->whereIn('role_id',$diff_role_id)->delete();
                }

                if ($userDb->save()) {
                    try{//on changes done on page /administrator/users/view/156 or institute/user/view/156
                    //send deatils to super admin
                    $user_datails = [
                        'fullname' => $userDb->name,
                        'email_id' => $userDb->email,
                        'institute_code' => $userDb->franchise_code
                    ];

                    $super_admins = User::where('roles', 'superadmin')->where('status', 'active')->where('deleted_at', null)->get(['email'])->toArray();
                    $emails = [];
                    foreach ($super_admins as $super_admin) {
                        array_push($emails, $super_admin['email']);
                    }
                    $superAdminMailToSend = new NotifyAdminStudentAccountChanges($user_datails);
                    $sendAdminMail = Mail::to($emails)->send($superAdminMailToSend);
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/custom.log'),
                    ])->info('student account update admin '.implode(" ", $emails).' '.count(Mail::failures()));
                    //send email to user in which account changes are done
                    $mailToSend = new NotifyUserAccountChanges($user_datails);
                     $sendMail = Mail::to($userDb->email)->send($mailToSend);
                     Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/custom.log'),
                    ])->info('student account update '.$userDb->email.' '.count(Mail::failures()));
                     }catch (\Throwable $th) {
                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('problem in email sending in user activation'.$th);
                    }
                    return json_encode(true);
                }
                User::generateCounts();
                CorporateEnquiry::generateCounts();
                return json_encode(true);
            }
        }

        $data['manager']    = false;
        $data['creator']    = false;
        $data['publisher']  = false;
        $data['verifier']   = false;
        $data['reviewer']   = false;
        if ($user['franchise_roles'] && $user['is_staff'] == 1) {
            $roles = json_decode($user['franchise_roles']);
            if ($roles == 'manager' || in_array('manager', $roles)) {
                $data['manager'] = true;
            } else {
                $data['manager'] = false;
            }
            if ($roles == 'creator' || in_array('creator', $roles)) {
                $data['creator'] = true;
            } else {
                $data['creator'] = false;
            }
            if ($roles == 'publisher' || in_array('publisher', $roles)) {
                $data['publisher'] = true;
            } else {
                $data['publisher'] = false;
            }
            if ($roles == 'verifier' || in_array('verifier', $roles)) {
                $data['verifier'] = true;
            } else {
                $data['verifier'] = false;
            }
            if ($roles == 'reviewer' || in_array('reviewer', $roles)) {
                $data['reviewer'] = true;
            } else {
                $data['reviewer'] = false;
            }
        }

        $data['selectedDays'] = 7;
        $data['remainingSubscription'] = 'No Subscription';
        if ($data['details']->days) {
            $data['selectedDays'] = intval($data['details']->days);
            $data['remainingSubscription'] = 'Expires at ' . date('d-M-Y', strtotime($data['details']['started_at'] . ' + ' . $data['selectedDays'] . ' days'));
        }
        $data['education_type'] = intval($data['details']->education_type);
        $data['class'] = intval($data['details']->class);
        // dd($data,$data['user']);
        // return print_r($data);
        $gn_EduTypes      = Educationtype::get();
        $data['gn_EduTypes'] = $gn_EduTypes;

        $data['institute_code'] = DB::table('user_details')->where('user_id',$id)->first();
        $data['institute_name'] = DB::table('franchise_details')->where('branch_code',$data['institute_code']->institute_code)->first();


        return view('Dashboard/Franchise/Dashboard/user_view')->with('data', $data);
    }
    public function myProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $details = null;
        if (str_contains($user['roles'], 'franchise')) {
            $details = FranchiseDetails::where('user_id', $id)->first();
        }

        $otherRoles = ['creator', 'publisher', 'manager', 'verifier', 'reviewer'];
        $isOtherRole = false;
        foreach ($otherRoles as $role) {
            if (str_contains($user['roles'], $role)) {
                $isOtherRole = true;
                break;
            }
        }

        if ($isOtherRole) {
            $details = UserDetails::where('user_id', $id)->first();
            if (!$details) {
                $detailsDb = new UserDetails();
                $detailsDb->user_id = $id;
                $detailsDb->save();
                $details = UserDetails::where('user_id', $id)->first();
            }
        }

        if (request()->isMethod('post')) {
            // Ensure details record exists before processing
            if (!$details) {
                if (str_contains($user['roles'], 'franchise')) {
                    // For franchise users, we need FranchiseDetails
                    return redirect()->back()->with('error', 'Franchise details not found. Please contact administrator.');
                } else {
                    // For other users, create UserDetails if missing
                    $detailsDb = new UserDetails();
                    $detailsDb->user_id = $id;
                    $detailsDb->save();
                    $details = UserDetails::where('user_id', $id)->first();
                }
            }

            $inputs = request()->all();
            if (request()->input('name') && $inputs['name'] !== $user['name']) {
                $user['name'] = $inputs['name'];
            }
            if (request()->input('password')) {
                $user['password'] = Hash::make($inputs['password']);
            }

            // Image uploads
            if ($file = request()->file('user_image')) {
                $name = $file->hashName();
                $details->photo_url = request()->file('user_image')->storeAs('institute/avatar', $name, 'public');
            }
            if(str_contains($user['roles'], 'franchise')){
                if ($file = request()->file('logo')) {
                    $name = $file->hashName();
                    $details->logo = request()->file('logo')->storeAs('institute/logo', $name, 'public');
                }
            }

            // Address fields
            if (request()->input('address') && $inputs['address'] !== $details['address']) {
                $details->address = $inputs['address'];
            }
            if (request()->input('pincode') && $inputs['pincode'] !== $details['pincode']) {
                $details->pincode = $inputs['pincode'];
            }
            if (request()->input('city') && $inputs['city'] !== $details['city']) {
                $details->city = $inputs['city'];
            }
            if (request()->input('state') && $inputs['state'] !== $details['state']) {
                $details->state = $inputs['state'];
            }

            $user->save();
            $details->save();
            return redirect()->back()->with('message', 'Profile Updated Successfully');
        }
        $details['email'] = $user['email'];
        $details['mobile'] = $user['mobile'];
        $user['details'] = $details;

        if(strpos($user['roles'], 'franchise') !== false){
            return view('Dashboard/Franchise/Settings/profile')->with('user', $user);
        }

        if(strpos($user['roles'], 'creator') !== false || strpos($user['roles'], 'publisher') !== false){
            return view('Dashboard/Franchise/Settings/profile_creater')->with('user', $user);
        }

        if(strpos($user['roles'], 'manager') !== false || strpos($user['roles'], 'verifier') !== false || strpos($user['roles'], 'reviewer') !== false){
            return view('Dashboard/Franchise/Settings/profile_manager')->with('user', $user);
        }

        return view('Dashboard/Franchise/Settings/profile_manager')->with('user', $user);
    }

    public function myProfile_creater_publisher()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $details = UserDetails::where('user_id', $id)->first();
        if (!$details) {
            $detailsDb = new UserDetails();
            $detailsDb->user_id = $id;
            $detailsDb->save();
            $details = UserDetails::where('user_id', $id)->first();
        }
        if (request()->isMethod('post')) {
            $inputs = request()->all();
            if (request()->input('name') && $inputs['name'] !== $user['name']) {
                $user['name'] = $inputs['name'];
            }
            if (request()->input('password')) {
                $user['password'] = Hash::make($inputs['password']);
            }
            if (request()->input('email')) {
                $user['email'] = $inputs['email'];
            }
            if ($file = request()->file('user_image')) {
                $name = $file->hashName();
                $details->photo_url = request()->file('user_image')->storeAs('admin/' . $id, $name, 'public');
            }
            if (request()->input('address') && $inputs['address'] !== $details['address']) {
                $details->address = $inputs['address'];
            }
            if (request()->input('pincode') && $inputs['pincode'] !== $details['pincode']) {
                $details->pincode = $inputs['pincode'];
            }
            if (request()->input('city') && $inputs['city'] !== $details['city']) {
                $details->city = $inputs['city'];
            }
            if (request()->input('state') && $inputs['state'] !== $details['state']) {
                $details->state = $inputs['state'];
            }
            $user->save();
            $details->save();
            return redirect()->back();
        }
        $details['email'] = $user['email'];
        $details['mobile'] = $user['mobile'];
        $user['details'] = $details;
        return view('Dashboard/Franchise/Management/Creater/Settings/profile')->with('user', $user);
    }


    public function addUser(Request $req)
    {
        $data = array();

        $time = date('Y-m-d');
        $time .= '00:00:00';
        $franchiseCodes = FranchiseDetails::select('id', 'branch_code', 'institute_name')->where('inactive_at', '>', $time)->where('user_id',Auth::user()->id)->get();
        // dd($franchiseCodes,Auth::user()->franchise_code);
        // return print_r($franchiseCodes);

        if (request()->isMethod('post')) {
            $request = request()->all();
            // dd($req->all());
            // return print_r($request);
            $usernameError = false;
            $emailError = false;
            $mobileError = false;
            $validationErrorMessage = '';

            if ($request['username'] != '') {
                $check = User::select('id')->where('username', $request['username'])->first();
                if ($check) {
                    $usernameError = true;
                    $validationErrorMessage .= ' Username already in use.';
                }
            }
            if ($request['email'] != '') {
                $message = '';
                $check = User::select('id')->where('email', $request['email'])->first();
                if ($check) {
                    $emailError = true;
                    $validationErrorMessage .= ' Email already in use.';
                }
                $check = CorporateEnquiry::select('id')->where('email', $request['email'])->first();
                if ($check) {
                    $emailError = true;
                    $validationErrorMessage .= ' Email already in use.';
                }
                $validationErrorMessage .= ' ' . $message;
            }
            if ($request['mobile'] != '') {
                $message = '';
                $check = User::select('id')->where('mobile', $request['mobile'])->first();
                if ($check) {
                    $mobileError = true;
                    $validationErrorMessage .= ' Mobile already in use.';
                }
                $check = CorporateEnquiry::select('id')->where('mobile', $request['mobile'])->first();
                if ($check) {
                    $mobileError = true;
                    $validationErrorMessage .= ' Mobile already in use.';
                }
                $validationErrorMessage .= ' ' . $message;
            }

            if ($usernameError || $emailError || $mobileError) {
                // return print_r($validationErrorMessage);
                return back()->withErrors(['userError' => $validationErrorMessage]);
            } else {
                $userDb         = new User();
                $userDetailsDb  = new UserDetails();

                $userDb->status     = $request['status'];
                $userDb->username   = $request['username'] != '' ? $request['username'] : NULL;
                $userDb->name       = $request['name'];
                $userDb->email      = $request['email'];
                $userDb->mobile     = $request['mobile'];

                $userDb->is_staff       =  1;
                $userDb->is_franchise   =  0;

                if ($request['institute_code'] == 'Direct') {
                    $userDb->in_franchise =  0;
                    $userDb->franchise_code =  NULL;
                } else {
                    $userDb->in_franchise           =  1;
                    $userDb->franchise_code         =  $request['institute_code'];
                    $userDetailsDb->institute_code  =  filter_var($request['institute_code']);
                    $userDb->franchise_roles        = json_encode($request['role']);
                }

                $userDb->password        = Hash::make($request['password']);
                $userDb->roles           = implode(',', $request['role']);
                $userDb->franchise_roles = json_encode($request['role']);

                if ($userDb->save()) {
                    foreach ($request['role'] as $key => $role_assign) {
                        $userRole       = new RoleAssign();

                        if ($role_assign == 'manager') {
                            $userRole->user_id = $userDb->id;
                            $userRole->role_id = 6;
                            $userRole->save();
                        }
                        if ($role_assign == 'creator') {
                            $userRole->user_id = $userDb->id;
                            $userRole->role_id = 8;
                            $userRole->save();
                        }
                        if ($role_assign == 'publisher') {
                            $userRole->user_id = $userDb->id;
                            $userRole->role_id = 7;
                            $userRole->save();
                        }
                        if ($role_assign == 'verifier') {
                            $userRole->user_id = $userDb->id;
                            $userRole->role_id = 9;
                            $userRole->save();
                        }
                        if ($role_assign == 'reviewer') {
                            $userRole->user_id = $userDb->id;
                            $userRole->role_id = 10;
                            $userRole->save();
                        }
                    }

                    $userDetailsDb->user_id =  $userDb->id;
                    if ($file = request()->file('user_logo')) {
                        $name = $file->hashName();
                        $userDetailsDb->photo_url = request()->file('user_logo')->storeAs('student_uploads/' . $userDb->id, $name, 'public');
                    }
                    $userDetailsDb->save();
                    User::generateCounts();
                    return redirect()->route('franchise.dashboard', [$userDb->id]);
                } else {
                    return back()->withErrors(['userError' => 'Unable to create contributor, please try again later.']);
                }
                // save userdetails also + user image upload + user count generation + show on users lis.
                // on success goes to user view page

                // $today = date('Y-m-d');
                // if (intval($request['days']) > 0) {
                //     $franchiseDetailsSave->days = $requestData['days'];
                //     $days = intval($requestData['days'] + 1);
                //     $endDate = date('Y-m-d', strtotime('+' . $days . ' days'));
                //     $franchiseDetailsSave->started_at = $today;
                //     $franchiseDetailsSave->inactive_at = $endDate;
                //     $enquirySave->status = 'activated';
                //     $enquirySave->save();
                //     $franchiseSave->status = 'active';
                // }
                // return print_r('Data success');
            }
        }

        $data['franchiseCodes'] = $franchiseCodes;
        return view('Dashboard/Franchise/Dashboard/user_add')->with('data', $data);
    }
    public function verifymobile(Request $req, $mobile)
    {
        if (!\App\Helpers\ProfileValidationHelper::isMobileUnique($mobile, Auth::id())) {
            return false;
        } else {
            return $this->getMobileOtp($mobile);
        }
    }

    public function verifyemail(Request $req, $email)
    {
        if (!\App\Helpers\ProfileValidationHelper::isEmailUnique($email, Auth::id())) {
            return false;
        } else {
            return $this->getEmailOtp($email);
        }
    }

    public function getMobileOtp($mobileNumber)
    {
        $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'mobile'], ['credential', '=', $mobileNumber], ['created_at', '>', $time]])->first();
        // send once in only 10 minutes
        if ($otpData) {
            $this->returnResponse['message'] = 'You already request an OTP in last 10 minutes. please wait for another attempt.';
            return json_encode($this->returnResponse);
        }
        $otp            = mt_rand(100000, 999999);

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
            $otpVerifications               = new OtpVerifications;
            $otpVerifications->type         = 'mobile';
            $otpVerifications->credential   = $mobileNumber;
            $otpVerifications->otp          = $otp;
            $saveToDb                       = $otpVerifications->save();

            // if ($saveToDb && $response->status == 'success') {
            if ($saveToDb) {
                $this->returnResponse['success'] = true;
            }
        // }

        return $this->returnResponse;
    }

    public function getEmailOtp($email)
    {
        $time = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $otpData = OtpVerifications::where([['type', '=', 'email'], ['credential', '=', $email], ['created_at', '>', $time]])->first();
        // send once in only 10 minutes
        if ($otpData) {
            $this->returnResponse['message'] = 'You already request an OTP in last 10 minutes. please wait for another attempt.';
            return json_encode($this->returnResponse);
        }
        $otp            = mt_rand(100000, 999999);

        $details = [
            'otp' => $otp
        ];

        // Mail::to($email)->send(new \App\Mail\SendOtpMail($details));
        try {
            Mail::raw('Your OTP for Test and Notes is ' . $otp, function ($message) use ($email) {
                $message->to($email)
                  ->subject('OTP Verification');
            });
        } catch (\Exception $e) {
            $this->returnResponse['message'] = 'Failed to send OTP. Please try again.';
             return json_encode($this->returnResponse);
        }

        $otpVerifications               = new OtpVerifications;
        $otpVerifications->type         = 'email';
        $otpVerifications->credential   = $email;
        $otpVerifications->otp          = $otp;
        $saveToDb                       = $otpVerifications->save();

        if ($saveToDb) {
            $this->returnResponse['success'] = true;
        }


        return $this->returnResponse;
    }

    public function verifyotp($type, $credential, $otp)
    {
        $time = date('Y-m-d H:i:s', strtotime('-11 minutes'));
        $otpData = OtpVerifications::where([['type', '=', $type], ['credential', '=', $credential], ['otp', '=', $otp], ['created_at', '>', $time]])->first();
        if ($otpData) {
            $user = User::find(Auth::user()->id);
            if ($type == 'mobile') {
                $user->mobile = $credential;
            }
            if ($type == 'email') {
                 $user->email = $credential;
            }
            $user->save();
            return true;
        }
        return false;
    }
}
