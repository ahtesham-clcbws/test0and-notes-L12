@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        @error('resultError')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="student_planstable">
                        <thead>
                            <tr>
								<th scope="col">Sr</th>
                                <th scope="col">Plan Name</th>
                                <th scope="col">Package Type</th>
                                <th scope="col">Start date</th>
                                <th scope="col">End date</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Fees</th>
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
@endsection

@section('javascript')
<script>
    $(document).ready(function () {
        var table = $('#student_planstable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("student.my-plan") !!}',
            lengthMenu: [[10, 15, 30, 50],[10, 15, 30, 50]],
            responsive: {
                details: true
            },
            //tfoot search bar
            orderCellsTop: true,
            fixedHeader: true,

            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: true,
                    searchable: false
                },
                {data: 'plan_name'},
                {data: 'package_type'},
                {data: 'plan_start_date'},
                {data: 'plan_end_date'},
                {data: 'duration'},
                {data: 'final_fees'},
                {data: 'plan_status'},
                {data: 'actions', orderable: false, searchable: false},

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

    });
</script>
@endsection
