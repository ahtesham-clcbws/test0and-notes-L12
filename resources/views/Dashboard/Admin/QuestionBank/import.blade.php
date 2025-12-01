@extends('Layouts.admin')

@section('css')
    <style>
        .dashboard-container .alertx {
            position: relative;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            min-height: 49px;
        }
    </style>
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <form action="{{ route('administrator.dashboard_question_import_store') }}" enctype="multipart/form-data"
                method="POST" class="card">
                @csrf
                <div class="card-body">

                    <div class="col-md-12 mcq_answer_panel">
                        <div class="mb-3">
                            <label class="form-label" for="right_answer_{0}">
                                Excel
                            </label>
                            <input class="form-control w-full" type="file" name="question" required>
                        </div>
                        <div class="text-end">

                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/adminaddupdatequestion.js') }}"></script>
@endsection
