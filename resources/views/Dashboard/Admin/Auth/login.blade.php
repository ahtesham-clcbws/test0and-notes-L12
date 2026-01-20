@extends('Layouts.adminauth')

@section('form')
    <style>
        #forgetForm {
            display: none;
        }

    </style>
    <form method="POST" action="" id="loginForm">
        @csrf
        <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        @error('email')
            <p class="text-danger"><small>{{ $message }} </small></p>
        @enderror
        @error('resetSuccess')
            <p class="text-success"><b>{{ $message }} </b></p>
        @enderror

        <input hidden style="display: none;" name="isAdminAllowed" value="null">
        <input hidden style="display: none;" name="form_name" value="login_form">

        <div class="form-floating mb-2">
            @if (Request::segment(1) == 'administrator')
                <input type="email" name="username" class="form-control" id="floatingInput" value="{{ old('username') }}"
                    placeholder="Email" required>
                <label for="floatingInput">Email</label>
            @endif
            @if (Request::segment(1) == 'franchise')
                <input type="text" name="username" class="form-control" id="floatingInput" value="{{ old('username') }}"
                    placeholder="Email / Mobile" required>
                <label for="floatingInput">Email / Mobile</label>
            @endif
            @if (Request::segment(1) == 'student')
                <input type="text" name="username" class="form-control" id="floatingInput" value="{{ old('username') }}"
                    placeholder="Email / Username / Mobile" required>
                <label for="floatingInput">Email / Username / Mobile</label>
            @endif
            {{-- <input type="text" name="username" class="form-control" id="floatingInput" value="{{ old('username') }}"
                placeholder="Email / Username / Mobile">
            <label for="floatingInput">Email / Username / Mobile</label> --}}
        </div>
        <div class="form-floating position-relative">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" style="padding-right: 40px;">
            <label for="floatingPassword">Password</label>
            <span class="position-absolute top-50 translate-middle-y" style="right: 15px; cursor: pointer; z-index: 10;" onclick="togglePassword()">
                <!-- Eye Icon (Show) -->
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
                <!-- Eye Slash Icon (Hide) - Initially Hidden -->
                <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                    <path d="M11.297 5.31 9.12 7.483a.5.5 0 0 1-.71.052.5.5 0 0 1-.048-.706l2.147-2.146a5 5 0 0 0-.911-.305 2.49 2.49 0 0 0-.519-.127 2.48 2.48 0 0 0 .528.12 2.49 2.49 0 0 0 2.653 1.12c.07.01.138.02.206.035zm-7.151 9.47 1.894-1.893A.5.5 0 0 1 5.99 12.396a.5.5 0 0 1 .05-.705l-1.9-1.9a2.49 2.49 0 0 1 .53-.12 2.48 2.48 0 0 1-.527-.12 2.48 2.48 0 0 1-2.65-1.12.5.5 0 0 1 .632-.772 1.49 1.49 0 0 0 .565.65c.37.243.837.388 1.418.388a1.49 1.49 0 0 0 1.05-.335L2.3 2.3 1 3.6 15.146 17.747 13.854 19.04 11.297 16.488 4.146 14.78z"/>
                    <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457a13.134 13.134 0 0 1 1.172-1.63L3.197 7.7a14.12 14.12 0 0 0-1.838 2.378C.12 11.332 1.88 12.5 4 12.5c2.12 0 3.879-1.168 5.168-2.457a13.134 13.134 0 0 0 1.63-1.172l-1.428-1.428a12.13 12.13 0 0 1-1.077 1.257z"/>
                </svg>
            </span>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <div class="checkbox text-end mt-3 mb-5">
            Problem signin? <a href="#" onclick="showForget()">Forget Password</a>
        </div>
        <p class="mb-3 text-muted">&copy; 2017–2021</p>
    </form>
    <form method="POST" action="" id="forgetForm">
        @csrf
        @error('franchiseError')
            <p class="text-danger"><small>{{ $message }} </small></p>
        @enderror
        @error('franchiseSuccess')
            <p class="text-danger"><small>{{ $message }} </small></p>
        @enderror
        <input hidden style="display: none;" name="form_name" value="forget_password">
        <div class="form-floating mb-2">
            @if (Request::segment(1) == 'administrator')
                <input type="email" name="email" class="form-control" id="floatingInput2" value="{{ old('email') }}"
                    placeholder="Email" required>
                <label for="floatingInput2">Email</label>
            @endif
            @if (Request::segment(1) == 'franchise')
                <input type="email" name="email" class="form-control" id="floatingInput2" value="{{ old('email') }}"
                    placeholder="Email" required>
                <label for="floatingInput2">Email</label>
            @endif
            @if (Request::segment(1) == 'student')
                <input type="number" maxlength="10" minlength="10" name="mobile" class="form-control" id="floatingInput2"
                    value="{{ old('mobile') }}" placeholder="Mobile" required>
                <label for="floatingInput2">Mobile</label>
            @endif
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Request</button>
        <div class="checkbox text-end mt-3 mb-5">
            <a href="#" onclick="showForget()">Back to login</a>
        </div>
        <p class="mb-3 text-muted">&copy; 2017–2021</p>
    </form>
@endsection

@section('scripts')
<script>
    function togglePassword() {
        var passwordInput = document.getElementById('floatingPassword');
        var eyeIcon = document.getElementById('eyeIcon');
        var eyeSlashIcon = document.getElementById('eyeSlashIcon');

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
@endsection
