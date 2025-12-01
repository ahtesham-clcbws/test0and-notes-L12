@extends('Layouts.superadminauth')

@section('form')
    <style>
        #otpForm,
        #forgetForm {
            display: none;
        }

        h1 {
            max-width: 500px;
            color: grey;
        }
    </style>

    <div class="Login Box">
        <div class="Box__Header panel_logo"></div>
        <form method="POST" action="" id="loginForm" class="Box__Form">
            @csrf
            @error('email')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            @error('resetSuccess')
                <p class="text-success"><b>{{ $message }} </b></p>
            @enderror
            <input hidden style="display: none;" name="form_name" value="login_form">
            <label for="username" class="InputLabel">
                Username
            </label>
            <div class="Input">
                <input type="email" id="admin_email" name="username" class="Input__Text" value="{{ old('username') }}"
                    placeholder="Email" required>
            </div>
            <label for="password" class="InputLabel">
                Password
            </label>
            <div class="Input InputPassword">
                <input type="password" id="password" name="password" placeholder="Please enter your password"
                    autocomplete="current-password" class="InputPassword__Input" required>
                <a class="Input__Icon hoverable" onclick="togglePassword()">
                    <svg version="1.1" viewBox="0 0 48 48" class="svg-icon svg-fill" style="width: 20px;">
                        <path fill="#8db2be" stroke="none" pid="0"
                            d="M24 8C11.056 8 0 24 0 24s11.048 16 24 16c12.944 0 24-16 24-16S36.952 8 24 8zm0 28c-7.469 0-15.137-7.324-19-12 3.853-4.678 11.502-12 19-12 7.469 0 15.137 7.324 19 12-3.853 4.678-11.502 12-19 12zm0-20a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 12c-2.451 0-4-1.549-4-4s1.549-4 4-4 4 1.549 4 4-1.549 4-4 4z">
                        </path>
                    </svg>
                </a>
            </div>
            <button type="submit" class="Button">
                <span name="fade"><span>Sign in</span></span>
            </button>
            <div class="LanguageSelector">
                <label class="Label"><span>Problem signin?</span></label>
                <div class="Select" onclick="showForget()">
                    <div class="Title">
                        Forget Password
                    </div>
                </div>
            </div>
        </form>
        <form method="POST" action="" id="forgetForm" class="Box__Form">
            @csrf
            @error('franchiseError')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            @error('franchiseSuccess')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            <input hidden style="display: none;" name="form_name" value="forget_password">
            <label for="username" class="InputLabel">
                Username
            </label>
            <div class="Input">
                <input type="email" name="email" class="Input__Text" value="{{ old('email') }}" placeholder="Email"
                    required>
            </div>
            <button type="submit" class="Button">
                <span name="fade"><span>Request</span></span>
            </button>
            <div class="LanguageSelector">
                <div class="Select" onclick="showForget()">
                    <div class="Title">
                        Back to login
                    </div>
                </div>
            </div>
        </form>
        <form method="POST" action="" id="otpForm" class="Box__Form">
            @csrf
            @error('franchiseError')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            @error('franchiseSuccess')
                <p class="text-danger"><small>{{ $message }} </small></p>
            @enderror
            <h1>
                Please Provide 6 digit OTP, We have send to your Registered Mobile Number.
            </h1>
            <input hidden style="display: none;" name="form_name" value="otp_verify">
            {{-- <label for="otpcode" class="InputLabel">
                OTP
            </label> --}}
            <div class="Input">
                <input type="number" maxlength="6" minlength="6" name="otpcode" id="otp_code" class="Input__Text"
                    placeholder="OTP" required>
            </div>
            <button type="submit" class="Button">
                <span name="fade"><span>Submit</span></span>
            </button>
            <div class="LanguageSelector">
                <div class="Select" onclick="showForget()">
                    <div class="Title">
                        Back to login
                    </div>
                </div>
            </div>
        </form>
        {{-- Problem signin? <a href="#" onclick="showForget()">Forget Password</a>
        <a href="#" onclick="showForget()">Back to login</a> --}}
    </div>
@endsection

@section('javascript')
    <script>
        function togglePassword() {
            var password = document.getElementById('password');
            if (password.type == 'password') {
                password.type = 'text'
            } else {
                password.type = 'password'
            }
        }
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);
            console.log(Array.from(formData));

            $.ajax({
                url: '',
                data: formData,
                type: 'post',
                contentType: false,
                processData: false
            }).done(function(data, textStatus) {
                console.log(textStatus);
                const response = JSON.parse(data);
                console.log('login response: ',response);
                if (response.success) {
                    return window.location.href = '{{ route("administrator.dashboard") }}';
                    if (response.type == 'already') {
                        alert(
                            'You already request an OTP in last 10 minutes. please wait for another attempt.'
                        );
                    } else {
                        localStorage.setItem('admin_otp', response.otp);
                        // show otp screen here
                        $('#otpForm').show();
                        $('#loginForm').hide();
                    }
                }
            }).fail(function(data, textStatus) {
                console.log(data)
                console.log(textStatus)
            });
        })
        $('#otpForm').submit(async function(event) {
            event.preventDefault();
            var savedOtp = await parseInt(localStorage.getItem('admin_otp'));
            console.log("OTP:", savedOtp);
            var inputOtp = parseInt($('#otp_code').val());
            if (savedOtp == inputOtp) {
                var admin_email = $('#admin_email').val();
                var admin_password = $('#password').val();
                var formData = new FormData();
                formData.append('email', admin_email);
                formData.append('password', admin_password);
                formData.append('form_name', 'admin_login');
                formData.append('_token', '{{ csrf_token() }}');

                console.log(Array.from(formData))

                $.ajax({
                    url: '/',
                    data: formData,
                    type: 'post',
                    contentType: false,
                    processData: false
                }).done(function(data, textStatus) {
                    console.log(data);
                    console.log(textStatus);
                    if (data =='true') {
                        window.location.href = "{{ route('administrator.dashboard') }}";
                    } else {
                        alert('OTP unable to match or error happens, please contact tech team.');
                    }
                }).fail(function(data, textStatus) {
                    console.log(data)
                    console.log(textStatus)
                });
            } else {
                alert('OTP un-matched.');
            }
        })
    </script>
@endsection
