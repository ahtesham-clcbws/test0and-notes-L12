@extends('Layouts.franchise')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <livewire:franchise.tests.institute-test-table viewMode="owner" />
    </div>
@endsection

@section('javascript')
@endsection
