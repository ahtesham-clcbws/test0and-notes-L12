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

    </style>
@endsection
@section('main')
<h2>Course/Exam Master</h2>
<div class="row py-5 pl-3 pr-3">
    <div class="container card p-0">

        <div class="card-body">

            <form action="{{route('administrator.course-detail-store')}}" method="POST" enctype="multipart/form-data" id="course_detail_form">
                @csrf
                <div class="row">
                    <input type="hidden" name="id" value="{{$course->id ?? ''}}" autocomplete="off">


                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title"> Featured Image (JPG, PNG Only)</p>
                            <input type="file" class="form-control input-focus" value="{{old('featured_image', $course->featured_image ?? '')}}" onchange="validateImage(this)" name="featured_image" required accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Course Logo (JPG, PNG Only)</p>
                            <input type="file" class="form-control input-focus" value="{{old('course_logo', $course->course_logo ?? '')}}" onchange="validateImage(this)" name="course_logo" required accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Education Type<span class="text-danger">*</span></p>
                            <select name="education_type" class="form-control input-focus" required onchange="educationTypeChange(this.value)">
                                <option selected disabled >Select Board</option>
                                @foreach($education_type as $edu)

                                <option value="{{$edu->id}}">{{$edu->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title"> Class/Group/Exam Name <span class="text-danger">*</span></p>
                            <select name="course_name" class="form-control input-focus" required id="board_class_group_exam">
                                <option selected disabled >Select Class Group</option>
                                @foreach($course_data as $course)

                                <option value="{{$course->id}}">{{$course->name}}</option>
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

                                <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Course Exam Name</p>
                            <input type="text" value="{{old('course_full_name', $course->course_full_name ?? '')}}" name="course_full_name" class="form-control input-focus" placeholder="Enter Course Name:Preliminary & Mains" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Notification Date</p>
                            <input type="text" value="{{old('notification', $course->notification ?? '')}}" name="notification" class="form-control input-focus" placeholder="Enter Notification: 21 may 2024 - 26 jul 2024 " required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Registration Date</p>
                            <input type="text" value="{{old('registration', $course->registration ?? '')}}" name="registration" class="form-control input-focus" placeholder="Registration: 21 may 2024 - 26 jul 2024" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Date</p>
                            <input type="text" value="{{old('exam_Date', $course->exam_Date ?? '')}}" name="exam_Date" class="form-control input-focus" placeholder="Exam Date: 21 Aug 2024 - 26 Aug 2024" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Mode</p>
                            <input type="text" value="{{old('exam_mode', $course->exam_mode ?? '')}}" name="exam_mode" class="form-control input-focus" placeholder="Written & Computer Based" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Pattern</p>
                            <input type="text" value="{{old('exam_pattern', $course->exam_pattern ?? '')}}" name="exam_pattern" class="form-control input-focus" placeholder="Pre Mains Interview" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Vacancy</p>
                            <input type="text" value="{{old('vacancies', $course->vacancies ?? '')}}" name="vacancies" class="form-control input-focus" placeholder="5500" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Pay Scale</p>
                            <input type="text" value="{{old('pay_scale', $course->pay_scale ?? '')}}" name="pay_scale" class="form-control input-focus" placeholder="I21,700 - I69,100" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Age Crieteria</p>
                            <input type="text" value="{{old('age_criteria', $course->age_criteria ?? '')}}" name="age_criteria" class="form-control input-focus" placeholder="35 Years For GEN/ EWS 40 Years for SC/ ST 36 Years For OBC" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Eligibility</p>
                            <input type="text" value="{{old('eligibility', $course->eligibility ?? '')}}" name="eligibility" class="form-control input-focus" placeholder="Graduate / Graduation Final Year Graduation Appearing" required>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Official Site</p>
                            <input type="text" value="{{old('official_site', $course->official_site ?? '')}}" name="official_site" class="form-control input-focus" placeholder="	https://ppntestsite.com/career" required>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Required Text A (Optional)</p>
                            <input type="text" onchange="validateImage(this,'imagepdf')" class="form-control input-focus" value="{{old('custome_field_detail', $course->custome_field_detail ?? '')}}" name="required_first"  accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Required Text B (Optional)</p>
                            <input type="text"  class="form-control input-focus" value="{{old('custome_field_detail2', $course->custome_field_detail ?? '')}}" name="required_second"  accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Gazzete Notification (PDF Only)</p>
                            <input type="file" onchange="" class="form-control input-focus" value="{{old('notification_file', $course->notification_file ?? '')}}" name="notification_file"  accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="form-group">
                            <p class="form-title">Exam Details (PDF Only)</p>
                            <input type="file" onchange="validateImage(this,'imagepdf')" class="form-control input-focus" value="{{old('exam_details_file', $course->exam_details_file ?? '')}}" name="exam_details_file" required accept="application/pdf">
                        </div>
                    </div>

                    <!--<div class="col-md-3 col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <p>E-Prospectus</p>-->
                    <!--        <input type="file" onchange="validateImage(this,'imagepdf')" class="form-control input-focus" value="{{old('prospectus', $course->prospectus ?? '')}}" name="prospectus" required>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <p class="form-title">Course Overview</p>
                                <textarea class="ckeditor" id="editor" value="{{old('overview', $course->overview ?? '')}}" name="overview" required></textarea>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-12">
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-warning btn-flat m-b-10 m-l-5" value="Submit">
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

    {{-- <script>
$(document).ready(function() {
    $('#uploadPdf').on('submit', function(event) {

        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{route('administrator.pdf_submit')}}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploadPdf')[0].reset();
                if(response.status==true)
                {
                    var id = response.data.id;
                    var title = response.data.title;
                    var type = response.data.type;
                    var url = response.data.url;
                    var no = $('#pdfTable tr:last').attr('data-id')??0;
                    var no = parseInt(no)+1;
                    var html = '';
                    html+=
                    `<tr data-id="${no}">
                        <th scope="row">${no}</th>
                        <td>${title}</td>
                        <td>${type}</td>
                        <td><a href="{{ asset('storage/' . ltrim($url, '/')) }}" target="_blank"><i class="bi bi-file-pdf"></i> </a></td>
                        <td><button class="btn btn-outline-danger delete-file" data-id="${id}"><i class="bi bi-trash"></i></span></button></td>
                    </tr>`;
                        $('#allPdf').append(html);
                         location.reload();

                }else{

                }
                console.log(response);
            },
            error: function(xhr, status, error) {
                // alert('File upload failed');
                console.log(error);
            }
        });
    });
});
$(document).ready(function() {
    $('.delete-file').on('click', function() {
        var button = $(this);
        var id = $(this).attr('data-id');

        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url:"{{route('administrator.pdf_delete')}}",
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    id:id,
                },
                success: function(response) {
                    if (response.status==true) {
                        $('.row_'+id).html('');
                        location.reload();
                        alert('Record deleted successfully!');

                    } else {
                        alert('Error deleting record.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred.');
                }
            });
        }
    });
});
    </script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.19.0/ckeditor.js"></script>
// <script>
//     ClassicEditor
//         .create(document.querySelector('#editor'))
//         .catch(error => {
//             console.error(error);
//         });
// </script>
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
