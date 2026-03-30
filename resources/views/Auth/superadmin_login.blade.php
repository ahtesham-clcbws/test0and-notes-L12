@extends('Layouts.superadminauth')

@section('form')
    <style>
        #otpForm,
        #forgetForm,
        #loginStep2 {
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
    </style>

    <div class="Login Box">
        <div class="Box__Header panel_logo"></div>

        {{-- Step 1: Email --}}
        <form method="POST" action="" id="loginStep1" class="Box__Form">
            @csrf
            <h4 class="form-title">Admin Access</h4>
            <div id="step1Error" class="text-danger mb-3" style="display:none;"></div>

            <input hidden style="display: none;" name="form_name" value="get_otp">
            <label for="admin_email" class="InputLabel">Email Address</label>
            <div class="Input mb-4">
                <input type="email" id="admin_email" name="email" class="Input__Text" value="{{ old('email') }}"
                    placeholder="Enter your administrative email" required>
            </div>

            <button type="submit" id="btnGetOtp" class="btn-get-otp mb-3">
                <span>Get Login OTP</span>
            </button>
        </form>

        {{-- Step 2: OTP Verification --}}
        <form method="POST" action="" id="loginStep2" class="Box__Form">
            @csrf
            <h4 class="form-title">Verify Your Identity</h4>
            <div id="step2Error" class="text-danger mb-3" style="display:none;"></div>
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
                <a href="javascript:void(0)" onclick="backToStep1()" class="small text-decoration-none">Back to start</a>
            </div>
        </form>

        {{-- Legacy Forms Hidden --}}
        <form id="forgetForm" style="display:none;"></form>
        <form id="otpForm" style="display:none;"></form>
    </div>
@endsection

@section('javascript')
    <script>
        function backToStep1() {
            $('#loginStep2').hide();
            $('#loginStep1').fadeIn();
            $('#step1Error').hide();
        }

        $('#loginStep1').submit(function(e) {
            e.preventDefault();
            const btn = $('#btnGetOtp');
            const errorDiv = $('#step1Error');
            const email = $('#admin_email').val();

            btn.prop('disabled', true).html('<span>Sending...</span>');
            errorDiv.hide();

            $.ajax({
                url: '{{ route('administrator.login') }}',
                type: 'POST',
                data: $(this).serialize()
            }).done(function(data) {
                const res = JSON.parse(data);
                if (res.success) {
                    $('#verify_email').val(email);
                    $('#displayEmail').text(email);
                    $('#loginStep1').hide();
                    $('#loginStep2').fadeIn();
                } else {
                    errorDiv.text(res.message).fadeIn();
                }
            }).fail(function() {
                errorDiv.text('Request failed. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Get Login OTP</span>');
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
            }).done(function(data) {
                const res = JSON.parse(data);
                if (res.success) {
                    window.location.href = '{{ route('administrator.dashboard') }}';
                } else {
                    errorDiv.text(res.message).fadeIn();
                }
            }).fail(function() {
                errorDiv.text('Verification failed. Please try again.').fadeIn();
            }).always(function() {
                btn.prop('disabled', false).html('<span>Verify & Login</span>');
            });
        });
    </script>
@endsection
