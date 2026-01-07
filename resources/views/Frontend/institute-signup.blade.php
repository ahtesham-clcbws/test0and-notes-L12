@extends('Layouts.frontend')

@section('css')
    <style>
        /* #corporate .form-control,
                                                        #corporate .form-select {
                                                            height: inherit;
                                                        } */
        #corporate .input-group .btn {
            min-width: 85px;
        }

    </style>
@endsection
@section('main')

    <section>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                    <div class="crs_log_wrap">
                        <form class="crs_log__caption" id="corporate_regis" method="post">
                            <div class="rcs_log_124">
                                <div class="row py-3">
                                    <div class="col">
                                        <h4 class="theme-cl">Admin Signup</h4>
                                    </div>
                                    {{-- <div class="col text-end">
                                        <a href="{{ route('franchise.login') }}">
                                            <h4 class="text-primary">Admin Login</h4>
                                        </a>
                                    </div> --}}
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-12 mt-2">
                                        <div class="form-group smalls">
                                            <label>Institute / School Code *</label>
                                            <input type="text" class="form-control" name="school_code"
                                                oninput="branchCodeCheck(this)" id="school_code" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="form-group smalls">
                                            <label>Verified Mobile No *</label>
                                            <input type="number" maxlength="10" class="form-control" name="mobile_no"
                                                oninput="branchMobileCheck(this)" id="Verified_Mobile" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="form-group smalls">
                                            <label>Verified E-mail ID *</label>
                                            <input type="email" class="form-control" name="verify_email"
                                                oninput="branchEmailCheck(this)" id="verify_email" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="form-group smalls">
                                            <label>Create password *</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="password" name="password_corporegis"
                                                    id="password_corporegis" minlength="5" oninput="validatePassword2(this)"
                                                    required />
                                                <button class="btn btn-dark togglePassword" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="form-group smalls">
                                            <label>Confirm password *</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="password"
                                                    name="confirm_password_corporegis" id="confirm_password_corporegis"
                                                    minlength="5" oninput="inputConfirmPassword2(this)" required />
                                                <button class="btn btn-dark togglePassword" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" id="corporate_submit_button"
                                        class="btn full-width btn-md theme-bg text-white">Submit</button>
                                </div>
                                <div class="form-group mt-3">
                                    <p class="text-center">
                                    Already have an account? <a class="modal-title theme-cl pointerCursor" href="{{ route('franchise.login') }}">Login Here</a>
                                </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        var studentPasswordValid = true;
        var branchCodeVerify    = $('#branchCodeVerify');
        var branchMobileVerify  = $('#branchMobileVerify');
        var branchEmailVerify   = $('#branchEmailVerify');

        function inputConfirmPassword2(event) {
            validatePassword(event)
            if (checkPasswordmatch2()) {
                $('#password_corporegis').css('border-color', '#198754');
                $(event).css('border-color', '#198754');
                studentPasswordValid = true;
            } else {
                $('#password_corporegis').css('border-color', 'crimson');
                $(event).css('border-color', 'crimson');
                studentPasswordValid = false;
            }
        }

        function checkPasswordmatch2() {
            if ($('#password_corporegis').val() == $('#confirm_password_corporegis').val()) {
                studentPasswordValid = true;
                return true;
            }
            studentPasswordValid = false;
            return false;
        }

        function validatePassword2(event) {
            var passwordStr = $(event).val().toString();
            if (passwordStr.length > 4) {
                $(event).css('border-color', '#198754');
                studentPasswordValid = true;
            } else {
                $(event).css('border-color', 'crimson');
                studentPasswordValid = false;
            }
        }

        function branchCodeCheck(event) {
            var branchInput = $(event);
            if (branchInput.val().length > 9) {
                var formData = new FormData();
                formData.append('form_name', 'branch_code_check');
                formData.append('branch_code', branchInput.val());
                console.log(Array.from(formData));
                $.ajax({
                    url: '/',
                    data: formData,
                    processData: false,
                    type: 'post',
                    contentType: false
                }).done(function(data) {
                    console.log(data);
                    if (data == true) {
                        branchCodeVerify.val(1);
                        $(event).css('border-color', '#198754');
                    } else {
                        branchCodeVerify.val(0);
                        $(event).css('border-color', 'crimson');
                    }
                }).fail(function(data) {
                    console.log(data)
                });
            }
        }

        function branchMobileCheck(event) {
            var branchInput = $(event);
            if (branchInput.val().length > 9) {
                var formData = new FormData();
                formData.append('form_name', 'branch_mobile_check');
                formData.append('branch_mobile', branchInput.val());
                console.log(Array.from(formData));
                $.ajax({
                    url: '/',
                    data: formData,
                    processData: false,
                    type: 'post',
                    contentType: false
                }).done(function(data) {
                    console.log(data);
                    if (data == true) {
                        branchMobileVerify.val(1);
                        // $(event).css('border-color', '#198754');
                         $(event).css('border-color', 'crimson');
                    } else {
                        branchMobileVerify.val(0);
                        // $(event).css('border-color', 'crimson');
                        $(event).css('border-color', '#198754');
                    }
                }).fail(function(data) {
                    console.log(data)
                });

            } else {
                branchMobileVerify.val(0);
                $(event).css('border-color', 'crimson');
            }
        }

        function branchEmailCheck(event) {
            var branchInput = $(event);
            if (branchInput.val().length > 9) {
                var formData = new FormData();
                formData.append('form_name', 'branch_email_check');
                formData.append('branch_email', branchInput.val());
                console.log(Array.from(formData));
                $.ajax({
                    url: '/',
                    data: formData,
                    processData: false,
                    type: 'post',
                    contentType: false
                }).done(function(data) {
                    console.log('asdf');
                    console.log(data);
                    // if (data == true) {
                    //     branchEmailVerify.val(1);
                    //     $(event).css('border-color', '#198754');
                    // } else {
                    //     branchEmailVerify.val(0);
                    //     $(event).css('border-color', 'crimson');
                    // }

                    if (data == true) {
                        branchEmailVerify.val(1);
                        $(event).css('border-color', 'crimson');

                    } else {
                        branchEmailVerify.val();
                        $(event).css('border-color', '#198754');
                    }
                }).fail(function(data) {
                    console.log(data)
                });
            }
        }

        $('#corporate_regis').submit(function(event) {
            event.preventDefault();
            if (!studentPasswordValid) {
                showAlert(
                    'Password not valid, or both password not matched.',
                    'Error', 'warning');
                return;
            }
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'corporate_signup');
            //console.log(Array.from(formData));
            $.ajax({
                url: '/',
                data: formData,
                processData: false,
                type: 'post',
                contentType: false
            }).done(function(data) {
                //console.log(data);
                if (data =='true') {
                    showAlert("Thank you, we will activated your account once reviewed.").then(() => {
                        window.location.href = '{{ route('home_page') }}'
                    });
                } else {
                    showAlert('Server issue, please try again later.', 'Error', 'error');
                }
            }).fail(function(data) {
                showAlert('Server Error, please try again later.', 'Error', 'error');
                console.log(data)
            })
        })
    </script>
@endsection
