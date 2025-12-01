@extends('Layouts.student')

@section('main')

<div class="container p-0">
    @if(session()->has('message'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        {{session('message')}}  
       
    </div> 
    @endif 
        <form action="{{route('student.manage_profile_process')}}" method="post" enctype="multipart/form-data" class="card dashboard-container mb-5">
            @csrf
            <div class="card-body">
                {{-- part 1 --}}
                <div class="row">

				<!--<div class="col-md-3">-->
				<!--</div>-->
					<div class="col-md-3">
						<div class="form-group">
                        	<label for="Name" class="control-label">Name</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control form-control-sm" placeholder="Enter Name" style="border: 1px solid #aaa;" required>
                        </div>
                    </div>
				<!--	<div class="col-md-3">-->
				<!--</div>-->
				<!--	<div class="col-md-3">-->
				<!--</div>-->
					<div class="col-md-3">
						<div class="form-group">
                        	<label for="photo_url" class="control-label">Select Photo</label>
                            <input type="file" name="photo_url"  class="form-control form-control-sm" style="border: 1px solid #aaa;">
                        </div>
                    </div>
				<!--	<div class="col-md-3">-->
				<!--</div>-->
				<!--<div class="col-md-3">-->
				<!--</div>-->
					<div class="col-md-3">
						<div class="form-group">
                        	<label for="Email" class="control-label">Email</label>
                            <input type="email" name="email" value="{{$user->email}}" id="email_new"
                                                    oninput="uniqueEmailCheck(this)"
                                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    class="form-control" placeholder="E-mail">
                            <!--<button class="btn btn-primary"-->
                            <!--    onclick="sendOtp('register')" type="button">-->
                            <!--    Get Otp-->
                            <!--</button>-->
                        </div>
                    </div>
                    
      <!--              <div class="col-md-3">-->
						<!--<div class="form-group">-->
      <!--                  	<label for="Email" class="control-label">Verify Email</label>-->
      <!--                      <input type="text" name="email"  class="form-control form-control-sm" placeholder="Verify Email" style="border: 1px solid #aaa;" required>-->
      <!--                      <button class="btn btn-primary"-->
      <!--                          onclick="sendOtp('register')" type="button">-->
      <!--                          Verify Otp-->
      <!--                      </button>-->
      <!--                  </div>-->
      <!--              </div>-->
                    
				<!--	<div class="col-md-3">-->
				<!--</div>-->
				<!--<div class="col-md-3">-->
				<!--</div>-->
					<div class="col-md-3">
						<div class="form-group">
                        	<label for="Mobile" class="control-label">Mobile</label>
                            <input type="number" id="mobile_number"
                                value="{{$user->mobile}}" name="mobile_number"
                                minlength="10" maxlength="10" class="form-control"
                                placeholder="Mobile">
                            <button class="btn btn-primary sendOtp"
                                onclick="sendOtp()" type="button">
                                Get Otp
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="old_mobile_number" name="old_mobile_number" value="{{$user->mobile}}">
                    <input type="hidden" id="verify_check" name="verify_check">
                    <div class="col-md-3">
						<div class="form-group">
                        	<label for="Mobile" class="control-label">Verify Mobile</label>
                            <input type="number" name="mobile_otp" id="mobile_otp"
                                minlength="6" maxlength="6" class="form-control"
                                placeholder="Input OTP">
                            <button class="btn btn-primary verifyOtp"
                                onclick="verifyOtp()" type="button" disabled>
                                Verify
                            </button>
                        </div>
                    </div>
                    
				<!--	<div class="col-md-3">-->
				<!--</div>-->
				
				<div class="row mt-3">
					<!--<div class="col-sm-9">-->
						<div class="form-group" style="float:right">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					<!--</div>-->
				</div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function sendOtp(){
           var old_mobile_number = document.getElementById('old_mobile_number').value;
           var mobile_number = document.getElementById('mobile_number').value;
            if(old_mobile_number == mobile_number){
                Swal.fire('Mobile Number Already Updated!')
            }else{
                let timerInterval;
                  Swal.fire({
                      title: 'Wait...',
                      timerProgressBar: true,
                      didOpen: () => {
                          Swal.showLoading();
                          const b = Swal.getHtmlContainer().querySelector('b');
                          timerInterval = setInterval(() => {
                              b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                          }, 1000);
                      },
                  });
                $.get("/student/verifynumber/"+mobile_number, function(data){
                clearInterval(timerInterval);
                    if(data == false){
                        Swal.fire('Mobile Number Already Registered!')
                    }else{
                        Swal.fire('Otp Sent!');
                        $(".sendOtp").attr('disabled', ''); 
                        $(".verifyOtp").removeAttr('disabled', ''); 
                    }
                });
            }
            
    }
    
    function verifyOtp(){
        var mobile_number = document.getElementById('mobile_number').value;
        var mobile_otp = document.getElementById('mobile_otp').value;
        
        let timerInterval;
                  Swal.fire({
                      title: 'Wait...',
                      timerProgressBar: true,
                      didOpen: () => {
                          Swal.showLoading();
                          const b = Swal.getHtmlContainer().querySelector('b');
                          timerInterval = setInterval(() => {
                              b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                          }, 1000);
                      },
                  });
                $.get("/student/verifyotp/"+mobile_number+"/"+mobile_otp, function(data){
                clearInterval(timerInterval);
                    if(data == true){
                        Swal.fire('Otp Verified!');
                        $(".verifyOtp").attr('disabled', '');
                        document.getElementById('verify_check').value = '1';
                    }else{
                        Swal.fire('Please Enter Valid Otp');
                    }
                });
    }
    
//     $('#change_profile input[type=file]').submit(function(event) {
//         var verify_check = document.getElementById('verify_check').value;
//         var old_mobile_number = document.getElementById('old_mobile_number').value;
//           var mobile_number = document.getElementById('mobile_number').value;
//             if(old_mobile_number != mobile_number){
//                 if(verify_check != 1){
//                 Swal.fire('Please Verify Mobile Number')
//                 return false;
//                 }
//                 // Swal.fire('Mobile Number Already Updated!')
//             }
//             else{
//               event.preventDefault();
//               let timerInterval
//               Swal.fire({
//               title: 'Wait...',
//               // html: 'I will close in <b></b> milliseconds.',
//               //   timer: 2000,
//               timerProgressBar: true,
//               didOpen: () => {
//                   Swal.showLoading()
//                   const b = Swal.getHtmlContainer().querySelector('b')
//                   timerInterval = setInterval(() => {
//                   b.textContent = Swal.getTimerLeft()
//                   },)
//               },
//               })
//               var formData = $(this).serialize();
//               var file = e.target.files[event];
//               formData.append('photo', file);
//               $.ajax({
//                   url: $(this).attr('action'),
//                   type: 'POST',
//                   async: true,
//                   data: formData,
//                   success: function(response) {
//                       if (response == true) {
//                           willClose: () => {
//                               clearInterval(timerInterval)
//                           }
                      
//                       Swal.fire(
//                             'Good job!',
//                             'Profile Updated.',
//                             'success',
            
//                           ).then(function() {
//                             location.reload();
//                               });
//                       } else {
//                         Swal.fire({
//                           icon: 'error',
//                           title: 'This Email Alredy Registred!',
//                           text: response.msg,
//                         })
//                         // $("#msg_telent").html(response.msg);
//                       }
//                   }
//               });
//             }
// });
        </script>
    </script>
@endsection