@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-12">
                <?php



 echo $title; ?>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">

                    <table class="table" id="studytable">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Study Subject Title</th>
                                <th scope="col">Class/Group</th>
                                <th scope="col">Content Details</th>
                                <th scope="col">Format & Availability</th>
                                <th scope="col">Author</th>
                                <th class="col">View</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Indian Polity</td>
                                <td>9TH</td>
                                <td>Part(1st-6th) Hindi/Engg.</td>
                                <td><i class="bi bi-file-pdf"></i> <label style="color:#00A300;">Published </label><i class="bi bi-check-lg text-success" style="font-weight:400;"></i></br>19-12-2022</td>
                                <td>Admin</td>
                                <td><label class="btn btn-sm btn-success">View</label></td>
                                <td><a href='#'><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Indian Polity</td>
                                <td>9TH</td>
                                <td>Part(1st-6th) Hindi/Engg.</td>
                                <td><i class="bi bi-file-pdf"></i> <label style="color:#AA336A;">Coming Soon</label></br>20-12-2022</td>
                                <td>Admin</td>
                                <td><label class="btn btn-sm btn-primary">View</label></td>
                                <td><a href='#' disabled><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<?php use Illuminate\Support\Facades\Route; ?>
<script>
    $(document).ready(function () {
        var table = $('#studytable').DataTable({
            dom: 'lBrtip',
            buttons: [
            'copy','csv', 'excel', 'pdf', 'print'
            ],
            "lengthChange": true,
            bprocessing: true,
            serverSide: true,
            ajax: '{{ route(Route::currentRouteName()) }}',
            lengthMenu: [[10, 15, 30, 50],[10, 15, 30, 50]],
            responsive: {
                details: true
            },
            //tfoot search bar
            orderCellsTop: true,
            fixedHeader: true,

            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: true
                },
                {data: 'title'},
                {data: 'class'},
                {data: 'sub_title'},
                {data: 'availability'},
                {data: 'created_by'},
                {data: 'view',orderable: false},
                {data: 'download',orderable: false},
            ],
        });
    });
</script>
@endsection
