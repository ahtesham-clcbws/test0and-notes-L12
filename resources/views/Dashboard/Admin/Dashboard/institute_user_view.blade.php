@extends('Layouts.admin')

@section('main')
    <section class="content admin-1">
        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>New: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="newtable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($new as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->created_at->format('Y-m-d')}}</td>
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
        <br>
       
        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>managers: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="managerstable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($managers as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->created_at->format('Y-m-d')}}</td>
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
        <br>
        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>creators: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="creatorstable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($creators as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->created_at->format('Y-m-d')}}</td>
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
        <br>
        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>publishers: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="publisherstable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($publishers as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->created_at->format('Y-m-d')}}</td>
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
        <br>
        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>multi: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="multitable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Create date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($multi as $list)
                                            <tr>
                                                <td>{{$list->name}}</td>
                                                <td>{{$list->email}}</td>
                                                <td>{{$list->mobile}}</td>
                                                <td>{{$list->created_at->format('Y-m-d')}}</td>
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
    $('#newtable').DataTable();
} );
    $(document).ready( function () {
    $('#studentstable').DataTable();
} );
    $(document).ready( function () {
    $('#managerstable').DataTable();
} );
    $(document).ready( function () {
    $('#creatorstable').DataTable();
} );
    $(document).ready( function () {
    $('#publisherstable').DataTable();
} );
    $(document).ready( function () {
    $('#multitable').DataTable();
} );
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
