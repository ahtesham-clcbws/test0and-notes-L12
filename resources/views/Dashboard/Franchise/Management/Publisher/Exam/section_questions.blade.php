@extends('Layouts.Management.publisher')

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
            <div class="row">
                <div id="total_section_questions" class="d-none">
                    {{ intVal($data['section']['number_of_questions']) }}
                </div>
                <div class="col-12">
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="btn-group mb-2 me-3" role="group">
                                <button type="button" class="btn btn-dark">
                                    {{ $data['test']->Educationtype->name }}
                                </button>
                                <button type="button" class="btn btn-dark">
                                    {{ $data['test']->EducationClass->name }}
                                </button>
                                <button type="button" class="btn btn-dark">
                                    {{ $data['test']->EducationBoard->name }}
                                </button>
                                @if ($data['test']->OtherCategoryClass)
                                    <button type="button" class="btn btn-dark">
                                        {{ $data['test']->OtherCategoryClass->name }}
                                    </button>
                                @endif
                            </div>
                            <div class="btn-group mb-2 me-3" role="group">
                                <button type="button" class="btn btn-danger">
                                    {{ $data['section']->question_type == '1' ? 'MCQ - ' . $data['section']->mcq_options . ' Options' : 'Text questions' }}
                                </button>
                                <button type="button" class="btn btn-danger">
                                    Questions {{ $data['section']->number_of_questions }} /
                                    {{ $data['total_questions'] }} Submitted
                                </button>
                            </div>
                            <div class="btn-group mb-2" role="group">
                                <button type="button" class="btn btn-info">
                                    Subject: {{ $data['section']->sectionSubject->name }}
                                </button>
                                @if ($data['section']->subject_part)
                                    <button type="button" class="btn btn-info">
                                        Part: {{ $data['section']->sectionSubjectPart->name }}
                                    </button>
                                @endif
                                @if ($data['section']->subject_part_lesson)
                                    <button type="button" class="btn btn-info">
                                        Lesson/Chapter: {{ $data['section']->sectionSubjectLesson->name }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($data['section']->number_of_questions > $data['total_questions'])
                        <div class="col text-end" style="padding-top:15px">
                            <button type="button" data-bs-toggle="modal" data-bs-keyboard="false" data-bs-target="#questionModal"
                                class="btn btn-primary " title="Add Question to Section">
                                Add Question
                            </button>
                        </div>
                    @else
                        <div class="col text-end" style="padding-top:15px">
                            <button type="button" id="submit_question" class="btn btn-primary">
                                Submit Questions
                            </button>
                        </div>
                    @endif
                    <?php $question_count = 0; ?>

                    <div class="card mt-3">
                        <div class="card-body">
                            @if ($data['total_questions'])
                                <table class="table" id="questionsTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Question</th>
                                            <th scope="col">Answer</th>
                                            <th scope="col">Solution</th>
                                            <!-- <th scope="col">Submition Date</th>
                                            <th scope="col">Status</th> -->
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['questions'] as $key => $question)
                                            <tr>
                                                <td scope="col">{{ $question_count+=1 }}</td>
                                                <td scope="col">{!! $question->question->question !!}</td>
                                                <td scope="col">{!! $question->question->mcq_answer !!}</td>
                                                <td scope="col">{!! $question->question->solution !!}</td>
                                                <!-- <td scope="col">
                                                    {{ date('d M, Y', strtotime($question->question->created_at)) }}</td>
                                                <td scope="col fw-bold">
                                                    @if ($question->question->status == 'approved')
                                                        <span class="badge rounded-pill bg-success">
                                                            {{ Str::ucfirst($question->question->status) }}
                                                        </span>
                                                    @endif
                                                    @if ($question->question->status == 'rejected')
                                                        <span class="badge rounded-pill bg-danger">
                                                            {{ Str::ucfirst($question->question->status) }}
                                                        </span>
                                                    @endif
                                                    @if ($question->question->status == 'pending')
                                                        <span class="badge rounded-pill bg-info text-dark">
                                                            {{ Str::ucfirst($question->question->status) }}
                                                        </span>
                                                    @endif
                                                </td> -->
                                                <td class="text-end">
                                                    <!-- <button class="btn btn-link btn-sm me-2"><i
                                                            class="bi bi-eye text-primary"></i></button> -->
                                                    <button class="btn btn-link btn-sm" data-bs-toggle="modal" data-bs-keyboard="false" data-bs-target="#questionModal-{{ $key }}"><i class="bi bi-pencil-square text-primary"></i></button>
                                                            
                                                    {{-- @if ($question->question->status == 'pending' && $question->question->creator_id == $data['auth_id'])
                                                        <button class="btn btn-link btn-sm"><i class="bi bi-pencil-square text-primary"></i></button>
                                                    @endif --}}
                                                    {{--<button class="btn btn-link btn-sm">
                                                        <i class="bi bi-trash2-fill text-danger" onclick="removeQuestion({{ $question->id }})"></i>
                                                    </button>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alertx alert-primary mt-4" id="noQuestionsAlert">
                                    <div class="row">
                                        <div class="col text-dark text-center pt-2">
                                            <h4>There is no questions in this Section, please add some questions.</h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="" style="padding-top:15px">
                        <h2> Select From Questions Bank </h2>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table" id="questionsBankTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr No</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Question</th>
                                        <th scope="col">Answer</th>
                                        <th scope="col">Solution</th>
                                        <!-- <th scope="col">Submition Date</th>
                                        <th scope="col">Status</th> -->
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['unused_questions'] as $key => $question)
                                        <tr>
                                            <td scope="col">{{ $key+=1 }}</td>
                                            <td scope="col">{!! $question->classGroup->name !!}</td>
                                            <td scope="col">{!! $question->question !!}</td>
                                            <td scope="col">{!! $question->mcq_answer !!}</td>
                                            <td scope="col">{!! $question->solution !!}</td>
                                            <td class="text-end">
                                                @if ($data['section']->number_of_questions > $data['total_questions'])
                                                    <button class="btn btn-sm btn-primary" onclick="addQuestion({{ $data['test']->id }},{{ $data['section']->id }},{{ $question->creator_id }},{{ $question->id }})">
                                                        {{ 'Select' }}
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-danger">
                                                        {{ 'Select' }}
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- <div class="alertx alert-primary mt-4" id="noQuestionsAlert">
                                <div class="row">
                                    <div class="col text-dark text-center pt-2">
                                        <h4>There is no questions in this Section, please add some questions.</h4>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($data['questions'] as $key => $question)
        <?php $question_edit_count = $key+1; ?> 
        <div class="modal fade" id="questionModal-{{ $key }}" tabindex="-1" aria-labelledby="questionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <form class="modal-content" id="questionForm-{{ $key }}">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="questionModalLabel">Add Question {{ $question_edit_count }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-bottom mb-3">
                            <div class="col-12 mb-3">
                                <label for="question" class="form-label h5">Question</label>
                                <textarea class="form-control tinyMce" id="question" name="question" rows="3">{!! $question->question->question !!}</textarea>
                            </div>
                        </div>
                        @if ($data['section']->question_type == '1')
                            <div class="row border-bottom mb-3">
                                <label class="form-label h5">MCQ Answers</label>
                                @for ($i = 1; $i <= $data['section']->mcq_options; $i++)
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="mcq_answer"
                                                        id="right_answer_{{ $i }}"
                                                        @if($question->question->mcq_answer == 'ans_'.$i)
                                                            checked
                                                        @endif
                                                        value="ans_{{ $i }}" required>
                                                    <label class="form-check-label" for="right_answer_{{ $i }}">
                                                        Check if (Answer {{ $i }}) is right answer
                                                    </label>
                                                </div>
                                            </label>
                                            {{-- <span class="text-danger float-end">Answer {{ $i + 1 }} is
                                            required.</span> --}}
                                            <textarea class="form-control mb-2 mcq_answers" id="ans_{{ $i }}"
                                                name="ans_{{ $i }}" rows="3">{!! $question->question['ans_'.$i] !!}</textarea>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="solution" class="form-label h5">Solution</label>
                                <textarea class="form-control tinyMce" id="solution" name="solution" rows="3">{!! $question->question->solution !!}</textarea>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="explanation" class="form-label h5">Explanation</label>
                                <textarea class="form-control tinyMce" id="explanation" name="explanation"
                                    rows="3">{!! $question->question->explanation !!}</textarea>
                            </div>
                        </div>
                        <div class="d-none" id="questionHiddenFields">
                            @csrf
                            <input name="total_question"        value="{{ count($data['questions']) }}"             class="d-none" id="total_question">
                            <input name="id"                    value="{{ $question->question->id }}"               class="d-none">
                            <input name="creator_id"            value="{{ $data['auth_id'] }}"                      class="d-none">
                            <input name="section_id"            value="{{ $data['section']['id'] }}"                class="d-none">
                            <input name="test_id"               value="{{ $data['test']['id'] }}"                   class="d-none">
                            <input name="education_type_id"     value="{{ $data['test']->Educationtype->id }}"      class="d-none">
                            <input name="class_group_exam_id"   value="{{ $data['test']->EducationClass->id }}"     class="d-none">
                            <input name="board_agency_state_id" value="{{ $data['test']->EducationBoard->id }}"     class="d-none">
                            <input name="subject"               value="{{ $data['section']->sectionSubject->id }}"  class="d-none">
                            @if ($data['section']->subject_part)
                                <input name="subject_part"           value="{{ $data['section']->sectionSubjectPart->id }}"     class="d-none">
                            @endif
                            @if ($data['section']->subject_part_lesson)
                                <input name="subject_lesson_chapter" value="{{ $data['section']->sectionSubjectLesson->id }}"   class="d-none">
                            @endif
                                <input name="question_type"          value="{{ $data['section']->question_type }}"              class="d-none">
                            @if ($data['section']->question_type == '1')
                                <input name="mcq_options"            value="{{ $data['section']->mcq_options }}"                class="d-none">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-primary">Edit Question</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    @if ($data['section']->number_of_questions > $data['section']->submitted_questions)
        <!-- <button type="button" data-bs-toggle="modal" data-bs-keyboard="false" data-bs-target="#questionModal"
            class="btn btn-primary floating_button" title="Add Question to Section">
            <i class="bi bi-plus-circle-dotted"></i>
        </button> -->
        <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <form class="modal-content" id="questionForm">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="questionModalLabel">Add Question {{ $question_count+=1 }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-bottom mb-3">
                            <div class="col-12 mb-3">
                                <label for="question" class="form-label h5">Question</label>
                                <textarea class="form-control tinyMce" id="question" name="question" rows="3"></textarea>
                            </div>
                        </div>
                        @if ($data['section']->question_type == '1')
                            <div class="row border-bottom mb-3">
                                <label class="form-label h5">MCQ Answers</label>
                                @for ($i = 0; $i < $data['section']->mcq_options; $i++)
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="mcq_answer"
                                                        id="right_answer_{{ $i + 1 }}"
                                                        value="ans_{{ $i + 1 }}" required>
                                                    <label class="form-check-label" for="right_answer_{{ $i + 1 }}">
                                                        Check if (Answer {{ $i + 1 }}) is right answer
                                                    </label>
                                                </div>
                                            </label>
                                            {{-- <span class="text-danger float-end">Answer {{ $i + 1 }} is
                                            required.</span> --}}
                                            <textarea class="form-control mb-2 mcq_answers" id="ans_{{ $i + 1 }}"
                                                name="ans_{{ $i + 1 }}" rows="3"></textarea>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="solution" class="form-label h5">Solution</label>
                                <textarea class="form-control tinyMce" id="solution" name="solution" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="explanation" class="form-label h5">Explanation</label>
                                <textarea class="form-control tinyMce" id="explanation" name="explanation"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="d-none" id="questionHiddenFields">
                            @csrf
                            <input name="creator_id"            value="{{ $data['auth_id'] }}"                      class="d-none">
                            <input name="section_id"            value="{{ $data['section']['id'] }}"                class="d-none">
                            <input name="test_id"               value="{{ $data['test']['id'] }}"                   class="d-none">
                            <input name="education_type_id"     value="{{ $data['test']->Educationtype->id }}"      class="d-none">
                            <input name="class_group_exam_id"   value="{{ $data['test']->EducationClass->id }}"     class="d-none">
                            <input name="board_agency_state_id" value="{{ $data['test']->EducationBoard->id }}"     class="d-none">
                            <input name="subject"               value="{{ $data['section']->sectionSubject->id }}"  class="d-none">
                            @if ($data['section']->subject_part)
                                <input name="subject_part"      value="{{ $data['section']->sectionSubjectPart->id }}" class="d-none">
                            @endif
                            @if ($data['section']->subject_part_lesson)
                                <input name="subject_lesson_chapter" value="{{ $data['section']->sectionSubjectLesson->id }}" class="d-none">
                            @endif
                                <input name="question_type"          value="{{ $data['section']->question_type }}"   class="d-none">
                            @if ($data['section']->question_type == '1')
                                <input name="mcq_options"            value="{{ $data['section']->mcq_options }}"     class="d-none">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-primary">Save Question</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/franchise/management/publisher/admintestsectionquestions.js') }}"></script>
    <script>
        $("#submit_question").click(function(){
            window.location = "{{ route('franchise.management.publisher.dashboard_tests_list') }}";
        });
    </script>
@endsection
