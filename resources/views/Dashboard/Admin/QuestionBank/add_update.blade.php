@extends('Layouts.admin')

@section('css')
    <style>
        .dashboard-container .alertx {
            position: relative;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            min-height: 49px;
        }

    </style>
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <form id="questionForm" class="card">
                <div class="card-body">
                    <div class="row border-bottom">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Type of Education</b></small>
                                <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                    id="education_type_id" name="education_type_id" required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Class / Group / Exam</b></small>
                                <select class="form-select form-select-sm" onchange="getBoardsbyClass(this)" disabled
                                    id="education_type_child_id" name="education_type_child_id" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Board / Exam / State</b></small>
                                <select class="form-select form-select-sm" disabled id="board_state_agency"
                                    name="board_state_agency" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Other Category / Class</b></small>
                                <select class="form-select form-select-sm" id="other_category_class_id"
                                    name="other_category_class_id">
                                    <option value=""></option>
                                    @foreach (testOtherCategory() as $key => $otherCat)
                                        <option value="{{ $otherCat['id'] }}">{{ $otherCat['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Type of Questions</b></small>
                                <select class="form-select form-select-sm section_questions_type" id="question_type"
                                    onchange="onSelectQuestionType(this.value)" name="question_type" required>
                                    <option value=""></option>
                                    <option value="1">MCQ</option>
                                    <option value="2">Text</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12" id="question_mcq_options_default_div">
                            <div class="alertx alert-primary">
                                <small><b>No of Options</b></small>
                                <select class="form-select form-select-sm section_options" id="mcq_options"
                                    name="mcq_options" onchange="onChangeMcqOptions(this.value)" disabled>
                                    <option value=""></option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Difficulty Level</b></small>
                                <select class="form-select form-select-sm" id="difficulty_level" name="difficulty_level">
                                    <option value=""></option>
                                    @foreach ($data['difficulty_level'] as $difficulty)
                                        <option value="{{ $difficulty }}">
                                            {{ $difficulty }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="inititalMcqAnswers" class="d-none">{{ $data['question'] && $data['question']->question_type == '1' ? $data['question']->mcq_options : 0 }}</div>
                    <div class="row border-bottom mb-3">
                        <div class="col-12 mb-3">
                            <label for="question" class="form-label h5">Question</label>
                            <textarea class="form-control tinyMce" id="question" name="question" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row border-bottom mb-3" id="mcq_answers">
                        <label class="form-label h5">MCQ Answers</label>
                    </div>
                    <script type="text/html" id="mcqAnswersDiv">
                        <div class="col-md-6 col-12 mcq_answer_panel">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-success">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mcq_answer" id="right_answer_{0}" value="ans_{0}"
                                                            required>
                                        <label class="form-check-label" for="right_answer_{0}">
                                            Check if (Answer {0}) is right answer
                                        </label>
                                    </div>
                                </label>
                                <textarea class="form-control mb-2 mcqanswer" id="ans_{0}" name="ans_{0}" rows="3"></textarea>
                            </div>
                        </div>
                    </script>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label for="solution" class="form-label h5">Solution</label>
                            <textarea class="form-control tinyMce" id="solution" name="solution" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label for="explanation" class="form-label h5">Explanation</label>
                            <textarea class="form-control tinyMce" id="explanation" name="explanation" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="d-none" id="questionHiddenFields">
                        @csrf
                        <input name="creator_id" value="{{ $data['question']['creator_id'] }}" class="d-none">
                        {{-- <input name="education_type_id" value="{{ $data['question']->educationType->id }}"
                            class="d-none"> --}}
                        {{-- <input name="class_group_exam_id" value="{{ $data['question']->classGroup->id }}" class="d-none"> --}}
                        {{-- <input name="board_agency_state_id" value="{{ $data['question']->boardAgency->id }}"
                            class="d-none"> --}}
                        {{-- <input name="subject" value="{{ $data['question']->inSubject->id }}" class="d-none"> --}}
                        {{-- @if ($data['question']->subject_part)
                            <input name="subject_part" value="{{ $data['question']->inSubjectPart->id }}" class="d-none">
                            @endif --}}
                        {{-- @if ($data['question']->subject_part_lesson)
                            <input name="subject_lesson_chapter" value="{{ $data['question']->inSubjectLesson->id }}"
                                class="d-none">
                            @endif --}}
                        {{-- <input name="question_type" value="{{ $data['question']->question_type }}" class="d-none"> --}}
                        {{-- @if ($data['question']->question_type == '1')
                            <input name="mcq_options" value="{{ $data['question']->mcq_options }}" class="d-none">
                            @endif --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/adminaddupdatequestion.js') }}"></script>
@endsection
