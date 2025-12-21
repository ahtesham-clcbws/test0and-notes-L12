<?php if (isset($UserDetails) && isset($UserDetails->class)) {
    $class = $UserDetails->class;
} else {
    $class = 0;
} ?>
<?php if (isset($UserDetails) && isset($UserDetails->board)) {
    $board = $UserDetails->board;
} else {
    $board = 0;
} ?>
<?php if (isset($UserDetails) && isset($UserDetails->other_exam)) {
    $other_exam = $UserDetails->other_exam;
} else {
    $other_exam = 0;
} ?>
<?php if (isset($UserDetails) && isset($UserDetails->subject)) {
    $subject = $UserDetails->subject;
} else {
    $subject = 0;
} ?>
<?php if (isset($UserDetails) && isset($UserDetails->subject_part)) {
    $subject_part = $UserDetails->subject_part;
} else {
    $subject_part = 0;
} ?>
@extends('Layouts.franchise', ['class' => $class, 'board' => $board, 'other_exam' => $other_exam, 'subject' => $subject, 'subject_part' => $subject_part])

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
        <form class="card dashboard-container mb-5" id="studymaterial_form" method="post">
            @error('testError')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            @enderror
            @error('testSuccess')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            @enderror
            @csrf
            <!-- <input class="d-none" id="id" name="id" type="number" value="">
                <input class="d-none" id="testFormName" name="form_name" value="package_plan"> -->

            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Title">Title</label>
                            <input class="form-control form-control-sm" name="title" type="text"
                                value="<?php if (isset($UserDetails) && isset($UserDetails->title)) {
                                    echo $UserDetails->title;
                                } ?>" style="border: 1px solid #aaa;" placeholder="Enter Title"
                                required="">
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Sub Title">Sub Title</label>
                            <input class="form-control form-control-sm" name="sub_title" type="text"
                                value="<?php if (isset($UserDetails) && isset($UserDetails->sub_title)) {
                                    echo $UserDetails->sub_title;
                                } ?>" style="border: 1px solid #aaa;" placeholder="Enter Sub Title"
                                required="">
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Study Material Category">Study Material Category</label>
                            <select class="form-select form-select-sm select2" id="category" name="category" required>
                                <option value="" default selected> Select Study Material Category</option>
                                <option value="Study Notes & E-Books" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Study Notes & E-Books') {
                                    echo 'selected';
                                } ?>>Study Notes & E-Books</option>
                                <option value="Live & Video Classes" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Live & Video Classes') {
                                    echo 'selected';
                                } ?>>Live & Video Classes</option>
                                <option value="Static GK & Current Affairs" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Static GK & Current Affairs') {
                                    echo 'selected';
                                } ?>>Static GK & Current Affairs
                                </option>
                                <option value="Comprehensive Study Material" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Comprehensive Study Material') {
                                    echo 'selected';
                                } ?>>Comprehensive Study
                                    Material</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Education Type">Education Type</label>
                            <select class="form-select form-select-sm" id="education_type_id" name="education_type_id"
                                onchange="getClassesByEducation(this.value)" required>
                                <option value="" default selected> Select Education Type</option>
                                @if (isset($gn_EduTypes))
                                    @foreach ($gn_EduTypes as $u)
                                        <option value="{{ $u->id }}" <?php if (isset($UserDetails) && isset($UserDetails->education_type) && $UserDetails->education_type == $u->id) {
                                            echo 'selected';
                                        } ?>>{{ $u->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Class/Group/Exam Name">Class/Group/Exam Name</label>
                            <select class="form-select form-select-sm" id="class_group_exam_id" name="class_group_exam_id"
                                onchange="classes_group_exams_change(this.value);partClassChange(this.value)" required>
                                <option value="" default selected>Select Class/Group/Exam Name</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Exam Agency/Board/University">Exam
                                Agency/Board/University</label>
                            <select class="form-select form-select-sm" id="exam_agency_board_university_id"
                                name="exam_agency_board_university_id"
                                onchange="exam_agency_board_university_change(this.value)" required>
                                <option value="" default selected> Select Exam Agency/Board/University</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Other Exam/ Class Detail">Other Exam/ Class Detail</label>
                            <select class="form-select form-select-sm" id="other_exam_class_detail_id"
                                name="other_exam_class_detail_id" required>
                                <option value="" default selected> Select Other Exam/ Class Detail</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Subject">Subject</label>
                            <select class="form-select form-select-sm" id="part_subject_id" name="part_subject_id"
                                onchange="lessonSubjectChange(this.value)" required>
                                <option value="" default selected> Select Subject</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Subject Part">Subject part</label>
                            <select class="form-select form-select-sm" id="lesson_subject_part_id"
                                name="lesson_subject_part_id" required>
                                <option value="" default selected> Select Subject Part</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Permission to Download">Permission to Download</label>
                            <select class="form-select form-select-sm select2" id="permission" name="permission"
                                required>
                                <option value="Free View" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Free view') {
                                    echo 'selected';
                                } ?>>Free View</option>
                                <option value="Free View & Download" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Free View & Download') {
                                    echo 'selected';
                                } ?>>Free View & Download</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Document Upload Type">Document Upload Type</label>
                            <select class="form-select form-select-sm select2" id="document_type" name="document_type"
                                required>
                                <option value="PDF" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'PDF') {
                                    echo 'selected';
                                } ?>>PDF</option>
                                <option value="WORD" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'WORD') {
                                    echo 'selected';
                                } ?>>WORD</option>
                                <option value="EXCEL" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'EXCEL') {
                                    echo 'selected';
                                } ?>>EXCEL</option>
                                <option value="VIDEO" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'VIDEO') {
                                    echo 'selected';
                                } ?>>VIDEO</option>
                                <option value="AUDIO" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'AUDIO') {
                                    echo 'selected';
                                } ?>>AUDIO</option>
                                <option value="YOUTUBE" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'YOUTUBE') {
                                    echo 'selected';
                                } ?>>YOUTUBE</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Publish Date">Publish Date</label>
                            <input class="form-control form-control-sm" id="publish_date" name="publish_date"
                                type="date" value="<?php if (isset($UserDetails) && isset($UserDetails->publish_date)) {
                                    echo $UserDetails->publish_date;
                                } ?>" required>
                        </div>
                    </div>

                    <div class="col-md-5 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Video Link">Video Link</label>
                            <input class="form-control form-control-sm" id="video_link" name="video_link" type="text"
                                value="<?php if (isset($UserDetails) && isset($UserDetails->video_link)) {
                                    echo $UserDetails->video_link;
                                } ?>" style="border: 1px solid #aaa;"
                                placeholder="Enter Video Link" disabled>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Select File">Select File</label>
                            @if (isset($UserDetails) && isset($UserDetails->file) && $UserDetails->file != 'NA')
                                <?php $file = explode('/', $UserDetails->file); ?>
                                <a class="download" href="{{ route('franchise.management.download', $file[1]) }}"
                                    title="Download File" style="float:right;" data='{{ $UserDetails->file }}'><i
                                        class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>
                            @endif
                            <input class="form-control form-select-sm" id="material_file" name="material_file"
                                type="file" accept="" required>

                        </div>
                    </div>

                    @if (isset($UserDetails))
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="control-label" for="Remarks">Remarks</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="1"><?php if (isset($UserDetails) && isset($UserDetails->remarks)) {
                                    echo $UserDetails->remarks;
                                } ?></textarea>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="form-group" style="float:right;">
                                @if (isset($UserDetails))
                                    @if (isset($UserDetails->material_seen) && $UserDetails->material_seen == 1)
                                        <button class="btn btn-info" id="pause_material" type="button"
                                            title="Pause Study Material!">Pause Material</button>
                                    @else
                                        <button class="btn btn-info" id="pause_material" type="button"
                                            title="Active Study Material!">Active Material</button>
                                    @endif
                                @endif
                                <input id="pause_val" name="pause_val" type="hidden" value="<?php if (isset($UserDetails) && isset($UserDetails->material_seen)) {
                                    echo $UserDetails->material_seen;
                                } ?>">
                                @if (isset($UserDetails))
                                    <button class="btn btn-warning publish" id="sendback_material"
                                        name="sendback_material" type="button" title="Send Back Contributor!">Send Back
                                        Contributor</button>
                                    @if (isset($publish_content) && $publish_content == 1)
                                        <button class="btn btn-primary publish" type="submit"
                                            title="Publish Study Material!">Publish Material</button>
                                    @endif
                                @else
                                    <button class="btn btn-primary publish" type="submit"
                                        title="Publish Study Material!">Publish Material</button>
                                @endif
                                <input id="material_id" name="material_id" type="hidden" value="<?php if (isset($UserDetails) && isset($UserDetails->id)) {
                                    echo $UserDetails->id;
                                } else {
                                    echo 0;
                                } ?>">
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>

