@extends('Layouts.blackauth')

@section('form')
    <div class="card">
        <div class="card-header">
            <h3>Corporate Set Password</h3>
            <div class="d-flex justify-content-end social_icon">
                <img src="{{ asset('logos/logo-white-square.png') }}">
            </div>
        </div>
        <div class="card-body">
            <form id="loginForm" method="POST" action="">
                @csrf
                @error('error')
                    <p class="text-danger"><b>{{ $message }} </b></p>
                @enderror
                @if ($data['success'])
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                        <div class="input-group-append">
                            <button class="btn btn-dark togglePassword" type="button" style="width: 42px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input class="form-control" id="confirm_password" name="confirm_password" type="password"
                            placeholder="Confirm Password">
                        <div class="input-group-append">
                            <button class="btn btn-dark togglePassword" type="button" style="width: 42px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-light"><b>Code not matched. Please reset again.</b><br><br>
                        <a href="{{ route('franchise.login') }}?password_reset">Reset password again?</a><br>
                        <a href="{{ route('franchise.login') }}">Back to login</a>
                    </p>
                @endif
                @if ($data['success'])
                    <div class="form-group">
                        <button class="btn login_btn float-right" type="submit">Update</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
