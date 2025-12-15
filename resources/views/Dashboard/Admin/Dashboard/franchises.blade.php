@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;">Franchises</h5>
        </div>
        <div class="row p-3">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Applied<br>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img id="profile_img"
                                        src="{{ $user->institute['photo_url'] ? '/storage/public/' . $user->institute['photo_url'] : asset('noimg.png') }}"
                                        style="width:50px;height:50px;border:1px solid #c2c2c2;border-radius:50%;">
                                </td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}<br>{{ $user['mobile'] }}</td>
                                <td>{{ date('d M Y', strtotime($user['created_at'])) }}</td>
                                <td>
                                    <div class="btn-{{ $user['status'] }}">{{ Str::ucfirst($user['status']) }}</div>
                                    {{ $user->institute->branch_code }}
                                </td>
                                <td class="text-end">
                                    <div style="float:left; display: inline-block;">
                                    <a href="{{ route('administrator.franchise_viewstudentusers', $user['id']) }}"
                                        class="btn btn-info">
                                       View Student
                                    </a></br>
                                   <a href="{{ route('administrator.franchise_viewusers', $user['id']) }}"
                                        class="btn btn-warning">
                                       View Contributor
                                    </a></br>
                                    <a href="{{ route('administrator.franchise_viewmaterial', $user['id']) }}"
                                        class="btn btn-primary">
                                       View Study Material
                                    </a>
                                    </div>
                                    <div>
                                    <a href="{{ route('administrator.franchise_view', $user['id']) }}"
                                        class="btn btn-success">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('administrator.franchise_delete', $user['id']) }}"
                                        class="deletebutton ms-1 btn btn-danger">
                                        <i class="bi bi-trash2"></i>
                                    </a>
                                     </div>
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
@endsection
@section('javascript')
    {{-- <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
        });
    </script> --}}
@endsection
