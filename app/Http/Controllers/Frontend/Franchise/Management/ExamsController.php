<?php

namespace App\Http\Controllers\Frontend\Franchise\Management;

use App\Models\AssignClassBoardModel;
use App\Models\AssignClassSubjectsModel;
use App\Models\Educationtype;
use App\Models\ClassGoupExamModel;
use App\Models\BoardAgencyStateModel;
use App\Models\OtherCategoryClass;
use App\Models\Subject;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use App\Models\TestModal;
use App\Models\TestQuestions;
use App\Models\TestSections;
use App\Models\User;
use App\Models\Gn_SubjectPartLessionNew;
use App\Models\Gn_OtherExamClassDetailModel;
use App\Models\Gn_EducationClassExamAgencyBoardUniversity;
use App\Models\Gn_AssignClassGroupExamName;
use App\Models\Gn_DisplayClassGroupExamName;
use App\Models\Gn_DisplayExamAgencyBoardUniversity;
use App\Models\Gn_DisplayOtherExamClassDetail;
use App\Models\Gn_DisplaySubjectPart;
use App\Models\Gn_DisplaySubjectPartChapter;
use App\Models\QuestionBankModel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    protected $data;
    protected $insert_data;
    protected $diff_data;

    public function __construct()
    {
        $this->data = array();

        $this->data['educations']       = Educationtype::get();

        // $this->data['others'] = OtherCategoryClass::get();
        $this->data['pagename'] = 'Add Questions';
        $this->data['test_sections'] = ['1', '2', '3', '4', '5'];
        $this->data['difficulty_level'] = ['25', '35', '40', '50', '60', '70', '75', '80', '90', '100'];
    }

    public function index(Request $req)
    {
        // $search_value = 'one';
        // $testTableData = TestModal::select(['id', 'title', 'test_type', 'sections', 'total_questions', 'questions_submitted','questions_approved','reviewed','reviewed_status','published_status','published'])
        // ->where("title", "like", "%".$search_value."%")->orderBy('id', 'desc')->skip(0)->take(10)->get();
        // $count = TestModal::count();
        // $json_data = array(
        //     // "draw" => intval($params['draw']),
        //     "recordsTotal" => $count,
        //     "recordsFiltered" => $count,
        //     "data" => $testTableData   // total data array
        // );
        // return print_r($json_data);
        $this->data['pagename'] = 'All Tests';
        if ($req->isMethod('post')) {
            $params['draw'] = $_REQUEST['draw'];
            $start = $_REQUEST['start'];
            $length = $_REQUEST['length'];
            /* If we pass any extra data in request from ajax */
            //$value1 = isset($_REQUEST['key1'])?$_REQUEST['key1']:"";

            /* Value we will get from typing in search */
            $search_value = $_REQUEST['search']['value'];

            // if (!empty($search_value)) {
            //     $testTableData = TestModal::select(['id', 'title', 'test_type', 'sections', 'total_questions', 'questions_submitted', 'questions_approved', 'reviewed', 'reviewed_status', 'published'])
            //         ->where("title", "like", "%" . $search_value . "%")
            //         ->orderBy('id', 'desc')->skip($start)->take($length)->get();
            //     $count = TestModal::where("title", "like", "%" . $search_value . "%")->count();
            // } else {
            //     $testTableData = TestModal::select(['id', 'title', 'test_type', 'sections', 'total_questions', 'questions_submitted', 'questions_approved', 'reviewed', 'reviewed_status', 'published'])->orderBy('id', 'desc')->skip($start)->take($length)->get();
            //     $count = TestModal::count();
            // }

            if (!empty($search_value)) {
                $testTableData = TestModal::select(['test.id as id', 'test.title as title', 'test.sections as sections', 'test.total_questions as total_questions', 'test.questions_submitted as questions_submitted', 'test.questions_approved as questions_approved', 'test.reviewed as reviewed', 'test.reviewed_status as reviewed_status', 'test.published as published','test.created_at as created_at','test.education_type_child_id as education_type_child_id','test.published_status as published_status','users.name as username'])
                ->leftJoin('test_section','test_section.test_id','test.id')
                ->where("title", "like", "%" . $search_value . "%")
                ->where('test_section.creator_id','=',Auth::user()->id)
                ->orWhere('test_section.publisher_id','=',Auth::user()->id)
                ->orderBy('id', 'desc')->skip($start)->take($length)->get();

                $count = TestModal::where("title", "like", "%" . $search_value . "%")
                ->leftJoin('test_section','test_section.test_id','test.id')
                ->where('test_section.creator_id','=',Auth::user()->id)
                ->orWhere('test_section.publisher_id','=',Auth::user()->id)
                ->count();

            } else {
                $testTableData = TestModal::select(['test.id as id', 'test_section.id as section_id','test.title as title', 'test.sections as sections', 'test.total_questions as total_questions', 'test.questions_submitted as questions_submitted', 'test.questions_approved as questions_approved', 'test.reviewed as reviewed', 'test.reviewed_status as reviewed_status', 'test.published as published','test.created_at as created_at','test.education_type_child_id as education_type_child_id','test.published_status as published_status','users.name as username'])
                ->leftJoin('test_section','test_section.test_id','test.id')
                ->leftJoin('users','users.id','test.user_id')
                ->orderBy('id','desc')->skip($start)
                ->where('test_section.creator_id','=',Auth::user()->id)
                ->orWhere('test_section.publisher_id','=',Auth::user()->id)
                ->take($length)
                ->get();

                $count = TestModal::leftJoin('test_section','test_section.test_id','test.id')
                ->where('test_section.creator_id','=',Auth::user()->id)
                ->orWhere('test_section.publisher_id','=',Auth::user()->id)
                ->count();
            }

            foreach ($testTableData as $key => $testData) {
                // if ($testData['test_type'] == '1') {
                //     // $testTableData[$key]['type_text'] = 'Normal Test';
                // }
                // if ($testData['test_type'] == '2') {
                //     // $testTableData[$key]['type_text'] = 'Schedule Test';
                // }
                // if ($testData['test_type'] == '3') {
                //     // $testTableData[$key]['type_text'] = 'Practice Test';
                // }
                // dd();
                $total_questions = $testData['total_questions'];

                $testTableData[$key]['total_questions'] = $testData['total_questions'] . ' / ' . $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count();
                $status = '';

                // dd($testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count());
                // == 'true' ? $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count()  : '0'

                // $questionButton = '';
                if ($total_questions == 0) {
                    $status = '<span class="badge bg-warning text-dark">Awaiting Sections</span>';
                } else {
                    // $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count()
                    // if ($testData['total_questions'] !== $testData['questions_submitted'] || $testData['total_questions'] < $testData['questions_submitted']) {
                    if ($total_questions !== $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count() || $total_questions < $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count()) {
                        $status = '<span class="badge bg-warning text-dark">Awaiting Questions</span>';
                        // $questionButton = '<a href="' . route('franchise.dashboard_test_section', [$testData['id']]) . '" title="Test Questions"><i class="bi bi-journal-text text-primary me-2"></i></a>';
                        // $questionButton = $sectionButtons;
                    } else {
                        if ($testData['reviewed']) {
                            if ($testData['reviewed_status'] == 'approved') {
                                $status = '<span class="badge bg-success">Approved</span>';
                            }
                            if ($testData['reviewed_status'] == 'rejected') {
                                $status = '<span class="badge bg-danger">Rejected</span>';
                            }
                            if ($testData['reviewed_status'] == 'onhold') {
                                $status = '<span class="badge bg-warning text-dark">Hold Review</span>';
                            }
                        } else {
                            $status = '<a href="'.route('franchise.management.dashboard_publish_test_exam', [$testData['id']]).'"><span class="badge bg-primary">Publish Test</span></a>';
                        }
                        // if ($testData['published_status']) {
                        //     $status = '<span class="badge bg-primary">Published</span>';
                        // }
                        if ($testData['published'] == 1) {
                            $status = '<a href="'.route('franchise.management.dashboard_publish_test_exam', [$testData['id']]).'"><span class="badge bg-success">Published</span></a>';
                        }
                        // if ($total_questions == $testData->getQuestions()->wherePivot('deleted_at','=',NULL)->count()) {
                        //     $status = '<a href="'.route('franchise.dashboard_publish_test_exam', [$testData['id']]).'"><span class="badge bg-primary">Published</span></a>';
                        // }
                    }
                }
                $sectionButtons = '';
                if ($testData['sections']) {
                    // $sectionsX = TestSections::select('id')->where('test_id', $testData['id'])->get();
                    $sectionUrl = '';
                    $sectionButtons = '';
                    // foreach ($sectionsX as $keyX => $sectionX) {
                        $sectionUrl = route('franchise.management.dashboard_test_section_question', [$testData['id'], $testData['section_id']]);
                        $sectionButtons .= '<a href="' . $sectionUrl . '" ><i class="bi bi-journal-text text-primary me-2"></i></a>';
                    // }
                } else {
                    $sectionButtons = '0 Sections';
                }
                $testData['sections'] = $sectionButtons;

                $testTableData[$key]['status'] = $status;
                $testTableData[$key]['created_by'] = $testData->username;
                $testTableData[$key]['created_date'] = date('d-m-Y',strtotime($testData->created_at));
                $testTableData[$key]['class_name'] = $testData->EducationClass->name;

                // <a href="' . route('franchise.dashboard_test_sections', [$testData['id']]) . '" title="Test Sections"><i class="bi bi-columns-gap text-primary me-2"></i></a>
                $actionsHtml = '<a href="' . route('franchise.dashboard_update_test_exam', [$testData['id']]) . '" title="Edit Test"><i class="bi bi-pencil-square text-success me-2"></i></a>
                <a href="javascript:void(0);" title="Delete Test"><i class="bi bi-trash2-fill text-danger me-2" onclick="deleteTest('.$testData['id'].')"></i></a>';
                // $actionsHtml = $questionButton.'<a href="' . route('franchise.dashboard_test_sections', [$testData['id']]) . '" title="Test Sections"><i class="bi bi-columns-gap text-primary me-2"></i></a>
                // <a href="' . route('franchise.dashboard_update_test_exam', [$testData['id']]) . '" title="Edit Test"><i class="bi bi-pencil-square text-success me-2"></i></a>';
                $testTableData[$key]['actions'] = $actionsHtml;
            }

            $json_data = array(
                "draw"              => intval($params['draw']),
                "recordsTotal"      => $count,
                "recordsFiltered"   => $count,
                "data"              => $testTableData   // total data array
            );

            return json_encode($json_data);
        }
        // dd($this->data);
        return view('Dashboard/Franchise/Management/Exam/teststable')->with('data', $this->data);
    }

    public function saveTest(Request $req, $test_id = 0)
    {
        $this->data['marks'] = ['1', '2', '3', '4'];
        $this->data['negative_marks'] = [
            ['id' => '0', 'name' => 'No Negative Marking'],
            ['id' => '0.25', 'name' => '-0.25%'],
            ['id' => '0.33', 'name' => '-0.33%'],
            ['id' => '0.5', 'name' => '-0.50%'],
        ];
        $this->data['durations'] = [
            ['id' => 10, 'name' => '10 Minute'],
            ['id' => 20, 'name' => '20 Minute'],
            ['id' => 30, 'name' => '30 Minute'],
            ['id' => 40, 'name' => '40 Minute'],
            ['id' => 45, 'name' => '45 Minute'],
            ['id' => 50, 'name' => '50 Minute'],
            ['id' => 60, 'name' => '1 Hour'],
            ['id' => 70, 'name' => '1 Hour / 10 Minute'],
            ['id' => 75, 'name' => '1 Hour / 15 Minute'],
            ['id' => 80, 'name' => '1 Hour / 20 Minute'],
            ['id' => 90, 'name' => '1 Hour / 30 Minute'],
            ['id' => 100, 'name' => '1 Hour / 40 Minute'],
            ['id' => 105, 'name' => '1 Hour / 45 Minute'],
            ['id' => 110, 'name' => '1 Hour / 50 Minute'],
            ['id' => 120, 'name' => '2 Hour'],
            ['id' => 130, 'name' => '2 Hour / 10 Minute'],
            ['id' => 135, 'name' => '2 Hour / 15 Minute'],
            ['id' => 140, 'name' => '2 Hour / 20 Minute'],
            ['id' => 150, 'name' => '2 Hour / 30 Minute'],
            ['id' => 160, 'name' => '2 Hour / 40 Minute'],
            ['id' => 165, 'name' => '2 Hour / 45 Minute'],
            ['id' => 170, 'name' => '2 Hour / 50 Minute'],
            ['id' => 180, 'name' => '3 Hour'],
        ];
        $this->data['pagename'] = 'Add / Update Test';

        if ($test_id !== 0) {
            $test = TestModal::find($test_id);
            $this->data['show_section'] = 1;
        } else {
            $test = new TestModal();
            $this->data['show_section'] = 0;
        }
        $this->data['test'] = $test;

        $this->data['group_classes']    = ClassGoupExamModel::where('education_type_id',$this->data['test']->education_type_id)->get();
        $this->data['agency_boards']    = Gn_EducationClassExamAgencyBoardUniversity::where('education_type_id',$this->data['test']->education_type_id)->where('classes_group_exams_id',$this->data['test']->education_type_child_id)->get();
        $this->data['other_exams']      = Gn_OtherExamClassDetailModel::where('education_type_id',$this->data['test']->education_type_id)->where('classes_group_exams_id',$this->data['test']->education_type_child_id)->where('agency_board_university_id',$this->data['test']->board_state_agency)->get();

        if ($req->isMethod('post')) {
            $inputs = $req->all();

            if ($inputs['form_name'] == 'test_form') {
                $testMd = new TestModal();
                if (isset($inputs['id']) && $inputs['id'] > 0) {
                    $testMd = TestModal::find($inputs['id']);
                }
                $testMd->title                      = $inputs['title'];
                $testMd->user_id                    = Auth::user()->id;
                $testMd->gn_marks_per_questions     = $inputs['marks_per_questions'];
                $testMd->negative_marks             = $inputs['negative_marks'];
                $testMd->sections                   = $inputs['no_of_sections'];
                $testMd->total_questions            = $inputs['total_questions'];

                $testMd->education_type_id          = $inputs['education_type_id'];
                $testMd->education_type_child_id    = $inputs['class_group_exam_id'];
                $testMd->board_state_agency         = $inputs['exam_agency_board_university_id'];
                $testMd->other_category_class_id    = $inputs['other_exam_class_detail_id'];
                $query = $testMd->save();

                if (isset($inputs['id']) && $inputs['id'] > 0) {
                    $section_change = $testMd->getChanges();
                    if (isset($section_change['sections'])) {
                        $sections_delete = TestSections::where('test_id',$testMd->id);
                        $sections_delete->delete();
                        for ($i=0; $i < $testMd->sections ; $i++) {
                            $sectionMd = new TestSections();
                            $sectionMd->test_id = $testMd->id;
                            $sectionMd->save();
                        }
                    }
                }
                else{
                    for ($i=0; $i < $testMd->sections ; $i++) {
                        $sectionMd = new TestSections();
                        $sectionMd->test_id = $testMd->id;
                        $sectionMd->save();
                    }
                }

                if (isset($inputs['id']) && $inputs['id'] > 0) {

                    $this->data['auth_id']  = Auth::user()->id;
                    $testId                 = $inputs['id'];

                    $test                       = TestModal::find($testId);
                    $this->data['subjects']     = Subject::get();
                    $this->data['test']         = $test;

                    $matchThis = ['in_franchise' => '0', 'isAdminAllowed' => '1'];
                    $creators = User::where($matchThis)->where('roles', 'like', '%"creator"%')->orWhere('roles', 'like', '%"manager"%')->orWhere('roles', 'superadmin')->get();

                    foreach ($creators as $key => $creator) {
                        if ($creator['id'] == $this->data['auth_id']) {
                            $creators[$key]['name'] = 'My Self';
                        }
                    }

                    $sections               = TestSections::where('test_id', $testId)->get();
                    $this->data['sections'] = $sections;
                    $this->data['creators'] = $creators;
                    $this->data['pagename'] = 'Test Sections';
                }
                if ($query) {
                    $testId = $testMd->id;
                    return redirect()->route('franchise.management.dashboard_update_test_exam', [$testId])->withErrors(['testSuccess' => 'Test succesfully added.']);
                    // return redirect()->route('franchise.dashboard_test_sections', [$testId])->withErrors(['testSuccess' => 'Test succesfully added.']);
                } else {
                    return back()->withErrors(['testError' => 'Server Error, please try again.']);
                }
                return print_r($inputs);
            }

            if ($req->input('form_name') && $req->input('form_name') == 'notify_creator') {
                return json_encode($req->all());
            }
            if ($inputs['form_name'] == 'sections_form') {

                $errors         = array();
                $sectionsSaved  = array();
                $inputs         = $req->all();
                $sections       = $inputs['section'];
                foreach ($sections as $key => $section) {
                    $sectionMd      = new TestSections();
                    if ($section['id'] > 0) {
                        $sectionMd  = TestSections::find($section['id']);
                    }
                    $sectionMd->test_id                 = $test_id;
                    $sectionMd->subject                 = $section['subject'];
                    $sectionMd->subject_part            = isset($section['subject_part']) ? $section['subject_part'] : 0;
                    $sectionMd->subject_part_lesson     = isset($section['subject_part_lesson']) ? $section['subject_part_lesson'] : 0;
                    $sectionMd->gn_subject_part_lesson  = isset($section['gn_subject_part_lesson']) ? $section['gn_subject_part_lesson'] : 0;
                    $sectionMd->number_of_questions     = $section['number_of_questions'];
                    $sectionMd->question_type           = $section['question_type'];
                    $sectionMd->mcq_options             = isset($section['mcq_options']) ? $section['mcq_options'] : 0;
                    $sectionMd->difficulty_level        = $section['difficulty_level'];
                    $sectionMd->creator_id              = $section['creator_id'];
                    $sectionMd->creator_id              = $section['creator_id'];
                    $sectionMd->date_of_completion      = $section['date_of_completion'];
                    $sectionMd->duration                = $section['duration'];
                    $sectionMd->publisher_id            = $section['publisher_id'];
                    $sectionMd->publishing_date         = $section['publishing_date'];
                    $sectionMd->section_instruction     = $section['section_instruction'];
                    $query                              = $sectionMd->save();
                    $sectionKey                         = $key + 1;
                    if ($query) {
                        array_push($sectionsSaved, $sectionKey);
                    } else {
                        array_push($errors, $sectionKey);
                    }
                }
                $alertClass     = 'success';
                $errorMessage   = '';
                $successMessage = '';
                if (count($errors)) {
                    $errorSections  = implode(',', $errors);
                    $errorMessage   = 'Sections <b>(' . $errorSections . ')</b> not saved.<br>';
                    $alertClass     = 'warning';
                }
                if (count($sectionsSaved)) {
                    $savedSections  = implode(',', $sectionsSaved);
                    $successMessage = 'Sections <b>(' . $savedSections . ')</b> successfully saved.';
                }
                TestModal::sectionsCount();
                // $totalSections = count($sections);

                // $test->sections = $totalSections;
                // $test->save();

                $alertMessage   = $errorMessage . $successMessage;
                $returnResponse = ['class' => $alertClass, 'message' => $alertMessage];
                // return redirect()->route('franchise.dashboard_tests_list', [$test_id])->withErrors(['sectionsError' => $returnResponse]);
                return redirect()->route('franchise.management.dashboard_tests_list')->withErrors(['sectionsError' => $returnResponse]);
                return print_r($sections);
            }

            // if ($inputs['form_name'] == 'publish_test_form') {
            //     dd('')
            // }
        }
        $this->data['auth_id'] = Auth::user()->id;
        // $test = TestModal::find($this->data['test_id']);


        $this->data['education_types']  = Educationtype::get();
        $this->data['subject']          = Subject::get();
        $this->data['subjects']         = Subject::get();

        // $this->data['test']     = $test;
        // $this->data['subjects'] = Subject::get();

        $matchThis = ['in_franchise' => '1'];
        $user_franchise_code = Auth::user()->myInstitute->branch_code;
        // dd($user_franchise_code);
        // $creators = User::where($matchThis)->where('roles', 'like', '%"creator"%')->orWhere('roles', 'like', '%"manager"%')->get();
        $creators = User::where($matchThis)->where('roles', 'like', '%creator%')->where('franchise_code',$user_franchise_code)->get();
        // dd($creators);
        foreach ($creators as $key => $creator) {
            if ($creator['id'] == $this->data['auth_id']) {
                $creators[$key]['name'] = 'My Self';
            }
        }

        $publishers = User::where($matchThis)->where('roles', 'like', '%publisher%')->where('franchise_code',$user_franchise_code)->get();

        foreach ($publishers as $key => $publisher) {
            if ($publisher['id'] == $this->data['auth_id']) {
                $publishers[$key]['name'] = 'My Self';
            }
        }
        // dd($this->data['test']);
        $sections = TestSections::where('test_id', $test_id)->get();
        $this->data['sections'] = $sections;
        $this->data['creators'] = $creators;
        $this->data['publishers'] = $publishers;
        // $this->data['pagename'] = 'Test Sections';
        // dd($this->data['test']->negative_marks);
        return view('Dashboard/Franchise/Management/Exam/savetest')->with('data', $this->data);
    }

    public function publishTest(Request $req,$test_id)
    {
        $test = TestModal::find($test_id);
        $this->data['marks'] = ['1', '2', '3', '4'];
        $this->data['negative_marks'] = [
            ['id' => '0.25', 'name' => '-0.25%'],
            ['id' => '0.33', 'name' => '-0.33%'],
            ['id' => '0.5', 'name' => '-0.50%'],
        ];
        $this->data['durations'] = [
            ['id' => 10, 'name' => '10 Minute'],
            ['id' => 20, 'name' => '20 Minute'],
            ['id' => 30, 'name' => '30 Minute'],
            ['id' => 40, 'name' => '40 Minute'],
            ['id' => 45, 'name' => '45 Minute'],
            ['id' => 50, 'name' => '50 Minute'],
            ['id' => 60, 'name' => '1 Hour'],
            ['id' => 70, 'name' => '1 Hour / 10 Minute'],
            ['id' => 75, 'name' => '1 Hour / 15 Minute'],
            ['id' => 80, 'name' => '1 Hour / 20 Minute'],
            ['id' => 90, 'name' => '1 Hour / 30 Minute'],
            ['id' => 100, 'name' => '1 Hour / 40 Minute'],
            ['id' => 105, 'name' => '1 Hour / 45 Minute'],
            ['id' => 110, 'name' => '1 Hour / 50 Minute'],
            ['id' => 120, 'name' => '2 Hour'],
            ['id' => 130, 'name' => '2 Hour / 10 Minute'],
            ['id' => 135, 'name' => '2 Hour / 15 Minute'],
            ['id' => 140, 'name' => '2 Hour / 20 Minute'],
            ['id' => 150, 'name' => '2 Hour / 30 Minute'],
            ['id' => 160, 'name' => '2 Hour / 40 Minute'],
            ['id' => 165, 'name' => '2 Hour / 45 Minute'],
            ['id' => 170, 'name' => '2 Hour / 50 Minute'],
            ['id' => 180, 'name' => '3 Hour'],
        ];
        $this->data['pagename'] = 'Add / Update Test';

        if ($req->isMethod('post')) {
            $inputs = $req->all();
            if ($inputs['form_name'] == 'publish_test') {
                $publish_test = TestModal::find($test_id);
                $publish_test->show_result      = isset($inputs['show_result']) ? $inputs['show_result'] == 'on' ? 1 : 0 : 0 ;
                $publish_test->show_rank        = isset($inputs['show_rank']) ? $inputs['show_rank'] == 'on'? 1 : 0 : 0;
                $publish_test->show_answer      = isset($inputs['show_answer']) ? $inputs['show_answer'] == 'on'? 1 : 0 : 0;
                $publish_test->show_solution    = isset($inputs['show_solution']) ? $inputs['show_solution'] == 'on'? 1 : 0 : 0;
                $publish_test->published        = 1;
                $publish_test->save();

                return redirect()->route('franchise.management.dashboard_tests_list')->withErrors(['testSuccess' => 'Test succesfully added.']);

            }
        }
        $this->data['test'] = $test;
        $this->data['group_classes']    = ClassGoupExamModel::where('education_type_id',$this->data['test']->education_type_id)->get();
        $this->data['agency_boards']    = Gn_EducationClassExamAgencyBoardUniversity::where('education_type_id',$this->data['test']->education_type_id)->where('classes_group_exams_id',$this->data['test']->education_type_child_id)->get();
        $this->data['other_exams']      = Gn_OtherExamClassDetailModel::where('education_type_id',$this->data['test']->education_type_id)->where('classes_group_exams_id',$this->data['test']->education_type_child_id)->where('agency_board_university_id',$this->data['test']->board_state_agency)->get();

        return view('Dashboard/Franchise/Management/Exam/publish_test')->with('data', $this->data);

    }

    public function testSections(Request $req, $test_id)
    {
        $this->data['auth_id'] = Auth::user()->id;
        $test = TestModal::find($test_id);
        if ($req->isMethod('post')) {
            if ($req->input('form_name') && $req->input('form_name') == 'notify_creator') {
                return json_encode($req->all());
                // send email here to the creator, also check changes if new mail send by the manager
            }
            dd($req->all());
            $errors         = array();
            $sectionsSaved  = array();
            $inputs         = $req->all();
            $sections       = $inputs['section'];
            foreach ($sections as $key => $section) {
                $sectionMd      = new TestSections();
                if ($section['id'] > 0) {
                    $sectionMd  = TestSections::find($section['id']);
                }
                $sectionMd->test_id                 = $test_id;
                $sectionMd->subject                 = $section['subject'];
                $sectionMd->subject_part            = isset($section['subject_part']) ? $section['subject_part'] : 0;
                $sectionMd->subject_part_lesson     = isset($section['subject_part_lesson']) ? $section['subject_part_lesson'] : 0;
                $sectionMd->gn_subject_part_lesson  = isset($section['gn_subject_part_lesson']) ? $section['gn_subject_part_lesson'] : 0;
                $sectionMd->number_of_questions     = $section['number_of_questions'];
                $sectionMd->question_type           = $section['question_type'];
                $sectionMd->mcq_options             = isset($section['mcq_options']) ? $section['mcq_options'] : 0;
                $sectionMd->difficulty_level        = $section['difficulty_level'];
                $sectionMd->creator_id              = $section['creator_id'];
                $sectionMd->date_of_completion      = $section['date_of_completion'];
                $sectionMd->publisher_id            = $section['publisher_id'];
                $sectionMd->publishing_date         = $section['publishing_date'];
                $query                              = $sectionMd->save();
                $sectionKey                         = $key + 1;
                if ($query) {
                    array_push($sectionsSaved, $sectionKey);
                } else {
                    array_push($errors, $sectionKey);
                }
            }
            $alertClass     = 'success';
            $errorMessage   = '';
            $successMessage = '';
            if (count($errors)) {
                $errorSections  = implode(',', $errors);
                $errorMessage   = 'Sections <b>(' . $errorSections . ')</b> not saved.<br>';
                $alertClass     = 'warning';
            }
            if (count($sectionsSaved)) {
                $savedSections  = implode(',', $sectionsSaved);
                $successMessage = 'Sections <b>(' . $savedSections . ')</b> successfully saved.';
            }
            TestModal::sectionsCount();
            // $totalSections = count($sections);

            // $test->sections = $totalSections;
            // $test->save();

            $alertMessage   = $errorMessage . $successMessage;
            $returnResponse = ['class' => $alertClass, 'message' => $alertMessage];
            return redirect()->route('franchise.management.dashboard_test_sections', [$test_id])->withErrors(['sectionsError' => $returnResponse]);
            return print_r($sections);
        }
        $this->data['test']     = $test;
        $this->data['subjects'] = Subject::get();

        $matchThis = ['in_franchise' => '0', 'isAdminAllowed' => '1'];
        $creators = User::where($matchThis)->where('roles', 'like', '%"creator"%')->orWhere('roles', 'like', '%"manager"%')->orWhere('roles', 'superadmin')->get();

        foreach ($creators as $key => $creator) {
            if ($creator['id'] == $this->data['auth_id']) {
                $creators[$key]['name'] = 'My Self';
            }
        }

        $sections = TestSections::where('test_id', $test_id)->get();
        $this->data['sections'] = $sections;
        $this->data['creators'] = $creators;
        $this->data['pagename'] = 'Test Sections';
        return view('Dashboard/Franchise/Management/Exam/sections')->with('data', $this->data);
    }
    public function section(Request $req, $test_id = 0)
    {
        // $this->data['test'] = TestModal::find($test_id);
        $sections = TestSections::where('test_id', $test_id)->get();

        print_r($sections);
        return;
    }
    public function section_questions(Request $req, $test_id, $section_id)
    {
        $this->data['auth_id']          = Auth::user()->id;
        $this->data['test']             = TestModal::find($test_id);
        $thisSection                    = TestSections::find($section_id);
        $this->data['section']          = $thisSection;
        $questions                      = TestQuestions::where(['test_id' => $test_id, 'section_id' => $section_id])->get();
        $this->data['questions']        = $questions;
        $this->data['total_questions']  = count($questions);

        $used_questions                 = $questions->pluck('question_id')->toArray();
        $unused_questions               = QuestionBankModel::where('subject',$thisSection->subject)->whereOr('subject_part',$thisSection->subject_part)->whereOr('subject_lesson_chapter',$thisSection->subject_part_lesson)->get()->pluck('id')->toArray();
        $unused_questions               = array_diff($unused_questions,$used_questions);

        $this->data['unused_questions']   = QuestionBankModel::findOrFail($unused_questions);

        return view('Dashboard/Franchise/Management/Exam/section_questions')->with('data', $this->data);
    }
    public function section_question_add(Request $req, $test_id, $section_id)
    {
        $this->data['test'] = TestModal::find($test_id);
        $thisSection = TestSections::find($section_id);
        $this->data['section'] = $thisSection;

        return view('Dashboard/Franchise/Management/Exam/section_questions')->with('data', $this->data);
    }
}
