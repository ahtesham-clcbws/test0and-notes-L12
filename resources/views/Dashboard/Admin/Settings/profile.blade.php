@extends('Layouts.admin')

@section('css')
    <style>
        #imageSaveButton {
            display: none;
        }

    </style>
@endsection
@section('main')
    <section class="content admin-1">
        <div class="card">
            <div class="card-body">
               
               
                    <form  id="uploadImage" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="Select User Image" class="control-label"></label>
                            <input name="user_image" class="form-control" accept="image/jpeg,image/jpg" type="file"
                                onchange="avatarPreview(event)">
                            <img class="w-100 mb-2" id="user_profile_image"
                                src="{{ isset($user['details']) && $user['details']['photo_url'] ? '/storage/' . $user['details']['photo_url'] : asset('noimg.png') }}">
                        </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Email" class="control-label">Email</label>
                                    <input type="email" id="email" name="email"  class="form-control" style="border: 1px solid #aaa;" value="<?php echo $user['details']['email']; ?>" required>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Mobile No." class="control-label">Mobile No.</label>
                                <input type="number" id="mobile"  name="mobile" minlength="10" maxlength="10" required="" class="form-control" value="<?php echo $user['details']['mobile']; ?>">
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" type="submit" id="imageSaveButton" >
                                    Update Profile Details
                                </button> 
                            </div>
                        </div>
                        
                    </form>
                    
               
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script>
        $('#imageSaveButton').show();
        function avatarPreview(event) {
            var output = document.getElementById('user_profile_image');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
                // $('#imageSaveButton').show();
            } else {
                // $('#imageSaveButton').hide();
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
