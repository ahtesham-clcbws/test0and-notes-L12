<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardAgencyStateModel;
use App\Models\CourseDetail;
use App\Models\Educationtype;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $counts = [];

        // 1. New Business Enquiry
        $counts['new_business_enquiry'] = \App\Models\CorporateEnquiry::where('status', 'new')->count();

        // 2. Approved Business Enquiry
        $counts['approved_business_enquiry'] = \App\Models\CorporateEnquiry::where('status', 'approved')->count();

        // 3. Pending Business Enquiry (Rejected)
        $counts['pending_business_enquiry'] = \App\Models\CorporateEnquiry::where('status', 'rejected')->count();

        // 4. Franchise Discontinue
        // FranchiseDetails has no status column. Using CorporateEnquiry status 'discontinue' or similar if exists.
        // If 'discontinue' is not a valid status, this will return 0 but not error.
        $counts['franchise_discontinue'] = \App\Models\CorporateEnquiry::where('status', 'discontinue')->count();

        // 5. Student Left Direct Portal (Assumed status 'left', in_franchise = 0)
        $counts['student_left_direct'] = \App\Models\User::where('status', 'left')->where('in_franchise', 0)->count();

        // 6. Contact Forms (This Month) - Using full namespace if needed, assuming App\Models or App\NewModels
        // logic below uses Carbon
        $counts['contact_forms_month'] = \App\Models\NewModels\ContactQuery::whereMonth('created_at', \Carbon\Carbon::now()->month)->count();

        // 7. New Corporate Sign Up (converted)
        $counts['new_corporate_signup'] = \App\Models\CorporateEnquiry::where('status', 'converted')->count();

        // 8. Competition Franchise
        // Column is 'franchise_types' (plural) and value suffix is '_franchise'
        // Join with users to ensure user exists (handling soft deletes or orphans)
        $counts['competition_franchise'] = \App\Models\FranchiseDetails::join('users', function ($join) {
            $join->on('franchise_details.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
        })
            ->where('franchise_types', 'like', '%compitition_franchise%')
            ->where('is_multiple', 0)
            ->count();

        // 9. Academics Franchise
        $counts['academics_franchise'] = \App\Models\FranchiseDetails::join('users', function ($join) {
            $join->on('franchise_details.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
        })
            ->where('franchise_types', 'like', '%academics_franchise%')
            ->where('is_multiple', 0)
            ->count();

        // 10. School Franchise
        $counts['school_franchise'] = \App\Models\FranchiseDetails::join('users', function ($join) {
            $join->on('franchise_details.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
        })
            ->where('franchise_types', 'like', '%school_franchise%')
            ->where('is_multiple', 0)
            ->count();

        // 11. Other Franchise
        $counts['other_franchise'] = \App\Models\FranchiseDetails::join('users', function ($join) {
            $join->on('franchise_details.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
        })
            ->where('franchise_types', 'like', '%other_franchise%')
            ->where('is_multiple', 0)
            ->count();

        // 12. Multi Franchise
        $counts['multi_franchise'] = \App\Models\FranchiseDetails::join('users', function ($join) {
            $join->on('franchise_details.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at');
        })
            ->where('is_multiple', 1)
            ->count();

        // 13. New User Sign Up (Franchise)
        $counts['new_user_signup_franchise'] = \App\Models\User::where(function ($q) {
            $q->where('status', 'inactive')->orWhere('status', 'unread');
        })->where('in_franchise', 1)->where('isAdminAllowed', 0)->count();

        // 14. Students (Franchise) - UsersController does not check is_staff for students
        $counts['students_franchise'] = \App\Models\User::where('roles', 'student')->where('in_franchise', 1)->where('isAdminAllowed', 0)->count();

        // 15. Managers (Franchise)
        $counts['managers_franchise'] = \App\Models\User::where('roles', 'manager')->where('in_franchise', 1)->where('is_staff', 1)->where('isAdminAllowed', 0)->count();

        // 16. Creators (Franchise)
        $counts['creators_franchise'] = \App\Models\User::where('roles', 'creator')->where('in_franchise', 1)->where('is_staff', 1)->where('isAdminAllowed', 0)->count();

        // 17. Publishers (Franchise)
        $counts['publishers_franchise'] = \App\Models\User::where('roles', 'publisher')->where('in_franchise', 1)->where('is_staff', 1)->where('isAdminAllowed', 0)->count();

        // 18. Multi Role (Franchise)
        $counts['multi_role_franchise'] = \App\Models\User::where('roles', 'like', '%,%')->where('in_franchise', 1)->where('is_staff', 1)->where('isAdminAllowed', 0)->count();

        // 19. New User Sign Up (Direct)
        $counts['new_user_signup_direct'] = \App\Models\User::where(function ($q) {
            $q->where('status', 'inactive')->orWhere('status', 'unread');
        })->where('in_franchise', 0)->count();

        // 20. Students (Direct)
        $counts['students_direct'] = \App\Models\User::where('roles', 'student')->where('in_franchise', 0)->count();

        // 21. Managers (Direct)
        $counts['managers_direct'] = \App\Models\User::where('roles', 'manager')->where('in_franchise', 0)->where('is_staff', 1)->count();

        // 22. Creators (Direct)
        $counts['creators_direct'] = \App\Models\User::where('roles', 'creator')->where('in_franchise', 0)->where('is_staff', 1)->count();

        // 23. Publishers (Direct)
        $counts['publishers_direct'] = \App\Models\User::where('roles', 'publisher')->where('in_franchise', 0)->where('is_staff', 1)->count();

        // 24. Multi Role (Direct)
        $counts['multi_role_direct'] = \App\Models\User::where('roles', 'like', '%,%')->where('in_franchise', 0)->where('is_staff', 1)->count();

        $data['counts'] = $counts;

        return view('Dashboard/Admin/Dashboard/index')->with('data', $data);
    }

    public function courseDetail()
    {

        $course_data = DB::table('classes_groups_exams')->get();
        $education_type = Educationtype::get();
        $board = BoardAgencyStateModel::get();

        return view('Dashboard.Admin.Dashboard.course-detail-add', compact('course_data', 'education_type', 'board'));

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
                $noti_img = $this->imageService->handleUpload($request->file('notification_file'), 'uploads/notification_image', 1000);
            }
            if ($request->hasFile('exam_details_file')) {
                $exam_img = $this->imageService->handleUpload($request->file('exam_details_file'), 'uploads/exam_details', 1000);
            }
            if ($request->hasFile('course_logo')) {
                $course_logo = $this->imageService->handleUpload($request->file('course_logo'), 'uploads/course_logo', 500);
            }

            $courseDetails = new CourseDetail;
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
        $courses = CourseDetail::all();

        return view('Dashboard.Admin.Dashboard.course-master-list', compact('courses'));
    }

    public function courseDetailEdit($id)
    {
        $course = CourseDetail::findOrFail($id);
        $course_data = DB::table('classes_groups_exams')->get();
        $education_type = Educationtype::get();
        $board = BoardAgencyStateModel::get();

        return view('Dashboard.Admin.Dashboard.course-detail-edit', compact('course', 'course_data', 'education_type', 'board'));
    }

    public function courseDetailUpdate(Request $request, $id)
    {
        $courseDetails = CourseDetail::findOrFail($id);

        if ($request->isMethod('POST')) {
            $noti_img = $courseDetails->notification_image;
            $exam_img = $courseDetails->exam_detail;
            $course_logo = $courseDetails->course_image;

            if ($request->hasFile('notification_file')) {
                $noti_img = $this->imageService->handleUpload($request->file('notification_file'), 'uploads/notification_image', 1000);
            }
            if ($request->hasFile('exam_details_file')) {
                $exam_img = $this->imageService->handleUpload($request->file('exam_details_file'), 'uploads/exam_details', 1000);
            }
            if ($request->hasFile('course_logo')) {
                $course_logo = $this->imageService->handleUpload($request->file('course_logo'), 'uploads/course_logo', 500);
            }

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

            return redirect()->route('administrator.course-detail-list')->with('success', 'Course details updated successfully!');
        }
    }
}
