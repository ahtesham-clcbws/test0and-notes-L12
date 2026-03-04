@extends('Layouts.admin')

@section('main')
    @livewire('admin.tests.test-section-manager', ['testId' => $test_id])
@endsection
