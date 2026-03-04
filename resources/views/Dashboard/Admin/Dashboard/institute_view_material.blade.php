@extends('Layouts.admin')

@section('main')
    <section class="content admin-1">

        <div class="row corporate-cards">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#19467a ; color: white;">
                        <div>
                            <h5>Study Metirial: </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="studytable">
                                    <thead>
                                        <tr>
                                            <th >Sr. No.</th>
                                            <th >Study Subjects Title</th>
                                            <th >Class/Group</th>
                                            <th >Content Details</th>
                                            <th >Availability</th>
                                            <th >Author</th>
                                            <th >Status</th>
                                            <th >Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($study_material as $list)
                                            <tr>
                                                <td>{{$list->id}}</td>
                                                <td>{{$list->title}}</td>
                                                <td>{{$list->class_group}}</td>
                                                <td>{{$list->sub_title}}</td>
                                                <td>{{$list->publish_status}}<br>{{$list->publish_date}}</td>
                                                <td>{{$list->name}}</td>
                                                <td>
                                                @if($list->publish_status == 'Submit')
                                                    <label class="btn btn-sm btn-primary">{{$list->publish_status}}</label>
                                                @endif
                                                @if($list->publish_status == 'Published')
                                                    <label class="btn btn-sm btn-success">{{$list->publish_status}}</label>
                                                @endif
                                                @if($list->publish_status == 'Paused')
                                                    <label class="btn btn-sm btn-danger">{{$list->publish_status}}</label>
                                                @endif
                                                @if($list->publish_status == 'Paused & Send Back')
                                                    <label class="btn btn-sm btn-danger">{{$list->publish_status}}</label>
                                                @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('administrator.edit', [$list->id])}}" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>
                                                    <a href="javascript:void(0);" class="delete_material" id='{{$list->id}}' data='{{$list->file}}' title="Delete Study Material!"><i class="bi bi-trash2-fill text-danger me-2"></i></a>
                                                </td>
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
    $('#studytable').DataTable();
} );
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).on('click', '.delete_material', function () {
alert('hi')
        var id = $(this).attr('id');
        var file = $(this).attr('data');
        console.log("Delete Id:",id, file);
        if (id != "") {
            let text = "Are you sure to delete study material?";
            if (confirm(text) == true) {
            
            $.ajax({
                type: "POST",
                url: '{!! route("administrator.material_delete") !!}',
                dataType: "JSON",
                data: { study_material_id: id, file: file},
                success: function (data) {
                    if(data['status'] == 200){
                        alert(data['message']);
                        location.href = '{!! route("administrator.material") !!}';
                    }else{
                        alert(data['message']);
                        location.href = '{!! route("administrator.material") !!}';
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
