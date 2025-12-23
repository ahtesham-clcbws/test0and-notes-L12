<!DOCTYPE html>
<html lang="en">
    <!-- Basic -->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <!-- Site Metas -->
        <title>{{ env('APP_NAME') }}</title>
        <!-- Site Icons -->
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="icon">
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="shortcut-icon">
        <link href="{{ asset('logos/logo-white-square.png') }}" rel="apple-touch-icon">
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Sansita:wght@400;700&display=swap" rel="stylesheet">

        <link href="{{ asset('skillup/css/styles.css') }}" rel=" stylesheet">

        <style>
            .nav-submenu {
                max-height: 80vh;
                overflow: hidden auto;
            }
        </style>
        <style>
            .footer {
                background-color: #000;
                color: #fff;
                padding-top: 20px;
                font-family: 'Arial', sans-serif;
                /* Update this to match the font style */
            }

            .footer .logo img {
                max-width: 150px;
                /* Adjust the size of the logo */
            }

            .footer h5 {
                font-weight: bold;
                font-family: 'Arial Black', Gadget, sans-serif;
                /* Closely matches the bold and strong font */
            }

            .footer p,
            .footer a,
            .footer address {
                font-size: 14px;
                line-height: 24px;
                font-weight: 400;
                /* Regular weight for text */
            }

            .footer a {
                color: #fff;
                text-decoration: none;
                font-weight: 600;
                /* Slightly bolder for links */
            }

            .footer a:hover {
                text-decoration: underline;
            }

            .footer hr {
                border-color: #555;
            }

            .footer .text-center {
                margin-top: 20px;
                font-size: 12px;
                font-weight: 400;
                /* Regular weight for copyright text */
            }

            .call_action_wrap {
                height: 2px;
                /* Change this value to adjust the height */
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            #userid_new_error,
            #statusUsername,
            #citiesRegisterDiv {
                display: none;
            }

            #branchRemove,
            #branchcehck {
                cursor: pointer;
            }

            span.select2-selection.select2-selection--single {
                height: 33px;
            }

            .noDisplay {
                display: none;
            }

            .pointerCursor {
                cursor: pointer;
            }

            .login-form .form-control {
                height: inherit;
            }

            #branchRemove,
            #branchcehck {
                cursor: pointer;
            }

            /* Import custom fort */
            @font-face {
                font-family: arial_bold;
                src: url(<?= asset('fonts/ARLRDBD.ttf') ?>);
            }

            /* Import custom fort */
            @font-face {
                font-family: bree_serif;
                src: url(<?= asset('fonts/BreeSerif-Regular.ttf') ?>);
            }

            /* Import custom fort */
            @font-face {
                font-family: geometric_black_bt;
                src: url(<?= asset('fonts/geometric_415_black_bt.ttf') ?>);
            }

            .font-family-arial-bold {
                font-family: arial_bold;
            }

            .font-family-bree-serif {
                font-family: bree_serif;
            }

            .font-family-geometric-black-bt {
                font-family: geometric_black_bt;
            }

            .swal2-container {
                z-index: 20000 !important;
            }
            body.swal2-toast-shown .swal2-container {
                pointer-events: none;
            }
            body.swal2-toast-shown .swal2-popup {
                pointer-events: auto;
            }
        </style>

        @yield('css')

        @php
            $education_types = education_types();
            $gn_EduTypes = gn_EduTypes();
            $gn_EduTest = gn_EduTest();
            $classes_groups_exams = classes_groups_exams();
        @endphp
    </head>

    <body>

        <div id="main-wrapper">

            <!-- Start Navigation -->
            @if (strpos(url()->current(), 'start-test/') == false)
                <div class="header header-light dark-text">
                    <div class="container">
                        <nav class="navigation navigation-landscape" id="navigation">
                            <div class="nav-header">
                                <a class="nav-brand" href="{{ route('home_page') }}">
                                    <img class="logo" src="{{ asset('logos/logo-transparent.png') }}"
                                        alt="{{ env('APP_NAME') }}" />
                                </a>
                                <div class="nav-toggle"></div>
                                <div class="mobile_nav">
                                    <ul>
                                        <li>
                                            <a class="crs_yuo12 theme-bg w-auto text-white"
                                                href="{{ route('bussines_enquiry') }}">
                                                <span class="embos_45"><i class="ti ti-briefcase"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="crs_yuo12 btn-danger w-auto text-white" href="{{ route('login') }}">
                                                <span class="embos_45"><i class="ti ti-user"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nav-menus-wrapper">
                                <ul class="nav-menu ms-auto">
                                    <li class="active"><a href="{{ route('home_page') }}">Home</a></li>

                                    @foreach ($education_types as $education_type)
                                        <li><a href="#">{{ $education_type->name }}<span
                                                    class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu ahtesham">
                                                @foreach ($classes_groups_exams as $classes_groups_exam)
                                                    @if ($classes_groups_exam->education_type_id == $education_type->id)
                                                        <li><a
                                                                href="{{ route('course.index', ['edu_type' => $education_type->id, 'class' => $classes_groups_exam->id]) }}">{{ $classes_groups_exam->name }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                    <li><a href="{{ route('contact_us') }}">Contact Us<span
                                                class="submenu-indicator"></span></a>
                                    </li>
                                </ul>
                                @if (Auth::check() &&
                                        auth()->user()->isAdminAllowed == 0 &&
                                        auth()->user()->is_franchise == 0 &&
                                        auth()->user()->is_staff == 0 &&
                                        auth()->user()->status == 'active')
                                    <ul class="nav-menu nav-menu-social align-to-right">
                                        <li>
                                            <h5>Hi, {{ auth()->user()->name }}</h5>
                                        </li>
                                        <li class="add-listing theme-bg">
                                            <a href="{{ route('student.dashboard') }}">
                                                <i class="fas fa-tachometer-alt"></i><span class="dn-lg">
                                                    Dashboard</span>
                                            </a>
                                        </li>
                                    </ul>
                                @else
                                    <ul class="nav-menu nav-menu-social align-to-right">
                                        <li>
                                            <a class="alio_green" href="{{ route('login') }}">
                                                <i class="fas fa-sign-in-alt me-1"></i><span class="dn-lg">Login</span>
                                            </a>
                                        </li>
                                        <li class="add-listing theme-bg">
                                            <a class="alio_green register" href="{{ route('register') }}">
                                                <i class="fas fa-users me-1"></i><span class="dn-lg">Register</span>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a class="alio_green" data-bs-toggle="modal" data-bs-target="#login"
                                                href="#">
                                                <i class="fas fa-sign-in-alt me-1"></i><span class="dn-lg">Login</span>
                                            </a>
                                        </li>
                                        <li class="add-listing theme-bg">
                                            <a class="alio_green register" data-bs-toggle="modal"
                                                data-bs-target="#login" href="#">
                                                <i class="fas fa-users me-1"></i><span class="dn-lg">Register</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            @endif
            <!-- End Navigation -->
            <div class="clearfix"></div>
            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->

            @yield('main')
            @if (isset($slot))
                {{ $slot }}
            @endif

            <!-- ============================ Footer Start ================================== -->
            <livewire:frontend.components.footer />
            <!-- ============================ Footer End ================================== -->

            <a class="top-scroll" id="back2Top" href="#" title="Back to top"><i class="ti-arrow-up"></i></a>

        </div>
        <!-- ALL JS FILES -->
        <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('skillup/js/select2.min.js') }}"></script>
        <script src="{{ asset('skillup/js/slick.js') }}"></script>
        <script src="{{ asset('skillup/js/moment.min.js') }}"></script>
        <script src="{{ asset('skillup/js/daterangepicker.js') }}"></script>
        <script src="{{ asset('skillup/js/summernote.min.js') }}"></script>
        <script src="{{ asset('skillup/js/metisMenu.min.js') }}"></script>
        {{-- <script src="{{ asset('frontend/sweetalert2/sweetalert2.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
        {{-- <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script> --}}
        <script src="{{ asset('skillup/js/custom.js') }}"></script>
        <script>
            $('.togglePassword').on('click', function() {
                var passwordInput = $(this).closest('.input-group').find('.form-control');
                var icon = $(this).find('.fas');
                console.log(icon)
                if (passwordInput.attr('type') == 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye');
                    icon.addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash');
                    icon.addClass('fa-eye');
                }
            })

            function verifyInstitute() {
                var branch_code_new = $('#branch_code_new').val();
                // alert(branch_code_new);
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
                    if (data != 'false') {
                        showAlert('Institute code verified.', 'Error', 'warning');
                        $('#verifystatus_institute').val(1);
                        $('#branch_code_new').attr('readonlny', 'readonlny');
                        $('#institute_name').val(JSON.parse(data));
                        $('#institute_name').show();
                    } else {
                        showAlert('Institute code not verified.', 'Error', 'warning');
                        $('#verifystatus_institute').val(0);
                        $('#branch_code_new').removeAttr('readonlny');
                        $('#institute_name').val('');
                        $('#institute_name').hide();
                    }
                }).fail(function(data, textStatus) {
                    console.log(data);
                })
            }

            $('#forgetStudent').submit(function(event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                formData.append('form_name', 'student_forget');
                console.log(Array.from(formData));

                $.ajax({
                    url: '/',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(function(response, textStatus) {
                    console.log(response);
                    if (response == '"NA"') {
                        showAlert('Student not found on this email. Please check your email.', 'Info', 'info');
                    } else if (response == '"true"') {
                        showAlert('Please check your email for reset your password.').then((response) => {
                            // location.reload();
                        });
                    } else {
                        showAlert('Server error, please try again later.', 'Error', 'error');
                    }
                    console.log(textStatus);
                }).fail(function(error, textStatus) {
                    console.log(error);
                    console.log(textStatus);
                })
            });

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
                }).done(function(data) {
                    console.log(data);
                    if (data && data.success) {
                        const classes = data.message;
                        var options = '<option value="">Class / Group / Exam</option>';
                        if (classes.length > 0) {
                            $(classes).each(function(index, item) {
                                // var boards = JSON.parse(item.boards).join();
                                options += '<option value="' + item.id + '">' + item.name + '</option>';
                            });
                            $('#class_group_exam_id').removeAttr('disabled');
                        } else {
                            $('#class_group_exam_id').val('');
                            $('#class_group_exam_id').attr('disabled', 'disabled');
                            alert('No classes / Groups or Exams in this Type, please select another, or add some.');
                        }
                        $('#class_group_exam_id').html(options);
                    } else {
                        alert(data.message);
                    }
                }).fail(function(data) {
                    console.log(data);
                })
            }
            const Toast2 = Swal.mixin({
                toast: true,
                position: "bottom-center",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            function success(messasge) {
                return Toast2.fire({
                    icon: "success",
                    title: messasge
                });
            }
            function error(messasge) {
                return Toast2.fire({
                    icon: "error",
                    title: messasge
                });
            }
        </script>

        @yield('js')
        @stack('scripts')

        <div class="text-center" id="fullpage_loader">
            <div>
                <div class="loader spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </body>

</html>
