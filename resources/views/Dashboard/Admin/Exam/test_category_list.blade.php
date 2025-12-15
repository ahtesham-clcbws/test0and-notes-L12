@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-danger" style="float: right;" href="{{ route('administrator.add_category') }}">
                       Add Category
                    </a>
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Categry Name</th>
                                <th scope="col">Category Image</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($test_cat as $key => $list)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$list->cat_name}}</td>
                                <td><img style="width:80px;height:80px;border:1px solid #c2c2c2;  " src="{{ isset($list) && $list->cat_image ? '/storage/' . $list->cat_image : asset('noimg.png') }}"></td>
                                <td>
                                   <a class="btn btn-primary" href="{{ route('administrator.edit_category',[$list->id]) }}">
                                       Edit
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');" href="{{ route('administrator.delete_category',[$list->id]) }}">
                                       Delete
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
@endsection

@section('javascript')
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
@endsection
