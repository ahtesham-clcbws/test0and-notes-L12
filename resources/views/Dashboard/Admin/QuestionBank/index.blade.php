@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    @livewire('admin.questions.question-table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/adminquestionbank.js') }}"></script>
@endsection
