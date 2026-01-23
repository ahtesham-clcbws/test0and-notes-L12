<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestCat;
use App\Models\CourseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

   public function index(Request $request, $edu_id, $class_id){
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();

        $education_type_data = DB::table('education_type')->where('id', $edu_id)->first();
        $classes_groups_exams_data = DB::table('classes_groups_exams')->where('id', $class_id)->first();
        $tests_category_data = \App\Models\TestCat::get();

        $students_count = DB::table('user_details')->where('education_type', $edu_id)->where('class', $class_id)->count();
        $course_detail  = CourseDetail::where('class_group_examp_id',$class_id)->orderBy('id','DESC')->first();

        //dd($education_type,$classes_groups_exams,$tests_category,$tests,$students_count );
        return view('Frontend/ClassDetail/index', compact('classes_groups_exams','education_types','education_type_data','classes_groups_exams_data','students_count', 'tests_category_data','course_detail'));
    }
}
