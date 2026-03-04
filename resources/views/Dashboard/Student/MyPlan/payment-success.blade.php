@extends('Layouts.student')

@section('css')
@endsection
@section('main')
<div class="container">
    <div style="color:green;font-size:90px;text-align:center;">
        <i class="fa fa-check" style="padding:50px;background-color:#f8f8f8;border-radius:200px;"></i>
    </div>
    <div style="text-align: center;padding-bottom: 20px;">
        <h1>Success</h1>
        <p>Your Payment Was Successful. Thank You!</p>
        <a href="{{ route('student.dashboard') }}"id="add-form2" class="btn btn-success btn-xl">Home</a>
    </div>
</div>
@endsection
