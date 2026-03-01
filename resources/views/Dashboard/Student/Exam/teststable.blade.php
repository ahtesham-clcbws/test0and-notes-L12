@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <livewire:student.tests.student-test-list :type="$data['type']" :cat="$data['cat']" />
    </div>
@endsection

@section('javascript')
@endsection
