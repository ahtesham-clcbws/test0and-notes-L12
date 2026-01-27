<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/sweetalert2/sweetalert2.min.css') }}">
    @yield('css')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('super/style.css') }}"> --}}
    <style>
        .franchise-dashboard .custom-dash-card {
            box-shadow: 0px 0px 5px 1px #888888 !important;
            border-radius: 10px !important;
            border: 1px solid black !important;
            margin-bottom: 1rem;
        }
        .franchise-dashboard .custom-dash-card .number,
        .franchise-dashboard .custom-dash-card .action_required a {
            color: red;
        }
    </style>
</head>

<body>

    @include('Dashboard.Franchise.partials.mainheader')

    <div class="container-fluid">
        <div class="row">
            @include('Dashboard.Franchise.partials.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="pt-3 pb-2 custom-dashboard">
                    <div class="w-100 dashboard-header mb-4">
                        <h2 class="d-inline-block">
                            <i class="bi bi-{{ isset($pageicon) ? $pageicon : 'house-fill' }}"></i>
                            {{ isset($data['pagename']) ? $data['pagename'] : 'Corporate Dashboard' }}
                        </h2>
                    </div>
                    @yield('main')
                </div>
            </main>
        </div>
    </div>


    @if (session()->has('loginSuccess'))
        <div class="toast align-items-center text-white bg-primary border-0 position-absolute bottom-0 end-0 mb-3"
            role="alert" aria-live="assertive" aria-atomic="true" id="myToastEl">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('loginSuccess') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif

    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
    <!-- <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('frontend/sweetalert2/sweetalert2.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfToken
            }
        });
        feather.replace({
            'aria-hidden': 'true'
        })
        if (document.getElementById('myToastEl')) {
            var myToastEl = document.getElementById('myToastEl');
            var myToast = new bootstrap.Toast(myToastEl)
            myToast.show();
        }
        $(".flatpickr").flatpickr({
            altInput: true,
            altFormat: "j F, Y",
            minDate: "today",
        });
        $(".flatpickrtime").flatpickr({
            altInput: true,
            altFormat: "j F, Y - H:i K",
            enableTime: true,
            minDate: "today",
            minTime: "10:00",
        });
        $('.validate').keyup(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid')
                $(this).removeClass('is-valid')
            } else {
                $(this).removeClass('is-invalid')
                $(this).addClass('is-valid')
            }
        });

        function showAlert(text, title = 'Success', icon = 'success', button = 'Ok') {
	return swal({
		title,
		text,
		icon,
		button
	});
}
var studentMobileValid = true;
function mobileNumberCheck(event, type) {
	var mobileInput = $(event);
	var formData = new FormData();
	if (mobileInput.val().toString().length > 9) {
		formData.append('form_name', 'unique_mobile_check');
		formData.append('mobile', mobileInput.val());
		formData.append('type', type);
		formData.append('_token', csrfToken);
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
	var mobile_input = $("#contributor_mobile");
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
	var mobileInput = $('#contributor_mobile');
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
		if (data == true) {
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

var class_group = <?php if(isset($class)) echo $class; else echo 0; ?>;
var board = <?php if(isset($board)) echo $board; else echo 0; ?>;
var other_exam = <?php if(isset($other_exam)) echo $other_exam; else echo 0; ?>;
var subject = <?php if(isset($subject)) echo $subject; else echo 0; ?>;
var subject_part = <?php if(isset($subject_part)) echo $subject_part; else echo 0; ?>;

async function getClassesByEducation(educationId) {
    console.log(educationId);
    var formData = new FormData();
    formData.append('form_name', 'get_classes');
    formData.append('education_id', educationId);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const classes = data.message;
            var options = '<option value="">Class / Group / Exam</option>';
            if (classes.length > 0) {
                $(classes).each(function (index, item) {
                    // var boards = JSON.parse(item.boards).join();
                    var selected = '';
                    if(class_group == item.id){
                        selected = 'selected';
                    }
                    options += '<option value="' + item.id + '" '+selected+'>' + item.name + '</option>';
                });
                $('#class_group_exam_id').removeAttr('disabled');
            } else {
                $('#class_group_exam_id').val('');
                $('#class_group_exam_id').attr('disabled', 'disabled');
                alert('No classes / Groups or Exams in this Type, please select another, or add some.');
            }
            $('#class_group_exam_id').html(options);
            if(class_group != 0)
                $('#class_group_exam_id').trigger('change');
        } else {
            alert(data.message);
			}
		}).fail(function (data) {
			console.log(data);
		})
}

