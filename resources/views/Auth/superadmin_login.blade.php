@extends('Layouts.superadminauth')

@section('form')
    <style>
        #loginStep2,
        #forgetForm {
            display: none;
        }

        h1 {
            max-width: 500px;
            color: grey;
        }

        .login-card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-get-otp {
            background: #0d6efd;
            color: #fff;
            padding: 0.8rem;
            border-radius: 0.5rem;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }

        .btn-get-otp:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
        }

        .auth-link {
            font-size: 13px;
            color: #0d6efd;
            text-decoration: none;
            cursor: pointer;
        }

        .auth-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="Login Box">
        <div class="Box__Header panel_logo"></div>

        @if (session('loginSuccess'))
            <div class="alert alert-success text-center mb-3 p-2" style="background:#d1e7dd;color:#0f5132;border-radius:6px;font-size:14px;">
                {{ session('loginSuccess') }}
            </div>
        @endif

        {{-- Step 1: Email & Password --}}
        <form method="POST" action="" id="loginStep1" class="Box__Form">
            @csrf
            <h4 class="form-title">Admin Access</h4>
            <div id="step1Error" class="text-danger mb-3" style="display:none;font-size:13px;text-align:center;"></div>

            <input hidden style="display: none;" name="form_name" value="get_otp">
            
            <label for="admin_email" class="InputLabel">Email Address</label>
            <div class="Input mb-3">
                <input type="email" id="admin_email" name="email" class="Input__Text" value="{{ old('email') }}"
                    placeholder="Enter administrative email" required autocomplete="username">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="admin_password" class="InputLabel">Password</label>
            </div>
            <div class="Input mb-3" style="position: relative;">
                <input type="password" id="admin_password" name="password" class="Input__Text"
                    placeholder="Enter password" required autocomplete="current-password" style="padding-right: 50px;">
                <span class="Input__Icon hoverable" style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 5;" onclick="togglePasswordVisibility('admin_password', 'eyeAdmin', 'eyeSlashAdmin')">
                    <svg id="eyeAdmin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#697388" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    <svg id="eyeSlashAdmin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#697388" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 5.31 9.12 7.483a.5.5 0 0 1-.71.052.5.5 0 0 1-.048-.706l2.147-2.146a5 5 0 0 0-.911-.305 2.49 2.49 0 0 0-.519-.127 2.48 2.48 0 0 0 .528.12 2.49 2.49 0 0 0 2.653 1.12c.07.01.138.02.206.035zm-7.151 9.47 1.894-1.893A.5.5 0 0 1 5.99 12.396a.5.5 0 0 1 .05-.705l-1.9-1.9a2.49 2.49 0 0 1 .53-.12 2.48 2.48 0 0 1-.527-.12 2.48 2.48 0 0 1-2.65-1.12.5.5 0 0 1 .632-.772 1.49 1.49 0 0 0 .565.65c.37.243.837.388 1.418.388a1.49 1.49 0 0 0 1.05-.335L2.3 2.3 1 3.6 15.146 17.747 13.854 19.04 11.297 16.488 4.146 14.78z"/>
                        <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457a13.134 13.134 0 0 1 1.172-1.63L3.197 7.7a14.12 14.12 0 0 0-1.838 2.378C.12 11.332 1.88 12.5 4 12.5c2.12 0 3.879-1.168 5.168-2.457a13.134 13.134 0 0 0 1.63-1.172l-1.428-1.428a12.13 12.13 0 0 1-1.077 1.257z"/>
                    </svg>
                </span>
            </div>

            <div class="text-end mb-3">
                <a href="javascript:void(0)" onclick="showForgotForm()" class="auth-link">Forgot password?</a>
            </div>

            <button type="submit" id="btnGetOtp" class="btn-get-otp mb-3">
                <span>Continue to OTP Verification</span>
            </button>
        </form>

        {{-- Step 2: OTP Verification --}}
        <form method="POST" action="" id="loginStep2" class="Box__Form">
            @csrf
            <h4 class="form-title">Verify Your Identity</h4>
            <div id="step2Error" class="text-danger mb-3" style="display:none;font-size:13px;text-align:center;"></div>
            <p class="text-muted small mb-4 text-center">We've sent a 6-digit verification code to <b id="displayEmail"></b></p>

            <input hidden style="display: none;" name="form_name" value="login_otp">
            <input type="hidden" name="email" id="verify_email">

            <div class="Input mb-4">
                <input type="number" id="login_otp_code" name="otp" class="Input__Text"
                    placeholder="Enter 6-digit OTP" required maxlength="6" minlength="6">
            </div>

            <button type="submit" id="btnLogin" class="btn-get-otp mb-3">
                <span>Verify & Login</span>
            </button>

            <div class="text-center">
                <a href="javascript:void(0)" onclick="backToStep1()" class="auth-link">Back to credentials</a>
            </div>
        </form>

        {{-- Forgot Password Form --}}
        <form method="POST" action="" id="forgetForm" class="Box__Form">
            @csrf
            <h4 class="form-title">Reset Admin Password</h4>
            <div id="forgetStatus" class="mb-3" style="display:none;font-size:13px;text-align:center;"></div>

            <input hidden style="display: none;" name="form_name" value="forget_password">
            
            <label for="forget_email" class="InputLabel">Email Address</label>
            <div class="Input mb-4">
                <input type="email" id="forget_email" name="email" class="Input__Text"
                    placeholder="Enter registered email" required>
            </div>

            <button type="submit" id="btnForgetPassword" class="btn-get-otp mb-3">
                <span>Send Password Reset Link</span>
            </button>

            <div class="text-center">
                <a href="javascript:void(0)" onclick="backToStep1()" class="auth-link">Back to Login</a>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        function togglePasswordVisibility(inputId, eyeId, eyeSlashId) {
            var input = document.getElementById(inputId);
            var eye = document.getElementById(eyeId);
            var eyeSlash = document.getElementById(eyeSlashId);
            if (!input || !eye || !eyeSlash) return;

            if (input.type === 'password') {
                input.type = 'text';
                eye.style.display = 'none';
                eyeSlash.style.display = 'inline-block';
            } else {
                input.type = 'password';
                eye.style.display = 'inline-block';
                eyeSlash.style.display = 'none';
            }
        }

        function updateCsrf(res, xhr) {
            var token = null;
            if (res && res.csrf_token) {
                token = res.csrf_token;
            } else if (xhr && typeof xhr.getResponseHeader === 'function' && xhr.getResponseHeader('X-CSRF-TOKEN')) {
                token = xhr.getResponseHeader('X-CSRF-TOKEN');
            }
            if (token) {
                $('input[name="_token"]').val(token);
                $('meta[name="csrf-token"]').attr('content', token);
                if (window.jQuery && $.ajaxSetup) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    });
                }
            }
        }

        function parseResponse(data, xhr) {
            if (data && typeof data === 'object') return data;
            if (xhr && xhr.responseJSON) return xhr.responseJSON;
            if (typeof data === 'string') {
                try { return JSON.parse(data); } catch(e) {}
            }
            if (xhr && xhr.responseText) {
                try { return JSON.parse(xhr.responseText); } catch(e) {}
            }
            return null;
        }

        function backToStep1() {
            $('#loginStep2').hide();
            $('#forgetForm').hide();
            $('#loginStep1').fadeIn();
            $('#step1Error').hide();
        }

        function showForgotForm() {
            $('#loginStep1').hide();
            $('#loginStep2').hide();
            $('#forgetForm').fadeIn();
            $('#forgetStatus').hide();
            const currentEmail = $('#admin_email').val();
            if (currentEmail) {
                $('#forget_email').val(currentEmail);
            }
        }

        $('#loginStep1').submit(function(e) {
            e.preventDefault();
            const btn = $('#btnGetOtp');
            const errorDiv = $('#step1Error');
            const email = $('#admin_email').val();

            btn.prop('disabled', true).html('<span>Authenticating...</span>');
            errorDiv.hide();

            $.ajax({
                url: '{{ route('administrator.login') }}',
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                updateCsrf(res, xhr);

                if (res && res.redirect) {
                    window.location.href = res.redirect;
                    return;
                }

                if (res && res.success) {
                    $('#verify_email').val(email);
                    $('#displayEmail').text(email);
                    $('#loginStep1').hide();
                    $('#loginStep2').fadeIn();
                } else {
                    errorDiv.text(res && res.message ? res.message : 'Authentication failed.').fadeIn();
                }
            }).fail(function(xhr) {
                updateCsrf(null, xhr);
                if (xhr && xhr.status === 419) {
                    errorDiv.text('Session expired. Reloading page...').fadeIn();
                    setTimeout(function() { window.location.reload(); }, 1000);
                    return;
                }
                const res = parseResponse(null, xhr);
                errorDiv.text(res && res.message ? res.message : 'Request failed. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Continue to OTP Verification</span>');
            });
        });

        $('#loginStep2').submit(function(e) {
            e.preventDefault();
            const btn = $('#btnLogin');
            const errorDiv = $('#step2Error');

            btn.prop('disabled', true).html('<span>Verifying...</span>');
            errorDiv.hide();

            $.ajax({
                url: '{{ route('administrator.login') }}',
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                updateCsrf(res, xhr);

                if (res && res.success) {
                    window.location.href = (res.redirect || '{{ route('administrator.dashboard') }}');
                } else {
                    errorDiv.text(res && res.message ? res.message : 'Verification failed.').fadeIn();
                }
            }).fail(function(xhr) {
                updateCsrf(null, xhr);
                if (xhr && xhr.status === 419) {
                    errorDiv.text('Session expired. Reloading page...').fadeIn();
                    setTimeout(function() { window.location.reload(); }, 1000);
                    return;
                }
                const res = parseResponse(null, xhr);
                errorDiv.text(res && res.message ? res.message : 'Verification failed. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Verify & Login</span>');
            });
        });

        $('#forgetForm').submit(function(e) {
            e.preventDefault();
            const btn = $('#btnForgetPassword');
            const statusDiv = $('#forgetStatus');

            btn.prop('disabled', true).html('<span>Sending Link...</span>');
            statusDiv.hide();

            $.ajax({
                url: '{{ route('administrator.login') }}',
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                updateCsrf(res, xhr);

                if (res && res.success) {
                    statusDiv.attr('class', 'alert alert-info text-success').text(res.message).fadeIn();
                } else {
                    statusDiv.attr('class', 'alert alert-danger text-danger').text(res && res.message ? res.message : 'Failed to send link.').fadeIn();
                }
            }).fail(function(xhr) {
                updateCsrf(null, xhr);
                if (xhr && xhr.status === 419) {
                    statusDiv.attr('class', 'alert alert-danger text-danger').text('Session expired. Reloading page...').fadeIn();
                    setTimeout(function() { window.location.reload(); }, 1000);
                    return;
                }
                const res = parseResponse(null, xhr);
                statusDiv.attr('class', 'alert alert-danger text-danger').text(res && res.message ? res.message : 'Unable to process request. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Send Password Reset Link</span>');
            });
        });
    </script>
@endsection
