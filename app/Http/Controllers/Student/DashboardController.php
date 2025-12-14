<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Count;
use App\Models\User;
use App\Models\TestModal;
use App\Models\Gn_StudentTestAttempt;
use App\Models\Studymaterial;
use App\Models\UserDetails;
use App\Models\TestCat;
use Illuminate\Support\Facades\DB;
use App\Models\OtpVerifications;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $returnResponse = [];
    public function __construct(){
        $this->returnResponse = [
            'message' => null,
            'success' => false
        ];
    }
    public function index(Request $req)
    {
        $stud_id = Auth::user()->id;
        $User = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        $class = $User->class;
        $education_type = $User->education_type;
        $testAttempt = Gn_StudentTestAttempt::where('student_id', $stud_id)->get();
        $testAttemptCount = $testAttempt->count();

        $testTotal = TestModal::where('user_id', NULL)->where('published', 1)->where('education_type_child_id', $class)->get();
        // $testCount = $testTotal->count();

        $testCount = [];
        $test_cat = TestCat::get();
        foreach ($test_cat as $cat) {
            $testCount[$cat->id] = $testTotal->where('test_cat', $cat->id)->count();
        }
        if (!empty(Auth::user()->myInstitute)) {
            $testInstitute = Auth::user()->myInstitute->test()->where('published', 1)->where('education_type_child_id', $class)->count();
        } else {
            $testInstitute = 0;
        }

        $notes_count = Studymaterial::where('category', 'Study Notes & E-Books')->whereIn('institute_id', array(Auth::user()->myInstitute?->id, 0))->where('class', $class)->where("status", 1)->where("material_seen", 1)->get();
        $notes_count = $notes_count->count($notes_count);

        $video_count = Studymaterial::where('category', 'Live & Video Classes')->whereIn('institute_id', array(Auth::user()->myInstitute?->id, 0))->where('class', $class)->where("status", 1)->where("material_seen", 1)->get();
        $video_count = $video_count->count($video_count);

        $gk_count = Studymaterial::where('category', 'Static GK & Current Affairs')->whereIn('institute_id', array(Auth::user()->myInstitute?->id, 0))->where('class', $class)->where("status", 1)->where("material_seen", 1)->get();
        $gk_count = $gk_count->count($gk_count);

        $comprehensive_count = Studymaterial::where('category', 'Comprehensive Study Material')->whereIn('institute_id', array(Auth::user()->myInstitute?->id, 0))->where('class', $class)->where("status", 1)->where("material_seen", 1)->get();
        $comprehensive_count = $comprehensive_count->count($comprehensive_count);
        // dd($testCount);

        return view('Dashboard/Student/Dashboard/index', compact('testAttemptCount', 'testCount', 'testInstitute', 'notes_count', 'video_count', 'gk_count', 'comprehensive_count', 'education_type', 'testTotal', 'test_cat'));
    }

    public function profile(Request $req)
    {

        $result['user'] = User::where('id', Auth::user()->id)->first();

        // return $result['user'];

        return view('Dashboard/Student/profile/profile_manage', $result);
    }

    public function verifynumber(Request $req, $mobile_number)
    {
        $user = User::where('id', Auth::user()->id)->where('mobile', $mobile_number)->first();
        if ($user) {
            return false;
        } else {
            return $this->getMobileOtp($mobile_number);
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
        // $mobileMessage  = 'Dear user, Your OTP for sign up to The Gyanology portal is ' . $otp . '. Valid for 10 minutes. Please do not share this OTP. Regards, The Gyanology Team';
        // $templateId     = 1207163026060776390;
        // $url            = 'http://198.24.149.4/API/pushsms.aspx?loginID=rajji1&password=kanpureduup78&mobile=' . $mobileNumber . '&text=' . $mobileMessage . '&senderid=GYNLGY&route_id=2&Unicode=0&Template_id=' . $templateId;
        // $response       = Http::get($url);


        $message    = rawurlencode('Dear user%nYour OTP for sign up to The Gyanology portal is ' . $otp . '.%nValid for 10 minutes. Please do not share this OTP.%nRegards%nThe Gyanology Team');
        $sender     = urlencode("GYNLGY");
        $apikey     = urlencode("MzQ0YzZhMzU2ZTY2NjI0YjU4Mzc0NDMxNmU3MjYzNmM=");
        $url        = 'https://api.textlocal.in/send/?apikey=' . $apikey . '&numbers=' . $mobileNumber . '&sender=' . $sender . '&message=' . $message;

        $ch         = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response   = curl_exec($ch);
        curl_close($ch);
        $response   = json_decode($response);
        if ($response) {
            $otpVerifications               = new OtpVerifications;
            $otpVerifications->type         = 'mobile';
            $otpVerifications->credential   = $mobileNumber;
            $otpVerifications->otp          = $otp;
            $saveToDb                       = $otpVerifications->save();

            if ($saveToDb && $response->status == 'success') {
                $this->returnResponse['success'] = true;
            }
        }

        return $this->returnResponse;
    }
    public function verifyotp($mobile, $otp)
    {

        $type =  'mobile';
        $time = date('Y-m-d H:i:s', strtotime('-11 minutes'));
        $otpData = OtpVerifications::where([['type', '=', $type], ['credential', '=', $mobile], ['otp', '=', $otp], ['created_at', '>', $time]])->first();
        if ($otpData) {
            return true;
        }
    }

    public function manage_profile_process(Request $req)
    {

        // return $req->all();
        if ($req->mobile_number != $req->old_mobile_number) {
            if ($req->verify_check != 1) {
                $req->session()->flash('message', 'Please Verify Mobile Number');
                return redirect()->back();
            }
        }
        $verifyemail = User::where('id', '!=', Auth::user()->id)->where('email', $req->email)->first();
        if ($verifyemail) {
            $req->session()->flash('message', 'This Email Alredy Registred!');
            return redirect()->back();
        } else
            $user = User::find(Auth::user()->id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->mobile = $req->mobile_number;
        $user->save();

        if ($req->hasfile('photo_url')) {

            $file = $req->file('photo_url');
            $name = $file->hashName();
            $image_name = $req->file('photo_url')->storeAs('student_uploads/' . $user->id, $name, 'public');
            DB::table('user_details')
                ->where('user_id', Auth::user()->id)
                ->update(['photo_url' => $image_name]);
        }
        $req->session()->flash('message', 'Profile Updated.');
        return redirect()->back();
    }

    public function package_manage(Request $req, $id)
    {

        return view("Dashboard/Student/MyPlan/package_manage");
    }
}
