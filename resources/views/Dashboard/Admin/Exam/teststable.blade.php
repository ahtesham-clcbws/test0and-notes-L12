@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <livewire:admin.tests.test-table />
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('frontend/sweetalert2/sweetalert.min.js') }}"></script>
@endsection
