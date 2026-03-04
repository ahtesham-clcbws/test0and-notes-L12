@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
<?php

use Illuminate\Support\Facades\Auth;

function getFeatured($featured, $id)
{
    if ($featured) {
        return '<a href="' . 'material/is_featured/' . $id . '/0' . '" class="btn btn-sm btn-warning">UnFeatured</a>';
    }
    return '<a href="' . 'material/is_featured/' . $id . '/1' . '" class="btn btn-sm btn-primary" >Featured</a>';
}
function getAvailability($document_type, $publish_status, $publish_date)
{
    $type = '';
    if ($document_type == 'PDF')
        $type = '<i class="bi bi-file-pdf"></i>';
    if ($document_type == 'WORD')
        $type = '<i class="bi bi-file-word"></i>';
    if ($document_type == 'EXCEL')
        $type = '<i class="bi bi-file-excel"></i>';
    if ($document_type == 'VIDEO')
        $type = '<i class="bi bi-camera-video"></i>';
    if ($document_type == 'AUDIO')
        $type = '<i class="bi bi-file-music"></i>';
    if ($document_type == 'YOUTUBE')
        $type = '<i class="bi bi-youtube"></i>';

    if ($publish_status == 'Submit') {
        return $type . ' <label style="color:#AA336A;">' . $publish_status . '</label>' . '</br>' . date('d-m-Y', strtotime($publish_date));
    }
    return $type . ' <label style="color: #00A300;">' . $publish_status . '</label>' . '</br>' . date('d-m-Y', strtotime($publish_date));
}
function getStatus($publish_status)
{
    if ($publish_status == 'Submit')
        return '<label class="btn btn-sm btn-primary">' . $publish_status . '</label>';
    if ($publish_status == 'Published')
        return '<label class="btn btn-sm btn-success">' . $publish_status . '</label>';
    if ($publish_status == 'Paused')
        return '<label class="btn btn-sm btn-danger">' . $publish_status . '</label>';
    if ($publish_status == 'Paused & Send Back')
        return '<label class="btn btn-sm btn-danger">' . $publish_status . '</label>';
}
?>
<div class="container p-0">
    <div class="pb-4 justify-content-between align-items-end">
        <div class="col-2 mb-3">
            <small><b>Published Status</b></small>
            <select class="form-select form-select-sm" id="test_type" name="test_type"
                onchange="hendleTestPublish(this.value)" required>
                <option value="">All</option>
                <option value="Published" <?= isset($_GET['published']) && $_GET['published'] == 'Published' ? 'selected' : '' ?>>Published</option>
                <option value="Paused" <?= isset($_GET['published']) && $_GET['published'] == 'Paused' ? 'selected' : '' ?>>Paused</option>
            </select>
        </div>
        <div>
            <small><b>Study Material</b></small>
            <div class="">
                <div class="btn-group" role="group" aria-label="Basic outlined example" id="test_cat_button">
                    <button type="button" data-value='' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && empty($_GET['study_material_cat']) || !isset($_GET['study_material_cat']) ? 'active' : '' ?>"
                        onclick="handleTestCategory(null)">All </button>
                    <button type="button" data-value='1' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 1 ? 'active' : '' ?>"
                        onclick="handleTestCategory(1)">Study Notes & E-Books</button>
                    <button type="button" data-value='2' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 2 ? 'active' : '' ?>"
                        onclick="handleTestCategory(2)">Live & Video Classes</button>
                    <button type="button" data-value='3' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 3 ? 'active' : '' ?>"
                        onclick="handleTestCategory(3)">Static GK & Current Affairs</button>
                    <button type="button" data-value='4' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 4 ? 'active' : '' ?>"
                        onclick="handleTestCategory(4)">Comprehensive Study Material</button>
                    <button type="button" data-value='5' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 5 ? 'active' : '' ?>"
                        onclick="handleTestCategory(5)">Short Notes & One Liner</button>
                    <button type="button" data-value='6' class="btn btn-outline-primary <?= isset($_GET['study_material_cat']) && intval($_GET['study_material_cat']) == 6 ? 'active' : '' ?>"
                        onclick="handleTestCategory(6)">Premium Study Notes</button>
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
            <div class="card-body">

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
                        @foreach ($model as $material)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $material->title }}</td>
                            <td>{{ $material->study_class?->name }}</td>
                            <td>{{ $material->sub_title }}</td>
                            <td>{!! getFeatured($material->is_featured, $material->id) !!}</td>
                            <td>{!! getAvailability($material->document_type, $material->publish_status, $material->publish_date) !!}</td>
                            <td>{{ $material->created_by_user?->name ?? 'N/A' }}</td>
                            <td>{{ $material->category }}</td>
                            <td><a href="{{ route('administrator.edit', [$material->id]) }}" class="btn btn-info btn-sm" title="View Study Material!">View</a></td>
                            <td>{!! getStatus($material->publish_status) !!}</td>
                            <td>
                                <a href="{{ route('administrator.edit', [$material->id]) }}" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>
                                <a href="javascript:void(0);" class="delete_material" id="{{ $material->id }}" data="{{ $material->file }}" title="Delete Study Material!"><i class="bi bi-trash2-fill text-danger me-2"></i></a>
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
            fixedHeader: true
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

    let study_material_cat = "<?= isset($_GET['study_material_cat']) && $_GET['study_material_cat'] ? $_GET['study_material_cat'] : 0 ?>";
    let published = "<?= isset($_GET['published']) && $_GET['published'] ? $_GET['published'] : null ?>";

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
        study_material_cat = value == null ? '' : value;
        getTestTabledata()
    }

    async function hendleTestPublish(value) {
        published = value
        getTestTabledata()
    }

    function getTestTabledata() {
        const thisUrl = new URL(window.location.href);
        const params = thisUrl.searchParams;

        // Validate and update `study_material_cat`
        if (
            study_material_cat &&
            !isNaN(study_material_cat) &&
            Number(study_material_cat) >= 1 &&
            Number(study_material_cat) <= 6
        ) {
            if (params.has('study_material_cat')) {
                params.set('study_material_cat', encodeURI(study_material_cat)); // Update if exists
            } else {
                params.append('study_material_cat', encodeURI(study_material_cat)); // Add if not present
            }
        } else {
            params.delete('study_material_cat'); // Remove if invalid
        }

        // Validate and update `published`
        if (published === "Published" || published === "Paused") {
            if (params.has('published')) {
                params.set('published', published); // Update if exists
            } else {
                params.append('published', published); // Add if not present
            }
        } else {
            params.delete('published'); // Remove if invalid
        }

        // Construct the new URL
        const paramString = params.toString(); // Convert parameters to a query string
        const newUrl = paramString ? `${window.location.pathname}?${paramString}` : window.location.pathname;


        window.location.href = newUrl;
    }



    function noSection() {
        alert('Please Add section detail before adding questions.')
    }
</script>
@endsection
