<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{

    public function index(Request $request, $edu_id, $class_id){

        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();

        $tests =  DB::table('test')->where('education_type_id', $edu_id)->where('education_type_child_id', $class_id)->where('published', 1)->get();
        dd($tests);
        return view('Frontend/ClassDetail/index', compact('education_types','classes_groups_exams'));
    }
}
