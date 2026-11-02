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
            <div class="Input mb-3">
                <input type="password" id="admin_password" name="password" class="Input__Text"
                    placeholder="Enter password" required autocomplete="current-password">
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
                data: $(this).serialize()
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                if (res && res.success) {
                    $('#verify_email').val(email);
                    $('#displayEmail').text(email);
                    $('#loginStep1').hide();
                    $('#loginStep2').fadeIn();
                } else {
                    errorDiv.text(res && res.message ? res.message : 'Authentication failed.').fadeIn();
                }
            }).fail(function(xhr) {
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
                data: $(this).serialize()
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                if (res && res.success) {
                    window.location.href = '{{ route('administrator.dashboard') }}';
                } else {
                    errorDiv.text(res && res.message ? res.message : 'Verification failed.').fadeIn();
                }
            }).fail(function(xhr) {
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
                data: $(this).serialize()
            }).done(function(data, textStatus, xhr) {
                const res = parseResponse(data, xhr);
                if (res && res.success) {
                    statusDiv.attr('class', 'alert alert-info text-success').text(res.message).fadeIn();
                } else {
                    statusDiv.attr('class', 'alert alert-danger text-danger').text(res && res.message ? res.message : 'Failed to send link.').fadeIn();
                }
            }).fail(function(xhr) {
                const res = parseResponse(null, xhr);
                statusDiv.attr('class', 'alert alert-danger text-danger').text(res && res.message ? res.message : 'Unable to process request. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Send Password Reset Link</span>');
            });
        });
    </script>
@endsection
