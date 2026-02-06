<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotifyUserAccountChanges;
use App\Models\CorporateEnquiry;
use App\Models\FranchiseDetails;
use App\Models\Educationtype;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\RoleAssign;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index($type = 'all', $franchise = false)
    {
        $data = array();
        $matchThis = ['in_franchise' => '0'];
        if ($franchise) {
            $matchThis = ['in_franchise' => '1', 'isAdminAllowed' => '0'];
        }
        $data = User::leftjoin('user_details','users.id','=','user_details.user_id')
        ->leftjoin('education_type','user_details.education_type','=','education_type.id')
        ->leftjoin('classes_groups_exams','user_details.class','=','classes_groups_exams.id')
        ->leftjoin('franchise_details','user_details.institute_code','=','franchise_details.branch_code')
        ->select('users.*', 'user_details.photo_url','education_type.name as education_type_name','classes_groups_exams.name as class_name','user_details.institute_code','franchise_details.institute_name' )
        ->where($matchThis);

        if ($type == 'new') {
            $data = $data->where(function($q) {
                $q->where('status', 'inactive')->orWhere('status', 'unread');
            })->get();
        }
        if ($type == 'students') {
            // $data = $data->where('status', 'active')->where('roles', 'student')->get();
            $data = $data->where('roles', 'student')->get();
        }
        if ($type == 'managers') {
            $data = $data->where('is_staff', '1')->where('roles', 'manager')->get();
        }
        if ($type == 'creators') {
            $data = $data->where('is_staff', '1')->where('roles', 'creator')->get();
        }
        if ($type == 'publishers') {
            $data = $data->where('is_staff', '1')->where('roles', 'publisher')->get();
        }
        if ($type == 'verifier') {
            $data = $data->where('is_staff', '1')->where('roles', 'verifier')->get();
        }
        if ($type == 'reviewver') {
            $data = $data->where('is_staff', '1')->where('roles', 'reviewver')->get();
        }
        if ($type == 'multi') {
            $data = $data->where('is_staff', '1')->where('roles', 'like', '%,%')->get();
        }
        if ($type == 'left') {
            $data = $data->where('status', 'left')->get();
        }

        $page_title = 'Users';
        switch ($type) {
            case 'students': $page_title = 'Students'; break;
            case 'managers': $page_title = 'Managers'; break;
            case 'creators': $page_title = 'Creators'; break;
            case 'publishers': $page_title = 'Publishers'; break;
            case 'verifier': $page_title = 'Verifiers'; break;
            case 'reviewver': $page_title = 'Reviewers'; break;
            case 'new': $page_title = 'New User Sign Up'; break;
            case 'multi': $page_title = 'Contributors'; break; // Assuming multi-role users are contributors based on user hint
            case 'all': default: $page_title = 'All Users'; break;
        }

        $thisData['user'] = $data;
        $thisData['franchise_status'] = $franchise;
        $thisData['page_title'] = $page_title . ($franchise ? ' (Franchise)' : ' (Direct)');

        return view('Dashboard/Admin/Dashboard/users')->with('data', $thisData);
    }

    // public function edit(){
    //     return "test";
    // }

    public function show($id)
    {

        $user = User::find($id);
        $data['user'] = $user;
        $data['details'] = array();
        $data['details'] = UserDetails::where('user_id', $id)->first();

        // return $id;

        if (request()->isMethod('post')) {
            $requestData = request()->all();
            if (request()->input('form_name') == 'set_user') {
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

                $userDb = User::find($id);
                $userDb->name =  filter_var(request()->input('name'), FILTER_SANITIZE_STRING);
                if (request()->input('is_staff') == 0 || empty($role_id)) {
                    $userDb->roles =  'student';
                    $userDb->franchise_roles = null;
                } else {

                    if ($userDb->franchise_code) {
                        $userDb->roles              =  implode(',',request()->input('role'));
                        $userDb->franchise_roles    =  json_encode(request()->input('role'));
                    } else {
                        $userDb->isAdminAllowed = 1;
                        // $userDb->roles              =  json_encode(request()->input('role'));
                        $userDb->roles              =  implode(',',request()->input('role'));
                        $userDb->franchise_roles    =  null;
                    }
                }

                $userDetailsDB = UserDetails::where('user_id', $id)->first();
                if ($requestData['status'] !== $userDb['status']) {
                    $userDb->status = $requestData['status'];
                }
                $today = date('Y-m-d');
                if ($userDetailsDB) {
                    if ($requestData['days'] !== $userDetailsDB['days'] || intval($requestData['days']) > 0 && $today < $userDetailsDB['inactive_at']) {
                        $userDetailsDB->days = $requestData['days'];
                        $days = intval($requestData['days'] + 1);
                        $endDate = date('Y-m-d', strtotime('+' . $days . ' days'));
                        $userDetailsDB->started_at = $today;
                        $userDetailsDB->inactive_at = $endDate;
                        $userDetailsDB->allowed_to_upload = (isset($requestData['allowed_to_upload'])) ? $requestData['allowed_to_upload'] : 0;
                        $userDetailsDB->submit_content = (isset($requestData['submit_content'])) ? $requestData['submit_content'] : 0;
                        $userDetailsDB->allowed_to_package = (isset($requestData['allowed_to_package'])) ? $requestData['allowed_to_package'] : 0;
                        $userDetailsDB->add_package = (isset($requestData['add_package'])) ? $requestData['add_package'] : 0;
                        $userDetailsDB->education_type = (isset($requestData['education_type_id'])) ? $requestData['education_type_id'] : 0;
                        $userDetailsDB->class = (isset($requestData['class_group_exam_id'])) ? $requestData['class_group_exam_id'] : 0;
                        $userDetailsDB->save();
                    }
                }
                $userDetailsDB->education_type = (isset($requestData['education_type_id'])) ? $requestData['education_type_id'] : 0;
                $userDetailsDB->class = (isset($requestData['class_group_exam_id'])) ? $requestData['class_group_exam_id'] : 0;
                $userDetailsDB->save();
                if (request()->input('password')) {
                    $userDb->password =  Hash::make(request()->input('password'));
                }

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
                    $user_datails = [
                        'fullname' => $userDb->name,
                        'email_id' => $userDb->email,
                        'institute_code' => $userDb->franchise_code
                    ];

                     //send email to user in which account changes are done
                     $mailToSend = new NotifyUserAccountChanges($user_datails);
                     $sendMail = Mail::to($user->email)->send($mailToSend);
                    //return json_encode(true);
                     return response()->json(['success' => true]);
                }
                User::generateCounts();
                CorporateEnquiry::generateCounts();
                return response()->json(['success' => true]);
                //return json_encode(false);
            }
        }

        $data['manager'] = false;
        $data['creator'] = false;
        $data['publisher'] = false;
        $data['verifier'] = false;
        $data['reviewer'] = false;
        if ($user['roles'] && $user['is_staff'] == 1) {
            $roles = explode(',',$user['roles']);
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

         $todayDate = Carbon::today();
        if ($data['details']?->days) {
            $data['selectedDays'] = intval($data['details']->days);
            $data['remainingSubscription'] = 'Expires at ' . date('d-M-Y', strtotime($data['details']['started_at'] . ' + ' . $data['selectedDays'] . ' days'));
            $Subscriptionend = date('d-M-Y', strtotime($data['details']['started_at'] . ' + ' . $data['selectedDays'] . ' days'));

            if ($Subscriptionend > $todayDate->format('d-M-Y'))
            {
                $oneDayAfter = Carbon::createFromFormat('d-M-Y', $Subscriptionend)->addDay();
                $data['renewal_date'] = $oneDayAfter;
            }
            else
            {
                $data['renewal_date'] = $todayDate->format('d-M-Y');
            }
        }
        else
        {
            $data['renewal_date'] = $todayDate->format('d-M-Y');
        }

        // if ($data['details']->days) {
        //     $data['selectedDays'] = intval($data['details']->days);
        //     $data['remainingSubscription'] = 'Expires at '. date('d-M-Y', strtotime($data['started_at'] . ' + '.$data['selectedDays'].' days'));
        // }
        $data['education_type'] = intval($data['details']?->education_type);
        $data['class'] = intval($data['details']?->class);
        // dd($data,$data['user']);
        // return print_r($data);
        $gn_EduTypes      = Educationtype::get();
        $data['gn_EduTypes'] = $gn_EduTypes;

        $data['institute_code'] = DB::table('user_details')->where('user_id',$id)->first();
        $data['institute_name'] = DB::table('franchise_details')->where('branch_code',$data['institute_code']?->institute_code)->first();
        $data['class_name'] = DB::table('classes_groups_exams')->where('id',$data['institute_code']?->class)->first();
        $data['education_type_name'] = DB::table('education_type')->where('id',$data['institute_code']?->education_type)->first();
        // return $data;
        return view('Dashboard/Admin/Dashboard/user_view')->with('data', $data);
    }
    public function franchise($type = 'all')
    {
    }
    public function myPofile()
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
        return view('Dashboard/Admin/Settings/profile')->with('user', $user);
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user['is_franchise']) {
                $userDetails = FranchiseDetails::where('user_id', $id)->first();
                if ($userDetails) {
                    $franchiseEnquiry = CorporateEnquiry::find($userDetails['enquiry_id']);
                    $franchiseEnquiry->delete();
                    $userDetails->delete();
                }
            } else {
                $userDetails = UserDetails::where('user_id', $id)->first();
                if ($userDetails) {
                    $userDetails->delete();
                }
            }
            $user->delete();
            User::generateCounts();
            CorporateEnquiry::generateCounts();
        }
        return redirect()->back();
    }
    public function add()
    {
        $data = array();

        $time = date('Y-m-d');
        $time .= ' 00:00:00';
        $franchiseCodes = FranchiseDetails::select('id', 'branch_code', 'institute_name')->where('inactive_at', '>', $time)->get();
        // return print_r($franchiseCodes);

        if (request()->isMethod('post')) {
            $request = request()->all();
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
                $userDb             = new User();
                $userDetailsDb      = new UserDetails();

                $userDb->status     = $request['status'];
                $userDb->username   = $request['username'] != '' ? $request['username'] : NULL;
                $userDb->name       = $request['name'];
                $userDb->email      = $request['email'];
                $userDb->mobile     = $request['mobile'];

                $userDb->is_staff       =  1;
                $userDb->is_franchise   =  0;
                if ($request['institute_code'] == 'Direct') {
                    $userDb->in_franchise       =  0;
                    $userDb->franchise_code     =  NULL;
                } else {
                    $userDb->in_franchise           =  1;
                    $userDb->franchise_code         =  $request['institute_code'];
                    $userDetailsDb->institute_code  =  filter_var($request['institute_code']);
                    $userDb->franchise_roles        = json_encode($request['role']);
                }

                $userDb->password = Hash::make($request['password']);
                $userDb->roles = implode(',', $request['role']);
                // $userDb->save();
                if ($userDb->save()) {
                    $userDetailsDb->user_id =  $userDb->id;
                    if ($file = request()->file('user_logo')) {
                        $name                       = $file->hashName();
                        $userDetailsDb->photo_url   = request()->file('user_logo')->storeAs('student_uploads/' . $userDb->id, $name, 'public');
                    }
                    $userDetailsDb->save();
                    User::generateCounts();
                    return redirect()->route('administrator.user_show', [$userDb->id]);
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
        return view('Dashboard/Admin/Dashboard/user_add')->with('data', $data);
    }
}
