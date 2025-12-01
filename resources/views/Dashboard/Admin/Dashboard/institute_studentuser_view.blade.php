@extends('Layouts.admin')

@section('main')
    <section class="content admin-1">

        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>students: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <button type="button" style="margin-top: 5px; float:right;" class="btn btn-success" onclick="printTable()">Print Form</button>
                                <table class="table table-bordered table-hover" id="studentstable">
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
                                        @foreach($students as $key=> $list)
                                            <tr>
                                                 <td>{{$key + 1}}</td>
                                                <td>
                                                    <img id="profile_img"
                                                    src="{{ isset($list) && $list->photo_url ? '/storage/app/' . $list->photo_url : asset('noimg.png') }}"
                                                    style="width:80px;height:80px;border:1px solid #c2c2c2;  ">
                                                   </td>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->education_type_name}}</td>
                                                <td>{{$list->class_name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->institute_name}}<br>{{$list->institute_code}}</td>
                                                <td>{{$list->status}}</td>
                                                <td><a href="{{ route('administrator.user_show', $list->id) }}"
                                                    class="btn btn-info">
                                                   Edit Student
                                                </a></td>
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
    </section>

            
@endsection
@section('javascript')
<script>
    $(document).ready( function () {
    $('#studentstable').DataTable();
} );


function printTable() {
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
}
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
