<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotifyFranchiseAccountModify;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry as ModelsCorporateEnquiry;
use App\Models\FranchiseDetails;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CorporateEnquiry extends Controller
{
    public function index($type = 'all')
    {
        $data = array();
        if ($type == 'all') {
            $data = ModelsCorporateEnquiry::join('states', 'corporate_enquiries.state_id', '=', 'states.id')
                ->join('cities', 'corporate_enquiries.city_id', '=', 'cities.id')
                ->where('corporate_enquiries.status', '==', 'converted')
                ->orderByDesc('corporate_enquiries.id')
                ->get(['corporate_enquiries.id', 'corporate_enquiries.status', 'corporate_enquiries.photoUrl', 'corporate_enquiries.name', 'corporate_enquiries.institute_name', 'corporate_enquiries.email', 'corporate_enquiries.mobile', 'corporate_enquiries.established_year', 'corporate_enquiries.status', 'states.name as state_name', 'cities.name as city_name']);
        } else {
            $data = ModelsCorporateEnquiry::join('states', 'corporate_enquiries.state_id', '=', 'states.id')
                ->join('cities', 'corporate_enquiries.city_id', '=', 'cities.id')
                ->where('corporate_enquiries.status', $type)
                ->orderByDesc('corporate_enquiries.id')
                ->get(['corporate_enquiries.id', 'corporate_enquiries.status', 'corporate_enquiries.photoUrl', 'corporate_enquiries.name', 'corporate_enquiries.institute_name', 'corporate_enquiries.email', 'corporate_enquiries.mobile', 'corporate_enquiries.established_year', 'states.name as state_name', 'cities.name as city_name','corporate_enquiries.created_at','corporate_enquiries.branch_code']);
        }

        return view('Dashboard/Admin/Dashboard/corporate_enquiry')->with('data', $data);
    }

    public function show($id)
    {
        $data = ModelsCorporateEnquiry::join('states', 'corporate_enquiries.state_id', '=', 'states.id')
            ->join('cities', 'corporate_enquiries.city_id', '=', 'cities.id')
            ->select(['corporate_enquiries.*', 'states.name as state_name', 'cities.name as city_name'])
            ->find($id);
        $data['user'] = array();
        $data['details'] = array();
        if ($data['status'] == 'converted' || $data['status'] == 'activated' || $data['status'] == 'expired' || $data['status'] == 'banned') {
            $data['user'] = User::where('email', $data->email)->where('mobile', $data->mobile)->first();
            $data['details'] = FranchiseDetails::where('enquiry_id', $id)->first();
            $data['compitition_franchise'] = false;
            $data['academics_franchise'] = false;
            $data['school_franchise'] = false;
            $data['other_franchise'] = false;
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
            $data['franchise_manager'] = true;
            $data['franchise_creator'] = true;
            $data['franchise_publisher'] = true;
            $data['franchise_verifier'] = false;
            $data['franchise_reviewer'] = false;
            if ($data['user']->franchise_roles) {
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
            if ($data['details']->days) {
                $data['selectedDays'] = intval($data['details']->days);
            }
        }
        if (request()->isMethod('post')) {
            $returnResponse = ['success' => false, 'type' => 'danger', 'message' => 'Server Error XTB-256314'];
            if (request()->input('form_name') == 'set_franchise') {
                $requestData = request()->all();
                // return json_encode($requestData);

                $franchiseDetailsSave   = FranchiseDetails::where('enquiry_id', $id)->first();
                $franchiseSave          = User::find($data['user']['id']);
                $enquirySave            = ModelsCorporateEnquiry::find($id);

                $franchiseTypes = $requestData['type'];
                // $franchiseTypes = implode(',', $requestData['type']);
                $userRoles = $requestData['role'];

                $franchiseDetailsSave->franchise_types = implode(',', $franchiseTypes);
                $franchiseSave->franchise_roles = json_encode($userRoles);
                $franchiseSave->roles = 'franchise';

                $today = date('Y-m-d');
                if ($requestData['status'] !== $franchiseSave['status']) {
                    $franchiseSave->status = $requestData['status'];
                }

                if ($requestData['days'] !== $franchiseDetailsSave['days'] || intval($requestData['days']) > 0 && $today > $franchiseDetailsSave['inactive_at']) {
                    $franchiseDetailsSave->days = $requestData['days'];
                    $days                               = intval($requestData['days'] + 1);
                    $endDate                            = date('Y-m-d', strtotime('+' . $days . ' days'));
                    $franchiseDetailsSave->started_at   = $today;
                    $franchiseDetailsSave->inactive_at  = $endDate;
                    $enquirySave->status                = 'activated';
                    $enquirySave->save();
                    $franchiseSave->status              = 'active';
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

                $franchiseDetailsSave->submit_content = $requestData['submit_content'];
                $franchiseDetailsSave->add_package = $requestData['add_package'];
                $franchiseDetailsSave->allowed_to_package = $requestData['allowed_to_package'];

                if ($requestData['name'] !== $franchiseSave['name']) {
                    $franchiseSave->name = $requestData['name'];
                }

                if ($requestData['mobile'] !== $franchiseSave['mobile']) {
                    $franchiseSave->mobile = $requestData['mobile'];
                }

                if ($requestData['email'] !== $franchiseSave['email']) {
                    $franchiseSave->email = $requestData['email'];
                }

                if ($enquirySave->photoUrl !== $franchiseSave['photo_url']) {
                    $franchiseDetailsSave->photo_url = $enquirySave->photoUrl;
                }

                if ($requestData['password']) {
                    $franchiseSave->password = Hash::make($requestData['password']);
                }

                if (count($franchiseTypes) > 1) {
                    $franchiseDetailsSave->is_multiple = 1;
                }
                else {
                    $franchiseDetailsSave->is_multiple = 0;
                }

                if ($franchiseDetailsSave->save()) {
                    if ($franchiseSave->save()) {
                        $details = [
                            'institute_name' => $franchiseDetailsSave->institute_name,
                            'institute_code' => $franchiseDetailsSave->branch_code
                        ];
                        try {
                            $mailToSend = new NotifyFranchiseAccountModify($details);
                            Mail::to($requestData['email'])->send($mailToSend);

                            $returnResponse['success'] = true;
                            $returnResponse['type'] = 'success';
                            $returnResponse['message'] = 'Franchise account updated successfully.';
                        } catch (\Exception $e) {
                            $returnResponse['type'] = 'warning';
                            $returnResponse['message'] = 'Franchise details saved, but unable to send email: ' . $e->getMessage();
                        }

                        Log::build([
                            'driver' => 'single',
                            'path' => storage_path('logs/custom.log'),
                        ])->info('Institute account update by admin 7 '.$requestData['email']);

                    }
                    else {
                        $returnResponse['message'] = 'Franchise details not saved, please try again later';
                    }
                    User::generateCounts();
                    ModelsCorporateEnquiry::generateCounts();
                }
                else {
                    $returnResponse['message'] = 'Details not saved, please try again later';
                }
                return json_encode($returnResponse);
            }
        }
        // return print_r($data);
        return view('Dashboard/Admin/Dashboard/corporate_enquiry_view')->with('data', $data);
    }

    public function delete($id)
    {
        $enquiryUser = FranchiseDetails::where('enquiry_id', $id)->first();
        if (!$enquiryUser) {
            $enquiry = ModelsCorporateEnquiry::find($id);
            $enquiry->delete();
            User::generateCounts();
            ModelsCorporateEnquiry::generateCounts();
        }
        return redirect()->back();
    }
}
