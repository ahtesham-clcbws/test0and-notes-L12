@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="student_list_table">
                        <thead>
                            <tr>
                                <th scope="col">Student Name</th>
                                <th scope="col">Test Name</th>
                                <th scope="col">Attempt date</th>
                                <th scope="col">Created Date</th>
                                <!-- <th scope="col">Sections</th>
                                <th scope="col">Questions</th>
                                <th scope="col">Status</th>
                                <th class="text-end">Actions</th> -->
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
    <script type="text/javascript" src="{{ asset('js/franchise/studentlisttable.js') }}"></script>
@endsection
