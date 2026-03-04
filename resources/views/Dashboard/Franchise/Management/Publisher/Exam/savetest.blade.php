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

        .dashboard-container .form-switch {
            padding-top: 4px;
        }

        .dashboard-container .form-switch label {
            width: -webkit-fill-available;
        }

        .noDisplay {
            display: none;
        }

    </style>
@endsection
@section('main')
    <div class="container p-0">
        <form class="card dashboard-container mb-5" method="post" id="testForm">
            @error('testError')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @error('testSuccess')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            @csrf
            <input type="number" name="id" class="d-none" id="test_id"
                value="{{ $data['test'] ? $data['test']['id'] : '0' }}">
            <input name="form_name" id="testFormName" class="d-none" value="test_form">

            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">
                    <div class="col-12">
                        <div class="alertx alert-primary">
                            <small><b>Test Title</b></small>
                            <input type="text" class="form-control form-control-sm" id="test_title" name="title"
                                value="{{ $data['test'] ? $data['test']['title'] : '' }}" placeholder="Test Title">
                        </div>
                    </div>
                </div>
                {{-- part 3 --}}
                <div class="row mt-3">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Education Type</b></small>
                            <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                id="education_type_id" name="education_type_id" required>
                                <option value="">select</option>
                                @foreach ($data['educations'] as $key => $education)
                                    <option
                                        {{ $data['test'] && $data['test']['education_type_id'] == $education['id'] ? 'selected' : '' }}
                                        value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Class/Group/Exam Name</b></small>
                            <select class="form-select form-select-sm" id="class_group_exam_id" name="class_group_exam_id" onchange="classes_group_exams_change(this.value)">
                                <option value="">Select</option>
                                @if(!empty($data['test']))
                                    @foreach($data['group_classes'] as $group_classes)
                                        <option value="{{ $group_classes->id }}" @if($group_classes->id == $data['test']->education_type_child_id) selected @endif>{{ $group_classes->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Exam Agency/Board/University</b></small>
                            <select class="form-select form-select-sm" id="exam_agency_board_university_id" name="exam_agency_board_university_id" onchange="exam_agency_board_university_change(this.value)" required>
                                <option value="">Select</option>
                                @if(1)
                                    @foreach($data['agency_boards'] as $agency_boards)
                                        <option value="{{ $agency_boards->board_agency_exam_id }}" @if($agency_boards->board_agency_exam_id == $data['test']->board_state_agency) selected @endif>{{ $agency_boards->agencyBoardUniversity->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Other Exam/ Class Detail</b></small>
                            <select class="form-select form-select-sm" id="other_exam_class_detail_id" name="other_exam_class_detail_id" required>
                                <option value="">Select</option>
                                @if(!empty($data['test']))
                                    @foreach($data['other_exams'] as $other_exams)
                                        <option value="{{ $other_exams->id }}" @if($other_exams->id == $data['test']->other_category_class_id) selected @endif>{{ $other_exams->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-3">
                        <div class="alertx alert-primary">
                        <small><b>Marks per Questions</b></small>
                        
                        <!-- <button style="float:right;" type="" id="divno1" class="btn btn-danger btn-sm">No</button>
                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo1" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_marks_per_questions" name="marks_per_questions" onchange="set_negative_marks()" required>
                                <option value="">Select</option>
                                @foreach($data['marks'] as $marks)
                                    <option value="{{ $marks }}" @if(old('marks_per_questions',$data['test']->gn_marks_per_questions) == $marks) selected @endif>{{ $marks }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                        <small><b>Negative Marks per Questions</b></small>
                        
                        <!-- <button style="float:right;" type="" id="divno2" class="btn btn-danger btn-sm">No</button>
                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo2" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_negative_marks" name="negative_marks" disabled required>
                                <option value="">Select</option>
                                @foreach($data['negative_marks'] as $negative_marks)
                                    <option value="{{ $negative_marks['id'] }}" @if(old('negative_marks',$data['test']->negative_marks) == $negative_marks['id']) selected @endif>{{ $negative_marks['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Subjects(s) / Sections(s)</b></small>
                            <select class="form-select form-select-sm" id="no_of_sections" name="no_of_sections"  onchange="addSection()"
                                required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-3">
                        <div class="alertx alert-primary">
                        <small><b>Subjects(s) / Sections(s)</b></small>
                        
                        <!-- <button style="float:right;" type="" id="divno4" class="btn btn-danger btn-sm">No</button>
                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo4" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_no_of_sections" name="no_of_sections" required>
                                <option value="">Select</option>
                                <option value="1" @if($data['test']->sections  == '1') selected @endif>1 Sections</option>
                                <option value="2" @if($data['test']->sections  == '2') selected @endif>2 Sections</option>
                                <option value="3" @if($data['test']->sections  == '3') selected @endif>3 Sections</option>
                                <option value="4" @if($data['test']->sections  == '4') selected @endif>4 Sections</option>
                                <option value="5" @if($data['test']->sections  == '5') selected @endif>5 Sections</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                        <small><b>Total Questions</b></small>
                        
                        <!-- <button style="float:right;" type="" id="divno3" class="btn btn-danger btn-sm">No</button>
                        <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button> -->
                        </div>
                        <div id="divinfo3" style="margin-bottom:20px;">
                            <select class="form-select form-select-sm" id="test_total_questions" name="total_questions" required>
                            @for ($i = 1; $i < 201; $i++)
                                <option
                                    value="{{ $i }}" @if($data['test']->total_questions == $i) selected @endif>{{ $i }} {{ 'Questions' }}
                                </option>
                            @endfor
                            </select>
                        </div>
                    </div>
                </div>
                {{-- part 4 --}}
                <div class="row mt-3">
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Education Type</b></small>
                            <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                id="education_type_id" name="education_type_id" required>
                                <option value="">select</option>
                                @foreach ($data['educations'] as $key => $education)
                                    <option
                                        {{ $data['test'] && $data['test']['education_type_id'] == $education['id'] ? 'selected' : '' }}
                                        value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Class/Group/Exam Name</b></small>
                            <select class="form-select form-select-sm" id="class_group_exam_id" name="class_group_exam_id" onchange="classes_group_exams_change(this.value)">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Exam Agency/Board/University</b></small>
                            <select class="form-select form-select-sm" id="exam_agency_board_university_id" name="exam_agency_board_university_id" onchange="exam_agency_board_university_change(this.value)" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary" id="time_to_complete_div">
                            <small><b>Other Exam/ Class Detail</b></small>
                            <select class="form-select form-select-sm" id="other_exam_class_detail_id" name="other_exam_class_detail_id" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-12 col-sm-6 col-12">
                        <div class="alertx alert-primary {{ ($data['test'] && $data['test']['time_to_complete'] > '0' ? ' noDisplay ' : '') ? ' noDisplay ' : '' }}"
                            id="time_to_complete_div">
                            <small><b>No. of Sections</b></small>
                            <select class="form-select form-select-sm" id="time_to_complete" name="time_to_complete"
                                required>
                                <option value="">Select</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                                <option value="">5</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Main Subject</b></small>
                            <select class="form-select form-select-sm" id="subject_id" name="subject_id" onchange="subjectChange(this.value)" required>
                                <option value="">Select</option>
                                @foreach($data['subject'] as $subject)
                                    <option value="{{ $subject->id }}"> {{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Subject Part</b></small>
                            <select class="form-select form-select-sm" id="subject_part_id" name="subject_part_id" onchange="subjectPartChange(this.value)" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Chapter Name</b></small>
                            <select class="form-select form-select-sm" id="subejct_chapter_id" name="subejct_chapter_id" onchange="subjectChapterChange(this.value)" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary " >
                            <small><b>Lesson Name</b></small>
                            <select class="form-select form-select-sm" id="chapter_lession_id" name="chapter_lession_id" required>
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Extra Requirements</b></small>
                            <input type="text" class="form-control form-control-sm" readonly disabled
                                placeholder="Extra Requirements">
                        </div>
                    </div> -->
                    <!-- <input id="type_of_education" class="d-none"
                        value="{{ $data['test'] && $data['test']['education_type_id'] ? $data['test']['education_type_id'] : '0' }}">
                    <input id="type_of_class" class="d-none"
                        value="{{ $data['test'] && $data['test']['education_type_child_id'] ? $data['test']['education_type_child_id'] : '0' }}">
                    <input id="type_of_board" class="d-none"
                        value="{{ $data['test'] && $data['test']['board_state_agency'] ? $data['test']['board_state_agency'] : '0' }}">
                    <input id="type_of_other" class="d-none"
                        value="{{ $data['test'] && $data['test']['other_category_class_id'] ? $data['test']['other_category_class_id'] : '0' }}">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Type of Education</b></small>
                            <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                id="education_type_id" name="education_type_id" required>
                                <option value=""></option>
                                @foreach ($data['educations'] as $key => $education)
                                    <option
                                        {{ $data['test'] && $data['test']['education_type_id'] == $education['id'] ? 'selected' : '' }}
                                        value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Type of Question</b></small>
                            <select class="form-select form-select-sm" id="type_of_questions" name="type_of_questions"
                                required>
                                <option value="">Select</option>
                                <option value="1">MCQ</option>
                                <option value="2">Value Input</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>No. of Options</b></small>
                            <select class="form-select form-select-sm" id="no_of_options" name="no_of_options"
                                required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>No. of Questions</b></small>
                            <select class="form-select form-select-sm" id="no_of_questions" name="no_of_questions"
                                required>
                                <option value="">Select</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Subjects(s) / Sections(s)</b></small>
                            <select class="form-select form-select-sm" id="no_of_sections" name="no_of_sections"  onchange="addSection()"
                                required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 col-sm-6 col-12">
                        <div class="alertx alert-primary">
                            <small><b>Difficulty Level</b></small>
                            <select class="form-select form-select-sm" id="difficulty_level" name="difficulty_level" required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div> -->
                </div>

                {{-- part 2 --}}
                <!-- <div class="row">
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Result</b></small>
                            <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Solution</b></small>
                            <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Rank</b></small>
                            <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alertx alert-primary">
                            <small><b>Publish Answer(R/W)</b></small>
                            <button style="float:right;" type="" class="btn btn-danger btn-sm">No</button>
                            <button style="float:right;" type="" class="btn btn-success btn-sm">Yes</button>
                        </div>
                    </div>
                </div> -->
                <button type="submit" class="btn btn-success">Save Test</button>

            </div>
            <!-- <div class="card-footer">
                <small><b>Select Creator</b></small>
                <select class="form-select form-select-sm" id="creater_type" name="creater_type" style="margin-bottom: 10px;"required>
                    <option value="">Select</option>
                    <option value="1">Myself</option>
                    <option value="2">Rohit</option>
                    <option value="3">Nitin</option>
                    <option value="4">Joy</option>
                    <option value="5">Dheer</option>
                </select>
        
                <small><b>Select Publisher</b></small>
                <select class="form-select form-select-sm" id="publisher_type" name="publisher_type" style="margin-bottom: 20px;"required>
                <option value="">Select</option>
                    <option value="1">Myself</option>
                    <option value="2">Rohit</option>
                    <option value="3">Nitin</option>
                    <option value="4">Joy</option>
                    <option value="5">Dheer</option>
                </select>
                <button type="submit" class="btn btn-success">Submit Request</button>
                <button type="submit" class="btn btn-success">Create Test</button>
            </div> -->
        </form>
    </div>

    @if($data['show_section'] == 1)
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
                            
                                        <input name="form_name" id="sectionsFormName" class="d-none" value="sections_form">

                                        <div class="row">
                                            <div class="col text-primary">
                                                <h5>Section <span class="section_number"></span></h5>
                                            </div>
                                            
                                            <!-- <div class="col text-end">
                                                <button class="btn btn-sm btn-success" type="button" onclick="addSection()">
                                                    <i class="bi bi-plus-circle"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" type="button"
                                                    onclick="removeSection({{ $section['id'] }})">
                                                    <i class="bi bi-trash2"></i>
                                                </button>
                                            </div> -->
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
                                                    @if ($data['test']->gn_OtherCategoryClass)
                                                        <button type="button" class="btn btn-outline-primary">
                                                            {{ $data['test']->gn_OtherCategoryClass->name }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6 text-end">
                                                <div class="btn-group mb-2" role="group" aria-label="Basic outlined example">
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ $data['test']->gn_marks_per_questions }} {{ 'Marks / Question' }}
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ '-' }} {{ $data['test']->negative_marks }}{{ '%' }} 
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary">
                                                        {{ $data['test']->sections }} {{ 'Sections' }}
                                                    </button>
                                                    @if ($data['test']->gn_OtherCategoryClass)
                                                        <button type="button" class="btn btn-outline-primary">
                                                            {{ 'Total ' }}{{ $data['test']->total_questions }} {{ 'Questions' }}
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
                                                <small><b>Chapter/Lesson</b></small>
                                                <select class="form-select form-select-sm section_lesson"
                                                    key="{{ $key }}" id="subject_part_lesson_{{ $key }}"
                                                    
                                                    initialValue="{{ $section['subject_part_lesson'] ? $section['subject_part_lesson'] : '' }}"
                                                    name="section[{{ $key }}][subject_part_lesson]" disabled>
                                                    <option value=""></option>
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
                                            <!-- <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Lesson</b></small>
                                                <select class="form-select form-select-sm gn_section_lesson"
                                                    key="{{ $key }}" id="gn_subject_part_lesson_{{ $key }}"
                                                    initialValue="{{ $section['gn_subject_part_lesson'] ? $section['gn_subject_part_lesson'] : '' }}"
                                                    name="section[{{ $key }}][gn_subject_part_lesson]" disabled>
                                                    <option value=""></option>
                                                </select>
                                            </div> -->
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Type of Questions</b></small>
                                                <select class="form-select form-select-sm section_questions_type"
                                                    key="{{ $key }}" id="question_type_{{ $key }}"
                                                    onchange="onSelectQuestionType(this.value, {{ $key }})"
                                                    name="section[{{ $key }}][question_type]" required>
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
                                                <small><b>No of questions</b></small>
                                                <select class="form-select form-select-sm section_questions"
                                                    key="{{ $key }}"
                                                    name="section[{{ $key }}][number_of_questions]"
                                                    id="number_of_questions_{{ $key }}"
                                                    initialValue="{{ $section['number_of_questions'] }} "
                                                    onchange="onChangeQustions(this.value,{{ $key }})" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Test Duration</b></small>
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
                                            </div> -->
                                            <div class="col-md-3 col-sm-6 col-12 {{ ($data['test'] && $data['test']['time_to_complete'] > '0' ? ' noDisplay ' : '') ? ' noDisplay ' : '' }}"
                                                id="time_to_complete_div">
                                                <small><b>Duration (per Question)</b></small>
                                                <select class="form-select form-select-sm select_duration"
                                                key="{{ $key }}" 
                                                id="duration__{{ $key }}" 
                                                name="section[{{ $key }}][duration]" required>
                                                <option value=""></option>
                                                    @for ($i = 1; $i < 201; $i++)
                                                        <option value="{{ $i }}" {{ $i == $section['duration'] ? 'selected' : '' }} >{{ $i }} {{ 'Minutes' }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-3 col-sm-6 col-12">
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
                                            </div> -->
                                            
                                            <!-- <div class="col-md-3 col-sm-6 col-12">
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
                                            </div> -->
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Test Creator</b></small>
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
                                                <small><b>Test Submission Date</b></small>
                                                <input type="text" class="form-control form-control-sm flatpickr"
                                                    key="{{ $key }}" id="date_of_completion_{{ $key }}"
                                                    name="section[{{ $key }}][date_of_completion]"
                                                    value="{{ $section['date_of_completion'] }}">
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Test Publisher</b></small>
                                                <div class="input-group input-group-sm">
                                                    <select class="form-select form-select-sm section_creator"
                                                        key="{{ $key }}" id="publisher_id_{{ $key }}"
                                                        name="section[{{ $key }}][publisher_id]">
                                                        <option value=""></option>
                                                        @foreach ($data['publishers'] as $creator)
                                                            <option
                                                                {{ $section['publisher_id'] == $creator['id'] ? 'selected' : '' }}
                                                                value="{{ $creator['id'] }}">
                                                                {{ $creator['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($section['publishers'] != $data['auth_id'])
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="notifyCreator('publisher_id_{{ $key }}', '{{ $section['id'] }}')">
                                                            {{ $section['creator_notify'] ? 'Notify Again' : 'Notify' }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <small><b>Test Publishing Date</b></small>
                                                <input type="text" class="form-control form-control-sm flatpickr"
                                                    key="{{ $key }}" id="publishing_date_{{ $key }}"
                                                    name="section[{{ $key }}][publishing_date]"
                                                    value="{{ $section['publishing_date'] }}">
                                            </div>
                                            <div class="col-md-12 col-sm-6 col-12">
                                                <small><b>Instruction/Notes</b></small>
                                                <textarea class="form-control" 
                                                key="{{ $key }}" 
                                                id="section_instruction_{{ $key }}" 
                                                name="section[{{ $key }}][section_instruction]"
                                                rows="5">{{ $section['section_instruction'] }}</textarea>
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
                            <button class="btn btn-success {{ count($data['sections']) ? '' : 'noDisplay' }}" id="saveSectionButton">Save Sections</button>
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
    @endif

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('js/franchise/franchisetest.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/franchise/franchisetestsections.js') }}"></script>
@endsection
