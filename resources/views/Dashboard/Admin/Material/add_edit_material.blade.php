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
@extends('Layouts.admin', ['class' => $class, 'board' => $board, 'other_exam' => $other_exam, 'subject' => $subject, 'subject_part' => $subject_part])

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
    <form class="card dashboard-container mb-5" method="post" id="studymaterial_form" enctype="multipart/form-data">
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

        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="card-body">
            <!-- part 1 -->
            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Select File" class="control-label">Study Material Image</label>
                        @if (isset($UserDetails) && isset($UserDetails->study_material_image) && $UserDetails->study_material_image != 'NA')
                        <?php $study_material_image = explode('/', $UserDetails->study_material_image); ?>
                        <a href="{{ '/storage/app/study_material_image/' . $study_material_image[1] }}"
                            class="download" data='{{ $UserDetails->study_material_image }}' style="float:right;"
                            title="Download File"><i class="bi bi-download text-danger me-2"
                                aria-hidden="true"></i></a>
                        @endif
                        <input type="file" accept="" id="study_material_image" name="study_material_image"
                            class="form-control form-select-sm">

                    </div>
                </div>



                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Title" class="control-label">Title</label>
                        <input type="text" name="title" class="form-control form-control-sm"
                            placeholder="Enter Title" style="border: 1px solid #aaa;" value="<?php if (isset($UserDetails) && isset($UserDetails->title)) {
                                                                                                    echo $UserDetails->title;
                                                                                                } ?>"
                            required="">
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Sub Title" class="control-label">Sub Title</label>
                        <input type="text" name="sub_title" class="form-control form-control-sm"
                            placeholder="Enter Sub Title" style="border: 1px solid #aaa;" value="<?php if (isset($UserDetails) && isset($UserDetails->sub_title)) {
                                                                                                        echo $UserDetails->sub_title;
                                                                                                    } ?>"
                            required="">
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Study Material Category" class="control-label">Study Material Category</label>
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
                            <option value="Short Notes & One Liner" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Short Notes & One Liner') {
                                                                        echo 'selected';
                                                                    } ?>>Short Notes & One Liner
                            </option>
                            <option value="Premium Study Notes" <?php if (isset($UserDetails) && isset($UserDetails->category) && $UserDetails->category == 'Premium Study Niotes') {
                                                                    echo 'selected';
                                                                } ?>>Premium Study Notes</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Education Type" class="control-label">Education Type</label>
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

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Class/Group/Exam Name" class="control-label">Class/Group/Exam Name</label>
                        <select class="form-select form-select-sm" id="class_group_exam_id" name="class_group_exam_id"
                            onchange="classes_group_exams_change(this.value);partClassChange(this.value)" required>
                            <option value="" default selected>Select Class/Group/Exam Name</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Exam Agency/Board/University" class="control-label">Exam
                            Agency/Board/University</label>
                        <select class="form-select form-select-sm" id="exam_agency_board_university_id"
                            name="exam_agency_board_university_id"
                            onchange="exam_agency_board_university_change(this.value)" required>
                            <option value="" default selected> Select Exam Agency/Board/University</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Other Exam/ Class Detail" class="control-label">Other Exam/ Class Detail</label>
                        <select class="form-select form-select-sm" id="other_exam_class_detail_id"
                            name="other_exam_class_detail_id" required>
                            <option value="" default selected> Select Other Exam/ Class Detail</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Subject" class="control-label">Subject</label>
                        <select class="form-select form-select-sm" id="part_subject_id" name="part_subject_id"
                            onchange="lessonSubjectChange(this.value)" required>
                            <option value="" default selected> Select Subject</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Subject Part" class="control-label">Subject part</label>
                        <select class="form-select form-select-sm" id="lesson_subject_part_id"
                            name="lesson_subject_part_id" required>
                            <option value="" default selected> Select Subject Part</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Permission to Download" class="control-label">Permission to Download</label>
                        <select class="form-select form-select-sm select2" id="permission" name="permission"
                            required>
                            <option value="Free View" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Free view') {
                                                            echo 'selected';
                                                        } ?>>Free View</option>
                            <option value="Free View & Download" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Free View & Download') {
                                                                        echo 'selected';
                                                                    } ?>>Free View & Download</option>
                            <option value="Premium View" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Premium View') {
                                                                echo 'selected';
                                                            } ?>>Premium View</option>
                            <option value="Premium View & Download" <?php if (isset($UserDetails) && isset($UserDetails->permission_to_download) && $UserDetails->permission_to_download == 'Premium View & Download') {
                                                                        echo 'selected';
                                                                    } ?>>Premium View & Download
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Document Upload Type" class="control-label">Document Upload Type</label>
                        <select class="form-select form-select-sm select2" id="document_type" name="document_type"
                            required>
                            <option value="PDF" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'PDF') {
                                                    echo 'selected';
                                                } ?>>PDF</option>
                            ?>>WORD</option> --}}
                            <option value="EXCEL" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'EXCEL') {
                                                        echo 'selected';
                                                    } ?>>EXCEL</option>
                            <option value="VIDEO" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'VIDEO') {
                                                        echo 'selected';
                                                    } ?>>VIDEO</option>
                            <option value="YOUTUBE" <?php if (isset($UserDetails) && isset($UserDetails->document_type) && $UserDetails->document_type == 'YOUTUBE') {
                                                        echo 'selected';
                                                    } ?>>YOUTUBE</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Publish Date" class="control-label">Publish Date</label>
                        <input id="publish_date" name="publish_date"
                            class="form-control form-control-sm" value="<?php if (isset($UserDetails) && isset($UserDetails->publish_date)) {
                                                                            echo $UserDetails->publish_date;
                                                                        } ?>" required>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Video Link" class="control-label">Video Link</label>
                        <input type="text" id="video_link" name="video_link" class="form-control form-control-sm"
                            placeholder="Enter Video Link" style="border: 1px solid #aaa;"
                            value="<?php if (isset($UserDetails) && isset($UserDetails->video_link)) {
                                        echo $UserDetails->video_link;
                                    } ?>" disabled>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Select File" class="control-label">Select File</label>
                        @if (isset($UserDetails) && isset($UserDetails->file) && $UserDetails->file != 'NA')
                        <?php $file = explode('/', $UserDetails->file); ?>
                        <a href="{{ route('administrator.download', $file[1]) }}" class="download"
                            data='{{ $UserDetails->file }}' style="float:right;" title="Download File"><i
                                class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>
                        @endif
                        @if (isset($UserDetails) && isset($UserDetails->file) && $UserDetails->file != 'NA')
                        <input type="file" accept="" id="material_file" name="material_file"
                            class="form-control form-select-sm" onchange=hangleFileUpload()>
                        @else
                        <input type="file" accept="" id="material_file" name="material_file"
                            class="form-control form-select-sm" required onchange=hangleFileUpload()>
                        @endif
                        <p style="font-size: 14px; color: red;" id="file_error"></p>

                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Document Upload Type" class="control-label">Study Material Package
                            Category</label>
                        <select class="form-select form-select-sm select2" id="study_material_type"
                            onchange="getPackage(this)" name="study_material_type" required>
                            <option value="" default selected> Select Study Material Type</option>
                            <option value="Free" <?php if (isset($UserDetails) && isset($UserDetails->study_material_type) && $UserDetails->study_material_type == 'Free') {
                                                        echo 'selected';
                                                    } ?>>Free</option>
                            <option value="Paid" <?php if (isset($UserDetails) && isset($UserDetails->study_material_type) && $UserDetails->study_material_type == 'Paid') {
                                                        echo 'selected';
                                                    } ?>>Premium</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Document Upload Type" class="control-label">Select Package (If any)</label>
                        <input type="hidden" name="package_id" id="package_id" value="{{isset($UserDetails->select_package) ? $UserDetails->select_package : ''}}">
                        <select class="form-select form-select-sm select2" id="select_package" name="select_package">
                            <option value="" default selected> Select Package</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-3" id="test_fees">
                    <div class="form-group">
                        <label>Study Material Fees</label>
                        <input type="text" class="form-control form-control-sm" id="price" name="price"
                            value="{{ isset($UserDetails) ? $UserDetails->price : '0' }}" placeholder="0" disabled>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="enrol_student_no" class="control-label">Total Enroll Student</label>
                        <input type="number" id="enrol_student_no" min="1" name="total_student"
                            class="form-control form-control-sm" style="border: 1px solid #aaa;"
                            value="<?php if (isset($UserDetails) && isset($UserDetails->total_student)) {
                                        echo $UserDetails->total_student;
                                    } ?>" required>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Title" class="control-label">Remarks 1</label>
                        <input type="text" name="remarks" class="form-control form-control-sm"
                            placeholder="Enter Remarks" style="border: 1px solid #aaa;" value="<?php if (isset($UserDetails) && isset($UserDetails->remarks)) {
                                                                                                    echo $UserDetails->remarks;
                                                                                                } ?>"
                            required="">
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="Title" class="control-label">Remarks 2</label>
                        <input type="text" name="other_remark" class="form-control form-control-sm"
                            placeholder="Enter Remarks" style="border: 1px solid #aaa;" value="<?php if (isset($UserDetails) && isset($UserDetails->other_remark)) {
                                                                                                    echo $UserDetails->other_remark;
                                                                                                } ?>"
                            required="">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="student_rating" class="control-label">Classroom Student’s Rating</label>
                        <input type="number" step="0.1" min="0" max="5" name="student_rating"
                            class="form-control form-control-sm" placeholder="Enter Rating"
                            style="border: 1px solid #aaa;" value="<?php if (isset($UserDetails) && isset($UserDetails->student_rating)) {
                                                                        echo $UserDetails->student_rating;
                                                                    } ?>" required="">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="form-group" style="float:right;">
                            @if (isset($UserDetails))
                            @if (isset($UserDetails->material_seen) && $UserDetails->material_seen == 1)
                            <button type="button" class="btn btn-info" id="pause_material"
                                title="Pause Study Material!">Pause Material</button>
                            @else
                            <button type="button" class="btn btn-info" id="pause_material"
                                title="Active Study Material!">Active Material</button>
                            @endif
                            @endif
                            <input type="hidden" id="pause_val" name="pause_val" value="<?php if (isset($UserDetails) && isset($UserDetails->material_seen)) {
                                                                                            echo $UserDetails->material_seen;
                                                                                        } ?>">
                            @if (isset($UserDetails))
                            <button type="button" class="btn btn-warning publish" id="sendback_material"
                                name="sendback_material" title="Send Back Contributor!">Send Back
                                Contributor</button>
                            <button type="submit" class="btn btn-primary publish"
                                title="Publish Study Material!">Publish Material</button>
                            @else
                            <button type="submit" class="btn btn-primary publish"
                                title="Publish Study Material!">Publish Material</button>
                            @endif
                            <input type="hidden" id="material_id" name="material_id" value="<?php if (isset($UserDetails) && isset($UserDetails->id)) {
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
    var storematerial = "{{ route('administrator.store') }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
