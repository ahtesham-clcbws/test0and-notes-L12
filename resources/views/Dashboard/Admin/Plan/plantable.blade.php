@extends('Layouts.admin')

@section('css')
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="" style="text-align: right;margin-top: 10px;margin-right: 28px;">
                    <a href="{{ route('administrator.plan_add') }}" class="btn btn-success pull-right">Add Package</a>
                </div>
                <div class="card-body">
                    
                    <table class="table" id="planstable">
                        <thead>
                            <tr>
                                <th scope="col">Sr. No</th>
                                <th scope="col">Package Image</th>
                                <th scope="col">Package Name & Class</th>
                                 <th scope="col">Featured</th> 
                                <th scope="col">Created For</th>
                                <th scope="col">Package Detail</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Package Type & Fee</th>
                                <th scope="col">Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
     <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#test_model">Open Modal</button> -->

<!-- Modal -->
<div class="modal fade" id="test_model" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content" style="width:120%;">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title">Package Details</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="" class="control-label">Package Name :</label>
                    <strong id="pack_nm"></strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Test Name</th>
                            <th>Study Notes</th>
                            <th>Video/ Youtube Class</th>
                            <th>Current Affairs</th>
                            
                        </tr>
                    </thead>
                    <tbody id="test_body">

                    </tbody>
                </table>

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info close" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>

@endsection

@section('javascript')
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    var deletedata="{{ url('administrator.plan_delete') }}";
    $(document).ready(function () {
        var table = $('#planstable').DataTable({
            // dom: 'lBrtip',
            // buttons: [
            // 'copy','csv', 'excel', 'pdf', 'print'
            // ]
            // "lengthChange": true,
            bprocessing: true,
            serverSide: true,
            ajax: '{!! route("administrator.plan") !!}',
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
                {data: 'plan_image'},
                {data: 'plan_name'},
                {data: 'is_featured'},
                {data: 'institute_id'},
                {data: 'tests'},
                {data: 'duration'},
                {data: 'final_fees'},
                {data: 'status'},
                {data: 'edit',orderable: false},
            ],
        });
        // Setup - add a text input to each header cell
        $('#example thead tr:eq(1) th').each(function (i) {
            if (i != 0 && i != 6) {
                var title = $('#example thead tr:eq(0) th').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            }
        });

        // Apply the search
        table.columns().every(function (index) {
            $('#example thead tr:eq(1) th:eq(' + index + ') input').on('keyup change', function () {
                table.column($(this).parent().index() + ':visible')
                    .search(this.value)
                    .draw();
            });
        });

        window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);


        // event to delete data 
     $(document).on('click', '.delete_plan', function () {console.log("delete");

            var id = $(this).attr('id');
            var status = $(this).attr('data');
            console.log("Delete Id:",id,status);
            if (id != "") {
                let text = "Are you sure to Active/Inactive a plan?";
                if (confirm(text) == true) {
                   
                $.ajax({
                    type: "POST",
                    url: '{!! route("administrator.plan_delete") !!}',
                    dataType: "JSON",
                    data: { plan_id: id , status: status},
                    success: function (data) {
                        if(data['status'] == 200){
                            alert(data['message']);
                            location.href = '{!! route("administrator.plan") !!}';
                        }else{
                            alert(data['message']);
                            location.href = '{!! route("administrator.plan") !!}';
                        }
                    }
                });
            }
                return false;
            }
        });

        function unique(list) {
        var result = [];
        $.each(list, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
        }

        // even to view test in modal
        $(document).on('click', '.view_test', function () {
            var package_name = $(this).attr('id');
            var tests = $(this).attr('data');
            var study_material_id = $(this).attr('study_material_id');
            var video_id = $(this).attr('video_id');
            var static_gk_id = $(this).attr('static_gk_id');
            // alert(static_gk_id)
            $('#pack_nm').html(package_name);
            test_arry = tests.split(',');
            console.log('test arry:',test_arry);

            var html = '';
            var i = 1 ;
            test_arry = unique(test_arry);
            
            //study array
            study_material_array = study_material_id.split(',');

            var html = '';
            var i = 1 ;
            study_material_array = unique(study_material_array);
            //study array
            
            //video array
            video_array = video_id.split(',');

            var html = '';
            var i = 1 ;
            video_array = unique(video_array);
            //video array
            
            //current affiars array
            static_gk_array = static_gk_id.split(',');

            var html = '';
            var i = 1 ;
            static_gk_array = unique(static_gk_array);
            //current affiars
            
            // $.each(test_arry, function(index, value) {
            //     html += '<tr>' +
            //                 '<td>'+(i++)+'</td>'+
            //                 '<td>'+value+'</td>'+
            //                 '<td>'+study_material_array[index]+'</td>'+
            //                 '<td>'+video_array[index]+'</td>'+
            //                 '<td>'+static_gk_array[index]+'</td>';
            // });
            $.each(test_arry, function(index, value) {
    html += '<tr>' +
                '<td>'+(i++)+'</td>'+
                '<td>'+value+'</td>'+
                '<td>'+ (study_material_array[index] ? study_material_array[index] : 'comingsoon') +'</td>'+
                '<td>'+ (video_array[index] ? video_array[index] : 'comingsoon') +'</td>'+
                '<td>'+ (static_gk_array[index] ? static_gk_array[index] : 'comingsoon') +'</td>';
});


            $('#test_body').html(html);
            $('#test_model').modal('show');
        });

        // even to close test modal
        $(document).on('click', '.close', function () {
            $('#test_model').modal('hide');
        });
    });
</script>
@endsection
