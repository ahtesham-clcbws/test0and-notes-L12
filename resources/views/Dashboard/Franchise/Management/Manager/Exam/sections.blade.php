@extends('Layouts.Management.manager')

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
                {{-- Sections Form --}}
                <div id="total_sections" class="d-none">{{ $data['test']->sections }}</div>
                <div class="col-12">
                    <div class="card">
                        <form class="card-body" method="post" id="sections_form">
                            <!-- <div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
                                <button type="button" class="btn btn-outline-primary">
                                    {{ $data['test']->Educationtype->name }}
                                </button>
                                <button type="button" class="btn btn-outline-primary">
                                    {{ $data['test']->EducationClass->name }}
                                </button>
                                <button type="button" class="btn btn-outline-primary">
                                    {{ $data['test']->EducationBoard->name }}
                                </button>
                                @if ($data['test']->OtherCategoryClass)
                                    <button type="button" class="btn btn-outline-primary">
                                        {{ $data['test']->OtherCategoryClass->name }}
                                    </button>
                                @endif
                            </div> -->
                            <!-- <button type="button" class="btn btn-primary float-md-end" onclick="addSection()">
                                <i class="bi bi-plus-circle me-2"></i> Add Section
                            </button> -->
                            @error('sectionsError')
                                <?php
                                $thisErrors = json_decode($errors);
                                // echo $thisErrors->sectionsError->class;
                                ?>
                                <div class="alert alert-{{ $thisErrors->sectionsError->class }} alert-dismissible fade show"
                                    role="alert">
                                    <strong
                                        class="me-2">{{ $thisErrors->sectionsError->class == 'success' ? 'Success' : 'Error' }}</strong>
                                    {!! $thisErrors->sectionsError->message !!}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @enderror
                            @csrf
                            @if (count($data['sections']))
                                @foreach ($data['sections'] as $key => $section)
                                    <div class="alertx alert-primary text-dark test_sections_div"
                                        id="test_sections_{{ $key }}">
                                        <input id="section_id_{{ $key }}" name="section[{{ $key }}][id]"
                                            value="{{ $section['id'] }}" class="d-none">
                                        <div class="row">
                                            <div class="col text-primary">
                                                <h5>Section <span class="section_number"></span></h5>
                                            </div>
                                            
                                            <div class="col text-end">
                                                <button class="btn btn-sm btn-success" type="button" onclick="addSection()">
                                                    <i class="bi bi-plus-circle"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" type="button"
                                                    onclick="removeSection({{ $section['id'] }})">
                                                    <i class="bi bi-trash2"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ $data['test']->Educationtype->name }}
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ $data['test']->EducationClass->name }}
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ $data['test']->EducationBoard->name }}
                                                    </button>
                                                    @if ($data['test']->OtherCategoryClass)
                                                        <button type="button" class="btn btn-outline-primary">
                                                            {{ $data['test']->OtherCategoryClass->name }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Main Subject</b></small>
                                                <select class="form-select form-select-sm section_subject"
                                                    key="{{ $key }}" id="subject_{{ $key }}"
                                                    onchange="changeSubject(this.value, '{{ $key }}')"
                                                    name="section[{{ $key }}][subject]" required>
                                                    <option value=""></option>
                                                    @foreach ($data['subjects'] as $subject)
                                                        <option
                                                            {{ $section['subject'] == $subject['id'] ? 'selected' : '' }}
                                                            value="{{ $subject['id'] }}">{{ $subject['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Subject Part</b></small>
                                                <select class="form-select form-select-sm section_part"
                                                    key="{{ $key }}" id="subject_part_{{ $key }}"
                                                    initialValue="{{ $section['subject_part'] ? $section['subject_part'] : '' }}"
                                                    onchange="changeSubjectPart(this.value, '{{ $key }}')"
                                                    name="section[{{ $key }}][subject_part]" disabled>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Chapter</b></small>
                                                <select class="form-select form-select-sm section_lesson"
                                                    key="{{ $key }}" id="subject_part_lesson_{{ $key }}"
                                                    onchange="changeSubjectChapter(this.value, '{{ $key }}')"
                                                    initialValue="{{ $section['subject_part_lesson'] ? $section['subject_part_lesson'] : '' }}"
                                                    name="section[{{ $key }}][subject_part_lesson]" disabled>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Lesson</b></small>
                                                <select class="form-select form-select-sm gn_section_lesson"
                                                    key="{{ $key }}" id="gn_subject_part_lesson_{{ $key }}"
                                                    initialValue="{{ $section['gn_subject_part_lesson'] ? $section['gn_subject_part_lesson'] : '' }}"
                                                    name="section[{{ $key }}][gn_subject_part_lesson]" disabled>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>No of questions</b></small>
                                                <select class="form-select form-select-sm section_questions"
                                                    key="{{ $key }}"
                                                    name="section[{{ $key }}][number_of_questions]"
                                                    id="number_of_questions_{{ $key }}" required>
                                                    <option value=""></option>
                                                    @for ($i = 1; $i < 201; $i++)
                                                        <option
                                                            {{ $section['number_of_questions'] == $i ? 'selected' : '' }}
                                                            value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Type of Questions</b></small>
                                                <select class="form-select form-select-sm section_questions_type"
                                                    key="{{ $key }}" id="question_type_{{ $key }}"
                                                    onchange="onSelectQuestionType(this.value, {{ $key }})"
                                                    name="section[{{ $key }}][question_type]" required>
                                                    <option value=""></option>
                                                    <option {{ $section['question_type'] == '1' ? 'selected' : '' }}
                                                        value="1">MCQ</option>
                                                    <option {{ $section['question_type'] == '2' ? 'selected' : '' }}
                                                        value="2">Text</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>No of options</b></small>
                                                <select class="form-select form-select-sm section_options"
                                                    key="{{ $key }}" id="mcq_options_{{ $key }}"
                                                    {{ $section['question_type'] == '1' ? '' : 'disabled' }}
                                                    name="section[{{ $key }}][mcq_options]">
                                                    <option value=""></option>
                                                    <option
                                                        {{ $section['question_type'] == '1' && $section['mcq_options'] == '2' ? 'selected' : '' }}
                                                        value="2">2</option>
                                                    <option
                                                        {{ $section['question_type'] == '1' && $section['mcq_options'] == '3' ? 'selected' : '' }}
                                                        value="3">3</option>
                                                    <option
                                                        {{ $section['question_type'] == '1' && $section['mcq_options'] == '4' ? 'selected' : '' }}
                                                        value="4">4</option>
                                                    <option
                                                        {{ $section['question_type'] == '1' && $section['mcq_options'] == '5' ? 'selected' : '' }}
                                                        value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Difficulty Level</b></small>
                                                <select class="form-select form-select-sm section_difficulty"
                                                    key="{{ $key }}" id="difficulty_level_{{ $key }}"
                                                    name="section[{{ $key }}][difficulty_level]" required>
                                                    <option value=""></option>
                                                    @foreach ($data['difficulty_level'] as $difficulty)
                                                        <option
                                                            {{ $section['difficulty_level'] == $difficulty ? 'selected' : '' }}
                                                            value="{{ $difficulty }}">
                                                            {{ $difficulty }}%
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Choose Creator</b></small>
                                                <div class="input-group input-group-sm">
                                                    <select class="form-select form-select-sm section_creator"
                                                        key="{{ $key }}" id="creator_id_{{ $key }}"
                                                        name="section[{{ $key }}][creator_id]">
                                                        <option value=""></option>
                                                        @foreach ($data['creators'] as $creator)
                                                            <option
                                                                {{ $section['creator_id'] == $creator['id'] ? 'selected' : '' }}
                                                                value="{{ $creator['id'] }}">
                                                                {{ $creator['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($section['creator_id'] != $data['auth_id'])
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="notifyCreator('creator_id_{{ $key }}', '{{ $section['id'] }}')">
                                                            {{ $section['creator_notify'] ? 'Notify Again' : 'Notify' }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Date of completion</b></small>
                                                <input type="text" class="form-control form-control-sm flatpickr"
                                                    key="{{ $key }}" id="date_of_completion_{{ $key }}"
                                                    name="section[{{ $key }}][date_of_completion]"
                                                    value="{{ $section['date_of_completion'] }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alertx alert-primary mt-4" id="noSectionAlert">
                                    <div class="row">
                                        <div class="col text-dark text-center pt-2">
                                            <h4>There is no section in this Test, please create some.</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none test_sections_div">
                                </div>
                            @endif
                            <button class="btn btn-success {{ count($data['sections']) ? '' : 'noDisplay' }}" id="saveSectionButton">Save
                                Sections</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="sectionTemplate" type="text/html">
        <div class="alertx alert-primary text-dark test_sections_div" id="test_sections_{0}">
            <input id="section_id_{0}" name="section[{0}][id]" value="0" class="d-none">
            <div class="row">
                <div class="col text-primary">
                    <h5>Section <span class="section_number"></span></h5>
                </div>
                <div class="col text-end">
                    <button class="btn btn-sm btn-success" type="button" onclick="addSection()">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" type="button" onclick="removeDynamicSection(this)">
                        <i class="bi bi-dash-circle"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Main Subject</b></small>
                    <select class="form-select form-select-sm section_subject" key="{0}" id="subject_{0}"
                        onchange="changeSubject(this.value, '{0}')" name="section[{0}][subject]" required>
                        <option value=""></option>
                        @foreach ($data['subjects'] as $subject)
                            <option value="{{ $subject['id'] }}">{{ $subject['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Subject Part</b></small>
                    <select class="form-select form-select-sm section_part" key="{0}" id="subject_part_{0}"
                        onchange="changeSubjectPart(this.value, '{0}')" name="section[{0}][subject_part]" disabled>
                        <option value=""></option>
                        <option value="1">Test</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Chapter</b></small>
                    <select class="form-select form-select-sm section_lesson" key="{0}" id="subject_part_lesson_{0}"
                    onchange="changeSubjectChapter(this.value, '{0}')" name="section[{0}][subject_part_lesson]" disabled>
                        
                        <option value=""></option>
                        <option value="1">Test</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Lesson</b></small>
                    <select class="form-select form-select-sm gn_section_lesson" key="{0}" id="gn_subject_part_lesson_{0}"
                        name="section[{0}][gn_subject_part_lesson]" disabled>
                        <option value=""></option>
                        <option value="1">Test</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>No of questions</b></small>
                    <select class="form-select form-select-sm section_questions" key="{0}"
                        name="section[{0}][number_of_questions]" id="number_of_questions_{0}" required>
                        <option value=""></option>
                        @for ($i = 1; $i < 201; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Type of Questions</b></small>
                    <select class="form-select form-select-sm section_questions_type"
                        onchange="onSelectQuestionType(this.value, {0})" key="{0}" id="question_type_{0}"
                        name="section[{0}][question_type]" required>
                        <option value=""></option>
                        <option value="1">MCQ</option>
                        <option value="2">Text</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>No of options</b></small>
                    <select class="form-select form-select-sm section_options" key="{0}" id="mcq_options_{0}"
                        name="section[{0}][mcq_options]" disabled>
                        <option value=""></option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Difficulty Level</b></small>
                    <select class="form-select form-select-sm section_difficulty" key="{0}" id="difficulty_level_{0}"
                        name="section[{0}][difficulty_level]" required>
                        <option value=""></option>
                        @foreach ($data['difficulty_level'] as $difficulty)
                            <option value="{{ $difficulty }}">
                                {{ $difficulty }}%
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Choose Creator</b></small>
                    <select class="form-select form-select-sm section_creator" key="{0}" id="creator_id_{0}"
                        name="section[{0}][creator_id]">
                        <option value=""></option>
                        @foreach ($data['creators'] as $creator)
                            <option value="{{ $creator['id'] }}">
                                {{ $creator['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <small><b>Date of completion</b></small>
                    <input type="text" class="form-control form-control-sm flatpickr" id="date_of_completion{0}"
                        name="section[{0}][date_of_completion]" placeholder="">
                </div>
            </div>
        </div>
    </script>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admintestsections.js') }}"></script>
@endsection
