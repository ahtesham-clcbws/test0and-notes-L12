@extends('Layouts.admin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .corporate-cards .content-wrapper .card {
            border: solid 1px black;
            margin: 10px 20px;
        }

        .corporate-cards td.userImageCell {
            width: 96px !important;
        }

        .corporate-cards .card .card-header {
            height: 40px;
            display: flex;
            justify-content: space-between;
            background-color: #19467a;
            border: 0px !important;
            height: 42px;
        }

        .corporate-cards textarea {
            margin: 10px 20px;
        }

        .corporate-cards .dropdown-label {
            font-size: 12px;
        }

        .corporate-cards input,
        .corporate-cards select {
            margin-left: auto;
            height: 30px;
            padding: 6px 12px;
            font-size: 12px;
            color: black;
        }

        .corporate-cards select {
            color: black;
            font-size: 12px;
        }

        .corporate-cards .input-group-text {
            height: 30px;
            width: 40px;
            border-radius: 0px;
        }

        .corporate-cards .status {
            background-color: #18c968;
            width: 100%;
        }

        .corporate-cards .btn-status {
            color: white !important;
            font-size: 15px !important;
            font-weight: 500 !important;
        }

        .corporate-cards .information-txt {
            font-size: 14px;
            font-weight: 500;
            padding-left: 22px !important;
        }

        .corporate-cards .btn-link {
            font-weight: 500 !important;
            font-size: 15px !important;
            text-decoration: underline;
        }

        .corporate-cards td b {
            font-size: 14px;
            text-align: right;
        }

        .corporate-cards .table {
            margin-bottom: 0px !important;
        }

        .corporate-cards td .btn {
            padding: 0 9px !important;
        }

        .corporate-cards .box {
            display: flex;
            margin-bottom: 10px;
        }

        .corporate-cards label.box-heading {
            width: 150px;
            display: flex;
            align-items: center;
            font-size: 12px;
            margin: auto;
            margin-left: auto;
            margin-right: 20px;
        }

        .corporate-cards .box-input {
            width: 100%;
            display: flex;
        }

        .corporate-cards .box-icon {
            width: 20px;
            height: 100%;
            background-color: gray;
        }

        .corporate-cards td .btn-link {
            font-size: 14px !important;
            text-decoration: none;
        }

        .corporate-cards .dropdown {
            position: relative;
            font-size: 14px;
            color: #333;
            width: 100%;
        }

        .corporate-cards .dropdown .dropdown-list {
            padding: 12px;
            background: #fff;
            position: absolute;
            top: 30px;
            z-index: 222;
            left: 2px;
            right: 2px;
            box-shadow: 0 1px 2px 1px rgba(0, 0, 0, 0.15);
            transform-origin: 50% 0;
            transform: scale(1, 0);
            transition: transform 0.15s ease-in-out 0.15s;
            overflow-y: scroll;
        }

        .corporate-cards .dropdown .dropdown-option {
            display: block;
            padding: 4px 12px;
            opacity: 0;
            transition: opacity 0.15s ease-in-out;
        }

        .corporate-cards .dropdown .dropdown-label {
            display: block;
            height: 30px;
            background: #fff;
            border: 1px solid #ccc;
            padding: 6px 12px;
            line-height: 1;
            cursor: pointer;
        }

        .corporate-cards .dropdown .dropdown-label:before {
            content: "";
            float: right;
        }

        .corporate-cards .dropdown.on .dropdown-list {
            transform: scale(1, 1);
            transition-delay: 0s;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .corporate-cards .dropdown-list a {
            margin-left: 17px;
        }

        .corporate-cards .dropdown.on .dropdown-list .dropdown-option {
            opacity: 1;
            display: flex;
            text-decoration: none;
            float: left;
            width: 100%;
            transition-delay: 0.2s;
            margin: 0px;
        }

        .corporate-cards .dropdown.on .dropdown-label:before {
            content: "";
        }

        .corporate-cards .dropdown [type="checkbox"] {
            position: relative;
            top: -4px;
            margin-right: 4px;
            margin-left: 0px !important;
        }

        .corporate-cards #get_otp {
            color: white;
            position: absolute;
            margin-top: -43px;
            margin-left: 147px;

            height: 33px;
            background-color: #2e3092;
        }

        .corporate-cards #verifyotp .a {
            align-items: center;
            color: blue;
            color: white;
            font-size: 16px;
            position: absolute;
            margin-top: -13px;
            margin-left: -75px;
            border-radius: 5px;
            padding: 2px 19px;
            /* height: 33px; */
            background-color: #2e3092;
        }

        .corporate-cards .contactsubmitbtn4 {
            color: white;
            position: absolute;
            margin-top: -43px;
            margin-left: 380px;
            width: 105px;
            font-size: 17px;
            height: 33px;
            background-color: #2e3092;
        }

        .corporate-cards .btn-primary {
            color: #fff;
            background-color: #2e3092;
            width: 110px;
            border-color: #2e3092;
        }

        .corporate-cards #profile_img {
            margin-right: -48px !important;
        }

        .corporate-cards select option {
            width: 250px !important;
            height: 10px !important;
        }

        .corporate-cards .bootstrap-select.btn-group .dropdown-menu.open {
            width: 250px !important;
            overflow: auto !important;
            background-color: red !important;
        }

        .corporate-cards .btn-new {
            background-color: #626f7c !important;
        }

        .corporate-cards .select-hidden {
            visibility: hidden;
            padding-right: 10px;
        }

        .corporate-cards .select {
            cursor: pointer;
            display: inline-block;
            position: relative;
            font-size: 12px;
            flex: 1;
            color: black;
        }

        .corporate-cards .select-styled {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            border: 1px solid #ced4da;
            padding: 2px 15px;
        }

        .corporate-cards .select-styled:after {
            content: "";
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-color: black transparent transparent transparent;
            position: absolute;
            top: 9px;
            right: 10px;
        }

        .corporate-cards .select-styled:hover {
            background-color: white;
        }

        .corporate-cards .select-styled:active,
        .corporate-cards .select-styled.active {
            background-color: white;
        }

        .corporate-cards .select-styled:active:after,
        .corporate-cards .select-styled.active:after {
            top: 5px;
            border-color: transparent transparent black transparent;
        }

        .corporate-cards .select-options {
            position: absolute;
            top: 100%;
            right: 0;
            left: 0;
            z-index: 999;
            margin: 0;
            padding: 2px 0px;
            list-style: none;
            background-color: white;
            box-shadow: 0 1px 2px 1px rgb(0 0 0 / 15%);
        }

        .corporate-cards .select-options li {
            margin: 0;
            padding: 6px 0;
            text-indent: 16px;
            /* border-top: 1px solid #19467a ; */
        }

        .corporate-cards .select-options li:hover {
            color: black;
            background: #fff;
        }

        .corporate-cards .select-options,
        .corporate-cards .select-hidden,
        .corporate-cards .select-options li[rel="hide"],
        .corporate-cards #reply-show,
        .corporate-cards #approved-show,
        .corporate-cards #pending-show,
        .corporate-cards #reject-show {
            display: none;
        }

        .corporate-cards .mid-content textarea {
            margin: 0px;
            width: 100%;
            height: 464px;
            border: 1px solid lightgray !important;
        }

        .corporate-cards .control-area {
            margin-left: auto;
            margin-top: 10px;
        }

        .action-button:not(:last-shild):after {
            content: " | "
        }
        .form-title {
            font-weight: bold;
            color: #19467a;
            margin-top: 10px;
            font-size: 16px;
        }
        .existing-file {
            font-size: 11px;
            color: #666;
            display: block;
            margin-top: 5px;
        }
        .img-preview-small {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

    </style>
@endsection
@section('main')
<h2>Edit Course/Exam</h2>
<div class="row py-5 pl-3 pr-3">
    <div class="container card p-0">

        <div class="card-body">

            <form action="{{route('administrator.course-detail-update', $course->id)}}" method="POST" enctype="multipart/form-data" id="course_detail_form">
                @csrf
                <div class="row">
                    <input type="hidden" name="id" value="{{$course->id ?? ''}}" autocomplete="off">


                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title"> Featured Image (JPG, PNG Only)</p>
                            <input type="file" class="form-control input-focus" onchange="validateImage(this)" name="featured_image" accept="image/*">
                            @if($course->course_image) {{-- Assuming featured image mapping --}}
                                <img src="{{asset('storage/' . ltrim($course->course_image, '/'))}}" class="img-preview-small">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Course Logo (JPG, PNG Only)</p>
                            <input type="file" class="form-control input-focus" onchange="validateImage(this)" name="course_logo" accept="image/*">
                            @if($course->course_image)
                                <img src="{{asset('storage/' . ltrim($course->course_image, '/'))}}" class="img-preview-small">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Education Type<span class="text-danger">*</span></p>
                            <select name="education_type" class="form-control input-focus" required onchange="educationTypeChange(this.value)">
                                <option selected disabled >Select Education Type</option>
                                @foreach($education_type as $edu)
                                <option value="{{$edu->id}}" {{ $course->education_id == $edu->id ? 'selected' : '' }}>{{$edu->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title"> Class/Group/Exam Name <span class="text-danger">*</span></p>
                            <select name="course_name" class="form-control input-focus" required id="board_class_group_exam">
                                <option selected disabled >Select Class Group</option>
                                @foreach($course_data as $cat)
                                <option value="{{$cat->id}}" {{ $course->class_group_examp_id == $cat->id ? 'selected' : '' }}>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Agency/ Board/University</p>
                            <select name="board" class="form-control input-focus" required>
                                <option selected disabled >Select Board</option>
                                @foreach($board as $val)
                                <option value="{{$val->id}}" {{ $course->board_id == $val->id ? 'selected' : '' }}>{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Course Exam Name</p>
                            <input type="text" value="{{old('course_full_name', $course->course_full_name ?? '')}}" name="course_full_name" class="form-control input-focus" placeholder="Enter Course Name" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Notification Date</p>
                            {{-- Assuming notification mapping, using registration if notification field missing in model --}}
                            <input type="text" value="{{old('notification', $course->registration ?? '')}}" name="notification" class="form-control input-focus" placeholder="Enter Notification Date" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Registration Date</p>
                            <input type="text" value="{{old('registration', $course->registration ?? '')}}" name="registration" class="form-control input-focus" placeholder="Registration Date" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Date</p>
                            <input type="text" value="{{old('exam_Date', $course->exam_date ?? '')}}" name="exam_Date" class="form-control input-focus" placeholder="Exam Date" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Mode</p>
                            <input type="text" value="{{old('exam_mode', $course->exam_mode ?? '')}}" name="exam_mode" class="form-control input-focus" placeholder="Exam Mode" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Pattern</p>
                            {{-- Model doesn't have exam_pattern, reusing exam_mode or other field if needed, but keeping it as per add page UI --}}
                            <input type="text" value="{{old('exam_pattern', $course->exam_mode ?? '')}}" name="exam_pattern" class="form-control input-focus" placeholder="Exam Pattern">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Vacancy</p>
                            <input type="text" value="{{old('vacancies', $course->vacancies ?? '')}}" name="vacancies" class="form-control input-focus" placeholder="Vacancy" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Pay Scale</p>
                            <input type="text" value="{{old('pay_scale', $course->salary ?? '')}}" name="pay_scale" class="form-control input-focus" placeholder="Pay Scale" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Age Crieteria</p>
                            {{-- Reusing eligibility or other if needed --}}
                            <input type="text" value="{{old('age_criteria', $course->eligibility ?? '')}}" name="age_criteria" class="form-control input-focus" placeholder="Age Criteria">
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Eligibility</p>
                            <input type="text" value="{{old('eligibility', $course->eligibility ?? '')}}" name="eligibility" class="form-control input-focus" placeholder="Eligibility" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Official Site</p>
                            <input type="text" value="{{old('official_site', $course->official_site ?? '')}}" name="official_site" class="form-control input-focus" placeholder="Official Site" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Required Text A (Optional)</p>
                            <input type="text" class="form-control input-focus" value="{{old('required_first', $course->required_A ?? '')}}" name="required_first">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Required Text B (Optional)</p>
                            <input type="text" class="form-control input-focus" value="{{old('required_second', $course->required_B ?? '')}}" name="required_second">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Gazzete Notification (PDF Only)</p>
                            <input type="file" class="form-control input-focus" name="notification_file" accept="application/pdf">
                            @if($course->notification_image)
                                <a href="{{asset('storage/' . ltrim($course->notification_image, '/'))}}" target="_blank" class="existing-file">View Existing PDF</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Details (PDF Only)</p>
                            <input type="file" class="form-control input-focus" name="exam_details_file" accept="application/pdf">
                            @if($course->exam_detail)
                                <a href="{{asset('storage/' . ltrim($course->exam_detail, '/'))}}" target="_blank" class="existing-file">View Existing PDF</a>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <p class="form-title">Course Overview</p>
                                <textarea class="ckeditor" id="editor" name="overview" required>{{old('overview', $course->description ?? '')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-warning btn-flat m-b-10 m-l-5" value="Update">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.19.0/ckeditor.js"></script>
<script>
    async function educationTypeChange(id,class_exam) {
    var formData = new FormData();
    formData.append('form_name', 'get_class_group_exam');
    formData.append('education_type_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {

        if (data && data.success) {
            const class_group_exam = data.message;
            var options = '<option selected disabled >Select Class Group</option>';
            if (class_group_exam.length > 0) {
                $(class_group_exam).each(function (index, item) {
                    options += '<option value="' + item.id + '" '+(item.id == class_exam ? "selected" : "")+'>' + item.name + '</option>';
                });
                $('#board_class_group_exam').removeAttr('disabled');
            } else {
                $('#board_class_group_exam').val('');
                $('#board_class_group_exam').attr('disabled', 'disabled');
                alert('No Class/ Group/ Exam Name in this Education Type, please select another, or add some.');
            }
            $('#board_class_group_exam').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}
</script>

@endsection
