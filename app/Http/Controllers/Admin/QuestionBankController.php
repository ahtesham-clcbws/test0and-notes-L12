<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionBankImport;
use App\Models\Educationtype;
use App\Models\QuestionBankModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class QuestionBankController extends Controller
{
    protected $req;
    protected $data;
    public function __construct(Request $req)
    {
        $this->data = array();

        // $this->data['classes'] = ClassGoupExamModel::get();
        $this->data['educations'] = Educationtype::get();
        // $this->data['boards'] = BoardAgencyStateModel::get();
        // $this->data['others'] = OtherCategoryClass::get();
        $this->data['pagename'] = 'Question Bank';
        $this->data['test_sections'] = ['1', '2', '3', '4', '5'];
        $this->data['difficulty_level'] = ['25', '35', '40', '50', '60', '70', '75', '80', '90', '100'];
        $this->req = $req;
    }
    public function index($type = 'all')
    {
        $this->data['pagename'] = 'Questions';
        if ($this->req->isMethod('post')) {
            $params['draw'] = $this->req->input('draw') ? $this->req->input('draw') : 1;
            $start = $this->req->input('start') ? $this->req->input('start') : 0;
            $length = $this->req->input('length') ? $this->req->input('length') : 10;

            // $search_value = $_REQUEST['search']['value'];
            $search_value = $this->req->input('search.value') ? $this->req->input('search.value') : '';
            $selectFields = [
                'id',
                'education_type_id',
                'class_group_exam_id',
                'board_agency_state_id',
                'subject',
                'subject_part',
                'subject_lesson_chapter',
                'question_type',
                'question',
                'creator_id',
                'status',
                'checked_by_id',
                'created_at',
                'updated_at'
            ];

            if (!empty($search_value)) {
                $testTableData = QuestionBankModel::select($selectFields)
                    ->where("question", "like", "%" . $search_value . "%")
                    ->orderBy('id', 'desc')->skip($start)->take($length)->get();
                $count = QuestionBankModel::where("question", "like", "%" . $search_value . "%")->count();
            } else {
                $testTableData = QuestionBankModel::select($selectFields)->orderBy('id', 'desc')->skip($start)->take($length)->get();
                $count = QuestionBankModel::count();
            }
            $questionsData = array();

            foreach ($testTableData as $key => $testData) {
                $questionsData[$key] = $testData;


                $viewButton = '<a href="' . route('administrator.dashboard_question_show', [$testData['id']]) . '" title="View" target="_blank"><i class="bi bi-eye text-primary me-2"></i></a>';
                $editButton = '';
                if (Auth::user()->id == $testData['creator_id'] && ($testData['status'] == 'pending' || $testData['status'] == 'rejected')) {
                    $editButton = '<a href="' . route('administrator.dashboard_question_update', [$testData['id']]) . '" title="Edit Test"><i class="bi bi-pencil-square text-success me-2"></i></a>';
                }

                $questionsData[$key]['creator_name'] = optional($testData->creator)->name ?? '';

                $questionsData[$key]['checker_name'] = '';
                if ($testData['checked_by_id']) {
                    $questionsData[$key]['checker_name'] = optional($testData->checkedBy)->name ?? '';
                }

                $questionsData[$key]['type'] = 'Text';
                if ($testData['question_type'] == '1') {
                    $questionsData[$key]['type'] = 'MCQ';
                }

                // if (str_contains($questionsData[$key]['question'], 'questionImage')) {
                //     if ($testData['question']) {
                //         $questionsData[$key]['question'] = '<img src="' . '/storage/' . $questionsData[$key]['question'] . '"/>';
                //     }
                // }


                $questionsData[$key]['education'] = '';
                if ($testData['education_type_id']) {
                    $questionsData[$key]['education'] = optional($testData->educationType)->name ?? '';
                }

                $questionsData[$key]['class'] = '';
                if ($testData['class_group_exam_id']) {
                    $questionsData[$key]['class'] = optional($testData->classGroup)->name ?? '';
                }

                $questionsData[$key]['board'] = '';
                if ($testData['board_agency_state_id']) {
                    $questionsData[$key]['board'] = optional($testData->boardAgency)->name ?? '';
                }

                $questionsData[$key]['subject'] = '';
                if ($testData['subject']) {
                    $questionsData[$key]['subject'] = optional($testData->inSubject)->name ?? '';
                }

                $questionsData[$key]['subject_part'] = '';
                if ($testData['subject_part']) {
                    $questionsData[$key]['subject_part'] = optional($testData->inSubjectPart)->name ?? '';
                }

                $questionsData[$key]['lesson_chapter'] = '';
                if ($testData['subject_lesson_chapter']) {
                    $questionsData[$key]['lesson_chapter'] = optional($testData->inSubjectLesson)->name ?? '';
                }

                $questionsData[$key]['created'] = date('d-M-y g:s A', strtotime($testData->created_at));
                $questionsData[$key]['updated'] = date('d-M-y g:s A', strtotime($testData->updated_at));

                $status = ucfirst($testData['status']);
                if ($testData['status'] == 'approved') {
                    $questionsData[$key]['status'] = '<span class="badge rounded-pill bg-success">' . $status . '</span>';
                }
                if ($testData['status'] == 'rejected') {
                    $questionsData[$key]['status'] = '<span class="badge rounded-pill bg-danger">' . $status . '</span>';
                }
                if ($testData['status'] == 'pending') {
                    $questionsData[$key]['status'] = '<span class="badge rounded-pill bg-warning text-dark">' . $status . '</span>';
                }

                $actionsHtml = $viewButton . $editButton;

                $questionsData[$key]['actions'] = $actionsHtml;
            }

            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $questionsData   // total data array
            );

            // return print_r($json_data);
            return json_encode($json_data);
        }
        return view('Dashboard/Admin/QuestionBank/index')->with('data', $this->data);
    }
    public function add_update($id = 0)
    {
        $question = NULL;
        if ($id > 0) {
            $this->data['pagename'] = 'Update Question';
            $question = QuestionBankModel::find($id);
        } else {
            $this->data['pagename'] = 'Add Question';
            $question = new QuestionBankModel();
        }
        // return print_r($question);
        $this->data['question'] = $question;
        return view('Dashboard/Admin/QuestionBank/add_update')->with('data', $this->data);
    }
    public function show($id)
    {
        return view('Dashboard/Admin/QuestionBank/show')->with('data', $this->data);
    }

    public function importView()
    {
        return view('Dashboard/Admin/QuestionBank/import');
    }


    public function import()
    {
        Excel::import(new QuestionBankImport, request()->file('question'));
        return back();
    }
}
