@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        @error('resultError')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="teststable">
                        <thead>
                            <tr>
                                <th scope="col">Test Name</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">Class Name</th>
                                <!-- <th scope="col">Created By</th> -->
                                <th scope="col">Test Date</th>
                                <!-- <th scope="col">Sections</th> -->
                                <th scope="col">Test Type</th>
                                <!-- <th scope="col">Status</th> -->
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/student/student_attempt_teststable.js') }}"></script>
@endsection
