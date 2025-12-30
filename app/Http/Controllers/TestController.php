<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestModal;
use App\Models\Gn_Test_Response;
use App\Models\QuestionBankModel;
use App\Models\Gn_StudentTestAttempt;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    protected $data;
    public function onlineTest()
    {
        return view('Frontend/online-test');
    }

    public function getTest(Request $request, $name)
    {
        $id = Auth::id();
        $test               = TestModal::find($name);
        if (empty($test) || !empty($test->institude)) {
            return redirect('/');
        }

        $this->data['test'] = $test;
        $section_time = $this->data['test']->getSection()->select('number_of_questions', 'duration')->get()->toArray();
        $time = [];
        foreach ($section_time as $key => $section) {
            $time[$key] = $section['number_of_questions'] * $section['duration'];
        }
        $this->data['test_duration'] = array_sum($time);
        $this->data['user'] = User::where('status', 'active')->where('roles', 'student')->get();
        $this->data['user_data'] = UserDetails::where('user_id', $id)->first();

        // $start = $_REQUEST['start'];
        // $length = $_REQUEST['length'];

        // $this->data['test_tab_data'] = TestModal::select([
        //     'test.id as id', 'test.user_id', 'title', 'sections', 'total_questions', 'questions_submitted',
        //     'questions_approved', 'reviewed', 'reviewed_status', 'published', 'test.created_at as created_at', 'education_type_child_id', 'published_status',
        //     'users.name as username', 'franchise_details.institute_name as institute_name'
        // ])
        //     ->leftJoin('users', 'users.id', 'test.user_id')
        //     ->leftJoin('franchise_details', 'franchise_details.user_id', 'users.id')
        //     ->orderBy('id', 'desc')->get();

        //     foreach ($this->data['test_tab_data'] as $key => $testData) {
        //         $this->data['test_tab_data']['created_by'] = $testData['institute_name'] != NULL ? $testData['institute_name'] : Auth::user()->name;
        //     }

        // dd($this->data);

        return view('Frontend/online-test')->with('data', $this->data);
    }

    public function startTest($name)
    {
        $test = TestModal::find($name);
        if (empty($test) || !empty($test->institude)) {
            if (Auth::user()->myInstitute->id == $test->institude->id) {
                return redirect()->route('student.start-test', [$name]);
            }
            return redirect('/');
        }

        $this->data['test_start'] = $test;
        // $this->data['questions']  = $test->getQuestions()->wherePivot('deleted_at','=',NULL);
        $this->data['questions']  = $test->getQuestions()->wherePivot('deleted_at', '=', NULL)->get()->groupBy('pivot.section_id');
        // dd($test->getQuestions()->wherePivot('deleted_at','=',NULL)->get()->groupBy('pivot.section_id'));
        // dd($test->getQuestions()->get()->pluck('pivot')->toArray()); subject
        // dd($this->data['test_start']->getSection);
        $section_time = $this->data['test_start']->getSection()->select('number_of_questions', 'duration')->get()->toArray();
        $time = [];
        foreach ($section_time as $key => $section) {
            $time[$key] = $section['number_of_questions'] * $section['duration'];
        }
        $this->data['test_duration'] = array_sum($time);
        return view('Frontend/start-test')->with('data', $this->data);
    }

    public function endTest(Request $request, $name)
    {
        $test = TestModal::find($name);
        if (empty($test)) {
            return redirect('/');
        }
        $old_test_response = Gn_Test_Response::where('student_id', Auth::user()->id)->where('test_id', $name);

        if (!empty($old_test_response->get())) {
            $old_test_response->delete();
        }

        foreach ($request->attemted_questions as $key => $value) {
            $test_response              = new Gn_Test_Response();
            $test_response->student_id  = Auth::user()->id;
            $test_response->test_id     = $name;
            if ($value == 1) {
                $test_response->question_id = $key;
                $test_response->answer      = $request->question[$key];
            } else {
                $test_response->question_id = $key;
            }
            $test_response->save();
        }

        $old_student_test = Gn_StudentTestAttempt::where('student_id', Auth::user()->id)->where('test_id', $name);

        if (!empty($old_student_test->get())) {
            $old_student_test->delete();
        }

        $student_test               = new Gn_StudentTestAttempt();
        $student_test->student_id   = Auth::user()->id;
        $student_test->test_id      = $name;
        $student_test->test_attempt = 1;
        $student_test->save();

        $this->data['test'] = $test;
        if ($request->show_result == 1) {
            return redirect('show-result/' . $test_response->student_id . '/' . $test_response->test_id);
        } else {
            return redirect('/');
        }
    }

    public function questionPaper($name)
    {
        $test                                           = TestModal::find($name);
        if (empty($test) || !empty($test->institude)) {
            if (Auth::user()->myInstitute->id == $test->institude->id) {
                return redirect()->route('student.question-paper', [$name]);
            }
            return redirect('/');
        }
        $this->data['test_question_paper']              = $test;
        return view('Frontend/question-paper')->with('data', $this->data);
    }

    public function showResult($name, $test_id)
    {

        $education_types = DB::table('education_type')->get();
        $classes_groups_exams = DB::table('classes_groups_exams')->get();
        $test = TestModal::find($test_id);

        if (empty($test) || !empty($test->institude)) {
            if (Auth::user()->myInstitute->id == $test->institude->id) {
                return redirect()->route('student.show-result', [$name, $test_id]);
            }
            return redirect('/',compact('education_types','classes_groups_exams'));
        }
        $test_response      = Gn_Test_Response::where('student_id', $name)->where('test_id', $test_id)->orderBy('question_id', 'asc')->get();
        $questions          = QuestionBankModel::whereIn('id', $test_response->pluck('question_id')->toArray())->orderBy('id', 'asc')->get();
        $correct_answer     = 0;
        $incorrect_answer   = 0;
        $not_attempted      = 0;

        $answer['correct_answer']     = collect([]);
        $answer['incorrect_answer']   = collect([]);
        $answer['not_attempted']      = collect([]);
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
        $negativeMarks = ($test->negative_marks * $test->gn_marks_per_questions);
        $this->data['not_attempted']    = $not_attempted;
        $this->data['total_question']   = count($test_response);
        $this->data['total_marks']      = count($test_response)*$test->gn_marks_per_questions;
        $this->data['negative_marks']   = $incorrect_answer* $negativeMarks;
        $this->data['out_of_marks']     = $correct_answer*$test->gn_marks_per_questions;
        $this->data['final_marks']      = $this->data['out_of_marks'] - ($incorrect_answer* $negativeMarks);
        $this->data['correct_answer']   = $correct_answer;
        $this->data['incorrect_answer'] = $incorrect_answer;
        $this->data['test']             = $test;
        $this->data['student_id']       = $name;
        $this->data['answer']           = $answer;

        if ($test->show_result == 1) {
            return view('Frontend/show-result',compact('education_types','classes_groups_exams'))->with('data', $this->data);
        } else {

            return redirect('/',compact('education_types','classes_groups_exams'));
        }
    }

    public function showTestResponse($name, $test_id)
    {
        return redirect('/');
        // $test_response      = Gn_Test_Response::where('student_id',$name)->where('test_id',$test_id)->orderBy('question_id','asc')->get();
        // $questions          = QuestionBankModel::whereIn('id',$test_response->pluck('question_id')->toArray())->orderBy('id','asc')->get();
        // $test               = TestModal::find($test_id);
        // $answer['correct_answer']     = [];
        // $answer['incorrect_answer']   = [];
        // $answer['not_attempted']      = [];

        // foreach($questions as $key => $question) {
        //     if ($question->id == $test_response[$key]->question_id) {
        //         if ($test_response[$key]->answer == null) {
        //             array_push($answer['not_attempted'],$test_response[$key]);
        //         }
        //         if($question->mcq_answer == $test_response[$key]->answer){
        //             array_push($answer['correct_answer'],$test_response[$key]);
        //         }
        //         if($question->mcq_answer != $test_response[$key]->answer && $test_response[$key]->answer != null){
        //             array_push($answer['incorrect_answer'],$test_response[$key]);
        //         }
        //     }
        // }

        // $this->data['test_response']    = $test_response;
        // $this->data['questions']        = $questions;
        // $this->data['test_start']       = $test;
        // $this->data['answer']           = $answer;

        // return view('Frontend/show-test-response')->with('data', $this->data);

        // // $this->data['not_attempted']    = $not_attempted;

    }
}
