@extends('Layouts.adminauth')

@section('form')
    <style>
        .form-signin input[type="password"],
        .form-signin input[type="text"] {
            margin-bottom: 12px;
            border-radius: 0.375rem;
        }
        .password-toggle-icon {
            right: 15px;
            cursor: pointer;
            z-index: 10;
            color: #6c757d;
            transition: color 0.2s ease;
        }
        .password-toggle-icon:hover {
            color: #212529;
        }
    </style>

    <form method="POST" action="">
        @csrf
        @error('error')
            <p class="text-danger"><b>{{ $message }} </b></p>
        @enderror

        @if ($data['success'])
            <h1 class="h3 mb-3 fw-normal">Set New Password</h1>
            
            <div class="form-floating position-relative">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" style="padding-right: 45px;" required minlength="6">
                <label for="password">Password</label>
                <span class="position-absolute top-50 translate-middle-y password-toggle-icon" onclick="togglePasswordVisibility('password', 'eyeResetPass', 'eyeSlashResetPass')">
                    <svg id="eyeResetPass" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    <svg id="eyeSlashResetPass" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 5.31 9.12 7.483a.5.5 0 0 1-.71.052.5.5 0 0 1-.048-.706l2.147-2.146a5 5 0 0 0-.911-.305 2.49 2.49 0 0 0-.519-.127 2.48 2.48 0 0 0 .528.12 2.49 2.49 0 0 0 2.653 1.12c.07.01.138.02.206.035zm-7.151 9.47 1.894-1.893A.5.5 0 0 1 5.99 12.396a.5.5 0 0 1 .05-.705l-1.9-1.9a2.49 2.49 0 0 1 .53-.12 2.48 2.48 0 0 1-.527-.12 2.48 2.48 0 0 1-2.65-1.12.5.5 0 0 1 .632-.772 1.49 1.49 0 0 0 .565.65c.37.243.837.388 1.418.388a1.49 1.49 0 0 0 1.05-.335L2.3 2.3 1 3.6 15.146 17.747 13.854 19.04 11.297 16.488 4.146 14.78z"/>
                        <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457a13.134 13.134 0 0 1 1.172-1.63L3.197 7.7a14.12 14.12 0 0 0-1.838 2.378C.12 11.332 1.88 12.5 4 12.5c2.12 0 3.879-1.168 5.168-2.457a13.134 13.134 0 0 0 1.63-1.172l-1.428-1.428a12.13 12.13 0 0 1-1.077 1.257z"/>
                    </svg>
                </span>
            </div>

            <div class="form-floating position-relative">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                    placeholder="Confirm Password" style="padding-right: 45px;" required minlength="6">
                <label for="confirm_password">Confirm Password</label>
                <span class="position-absolute top-50 translate-middle-y password-toggle-icon" onclick="togglePasswordVisibility('confirm_password', 'eyeResetConfirm', 'eyeSlashResetConfirm')">
                    <svg id="eyeResetConfirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    <svg id="eyeSlashResetConfirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                        <path d="M11.297 5.31 9.12 7.483a.5.5 0 0 1-.71.052.5.5 0 0 1-.048-.706l2.147-2.146a5 5 0 0 0-.911-.305 2.49 2.49 0 0 0-.519-.127 2.48 2.48 0 0 0 .528.12 2.49 2.49 0 0 0 2.653 1.12c.07.01.138.02.206.035zm-7.151 9.47 1.894-1.893A.5.5 0 0 1 5.99 12.396a.5.5 0 0 1 .05-.705l-1.9-1.9a2.49 2.49 0 0 1 .53-.12 2.48 2.48 0 0 1-.527-.12 2.48 2.48 0 0 1-2.65-1.12.5.5 0 0 1 .632-.772 1.49 1.49 0 0 0 .565.65c.37.243.837.388 1.418.388a1.49 1.49 0 0 0 1.05-.335L2.3 2.3 1 3.6 15.146 17.747 13.854 19.04 11.297 16.488 4.146 14.78z"/>
                        <path d="M8 12.5c-2.12 0-3.879-1.168-5.168-2.457a13.134 13.134 0 0 1 1.172-1.63L3.197 7.7a14.12 14.12 0 0 0-1.838 2.378C.12 11.332 1.88 12.5 4 12.5c2.12 0 3.879-1.168 5.168-2.457a13.134 13.134 0 0 0 1.63-1.172l-1.428-1.428a12.13 12.13 0 0 1-1.077 1.257z"/>
                    </svg>
                </span>
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Save Password</button>
        @else
            <p class="text-danger"><b>Reset code invalid or expired. Please request a new link.</b></p><br>

            @if (Request::segment(1) == 'administrator')
                <div class="checkbox text-end">
                    <a href="{{ route('administrator.login') }}">Return to admin login</a>
                </div>
            @else
                <div class="checkbox text-end">
                    <a href="{{ route('administrator.login') }}">Click to get reset code again.</a>
                </div>
            @endif
        @endif
    </form>
@endsection

@section('scripts')
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
    </script>
@endsection
