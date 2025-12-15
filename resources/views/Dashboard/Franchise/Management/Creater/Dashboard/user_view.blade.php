@extends('Layouts.Management.creater')

@section('main')
    <section class="content admin-1">
        <div class="row corporate-cards">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>Registered: </h5>
                        </div>

                        <div>
                            <h5>{{ date('d M Y', strtotime($data['user']['created_at'])) }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><b>Name</b></td>
                                            <td class="information-txt">{{ $data['user']['name'] }}</td>
                                            <td rowspan="2" class="userImageCell">
                                                <img id="profile_img"
                                                    src="{{ $data['details']['photo_url'] ? '/storage/'.$data['details']['photo_url'] : asset('noimg.png') }}"
                                                    style="width:80px;height:80px;border:1px solid #c2c2c2;  ">
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="2"><b>Username</b></td>
                                            <td class="information-txt">{{ $data['user']['username'] }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Email</b></td>
                                            <td class="information-txt" colspan="2">{{ $data['user']['email'] }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Action</b></td>
                                            <td colspan="2">
                                                @if ($data['user']['status'] == 'inactive')
                                                    <button type="button" class="btn btn-link text-danger action-button"
                                                        onclick="showReject()">Reject</button>
                                                    <button type="button" class="btn btn-link text-success action-button"
                                                        onclick="showApproved()">Approve</button>
                                                @endif
                                                @if ($data['user']['status'] == 'active')
                                                    <button type="button"
                                                        class="btn btn-link text-danger action-button">Discontinue</button>
                                                @endif
                                                <button type="button" class="btn btn-link text-info action-button"
                                                    onclick="showReply()">Reply</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Status</b></td>
                                            <td @if ($data['user']['status'] == 'inactive')
                                                class="bg-info"
                                            @elseif($data['user']['status'] == 'active')
                                                class="bg-success"
                                            @elseif($data['user']['status'] == 'rejected')
                                                class="bg-danger"
                                            @else
                                                class="bg-warning"
                                                @endif
                                                colspan="2">
                                                <span
                                                    class="text-white">{{ Str::ucfirst($data['user']['status']) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Subscription</b></td>
                                            <td colspan="2">
                                                {{ $data['remainingSubscription'] }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="card" id="reply-show">
                    <div class="card-header" style="background-color:#0DCAF0; color: #fff;">
                        <h5>Reply</h5>
                    </div>
                    <div class="card-body">
                        <div class="modalLoader" id="reply-loader">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="mid-content">
                            <textarea id="reply-message" name="type" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="control-area">
                            <button class="btn btn-danger" onclick="closeBox()">Close</button>
                            <button class="btn btn-success" onclick="submitReply('reply', this)">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="card" id="approved-show">
                    <div class="card-header" style="background-color:#18c968; color: #fff;">
                        <h5>Approve</h5>
                    </div>
                    <div class="card-body">
                        <div class="modalLoader" id="approved-loader">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="mid-content">
                            <textarea id="approved-message" name="type" id="" cols="30"
                                rows="10">Please use this ({{ $data['details']['branch_code'] }}) branch code, to signup so we can go further on your request.</textarea>
                        </div>
                        <div class="control-area">
                            <button class="btn btn-danger" onclick="closeBox()">Close</button>
                            <button class="btn btn-success" onclick="submitReply('approved', this)">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="card" id="reject-show">
                    <div class="card-header" style="background-color:#ff0000; color: #fff;">
                        <h5>Reason to reject</h5>
                    </div>
                    <div class="card-body">
                        <div class="modalLoader" id="reject-loader">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="mid-content">
                            <textarea id="reject-message" name="type" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="control-area">
                            <button class="btn btn-danger" onclick="closeBox()">Close</button>
                            <button class="btn btn-success" onclick="submitReply('reject', this)">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="card" id="pending-show">
                    <div class="card-header" style="background-color:#F48134; color: #fff;">
                        <h5>Reason for pending</h5>
                    </div>
                    <div class="card-body">
                        <div class="modalLoader" id="pending-loader">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="mid-content">
                            <textarea id="pending-message" name="type" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="control-area">
                            <button class="btn btn-danger" onclick="closeBox()">Close</button>
                            <button class="btn btn-success" onclick="submitReply('pending', this)">Submit</button>
                        </div>
                    </div>
                </div>

                <form class="card" id="reply-hidden">
                    <div class="card-header" style="background-color:#19467a; color: #fff;">
                        <h5>Set User Type</h5>
                    </div>
                    <div class="card-body">

                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Duration
                            </label>

                            <div class="box-input">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect01"><i
                                            class="bi bi-clock-fill"></i></label>
                                    <select class="form-select" id="inputGroupSelect01" name="days"
                                        data-style="btn-new">
                                        <option {{ $data['details']['days'] == 0 ? 'selected' : '' }} value="0">No subscription
                                        </option>

                                        <option {{ $data['details']['days'] == 3 ? 'selected' : '' }} value="3">3 days
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 7 ? 'selected' : '' }} @if(!isset($data['details']['days'])) selected @endif value="7">7 days
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 15 ? 'selected' : '' }} value="15">15
                                            days
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 30 ? 'selected' : '' }} value="30">30
                                            days
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 60 ? 'selected' : '' }} value="60">60
                                            days
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 90 ? 'selected' : '' }} value="90">3
                                            months
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 120 ? 'selected' : '' }} value="120">4
                                            months
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 150 ? 'selected' : '' }} value="150">5
                                            months
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 180 ? 'selected' : '' }} value="180">6
                                            months
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 270 ? 'selected' : '' }} value="270">9
                                            months
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 365 ? 'selected' : '' }} value="365">1
                                            year
                                        </option>
                                        
                                        <option {{ $data['details']['days'] == 730 ? 'selected' : '' }} value="730">2
                                            year
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Student / Management
                            </label>

                            <div class="box-input">
                                <div class="input-group">
                                    <label class="input-group-text" for="is_staff_selection"><i
                                            class="bi bi-intersect"></i></label>
                                    <select class="form-select" id="is_staff_selection" name="is_staff">
                                        <option {{ $data['user']['is_staff'] == 0 ? 'selected' : '' }} value="0">Student
                                        </option>
                                        <option {{ $data['user']['is_staff'] == 1 ? 'selected' : '' }} value="1">Management
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <div id="franchise_roles_div">
                            <div class="d-flex mb-2">

                                <label class="box-heading text-end">
                                    Select Role
                                </label>

                                <div class="box-input" id="franchiseRoleDiv">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-gear-fill"></i></span>
                                    <div class="dropdown" data-control="checkbox-dropdown">
                                        <label id="label2" class="dropdown-label">Select</label>

                                        <div class="dropdown-list">
                                            <label for="" class="dropdown-option">
                                                <input type="checkbox" value="Selection 0" data-toggle="check-all" />
                                                <a href="#" data-toggle="check-all" class="dropdown-option"
                                                    style="margin-left: -12px;color: #19467a;margin-top: -4px;">
                                                    Select all
                                                </a>
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]" value="manager"
                                                    {{ $data['manager'] ? 'checked' : '' }} />
                                                Manager
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]" value="creator"
                                                    {{ $data['creator'] ? 'checked' : '' }} />
                                                Creator
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]"
                                                    value="publisher" {{ $data['publisher'] ? 'checked' : '' }} />
                                                Publisher
                                            </label>

                                            {{--<label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]" value="verifier"
                                                    {{ $data['verifier'] ? 'checked' : '' }} />
                                                Verifier
                                            </label>

                                            <label class="dropdown-option">
                                                <input type="checkbox" class="franchise_role" name="role[]" value="reviewer"
                                                    {{ $data['reviewer'] ? 'checked' : '' }} />
                                                Reviewer
                                            </label>--}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Person name
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $data['user']->name }}" placeholder="Person name">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Username
                            </label>

                            <div class="box-input">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" placeholder="Username"
                                        value="{{ $data['user']->username }}" name="username" readonly>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                E-mail
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" value="{{ $data['user']->email }}"
                                        placeholder="E-mail" name="email" readonly>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Password
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>
                        </div> --}}

                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Required box
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-compass-fill"></i></span>
                                    <input type="password" class="form-control" placeholder="Required box">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Allowed content
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect02"><i
                                            class="bi bi-intersect"></i></label>
                                    <select class="form-select" id="inputGroupSelect02" name="allowed_to_upload">
                                        <option {{ $data['details']['allowed_to_upload'] == 0 ? 'selected' : '' }}
                                            value="0">No
                                        </option>
                                        <option {{ $data['details']['allowed_to_upload'] == 1 ? 'selected' : '' }}
                                            value="1">Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                                Status
                            </label>

                            <div class="box-input">
                                <!-- <div class="box-icon"></div> -->
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupSelect03"><i
                                            class="bi bi-person-badge-fill"></i></label>
                                    <select class="form-select" id="inputGroupSelect03" name="status">
                                        <!-- <option selected>Select Option</option> -->
                                        <option {{ $data['user']['status'] == 'inactive' ? 'selected' : '' }}
                                            value="inactive">
                                            Inactive</option>
                                        <option {{ $data['user']['status'] == 'active' ? 'selected' : '' }}
                                            value="active">
                                            Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mb-2">

                            <label class="box-heading text-end">
                            </label>

                            <div class="box-input">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-md-6 d-none">
                <div class="table-responsive">
                    <table class="table table-bordered border-primary corporate-table">
                        <tbody>
                            <tr>
                                <th>Actions</th>
                                <td>
                                    @if ($data['user']['status'] == 'new')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#approveBox">Ok</button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#rejectBox">Reject</button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#replyBox">Reply</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        #franchise_roles_div,
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
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();

        $('#is_staff_selection').on('change', function() {
            console.log($(this).val());
            if ($(this).val() == '1') {
                $('#franchise_roles_div').show();
            } else {
                $('#franchise_roles_div').hide();
            }
        })

        function showToast(message, bgColor) {
            var responseToastMessage = $('#responseToastMessage');
            responseToastMessage.html('');
            responseToastMessage.html(message);
            var responseToast = document.getElementById('responseToast');
            responseToast.classList.remove('bg-success');
            responseToast.classList.remove('bg-danger');
            responseToast.classList.add(bgColor);
            responseToast = new bootstrap.Toast(responseToast);
            responseToast.show();
        }
        var rejectBox = $('#reject-show')
        var approvedBox = $('#approved-show')
        var pendingBox = $('#pending-show')
        var replyBox = $('#reply-show')
        var formBox = $('#reply-hidden')

        function showReply() {
            rejectBox.hide();
            approvedBox.hide();
            pendingBox.hide();
            replyBox.show();
            formBox.hide();
        }

        function showReject() {
            rejectBox.show();
            approvedBox.hide();
            pendingBox.hide();
            replyBox.hide();
            formBox.hide();
        }

        function showApproved() {
            rejectBox.hide();
            approvedBox.show();
            pendingBox.hide();
            replyBox.hide();
            formBox.hide();
        }

        function showPending() {
            rejectBox.hide();
            approvedBox.hide();
            pendingBox.show();
            replyBox.hide();
            formBox.hide();
        }

        function closeBox() {
            rejectBox.hide();
            approvedBox.hide();
            pendingBox.hide();
            replyBox.hide();
            formBox.show();
        }

        function closeMessage(messageBox, loader) {
            messageBox.removeClass('is-invalid');
            messageBox.removeClass('is-valid');
            loader.hide();
            rejectBox.hide();
            approvedBox.hide();
            pendingBox.hide();
            replyBox.hide();
            formBox.hide();
        }

        function submitReply(id, button) {
            const message = $('#' + id + '-message');
            if (!message.val()) {
                message.addClass('is-invalid');
                message.removeClass('is-valid');
                return;
            } else {
                message.addClass('is-valid');
                message.removeClass('is-invalid');
            }
            const loader = $('#' + id + '-loader');
            loader.show();
            var formData = new FormData();
            formData.append('message', message.val())
            formData.append('type', id)
            formData.append('name', '{{ $data['user']['name'] }}')
            formData.append('email', '{{ $data['user']['email'] }}')
            formData.append('mobile', '{{ $data['user']['mobile'] }}')
            // formData.append('_token', $('meta[name="csrf-token"]').attr('content'))

            console.log(Array.from(formData));

            $.ajax({
                url: '/administrator/ajax/franchise-request',
                // url: '',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function(data) {
                console.log(data)
                var response = JSON.parse(data);
                var myClass = 'bg-danger';
                if (response['success']) {
                    myClass = 'bg-success';
                }
                showToast(response['message'], myClass);
                message.val('');
                closeMessage(message, loader);
            }).fail(function(err) {
                console.log('error', err)
                showToast(err.statusText, 'bg-danger');
                loader.hide();
                // closeMessage(message, loader);
            });

        }

        $('#reply-hidden').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'set_user');

            if ($('#is_staff_selection').val() == 1) {
                var franchise_role_checked = $('.franchise_role:checked').length;
                var franchiseRoleDiv = $('#franchiseRoleDiv');
                if (franchise_role_checked == 0) {
                    $(franchiseRoleDiv).css('border', '2px solid crimson');
                    showToast('Please select atleast one franchise role', 'bg-danger');
                    setTimeout(() => {
                        franchiseRoleDiv.css('border', 'none');
                    }, 3000);
                    return;
                }
            }
            console.log(Array.from(formData));
            // return;
            $.ajax({
                url: '',
                data: formData,
                processData: false,
                type: 'post',
                contentType: false
            }).done(function(data) {
                console.log(data);
                if (data == true) {
                    showToast('Succesfully saved.', 'bg-success');
                    location.reload();
                } else {
                    showToast('Server error, please try again later.', 'bg-danger');
                }
                // return;
            }).fail(function(data) {
                showToast('Server error, please try again later.', 'bg-danger');
                console.log(data)
            });
        })
    </script>

    @if ($data['user']['is_staff'] == 1)
        <script>
            $('#franchise_roles_div').show();
        </script>
    @endif

    <script>
        (function($) {
            var CheckboxDropdown = function(el) {
                var _this = this;
                this.isOpen = false;
                this.areAllChecked = false;
                this.$el = $(el);
                this.$label = this.$el.find('.dropdown-label')
                this.$label1 = this.$el.find('#label1');
                this.$label2 = this.$el.find('#label2');
                this.$checkAll = this.$el.find('[data-toggle="check-all"]'); //first()
                this.$inputs = this.$el.find('[type="checkbox"]');

                this.onCheckBox();

                this.$label.on('click', function(e) {
                    e.preventDefault();
                    _this.toggleOpen();
                });

                this.$checkAll.on('click', function(e) {
                    e.preventDefault();
                    _this.onCheckAll();
                });

                this.$inputs.on('change', function(e) {
                    _this.onCheckBox();
                });
            };

            CheckboxDropdown.prototype.onCheckBox = function() {
                this.updateStatus();
            };

            CheckboxDropdown.prototype.updateStatus = function() {
                var checked = this.$el.find(':checked');

                this.areAllChecked = false;
                this.$checkAll.html('Select All');

                if (checked.length <= 0) {
                    this.$label1.html(
                        'Select Franchise <i class="fa fa-angle-down" style="float: right; font-size: 17px; font-weight: bold;"></i>'
                    );
                    this.$label2.html(
                        'Select role <i class="fa fa-angle-down" style="float: right; font-size: 17px; font-weight: bold;"></i>'
                    );
                } else if (checked.length === 1) {
                    this.$label.html(checked.parent('label').text());
                } else if (checked.length === this.$inputs.length) {
                    this.$label.html('All Selected');
                    this.areAllChecked = true;
                    this.$checkAll.html('Unselect All');
                } else {
                    this.$label.html(checked.length +
                        " selected <i class='fa fa-angle-down' style='float: right; font-size: 17px; font-weight: bold;'></i>"
                    );
                }

                // else {
                //   this.$label.html(checked.length + ' Selected');
                // }
            };

            CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
                if (!this.areAllChecked || checkAll) {
                    this.areAllChecked = true;
                    this.$checkAll.html('Uncheck All');
                    this.$inputs.prop('checked', true);
                } else {
                    this.areAllChecked = false;
                    this.$checkAll.html('Check All');
                    this.$inputs.prop('checked', false);
                }

                this.updateStatus();
            };

            CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
                var _this = this;

                if (!this.isOpen || forceOpen) {
                    this.isOpen = true;
                    this.$el.addClass('on');
                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('[data-control]').length) {
                            _this.toggleOpen();
                        }
                    });
                } else {
                    this.isOpen = false;
                    this.$el.removeClass('on');
                    $(document).off('click');
                }
            };

            var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
            for (var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
                new CheckboxDropdown(checkboxesDropdowns[i]);
            }
        })(jQuery);
        /*
        Reference: http://jsfiddle.net/BB3JK/47/
        */

        $('.select').each(function() {
            var $this = $(this),
                numberOfOptions = $(this).children('option').length;

            $this.addClass('select-hidden');
            $this.wrap('<div class="select"></div>');
            $this.after('<div class="select-styled"></div>');

            var $styledSelect = $this.next('div.select-styled');
            $styledSelect.text($this.children('option').eq(0).text());

            var $list = $('<ul />', {
                'class': 'select-options'
            }).insertAfter($styledSelect);

            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }

            var $listItems = $list.children('li');

            $styledSelect.click(function(e) {
                e.stopPropagation();
                $('div.select-styled.active').not(this).each(function() {
                    $(this).removeClass('active').next('ul.select-options').hide();
                });
                $(this).toggleClass('active').next('ul.select-options').toggle();
            });

            $listItems.click(function(e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $list.hide();
                //console.log($this.val());
            });

            $(document).click(function() {
                $styledSelect.removeClass('active');
                $list.hide();
            });

        });
    </script>

@endsection
