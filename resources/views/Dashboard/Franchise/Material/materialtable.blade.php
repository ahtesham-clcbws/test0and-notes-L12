@extends('Layouts.franchise')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
            @if(isset($submit_content) && $submit_content == 1)
                @if(isset($is_franchies) && $is_franchies == 1)
                <div class="" style="text-align: right;margin-top: 10px;margin-right: 28px;">
                    <a href="{{ route('franchise.management.material_add') }}" class="btn btn-success pull-right">Add Study Material</a>
                </div>
                @endif
                <div class="card-body">
                    
                    <table class="table" id="studytable">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Study Subjects Title</th>
                                <th scope="col">Class/Group</th>
                                <th scope="col">Content Details</th>
                                <!-- <th scope="col">Type</th> -->
                                <!-- <th scope="col">Format</th> -->
                                <th scope="col">Availability</th>
                                <th scope="col">Author</th>
                                <th class="col">View</th>
                                <th scope="col">Status</th>
                                <!-- <th class="text-end">Download</th> -->
                                <th class="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Indian Polity</td>
                                <td>Part(1st-6th) Hindi/Engg.</td>
                                <td>Free</td>
                                <td>Coming Soon</td>
                                <td>PDF</td>
                                <td>Vishal</td>
                                <td><button type="button" class="btn btn-sm btn-primary">Publish</button></td>
                                <td><a href="" style="margin: 0 auto; display:block; text-align: center;pointer-events: none;"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Active and Passive Voice</td>
                                <td>Basic English grammer</td>
                                <td>Free</td>
                                <td>Available</td>
                                <td>PDF</td>
                                <td>Arzoo</td>
                                <td>Downloaded</td>
                                <td><a href="" style="margin: 0 auto; display:block; text-align: center"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                @else
                <div class="card-body">
                    <h4 style="color:red;">You are not allowed to access this menu functionality. Kindly contact admin to enable it!</h4>
                </div>

                @endif
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        var table = $('#studytable').DataTable({
            // dom: 'lBrtip',
            // buttons: [
            // 'copy','csv', 'excel', 'pdf', 'print'
            // ]
            // "lengthChange": true,
            bprocessing: true,
            serverSide: true,
            ajax: '{!! route("franchise.management.material") !!}',
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
                // {data: 'type'},
                // {data: 'format'},
                {data: 'availability'},
                {data: 'created_by'},
                {data: 'view',orderable: false},
                {data: 'status'},
                // {data: 'download',orderable: false},
                {data: 'edit',orderable: false},
            ],
        });

        // event to delete data 
     $(document).on('click', '.delete_material', function () {

        var id = $(this).attr('id');
        var file = $(this).attr('data');
        console.log("Delete Id:",id, file);
        if (id != "") {
            let text = "Are you sure to delete study material?";
            if (confirm(text) == true) {
            
            $.ajax({
                type: "POST",
                url: '{!! route("franchise.management.material_delete") !!}',
                dataType: "JSON",
                data: { study_material_id: id, file: file},
                success: function (data) {
                    if(data['status'] == 200){
                        alert(data['message']);
                        location.href = '{!! route("franchise.management.material") !!}';
                    }else{
                        alert(data['message']);
                        location.href = '{!! route("franchise.management.material") !!}';
                    }
                }
            });
        }
            return false;
        }
        });
    });
</script>
@endsection
