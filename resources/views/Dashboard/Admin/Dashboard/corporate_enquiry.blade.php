@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;">Enquiries</h5>
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
                            <th>City</th>
                            <th>Enquiry<br>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $enquiry)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img id="profile_img"
                                        src="{{ $enquiry['photoUrl'] ? '/storage/public/' . $enquiry['photoUrl'] : asset('noimg.png') }}"
                                        style="width:50px;height:50px;border:1px solid #c2c2c2;border-radius:50%;">
                                </td>
                                <td>{{ $enquiry['name'] }}</td>
                                <td>{{ $enquiry['email'] }}<br>{{ $enquiry['mobile'] }}</td>
                                <td>{{ $enquiry['city_name'] }}</td>
                                <td>{{ date('d M Y', strtotime($enquiry['created_at'])) }}</td>
                                <td>
                                    <div class="btn-{{ $enquiry['status'] }}" style="margin-bottom:0px">
                                        @if($enquiry['status'] == 'converted')
                                            {{ Str::ucfirst('new') }}
                                        @else
                                            {{ Str::ucfirst($enquiry['status']) }}
                                        @endif
                                    </div>
                                    
                                    @if($enquiry['status'] != 'new')
										<p style="text-align:center;margin:0px">{{ $enquiry['branch_code'] }}</p>
									@endif
                                    {{--
                                        <p style="text-align:center;margin:0px">{{ $enquiry['branch_code'] }}</p>
                                    --}}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('administrator.corporate_enquiry_show', $enquiry['id']) }}" class="btn btn-success">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('administrator.corporate_enquiry_delete', $enquiry['id']) }}" class="deletebutton ms-1 btn btn-danger">
                                        <i class="bi bi-trash2"></i>
                                    </a>
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
