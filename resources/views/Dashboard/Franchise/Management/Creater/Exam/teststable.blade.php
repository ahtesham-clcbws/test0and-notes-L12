@extends('Layouts.Management.creater')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="teststable">
                        <thead>
                            <tr>
                                <th scope="col">Test</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">Class Name</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Sections</th>
                                <th scope="col">Questions</th>
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
    <script type="text/javascript" src="{{ asset('js/franchise/franchiseteststable.js') }}"></script>
    <script>
        async function sentToPublisher(id) {
            var formData = new FormData();
            formData.append('form_name', 'sent_to_publisher');
            formData.append('id', id);
            await $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function (data) {
                if (data && data.success) {
                    alert('Section are sent to publisher');
                    location.reload();
                } else {
                    alert(data.message);
                }
            }).fail(function (data) {
                alert('Section are not sent to publisher');
            })
        } 
    </script>
@endsection
