@extends('Layouts.blackauth')

@section('form')
    <div class="card">
        <div class="card-header">
            <h3>Institute Set Password</h3>
            <div class="d-flex justify-content-end social_icon">
                <img src="{{ asset('logos/logo-white-square.png') }}">
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="" id="loginForm">
                @csrf
                @error('error')
                    <p class="text-danger"><b>{{ $message }} </b></p>
                @enderror
                @if ($data['success'])
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                            placeholder="Confirm Password">
                    </div>
                @else
                    <p class="text-light"><b>Code not matched. Please reset again.</b><br><br>
                    <a href="{{ route('franchise.login') }}?password_reset">Reset password again?</a><br>
                    <a href="{{ route('franchise.login') }}">Back to login</a></p>
                @endif
                @if ($data['success'])
                    <div class="form-group">
                        <button type="submit" class="btn float-right login_btn">Update</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
