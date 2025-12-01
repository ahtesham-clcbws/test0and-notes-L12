<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InstituteApproveEmail;
use App\Mail\InstituteRejectedEmail;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry;
use App\Models\CorporateEnquiryReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AjaxController extends Controller
{
    public function franchiseRequest()
    {
        $admin = Auth::user();
        $adminRoles = explode(',', $admin['roles']);
        $response = ['success' => true, 'message' => 'Corporate Enquiry Approved Successfully.'];
        if ($admin['isAdminAllowed'] && in_array('superadmin', $adminRoles)) {
            $requestedData = request()->all();
            // return json_encode($requestedData);
            $typeMessage = 'Bussiness Enquiry';
            if ($requestedData['type'] == 'approved') {
                $typeMessage = 'Your application has been approved succesfully.';
            }
            if ($requestedData['type'] == 'reject') {
                $typeMessage = 'Your application has been rejected.';
            }
            // $details = [
            //     'fullname' => $requestedData['name'],
            //     'typeMessage' => $typeMessage,
            //     'message' => $requestedData['message']
            // ];
            // $mailToSend = new sendFranchiseEmail($details);
            // $sendMail = Mail::to($requestedData['email'])->send($mailToSend);
            // if (count(Mail::failures()) > 0) return json_encode($response);

            $enquiryReply = new CorporateEnquiryReply;
            $enquiryReply->corporate_enquiry_id = $requestedData['id'];
            $enquiryReply->message = $typeMessage . ' <br>' . $requestedData['message'];
            $enquiryReply->type = $requestedData['type'];
            $enquiryReply->user_id = $admin['id'];
            $queryResponse = $enquiryReply->save();
            if ($requestedData['type'] != 'reply') {
                $updateStatus = $requestedData['type'];
                if ($updateStatus == 'approved') {
                    $updateStatus = 'approved';
                }
                if ($updateStatus == 'reject') {
                    $updateStatus = 'rejected';
                }
                if ($updateStatus == 'pending') {
                    $updateStatus = 'pending';
                }
                $enquiryUpdate = CorporateEnquiry::find($requestedData['id']);
                $enquiryUpdate->status = $updateStatus;
                $enquiryUpdate->user_id = $admin['id'];
                $queryResponse = $enquiryUpdate->save();
            }
            if ($queryResponse) {
                CorporateEnquiry::generateCounts();

                $emailSend = '';
                $emailType = '';

                $enquiryData = CorporateEnquiry::find($requestedData['id']);

                $details = [
                    'institute_name' => $enquiryData->institute_name,
                    'institute_code' => $enquiryData->branch_code
                ];
                if ($requestedData['type'] == 'approved') {
                    $mailToSend = new InstituteApproveEmail($details);
                    Mail::to($enquiryData['email'])->send($mailToSend);
                    $emailSend = Mail::failures();
                    $emailType = 'Approval';
                }
                if ($requestedData['type'] == 'reject') {
                    $mailToSend = new InstituteRejectedEmail($details);
                    Mail::to($enquiryData['email'])->send($mailToSend);
                    $emailSend = Mail::failures();
                    $emailType = 'Rejection';
                }

                $response['emailSend'] = $emailSend;
                $response['emailType'] = $emailType;

                return json_encode($response);
            } else {
                $response['success'] = false;
                $response['message'] = 'You are not authorized.';
                return json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'You are not authorized.';
            return json_encode($response);
        }
    }
}
