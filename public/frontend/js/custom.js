/* ..............................................
	Loader 
	................................................. */

var select2Options = {}
if ($('.select2').length) {
	$('.select2').select2(select2Options);
}
$(window).on('load', function () {
	$('.preloader').fadeOut();
	$('#preloader').delay(550).fadeOut('slow');
	$('body').delay(450).css({
		'overflow': 'visible'
	});
});
const csrfToken = $('meta[name="_token"]').attr('content');
$.ajaxSetup({
	headers: {
		'X-CSRF-Token': csrfToken
	}
});

$(window).on('scroll', function () {
	if ($(window).scrollTop() > 50) {
		$('.main-header').addClass('fixed-menu');
	} else {
		$('.main-header').removeClass('fixed-menu');
	}
});

$(window).on('scroll', function () {
	if ($(this).scrollTop() > 100) {
		$('#back-to-top').fadeIn();
	} else {
		$('#back-to-top').fadeOut();
	}
});
$('#back-to-top').click(function () {
	$("html, body").animate({
		scrollTop: 0
	}, 600);
	return false;
});

var Container = $('.container');
Container.imagesLoaded(function () {
	var portfolio = $('.special-menu');
	portfolio.on('click', 'button', function () {
		$(this).addClass('active').siblings().removeClass('active');
		var filterValue = $(this).attr('data-filter');
		$grid.isotope({
			filter: filterValue
		});
	});
	var $grid = $('.special-list').isotope({
		itemSelector: '.special-grid'
	});
});

$(window).on('scroll', function () {
	if ($(this).scrollTop() > 100) {
		$('#back-to-top').fadeIn();
	} else {
		$('#back-to-top').fadeOut();
	}
});
$('#back-to-top').click(function () {
	$("html, body").animate({
		scrollTop: 0
	}, 600);
	return false;
});

$(".panel-collapse").fadeOut(0);
$(".panel-heading").click(function () {
	$(".panel-collapse").not($(this).next()).slideUp(400);
	$(this).next4().slideToggle(400);
});

$(".wislist a").click(function () {
	$(".side-wish").addClass("on");
})

$(".close-side").click(function () {
	$(".side-wish").removeClass("on")
})

function loginModal() {
	$("#loginModal").modal('show');
	$("#registrationModal").modal('hide');
}

function corporate_login() {
	$("#loginModal").modal('show');
	$("#corporateModal").modal('hide');
}

