@extends('Layouts.Management.manager')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <livewire:franchise.tests.institute-test-table viewMode="manager" />
    </div>
@endsection

@section('javascript')
@endsection