<script>
    function hangleFileUpload(value) {
        const PDF = ['pdf'];
        const EXCEL = ['xls', 'xlsx'];
        const VIDEO = ['mp4', 'mov'];

        const doc_type = $('#document_type').val()
        var output = document.getElementById('material_file');
        const ext = output.files[0].name.split('.');
        const ext_name = ext[ext.length - 1];
        if (doc_type == 'PDF') {
            !PDF.includes(ext_name) ? ($('#file_error').html('allow file type are .pdf only'), output.value = '') : $(
                '#file_error').html('')
        } else if (doc_type == 'EXCEL') {
            !EXCEL.includes(ext_name) ? ($('#file_error').html('allow file type are .xls and .xlsx only'), output
                .value = '') : $('#file_error').html('')
        }
        if (doc_type == 'VIDEO') {
            !VIDEO.includes(ext_name) ? ($('#file_error').html('allow file type are .mp4 and .mov only'), output.value =
                '') : $('#file_error').html('')
        }
    }

    async function getPackage() {
        var education_type_id = $("#education_type_id").val();
        var class_id = $("#class_group_exam_id").val();
        var test_type = $("#study_material_type").val();
        console.log('testtype' + test_type);
        if (test_type != '') {
            if (test_type == 'Free') {
                test_type = 'Free';
                $('#price').attr('disabled', true);
                $("#price").removeAttr('required');
                $("#price").val('0');

            } else {
                test_type = 'Paid';
                $('#price').removeAttr('disabled');
                $("#price").attr('required', true);
            }
        }

        var formData = new FormData();
        formData.append('form_name', 'get_package');
        formData.append('education_type_id', education_type_id);
        formData.append('classes_group_exams_id', class_id);
        formData.append('test_type', test_type);

        console.log(":" + class_id);
        if (test_type != '' && class_id != '') {

            await $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function(data) {
                if (data && data.success) {
                    const package_data = data.message;
                    console.log('packahe');
                    const package = $('#package_id').val();
                    console.log(package);
                    // console.log('pack'+package);
                    // var options = '<option value="">Add Video</option>';
                    var packageOptions = '';

                    if (package_data.length > 0) {

                        $(package_data).each(function(index, item) {
                            console.log(item);
                            var selected = "";
                            if (package != 0) {
                                package_arry = package.toString().split(',');
                                console.log("package_arry:", package_arry);
                                if (jQuery.inArray(item.id.toString(), package_arry) !== -1) {
                                    console.log('item.id:', item.id);
                                    selected = 'selected';
                                }
                            }
                            packageOptions += '<option value="' + item.id + '" ' + selected + '>' +
                                item.plan_name + '</option>';
                        });
                    }
                    if (package == 0) {
                        packageOptions += '<option value="0" selected >No Pacakge</option>';
                    } else {
                        packageOptions += '<option value="0">No Pacakge</option>';
                    }
                    //  else {
                    //     alert('No Data, please select another, or add some.');
                    // }
                    $('#select_package').html(packageOptions);
                } else {
                    alert(data.message);
                }
            }).fail(function(data) {
                console.log(data);
            })
        }
    }

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
            // $('.publish').attr('disabled', 'disabled');
            var values = {};
            // $.each($("form#studymaterial_form").serializeArray(), function (i, field) {
            // 	values[field.name] = field.value;
            // });

            // console.log("Data:",values);
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'studymaterial_form');
            console.log(Array.from(formData));

            $.ajax({
                data: formData,
                url: storematerial,
                type: "POST",
                // dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {
                    alert(data['message']);
                    $('#studymaterial_form')[0].reset();
                    $(".publish").removeAttr('disabled');
                    location.href = "<?= route('administrator.material') ?>"
                },
                error: function(xhr, status, error) {
                    // alert(status);
                    alert(xhr.responseText);
                    // alert(error);
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
                url: "{!! route('administrator.material_pause') !!}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    alert(data['message']);
                    location.href = "{!! route('administrator.material') !!}"
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
                    url: "{!! route('administrator.material_sendback') !!}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        alert(data['message']);
                        location.href = "{!! route('administrator.material') !!}"
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
                <?php if (isset($UserDetails)) : ?>
                    $("#material_file").removeAttr("required");
                <?php else : ?>
                    $("#material_file").attr("required", "true");
                <?php endif; ?>
            }
        });

        <?php if (isset($UserDetails)) : ?>
            $('#education_type_id').trigger('change');
            $('#document_type').trigger('change');
        <?php endif; ?>
    });
</script>

<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<script>
    $(function() {
        $("#publish_date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#study_material_type').on('change', function() {
            if (this.value == 'Free') {
                $("#freePackages").show();
                $("#paidPackages").hide();
            } else if (this.value == 'Paid') {
                $("#freePackages").hide();
                $("#paidPackages").show();
            } else {
                $("#freePackages").hide();
                $("#paidPackages").hide();
            }
        });
    });


    $(document).ready(function() {
        $('#document_type').on('change', function() {
            if (this.value == 'YOUTUBE') {
                $("#imageDiv").hide();
            } else {
                $("#imageDiv").show();
            }
        });
    });
</script>
@endsection
