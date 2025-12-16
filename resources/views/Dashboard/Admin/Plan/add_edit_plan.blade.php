@php
    if (isset($data['package']) && isset($data['package'][0]['class'])) {
        $class = $data['package'][0]['class'];
    } else {
        $class = 0;
    }
@endphp
@php
    if (isset($data['package']) && isset($data['package'][0]['video_id'])) {
        $video = $data['package'][0]['video_id'];
    } else {
        $video = 0;
    }
@endphp
@php
    if (isset($data['package']) && isset($data['package'][0]['study_material_id'])) {
        $notes = $data['package'][0]['study_material_id'];
    } else {
        $notes = 0;
    }
@endphp
@php
    if (isset($data['package']) && isset($data['package'][0]['static_gk_id'])) {
        $gk = $data['package'][0]['static_gk_id'];
    } else {
        $gk = 0;
    }
@endphp
@php
    if (isset($data['test_data'])) {
        $test = json_encode($data['test_data']);
    } else {
        $test = 0;
    }
@endphp
@extends('Layouts.admin', ['class' => $class, 'video' => $video, 'notes' => $notes, 'test' => $test])

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
        <form class="card dashboard-container mb-5" id="testForm" method="post" enctype="multipart/form-data">
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
            <input class="d-none" id="id" name="id" type="number" value="">
            <input class="d-none" id="testFormName" name="form_name" value="package_plan">

            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">
                    <div class="{{ isset($data['package'])  ? 'col-md-2 mt-3' : 'col-md-3 mt-3' }}">
                        <div class="form-group">
                            <label class="control-label" for="Package Image">Package Image</label>
                            <input class="form-control form-control-sm" id="package_image" name="package_image"
                                type="file">
                        </div>
                    </div>
                    @if (isset($data['package']))
                        <div class="col-md-1 mt-3">
                            <div class="form-group">
                                <img id="package_img"
                                    src="{{ isset($data['package']) && $data['package'][0]['package_image'] ? '/storage/' . $data['package'][0]['package_image'] : asset('noimg.png') }}"
                                    style="width:80px;height:80px;border:1px solid #c2c2c2;  ">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Creation Date">Creation Date</label>
                            <input class="form-control form-control-sm" id="creation_date" name="creation_date"
                                type="date" value="<?php if (isset($data['package'][0]['created_at'])) {
                                    echo date('Y-m-d', strtotime($data['package'][0]['created_at']));
                                } else {
                                    echo date('Y-m-d');
                                } ?>" disabled required>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Active Date">Package/ Offer Start</label>
                            <input class="form-control form-control-sm" id="active_date" name="active_date" type="date"
                                value="<?php if (isset($data['package'][0]['active_date'])) {
                                    echo $data['package'][0]['active_date'];
                                } ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Expire Date">Package/ Offer Expiration</label>
                            <input class="form-control form-control-sm" id="expire_date" name="expire_date" type="text"
                                value="<?php if (isset($data['package'][0]['expire_date'])) {
                                    echo $data['package'][0]['expire_date'];
                                } ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Package Name</label>
                            <input class="form-control form-control-sm" name="plan_name" type="text"
                                value="<?php if (isset($data['package'][0]['plan_name'])) {
                                    echo $data['package'][0]['plan_name'];
                                } ?>" style="border: 1px solid #aaa;">
                            <input id="plan_id" name="plan_id" type="hidden" value="<?php if (isset($data['package'][0]['id'])) {
                                echo $data['package'][0]['id'];
                            } else {
                                echo '';
                            } ?>">
                            <input id="plan_test_id" name="plan_test_id" type="hidden" value="<?php if (isset($data['test_data'][0]['id'])) {
                                echo $data['test_data'][0]['id'];
                            } else {
                                echo '';
                            } ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <label class="control-label" for="Package Created For">Package Created For</label>
                        <div class="form-group">
                            <input class="" id="package_type" name="package_type" type="radio" value="0"
                                <?php if (isset($data['package'][0]['package_type']) && $data['package'][0]['package_type'] == 0) {
                                    echo 'checked="checked"';
                                } else {
                                    echo 'checked="checked"';
                                } ?>>
                            <label class="control-label" for="" style="margin-right: 15px;">Gyanology</label>

                            <input class="" id="package_type" name="package_type" type="radio" value="1"
                                <?php if (isset($data['package'][0]['package_type']) && $data['package'][0]['package_type'] == 1) {
                                    echo 'checked="checked"';
                                } ?>>
                            <label class="control-label" for="">Institute</label>

                        </div>
                    </div>

                    <div class="col-md-3 mt-3" id="institute_show" style="display:none">
                        <div class="form-group">
                            <label class="control-label" for="">Institute</label>
                            <select class="form-select form-select-sm" id="institute_id" name="institute_id" required>
                                <option value="0">Select Institute</option>
                                @foreach ($data['institute'] as $institute)
                                    <option value="{{ $institute->id }}" <?php if (isset($data['package'][0]['institute_id']) && $data['package'][0]['institute_id'] == $institute->id) {
                                        echo 'selected';
                                    } ?>>
                                        {{ $institute->institute_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="Education Type">Education Type</label>
                            <select class="form-select form-select-sm" id="education_type_id" name="education_type_id"
                                onchange="getClassesByEducation(this.value)" required>
                                <option value="" default selected> Select Education Type</option>
                                @if (isset($data['gn_EduTypes']))
                                    @foreach ($data['gn_EduTypes'] as $u)
                                        <option value="{{ $u->id }}" <?php if (isset($data['package'][0]['education_type']) && $data['package'][0]['education_type'] == $u->id) {
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
                            <select class="form-select form-select-sm" id="class_group_exam_id"
                                name="class_group_exam_id" onchange="getStudyMaterial(this.value);getTest(this.value)"
                                required>
                                <option value="" default selected>Select Class/Group/Exam Name</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">No. of Test Allow</label>
                            <input class="form-control form-control-sm" id="total_test" name="total_test" type="number"
                                value="<?php if (isset($data['package'][0]['total_test'])) {
                                    echo $data['package'][0]['total_test'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;" min="1"
                                max="50" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">No. of Video/Youtube Class Allow</label>
                            <input class="form-control form-control-sm" id="total_video" name="total_video"
                                type="number" value="<?php if (isset($data['package'][0]['total_video'])) {
                                    echo $data['package'][0]['total_video'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;"
                                min="1" max="50" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">No. of Study Notes Allow</label>
                            <input class="form-control form-control-sm" id="total_notes" name="total_notes"
                                type="number" value="<?php if (isset($data['package'][0]['total_notes'])) {
                                    echo $data['package'][0]['total_notes'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;"
                                min="1" max="50" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3" id="static_gk">
                        <div class="form-group">
                            <label class="control-label" for="">No of Static GK & Current Affairs Allow</label>
                            <input class="form-control form-control-sm" id="current_affairs_allow"
                                name="current_affairs_allow" type="number" value="<?php if (isset($data['package'][0]['current_affairs_allow'])) {
                                    echo $data['package'][0]['current_affairs_allow'];
                                } else {
                                    echo 0;
                                } ?>"
                                style="border: 1px solid #aaa;" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3" id="comprehensive_study">
                        <div class="form-group">
                            <label class="control-label" for="">Comprehensive Study Material</label>
                            <input class="form-control form-control-sm" id="comprehensive_study_material"
                                name="comprehensive_study_material" type="number" value="<?php if (isset($data['package'][0]['comprehensive_study_material'])) {
                                    echo $data['package'][0]['comprehensive_study_material'];
                                } else {
                                    echo 0;
                                } ?>"
                                style="border: 1px solid #aaa;" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Add Test</label>
                            <select class="form-select form-select-sm select2" id="test_id" name="test_id[]" multiple>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Add Video/Youtube Class</label>
                            <select class="form-select form-select-sm select2" id="video_id" name="video_id[]" multiple>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Add Study Notes</label>
                            <select class="form-select form-select-sm select2" id="study_material_id"
                                name="study_material_id[]" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3" id="add_current_affairs">
                        <div class="form-group">
                            <label class="control-label" for="">Add Static GK & Current Affairs</label>
                            <select class="form-select form-select-sm select2" id="current_affairs_id"
                                name="current_affairs_id[]" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3" id="add_comprehensive_study_material">
                        <div class="form-group">
                            <label class="control-label" for="">Add Comprehensive Study Material</label>
                            <select class="form-select form-select-sm select2" id="add_comprehensive_study_material"
                                name="add_comprehensive_study_material[]" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Duration</label>
                            <select class="form-select form-select-sm select2" id="duration" name="duration" required>
                                @for ($i = 1; $i <= 365; $i++)
                                    <option value="{{ $i }}" <?php if (isset($data['package'][0]['duration']) && $data['package'][0]['duration'] == $i) {
                                        echo 'selected';
                                    } ?>>{{ $i }} days
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Free Extended Duration</label>
                            <select class="form-select form-select-sm select2" id="free_duration" name="free_duration"
                                required>
                                @for ($i = 0; $i <= 365; $i++)
                                    <option value="{{ $i }}" <?php if (isset($data['package'][0]['free_duration']) && $data['package'][0]['free_duration'] == $i) {
                                        echo 'selected';
                                    } ?>>{{ $i }} days
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Package Category</label>
                            <select class="form-select form-select-sm select2" id="package_category"
                                name="package_category">
                                <option value="">Select Package Category</option>
                                <option value="Free" <?php if (isset($data['package'][0]['package_category']) && $data['package'][0]['package_category'] == 'Free') {
                                    echo 'selected';
                                } ?>>Free</option>
                                <option value="Paid" <?php if (isset($data['package'][0]['package_category']) && $data['package'][0]['package_category'] == 'Paid') {
                                    echo 'selected';
                                } ?>>Paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Actual Fees</label>
                            <input class="form-control form-control-sm" id="actual_fees" name="actual_fees"
                                type="text" value="<?php if (isset($data['package'][0]['actual_fees'])) {
                                    echo $data['package'][0]['actual_fees'];
                                } ?>" style="border: 1px solid #aaa;">
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Discount</label>
                            <select class="form-select form-select-sm select2" id="discount" name="discount" required>
                                @for ($i = 0; $i <= 100; $i++)
                                    <option value="{{ $i }}" <?php if (isset($data['package'][0]['discount']) && $data['package'][0]['discount'] == $i) {
                                        echo 'selected';
                                    } ?>>{{ $i }}%
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Offer Fees</label>
                            <input class="form-control form-control-sm" id="final_fees" name="final_fees" type="text"
                                value="<?php if (isset($data['package'][0]['final_fees'])) {
                                    echo $data['package'][0]['final_fees'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;" readonly>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Status</label>
                            <select class="form-select form-select-sm select2" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="1" <?php if (isset($data['package'][0]['status']) && $data['package'][0]['status'] == 1) {
                                    echo 'selected';
                                } ?>>Active</option>
                                <option value="0" <?php if (isset($data['package'][0]['status']) && $data['package'][0]['status'] == 0) {
                                    echo 'selected';
                                } ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Special Remark 1</label>
                            <input class="form-control form-control-sm" id="special_remark_1" name="special_remark_1"
                                type="text" value="<?php if (isset($data['package'][0]['special_remark_1'])) {
                                    echo $data['package'][0]['special_remark_1'];
                                } else {
                                    echo '';
                                } ?>" style="border: 1px solid #aaa;" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Special Remark 2</label>
                            <input class="form-control form-control-sm" id="special_remark_2" name="special_remark_2"
                                type="text" value="<?php if (isset($data['package'][0]['special_remark_2'])) {
                                    echo $data['package'][0]['special_remark_2'];
                                } else {
                                    echo '';
                                } ?>" style="border: 1px solid #aaa;" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="">Classroom Student’s Rating</label>
                            <input class="form-control form-control-sm" id="student_rating" name="student_rating"
                                type="number" value="<?php if (isset($data['package'][0]['student_rating'])) {
                                    echo $data['package'][0]['student_rating'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;"
                                onchange="setTwoNumberDecimal" min="1" max="5" step="0.1" required />
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label class="control-label" for="enrol_student_no">Total Enroll Student</label>
                            <input class="form-control form-control-sm" id="enrol_student_no" name="enrol_student_no"
                                type="number" value="<?php if (isset($data['package'][0]['total_test'])) {
                                    echo $data['package'][0]['enrol_student_no'];
                                } else {
                                    echo 0;
                                } ?>" style="border: 1px solid #aaa;"
                                min="1" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-9">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Add Plan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var final_fees = 0;
            $("#discount").change(function() {
                var discount = $(this).val();
                var actual_fees = $("#actual_fees").val();
                console.log("actual_fees:", actual_fees);
                if (actual_fees != null && actual_fees != '') {
                    final_fees = parseInt(actual_fees) - ((actual_fees / 100) * discount);
                    $("#final_fees").val(final_fees.toFixed(2));
                    console.log("final_fees:", final_fees);
                } else {
                    $("#final_fees").val(0);
                }
            }).trigger("change");

            $("#actual_fees").keyup(function() {
                var discount = $("#discount").val();
                var actual_fees = $(this).val();

                if (actual_fees != null) {
                    final_fees = parseInt(actual_fees) - ((actual_fees / 100) * discount);

                    $("#final_fees").val(final_fees.toFixed(2));
                }
            });

            $("input[type=radio][name=package_type]").change(function() {
                if ($("input[name='package_type']:checked").val() == 0) {
                    $("#institute_show").hide();
                    $("#institute_id").val(0);
                    $("#education_type_id").val('');
                    $("#class_group_exam_id").val('');
                }
                if ($("input[name='package_type']:checked").val() == 1) {
                    $("#institute_show").show();
                    @if (!isset($data['package']))
                        $("#institute_id").val(0);
                        $("#education_type_id").val('');
                        $("#class_group_exam_id").val('');
                    @endif
                }
            });

            $("#package_category").change(function() {
                var package_category = $('#package_category').val();
                if (package_category == 'Free') {
                    $('#actual_fees').val(0);
                    $('#final_fees').val(0);
                    $("#discount").select2("val", "0");
                } else {
                    $('#actual_fees').val('');
                    $('#final_fees').val(0);
                    $("#discount").select2("val", "0");
                }
            });

            $("#actual_fees").keyup(function() {
                var package_category = $('#package_category').val();
                if (package_category == 'Free') {
                    $('#actual_fees').val(0);
                    $('#final_fees').val(0);
                    $("#discount").select2("val", "0");
                }
            });

            $("#education_type_id").change(function() {
                var education_type = $('#education_type_id :selected').text();
                if (education_type == 'Competition') {
                    console.log('Competition');
                    $("#total_gk").removeAttr("disabled", "");
                    $("#static_gk").show();
                    $("#comprehensive_study").hide();
                    $("#add_current_affairs").show();
                    $("#add_comprehensive_study_material").hide();
                    $("#total_gk").val(0);
                    $("#current_affairs_id").removeAttr("disabled", "");
                    $("#current_affairs_id").select2("val", "0");
                }

                if (education_type == 'Govt Jobs') {
                    $("#static_gk").show();
                    $("#comprehensive_study").hide();
                    $("#add_current_affairs").show();
                    $("#add_comprehensive_study_material").hide();
                }

                if (education_type == 'Academics') {
                    console.log('Academics');
                    $("#total_gk").attr("disabled", "disabled");
                    $("#static_gk").hide();
                    $("#comprehensive_study").show();
                    $("#add_current_affairs").hide();
                    $("#add_comprehensive_study_material").show();
                    $("#total_gk").val(0);
                    $("#current_affairs_id").attr("disabled", "disabled");
                    $("#current_affairs_id").select2("val", "0");
                }

                if (education_type == 'Other Entrance Exams') {
                    $("#static_gk").hide();
                    $("#comprehensive_study").show();
                    $("#add_current_affairs").hide();
                    $("#add_comprehensive_study_material").show();
                }
            });

            @if (isset($data['package']))
                $('#education_type_id').trigger('change');
            @endif

            @if (isset($data['package'][0]['institute_id']) && $data['package'][0]['institute_id'] != 0)
                $('#package_type').trigger('change');
            @endif
        });
    </script>





    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#expire_date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
            });
        });
    </script>
    <script>
        var max = 50;
        $('#total_test').keyup(function() {

            var inputValue = $(this).val();
            if (inputValue > max) {
                alert('Total test can not be greater than 50!');
                $(this).val('')
            }
        });
        $('#total_video').keyup(function() {
            var inputValue = $(this).val();
            if (inputValue > max) {
                alert('Total videos can not be greater than 50!');

                $(this).val('')
            }
        });
        $('#total_notes').keyup(function() {
            var inputValue = $(this).val();
            if (inputValue > max) {
                alert('Total notes can not be greater than 50!');

                $(this).val('')
            }
        });

        function setTwoNumberDecimal(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    </script>
@endsection
