@extends('Layouts.admin')

@section('css')
@endsection
@section('main')
    <div class="container p-0">
        <div class="pb-4 d-flex justify-content-between align-items-end">
            <div class="col-2">
                <small><b>Published Status</b></small>
                <select class="form-select form-select-sm" id="test_type" name="test_type"
                    onchange="hendleTestPublish(this.value)" required>
                    <option value="">All</option>
                    <option value="true">Published</option>
                    <option value="false">Not Published</option>
                </select>
            </div>
            <div class="text-end">
                <div class="btn-group" role="group" aria-label="Basic outlined example" id="test_cat_button">
                    <button type="button" data-value='' class="btn btn-outline-primary active"
                        onclick="handleTestCategory(this)">All Test</button>
                    <button type="button" data-value='4' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">New Test</button>
                    <button type="button" data-value='5' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Original Test</button>
                    <button type="button" data-value='6' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Previous Test</button>
                    <button type="button" data-value='7' class="btn btn-outline-primary"
                        onclick="handleTestCategory(this)">Premium Test</button>
                </div>
            </div>
        </div>
        <div class="dashboard-container mb-5">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="teststable">
                        <thead>
                            <tr>
                                <th scope="col">Test title</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">Class Name</th>
                                <th scope="col">Test Category</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Sections</th>
                                <th scope="col">Test Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Featured</th>
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
    <script type="text/javascript" src="{{ asset('js/adminteststable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/sweetalert2/sweetalert.min.js') }}"></script>
    <script>
        let test_cat = '';
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
            console.log(value);
            $('#test_cat_button').children().removeClass('active');
            value.classList.add('active');
            test_cat = value.getAttribute('data-value')
            getTestTabledata()
        }

        async function hendleTestPublish(value) {
            published = value
            getTestTabledata()
        }

        function getTestTabledata() {
            $('#teststable').DataTable().ajax.url(`?test_cat=${test_cat}&published=${published}`).load();
        }

        function noSection(){
            alert('Please Add section detail before adding questions.')
        }
    </script>
@endsection
