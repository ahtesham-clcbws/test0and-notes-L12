@extends('Layouts.superadminauth')

@section('form')
    <div class="Login Box">
        <div class="Box__Header panel_logo"></div>
        <form method="POST" action="" id="otpForm" class="Box__Form">
            @csrf
            @error('franchiseError')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            @error('franchiseSuccess')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            <input hidden style="display: none;" name="form_name" value="otp_verify">
            <label for="otpcode" class="InputLabel">
                Username
            </label>
            <div class="Input">
                <input type="number" name="otpcode" class="Input__Text" placeholder="OTP" required>
            </div>
            <button type="submit" class="Button">
                <span name="fade"><span>Verify</span></span>
            </button>
            <div class="LanguageSelector">
                <div class="Select" onclick="showForget()">
                    <div class="Title">
                        Back to login
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        function togglePassword() {
            var password = document.getElementById('password');
            if (password.type == 'password') {
                password.type = 'text'
            } else {
                password.type = 'password'
            }
        }
    </script>
@endsection
