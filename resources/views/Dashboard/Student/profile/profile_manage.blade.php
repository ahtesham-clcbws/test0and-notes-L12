@extends('Layouts.student')

@section('main')
    <div class="container p-0">
        @if (session()->has('message'))
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                {{ session('message') }}

            </div>
        @endif
        <form class="card dashboard-container mb-5" action="{{ route('student.manage_profile_process') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="Name">Name</label>
                            <input class="form-control form-control-sm" name="name" type="text"
                                value="{{ $user->name }}" style="border: 1px solid #aaa;" placeholder="Enter Name"
                                required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="photo_url">Select Photo</label>
                            <input class="form-control form-control-sm" name="photo_url" type="file"
                                style="border: 1px solid #aaa;">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="Email">Email</label>
                            <div class="input-group">
                                <input class="form-control" id="email_new" name="email" type="email"
                                    value="{{ $user->email }}" oninput="uniqueEmailCheck(this)"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="E-mail">
                                <div class="input-group-append">
                                    <button class="btn btn-primary sendEmailOtp" type="button" onclick="sendEmailOtp()">
                                        Get Otp
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="control-label" for="Email">Verify Email</label>
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="email_otp" name="email_otp" type="text"
                                    style="border: 1px solid #aaa;" placeholder="Input OTP">
                                <div class="input-group-append">
                                    <button class="btn btn-primary verifyEmailOtp" type="button" onclick="verifyEmailOtp()"
                                        disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="Mobile">Mobile</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile_number" name="mobile_number" type="number"
                                    value="{{ $user->mobile }}" minlength="10" maxlength="10" placeholder="Mobile">
                                <div class="input-group-append">
                                    <button class="btn btn-primary sendOtp" type="button" onclick="sendOtp()">
                                        Get Otp
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="control-label" for="Mobile">Verify Mobile</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile_otp" name="mobile_otp" type="number" minlength="6"
                                    maxlength="6" placeholder="Input OTP">
                                <div class="input-group-append">
                                    <button class="btn btn-primary verifyOtp" type="button" onclick="verifyOtp()" disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input id="old_mobile_number" name="old_mobile_number" type="hidden" value="{{ $user->mobile }}">
                    <input id="verify_check" name="verify_check" type="hidden">
                    <input id="old_email" name="old_email" type="hidden" value="{{ $user->email }}">
                    <input id="verify_email_check" name="verify_email_check" type="hidden">


                    <div class="row mt-3">
                        <div class="form-group" style="float:right">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        function sendOtp() {
            var old_mobile_number = document.getElementById('old_mobile_number').value;
            var mobile_number = document.getElementById('mobile_number').value;
            if (old_mobile_number == mobile_number) {
                alert('Mobile Number Already Updated!');
            } else {
                $.get("/student/verifynumber/" + mobile_number, function(data) {
                    if (data == false) {
                        alert('Mobile Number Already Registered!');
                    } else if (data.success) {
                        alert('Otp Sent!');
                        $(".sendOtp").attr('disabled', '');
                        $(".verifyOtp").removeAttr('disabled', '');
                    } else {
                        alert(data.message || 'Failed to send OTP');
                    }
                });
            }

        }

        function verifyOtp() {
            var mobile_number = document.getElementById('mobile_number').value;
            var mobile_otp = document.getElementById('mobile_otp').value;

            $.get("/student/verifyotp/" + mobile_number + "/" + mobile_otp, function(data) {
                if (data == true) {
                    alert('Otp Verified!');
                    $(".verifyOtp").attr('disabled', '');
                    document.getElementById('verify_check').value = '1';
                } else {
                    alert('Please Enter Valid Otp');
                }
            });
        }

        //     $('#change_profile input[type=file]').submit(function(event) {
        //         var verify_check = document.getElementById('verify_check').value;
        //         var old_mobile_number = document.getElementById('old_mobile_number').value;
        //           var mobile_number = document.getElementById('mobile_number').value;
        //             if(old_mobile_number != mobile_number){
        //                 if(verify_check != 1){
        //                 Swal.fire('Please Verify Mobile Number')
        //                 return false;
        //                 }
        //                 // Swal.fire('Mobile Number Already Updated!')
        //             }
        //             else{
        //               event.preventDefault();
        //               let timerInterval
        //               Swal.fire({
        //               title: 'Wait...',
        //               // html: 'I will close in <b></b> milliseconds.',
        //               //   timer: 2000,
        //               timerProgressBar: true,
        //               didOpen: () => {
        //                   Swal.showLoading()
        //                   const b = Swal.getHtmlContainer().querySelector('b')
        //                   timerInterval = setInterval(() => {
        //                   b.textContent = Swal.getTimerLeft()
        //                   },)
        //               },
        //               })
        //               var formData = $(this).serialize();
        //               var file = e.target.files[event];
        //               formData.append('photo', file);
        //               $.ajax({
        //                   url: $(this).attr('action'),
        //                   type: 'POST',
        //                   async: true,
        //                   data: formData,
        //                   success: function(response) {
        //                       if (response == true) {
        //                           willClose: () => {
        //                               clearInterval(timerInterval)
        //                           }

        //                       Swal.fire(
        //                             'Good job!',
        //                             'Profile Updated.',
        //                             'success',

        //                           ).then(function() {
        //                             location.reload();
        //                               });
        //                       } else {
        //                         Swal.fire({
        //                           icon: 'error',
        //                           title: 'This Email Alredy Registred!',
        //                           text: response.msg,
        //                         })
        //                         // $("#msg_telent").html(response.msg);
        //                       }
        //                   }
        //               });
        //             }
        // });

        function sendEmailOtp() {
            var old_email = document.getElementById('old_email').value;
            var email = document.getElementById('email_new').value;
            if (old_email == email) {
                alert('Email Already Updated!');
            } else {
                $.get("/student/verifyemail/" + email, function(data) {
                    if (data == false) {
                        alert('Email Already Registered!');
                    } else if (data.success) {
                        alert('Otp Sent!');
                        $(".sendEmailOtp").attr('disabled', '');
                        $(".verifyEmailOtp").removeAttr('disabled', '');
                    } else {
                        alert(data.message || 'Failed to send OTP');
                    }
                });
            }

        }

        function verifyEmailOtp() {
            var email = document.getElementById('email_new').value;
            var email_otp = document.getElementById('email_otp').value;

            $.get("/student/verifyemailotp/" + email + "/" + email_otp, function(data) {
                if (data == true) {
                    alert('Otp Verified!');
                    $(".verifyEmailOtp").attr('disabled', '');
                    document.getElementById('verify_email_check').value = '1';
                } else {
                    alert('Please Enter Valid Otp');
                }
            });
        }

        //     $('#change_profile input[type=file]').submit(function(event) {
    </script>
@endsection