$(".dropdown dt a").on('click', function () {
	$(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function () {
	$(".dropdown dd ul").hide();
});
$(document).on("click", function (e) {
	var $clicked = $(e.target);
	if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$(".dropdown1 dt a").on('click', function () {
	$(".dropdown1 dd ul").slideToggle('fast');
});

$(".dropdown1 dd ul li a").on('click', function () {
	$(".dropdown1 dd ul").hide();
});
$(document).on("click", function (e) {
	var $clicked = $(e.target);
	if (!$clicked.parents().hasClass("dropdown1")) $(".dropdown1 dd ul").hide();
});

var _URL = window.URL || window.webkitURL;

$.validator.addMethod("checklower", function (value) {
	return /[a-z]/.test(value);
});
$.validator.addMethod("checkupper", function (value) {
	return /[A-Z]/.test(value);
});
$.validator.addMethod("checkdigit", function (value) {
	return /[0-9]/.test(value);
});
$.validator.addMethod("pwcheck", function (value) {
	return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/.test(value) &&
		/[A-Z]/.test(value);
});

// global function & method
function togglePassword(passwordId, spanId) {
	var showPassIcon = '<i id="eyeIcon" class="fa fa-eye"></i>';
	var hidePassIcon = '<i id="eyeIcon" class="fa fa-eye-slash"></i>';
	var passInput = $('#' + passwordId);
	var spanInput = $('#' + spanId);
	if (passInput.attr('type') == 'password') {
		passInput.attr('type', 'text');
		spanInput.html(hidePassIcon);
	} else {
		passInput.attr('type', 'password');
		spanInput.html(showPassIcon);
	}
}

// $("[name='state_id']").select2({
// 	placeholder: "Select State*",
// 	dropdownParent: $('.modal')
// })

function uniqueEmailCheck(event, type) {
	var emailInput = $(event);
	var formData = new FormData();
	formData.append('form_name', 'unique_email_check');
	formData.append('email', emailInput.val());
	console.log(Array.from(formData));
	$.ajax({
		url: '/',
		data: formData,
		processData: false,
		type: 'post',
		contentType: false
	}).done(function (data) {
		console.log(data)
		if (data == 'true') {
			corporateFormIsValid = false;
			studentEmailValid = false;
			showAlert('Email Already in use.', 'In Use', 'error');
			$(event).css('border-color', 'crimson')
		} else {
			corporateFormIsValid = true;
			studentEmailValid = true;
			$(event).css('border-color', '#198754')
		}
	}).fail(function (data) {
		console.log(data)
	});
}
function mobileNumberCheck(event, type) {
	var mobileInput = $(event);
	var formData = new FormData();
	if (mobileInput.val().toString().length > 9) {
		formData.append('form_name', 'unique_mobile_check');
		formData.append('mobile', mobileInput.val());
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
			if (data == 'true') {
				corporateFormIsValid = false;
				studentMobileValid = false;
				if (type == 'corporate') {
					showAlert(
						'Mobile number Already in use. Please contact support from contact page along with your BRANCH code and all the information which you use to query before.',
						'In Use', 'error');
				} else {
					showAlert('Mobile number Already in use.', 'In Use', 'error');
				}
				$(event).css('border-color', 'crimson')
			} else {
				corporateFormIsValid = true;
				studentMobileValid = true;
				$(event).css('border-color', '#198754')
			}
		}).fail(function (data) {
			console.log(data)
		});
	}
}
function sendOtp(type) {
	if (type == 'register') {
		if (!studentMobileValid) {
			showAlert('Please input valid mobile number.', 'Mobile Invalid', 'error');
			return;
		}
	}
	if (type == 'corporate') {
		if (!corporateMobileValid) {
			showAlert('Please input valid mobile number.', 'Mobile Invalid', 'error');
			return;
		}
	}
	var verifystatus = $('#verifystatus_' + type);
	var mobile_input = $("#mobile_" + type);
	var mobile_otp_new = $("#mobile_otp_" + type);
	var mobileNumber = parseInt(mobile_input.val());

	verifystatus.val(0);
	console.log(mobileNumber);
	var mobileStr = mobileNumber.toString();
	console.log(mobileStr.length);

	if (!mobileNumber || mobileStr.length > 10 || mobileStr.length < 10) {
		showAlert('10 digit mobile no is required', 'Error', 'warning');
		mobile_input.css('border-color', 'crimson');
		mobile_input.css('background-color', 'yellow');
	} else {
		// return;
		var formData = new FormData();
		formData.append('form_name', 'mobile_otp');
		formData.append('mobile', mobileNumber);
		$.ajax({
			url: '/',
			data: formData,
			type: 'post',
			processData: false,
			contentType: false
		}).done(function (data) {
			console.log(data);
			// return;
			if (data) {
				var response = JSON.parse(data);
				// alert('Success');
				var lastFour = mobileStr.substr(mobileStr.length - 4);
				var message = "An OTP has been sent to your mobile number +91XXXXXX" + lastFour + " and OTP is valid for 10 minutes"
				if(response['success']) {
					showAlert(message, "OTP Send!", "info").then((willDelete) => {
						if (willDelete) {
							mobile_otp_new.focus();
						} else {
							mobile_otp_new.focus();
						}
					});
					mobile_input.css('border-color', '#2e3092');
					mobile_input.css('background-color', 'none');
				} else {
					showAlert(response.message, "Info!", "info").then((willDelete) => {
						if (willDelete) {
							mobile_otp_new.focus();
						} else {
							mobile_otp_new.focus();
						}
					});
					mobile_input.css('border-color', '#2e3092');
					mobile_input.css('background-color', 'none');
				}
			} else {
				showAlert('Server issue, please try again later.', 'Error', 'error');
				// alert('Server Error');
			}
		}).fail(function (data) {
			showAlert('Server error, please try again later.', 'Error', 'error');
			// alert('Server Error');
			console.log(data);
		})
	}
}
function verifyOtp(type) {
	var mobileInput = $('#mobile_' + type);
	var mobileOtpInput = $('#mobile_otp_' + type);
	var mobileNumber = parseInt(mobileInput.val());
	var mobileOtp = parseInt(mobileOtpInput.val());
	var verifystatus = $('#verifystatus_' + type);

	verifystatus.val(0);
	console.log(mobileNumber);
	var formData = new FormData();
	formData.append('form_name', 'verify_otp');
	formData.append('mobile', mobileNumber);
	formData.append('otp', mobileOtp);
	formData.append('type', 'mobile');
	$.ajax({
		url: '/',
		data: formData,
		type: 'post',
		processData: false,
		contentType: false
	}).done(function (data) {
		console.log(data);
		// return;
		if (data == 'true') {
			showAlert('OTP verified.');
			mobileInput.attr('readonly', 'readonly');
			mobileOtpInput.attr('readonly', 'readonly');
			verifystatus.val(1);
			// alert('Success');
		} else {
			// alert('Server Error');
			showAlert('OTP not verified.', 'Error', 'warning');
			mobileInput.removeAttr('readonly');
			mobileOtpInput.removeAttr('readonly');
			verifystatus.val(0);
		}
	}).fail(function (data) {
		// alert('Server Error');
		showAlert('Server error, please try later.', 'Error', 'warning');
		mobileInput.removeAttr('readonly');
		mobileOtpInput.removeAttr('readonly');
		verifystatus.val(0);
		console.log(data);
	})
}
function showAlert(text, title = 'Success', icon = 'success', button = 'Ok') {
	return swal({
		title,
		text,
		icon,
		button
	});
}

// corporate ONLY
var corporateEmailValid = true;
var corporateMobileValid = true;
var corporateModal = document.getElementById('corporateModal');
corporateModal.addEventListener('show.bs.modal', function (event) {
	$('#corporate')[0].reset();
	$('#verifystatus_corporate').val(0);
	$('#mobile_corporate_otp_new').removeAttr('readonly');
	$('#mobile_corporate').removeAttr('readonly');
});
corporateModal.addEventListener('hide.bs.modal', function (event) {
	$('#corporate')[0].reset();
	$('#verifystatus_corporate').val(0);
	$('#mobile_corporate_otp_new').removeAttr('readonly');
	$('#mobile_corporate').removeAttr('readonly');
});
$('#institute_type').select2({
	placeholder: "Type of Institution*",
	maximumSelectionLength: 2
});
$('#interested_for').select2({
	placeholder: "Interested For*",
	maximumSelectionLength: 2
});
$("#branch_confirm").click(function () {
	var branch_code = $("#branch_code_new").val();
	if (branch_code == "" || branch_code == null) {
		$("#branch_code_error_new").text("Branch Code is required");
		$("#branch_code_new").css('background-color', 'yellow');
		showAlert('Please enter valid branch code if you have, or leave blank.', 'Error', 'warning');
	} else {

		var formData = new FormData();
		formData.append('form_name', 'branch_code_confirm');
		formData.append('branch_code', branch_code);
		$.ajax({
			url: '/',
			data: formData,
			type: 'post',
			processData: false,
			contentType: false,
			success: function (data) {
				if (data == 'false') {

					$("#branch_code_new").css('background-color', 'yellow');

					showAlert('Please enter valid Branch Code', 'Error', 'warning');
				} else {

					$("#branch_code_new").css('background-color', 'none');
					$("#branch_name").val(JSON.parse(data));
					$('#is_valid_branch').val(1);

					showAlert('Your Branchcode is Valid');
				}

			}
		});

	}

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
	}).done(function (data) {
		console.log(data);
		// return;
		if (data != 'false') {
			var options = '<option selected value="">Select City</option>';
			var cities = JSON.parse(data);
			if (cities.length) {
				$(cities).each(function (index, city) {
					options += '<option value="' + city.id + '">' + city.name + '</option>';
				});
				$('#city_id_franchise').html(options);
				$('#city_id_franchise').attr('required', 'required');
				$('#citiesDiv').show();
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
	}).fail(function (data) {
		$('#citiesDiv').hide();
		$('#city_id_franchise').html('');
		$('#city_id_franchise').removeAttr('required');
		console.log(data);
	});
}
$('#corporate').submit(function (event) {
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	console.log(Array.from(formData));
	formData.append('form_name', 'corporate_form');
	if ($('#verifystatus_corporate').val() == 1) {
		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data);
			if (data == 'true') {
				showAlert("Thank you, we will reach back to you within 72 hours.").then(() => {
					$("#corporateModal").modal('hide');
				});
			} else {
				showAlert('Server issue, please try again later.', 'Error', 'error');
			}
		}).fail(function (data) {
			showAlert('Server Error, please try again later.', 'Error', 'error');
			console.log(data)
		})
	} else {
		showAlert('Verify your number first before continue.', 'Error', 'warning');
	}
});

