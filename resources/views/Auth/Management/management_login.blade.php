@extends('Layouts.blackauth')

@section('form')
    <div class="card">
        <div class="card-header">
            <h3>Management Login</h3>
            <div class="d-flex justify-content-end social_icon">
                <img src="{{asset('logos/logo-white-square.png')}}">
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="" id="loginForm">
                @csrf
                @error('email')
                    <p class="text-danger"><small>{{ $message }} </small></p>
                @enderror
                @error('resetSuccess')
                    <p class="text-success"><b>{{ $message }} </b></p>
                @enderror
                <input hidden style="display: none;" name="form_name" value="login_form">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input name="username" class="form-control" id="floatingInput" value="{{ old('username') }}"
                    placeholder="Email" required>

                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePasswordManagement()" style="cursor: pointer; background-color: #FFC312; color: black; border: 0;">
                            <!-- Eye Icon (Show) -->
                            <svg id="eyeIconMgmt" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                            <!-- Eye Slash Icon (Hide) - Initially Hidden -->
                            <svg id="eyeSlashIconMgmt" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                <path d="M11.297 5.31 9.12 7.483a.5.5 0 0 1-.71.052.5.5 0 0 1-.048-.706l2.147-2.146a5 5 0 0 0-.911-.305 2.49 2.49 0 0 0-.519-.127 2.48 2.48 0 0 0 .528.12 2.49 2.49 0 0 0 2.653 1.12c.07.01.138.02.206.035zm-7.151 9.47 1.894-1.893A.5.5 0 0 1 5.99 12.396a.5.5 0 0 1 .05-.705l-1.9-1.9a2.49 2.49 0 0 1 .53-.12 2.48 2.48 0 0 1-.527-.12 2.48 2.48 0 0 1-2.65-1.12.5.5 0 0 1 .632-.772 1.49 1.49 0 0 0 .565.65c.37.243.837.388 1.418.388a1.49 1.49 0 0 0 1.05-.335L2.3 2.3 1 3.6 15.146 17.747 13.854 19.04 11.297 16.488 4.146 14.78z"/>
                                <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457a13.134 13.134 0 0 1 1.172-1.63L3.197 7.7a14.12 14.12 0 0 0-1.838 2.378C.12 11.332 1.88 12.5 4 12.5c2.12 0 3.879-1.168 5.168-2.457a13.134 13.134 0 0 0 1.63-1.172l-1.428-1.428a12.13 12.13 0 0 1-1.077 1.257z"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="row align-items-center remember">
                    <input type="checkbox">Remember Me
                </div>
                <div class="form-group">
                    <button type="submit" class="btn float-right login_btn">Login</button>
                </div>
            </form>
            <form method="POST" action="" id="forgetForm">
                @csrf
                @error('franchiseError')
                    <p class="text-danger"><small>{!!$message!!} </small></p>
                @enderror
                @error('franchiseSuccess')
                    <p class="text-danger"><small>{!!$message!!} </small></p>
                @enderror
                <input hidden style="display: none;" name="form_name" value="forget_password">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="Email" required>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn float-right login_btn">Request</button>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center links">
                Don't have an account?<a href="{{ route('contributor') }}">Sign Up</a>
            </div>
            <div class="text-center links" id="forgetLink" onclick="showForget()">
                Problem signing in? <button class="btn btn-link">Reset password</but>
           </div>
           <div class="text-center links" id="loginLink" onclick="hideForget()">
                <button class="btn btn-link">Back to login.</button>
           </div>
        </div>
    </div>
@endsection

<script>
    function togglePasswordManagement() {
        var passwordInput = document.getElementById('floatingPassword');
        var eyeIcon = document.getElementById('eyeIconMgmt');
        var eyeSlashIcon = document.getElementById('eyeSlashIconMgmt');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIcon.style.display = 'block';
            eyeSlashIcon.style.display = 'none';
        }
    }
</script>
