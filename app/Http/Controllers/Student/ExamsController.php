<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Educationtype;
use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
use App\Models\OtherCategoryClass;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ExamsController extends Controller
{
    protected $data;

    protected $insert_data;

    protected $diff_data;

    public function __construct()
    {
        $this->data = [];

        $this->data['educations'] = Educationtype::get();

        // $this->data['others'] = OtherCategoryClass::get();
        $this->data['pagename'] = 'Add Questions';
        $this->data['test_sections'] = ['1', '2', '3', '4', '5'];
        $this->data['difficulty_level'] = ['25', '35', '40', '50', '60', '70', '75', '80', '90', '100'];
    }

    public function index(Request $req, $cat = '')
    {
        $name = Route::currentRouteName();
        if ($name == 'student.dashboard_tests_list') {
            $type = 1;
        }
        if ($name == 'student.dashboard_gyanology_list') {
            $type = 0;
        }

        $this->data['type'] = $type;
        $this->data['cat'] = $cat;

        $this->data['pagename'] = 'All Tests';
        if ($req->isMethod('post')) {
            // DataTables logic removed in favor of Livewire
            return response()->json([], 200);
        }

        return view('Dashboard/Student/Exam/teststable')->with('data', $this->data);
    }

    public function package_manage(Request $req, $id)
    {
        $result = [
            'onegk' => [],
            'live_video' => [],
            'study_material' => [],
            'test' => [],
        ];
        $test_id = DB::table('gn__package_plan_tests')
            ->select('gn_package_plan_id', 'test_id')
            ->where('gn_package_plan_id', $id)
            ->groupBy('gn_package_plan_id', 'test_id')
            ->get();

        $study_material_id = DB::table('gn__package_plans')
            ->select('study_material_id', 'id')
            ->where('id', $id)
            ->get();

        $video_id = DB::table('gn__package_plans')
            ->select('video_id', 'id')
            ->where('id', $id)
            ->first();

        $static_gk_id = DB::table('gn__package_plans')
            ->select('static_gk_id', 'id')
            ->where('id', $id)
            ->first();

        $static_gk_ids = array_map('intval', explode(',', $static_gk_id->static_gk_id));
        foreach ($static_gk_ids as $onegkid) {
            $data = DB::table('study_material')
                ->leftJoin('classes_groups_exams', function ($join) {
                    $join->on('study_material.class', 'classes_groups_exams.id')
                        ->whereNull('classes_groups_exams.deleted_at');
                })
                ->select('study_material.*', 'classes_groups_exams.name')
                ->where('study_material.id', $onegkid)
                ->first();
            if ($data) {
                $result['onegk'][] = $data;
            }
        }

        $video_ids = array_map('intval', explode(',', $video_id->video_id));
        foreach ($video_ids as $onevideo) {
            $data = DB::table('study_material')
                ->leftJoin('classes_groups_exams', function ($join) {
                    $join->on('study_material.class', 'classes_groups_exams.id')
                        ->whereNull('classes_groups_exams.deleted_at');
                })
                ->select('study_material.*', 'classes_groups_exams.name')
                ->where('study_material.id', $onevideo)
                ->first();
            if ($data) {
                $result['live_video'][] = $data;
            }
        }

        $study_material_ids = array_map('intval', explode(',', $study_material_id[0]->study_material_id));
        foreach ($study_material_ids as $onematerial) {
            $data = DB::table('study_material')
                ->leftJoin('classes_groups_exams', function ($join) {
                    $join->on('study_material.class', 'classes_groups_exams.id')
                        ->whereNull('classes_groups_exams.deleted_at');
                })
                ->select('study_material.*', 'classes_groups_exams.name')
                ->where('study_material.id', $onematerial)
                ->first();
            if ($data) {
                $result['study_material'][] = $data;
            }
        }

        foreach ($test_id as $onetest) {
            $data = DB::table('test')
                ->leftjoin('classes_groups_exams', function ($join) {
                    $join->on('test.education_type_child_id', '=', 'classes_groups_exams.id')
                        ->whereNull('classes_groups_exams.deleted_at');
                })
                ->select('test.*', 'classes_groups_exams.name as class_name')
                ->where('test.id', $onetest->test_id)
                ->whereNull('test.deleted_at')
                ->first();
            if ($data) {
                $result['test'][] = $data;
            }
        }

        return view('Dashboard/Student/MyPlan/package_manage', $result);
    }

    public function getTest(Request $request, $name)
    {

        $id = Auth::id();
        $test = TestModal::find($name);

        // if (empty($test) || Auth::user()->myInstitute->id != $test->institude->id) {
        //     return redirect('/');
        // }

        $this->data['test'] = $test;
        $section_time = $this->data['test']->getSection()->select('number_of_questions', 'duration')->get()->toArray();
        $time = [];
        foreach ($section_time as $key => $section) {
            $time[$key] = $section['number_of_questions'] * $section['duration'];
        }
        $this->data['test_duration'] = array_sum($time);
        $this->data['user'] = User::where('status', 'active')->where('roles', 'student')->get();
        $this->data['user_data'] = UserDetails::where('user_id', $id)->first();

        // return $this->data;
        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();

        return view('Frontend/online-test', compact('education_types', 'classes_groups_exams'))->with('data', $this->data);
    }

    public function startTest($name)
    {

        $test = TestModal::find($name);
        if (empty($test) || Auth::user()->myInstitute->id != $test->institude->id) {
            return redirect('/');
        }

        $student_test_attempt = Gn_StudentTestAttempt::where('student_id', Auth::user()->id)->where('test_id', $name)->first();
        if ($student_test_attempt) {
            return redirect()->route('student.show-result', [Auth::user()->id, $name]);
        }

        $this->data['test_start'] = $test;
        $this->data['questions'] = $test->getQuestions()->wherePivot('deleted_at', '=', null)->get()->groupBy('pivot.section_id');
        $section_time = $this->data['test_start']->getSection()->select('number_of_questions', 'duration')->get()->toArray();
        $time = [];
        foreach ($section_time as $key => $section) {
            $time[$key] = $section['number_of_questions'] * $section['duration'];
        }
        $this->data['test_duration'] = array_sum($time);

        return view('Frontend/start-test')->with('data', $this->data);
    }

    public function questionPaper($name)
    {
        $test = TestModal::find($name);
        if (empty($test) || Auth::user()->myInstitute->id != $test->institude->id) {
            return redirect('/');
        }
        $this->data['test_question_paper'] = $test;

        return view('Frontend/question-paper')->with('data', $this->data);
    }

    public function showResult($name, $test_id)
    {

        $test = TestModal::find($test_id);
        if (empty($test) || Auth::user()->id != $name) {
            return redirect('/student');
        }

        $test_response = Gn_Test_Response::where('student_id', $name)->where('test_id', $test_id)->orderBy('question_id', 'asc')->get();
        $questions = QuestionBankModel::whereIn('id', $test_response->pluck('question_id')->toArray())->orderBy('id', 'asc')->get();
        $correct_answer = 0;
        $incorrect_answer = 0;
        $not_attempted = 0;

        $answer['correct_answer'] = collect([]);
        $answer['incorrect_answer'] = collect([]);
        $answer['not_attempted'] = collect([]);

        foreach ($questions as $key => $question) {
            if ($question->id == $test_response[$key]->question_id) {
                if ($test_response[$key]->answer == null) {
                    $not_attempted += 1;
                    $answer['not_attempted']->push($test_response[$key]);
                }
                if ($question->mcq_answer == $test_response[$key]->answer) {
                    $correct_answer += 1;
                    $answer['correct_answer']->push($test_response[$key]);
                }
                if ($question->mcq_answer != $test_response[$key]->answer && $test_response[$key]->answer != null) {
                    $incorrect_answer += 1;
                    $answer['incorrect_answer']->push($test_response[$key]);
                }
            }
        }

        // dd($this->data['negative_marks']);
        $negativeMarks = ($test->negative_marks * $test->gn_marks_per_questions);
        // dd($incorrect_answer);
        $this->data['not_attempted'] = $not_attempted;
        $this->data['total_question'] = count($test_response);
        $this->data['total_marks'] = count($test_response) * $test->gn_marks_per_questions;
        $this->data['negative_marks'] = $incorrect_answer * $negativeMarks;
        $this->data['out_of_marks'] = $correct_answer * $test->gn_marks_per_questions;
        $this->data['final_marks'] = $this->data['out_of_marks'] - ($incorrect_answer * $negativeMarks);
        $this->data['correct_answer'] = $correct_answer;
        $this->data['incorrect_answer'] = $incorrect_answer;
        $this->data['test'] = $test;
        $this->data['student_id'] = $name;
        $this->data['answer'] = $answer;

        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();
        if ($test->show_result == 1) {
            return view('Frontend/show-result', compact('education_types', 'classes_groups_exams'))->with('data', $this->data);
        } else {
            return back()->withErrors(['resultError' => 'Result will be displayed soon...']);
        }
    }

    public function testAttempt(Request $req)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        // dd(Auth::user()->testAttempt);
        $this->data['pagename'] = 'All Tests';
        if ($req->isMethod('post')) {

            $params['draw'] = $_REQUEST['draw'];
            $start = $_REQUEST['start'];
            $length = $_REQUEST['length'];
            $search_value = $_REQUEST['search']['value'];

            if (! empty($search_value)) {
                $testTableData = $user->testAttempt()
                    ->orderBy('id', 'desc')
                    ->orderBy('id', 'desc')->skip($start)->take($length)->get();
                $count = $user->testAttempt()->where('id', 'like', '%'.$search_value.'%')->count();
            } else {
                $testTableData = $user->testAttempt()->orderBy('id', 'desc')->skip($start)->take($length)->get();
                $count = $user->testAttempt()->count();
            }

            foreach ($testTableData as $key => $testData) {
                $action = '';

                if ($testData->test->show_result == 0) {
                    $action = '<button class="btn btn-sm btn-warning" disabled="disabled"><i class="bi bi-pencil-square me-2"></i>Show Result</button>';
                } else {
                    $action = '<a class="btn btn-sm btn-warning" href="'.route('student.show-result', [Auth::user()->id, $testData->test->id]).'" title="Show Result"><i class="bi bi-pencil-square me-2"></i>Show Result</a>';
                }
                $testTableData[$key]['title'] = $testData->test->title;
                $testTableData[$key]['class_name'] = $testData->test->EducationClass->name;
                $testTableData[$key]['test_date'] = date('d-m-Y', strtotime($testData->created_at));
                $testTableData[$key]['test_category'] = $testData->test->user_id != null ? 'Institude' : 'Test and Notes';
                $testTableData[$key]['actions'] = $action;
            }

            $json_data = [
                'draw' => intval($params['draw']),
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $testTableData,   // total data array
            ];

            return json_encode($json_data);
        }

        return view('Dashboard/Student/Exam/student_teststable')->with('data', $this->data);
    }
}
