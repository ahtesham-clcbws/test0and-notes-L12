@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;">Franchises</h5>
        </div>
        <div class="row p-3">
            <div class="table-responsive">
                <table class="table table-bordered datatable" id="example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Groups</th>
                            <th>Status</th>
                            <th>Add Content</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['mobile'] }}</td>
                                <td>
                                    @foreach ($user['roles'] as $role)
                                        <span class="singleRole">{{ Str::ucfirst($role) }}</span>
                                    @endforeach
                                </td>
                                <td>{!! $user['status'] !!}</td>
                                <td>{!! $user['details'] && $user['details']['allowed_to_upload'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>' !!}
                                </td>
                                <td><a
                                        href="{{ route('administrator.corporate_enquiry_show', $user['id']) }}">View/Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection


@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" /> --}}
    <style>
        .singleRole:not(:last-child):after {
            content: ', ';
        }

    </style>
@endsection
@section('javascript')
    {{-- <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script> --}}
@endsection
