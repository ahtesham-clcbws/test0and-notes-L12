@extends('Layouts.franchise')

@section('css')
    <style>
        #imageSaveButton2,
        #imageSaveButton {
            display: none;
        }

    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form class="col-md-6 col-12" id="uploadImage" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <h4>User Image</h4>
                                <img class="w-100 mb-2" id="user_profile_image"
                                    src="{{ $user['details']['photo_url'] ? '/storage/app/public/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                                <input name="user_image" class="form-control mt-3" accept="image/jpeg,image/jpg" type="file"
                                    onchange="avatarPreview(event)">
                                <button class="btn btn-success w-100 mt-2" type="submit" id="imageSaveButton">
                                    Save Profile Image
                                </button>
                            </div>
                            <div class="col-md-6 col-12">
                                <h4>Institute Logo</h4>
                                <img class="w-100 mb-2" id="user_logo_image"
                                    src="{{ $user['details']['logo'] ? '/storage/app/public/' . $user['details']['logo'] : asset('noimg.png') }}">
                                <input name="logo" class="form-control mt-3" accept="image/jpeg,image/jpg" type="file"
                                    onchange="logoPreview(event)">
                                <button class="btn btn-success w-100 mt-2" type="submit" id="imageSaveButton2">
                                    Save Logo
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6 col-12">
                        <form></form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script>
        function avatarPreview(event) {
            var output = document.getElementById('user_profile_image');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
                $('#imageSaveButton').show();
            } else {
                $('#imageSaveButton').hide();
            }
        }
        function logoPreview(event) {
            var output = document.getElementById('user_logo_image');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
                $('#imageSaveButton2').show();
            } else {
                $('#imageSaveButton2').hide();
            }
        }
        // $('#uploadImage').submit(function(event) {
        //     event.preventDefault();
        //     var formData = new FormData($(this)[0]);

        //     $.ajax({
        //         url: '/',
        //         type: 'post',
        //         data: formData,
        //         contentType: false,
        //         processData: false
        //     }).done(function(response, textStatus) {
        //         console.log(response);
        //         if(response == 'true') {
        //             location.reload();
        //         }
        //     }).fail(function(error, textStatus) {
        //         console.log(error);
        //     })
        // })
    </script>
@endsection
