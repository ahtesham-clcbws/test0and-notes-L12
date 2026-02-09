@extends('Layouts.admin')

@section('main')
    <style>
        /* .dashboard-container {
            padding: calc(var(--bs-gutter-x) * .5);
            padding-bottom: 0;
        } */

        /* .dashboard-container .alertx {
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
        } */

    </style>

    <div class="container p-0">
        <div class="dashboard-container mb-5">
            @error('Error')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror
            <!-- <div class="row border-bottom pb-3">
                {{-- Education type child / Class - group - exam --}}
                <div class="col-md-12 col-sm-6 col-12">
                    <form class="card" method="post" id="classForm">
                        @csrf
                        <div class="card-header bg-primary text-white">
                            Quick Add
                        </div>
                        <input type="number" name="id" class="d-none" id="class_id" value="0">
                        <input name="form_name" id="classFormName" class="d-none" value="class_form">
                        <div class="card-body">
                            @error('classError')
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @enderror
                            @error('classSuccess')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @enderror
                            <div class="mb-3">
                                <label for="education_type_id" class="form-label">Education Type</label>
                                <select class="form-select form-select-sm" id="education_type_id" name="education_type_id" onchange="quickAddEducationTypeChange(this.value)">
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_group_exam" class="form-label">Class / Group / Exam Name</label>
                                <select class="form-select form-select-sm" multiple id="class_group_exam" name="class_group_exam[]" onchange="classes_group_exams_change(this.value)" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_boards" class="form-label"> Exam Agency / Board / University</label>
                                <select class="form-select form-select-sm" multiple id="class_boards" name="boards[]" onchange="classes_exams_board_change()" >
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_subjects" class="form-label">Other Exam / Class Detail</label>
                                <select class="form-select form-select-sm" multiple id="class_other_exam_detail"
                                    name="class_other_exam_detail[]" {{ count($data['subjects']) ? '' : 'disabled' }}>
                                    @foreach ($data['subjects'] as $key => $subject)
                                        <option value="{{ $subject['id'] }}">{{ $subject['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button type="button" class="btn btn-danger resetbtn" id="classReset"
                                    onclick="resetForm('class')">Reset</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div> -->
                <!-- <div class="col-md-9 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Type</th>
                                        <th scope="col">Class/Group/Exam</th>
                                        <th scope="col">Board/State/Agency</th>
                                        <th scope="col">Subjects</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['classes'] as $key => $class)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>

                                            <td>{{ $class['name'] }}</td>
                                            <td>
                                                @foreach ($class->class_boards as $board)
                                                    <span class="commaSeperatedSpan">{{ $board->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($class->class_subjects as $sunject)
                                                    <span class="commaSeperatedSpan">{{ $sunject->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-end" style="min-width: 60px;">
                                                <a href="javascript:void(0);"><i
                                                        class="bi bi-pencil-square text-success me-2"
                                                        onclick="editForm({{ $class['id'] }}, '{{ $class['name'] }}', 'class', '{{ $class['education_type_id'] }}', '{{ $class['boards'] }}', '{{ $class['subjects'] }}')"></i></a>
                                                <a href="#"><i class="bi bi-trash2-fill text-danger"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
            <!-- </div> -->
            <div class="row border-bottom mt-3 pb-3">
                {{-- Education type --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <form class="card" method="post" id="educationForm">
                        @csrf
                        @error('educationError')
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('educationSuccess')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="card-header bg-info">Education Type</div>
                        <input type="number" name="id" class="d-none" id="education_id" value="0">
                        <input name="form_name" id="educationFormName" class="d-none" value="education_form">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="class_boards" class="form-label"> Education Type</label>
                                <!-- <input type="text" name="name" class="form-control form-control-sm" id="education_name" required> -->
                                <select class="form-select form-select-sm" multiple id="education_name" name="name[]" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="education_slug" class="form-label"> Slug</label>
                                <input type="text" name="slug" class="form-control form-control-sm" id="education_slug">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="education_name" class="form-label">Name / Title</label>
                                <input type="text" name="name" class="form-control form-control-sm" id="education_name" required>
                            </div> -->
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button type="button" class="btn btn-danger resetbtn" id="educationReset" onclick="resetForm('education')">Reset</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Type</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['educations'] as $key => $education)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $education['name'] }}</td>
                                            <td>{{ $education['slug'] }}</td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);"><i
                                                        class="bi bi-pencil-square text-success me-2"
                                                        onclick="editForm({{ $education['id'] }}, '{{ $education['name'] }}', 'education', 0, '', '', '', '{{ $education['slug'] }}')"></i></a>
                                                <a href="javascript:void(0);"><i class="bi bi-trash2-fill text-danger" onclick="deleteEducationType({{ $education['id'] }})"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mt-3 pb-3">
                {{-- Education type child 2 / Board - exam - state --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <form class="card" method="post" id="class_group_examForm">
                        @csrf
                        @error('examError')
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('examSuccess')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="card-header bg-warning">
                            Class / Group / Exam Name
                        </div>
                        <input type="number" name="id" class="d-none" id="class_group_exam_id" value="0">
                        <input name="form_name" id="class_group_examFormName" class="d-none" value="exam_form">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="education_type_id" class="form-label">Education Type</label>
                                <select class="form-select form-select-sm" id="exam_education_type_id" name="exam_education_type_id"
                                    {{ count($data['educations']) ? '' : 'disabled' }} required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="class_group_exam_name_id" class="form-label"> Class / Group / Exam Name</label>
                                <select class="form-select form-select-sm" multiple id="class_group_exam_name_id" name="name[]" required>
                                    @foreach($data['class_data'] as $class)
                                        <option value="{{ $class->id }}"> {{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="board_name" class="form-label">Name / Title</label>
                                <input type="text" name="name" class="form-control form-control-sm" id="class_group_exam_name"
                                    required>
                            </div> -->

                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button type="button" class="btn btn-danger resetbtn" id="class_group_examReset"
                                    onclick="resetForm('class_group_exam')">Reset</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Type</th>
                                        <th scope="col">Class / Group / Exam Name</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['exam'] as $key => $exam)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>

                                            <td>@if(!empty($exam->education['name']))
                                                    {{ $exam->education['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif </td>
                                            <td>
                                                @foreach($exam->class_exam as $class_group_exam_name)
                                                    <span class="commaSeperatedSpan">{{ $class_group_exam_name->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);"><i
                                                        class="bi bi-pencil-square text-success me-2"
                                                        onclick="editForm( {{ $exam['id'] }}, '{{ $exam['class_group_exam_name'] }}', 'class_group_exam', '{{ $exam['education_type_id'] }}')"></i></a>
                                                <a href="javascript:void(0);"><i class="bi bi-trash2-fill text-danger" onclick="deleteClassGroup({{ $exam['id'] }}, {{ $exam['education_type_id'] }})"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mt-3 pb-3">
                {{-- Education type child 2 / Board - exam - state --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <form class="card" method="post" id="boardForm">
                        @csrf
                        @error('boardError')
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('boardSuccess')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="card-header bg-warning">
                            Exam Agency / Board / University
                        </div>
                        <input type="number" name="id" class="d-none" id="board_id" value="0">
                        <input name="form_name" id="boardFormName" class="d-none" value="board_form">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="board_education_type_id" class="form-label">Education Type</label>
                                <select class="form-select form-select-sm" id="board_education_type_id" name="education_type_id"
                                    {{ count($data['educations']) ? '' : 'disabled' }} onchange="educationTypeChange(this.value)" required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" id="board_class_group">
                                <label for="board_class_group_exam" class="form-label">Class / Group / Exam Name</label>
                                <select class="form-select form-select-sm" id="board_class_group_exam" name="classes_group_exams_id"
                                    disabled required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="board_name_id" class="form-label"> Name / Title</label>
                                <select class="form-select form-select-sm" multiple id="board_name_id" name="name[]" required>
                                    @foreach($data['boards'] as $boards)
                                        <option value="{{ $boards->id }}"> {{ $boards->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button type="button" class="btn btn-danger resetbtn" id="boardReset"
                                    onclick="resetForm('board')">Reset</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Type</th>
                                        <th scope="col">Class / Group / Exam Name</th>
                                        <th scope="col">Exam Agency / Board / University</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['gn_exam_agency_board'] as $key => $board)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>

                                            <td>
                                                @if(!empty($board->education['name']))
                                                    {{ $board->education['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($board->classesGroupExam['name']))
                                                    {{  $board->classesGroupExam['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($board['board_id']))
                                                    @foreach(json_decode($board['board_id']) as $board1)
                                                        <span class="commaSeperatedSpan">{{  \App\Models\BoardAgencyStateModel::find($board1)->name }}</span>
                                                    @endforeach
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);">
                                                    <i  class="bi bi-pencil-square text-success me-2"
                                                        onclick="editForm({{ $board['id'] }}, '{{ $board['board_id'] }}', 'board','{{ $board->education_type_id }}','','','{{ $board->classes_group_exams_id }}')">
                                                    </i>
                                                </a>
                                                <a href="javascript:void(0);">
                                                    <i  class="bi bi-trash2-fill text-danger"
                                                        onclick="deleteExamAgencyBoard({{ $board['education_type_id'] }},{{ $board['classes_group_exams_id'] }},{{ $board['board_id'] }},{{ $board['id'] }})">
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mt-3 pb-3">
                {{-- Education type child 2 / Board - exam - state --}}
                <div class="col-md-3 col-sm-6 col-12">
                    <form class="card" method="post" id="otherExamForm">
                        @csrf
                        @error('otherExamError')
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('otherExamSuccess')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        <div class="card-header bg-warning">
                            Other Exam / Class Detail
                        </div>
                        <input type="number" name="id" class="d-none" id="otherExam_id" value="0">
                        <input name="form_name" id="boardFormName" class="d-none" value="otherExam_form">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="other_exam_education_type_id" class="form-label">Education Type</label>
                                <select class="form-select form-select-sm" id="other_exam_education_type_id" name="education_type_id" onchange="other_exam_education_type_change(this.value)"
                                    {{ count($data['educations']) ? '' : 'disabled' }} required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="education_type_id" class="form-label">Class / Group / Exam Name</label>
                                <select class="form-select form-select-sm" id="other_exam_class_group_exam_id" name="classes_group_exams_id" onchange="other_exam_classes_group_exams_change(this.value)"
                                    {{ count($data['educations']) ? '' : 'disabled' }} required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="other_exam_agency_board_university_id" class="form-label">Exam Agency / Board / University</label>
                                <select class="form-select form-select-sm" id="other_exam_agency_board_university_id" name="agency_board_university_id"
                                    {{ count($data['educations']) ? '' : 'disabled' }} required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="other_exam_name_id" class="form-label"> Name / Title</label>
                                <select class="form-select form-select-sm" multiple id="other_exam_name_id" name="name[]" required>
                                    @foreach($data['gn_other_exam_classes'] as $gn_other_exam_classes)
                                        <option value="{{ $gn_other_exam_classes->id }}">{{ $gn_other_exam_classes->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="board_name" class="form-label">Name / Title</label>
                                <input type="text" name="name" class="form-control form-control-sm" id="board_name"
                                    required>
                            </div> -->

                            <div class="btn-group btn-group-sm w-100" role="group">
                                <button type="button" class="btn btn-danger resetbtn" id="otherExamReset"
                                    onclick="resetForm('otherExam')">Reset</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Education Type</th>
                                        <th scope="col">Class / Group / Exam Name</th>
                                        <th scope="col">Exam Agency / Board / University</th>
                                        <th scope="col">Other Exam / Class Detail</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['other_exam_classes'] as $key => $other_exam_class)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>
                                                @if(!empty($other_exam_class->education['name']))
                                                    {{ $other_exam_class->education['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($other_exam_class->classesGroupExam['name']))
                                                    {{ $other_exam_class->classesGroupExam['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($other_exam_class->boardAgencyState['name']))
                                                    {{ $other_exam_class->boardAgencyState['name'] }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($other_exam_class['other_exam_id']))
                                                    @foreach(json_decode($other_exam_class['other_exam_id']) as $other_exam_id)
                                                        <span class="commaSeperatedSpan">{{  \App\Models\Gn_OtherExamClassDetailModel::find($other_exam_id)->name }}</span>
                                                    @endforeach
                                                @endif
                                                </td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);"><i
                                                        class="bi bi-pencil-square text-success me-2"
                                                        onclick="editForm({{ $other_exam_class['id'] }}, '{{ $other_exam_class['other_exam_id'] }}', 'otherExam' , '{{ $other_exam_class['education_type_id'] }}','{{ $other_exam_class['agency_board_university_id'] }}','','{{ $other_exam_class['classes_group_exams_id'] }}')"></i></a>
                                                <a href="javascript:void(0);"><i class="bi bi-trash2-fill text-danger" onclick="deleteOtherExamClass({{ $other_exam_class['education_type_id'] }},{{ $other_exam_class['classes_group_exams_id'] }},{{ $other_exam_class['agency_board_university_id'] }})"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                <!-- <div class="row mt-3 pb-3">
                    {{-- Other category / class --}}
                    <div class="col-md-3 col-sm-6 col-12">
                        <form class="card" method="post" id="otherForm">
                            @csrf
                            @error('otherError')
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @enderror
                            @error('otherSuccess')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @enderror
                            <div class="card-header bg-danger text-white">
                                Other Category / Class
                            </div>
                            <input type="number" name="id" class="d-none" id="other_id" value="0">
                            <input name="form_name" id="otherFormName" class="d-none" value="other_form">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="other_name" class="form-label">Name / Title</label>
                                    <input type="text" name="name" class="form-control form-control-sm" id="other_name"
                                        required>
                                </div>
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <button type="button" class="btn btn-danger resetbtn" id="otherReset"
                                        onclick="resetForm('other')">Reset</button>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Other Category</th>
                                            <th scope="col" class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['others'] as $key => $other)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $other['name'] }}</td>
                                                <td class="text-end">
                                                    <a href="javascript:void(0);"><i
                                                            class="bi bi-pencil-square text-success me-2"
                                                            onclick="editForm({{ $other['id'] }}, '{{ $other['name'] }}', 'other')"></i></a>
                                                    <a href="#"><i class="bi bi-trash2-fill text-danger"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
        </div>
        <div class="row border-bottom mt-3 pb-3">
            {{-- Master Class List --}}
            <div class="col-md-4 col-sm-12">
                <form class="card" method="post" id="masterClassForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-primary text-white">Edit Master Class</div>
                    <input type="hidden" name="id" id="master_class_id" value="0">
                    <input type="hidden" name="form_name" value="master_class_form">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="master_class_name" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control form-control-sm">
                            <div id="master_class_image_preview" class="mt-2 text-center"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Summary</label>
                            <textarea name="summary" id="master_class_summary" class="form-control form-control-sm" rows="3"></textarea>
                        </div>
                        <div class="btn-group btn-group-sm w-100">
                            <button type="button" class="btn btn-danger" onclick="resetMasterClassForm()">Reset</button>
                            <button type="submit" class="btn btn-success">Update Class</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">Master Class List</div>
                    <div class="card-body">
                        <table class="table table-sm datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Summary</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['class_data'] as $key => $class)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($class->image)
                                                <img src="/storage/{{ $class->image }}" width="50">
                                            @else
                                                <img src="{{ asset('default.webp') }}" width="50">
                                            @endif
                                        </td>
                                        <td>{{ $class->name }}</td>
                                        <td><small>{{ Str::limit($class->summary, 50) }}</small></td>
                                        <td class="text-end">
                                            <a href="javascript:void(0);" onclick="editMasterClass({{ $class->id }}, '{{ addslashes($class->name) }}', '{{ addslashes($class->summary) }}', '{{ $class->image }}')">
                                                <i class="bi bi-pencil-square text-success"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/admineducationtypes.js') }}"></script>
@endsection