// REGISTRATION ONLY
var studentEmailValid = true;
var studentMobileValid = true;
var studentPasswordValid = true;
var registrationModal = document.getElementById('registrationModal')
registrationModal.addEventListener('show.bs.modal', function (event) {
	$('#registration')[0].reset();
	$('#verifystatus_register').val(0);
	$('#mobile_otp_register').removeAttr('readonly');
	$('#mobile_register').removeAttr('readonly');
});
registrationModal.addEventListener('hide.bs.modal', function (event) {
	$('#registration')[0].reset();
	$('#verifystatus_register').val(0);
	$('#mobile_otp_register').removeAttr('readonly');
	$('#mobile_register').removeAttr('readonly');
});
var verifyusername = $('#verifyusername_register');
var statusUsername = $('#statusUsername');
var usernameError = $('#userid_new_error');
$('#userid_new').on('input', function () {
	var user_name_str = $(this).val();
	var string = user_name_str.replace(/[^a-z0-9]/gi, '');
	var lowerCased = string.toLowerCase();
	$(this).val(lowerCased);
	var input = lowerCased.toString();
	var error1 = 'Username should be minimum 8 characters.';
	var error2 = 'Username already taken, please choose another.';
	if (input.length > 7) {
		usernameError.hide();
		console.log(input);

		var usernameIcon = $('#usernameIcon');
		var spinIcon = '<i class="text-primary fas fa-sync fa-spin"></i>';
		var checkIcon = '<i class="text-success fa fa-check"></i>';
		var crossIcon = '<i class="text-danger fa fa-times"></i>';

		var formData = new FormData();
		formData.append('form_name', 'student_username_check');
		formData.append('username', input);
		console.log(Array.from(formData));

		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false,
			beforeSend: function () {
				verifyusername.val(0);
				usernameIcon.html(spinIcon);
				statusUsername.show();
			}
		}).done(function (data) {
			console.log(data)
			if (data == 'true') {
				usernameIcon.html(crossIcon);
				usernameError.html(error2);
				usernameError.show();
				verifyusername.val(0);
			} else {
				verifyusername.val(1);
				usernameIcon.html(checkIcon);
				usernameError.html();
				usernameError.hide();
			}
		}).fail(function (data) {
			console.log(data)
		});
	} else {
		usernameError.html(error1);
		usernameError.show();
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
function branchRemove() {
	$('#branch_name').val('');
}
function branchCheck() {
	$('#branchRemove').hide();
}
function validatePassword(event) {
	var passwordStr = $(event).val().toString();
	if (passwordStr.length > 7) {
		$(event).css('border-color', '#198754');
		studentPasswordValid = true;
	} else {
		$(event).css('border-color', 'crimson');
		studentPasswordValid = false;
	}
}
function registerStateSelected(event) {
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
	}).done(function (data) {
		console.log(data);
		// return;
		if (data != 'false') {
			var options = '<option selected value="">Select City</option>';
			var cities = JSON.parse(data);
			if (cities.length) {
				$(cities).each(function (index, city) {
					options += '<option value="' + city.id + '">' + city.name + '</option>';
				});
				$('#city_id_register').html(options);
				$('#city_id_register').attr('required', 'required');
				$('#citiesRegisterDiv').show();
			} else {
				$('#citiesDiv').hide();
				$('#city_id_register').html('');
				$('#city_id_register').removeAttr('required');
			}
		} else {
			$('#citiesRegisterDiv').hide();
			$('#city_id_register').html('');
			$('#city_id_register').removeAttr('required');
		}
	}).fail(function (data) {
		$('#citiesRegisterDiv').hide();
		$('#city_id_register').html('');
		$('#city_id_register').removeAttr('required');
		console.log(data);
	});
}
$('#registration').submit(function (event) {
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('form_name', 'registration_form');
	console.log(Array.from(formData));
	// return;
	if ($('#verifystatus_register').val() == 1) {
		if ($("#branch_code_new").val() != '' && $("#is_valid_branch").val() == 0) {
			showAlert('Please validate branch name before continue.', 'Error', 'warning');
			return;
		}
		if (!studentPasswordValid || !studentEmailValid || !studentMobileValid) {
			showAlert(
				'Please check your form again before submitting, there is errors in your form. or contact support.',
				'Error', 'warning');
			return;
		}
		$.ajax({
			url: '/',
			data: formData,
			processData: false,
			type: 'post',
			contentType: false
		}).done(function (data) {
			console.log(data);
			console.log(JSON.parse(data));
			// return;
			if (data == 'true') {
				var message = 'You are successfully registered, please login to continue.';
				if ($("#branch_code_new").val() != '' && $("#is_valid_branch").val() == 0) {
					message = 'Registeration succesfully goes to institute, please contact for activation.'
				}
				showAlert(message, "Registered").then(() => {
					$("#registrationModal").modal('hide');
					$("#loginModal").modal('show');
				});
			} else {
				showAlert('Server issue, please try again later.', 'Error', 'error');
			}
		}).fail(function (data) {
			showAlert('Server error, please try again later.', 'Error', 'error');
			console.log(data)
		});
	} else {
		showAlert('Verify your mobile number before continue', 'Error', 'warning');
	}
});

