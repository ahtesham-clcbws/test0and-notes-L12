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
                    <button class="btn btn-dark togglePassword" type="button">
                        <i class="fas fa-eye"></i>
                    </button>
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
            {{-- <div class="d-flex justify-content-center links">
                Don't have an account?<a href="#">Sign Up</a>
            </div> --}}
            <div class="text-center links" id="forgetLink" onclick="showForget()">
                Problem signing in? <button class="btn btn-link">Reset password</but>
           </div>
           <div class="text-center links" id="loginLink" onclick="hideForget()">
                <button class="btn btn-link">Back to login.</button>
           </div>
        </div>
    </div>
@endsection
