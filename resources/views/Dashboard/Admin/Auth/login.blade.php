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
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
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
