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
            <form id="questionForm" class="card">
                @csrf
                <div class="card-body">
                    <div class="row border-bottom">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="alertx alert-primary">
                                <small><b>Type of Education</b></small>
                                <select class="form-select form-select-sm" onchange="getClassesByEducation(this.value)"
                                    id="education_type_id" name="education_type_id" required>
                                    <option value=""></option>
                                    @foreach ($data['educations'] as $key => $education)
                                        <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
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
