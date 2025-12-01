@extends('Layouts.frontend')

@section('css')
    <style>
        /* #corporate .form-control,
                            #corporate .form-select {
                                height: inherit;
                            } */
        #corporate .input-group .btn {
            min-width: 85px;
        }

    </style>
@endsection
@section('main')

    <section>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="crs_log_wrap" style="margin-top:-50px;border: 1px solid #03b97c;width:60%;">
                        <form class="crs_log__caption" id="institute_user" enctype="multipart/form-data">
                            <div class="rcs_log_124">
                                <div class="row py-3">
                                    <div class="col">
                                        <h4 class="theme-cl" style="border-bottom: 3px solid #03b97c;">
                                                    <i class="ti-user"></i>
                                           Contributor Sign up Form</h4>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                        <div class="form-group smalls">
                                            <label>Institute *</label>
                                            <select class="form-select" id="inputGroupSelect02" name="institute_code" required>
                                                @foreach ($data['franchiseCodes'] as $franchiseCode)
                                                <option selected value="{{ $franchiseCode['branch_code'] }}">
                                                    {{ $franchiseCode['institute_name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div> -->

                    <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-user"></i>
                                                </span>
                                            <input type="text" name="name" class="form-control" placeholder="Contributor name"
                                            required>
                                        </div>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                        <div class="form-group smalls">
                                        <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-email"></i>
                                                </span>
                                                <input type="email" name="email" id="email_new" oninput="uniqueEmailCheck(this)" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" placeholder="E-mail" required="" style="border-color: rgb(230, 235, 245); background-color: rgb(255, 255, 255);">
                                        </div>
                                        </div>
                                </div>
                        </div>  
                        
                        <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                        <div class="form-group smalls flex-nowrap">
                                            <div class="box-input">
                                            <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="ti-mobile"></i></span>
                                            <input type="number" min="10" class="form-control"
                                                placeholder="Mobile number" name="mobile_number" id="mobile_register" oninput="mobileNumberCheck(this, 'register')" required>
                                                <button class="btn theme-bg-dark text-white append"
                                                            onclick="sendOtp('register')" type="button" style="padding:0;">
                                                            Get Otp
                                                        </button>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <input id="verifystatus_register" name="verifystatus_register"
                                        class="d-none" value="0">
                                        <div class="form-group smalls flex-nowrap">
                                            <div class="box-input">
                                            <div class="input-group flex-nowrap">
                                            <span class="input-group-text">
                                            <i class="ti-key"></i>
                                                            </span>
                                                            <input type="number" name="mobile_otp" id="mobile_otp_register"
                                                                minlength="6" maxlength="6" required class="form-control"
                                                                placeholder="Input OTP">
                                                            <button class="btn theme-bg-dark text-white append"
                                                                onclick="verifyOtp('register')" type="button" style="padding:0;">
                                                                Verify
                                                            </button>
                                            </div>
                                        </div>
                                </div>
                        </div>
                        </div>

                        <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                        <div class="form-group smalls flex-nowrap">
                                        <div class="input-group flex-nowrap">
                                                <span class="input-group-text">
                                                    <i class="ti-unlock"></i>
                                                </span>
                                            <input type="password" class="form-control" placeholder="Password" id="password" name="password" value=""
                                        required>
                                        <button class="btn btn-dark togglePassword" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                        </div>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-unlock"></i>
                                                </span>
                                                <input type="password" name="confirm_password" id="confirm_password_new" class="form-control" placeholder="Confirm Password" required="" minlength="5" oninput="inputConfirmPassword(this)" style="border-color: rgb(230, 235, 245); background-color: rgb(255, 255, 255);">
                                                <button class="btn btn-dark togglePassword" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            
                                        </div>
                                    </div>
                        </div>

                        <div class="row" style="margin-top:10px;">
                                    <div class="col-12">
                                        <div class="form-group smalls">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="ti-ink-pen"></i>
                                                </span>
                                                <input type="text" id="branch_code_new" name="institute_code" class="form-control" placeholder="Branch Code" style="border-color: rgb(230, 235, 245); background-color: rgb(255, 255, 255);">
                                                <button class="btn theme-bg-dark text-white append" onclick="verifyInstitute()" type="button">
                                                    Verify
                                                </button>
                                                
                                            </div>
                                            <input type="text" id="institute_name" class="form-control" style="display: none;" readonly="" disabled="">
                                            <input id="verifystatus_institute" class="d-none" value="0">
                                        </div>
                                    </div>
                        </div>

                        <div class="col-12" style="margin-top:10px;">
                                        <div class="form-group smalls">
                                            <label>You can attach jpeg / png files (max size: 200 kb)</label>
                                            <input type="file" class="form-control" name="user_logo" id="user_logo">
                                        </div>
                                    </div>
                                
                                <!-- <div class="col-md-12">
                                        <div class="form-group smalls">
                                            <label>Username *</label>
                                            <input type="text" class="form-control" placeholder="Username" name="username"
                                        id="contributor_username" required>
                                        </div>
                                </div> -->
                                <div class="form-group col-12 mb-2" style="margin-top:10px;">
                                        <input class="checkbox-custom" id="required_check_registration" type="checkbox" required="">
                                        <label for="required_check_registration" class="checkbox-custom-label">I agree
                                            to The
                                            gyanology's <a href="#" class="theme-cl">Terms of
                                                Services</a></label>
                                    </div>
                                
                                <div class="col-md-12">
                                    <button class="btn btn-sm full-width theme-bg text-white" type="submit" style="margin-top:10px;margin-bottom:10px;">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    {{-- <div class="simple-input">
        <select id="cates" class="form-control">
            <option value="">&nbsp;</option>
            <option value="1">Parent</option>
            <option value="2">Banking</option>
            <option value="3">Medical</option>
            <option value="4">Insurence</option>
            <option value="5">Finance & Accounting</option>
        </select>
    </div> --}}
@endsection

@section('js')
    <script>
        $("#corporate_logo").change(function() {

            var photo = $("#corporate_logo").val();
            var ext = $("#corporate_logo").val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png']) == -1) {
                swal({
                    title: "Oh!Snap",
                    text: "Only Accept JPEG/JPG/PNG Files ",
                    icon: "error",
                    button: "close!",
                });
                $("#corporate_logo").val("");
                $("#corporate_logo").focus();

            } else {
                var file, img, height, width;
                var a = (this.files[0].size);
                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {
                        alert("width : " + this.width + " and height : " + this.height);
                        width = this.width;
                        height = this.height;
                        console.log(height);
                        console.log(width);

                    };
                }
                if (parseInt(width) > 1000 || parseInt(height) > 1000) {

                    swal({
                        title: "Oh!Snap",
                        text: "Image Width & Height Must be 1000px X 1000px",
                        icon: "error",
                        button: "close!",
                    });
                    $("#corporate_logo").val('');
                    $('#corporate_logo').closest('div').find('.custom-file-label').html('Choose File')
                    // $("#corporate_logo").focus();

                } else {

                    if ((Math.round(a) / 1024) > 200) {

                        swal({
                            title: "Oh!Snap",
                            text: "Image Size Must be under 200 KB",
                            icon: "error",
                            button: "close!",
                        });
                        $("#corporate_logo").val('');
                        $('#corporate_logo').closest('div').find('.custom-file-label').html('Choose File')
                        // $("#corporate_logo").focus();

                    } else {

                        //readURL(this);

                    }
                }
            }
        });
        // variables declaration
var studentEmailValid = false;
var studentMobileValid = false;
var studentPasswordValid = false;
        var corporateEmailValid = false;
        var corporateMobileValid = false;
        $('#institute_type').select2({
            maximumSelectionLength: 3
        });
        $('#interested_for').select2({
            maximumSelectionLength: 3
        });

        function franchiseStateSelected(event) {
            console.log(event.value);
            var formData = new FormData();
            formData.append('form_name', 'get_cities');
            formData.append('state_id', event.value);
            $.ajax({
                url: '/',
                data: formData,
                type: 'post',
                processData: false,
                contentType: false
            }).done(function(data) {
                console.log(data);
                // return;
                if (data != 'false') {
                    // var options = '<option value="">Cities</option>';
                    var options = '<option selected value=""></option>';
                    var cities = JSON.parse(data);
                    if (cities.length) {
                        $(cities).each(function(index, city) {
                            options += '<option value="' + city.id + '">' + city.name + '</option>';
                        });
                        $('#city_id_franchise').html(options);
                        $('#city_id_franchise').attr('required', 'required');
                        $('#citiesDiv').show();
                        initSelect2();
                    } else {
                        $('#citiesDiv').hide();
                        $('#city_id_franchise').html('');
                        $('#city_id_franchise').removeAttr('required');
                    }
                } else {
                    $('#citiesDiv').hide();
                    $('#city_id_franchise').html('');
                    $('#city_id_franchise').removeAttr('required');
                }
            }).fail(function(data) {
                $('#citiesDiv').hide();
                $('#city_id_franchise').html('');
                $('#city_id_franchise').removeAttr('required');
                console.log(data);
            });
        }
        $('#institute_user').submit(function(event) {
            event.preventDefault();
            $('#user_submit_button').html('Submitting...');
            var formData = new FormData($(this)[0]);
            formData.append('form_name', 'institute_user_form');
            if ($("#branch_code_new").val() != '' && $("#verifystatus_institute").val() == 0) {
                showAlert('Please validate branch name before continue.', 'Error', 'warning');
                return;
            }
            if (!studentPasswordValid || !studentEmailValid || !studentMobileValid) {
                var thisMessage = 'Please check your form again before submitting, there is errors in your form. or contact support.';
                if (!studentPasswordValid) {
                    thisMessage = 'Passwords not macthed, or invalid password type.';
                }
                if (!studentEmailValid) {
                    thisMessage = 'Unable to verify your email.';
                }
                if (!studentMobileValid) {
                    thisMessage = 'Mobile number is invalid, or otp is not verified.';
                }
                showAlert(thisMessage, 'Error', 'warning');
                return;
            }
            if ($('#verifystatus_register').val() == 1) {
                $.ajax({
                    url: '/',
                    data: formData,
                    processData: false,
                    type: 'post',
                    contentType: false
                }).done(function(data) {
                    console.log(data);
                    if (data['status'] == true) {
                        showAlert("Thank you, we will active your request soon.").then(() => {
                            $('#institute_user')[0].reset();
                        });
                    } else {
                        showAlert(data['message'], 'Error', 'error');
                    }
                }).fail(function(data) {
                    $('#user_submit_button').html('Submit');
                    showAlert('Server Error, please try again later.', 'Error', 'error');
                    console.log(data)
                })
            } else {
                $('#user_submit_button').html('Submit');
                showAlert('Verify your number first before continue.', 'Error', 'warning');
            }
        });

        function inputConfirmPassword(event) {
	validatePassword(event)
	if (checkPasswordmatch()) {
		$('#password').css('border-color', '#198754');
		$(event).css('border-color', '#198754');
		studentPasswordValid = true;
	} else {
		$('#password').css('border-color', 'crimson');
		$(event).css('border-color', 'crimson');
		studentPasswordValid = false;
	}
}
function checkPasswordmatch() {
	if ($('#password').val() == $('#confirm_password_new').val()) {
		studentPasswordValid = true;
		return true;
	}
	studentPasswordValid = false;
	return false;
}

function verifyInstitute() {
            var branch_code_new = $('#branch_code_new').val();
            var formData = new FormData();
            formData.append('form_name', 'branch_code_confirm');
            formData.append('branch_code', branch_code_new);
            $.ajax({
                url: '/',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(function(data, textStatus) {
                console.log(data);
                if (data == 'false') {
                    $('#verifystatus_institute').val(0);
                    $('#branch_code_new').removeAttr('readonlny');
                    $('#institute_name').val('');
                    $('#institute_name').hide();
                    showAlert('Branch Code Not Exist!.', 'Not Found', 'error');

                } else { 
                    $('#verifystatus_institute').val(1);
                    $('#branch_code_new').attr('readonlny', 'readonlny');
                    $('#institute_name').val(JSON.parse(data));
                    $('#institute_name').show();
                }
            }).fail(function(data, textStatus) {
                console.log(data);
            })
        }

        function uniqueEmailCheck(event, type) {
	var emailInput = $(event);
	if (validateEmail(emailInput.val())) {
		var formData = new FormData();
		formData.append('form_name', 'unique_email_check');
		formData.append('email', emailInput.val());
		formData.append('type', type);
		console.log(Array.from(formData));
		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data)
			if (data == true) {
				businessEmailCheck = false;
				studentEmailValid = false;
				showAlert('Email Already in use.', 'In Use', 'error');
				$(event).css('border-color', 'crimson')
			} else {
				businessEmailCheck = true;
				studentEmailValid = true;
				$(event).css('border-color', '#198754')
			}
		}).fail(function (data) {
			console.log(data)
		});
	} else {
		businessEmailCheck = false;
		studentEmailValid = false;
		$(event).css('border-color', 'crimson')
	}
}
    </script>
@endsection
