<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\sendFranchiseEmail;
use App\Models\CorporateEnquiry;
use App\Models\PasswordResetModel;
use App\Models\User;
use App\Models\FranchiseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FormsController extends Controller
{
    public function businessEnquiry(Request $request)
    {
        if($request->post()) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'institute_name' => 'required|string|max:255',
                'institute_type' => 'required|array',
                'interested_for' => 'required|array',
                'established_year' => 'required|integer',
                'email' => 'required|email',
                'contact_mobile' => 'required|numeric',
                'mobile_corporate_otp_new' => 'required|numeric',
                'state_id' => 'required|integer',
                'city_id' => 'required|integer',
                'pincode' => 'required|integer',
                'corporate_logo' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
            ]);

            $corporateDb = new CorporateEnquiry();
            $corporateDb->name = $validatedData['name'];
            $corporateDb->institute_name = $validatedData['institute_name'];
            $corporateDb->type_of_institution = json_encode($validatedData['institute_type']);
            $corporateDb->interested_for = json_encode($validatedData['interested_for']);
            $corporateDb->established_year = $validatedData['established_year'];
            $corporateDb->email = $validatedData['email'];
            $corporateDb->mobile = $validatedData['contact_mobile'];
            $corporateDb->otp = $validatedData['mobile_corporate_otp_new'];
            $corporateDb->state_id = $validatedData['state_id'];
            $corporateDb->city_id = $validatedData['city_id'];
            $corporateDb->pincode = $validatedData['pincode'];
            $corporateDb->branch_code = generateBranchCode($validatedData['institute_name']);

            if ($request->hasFile('corporate_logo')) {
                $file = $request->file('corporate_logo');
                $name = $file->hashName();
                $corporateDb->photoUrl = $file->storeAs('institute', $name, 'public');
            }

            $query = $corporateDb->save();
            if ($query) {
                if ($validatedData['email']) {
                    $details = [
                        'fullname' => $validatedData['name'],
                        'typeMessage' => 'Account updated.',
                        'message' => 'You are successfully registered.'
                    ];
                    // $sendMail = Mail::to($validatedData['email'])->send(new sendFranchiseEmail($details));
                }
                CorporateEnquiry::generateCounts();
                return response()->json(true);
            }
            return response()->json(false);
        }
        $data = array();
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();

        return view('Frontend/bussiness-enquiry',compact('education_types','classes_groups_exams'))->with('data', $data);
    }
    public function instituteUser(Request $req)
    {
        $data = array();
        $time = date('Y-m-d');
        $time .= '00:00:00';
        $franchiseCodes = FranchiseDetails::select('id', 'branch_code', 'institute_name')->where('inactive_at', '>', $time)->get();
        $data['franchiseCodes'] = $franchiseCodes;
        return view('Frontend/institute-user')->with('data', $data);
    }
    public function instituteSignup()
    {
         $data = array();
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();
        return view('Frontend/institute-signup',compact('education_types','classes_groups_exams'))->with('data', $data);
    }
    public function contactUs()
    {
    }
    public function userRegistration()
    {
    }
    public function userLogin()
    {
    }
    public function studentPasswordReset($studentid, $resetid)
    {
        $data = array();
        $typeOfRequest = 'forget';
        $resetData = PasswordResetModel::where('id', $resetid)->where('status', '0')->first();

        if ($resetData) {
            $studentData = User::where('id', $studentid)->where('roles', 'student')->first();
            // $studentData = User::find($studentid);
            if ($resetData['user_id'] == $studentid && $studentData) {
                $typeOfRequest = 'reset';
                $data['reset'] = $resetData;
                $data['student'] = $studentData;
            }
        }

        $data['typeOfRequest'] = $typeOfRequest;
        return view('Frontend/student-reset-password')->with('data', $data);
    }
}
