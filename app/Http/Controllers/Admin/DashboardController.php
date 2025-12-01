<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Count;
use App\Models\User;
use App\Models\CourseDetail;
use App\Models\Educationtype;
use App\Models\BoardAgencyStateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        User::generateCounts();
        $data = array();
        $countsData = Count::all();
        // $countsDataGrouped = [];
        // foreach ($countsData as $key => $value) {
        //     $category = $value['category'];
        //     $namekey = $value->toArray()['namekey'];
        //     $countsDataGrouped[$category][$namekey] = $value->toArray();
        //     $data[$namekey] = $value->toArray();
        // }
        foreach ($countsData as $value) {
            $data['cards'][] = $value->toArray();
        }
        // $countsDataGroupedSorted = [];
        // foreach ($countsDataGrouped as $key => $countsArray) {
        //     array_multisort(array_column($countsArray, 'box_index'), SORT_ASC, $countsArray);
        //     $countsDataGroupedSorted[$key] = $countsArray;
        //     $data[$key . '_counts'] = $countsArray;
        // }
        // return print_r($data);
        // return;
        // $data['cardsdata'] = array(
        //     [
        //         'color' => 'warning',
        //         'image' => '/images/icon/demo.png',
        //         'count' => $count = CorporateEnquiry::where('status', 'new')->count(),
        //         'countcolor' => 'danger',
        //         'title' => 'New business Enquiry',
        //         'action_required' => $count ? true : false,
        //         'url' => route('administrator.corporate_enquiry_type', 'new')
        //     ],
        //     [
        //         'color' => 'warning',
        //         'image' => '/images/icon/demo.png',
        //         'count' => $count = CorporateEnquiry::where('status', 'approved')->count(),
        //         'countcolor' => 'danger',
        //         'title' => 'Approved business Enquiry',
        //         'action_required' => $count ? true : false,
        //         'url' => route('administrator.corporate_enquiry_type', 'approved')
        //     ],
        //     [
        //         'color' => 'warning',
        //         'image' => '/images/icon/demo.png',
        //         'count' => $count = CorporateEnquiry::where('status', 'rejected')->count(),
        //         'countcolor' => 'danger',
        //         'title' => 'Rejected business Enquiry',
        //         'action_required' => $count ? true : false,
        //         'url' => route('administrator.corporate_enquiry_type', 'rejected')
        //     ]
        // );
        return view('Dashboard/Admin/Dashboard/index')->with('data', $data);
    }
    public function courseDetail()
    {

        $course_data= DB::table('classes_groups_exams')->get();
        $education_type= Educationtype::get();
        $board = BoardAgencyStateModel::get();

        return view('Dashboard.Admin.Dashboard.course-detail-add',compact('course_data','education_type','board'));

    }
    public function courseDetailStore(Request $request)
    {
        if ($request->isMethod('POST')) {
            // Validate the form data
            // $request->validate([
            //     'overview' => 'required',
            //     'course_name' => 'required',
            //     'scholarship_category' => 'required',
            // ]);
            $noti_img = '';
            $exam_img = '';
            $course_logo = '';

            if ($request->hasFile('notification_file')) {
                $file = $request->file('notification_file');
                $fileName = rand(11111, 999999) . '-' . $file->getClientOriginalName();
                $notificationFilePath = public_path('/uploads/notification_image');
                $file->move($notificationFilePath, $fileName);
                $noti_img = '/uploads/notification_image/'.$fileName;
            }
            if ($request->hasFile('exam_details_file')) {
                $file = $request->file('exam_details_file');
                $fileName = rand(11111, 999999) . '-' . $file->getClientOriginalName();
                $examDetailsFilePath = public_path('/uploads/exam_details');
                $file->move($examDetailsFilePath, $fileName);
                $exam_img = '/uploads/exam_details/'.$fileName;
            }
            if ($request->hasFile('course_logo')) {
                $file = $request->file('course_logo');
                $fileName = rand(11111, 999999) . '-' . $file->getClientOriginalName();
                $courseLogo = public_path('/uploads/course_logo');
                $file->move($courseLogo, $fileName);
                $course_logo = '/uploads/course_logo/'.$fileName;
            }

            $courseDetails = new CourseDetail();
            $courseDetails->description = $request->input('overview');
            $courseDetails->class_group_examp_id = $request->input('course_name');
            $courseDetails->course_short_name = $request->input('course_name');
            $courseDetails->course_full_name = $request->input('course_full_name');


            $courseDetails->registration = $request->input('registration');
            $courseDetails->exam_date = $request->input('exam_Date');
            $courseDetails->exam_mode = $request->input('exam_mode');

            $courseDetails->vacancies = $request->input('vacancies');
            $courseDetails->salary = $request->input('pay_scale');

            $courseDetails->eligibility = $request->input('eligibility');
            $courseDetails->official_site = $request->input('official_site');
            $courseDetails->notification_image = $noti_img;
            $courseDetails->exam_detail = $exam_img;
            $courseDetails->course_image = $course_logo;
            $courseDetails->education_id = $request->education_type;
            $courseDetails->board_id = $request->board;
            $courseDetails->required_A = $request->required_first;
            $courseDetails->required_B = $request->required_second;

            $courseDetails->save();

            return redirect()->route('administrator.course-detail-add')->with('success', 'Course details submitted successfully!');
        }

    }
    public function courseMasterList()
    {
        return view('Dashboard.admin.Dashboard.course-master-list');
    }
}
