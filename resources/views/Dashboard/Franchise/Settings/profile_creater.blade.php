@extends('Layouts.Management.creater')

@section('css')
@endsection
@section('main')
    <section class="content admin-1">
        {{-- Main Profile Form: Image Only --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Profile Image</h5>
                <form id="uploadImage" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Select User Image" class="control-label">Select User Image</label>
                                <input name="user_image" class="form-control" accept="image/jpeg,image/jpg" type="file"
                                    onchange="avatarPreview(event)">
                                <img class="w-100 mb-2 mt-2" id="user_profile_image" style="max-width: 300px;"
                                    src="{{ !empty($user['details']['photo_url']) ? '/storage/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success float-right" type="submit" id="imageSaveButton">
                                Update Profile Image
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Email Change Section --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Change Email Address</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Current Email</label>
                            <input type="text" class="form-control" value="<?php echo $user['details']['email']; ?>" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Email" class="control-label">New Email</label>
                            <input type="email" id="email" class="form-control" style="border: 1px solid #aaa;"
                                value="<?php echo $user['details']['email']; ?>" placeholder="Enter New Email">
                            <button class="btn btn-primary sendEmailOtp mt-1" onclick="sendEmailOtp()" type="button">
                                Get OTP
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Email OTP" class="control-label">Verify Email OTP</label>
                            <input type="text" id="email_otp" class="form-control"
                                placeholder="Enter OTP" style="border: 1px solid #aaa;">
                            <button class="btn btn-primary verifyEmailOtp mt-1" onclick="verifyEmailOtp()" type="button" disabled>
                                Verify
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="old_email" value="{{$user->email}}">
            </div>
        </div>

        {{-- Phone Change Section --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Change Mobile Number</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Current Mobile</label>
                            <input type="text" class="form-control" value="<?php echo $user['details']['mobile']; ?>" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Mobile No." class="control-label">New Mobile No.</label>
                            <input type="number" id="mobile" minlength="10" maxlength="10" class="form-control"
                                value="<?php echo $user['details']['mobile']; ?>" placeholder="Enter New Mobile">
                            <button class="btn btn-primary sendMobileOtp mt-1" onclick="sendMobileOtp()" type="button">
                                Get OTP
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Mobile OTP" class="control-label">Verify Mobile OTP</label>
                            <input type="number" id="mobile_otp" minlength="6" maxlength="6"
                                class="form-control" placeholder="Enter OTP">
                            <button class="btn btn-primary verifyMobileOtp mt-1" onclick="verifyMobileOtp()"
                                type="button" disabled>
                                Verify
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="old_mobile_number" value="{{$user->mobile}}">
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script>
        function avatarPreview(event) {
            var output = document.getElementById('user_profile_image');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
                // $('#imageSaveButton').show();
            } else {
                // $('#imageSaveButton').hide();
            }
        }

        function sendEmailOtp() {
            var old_email = document.getElementById('old_email').value;
            var email = document.getElementById('email').value;
            if (old_email == email) {
                alert('Email Already Updated!');
                $(".sendEmailOtp").removeAttr('disabled', '');
            } else {

                $(".sendEmailOtp").attr('disabled', '');
                $.get("/corporate/management/profile/verifyemail/" + email, function(data) {
                    if (data == false) {
                        alert('Email Already Registered!');
                        $(".sendEmailOtp").removeAttr('disabled', '');
                    } else if (data.message) {
                        alert(data.message);
                        $(".sendEmailOtp").removeAttr('disabled', '');
                    } else if (data.success) {
                        alert('Otp Sent!');
                        $(".verifyEmailOtp").removeAttr('disabled', '');
                    } else {
                        alert('Failed to send OTP');
                        $(".sendEmailOtp").removeAttr('disabled', '');
                    }
                });
            }

        }

        function verifyEmailOtp() {
            var email = document.getElementById('email').value;
            var email_otp = document.getElementById('email_otp').value;

            $.get("/corporate/management/profile/verifyotp/email/" + email + "/" + email_otp, function(data) {
                if (data == true) {
                    alert('Email Updated Successfully!');
                    location.reload();
                } else {
                    alert('Please Enter Valid OTP');
                }
            });
        }

        function sendMobileOtp() {
            var old_mobile_number = document.getElementById('old_mobile_number').value;
            var mobile_number = document.getElementById('mobile').value;
            if (old_mobile_number == mobile_number) {
                alert('Mobile Number Already Updated!');
                $(".sendMobileOtp").removeAttr('disabled', '');
            } else {

                $(".sendMobileOtp").attr('disabled', '');
                $.get("/corporate/management/profile/verifymobile/" + mobile_number, function(data) {
                    if (data == false) {
                        alert('Mobile Number Already Registered!');
                        $(".sendMobileOtp").removeAttr('disabled', '');
                    } else if (data.message) {
                        alert(data.message);
                        $(".sendMobileOtp").removeAttr('disabled', '');
                    } else if (data.success) {
                        alert('Otp Sent!');
                        $(".verifyMobileOtp").removeAttr('disabled', '');
                    } else {
                        alert('Failed to send OTP');
                        $(".sendMobileOtp").removeAttr('disabled', '');
                    }
                });
            }

        }

        function verifyMobileOtp() {
            var mobile_number = document.getElementById('mobile').value;
            var mobile_otp = document.getElementById('mobile_otp').value;

            $.get("/corporate/management/profile/verifyotp/mobile/" + mobile_number + "/" + mobile_otp, function(data) {
                if (data == true) {
                    alert('Mobile Number Updated Successfully!');
                    location.reload();
                } else {
                    alert('Please Enter Valid OTP');
                }
            });
        }
    </script>
