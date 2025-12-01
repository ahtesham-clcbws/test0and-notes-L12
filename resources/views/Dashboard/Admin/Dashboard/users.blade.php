@extends('Layouts.admin')

@section('main')
    <section class="content admin-1 border border-dark">
        <div class="heading">
            <h5 style="font-size: 18px;">Students</h5>
            <button type="button" style="" class="btn btn-success" onclick="printTable()">Print Form</button>
        </div>

        <div class="row p-3">
            <div class="table-responsive">
                <table class="table table-bordered datatable" id="studentstable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Student Name</th>
                            <th>Education Type</th>
                            <th>Class Group</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <!--<th>Applied & End date Subscription</th>-->
                            <th>Institute Name & Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data['user'] as $key=> $list)
                            <tr>
                                 <td>{{$key + 1}}</td>
                                <td>
                                    <img id="profile_img"
                                    src="{{ isset($list) && $list->user_details->photo_url ? '/storage/' . $list->user_details->photo_url : asset('noimg.png') }}"
                                    style="width:80px;height:80px;border:1px solid #c2c2c2;  ">
                                   </td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->education_type_name}}</td>
                                <td>{{$list->class_name}}</td>
                                <td>{{$list->email}}</td>
                                <td>{{$list->mobile}}</td>
                                <td>{{$list->institute_name}}<br>{{$list->institute_code}}</td>
                                <td>{{$list->status}}</td>
                                <td class="text-end">
                                    <a href="{{ route('administrator.user_show', $list->id) }}"
                                        class="btn btn-success">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    @if ($data['franchise_status'])
                                        <a href="{{ route('administrator.user_delete', $list->id) }}"
                                            class="deletebutton ms-1 btn btn-danger">
                                            <i class="bi bi-trash2"></i>
                                        </a>
                                    @endif
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
    {{-- <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
        //     $('.datatable').DataTable();
        // });
        {{--function printTable() {
            const table = document.getElementById("studentstable");
            const printWindow = window.open('', '', 'height=500,width=800');
            printWindow.document.write('<html><head><title>Services Table</title>');
            printWindow.document.write('<style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(table.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }--}}
    </script>
@endsection
