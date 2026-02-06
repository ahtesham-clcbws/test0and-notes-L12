@extends('Layouts.student')

@section('main')
    <div class="container p-0">
        @if (session()->has('message'))
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                {{ session('message') }}

            </div>
        @endif

        {{-- Main Profile Form: Name and Photo Only --}}
        <form class="card dashboard-container mb-3" action="{{ route('student.manage_profile_process') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="Name">Name</label>
                            <input class="form-control form-control-sm" name="name" type="text"
                                value="{{ $user->name }}" style="border: 1px solid #aaa;" placeholder="Enter Name"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="photo_url">Select Photo</label>
                            <input class="form-control form-control-sm" name="photo_url" type="file"
                                style="border: 1px solid #aaa;" onchange="previewImage(event)">
                            <img id="photo_preview" src="" alt="Image Preview"
                                style="display: none; max-width: 100%; height: auto; margin-top: 10px; border: 1px solid #ccc; padding: 5px;">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" type="submit">Update Profile</button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Email Change Section --}}
        <div class="card dashboard-container mb-3">
            <div class="card-body">
                <h5 class="mb-3">Change Email Address</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Current Email</label>
                            <input class="form-control form-control-sm" type="text" value="{{ $user->email }}" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Email">New Email</label>
                            <div class="input-group">
                                <input class="form-control" id="email_new" type="email"
                                    value="{{ $user->email }}"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Enter New Email">
                                <div class="input-group-append">
                                    <button class="btn btn-primary sendEmailOtp" type="button" onclick="sendEmailOtp()">
                                        Get OTP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Email">Verify Email</label>
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="email_otp" type="text"
                                    style="border: 1px solid #aaa;" placeholder="Enter OTP">
                                <div class="input-group-append">
                                    <button class="btn btn-primary verifyEmailOtp" type="button" onclick="verifyEmailOtp()"
                                        disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="old_email" type="hidden" value="{{ $user->email }}">
            </div>
        </div>

        {{-- Phone Change Section --}}
        <div class="card dashboard-container mb-5">
            <div class="card-body">
                <h5 class="mb-3">Change Mobile Number</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Current Mobile</label>
                            <input class="form-control form-control-sm" type="text" value="{{ $user->mobile }}" readonly
                                style="border: 1px solid #aaa; background-color: #f5f5f5;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Mobile">New Mobile</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile_number" type="number"
                                    value="{{ $user->mobile }}" minlength="10" maxlength="10" placeholder="Enter New Mobile">
                                <div class="input-group-append">
                                    <button class="btn btn-primary sendOtp" type="button" onclick="sendOtp()">
                                        Get OTP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="Mobile">Verify Mobile</label>
                            <div class="input-group">
                                <input class="form-control" id="mobile_otp" type="number" minlength="6"
                                    maxlength="6" placeholder="Enter OTP">
                                <div class="input-group-append">
                                    <button class="btn btn-primary verifyOtp" type="button" onclick="verifyOtp()" disabled>
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="old_mobile_number" type="hidden" value="{{ $user->mobile }}">
            </div>
        </div>
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
                    alert('Mobile Number Updated Successfully!');
                    location.reload();
                } else {
                    alert('Please Enter Valid OTP');
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
                    alert('Email Updated Successfully!');
                    location.reload();
                } else {
                    alert('Please Enter Valid OTP');
                }
            });
        }

        //     $('#change_profile input[type=file]').submit(function(event) {

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photo_preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
