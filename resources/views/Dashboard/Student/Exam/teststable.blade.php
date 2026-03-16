@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <livewire:student.tests.student-test-list 
            :type="$data['type']" 
            :cat="$data['cat'] ?? null" 
            :class_id="$data['class_id'] ?? null" 
            :education_type_id="$data['education_type_id'] ?? null" 
        />
    </div>
@endsection

@section('javascript')
@endsection
