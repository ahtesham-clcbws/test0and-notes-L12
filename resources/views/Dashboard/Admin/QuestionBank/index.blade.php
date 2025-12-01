@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table align-middle table-bordered" id="questionstable">
                        <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Type</th>
                                <th scope="col">Education</th>
                                <th scope="col">Class<br>Group<br>Exam</th>
                                <th scope="col">Board<br>Agency<br>State</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Part</th>
                                <th scope="col">Lesson<br>Chapter</th>
                                <th scope="col">Creator</th>
                                <th scope="col">Checker</th>
                                <th scope="col">Created</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Status</th>
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
    <script type="text/javascript" src="{{ asset('js/adminquestionbank.js') }}"></script>
@endsection
