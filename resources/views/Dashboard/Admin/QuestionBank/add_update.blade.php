@extends('Layouts.admin')

@section('main')
    <div class="p-0">
        @livewire('admin.questions.question-form', ['questionId' => $data['id'] ?? 0])
    </div>
@endsection
