@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;" class="d-inline">Default OTP numbers</h5>
            <button class="btn btn-success btn-sm float-end">Add New</button>
        </div>
        <div class="row p-3">
            <div class="table-responsive">
                <table class="table table-sm table-bordered datatable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['numbers'] as $key => $number)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $number['mobile'] }}</td>
                                <td>
                                    @if (numberInUse($number['mobile']))
                                        <button class="btn btn-sm btn-danger">In Use</button>
                                    @else
                                        <button class="btn btn-sm btn-success">Free</button>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('administrator.dashboard_default_number_delete', $number['id']) }}"
                                        class="deletebutton ms-1 btn btn-sm btn-danger">
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
