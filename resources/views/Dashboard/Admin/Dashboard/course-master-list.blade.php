@extends('Layouts.admin')

@section('css')
<style>
    .course-logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .card-header {
        background-color: #19467a;
        color: white;
    }
    .btn-edit {
        background-color: #2e3092;
        color: white;
    }
    .btn-edit:hover {
        color: white;
        background-color: #19467a;
    }
</style>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Course Master List</h4>
                    <a href="{{ route('administrator.course-detail-add') }}" class="btn btn-warning btn-sm">Add New Course</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="courseTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>Course Name</th>
                                    <th>Education Type</th>
                                    <th>Class/Group/Exam Name</th>
                                    <th>Exam Agency/ Board/University</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $index => $course)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($course->course_image)
                                            <img src="{{ asset($course->course_image) }}" alt="Logo" class="course-logo">
                                        @else
                                            <span class="text-muted">No Logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->course_full_name }}</td>
                                    <td>
                                        @php
                                            $eduType = \App\Models\Educationtype::find($course->education_id);
                                        @endphp
                                        {{ $eduType ? $eduType->name : 'N/A' }}
                                    </td>
                                    <td>
                                        @php
                                            $classGroup = \DB::table('classes_groups_exams')->where('id', $course->class_group_examp_id)->first();
                                        @endphp
                                        {{ $classGroup ? $classGroup->name : 'N/A' }}
                                    </td>
                                    <td>
                                        @php
                                            $board = \App\Models\BoardAgencyStateModel::find($course->board_id);
                                        @endphp
                                        {{ $board ? $board->name : 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('administrator.course-detail-edit', $course->id) }}" class="btn btn-edit btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        // Optional: Initialize dataTable if available
        if ($.fn.DataTable) {
            $('#courseTable').DataTable();
        }
    });
</script>
@endsection