@endsection

@section('javascript')
    <script>
        var storematerial = "{{ route('franchise.management.store') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            console.log("inside ready");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on("submit", "#studymaterial_form", function(e) {
                console.log("inside submit");
                e.preventDefault();
                $('.publish').attr('disabled', 'disabled');
                var values = {};
                // $.each($("form#studymaterial_form").serializeArray(), function (i, field) {
                // 	values[field.name] = field.value;
                // });

                // console.log("Data:",values);
                let timerInterval;
                Swal.fire({
                    title: 'Wait...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                        }, 1000);
                    },
                });
                var formData = new FormData($(this)[0]);
                formData.append('form_name', 'studymaterial_form');
                console.log(formData);

                $.ajax({
                    data: formData,
                    url: storematerial,
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        willClose: () => {
                            clearInterval(timerInterval)
                        }

                        alert(data['message']);
                        $('#studymaterial_form')[0].reset();
                        $(".publish").removeAttr('disabled');
                        location.href = '{!! route('franchise.management.material') !!}'
                    }
                });
            });

            $(document).on("click", "#pause_material", function(e) {
                e.preventDefault();
                var pause_value = $('#pause_val').val();
                var material_id = $('#material_id').val();

                console.log("pause values:", pause_value, material_id);

                $.ajax({
                    data: {
                        pause_value: pause_value,
                        material_id: material_id
                    },
                    url: '{!! route('franchise.management.material_pause') !!}',
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        alert(data['message']);
                        location.href = '{!! route('franchise.management.material') !!}'
                    }
                });
            });

            $(document).on("click", "#sendback_material", function(e) {
                e.preventDefault();
                var material_id = $('#material_id').val();
                var remarks = $('#remarks').val();

                if (remarks != '') {
                    $.ajax({
                        data: {
                            material_id: material_id,
                            remarks: remarks
                        },
                        url: '{!! route('franchise.management.material_sendback') !!}',
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            alert(data['message']);
                            location.href = '{!! route('franchise.management.material') !!}'
                        }
                    });
                } else {
                    alert('Remarks value should not empty!');
                }

            });

            $(document).on("change", "#document_type", function(e) {
                e.preventDefault();
                var doc_type = $(this).val();
                console.log("doc_type:", doc_type);
                if (doc_type == 'YOUTUBE') {
                    $("#video_link").removeAttr("disabled");
                    $("#video_link").attr("required", "true");
                    $("#material_file").attr("disabled", "disabled");
                    $("#material_file").removeAttr("required");
                } else {
                    $("#video_link").attr("disabled", "disabled");
                    $("#video_link").removeAttr("required");
                    $("#material_file").removeAttr("disabled");
                    @if (isset($UserDetails))
                        $("#material_file").removeAttr("required");
                    @else
                        $("#material_file").attr("required", "true");
                    @endif
                }
            });

            @if (isset($UserDetails))
                $('#education_type_id').trigger('change');
                $('#document_type').trigger('change');
            @endif
        });
    </script>
@endsection