// LOGIN ONLY
$('#userlogin').submit(function (event) {
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('form_name', 'login_form');
	console.log(Array.from(formData));
	$.ajax({
		url: '/',
		data: formData,
		processData: false,
		type: 'post',
		contentType: false
	}).done(function (data) {
		console.log(data);
		// return;
		if (data == 'true') {
			window.location = '/student';
		} else {
			showAlert('Server issue, please try again later.', 'Error', 'error');
		}
	}).fail(function (data) {
		showAlert('Server fail, please try again later.', 'Error', 'error');
		console.log(data)
	});
})

// BRANCH SIGNUP ONLY
var branchCodeVerify = $('#branchCodeVerify');
var branchMobileVerify = $('#branchMobileVerify');
var branchEmailVerify = $('#branchEmailVerify');
var branchModal = document.getElementById('franchiseSignupModal');
branchModal.addEventListener('show.bs.modal', function (event) {
	$('#corporate_regis')[0].reset();
	branchCodeVerify.val(0);
	branchMobileVerify.val(0);
	branchEmailVerify.val(0);
});
branchModal.addEventListener('hide.bs.modal', function (event) {
	$('#corporate_regis')[0].reset();
	branchCodeVerify.val(0);
	branchMobileVerify.val(0);
	branchEmailVerify.val(0);
});

