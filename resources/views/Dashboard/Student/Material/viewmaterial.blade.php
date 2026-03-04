@extends('Layouts.student')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="row" style="margin-bottom:10px;">
            <div class="col-md-12">
                <?php echo $title; ?>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <iframe class="doc" src="https://docs.google.com/gview?url={{ $filename }}&embedded=true" width="1000px" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {

    });
</script>
@endsection
