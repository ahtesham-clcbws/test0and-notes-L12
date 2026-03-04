@extends('Layouts.adminauth')

@section('form')
    <form method="POST" action="">
        @csrf
        @error('error')
            <p class="text-danger"><b>{{ $message }} </b></p>
        @enderror
        {{-- @error('noerror') --}}
        @if ($data['success'])
            <h1 class="h3 mb-3 fw-normal">Set password</h1>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                    placeholder="Confirm Password">
                <label for="confirm_password">Confirm Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Save</button>
            <p class="mb-3 text-muted">&copy; 2017–2021</p>
        @else
            <p class="text-danger"><b>Code not matched. Please reset again.</b></p><br>

            @if (Request::segment(1) == 'administrator')
                <div class="checkbox text-end">
                    <a href="#">Click to get reset code again.</a>
                </div>
            @endif
            @if (Request::segment(1) == 'franchise')
                <div class="checkbox text-end">
                    <a href="#">Click to get reset code again.</a>
                </div>
            @endif
            @if (Request::segment(1) == 'student')
                <div class="checkbox text-end">
                    <a href="#">Click to get reset code again.</a>
                </div>
            @endif

        @endif
        {{-- @enderror --}}
    </form>
@endsection
