@extends('Layouts.Management.manager')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;">Details of Users</h5>
        </div>
        <div class="row p-3">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            {{-- <th>Institute Name <br>& Address</th> --}}
                            <th>Applied<br>Date</th>
                            {{-- <th>Status &<br>Institute code</th> --}}
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img id="profile_img"
                                        src="{{ $user->user_details['photo_url'] ? '/storage/app/' . $user->user_details['photo_url'] : asset('noimg.png') }}"
                                        style="width:50px;height:50px;border:1px solid #c2c2c2;border-radius:50%;">
                                </td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['mobile'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ date('d M Y', strtotime($user['created_at'])) }}</td>
                                <td>
                                    <div class="btn-{{$user['status']}}">{{Str::ucfirst($user['status']) }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('franchise.user_show', $user['id']) }}">View/Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection


{{-- @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
        });
    </script>
@endsection --}}
