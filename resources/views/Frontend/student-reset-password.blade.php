@extends('Layouts.frontend')

@section('main')

    <section>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
                    <div class="crs_log_wrap">
                        @if ($data['typeOfRequest'] == 'reset')
                            <form class="crs_log__caption" id="reset_form">
                                <div class="rcs_log_124">
                                    <div class="row py-3">
                                        <div class="col">
                                            <h4 class="theme-cl">Reset Password</h4>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <input class="d-none" name="reset_id" value="{{ $data['reset']['id'] }}">
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="form-group smalls">
                                                <label>Email *</label>
                                                <input type="email" class="form-control" name="student_email"
                                                    id="student_email" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="form-group smalls">
                                                <label>Reset Code *</label>
                                                <input type="number" min="111111" max="999999" class="form-control"
                                                    name="student_code" id="student_code" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="form-group smalls">
                                                <label>Password *</label>
                                                <input type="password" class="form-control" name="student_password"
                                                    id="student_password" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="form-group smalls">
                                                <label>Confirm Password *</label>
                                                <input type="password" class="form-control"
                                                    name="student_password_confirm" id="student_password_confirm"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" id="corporate_submit_button"
                                            class="btn full-width btn-md theme-bg text-white">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="rcs_log_125">
                                    {{-- <span>Or SignUp with Social Info</span> --}}
                                </div>
                            </form>
                        @else
                            <form class="crs_log__caption" id="forget_form">
                                <div class="rcs_log_124">
                                    <div class="row py-3">
                                        <div class="col">
                                            <h4 class="theme-cl">Forget Password</h4>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" role="alert">
                                      Your reset link is expired, please get reset link & code again.
                                    </div>
                                    <div class="form-group row mb-0">
                                        {{-- <div class="col-md-6 col-12 mt-2"> --}}
                                        <div class="form-group smalls">
                                            <label>Email *</label>
                                            <input type="email" class="form-control" name="forget_email"
                                                id="student_forget_email" required />
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" id="corporate_submit_button"
                                            class="btn full-width btn-md theme-bg text-white">
                                            Request
                                        </button>
                                    </div>
                                </div>
                                <div class="rcs_log_125">
                                    {{-- <span>Or SignUp with Social Info</span> --}}
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    @if ($data['typeOfRequest'] == 'reset')
        <script>
            var studentEmail = '{{ $data['student']['email'] }}';
            var verifyCode = parseInt('{{ $data['reset']['code'] }}');
            // console.log(verifyCode)
        </script>
    @endif
    <script>
        $('#forget_form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'student_forget');
            console.log(Array.from(formData));

            $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function(response, textStatus) {
                console.log(response);
                
                if (response == '"NA"') {
                    showAlert('Student not found on this email. Please check your email.', 'Info', 'info');
                } else if (response == '"true"') {
                    showAlert('Please check your email for reset your password.').then((response) => {
                        window.location.href = '/';
                    });
                } else {
                    showAlert('Server error, please try again later.', 'Error', 'error');
                }
                console.log(textStatus);
            }).fail(function(error, textStatus) {
                showAlert('Server error, please try again later.', 'Error', 'error');
                console.log(error);
                console.log(textStatus);
            })
        });
        $('#reset_form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'student_reset_form');
            console.log(Array.from(formData));

            if ($('#student_email').val() != studentEmail || $('#student_code').val() != verifyCode) {
                showAlert('Email or Reset Code not matched.', 'Un-Matched', 'error');
                return;
            }
            if ($('#student_password').val() != $('#student_password_confirm').val()) {
                showAlert('Password and confirm password not matched.', 'Password', 'error');
                return;
            }

            $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function(response, textStatus) {
                console.log(response);
                if (response == '"NA"') {
                    showAlert('Email and code not matched, please check again or get reset code again.',
                        'Info', 'info');
                } else if (response == '"true"') {
                    showAlert('You are succesfully reset your password, please login.').then((response) => {
                        loginBsModal.show();
                    });
                } else {
                    showAlert('Server error, please try again later.', 'Error', 'error');
                }
                console.log(textStatus);
            }).fail(function(error, textStatus) {
                showAlert('Server error, please try again later.', 'Error', 'error');
                console.log(error);
                console.log(textStatus);
            })
        });
    </script>
@endsection
