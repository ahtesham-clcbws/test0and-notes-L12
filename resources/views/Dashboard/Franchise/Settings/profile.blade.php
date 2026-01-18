@extends('Layouts.franchise')

@section('css')
@endsection
@section('main')
    <section class="content admin-1">
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

        {{-- Main Profile Form: Images Only --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Profile Images</h5>
                <form id="uploadImage" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="Select User Image">Select User Image</label>
                                <input class="form-control" name="user_image" type="file" accept="image/jpeg,image/jpg"
                                    onchange="avatarPreview(event)">
                                <img class="w-100 mb-2 mt-2" id="user_profile_image"
                                    src="{{ $user['details']['photo_url'] ? '/storage/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="Select User Image">Select Logo</label>
                                <input class="form-control" name="logo" type="file" accept="image/jpeg,image/jpg"
                                    onchange="logoPreview(event)">
                                <img class="w-100 mb-2 mt-2" id="user_logo_image"
                                    src="{{ $user['details']['logo'] ? '/storage/' . $user['details']['logo'] : asset('noimg.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success float-right mt-2" id="imageSaveButton" type="submit">
                                Save Profile Images
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
                            <input class="form-control" type="text" value="<?php echo $user['details']['email']; ?>" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Email">New Email</label>
                            <div class="input-group">
                                <input class="form-control" id="email" type="email"
                                    value="<?php echo $user['details']['email']; ?>" style="border: 1px solid #aaa;" placeholder="Enter New Email">
                                <button class="btn btn-primary sendEmailOtp" type="button" onclick="sendEmailOtp()">
                                    Get OTP
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Email">Verify Email</label>
                            <div class="input-group">
                                <input class="form-control" id="email_otp" type="text"
                                    style="border: 1px solid #aaa;" placeholder="Enter OTP">
                                <button class="btn btn-primary verifyEmailOtp" type="button"
                                    onclick="verifyEmailOtp()" disabled>
                                    Verify
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="old_email" type="hidden" value="{{ $user->email }}">
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
                            <input class="form-control" type="text" value="<?php echo $user['details']['mobile']; ?>" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Mobile No.">New Mobile No.</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile" type="number"
                                    value="<?php echo $user['details']['mobile']; ?>" minlength="10" maxlength="10" placeholder="Enter New Mobile">
                                <button class="btn btn-primary sendMobileOtp" type="button" onclick="sendMobileOtp()">
                                    Get OTP
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Mobile">Verify Mobile</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile_otp" type="number" minlength="6"
                                    maxlength="6" placeholder="Enter OTP">
                                <button class="btn btn-primary verifyMobileOtp" type="button"
                                    onclick="verifyMobileOtp()" disabled>
                                    Verify
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="old_mobile_number" type="hidden" value="{{ $user->mobile }}">
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
                    alert('Mobile Number Updated Successfully!');
                    location.reload();
                } else {
                    alert('Please Enter Valid OTP');
                }
            });
        }
    </script>
@endsection
