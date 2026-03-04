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

    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="row corporate-cards">
            <div class="col-md-6 col-12">
                <form class="card" id="uploadPdf" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header" style="background-color:#19467a; color: #fff;">
                        <h5>Terms Condition Pdf</h5>
                    </div>
                    <div class="card-body">
                        @error('userError')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Title
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Type
                            </label>
                            <div class="box-input">
                                <div class="input-group">
                                    <select class="form-select" id="inputGroupSelect02" name="type" required>
                                        <option selected disabled>Select Type</option>
                                        <option value="student">Student Form</option>
                                        <option value="institute_enquiry">Institute Enquiry</option>
                                        <option value="corporate_signup">Corporate Sign Up</option>
                                        <option value="website_terms">Website Terms & Condition</option>
                                        <option value="website_privacy_policy">Website Privacy Policy</option>
                                        <option value="links">Important Links</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                                Add Pdf
                            </label>
                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <input type="file" accept="pdf" name="pdf_file"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <label class="box-heading text-end">
                            </label>

                            <div class="box-input">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-md-6 col-12">
                <table class="table" id="pdfTable">
                <thead>
                    <tr>
                    <th scope="col">Sr.No</th>
                    <th scope="col">title</th>
                    <th scope="col">type</th>
                    <th scope="col">pdf</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="allPdf">
                    @if(isset($pdfList))
                    @foreach($pdfList as $key=>$list)
                    @php
                    $filePath = $list->url;
                    @endphp
                    <tr data-id="{{$key+1}}" class="row_{{$list->id}}">
                    <th scope="row" >{{$key+1}}</th>
                    <td>{{$list->title}}</td>
                    <td>{{$list->type}}</td>
                    <td><a href="{{ asset('storage/' . ltrim($filePath, '/')) }}" target="_blank"><i class="bi bi-file-pdf"></i> </a></td>
                    <td>
                        <button class="btn btn-outline-danger delete-file" data-id="{{$list->id}}"><i class="bi bi-trash"></i></span></button>
                    </td>

                    </tr>
                    @endforeach
                   @endif
                </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="toast align-items-center text-white border-0 position-absolute bottom-0 end-0 mb-3" data-delay="5000"
        role="alert" aria-live="assertive" aria-atomic="true" id="responseToast">
        <div class="d-flex">
            <div class="toast-body" id="responseToastMessage">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

    </script>
    <script>
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
    </script>

@endsection