async function classes_group_exams_change(id) {
    var education_type_id = $("#education_type_id").val();
    var formData = new FormData();
    formData.append('form_name', 'get_agency_board_university');
    formData.append('education_type_id', education_type_id);
    formData.append('classes_group_exams_id', id);
    console.log("value:",education_type_id,id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value="">Exam Agency/Board/University</option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    var selected = '';
                    if(board == item.id){
                        selected = 'selected';
                    }
                    options += '<option value="' + item.id + '" '+selected+'>' + item.name + '</option>';
                });
                $('#exam_agency_board_university_id').removeAttr('disabled');
            } else {
                $('#exam_agency_board_university_id').val('');
                $('#exam_agency_board_university_id').attr('disabled', 'disabled');
                alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#exam_agency_board_university_id').html(options);
            if(board != 0)
                $('#exam_agency_board_university_id').trigger('change');
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function exam_agency_board_university_change(id) {

    var education_type_id       = $("#education_type_id").val();
    var classes_group_exams_id  = $('#class_group_exam_id').val();
    var class_boards_id         = id;

    var formData = new FormData();
    formData.append('form_name', 'get_other_exam_class_detail');
    formData.append('education_type_id', education_type_id);
    formData.append('classes_group_exams_id',classes_group_exams_id);
    formData.append('class_boards_id',class_boards_id);

    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        if (data && data.success) {
            const agency_board_university = data.message;
            var options = '<option value="">Other Exam/ Class Detail</option>';
            if (agency_board_university.length > 0) {
                $(agency_board_university).each(function (index, item) {
                    var selected = '';
                    if(other_exam == item.id){
                        selected = 'selected';
                    }
                    options += '<option value="' + item.id + '" '+selected+'>' + item.name + '</option>';
                });
                $('#other_exam_class_detail_id').removeAttr('disabled');
            } else {
                $('#other_exam_class_detail_id').val('');
                // $('#class_other_exam_detail').attr('disabled', 'disabled');
                // alert('Exam Agency/ Board/ University in this Class/ Group/ Exam Name, please select another, or add some.');
            }
            $('#other_exam_class_detail_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function partClassChange(class_id) {
    var formData = new FormData();
    formData.append('form_name', 'get_parts_subject');
    formData.append('class_id', class_id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value="">Select Subject</option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    var selected = '';
                    if(subject == item.id){
                        selected = 'selected';
                    }
                    options += '<option value="' + item.id + '" '+selected+'>' + item.name + '</option>';
                });
                $('#part_subject_id').removeAttr('disabled');
            } else {
                $('#part_subject_id').val('');
                $('#part_subject_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#part_subject_id').html(options);
            if(subject != 0)
                $('#part_subject_id').trigger('change');
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}

async function lessonSubjectChange(id) {
    console.log(id);
    var class_id = $("#class_group_exam_id").val();
    var formData = new FormData();
    formData.append('form_name', 'get_subject_parts');
    formData.append('class_id', class_id);
    formData.append('subject_id', id);
    await $.ajax({
        url: '/',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const subjectParts = data.message;
            var options = '<option value="" default selected> Select Subject Part</option>';
            if (subjectParts.length > 0) {
                $(subjectParts).each(function (index, item) {
                    var selected = '';
                    if(subject_part == item.id){
                        selected = 'selected';
                    }
                    options += '<option value="' + item.id + '" '+selected+'>' + item.name + '</option>';
                });
                $('#lesson_subject_part_id').removeAttr('disabled');
            } else {
                $('#lesson_subject_part_id').val('');
                $('#lesson_subject_part_id').attr('disabled', 'disabled');
                alert('No Subject parts in this subject, please select another, or add some.');
            }
            $('#lesson_subject_part_id').html(options);
        } else {
            alert(data.message);
        }
    }).fail(function (data) {
        console.log(data);
    })
}
    </script>
    @yield('javascript')
</body>

</html>
