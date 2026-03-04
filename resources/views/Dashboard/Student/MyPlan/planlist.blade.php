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
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        @if(request()->get('type') == 'premium')
                            Premium Packages
                        @elseif(request()->get('type') == 'free')
                            Free Packages
                        @else
                            Packages
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table" id="student_planstable">
                        <thead>
                            <tr>
								<th scope="col">Sr</th>
                                <th scope="col">Plan Name</th>
                                <th scope="col">Package Type</th>
                                <th scope="col">Institute/Test and Notes</th>
                                <th scope="col">Test</th>
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
            ajax: {
                url: '{!! route("student.plan") !!}',
                data: function(d) {
                    d.type = '{{ request()->get("type") }}';
                }
            },
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

    });
</script>
@endsection
