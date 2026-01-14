@extends('Layouts.Management.manager')

@section('css')
    <style>
        #imageSaveButton {
            display: none;
        }
    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="card">
            <div class="card-body">


                    <form  id="uploadImage" enctype="multipart/form-data" method="post">
                        @csrf
                            <input type="hidden" id="old_mobile_number" name="old_mobile_number" value="{{$user->mobile}}">
                            <input type="hidden" id="verify_mobile_check" name="verify_mobile_check">
                            <input type="hidden" id="old_email" name="old_email" value="{{$user->email}}">
                            <input type="hidden" id="verify_email_check" name="verify_email_check">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Select User Image" class="control-label"></label>
                                        <input name="user_image" class="form-control" accept="image/jpeg,image/jpg" type="file"
                                            onchange="avatarPreview(event)">
                                        <img class="w-100 mb-2" id="user_profile_image"
                                            src="{{ !empty($user['details']['photo_url']) ? '/storage/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Email" class="control-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            style="border: 1px solid #aaa;" value="<?php echo $user['details']['email']; ?>" required>
                                        <button class="btn btn-primary sendEmailOtp mt-1" onclick="sendEmailOtp()" type="button">
                                            Get Otp
                                        </button>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="Email OTP" class="control-label">Verify Email OTP</label>
                                        <input type="text" name="email_otp" id="email_otp" class="form-control"
                                            placeholder="Input OTP" style="border: 1px solid #aaa;">
                                        <button class="btn btn-primary verifyEmailOtp mt-1" onclick="verifyEmailOtp()" type="button"
                                            disabled>
                                            Verify
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Mobile No." class="control-label">Mobile No.</label>
                                        <input type="number" id="mobile" name="mobile" minlength="10" maxlength="10"
                                            required="" class="form-control" value="<?php echo $user['details']['mobile']; ?>">
                                        <button class="btn btn-primary sendMobileOtp mt-1" onclick="sendMobileOtp()" type="button">
                                            Get Otp
                                        </button>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="Mobile OTP" class="control-label">Verify Mobile OTP</label>
                                        <input type="number" name="mobile_otp" id="mobile_otp" minlength="6" maxlength="6"
                                            class="form-control" placeholder="Input OTP">
                                        <button class="btn btn-primary verifyMobileOtp mt-1" onclick="verifyMobileOtp()"
                                            type="button" disabled>
                                            Verify
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" type="submit" id="imageSaveButton" >
                                    Update Profile Details
                                </button>
                            </div>
                        </div>

                    </form>


            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script>
        $('#imageSaveButton').show();

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
                    alert('Otp Verified!');
                    $(".verifyEmailOtp").attr('disabled', '');
                    document.getElementById('verify_email_check').value = '1';
                } else {
                    alert('Please Enter Valid Otp');
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
                    alert('Otp Verified!');
                    $(".verifyMobileOtp").attr('disabled', '');
                    document.getElementById('verify_mobile_check').value = '1';
                } else {
                    alert('Please Enter Valid Otp');
                }
            });
        }
    </script>
@endsection
