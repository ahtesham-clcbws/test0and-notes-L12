@extends('Layouts.student')

@section('css')
@endsection
@section('main')
<div class="container">
    <div style="color: red;font-size: 90px;text-align:center;"> 
      	<i class="fa fa-close" style="padding:50px;background-color:#f8f8f8;border-radius:200px;"></i>
    </div>
    <div style="text-align: center;padding-bottom: 20px;">
		<h1>Failed</h1> 
		<p>Your payment was falied. Try after some time!</p>
		<a href="{{ route('student.login') }}"id="add-form2" class="btn btn-danger btn-xl">Home</a>
    </div>
</div>
@endsection
