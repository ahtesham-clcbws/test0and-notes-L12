<?php

namespace App\Http\Controllers;

use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
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
        $test = TestModal::find($name);
        if (empty($test) || ! empty($test->institude)) {
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
        if (empty($test) || ! empty($test->institude)) {
            if (Auth::user()->myInstitute->id == $test->institude->id) {
                return redirect()->route('student.start-test', [$name]);
            }

            return redirect('/');
        }

        $this->data['test_start'] = $test;
        // $this->data['questions']  = $test->getQuestions()->wherePivot('deleted_at','=',NULL);
        $this->data['questions'] = $test->getQuestions()->wherePivot('deleted_at', '=', null)->get()->groupBy('pivot.section_id');
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

        if (! empty($old_test_response->get())) {
            $old_test_response->delete();
        }

        foreach ($request->attemted_questions as $key => $value) {
            $test_response = new Gn_Test_Response;
            $test_response->student_id = Auth::user()->id;
            $test_response->test_id = $name;
            if ($value == 1) {
                $test_response->question_id = $key;
                $test_response->answer = $request->question[$key];
            } else {
                $test_response->question_id = $key;
            }
            $test_response->save();
        }

        $old_student_test = Gn_StudentTestAttempt::where('student_id', Auth::user()->id)->where('test_id', $name)->first();

        if ($old_student_test) {
            return redirect('show-result/'.Auth::user()->id.'/'.$name)->withErrors(['testError' => 'You have already submitted this test.']);
        }

        $student_test = new Gn_StudentTestAttempt;
        $student_test->student_id = Auth::user()->id;
        $student_test->test_id = $name;
        $student_test->test_attempt = 1;
        $student_test->save();

        $this->data['test'] = $test;
        if ($request->show_result == 1) {
            return redirect('show-result/'.$test_response->student_id.'/'.$test_response->test_id);
        } else {
            return redirect('/');
        }
    }

    public function questionPaper($name)
    {
        $test = TestModal::find($name);
        if (empty($test) || ! empty($test->institude)) {
            if (! empty($test->institude) && Auth::user()->myInstitute && Auth::user()->myInstitute->id == $test->institude->id) {
                return redirect()->route('student.question-paper', [$name]);
            }

            return redirect('/');
        }
        $this->data['test_question_paper'] = $test;

        return view('Frontend/question-paper')->with('data', $this->data);
    }

    public function showResult($name, $test_id)
    {
        // ... (Existing showResult)
    }

    public function getTestResult(Request $request)
    {
        $student_id = Auth::id();
        $test_id = $request->input('test_id');

        $test = TestModal::find($test_id);
        if (! $test) {
            return response()->json(['status' => 0, 'message' => 'Test not found']);
        }

        $test_responses = Gn_Test_Response::where('student_id', $student_id)
            ->where('test_id', $test_id)
            ->orderBy('question_id', 'asc')
            ->get();

        $questions = QuestionBankModel::whereIn('id', $test_responses->pluck('question_id'))
            ->orderBy('id', 'asc')
            ->get()
            ->keyBy('id');

        $correct = 0;
        $incorrect = 0;
        $unattempted = 0;
        $sections_data = [];

        foreach ($test_responses as $resp) {
            $q = $questions->get($resp->question_id);
            if (! $q) {
                continue;
            }

            $status = 'unattempted';
            if ($resp->answer === null) {
                $unattempted++;
                $status = 'unattempted';
            } elseif ($q->mcq_answer == $resp->answer) {
                $correct++;
                $status = 'correct';
            } else {
                $incorrect++;
                $status = 'incorrect';
            }

            // Section breakdown
            $section_id = $q->section_id ?? 0;
            if (! isset($sections_data[$section_id])) {
                $sections_data[$section_id] = [
                    'id' => $section_id,
                    'name' => 'Section '.$section_id, // Default
                    'correct' => 0,
                    'incorrect' => 0,
                    'unattempted' => 0,
                    'total' => 0,
                ];
            }
            $sections_data[$section_id][$status]++;
            $sections_data[$section_id]['total']++;
        }

        // Hydrate section names
        $sections = DB::table('test_sections')->whereIn('id', array_keys($sections_data))->get();
        foreach ($sections as $s) {
            $sections_data[$s->id]['name'] = $s->name;
        }

        $marks_per_q = $test->gn_marks_per_questions ?? 1;
        $neg_marks = ($test->negative_marks ?? 0) * $marks_per_q;

        $total_score = ($correct * $marks_per_q) - ($incorrect * $neg_marks);
        $max_score = count($test_responses) * $marks_per_q;

        $detailed_questions = [];
        foreach ($test_responses as $resp) {
            $q = $questions->get($resp->question_id);
            if (! $q) {
                continue;
            }

            $status = 'unattempted';
            if ($resp->answer === null || $resp->answer === '') {
                $status = 'unattempted';
            } elseif ($q->mcq_answer == $resp->answer) {
                $status = 'correct';
            } else {
                $status = 'incorrect';
            }

            $detailed_questions[] = [
                'id' => $q->id,
                'question' => $q->question,
                'options' => [
                    $q->option_1,
                    $q->option_2,
                    $q->option_3,
                    $q->option_4,
                    $q->option_5,
                ],
                'correct_answer' => $q->mcq_answer,
                'user_answer' => $resp->answer,
                'status' => $status,
                'solution' => $q->solution,
            ];
        }

        return response()->json([
            'status' => 1,
            'data' => [
                'test_name' => $test->title,
                'total_questions' => count($test_responses),
                'correct' => $correct,
                'incorrect' => $incorrect,
                'unattempted' => $unattempted,
                'total_score' => round($total_score, 2),
                'max_score' => $max_score,
                'accuracy' => count($test_responses) > 0 ? round(($correct / count($test_responses)) * 100, 2) : 0,
                'sections' => array_values($sections_data),
                'questions' => $detailed_questions,
            ],
        ]);
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
