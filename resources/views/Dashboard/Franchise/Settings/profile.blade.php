@extends('Layouts.franchise')

@section('css')
    <style>
        #imageSaveButton2,
        #imageSaveButton {
            display: none;
        }
    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="card">
            <div class="card-body">
                @if (session()->has('message'))
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                    </div>
                @endif
                <form id="uploadImage" enctype="multipart/form-data" method="post">
                    @csrf
                    <input id="old_mobile_number" name="old_mobile_number" type="hidden" value="{{ $user->mobile }}">
                    <input id="verify_mobile_check" name="verify_mobile_check" type="hidden">
                    <input id="old_email" name="old_email" type="hidden" value="{{ $user->email }}">
                    <input id="verify_email_check" name="verify_email_check" type="hidden">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Select User Image">Select User Image</label>
                                <input class="form-control" name="user_image" type="file" accept="image/jpeg,image/jpg"
                                    onchange="avatarPreview(event)">
                                <img class="w-100 mb-2" id="user_profile_image"
                                    src="{{ $user['details']['photo_url'] ? '/storage/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Select User Image">Select Logo</label>
                                <input class="form-control" name="logo" type="file" accept="image/jpeg,image/jpg"
                                    onchange="logoPreview(event)">
                                <img class="w-100 mb-2" id="user_logo_image"
                                    src="{{ $user['details']['logo'] ? '/storage/' . $user['details']['logo'] : asset('noimg.png') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Email">Email</label>
                                <div class="input-group">
                                    <input class="form-control" id="email" name="email" type="email"
                                        value="<?php echo $user['details']['email']; ?>" style="border: 1px solid #aaa;" required>
                                    <button class="btn btn-primary sendEmailOtp" type="button" onclick="sendEmailOtp()">
                                        Get Otp
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label" for="Email">Verify Email</label>
                                <div class="input-group">
                                    <input class="form-control" id="email_otp" name="email_otp" type="text"
                                        style="border: 1px solid #aaa;" placeholder="Input OTP">
                                    <button class="btn btn-primary verifyEmailOtp" type="button"
                                        onclick="verifyEmailOtp()" disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="Mobile No.">Mobile No.</label>
                                <div class="input-group">
                                    <input class="form-control" id="mobile" name="mobile" type="number"
                                        value="<?php echo $user['details']['mobile']; ?>" minlength="10" maxlength="10" required="">
                                    <button class="btn btn-primary sendMobileOtp" type="button" onclick="sendMobileOtp()">
                                        Get Otp
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label" for="Mobile">Verify Mobile</label>
                                <div class="input-group">
                                    <input class="form-control" id="mobile_otp" name="mobile_otp" type="number" minlength="6"
                                        maxlength="6" placeholder="Input OTP">
                                    <button class="btn btn-primary verifyMobileOtp" type="button"
                                        onclick="verifyMobileOtp()" disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success w-100 mt-2" id="imageSaveButton" type="submit">
                                Save Profile Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

        function logoPreview(event) {
            var output = document.getElementById('user_logo_image');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
                // $('#imageSaveButton2').show();
            } else {
                // $('#imageSaveButton2').hide();
            }
        }
        // $('#uploadImage').submit(function(event) {
        //     event.preventDefault();
        //     var formData = new FormData($(this)[0]);

        //     $.ajax({
        //         url: '/',
        //         type: 'post',
        //         data: formData,
        //         contentType: false,
        //         processData: false
        //     }).done(function(response, textStatus) {
        //         console.log(response);
        //         if(response == 'true') {
        //             location.reload();
        //         }
        //     }).fail(function(error, textStatus) {
        //         console.log(error);
        //     })
        // })

        function sendEmailOtp() {
            var old_email = document.getElementById('old_email').value;
            var email = document.getElementById('email').value;
            if (old_email == email) {
                alert('Email Already Updated!');
                $(".sendEmailOtp").removeAttr('disabled', '');
            } else {

                $(".sendEmailOtp").attr('disabled', '');
                $.get("/corporate/profile/verifyemail/" + email, function(data) {
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

            $.get("/corporate/profile/verifyotp/email/" + email + "/" + email_otp, function(data) {
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
                $.get("/corporate/profile/verifymobile/" + mobile_number, function(data) {
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

            $.get("/corporate/profile/verifyotp/mobile/" + mobile_number + "/" + mobile_otp, function(data) {
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
