<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry;
use App\Models\Studymaterial;
use App\Models\FranchiseDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FranchiseController extends Controller
{
    public function index($type = 'all', $franchise = false)
    {
        $data = array();
        $matchThis = ['in_franchise' => '0', 'isAdminAllowed' => '0'];
        if ($franchise) {
            $matchThis = ['in_franchise' => '1', 'isAdminAllowed' => '0'];
        }
        $data = User::where($matchThis);

        if ($type == 'new') {
            $data = $data->where('status', 'inactive')->get();
        }
        if ($type == 'students') {
            $data = $data->where('status', 'active')->where('roles', 'student')->get();
        }
        if ($type == 'managers' && !$franchise) {
            $data = $data->where('status', 'active')->where('roles', 'manager')->get();
        }
        if ($type == 'managers' && $franchise) {
            $data = $data->where('status', 'active')->where('franchise_roles', 'manager')->get();
        }
        if ($type == 'creators' && !$franchise) {
            $data = $data->where('status', 'active')->where('roles', 'creator')->get();
        }
        if ($type == 'creators' && $franchise) {
            $data = $data->where('status', 'active')->where('franchise_roles', 'creator')->get();
        }
        if ($type == 'publishers' && !$franchise) {
            $data = $data->where('status', 'active')->where('roles', 'publisher')->get();
        }
        if ($type == 'publishers' && $franchise) {
            $data = $data->where('status', 'active')->where('franchise_roles', 'publisher')->get();
        }
        if ($type == 'multi' && !$franchise) {
            $data = $data->where('status', 'active')->where('roles', 'publisher')->get();
        }
        if ($type == 'multi' && $franchise) {
            $data = $data->where('is_multiple', '1')->get();
        }

        return view('Dashboard/Admin/Dashboard/users')->with('data', $data);
    }
    public function byType($type)
    {
        $data = array();
        $users = array();

        if ($type == 'compitition') {
            $data = FranchiseDetails::where('franchise_types', 'like', '%compitition_franchise%')->where('is_multiple', 0)->get();
        }
        if ($type == 'academics') {
            $data = FranchiseDetails::where('franchise_types', 'like', '%academics_franchise%')->where('is_multiple', 0)->get();
        }
        if ($type == 'school') {
            $data = FranchiseDetails::where('franchise_types', 'like', '%school_franchise%')->where('is_multiple', 0)->get();
        }
        if ($type == 'other') {
            $data = FranchiseDetails::where('franchise_types', 'like', '%other_franchise%')->where('is_multiple', 0)->get();
        }
        if ($type == 'multi') {
            $data = FranchiseDetails::where('is_multiple', 1)->get();
        }
        // return $data->pluck('user_id');
        // foreach ($data as $key => $franchise) {
        //     $users = User::find($franchise['user_id']);
        //     $users[] = $user;
        // }
            $users = User::wherein('id',$data->pluck('user_id'))->get();
            // return $users;

        return view('Dashboard/Admin/Dashboard/franchises')->with('data', $users);
    }
    public function show($userID)
    {
        $franchiseUserData = FranchiseDetails::where('user_id', $userID)->first();
        $id = $franchiseUserData['enquiry_id'];
        $data = CorporateEnquiry::join('states', 'corporate_enquiries.state_id', '=', 'states.id')
            ->join('cities', 'corporate_enquiries.city_id', '=', 'cities.id')
            ->select(['corporate_enquiries.*', 'states.name as state_name', 'cities.name as city_name'])
            ->find($id);

        $data['user']       = array();
        $data['details']    = array();
        if ($data['status'] == 'converted' || $data['status'] == 'activated' || $data['status'] == 'expired' || $data['status'] == 'banned') {
            $data['user']                   = User::where('email', $data['email'])->where('mobile', $data['mobile'])->first();
            $data['details']                = FranchiseDetails::where('enquiry_id', $id)->first();
            $data['compitition_franchise']  = false;
            $data['academics_franchise']    = false;
            $data['school_franchise']       = false;
            $data['other_franchise']        = false;
            if ($data['details']->franchise_types) {
                // $franchise_types = json_decode($data['details']->franchise_types);
                $franchise_types = explode(',', $data['details']->franchise_types);
                if ($franchise_types == 'compitition_franchise' || in_array('compitition_franchise', $franchise_types)) {
                    $data['compitition_franchise'] = true;
                } else {
                    $data['compitition_franchise'] = false;
                }

                if ($franchise_types == 'academics_franchise' || in_array('academics_franchise', $franchise_types)) {
                    $data['academics_franchise'] = true;
                } else {
                    $data['academics_franchise'] = false;
                }

                if ($franchise_types == 'school_franchise' || in_array('school_franchise', $franchise_types)) {
                    $data['school_franchise'] = true;
                } else {
                    $data['school_franchise'] = false;
                }

                if ($franchise_types == 'other_franchise' || in_array('other_franchise', $franchise_types)) {
                    $data['other_franchise'] = true;
                } else {
                    $data['other_franchise'] = false;
                }
            }
            $data['franchise_manager']      = true;
            $data['franchise_creator']      = true;
            $data['franchise_publisher']    = true;
            $data['franchise_verifier']     = false;
            $data['franchise_reviewer']     = false;
            if (isset($data['user']) && $data['user']->franchise_roles) {
                $roles = $data['user']->franchise_roles;
                // $roles = json_decode($data['user']->roles);
                if (strpos($roles, 'franchise_manager') !== false) {
                    $data['franchise_manager'] = true;
                } else {
                    $data['franchise_manager'] = false;
                }
                if (strpos($roles, 'franchise_creator') !== false) {
                    $data['franchise_creator'] = true;
                } else {
                    $data['franchise_creator'] = false;
                }
                if (strpos($roles, 'franchise_publisher') !== false) {
                    $data['franchise_publisher'] = true;
                } else {
                    $data['franchise_publisher'] = false;
                }
                if (strpos($roles, 'franchise_verifier') !== false) {
                    $data['franchise_verifier'] = true;
                } else {
                    $data['franchise_verifier'] = false;
                }
                if (strpos($roles, 'franchise_reviewer') !== false) {
                    $data['franchise_reviewer'] = true;
                } else {
                    $data['franchise_reviewer'] = false;
                }
            }
            $data['selectedDays'] = 7;
            $data['remainingSubscription'] = 'No Subscription';
            if ($data['details']->days) {
                $data['selectedDays'] = intval($data['details']->days);
                $data['remainingSubscription'] = 'Expires at ' . date('d-M-Y', strtotime($data['started_at'] . ' + ' . $data['selectedDays'] . ' days'));
            }

        }
        if (request()->isMethod('post')) {
            $returnResponse = ['success' => false, 'type' => 'danger', 'message' => 'Server Error XTB-256314'];
            if (request()->input('form_name') == 'set_franchise') {
                $requestData = request()->all();
                // return json_encode($requestData);
                $franchiseDetailsSave = FranchiseDetails::where('enquiry_id', $id)->first();
                $franchiseSave = User::find($data['user']['id']);
                $enquirySave = CorporateEnquiry::find($id);

                $franchiseTypes = $requestData['type'];
                // $franchiseTypes = implode(',', $requestData['type']);
                $userRoles = $requestData['role'];

                $franchiseDetailsSave->franchise_types  = implode(',', $franchiseTypes);
                $franchiseSave->franchise_roles         = json_encode($userRoles);
                $franchiseSave->roles                   = 'franchise';

                $today = date('Y-m-d');
                if ($requestData['status'] !== $franchiseSave['status']) {
                    $franchiseSave->status = $requestData['status'];
                }
                if ($requestData['days'] !== $franchiseDetailsSave['days'] || intval($requestData['days']) > 0 && $today < $franchiseDetailsSave['inactive_at']) {
                    $franchiseDetailsSave->days         = $requestData['days'];
                    $days                               = intval($requestData['days'] + 1);
                    $endDate                            = date('Y-m-d', strtotime('+' . $days . ' days'));
                    $franchiseDetailsSave->started_at   = $today;
                    $franchiseDetailsSave->inactive_at  = $endDate;
                    $enquirySave->status                = 'activated';
                    $enquirySave->save();
                    $franchiseSave->status              = $requestData['status']; //'active';
                }
                if ($requestData['institute_name'] !== $franchiseDetailsSave['institute_name']) {
                    $franchiseDetailsSave->institute_name = $requestData['institute_name'];
                }
                if ($requestData['branch_code'] !== $franchiseDetailsSave['branch_code']) {
                    $franchiseDetailsSave->branch_code = $requestData['branch_code'];
                }
                if ($requestData['allowed_to_upload'] !== $franchiseDetailsSave['allowed_to_upload']) {
                    $franchiseDetailsSave->allowed_to_upload = $requestData['allowed_to_upload'];
                }

                if ($requestData['name'] !== $franchiseSave['name']) {
                    $franchiseSave->name = $requestData['name'];
                }
                if ($requestData['mobile'] !== $franchiseSave['mobile']) {
                    $franchiseSave->mobile = $requestData['mobile'];
                }
                if ($requestData['email'] !== $franchiseSave['email']) {
                    $franchiseSave->email = $requestData['email'];
                }

                if ($data->photoUrl !== $franchiseDetailsSave['photo_url']) {
                    $franchiseDetailsSave->photo_url = $data->photoUrl;
                }

                if ($requestData['password']) {
                    $franchiseSave->password = Hash::make($requestData['password']);
                }

                $franchiseDetailsSave->allowed_to_upload = $requestData['allowed_to_upload'];

                $franchiseDetailsSave->submit_content = $requestData['submit_content'];
                $franchiseDetailsSave->add_package = $requestData['add_package'];
                $franchiseDetailsSave->allowed_to_package = $requestData['allowed_to_package'];


                if (count($franchiseTypes) > 1) {
                    $franchiseDetailsSave->is_multiple = 1;
                } else {
                    $franchiseDetailsSave->is_multiple = 0;
                }

                // return json_encode($franchiseDetailsSave);

                if ($franchiseDetailsSave->save()) {
                    if ($franchiseSave->save()) {
                        /*
                        $details = [
                            'fullname' => $requestData['name'],
                            'typeMessage' => 'Account updated.',
                            'message' => 'We are glad to inform you that your business request is approved by our Authorisation Team.<br>We alloted a unique code for your institute which is required to sign up / registration process.<br>www.thegyanology.com<br>Your institute code is : XXXXXXXXXXX123<br>Please sign up with this unique code.'
                        ];
                        $mailToSend = new sendFranchiseEmail($details);
                        $sendMail = Mail::to($requestData['email'])->send($mailToSend);
                        if (count(Mail::failures()) > 0) {
                            $returnResponse['type'] = 'warning';
                            $returnResponse['message'] = 'Franchise details saved, but unable to send email.';
                        } else {
                            $returnResponse['success'] = true;
                            $returnResponse['type'] = 'success';
                            $returnResponse['message'] = 'Franchise account updated successfully.';
                        }
                        */
                        $returnResponse['success'] = true;
                        $returnResponse['type'] = 'success';
                        $returnResponse['message'] = 'Franchise account updated successfully.';
                    } else {
                        $returnResponse['message'] = 'Franchise details not saved, please try again later';
                    }
                    User::generateCounts();
                    CorporateEnquiry::generateCounts();
                } else {
                    $returnResponse['message'] = 'Details not saved, please try again later';
                }
                return json_encode($returnResponse);
            }
            // if (request()->input('form_name') == 'set_franchise') {
            //     $requestData = request()->all();
            //     // return json_encode($requestData);

            //     $franchiseDetailsSave = FranchiseDetails::where('enquiry_id', $id)->first();
            //     $franchiseSave = User::find($data['user']['id']);
            //     $enquirySave = CorporateEnquiry::find($id);

            //     $franchiseTypes = $requestData['type'];
            //     $userRoles = $requestData['role'];

            //     $franchiseSave->franchise_roles = json_encode($userRoles);
            //     $franchiseSave->roles = json_encode($userRoles);

            //     $today = date('Y-m-d');
            //     // $franchiseSave->status = $requestData['status'];
            //     if ($requestData['status'] !== $franchiseSave['status']) {
            //         $franchiseSave->status = $requestData['status'];
            //     }
            //     if ($requestData['days'] !== $franchiseDetailsSave['days'] || intval($requestData['days']) > 0 && $today > $franchiseDetailsSave['inactive_at']) {
            //         $franchiseDetailsSave->days = $requestData['days'];
            //         $days = intval($requestData['days'] + 1);
            //         $endDate = date('Y-m-d', strtotime('+' . $days . ' days'));
            //         $franchiseDetailsSave->started_at = $today;
            //         $franchiseDetailsSave->inactive_at = $endDate;
            //         $enquirySave->status = 'activated';
            //         $enquirySave->save();
            //         $franchiseSave->status = 'active';
            //     }
            //     if ($requestData['institute_name'] !== $franchiseDetailsSave['institute_name']) {
            //         $franchiseDetailsSave->institute_name = $requestData['institute_name'];
            //     }
            //     if ($requestData['branch_code'] !== $franchiseDetailsSave['branch_code']) {
            //         $franchiseDetailsSave->branch_code = $requestData['branch_code'];
            //     }
            //     if ($requestData['allowed_to_upload'] !== $franchiseDetailsSave['allowed_to_upload']) {
            //         $franchiseDetailsSave->allowed_to_upload = $requestData['allowed_to_upload'];
            //     }

            //     if ($requestData['name'] !== $franchiseSave['name']) {
            //         $franchiseSave->name = $requestData['name'];
            //     }
            //     if ($requestData['mobile'] !== $franchiseSave['mobile']) {
            //         $franchiseSave->mobile = $requestData['mobile'];
            //     }
            //     if ($requestData['email'] !== $franchiseSave['email']) {
            //         $franchiseSave->email = $requestData['email'];
            //     }
            //     if ($requestData['password']) {
            //         $franchiseSave->password = Hash::make($requestData['password']);
            //     }

            //     if (count($franchiseTypes) > 1) {
            //         $franchiseDetailsSave->is_multiple = 1;
            //     } else {
            //         $franchiseDetailsSave->is_multiple = 0;
            //         $ttttt = str_replace('"', '', $franchiseTypes[0]);
            //         $franchiseDetailsSave->franchise_types = $ttttt;
            //     }

            //     if ($franchiseDetailsSave->save()) {
            //         if ($franchiseSave->save()) {
            //             $details = [
            //                 'fullname' => $requestData['name'],
            //                 'typeMessage' => 'Account updated.',
            //                 'message' => 'Your account has been updated successfully by administration.'
            //             ];
            //             $mailToSend = new sendFranchiseEmail($details);
            //             $sendMail = Mail::to($requestData['email'])->send($mailToSend);
            //             if ($sendMail) {
            //                 $returnResponse['success'] = true;
            //                 $returnResponse['type'] = 'success';
            //                 $returnResponse['message'] = 'Franchise account updated successfully.';
            //             } else {
            //                 $returnResponse['success'] = true;
            //                 $returnResponse['type'] = 'warning';
            //                 $returnResponse['message'] = 'Franchise details saved, but unable to send email.';
            //             }
            //         } else {
            //             $returnResponse['message'] = 'Franchise details not saved, please try again later';
            //         }
            //         User::generateCounts();
            //         CorporateEnquiry::generateCounts();
            //     } else {
            //         $returnResponse['message'] = 'Details not saved, please try again later';
            //     }
            //     return json_encode($returnResponse);
            // }
        }
        // return print_r($data);
        return view('Dashboard/Admin/Dashboard/franchise_update')->with('data', $data);
    }
    public function delete($id)
    {
        $franchiseUser = User::find($id);
        if ($franchiseUser) {
            $franchiseDetails = FranchiseDetails::where('user_id', $id)->first();
            if ($franchiseDetails) {
                $franchiseEnquiry = CorporateEnquiry::find($franchiseDetails['enquiry_id']);
                $franchiseEnquiry->delete();
                $franchiseDetails->delete();
            }
            $franchiseUser->delete();
            User::generateCounts();
            CorporateEnquiry::generateCounts();
        }
        return redirect()->back();
    }

    public function viewusers($id){

       $data = array();
        // $id = auth()->id();
        $myDetails = FranchiseDetails::where('user_id', $id)->first();
        $branchCode = $myDetails->branch_code;

        $matchThis = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0'];

        $data['new'] = User::where($matchThis)->where('status', 'unread')->orWhere('status','inactive')->get();
        $data['students'] = User::where($matchThis)->where('status', 'active')->where('roles', 'student')->get();
        $data['managers'] = User::where($matchThis)->where('status', 'active')->where('roles', 'manager')->get();
        $data['creators'] = User::where($matchThis)->where('status', 'active')->where('roles', 'creator')->get();
        $data['publishers'] = User::where($matchThis)->where('status', 'active')->where('roles', 'publisher')->get();
        $data['multi'] = User::where($matchThis)->where('status', 'active')->where('roles','like','%,%')->get();

        // return $data['new'];

        return view('Dashboard/Admin/Dashboard/institute_user_view',$data);
    }

    public function viewstudentusers($id){

    //   return $type;
       $data = array();
        // $id = auth()->id();
        $myDetails = FranchiseDetails::where('user_id', $id)->first();
        $branchCode = $myDetails->branch_code;

        $matchThis = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0'];
        $data['students'] =
        User::leftjoin('user_details','users.id','=','user_details.user_id')
        ->leftjoin('education_type','user_details.education_type','=','education_type.id')
        ->leftjoin('classes_groups_exams','user_details.class','=','classes_groups_exams.id')
        ->leftjoin('franchise_details','user_details.institute_code','=','franchise_details.branch_code')
        ->select('users.*','education_type.name as education_type_name','classes_groups_exams.name as class_name','user_details.institute_code','franchise_details.institute_name' )
        ->where($matchThis)
        ->where('status', 'active')
        ->where('roles', 'student')
        ->get();

        // return $data['students'];

        return view('Dashboard/Admin/Dashboard/institute_studentuser_view',$data);
    }

    public function viewmaterial($id){

         $is_admin=$is_franchies=$is_staff='';
        if(Auth::user()->roles == 'superadmin')
            $is_admin = Auth::user()->isAdminAllowed;
        if(Auth::user()->roles == 'franchise')
            $is_franchies = Auth::user()->is_franchise;
        if(Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher')
            $is_staff = Auth::user()->is_staff;

        // return auth()->user()->id;
            $data['study_material']      = Studymaterial::select("study_material.id","title","sub_title","is_featured","institute_id","publish_status","publish_date","document_type","created_by","file","video_link","category","users.name as name","classes_groups_exams.name as class_group")
                        ->leftJoin("users","users.id","study_material.created_by")
                        ->leftJoin("classes_groups_exams","classes_groups_exams.id","study_material.class")
                        ->leftJoin("franchise_details","franchise_details.id","study_material.institute_id")
                        ->where("study_material.publish_by",$id)
                        ->where("study_material.status",1)
                        ->orderBy('study_material.id', 'desc')
                        ->get();
                        // return $model;
             return view('Dashboard/Admin/Dashboard/institute_view_material',$data);
    }
}
