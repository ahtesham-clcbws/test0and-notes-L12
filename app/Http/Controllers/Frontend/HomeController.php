<?php



namespace App\Http\Controllers\Frontend;



use App\Http\Controllers\Controller;

use App\Models\Gn_PackagePlan;

use App\Models\Pdf;

use App\Models\{Studymaterial, User};
use App\Notifications\ContactFormAdminNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller

{

    public function index()
    {

        $current_date = date('Y-m-d');


        //->where('class', 186)
        $Gn_PackagePlanGyanology = Gn_PackagePlan::with(['educationType', 'classType'])->where('is_featured', 1)->where('education_type', 54)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);
        $Gn_PackagePlanGyanology2 = Gn_PackagePlan::with(['educationType', 'classType'])->where('is_featured', 1)->where('education_type', 52)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);

        $StudymaterialGovComp = Studymaterial::with(['educationType', 'study_class'])->where('study_material.is_featured', 1)
            ->whereIn('study_material.education_type', [51, 53, 54])
            ->whereNotIN('category', ["Static GK & Current Affairs"])
            ->orderBy('study_material.id', 'desc')
            ->limit(6)
            ->get(['study_material.*']);

        $StudymaterialGovComp2 = Studymaterial::with(['educationType', 'study_class'])->where('study_material.is_featured', 1)
            ->where('category', "Static GK & Current Affairs")
            ->get(['study_material.*']);

        $StudymaterialGovComp3 = Studymaterial::with(['educationType', 'study_class'])->where('study_material.is_featured', 1)
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

        $StudymaterialAffairs = Studymaterial::with(['educationType', 'study_class'])->where('status', 1)->where('education_type', 53)->where('publish_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["study_material.*",]);

        //->where('expire_date', '>=' , $current_date)
        $Gn_PackagePackagelist = Gn_PackagePlan::with(['educationType', 'classType'])->where('status', 1)->where('education_type', 53)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);
        $Gn_PackagePlanInstitute = Gn_PackagePlan::with(['educationType', 'classType'])->where('status', 1)->where('education_type', 51)->where('expire_date', '>=', $current_date)->orderBy('id', 'desc')->limit(6)->get(["gn__package_plans.*", DB::raw("(gn__package_plans.duration + gn__package_plans.free_duration ) as total_duration")]);


        //    echo"<pre>"; print_r($Gn_PackagePlanGyanology); die;

        // Batch fetch landing page data
        $landingPages = DB::table('landing_page')->whereBetween('id', [1, 9])->get()->keyBy('id');

        // Helper to get landing page data safely
        $getLandingData = function($id) use ($landingPages) {
            return $landingPages->get($id) ?? (object)[
                'banner_title_first' => '', 'banner_title_second' => '', 'banner_title_third' => '', 'banner_content' => '',
                'competitive_courses_status' => 0, 'range_of_courses_status' => 0, 'banner_photo' => '',
                'banner_attr_image_1' => '', 'banner_attr_image_2' => '', 'banner_attr_image_3' => '', 'slider_footer_image' => ''
            ];
        };

        $data1 = $getLandingData(1);
        $result = [
            'banner_title_first' => $data1->banner_title_first,
            'banner_title_second' => $data1->banner_title_second,
            'banner_title_third' => $data1->banner_title_third,
            'banner_content' => $data1->banner_content,
            'competitive_courses_status' => $data1->competitive_courses_status,
            'range_of_courses_status' => $data1->range_of_courses_status,
            'banner_photo' => $data1->banner_photo,
            'banner_attr_image_1' => $data1->banner_attr_image_1,
            'banner_attr_image_2' => $data1->banner_attr_image_2,
            'banner_attr_image_3' => $data1->banner_attr_image_3,
            'slider_footer_image' => $data1->slider_footer_image,
        ];

        $data2 = $getLandingData(2);
        $result['subtitle1_first'] = $data2->banner_title_first;
        $result['subtitle1_second'] = $data2->banner_title_second;
        $result['subtitle1_third'] = $data2->banner_title_third;
        $result['subtitle1_content'] = $data2->banner_content;

        $data3 = $getLandingData(3);
        $result['subtitle2_first'] = $data3->banner_title_first;
        $result['subtitle2_second'] = $data3->banner_title_second;
        $result['subtitle2_third'] = $data3->banner_title_third;
        $result['subtitle2_content'] = $data3->banner_content;

        $data4 = $getLandingData(4);
        $result['subtitle3_first'] = $data4->banner_title_first;
        $result['subtitle3_second'] = $data4->banner_title_second;
        $result['subtitle3_third'] = $data4->banner_title_third;
        $result['subtitle3_content'] = $data4->banner_content;

        $data5 = $getLandingData(5);
        $result['subtitle4_first'] = $data5->banner_title_first;
        $result['subtitle4_second'] = $data5->banner_title_second;
        $result['subtitle4_third'] = $data5->banner_title_third;
        $result['subtitle4_content'] = $data5->banner_content;

        $data6 = $getLandingData(6);
        $result['subtitle5_first'] = $data6->banner_title_first;
        $result['subtitle5_second'] = $data6->banner_title_second;
        $result['subtitle5_third'] = $data6->banner_title_third;
        $result['subtitle5_content'] = $data6->banner_content;

        $data7 = $getLandingData(7);
        $result['subtitle6_first'] = $data7->banner_title_first;
        $result['subtitle6_second'] = $data7->banner_title_second;
        $result['subtitle6_third'] = $data7->banner_title_third;
        $result['subtitle6_content'] = $data7->banner_content;

        $data8 = $getLandingData(8);
        $result['subtitle7_first'] = $data8->banner_title_first;
        $result['subtitle7_second'] = $data8->banner_title_second;
        $result['subtitle7_third'] = $data8->banner_title_third;
        $result['subtitle7_content'] = $data8->banner_content;

        $data9 = $getLandingData(9);
        $result['subtitle8_first'] = $data9->banner_title_first;
        $result['subtitle8_second'] = $data9->banner_title_second;
        $result['subtitle8_third'] = $data9->banner_title_third;
        $result['subtitle8_content'] = $data9->banner_content;

        $pdf = Pdf::where('type', 'student')->orderBy('id', 'DESC')->first();
        return view('Frontend/home', compact('Gn_PackagePlanGyanology', 'Gn_PackagePlanGyanology2', 'StudymaterialGovComp', 'StudymaterialGovComp2', 'StudymaterialGovComp3', 'StudymaterialGovComp4', 'StudymaterialGovComp5', 'Gn_PackagePackagelist', 'Gn_PackagePlanInstitute', 'result', 'pdf'));
    }

    public function page()
    {
        $pdf = Pdf::where('type', 'student')->orderBy('id', 'DESC')->first();
        $education_types = DB::table('education_type')->get();
        return view('Frontend/page', compact('education_types', 'pdf'));
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