//--------------------------------------------------//

$("#corporate_logo").change(function () {

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
			img.onload = function () {
				//alert("width : "+this.width + " and height : " + this.height);
				width = this.width;
				height = this.height;
				console.log(height);
				console.log(width);

			};
			img.src = _URL.createObjectURL(file);
		}
		if (parseInt(width) > 1000 || parseInt(height) > 1000) {

			swal({
				title: "Oh!Snap",
				text: "Image Width & Height Must be 1000px X 1000px",
				icon: "error",
				button: "close!",
			});
			$("#corporate_logo").val("");
			$("#corporate_logo").focus();

		} else {

			if ((Math.round(a) / 1024) > 100) {

				swal({
					title: "Oh!Snap",
					text: "Image Size Must be under 100 KB",
					icon: "error",
					button: "close!",
				});
				$("#corporate_logo").val("");
				$("#corporate_logo").focus();

			} else {

				//readURL(this);

			}
		}
	}
});
$("#corporat_regis_logo").change(function () {

	var photo = $("#corporat_regis_logo").val();
	var ext = $("#corporat_regis_logo").val().split('.').pop().toLowerCase();
	if ($.inArray(ext, ['jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png', 'PDF', 'pdf', 'doc', 'docx',
		'DOC', 'DOCX', 'xlsx', 'XLSX', 'XLS', 'xls'
	]) == -1) {
		swal({
			title: "Oh!Snap",
			text: "Only Accept JPEG/JPG/PNG/PDF/DOC/EXCEL Files ",
			icon: "error",
			button: "close!",
		});
		$("#corporat_regis_logo").val("");
		$("#corporat_regis_logo").focus();

	} else {
		var file, img, height, width;
		var a = (this.files[0].size);
		if ((file = this.files[0])) {
			img = new Image();
			img.onload = function () {
				//alert("width : "+this.width + " and height : " + this.height);
				width = this.width;
				height = this.height;
				console.log(height);
				console.log(width);

			};
			img.src = _URL.createObjectURL(file);
		}
		if (parseInt(width) > 1000 || parseInt(height) > 1000) {

			swal({
				title: "Oh!Snap",
				text: "Image Width & Height Must be 1000px X 1000px",
				icon: "error",
				button: "close!",
			});
			$("#corporat_regis_logo").val("");
			$("#corporat_regis_logo").focus();

		} else {

			if ((Math.round(a) / 1024) > 100) {

				swal({
					title: "Oh!Snap",
					text: "Image Size Must be under 100 KB",
					icon: "error",
					button: "close!",
				});
				$("#corporat_regis_logo").val("");
				$("#corporat_regis_logo").focus();

			} else {

				//readURL(this);

			}
		}
	}
});
$("#user_logo").change(function () {

	var photo = $("#user_logo").val();
	var ext = $("#user_logo").val().split('.').pop().toLowerCase();
	if ($.inArray(ext, ['jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png']) == -1) {
		swal({
			title: "Oh!Snap",
			text: "Only Accept JPEG/JPG/PNG Files ",
			icon: "error",
			button: "close!",
		});
		$("#user_logo").val("");
		$("#user_logo").focus();

	} else {
		var file, img, height, width;
		var a = (this.files[0].size);
		if ((file = this.files[0])) {
			img = new Image();
			img.onload = function () {
				//alert("width : "+this.width + " and height : " + this.height);
				width = this.width;
				height = this.height;
				console.log(height);
				console.log(width);

			};
			img.src = _URL.createObjectURL(file);
		}
		if (parseInt(width) > 1000 || parseInt(height) > 1000) {

			swal({
				title: "Oh!Snap",
				text: "Image Width & Height Must be 1000px X 1000px",
				icon: "error",
				button: "close!",
			});
			$("#user_logo").val("");
			$("#user_logo").focus();

		} else {

			if ((Math.round(a) / 1024) > 100) {

				swal({
					title: "Oh!Snap",
					text: "Image Size Must be under 100 KB",
					icon: "error",
					button: "close!",
				});
				$("#user_logo").val("");
				$("#user_logo").focus();

			} else {

				//readURL(this);

			}
		}
	}
});

$(".btnrating").on('click', (function (e) {

	var previous_value = $("#selected_rating").val();

	var selected_value = $(this).attr("data-attr");
	$("#selected_rating").val(selected_value);

	$(".selected-rating").empty();
	$(".selected-rating").html(selected_value);

	for (i = 1; i <= selected_value; ++i) {
		$("#rating-star-" + i).toggleClass('btn-warning');
		$("#rating-star-" + i).toggleClass('btn-default');
	}

	for (ix = 1; ix <= previous_value; ++ix) {
		$("#rating-star-" + ix).toggleClass('btn-warning');
		$("#rating-star-" + ix).toggleClass('btn-default');
	}

}));

// function loginModal() {
// 	$("#loginModal").modal({
// 		backdrop: "static",
// 		keyboard: false,
// 	});
// 	$("#registrationModal").modal("hide");
// }

// function corporate_login() {
// 	$("#loginModal").modal("show");
// 	$("#corporateModal").modal("hide");
// }
