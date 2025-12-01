@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
<div class="container p-0">
    <div class="pb-4 justify-content-between align-items-end">
        <div class="col-2 mb-3">
            <small><b>Published Status</b></small>
            <select class="form-select form-select-sm" id="test_type" name="test_type"
                onchange="hendleTestPublish(this.value)" required>
                <option value="">All</option>
                <option value="Published">Published</option>
                <option value="Paused">Paused</option>
            </select>
        </div>
        <div>
            <small><b>Study Material</b></small>
            <div class="">
                <div class="btn-group" role="group" aria-label="Basic outlined example" id="test_cat_button">
                    <button type="button" data-value='' class="btn btn-outline-primary active"
                        onclick="handleTestCategory(this)">All </button>
                    <button type="button" data-value='1' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Study Notes & E-Books</button>
                    <button type="button" data-value='2' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Live & Video Classes</button>
                    <button type="button" data-value='3' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Static GK & Current Affairs</button>
                    <button type="button" data-value='4' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Comprehensive Study Material</button>
                    <button type="button" data-value='5' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Short Notes & One Liner</button>
                    <button type="button" data-value='6' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Premium Study Notes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-container mb-5">
        <div class="mb-2" style="text-align: right;margin-top: 10px;margin-right: 28px;">
            <a href="{{ route('administrator.material_add') }}" class="btn btn-success pull-right">Add Study
                Material</a>
        </div>
        <div class="card">
            @if ((isset($is_admin) && $is_admin == 1) || (isset($is_franchies) && $is_franchies == 1))
            @endif
            <div class="card-body">

                {{ json_encode($model) }}

                <table class="table" id="studytable">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No.</th>
                            <th scope="col">Study Subject Title</th>
                            <th scope="col">Class/Group</th>
                            <th scope="col">Content Details</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Availability</th>
                            <th scope="col">Author</th>
                            <th scope="col">Category</th>
                            <th class="col">View</th>
                            <th scope="col">Status</th>
                            <th class="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model as $study_material)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>Indian Polity</td>
                            <td>Part(1st-6th) Hindi/Engg.</td>
                            <td>Free</td>
                            <td>Coming Soon</td>
                            <td>PDF</td>
                            <td>Vishal</td>
                            <td>Vishal</td>
                            <td>Vishal</td>
                            <td><button type="button" class="btn btn-sm btn-primary">Publish</button></td>
                            <td><a href="" style="margin: 0 auto; display:block; text-align: center;pointer-events: none;"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a></td>
                        </tr>
                        @endforeach
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
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // bprocessing: true,
        // serverSide: true,
        // ajax: / route('administrator.materialTable'),
        var table = $('#studytable').DataTable({
            lengthMenu: [
                [10, 15, 30, 50],
                [10, 15, 30, 50]
            ],
            responsive: {
                details: true
            },
            orderCellsTop: true,
            fixedHeader: true,
            columns: [{
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'title',
                    searchable: true
                },
                {
                    data: 'class',
                    searchable: false
                },
                {
                    data: 'sub_title',
                    searchable: false
                },
                {
                    data: 'is_featured',
                    searchable: false
                },
                {
                    data: 'availability',
                    searchable: false
                },
                {
                    data: 'created_by',
                    searchable: false
                },
                {
                    data: 'category',
                    searchable: false
                },
                {
                    data: 'view',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    searchable: false
                },
                {
                    data: 'edit',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // event to delete data
        $(document).on('click', '.delete_material', function() {

            var id = $(this).attr('id');
            var file = $(this).attr('data');
            console.log("Delete Id:", id, file);
            if (id != "") {
                let text = "Are you sure to delete study material?";
                if (confirm(text) == true) {

                    $.ajax({
                        type: "POST",
                        url: "<?= route('administrator.material_delete') ?>",
                        dataType: "JSON",
                        data: {
                            study_material_id: id,
                            file: file
                        },
                        success: function(data) {
                            if (data['status'] == 200) {
                                alert(data['message']);
                                location.href = "<?= route('administrator.material') ?>";
                            } else {
                                alert(data['message']);
                                location.href = "<?= route('administrator.material') ?>";
                            }
                        }
                    });
                }
                return false;
            }
        });
    });

    let study_material_cat = '';
    let published = '';
    async function handleTestFeature(value) {
        await $.ajax({
            url: 'test/feature/' + value,
            type: 'get',
            contentType: false,
            processData: false
        }).done(function(data) {

        }).fail(function(data) {

        })
        $('#teststable').DataTable().ajax.reload()
    }

    async function handleTestCategory(value) {
        $('#test_cat_button').children().removeClass('active');
        value.classList.add('active');
        study_material_cat = value.getAttribute('data-value')
        console.log(study_material_cat);
        getTestTabledata()
    }

    async function hendleTestPublish(value) {
        published = value
        getTestTabledata()
    }

    function getTestTabledata() {
        $('#studytable').DataTable().ajax.url(`?study_material_cat=${encodeURI(study_material_cat)}&published=${published}`).load();
    }

    function noSection() {
        alert('Please Add section detail before adding questions.')
    }
</script>
@endsection
