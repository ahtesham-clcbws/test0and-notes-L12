<?php



namespace App\Http\Controllers\Frontend;



use App\Http\Controllers\Controller;

use App\Models\Gn_PackagePlan;

use App\Models\Educationtype;
use App\Models\Pdf;

use App\Models\{TestModal, Studymaterial, BooksModel, User};
use App\Notifications\ContactFormAdminNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller

{

    public function index()
    {

        $gn_EduTypes      = Educationtype::get();

        $gn_EduTest      = TestModal::get();



        $current_date = date('Y-m-d');


        //->where('class', 186)
        $Gn_PackagePlanGyanology = Gn_PackagePlan::where('is_featured', 1)->where('education_type', 54)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);
        $Gn_PackagePlanGyanology2 = Gn_PackagePlan::where('is_featured', 1)->where('education_type', 52)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);

        $StudymaterialGovComp = Studymaterial::where('study_material.is_featured', 1)
            ->whereIn('study_material.education_type', [51, 53, 54])
            ->whereNotIN('category', ["Static GK & Current Affairs"])
            ->orderBy('study_material.id', 'desc')
            ->limit(6)
            ->get(['study_material.*']);

        $StudymaterialGovComp2 = Studymaterial::where('study_material.is_featured', 1)
            ->where('category', "Static GK & Current Affairs")
            ->get(['study_material.*']);

        $StudymaterialGovComp3 = Studymaterial::where('study_material.is_featured', 1)
            ->whereIn('study_material.education_type', [52])
            ->where('category', "Study Notes & E-Books")
            ->get(['study_material.*']);

        $StudymaterialGovComp4 = Studymaterial::join('education_type', 'study_material.education_type', '=', 'education_type.id')
            ->join('classes_groups_exams', 'classes_groups_exams.id', '=', 'study_material.class')
            ->where('study_material.is_featured', 1)
            ->whereNotIN('study_material.education_type', [52])
            ->where('category', "Live & Video Classes")
            ->get(['study_material.*', 'education_type.name as education_type_name', 'classes_groups_exams.name as class_name']);

        $StudymaterialGovComp5 = Studymaterial::join('education_type', 'study_material.education_type', '=', 'education_type.id')
            ->join('classes_groups_exams', 'classes_groups_exams.id', '=', 'study_material.class')
            ->where('study_material.is_featured', 1)
            ->whereIN('study_material.education_type', [52])
            ->where('category', "Live & Video Classes")
            ->get(['study_material.*', 'education_type.name as education_type_name', 'classes_groups_exams.name as class_name']);

        //return $StudymaterialGovComp4;

        //return $StudymaterialGovComp;
        // ->leftJoin('classes_groups_exams', 'classes_groups_exams.id', '=', 'study_material.class')
        // ->leftJoin('gn__package_plans', 'gn__package_plans.id', '=', 'study_material.select_package')
        // ->get(['study_material.*', 'gn__package_plans.enrol_student_no']);

        $StudymaterialAffairs = Studymaterial::where('status', 1)->where('education_type', 53)->where('publish_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["study_material.*",]);

        //->where('expire_date', '>=' , $current_date)
        $Gn_PackagePackagelist = Gn_PackagePlan::where('status', 1)->where('education_type', 53)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);
        $Gn_PackagePlanInstitute = Gn_PackagePlan::where('status', 1)->where('education_type', 51)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);


        //    echo"<pre>"; print_r($Gn_PackagePlanGyanology); die;

        // $data = array();
        $data = DB::table('landing_page')->where('id', 1)->first();

        $result['banner_title_first'] = $data->banner_title_first;
        $result['banner_title_second'] = $data->banner_title_second;
        $result['banner_title_third'] = $data->banner_title_third;
        $result['banner_content'] = $data->banner_content;
        $result['competitive_courses_status'] = $data->competitive_courses_status;
        $result['range_of_courses_status'] = $data->range_of_courses_status;
        $result['banner_photo'] = $data->banner_photo;
        $result['banner_attr_image_1'] = $data->banner_attr_image_1;
        $result['banner_attr_image_2'] = $data->banner_attr_image_2;
        $result['banner_attr_image_3'] = $data->banner_attr_image_3;
        $result['slider_footer_image'] = $data->slider_footer_image;

        $data = DB::table('landing_page')->where('id', 2)->first();
        $result['subtitle1_first'] = $data->banner_title_first;
        $result['subtitle1_second'] = $data->banner_title_second;
        $result['subtitle1_third'] = $data->banner_title_third;
        $result['subtitle1_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 3)->first();
        $result['subtitle2_first'] = $data->banner_title_first;
        $result['subtitle2_second'] = $data->banner_title_second;
        $result['subtitle2_third'] = $data->banner_title_third;
        $result['subtitle2_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 4)->first();
        $result['subtitle3_first'] = $data->banner_title_first;
        $result['subtitle3_second'] = $data->banner_title_second;
        $result['subtitle3_third'] = $data->banner_title_third;
        $result['subtitle3_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 5)->first();
        $result['subtitle4_first'] = $data->banner_title_first;
        $result['subtitle4_second'] = $data->banner_title_second;
        $result['subtitle4_third'] = $data->banner_title_third;
        $result['subtitle4_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 6)->first();
        $result['subtitle5_first'] = $data->banner_title_first;
        $result['subtitle5_second'] = $data->banner_title_second;
        $result['subtitle5_third'] = $data->banner_title_third;
        $result['subtitle5_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 7)->first();
        $result['subtitle6_first'] = $data->banner_title_first;
        $result['subtitle6_second'] = $data->banner_title_second;
        $result['subtitle6_third'] = $data->banner_title_third;
        $result['subtitle6_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 8)->first();
        $result['subtitle7_first'] = $data->banner_title_first;
        $result['subtitle7_second'] = $data->banner_title_second;
        $result['subtitle7_third'] = $data->banner_title_third;
        $result['subtitle7_content'] = $data->banner_content;

        $data = DB::table('landing_page')->where('id', 9)->first();
        $result['subtitle8_first'] = $data->banner_title_first;
        $result['subtitle8_second'] = $data->banner_title_second;
        $result['subtitle8_third'] = $data->banner_title_third;
        $result['subtitle8_content'] = $data->banner_content;

        $pdf = Pdf::where('type', 'student')->orderBy('id', 'DESC')->first();
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();
        return view('Frontend/home', compact('classes_groups_exams', 'education_types', 'gn_EduTypes', 'gn_EduTest', 'Gn_PackagePlanGyanology', 'Gn_PackagePlanGyanology2', 'StudymaterialGovComp', 'StudymaterialGovComp2', 'StudymaterialGovComp3', 'StudymaterialGovComp4', 'StudymaterialGovComp5', 'Gn_PackagePackagelist', 'Gn_PackagePlanInstitute', 'result', 'pdf'));
    }

    public function page()
    {
        $pdf = Pdf::where('type', 'student')->orderBy('id', 'DESC')->first();
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();
        return view('Frontend/page', compact('education_types', 'classes_groups_exams', 'pdf'));
    }

    public function onlineTest()

    {

        return view('Frontend/online-test');
    }



    public function startTest()

    {



        return view('Frontend/start-test');
    }

    public function aboutUs()

    {



        return view('Frontend/about');
    }

    public function contactUs(Request $request)

    {
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();

        if ($request->input('contactSubmition')) {
            try {
                $admins = User::where('roles', 'superadmin')->get();
                Notification::send($admins, new ContactFormAdminNotify((object)$request->all()));
                // $notifyAdmins = $admins->notify(new ContactFormAdminNotify((object)$request->all()));
                return \response()->json([
                    "message" => "Your message has been sent successfully.",
                    "status" => "success",
                    "success" => true
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return \response()->json([
                    "message" => $th->getMessage(),
                    "status" => "failed",
                    "success" => false
                ]);
            }
        }

        return view('Frontend/contact', compact('education_types', 'classes_groups_exams'));
    }

    public function allTests()

    {

        return view('Frontend/test-list');
    }

    public function subscribePlan()

    {

        $gn_PackagePlan      = Gn_PackagePlan::select("gn__package_plans.id", "plan_name", "package_type", "duration", "final_fees", "gn__package_plans.status")->where("gn__package_plans.package_type", "=", 0)->where("gn__package_plans.status", "=", 1)->get();

        return view('Frontend/plans', compact('gn_PackagePlan'));
    }

    public function questionPaper()

    {


        return view('Frontend/question-paper');
    }
    public function pdfSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf_file' => 'required|mimes:pdf|max:2048',
            'title' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            // Return the first validation error message
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $title = $request->title;
        $type = $request->type;
        $pdf = $request->pdf_file;

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $title . rand(111, 999) . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('settingPdf', $fileName, 'public');
        }
        $storePdf = new Pdf();
        $storePdf->title = $title ?? "";
        $storePdf->type = $type ?? "";
        $storePdf->url = $path ?? "";
        if ($storePdf->save()) {
            return response()->json(['status' => true, 'message' => 'File uploaded successfully', 'path' => $path, 'data' => $storePdf]);
        } else {
            return response()->json(['status' => false, 'message' => 'something went wrong']);
        }
    }
    public function pdfDelete(Request $request)
    {

        if ($request->id) {
            $data =  Pdf::find($request->id);

            if ($data->delete()) {
                return response()->json(['status' => true, 'message' => 'file deleted success']);
            } else {
                return response()->json(['status' => false, 'message' => 'something went wrong']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'something went wrong']);
        }
    }
}
