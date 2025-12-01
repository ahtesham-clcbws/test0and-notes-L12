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
    <link rel="icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="shortcut-icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('logos/logo-white-square.png') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend/sweetalert2/sweetalert2.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sansita:wght@400;700&display=swap" rel="stylesheet">

    <link href="{{ asset('skillup/css/styles.css') }}" rel=" stylesheet">

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
    </style>

    @yield('css')
</head>

<body>

    <div id="main-wrapper">

        <!-- Start Navigation -->
        @if(strpos(url()->current(), 'start-test/') == false)
        <div class="header header-light dark-text">
            <div class="container">
                <nav id="navigation" class="navigation navigation-landscape">
                    <div class="nav-header">
                        <a class="nav-brand" href="{{ route('home_page') }}">
                            <img src="{{ asset('logos/logo-transparent.png') }}" class="logo"
                                alt="{{ env('APP_NAME') }}" />
                        </a>
                        <div class="nav-toggle"></div>
                        <div class="mobile_nav">
                            <ul>
                                <li>
                                    <a href="{{ route('bussines_enquiry') }}"
                                        class="crs_yuo12 w-auto text-white theme-bg">
                                        <span class="embos_45"><i class="ti ti-briefcase"></i></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#login"
                                        class="crs_yuo12 w-auto text-white btn-danger">
                                        <span class="embos_45"><i class="ti ti-user"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu ms-auto">
                            <li class="active"><a href="{{ route('home_page') }}">Home</a></li>

                            <!-- <li><a href="#">Govt Exams<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="#">Search Courses in Grid<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="grid-layout-with-sidebar.html">Grid Layout Style 1</a></li>
                                                <li><a href="grid-layout-with-sidebar-2.html">Grid Layout Style 2</a></li>
                                                <li><a href="grid-layout-with-sidebar-3.html">Grid Layout Style 3</a></li>
                                                <li><a href="grid-layout-with-sidebar-4.html">Grid Layout Style 4</a></li>
                                                <li><a href="grid-layout-with-sidebar-5.html">Grid Layout Style 5</a></li>
                                                <li><a href="grid-layout-full.html">Grid Full Width</a></li>
                                                <li><a href="grid-layout-full-2.html">Grid Full Width 2</a></li>
                                                <li><a href="grid-layout-full-3.html">Grid Full Width 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Search Courses in List<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="list-layout-with-sidebar.html">List Layout Style 1</a></li>
                                                <li><a href="list-layout-with-full.html">List Full Width</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="course-detail.html">Course Detail 01</a></li>
                                                <li><a href="course-detail-2.html">Course Detail 02</a></li>
                                                <li><a href="course-detail-3.html">Course Detail 03</a></li>
                                                <li><a href="course-detail-4.html">Course Detail 04</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="explore-category.html">Explore Category</a></li>
                                        <li><a href="find-instructor.html">Find Instructor</a></li>
                                        <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Online Test<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="#">Search Courses in Grid<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="grid-layout-with-sidebar.html">Grid Layout Style 1</a></li>
                                                <li><a href="grid-layout-with-sidebar-2.html">Grid Layout Style 2</a></li>
                                                <li><a href="grid-layout-with-sidebar-3.html">Grid Layout Style 3</a></li>
                                                <li><a href="grid-layout-with-sidebar-4.html">Grid Layout Style 4</a></li>
                                                <li><a href="grid-layout-with-sidebar-5.html">Grid Layout Style 5</a></li>
                                                <li><a href="grid-layout-full.html">Grid Full Width</a></li>
                                                <li><a href="grid-layout-full-2.html">Grid Full Width 2</a></li>
                                                <li><a href="grid-layout-full-3.html">Grid Full Width 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Search Courses in List<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="list-layout-with-sidebar.html">List Layout Style 1</a></li>
                                                <li><a href="list-layout-with-full.html">List Full Width</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="course-detail.html">Course Detail 01</a></li>
                                                <li><a href="course-detail-2.html">Course Detail 02</a></li>
                                                <li><a href="course-detail-3.html">Course Detail 03</a></li>
                                                <li><a href="course-detail-4.html">Course Detail 04</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="explore-category.html">Explore Category</a></li>
                                        <li><a href="find-instructor.html">Find Instructor</a></li>
                                        <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Kids Zone<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu">
                                        <li><a href="explore-category.html">Explore Category</a></li>
                                        <li><a href="find-instructor.html">Find Instructor</a></li>
                                        <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                    </ul>
                                </li> -->
                            @foreach($education_types as $education_type)

                            <li><a href="#">{{$education_type->name}}<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu">
                                    @foreach($classes_groups_exams as $classes_groups_exam)
                                    @if($classes_groups_exam->education_type_id == $education_type->id)
                                    <li><a href="{{route('course.index',['edu_type' => $education_type->id, 'class' =>  $classes_groups_exam->id])}}">{{$classes_groups_exam->name}}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                            {{-- <li><a href="{{ route('page') }}">Academics<span class="submenu-indicator"></span></a>
                            <li><a href="{{ route('page') }}">Competition<span class="submenu-indicator"></span></a> --}}
                                <!-- <li><a href="{{ route('about_us') }}">About Us<span class="submenu-indicator"></span></a> -->
                                <!-- <ul class="nav-dropdown nav-submenu">
                                        <li><a href="#">Study Notes<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="grid-layout-with-sidebar.html">Grid Layout Style 1</a></li>
                                                <li><a href="grid-layout-with-sidebar-2.html">Grid Layout Style 2</a></li>
                                                <li><a href="grid-layout-with-sidebar-3.html">Grid Layout Style 3</a></li>
                                                <li><a href="grid-layout-with-sidebar-4.html">Grid Layout Style 4</a></li>
                                                <li><a href="grid-layout-with-sidebar-5.html">Grid Layout Style 5</a></li>
                                                <li><a href="grid-layout-full.html">Grid Full Width</a></li>
                                                <li><a href="grid-layout-full-2.html">Grid Full Width 2</a></li>
                                                <li><a href="grid-layout-full-3.html">Grid Full Width 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Book Store<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="list-layout-with-sidebar.html">List Layout Style 1</a></li>
                                                <li><a href="list-layout-with-full.html">List Full Width</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                            <ul class="nav-dropdown nav-submenu">
                                                <li><a href="course-detail.html">Course Detail 01</a></li>
                                                <li><a href="course-detail-2.html">Course Detail 02</a></li>
                                                <li><a href="course-detail-3.html">Course Detail 03</a></li>
                                                <li><a href="course-detail-4.html">Course Detail 04</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="explore-category.html">Explore Category</a></li>
                                        <li><a href="find-instructor.html">Find Instructor</a></li>
                                        <li><a href="instructor-detail.html">Instructor Detail</a></li>
                                    </ul> -->
                            </li>

                            {{-- <li><a href="{{ route('page') }}">Govt Jobs<span class="submenu-indicator"></span></a>
                            @if(!\App\Models\TestModal::select('title','id')->where('user_id',NULL)->where('published',1)->get()->isEmpty())
                            <ul class="nav-dropdown nav-submenu">
                                @foreach(\App\Models\TestModal::select('title','id')->where('user_id',NULL)->where('published',1)->take(8)->get() as $test_name)
                                @if(Auth::check() && auth()->user()->isAdminAllowed == 0 && auth()->user()->is_franchise == 0 && auth()->user()->is_staff == 0 && auth()->user()->status == 'active')
                                <li><a href="{{ route('test-name',[ $test_name->id ])}}">{{ $test_name->title }}<span class="submenu-indicator"></span></a></li>
                                @else
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#login">{{ $test_name->title }}<span class="submenu-indicator"></span></a>
                                </li>
                                @endif
                                @endforeach
                                <!-- <li>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#login">View More Tests<span class="submenu-indicator"></span></a>
                                            </li> -->
                                <!-- <ul class="nav-dropdown nav-submenu">
                                                <li><a href="grid-layout-with-sidebar.html">Grid Layout Style 1</a></li>
                                                <li><a href="grid-layout-with-sidebar-2.html">Grid Layout Style 2</a></li>
                                                <li><a href="grid-layout-with-sidebar-3.html">Grid Layout Style 3</a></li>
                                                <li><a href="grid-layout-with-sidebar-4.html">Grid Layout Style 4</a></li>
                                                <li><a href="grid-layout-with-sidebar-5.html">Grid Layout Style 5</a></li>
                                                <li><a href="grid-layout-full.html">Grid Full Width</a></li>
                                                <li><a href="grid-layout-full-2.html">Grid Full Width 2</a></li>
                                                <li><a href="grid-layout-full-3.html">Grid Full Width 3</a></li>
                                            </ul> -->
                                <!-- <li><a href="{{ route('online_test') }}">SSC CHSL Mock Test 2<span class="submenu-indicator"></span></a>
                                            </li>
                                            <li><a href="{{ route('online_test') }}">SSC CHSL Mock Test 3<span class="submenu-indicator"></span></a>
                                            </li> -->
                                <!-- <li><a href="#">Search Courses in List<span class="submenu-indicator"></span></a>
                                                <ul class="nav-dropdown nav-submenu">
                                                    <li><a href="list-layout-with-sidebar.html">List Layout Style 1</a></li>
                                                    <li><a href="list-layout-with-full.html">List Full Width</a></li>
                                                </ul>
                                            </li> -->
                                <!-- <li><a href="#">Courses Detail<span class="submenu-indicator"></span></a>
                                                <ul class="nav-dropdown nav-submenu">
                                                    <li><a href="course-detail.html">Course Detail 01</a></li>
                                                    <li><a href="course-detail-2.html">Course Detail 02</a></li>
                                                    <li><a href="course-detail-3.html">Course Detail 03</a></li>
                                                    <li><a href="course-detail-4.html">Course Detail 04</a></li>
                                                </ul>
                                            </li>

                                            <li><a href="explore-category.html">Explore Category</a></li>
                                            <li><a href="find-instructor.html">Find Instructor</a></li>
                                            <li><a href="instructor-detail.html">Instructor Detail</a></li> -->
                            </ul>
                            @endif

                            </li> --}}
                            <li><a href="{{ route('contact_us') }}">Contact Us<span class="submenu-indicator"></span></a>
                            </li>
                        </ul>
                        @if(Auth::check() && auth()->user()->isAdminAllowed == 0 && auth()->user()->is_franchise == 0 && auth()->user()->is_staff == 0 && auth()->user()->status == 'active')
                        <ul class="nav-menu nav-menu-social align-to-right">
                            <li>
                                <h5>Hi, {{ auth()->user()->name }}</h5>
                            </li>
                            <li class="add-listing theme-bg">
                                <a href="{{ route('student.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i><span class="dn-lg"> Dashboard</span>
                                    <!-- <i class="fas fa-sign-in-alt me-1"></i> -->
                                </a>
                            </li>
                        </ul>
                        @else
                        <ul class="nav-menu nav-menu-social align-to-right">
                            <li>
                                <a href="#" class="alio_green" data-bs-toggle="modal" data-bs-target="#login">
                                    <i class="fas fa-sign-in-alt me-1"></i><span class="dn-lg">Login</span>
                                </a>
                            </li>
                            <li class="add-listing theme-bg">
                                <a href="#" class="alio_green register" data-bs-toggle="modal" data-bs-target="#login">
                                    <i class="fas fa-users me-1"></i><span class="dn-lg">Register</span>
                                </a>
                            </li>
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

        <!-- ============================ Footer Start ================================== -->
        <footer class="footer mt-auto py-3 bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logo">
                            <img src="{{asset('logos/logo-transparent.png')}}" alt="Test & Notes Logo" class="img-fluid" style="max-width:214px">
                        </div>
                        <p class="mt-2" style="font-family: 'Cookie', cursive;">Dedicated Online Test Platform For Institutions</p>
                        <h6 style="color:#ff6600">Weblies Equations Pvt. Ltd.</h6>
                        <address>
                            Green Boulevard, 5th Floor, Tower C <br>
                            Block B, Sector 62, Noida <br>
                            Uttar Pradesh, 201301
                        </address>
                        <p>Email: <a href="mailto:support@testandnotes.com" class="text-white">support@testandnotes.com</a></p>
                        <p>Mobile: 9335334045 (Monday to Friday)<br>
                            10:30 AM - 6:30 PM</p>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-uppercase text-white" style="font-family:Sansita">Our Terms & Policies</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">About Us</a></li>
                            <li><a href="#" class="text-white">Free for You</a></li>
                            <li><a href="#" class="text-white">Courses & Exams</a></li>
                            <li><a href="#" class="text-white">Teach Online with Us</a></li>
                            <li><a href="#" class="text-white">Become Our Education Partner</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-uppercase text-white" style="font-family:Sansita">FAQ’s & Policies</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">FAQ’s</a></li>
                            <li><a href="#" class="text-white">Important Links</a></li>
                            <li><a href="#" class="text-white">User Policy & Terms</a></li>
                            <li><a href="#" class="text-white">Website Privacy Policy</a></li>
                            <li><a href="#" class="text-white">Website Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-uppercase text-white" style="font-family:Sansita">Important Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Corporate Enquiry</a></li>
                            <li><a href="#" class="text-white">Institute Login</a></li>
                            <li><a href="#" class="text-white">Student Sign up</a></li>
                            <li><a href="#" class="text-white">Student Login</a></li>
                            <li><a href="#" class="text-white">Contact Us For Any Query</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p>Copyright &copy; 2024 SQS Foundation. All rights reserved.</p>
                </div>
            </div>
        </footer>


        {{-- <footer class="dark-footer skin-dark-footer style-2">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">

                        <div class="col-md-5">
                            <div class="footer_widget">
                                <div class="row">
                                <div class="col-md-7">
                                    <img src="{{ asset('skillup/img/footer-logo.png') }}" class="img-footer small mb-2"
        alt="" />
        <h4 class="extream mb-3 mt-2" style="font-family:Geometr415 Blk BT;">Weblies Equations Pvt Ltd</h4>
    </div>
    <div class="col-md-5">
        <p class="text-white mb-3" style="font-family:Sansita;">Communication & Business Center<br><br>Green Boulevard, 5th Floor, Tower C, <br>Block B, Sector 62, Noida<br>
            ,Uttar Pradesh, 201301</p>
    </div>
    </div>

    </div>
    </div>

    <div class="col-md-7 ms-auto">
        <div class="row">

            <div class="col-lg-4 col-md-4">
                <div class="footer_widget">
                    <h4 class="widget_title">About Us</h4>
                    <div style="color: #ffffff; font-size: 16px; text-transform: uppercase;letter-spacing: 2px;margin-bottom: 20px;
                                                    position: relative; font-weight: 700;"></div>
                    <ul class="footer-menu">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Home</a></li>
                        <li><a href="http://tests.thegyanology.com/contact">Contact Us</a></li>
                        <li><a href="{{route('contact_us')}}">Free For You</a></li>
                        <!-- <li><a href="{{ route('institute_signup') }}">Admin Signup</a></li>
                                            <li><a href="{{ route('franchise.login') }}">Admin Login</a></li> -->
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="footer_widget">
                    <h4 class="widget_title">Important Links</h4>
                    <ul class="footer-menu">
                        <li><a href="#">Government Job</a></li>
                        <li><a href="#">Competitive Exams</a></li>
                        <li><a href="#">Entrance Exams </a></li>
                        <li><a href="#">Academics Exams</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="footer_widget">
                    <h4 class="widget_title">All Sections</h4>
                    <ul class="footer-menu">
                        <li><a href="#">Packages</a></li>
                        <li><a href="#">Study Material</a></li>
                        <li><a href="#">GK & Current Affairs</a></li>
                        <li><a href="#">Live & Video Classe</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 text-center">
                    <p class="mb-0">© {{ date('Y') }} Weblies Equations Pvt. Ltd. </p>
                </div>
            </div>
        </div>
    </div>
    </footer> --}}
    <!-- ============================ Footer End ================================== -->

    <!-- Log In Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content overli" id="loginmodal">
                <div class="modal-header">
                    <h5 class="modal-title theme-cl pointerCursor" id="loginModalTitle" onclick="toggleLogin()">
                        Don't have account? SignUp
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login-form custom-form">
                        <form method="POST" id="userlogin" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Mobile / Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti-user"></i>
                                    </span>
                                    <input type="text" name="username" id="username" required
                                        class="form-control" placeholder="Mobile or email">
                                </div>
                            </div>
                            <div id="plan_input">
                                <input type='hidden' name='planclick' value='0'>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti-unlock"></i>
                                    </span>
                                    <input type="password" name="password" id="userpass" class="form-control"
                                        placeholder="">
                                    <button class="btn theme-bg togglePassword" type="button" style="width: 42px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <div class="fhg_45">
                                        <p class="musrt">
                                            <input id="remember_me" class="checkbox-custom" name="remember_me"
                                                type="checkbox">
                                            <label for="remember_me" class="checkbox-custom-label">Remember
                                                Me</label>
                                        </p>
                                    </div>
                                    <div class="fhg_45">
                                        <p class="musrt">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#forget"
                                                class="text-danger">Forgot
                                                Password?</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit"
                                        class="btn btn-sm full-width theme-bg text-white">Login</button>
                                </div>
                            </div>
                        </form>
                        <form id="registration" method="post" enctype="multipart/form-data" class="noDisplay">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-user"></i>
                                            </span>
                                            <input type="text" class="form-control" name="full_name"
                                                id="fname_new" placeholder="Student's name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-email"></i>
                                            </span>
                                            <input type="email" name="email" id="email_new"
                                                oninput="uniqueEmailCheck(this)"
                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                class="form-control" placeholder="E-mail" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-mobile"></i>
                                            </span>
                                            <input type="number" id="mobile_register"
                                                oninput="mobileNumberCheck(this, 'register')" name="mobile_number"
                                                minlength="10" maxlength="10" required class="form-control"
                                                placeholder="Mobile">
                                            <button class="btn theme-bg text-white append" style="width: 70px;"
                                                onclick="sendOtp('register')" type="button">
                                                Get OTP
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input id="verifystatus_register" name="verifystatus_register"
                                    class="d-none" value="0">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-key"></i>
                                            </span>
                                            <input type="number" name="mobile_otp" id="mobile_otp_register"
                                                minlength="6" maxlength="6" required class="form-control"
                                                placeholder="Input OTP">
                                            <button class="btn theme-bg text-white append" style="width: 70px;"
                                                onclick="verifyOtp('register')" type="button">
                                                Verify
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-unlock"></i>
                                            </span>
                                            <input type="password" name="password" id="password" type="password"
                                                class="form-control" placeholder="Password" required
                                                minlength="5" oninput="validatePassword(this)">
                                            <button class="btn theme-bg togglePassword" type="button" style="width: 70px;">
                                                <i class="fas fa-eye text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-unlock"></i>
                                            </span>
                                            <input type="password" name="confirm_password" id="confirm_password_new"
                                                class="form-control" placeholder="Confirm Password" required
                                                minlength="5" oninput="inputConfirmPassword(this)">
                                            <button class="btn theme-bg togglePassword" type="button" style="width: 70px;">
                                                <i class="fas fa-eye text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input id="verifystatus_institute" class="d-none" value="0">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="ti-ink-pen"></i>
                                            </span>
                                            <input type="text" id="branch_code_new" name="institute_code"
                                                class="form-control" placeholder="Your institute code (If any)">
                                            <button class="btn theme-bg text-white append" style="width: 70px;"
                                                onclick="verifyInstitute()" type="button">
                                                Verify
                                            </button>
                                        </div>
                                        <input type="text" id="institute_name" class="form-control"
                                            style="display: none;" readonly disabled>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <!-- <label>Education Type</label> -->
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            </span>
                                            <select class="form-control" id="education_type_id" name="education_type_id" onchange="getClassesByEducation(this.value)" required>
                                                <option value="" selected>Education Type</option>
                                                @if(isset($gn_EduTypes))
                                                @foreach($gn_EduTypes as $u)
                                                <option value="{{ $u->id }}">{{ $u->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <!-- <label>Education Type</label> -->
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-users" aria-hidden="true"></i>
                                            </span>
                                            <select class="form-control" id="class_group_exam_id" name="class_group_exam_id" required>
                                                <option value="" selected>Class/Group/Exam Name</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label>You can attach jpeg / png files (max size: 200 kb)</label>
                                        <input type="file" class="form-control" name="user_logo" id="user_logo">
                                    </div>
                                </div>
                                <div class="form-group col-12 mb-2">
                                    <input class="checkbox-custom" id="required_check_registration" type="checkbox"
                                        required>
                                    @if(isset($pdf))
                                    <label for="required_check_registration" class="checkbox-custom-label">I agree
                                        to The
                                        gyanology's <a href="{{ url('public/'. $pdf->url) }}" class="theme-cl" target="_blank">Terms of
                                            Services</a></label>
                                    @else
                                    <label for="required_check_registration" class="checkbox-custom-label">I agree
                                        to The
                                        gyanology's <a href="#" class="theme-cl">Terms of
                                            Services</a></label>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-sm full-width theme-bg text-white">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    {{-- Forget Modal --}}
    <div class="modal fade" id="forget" tabindex="-1" role="dialog" aria-labelledby="forgetModal"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered login-pop-form" role="document">
            <div class="modal-content overli" id="forgetModal">
                <div class="modal-header">
                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#forget" class="text-danger"> --}}
                    <h5 class="modal-title theme-cl pointerCursor" id="forgetModalTitle" data-bs-toggle="modal"
                        data-bs-target="#login">
                        Go back to login
                    </h5>
                    {{-- </a> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login-form custom-form">
                        <form method="POST" id="forgetStudent" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Student Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti-user"></i>
                                    </span>
                                    <input type="email" name="forget_email" id="forget_email" required
                                        class="form-control" placeholder="E-Mail">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit"
                                        class="btn btn-sm full-width theme-bg text-white">Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>

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
    <script src="{{ URL::asset('frontend/sweetalert2/sweetalert2.js') }}"></script>

    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <!-- <script src="{{ asset('frontend/js/sweetalert.min.js') }}"></script> -->
    <script src="{{ asset('skillup/js/custom.js') }}"></script>
    <script>
        var registration = $('#registration');
        var userlogin = $('#userlogin');
        loginModal.addEventListener('hidden.bs.modal', function(event) {
            if (userlogin.css('display') === 'none') {
                $('#loginModalTitle').html('Don\'t have account? SignUp')
                registration.toggle();
                userlogin.toggle();
            }
        })

        function toggleLogin() {
            // var loginModalFooter = $('#loginModalFooter');
            if (registration.css('display') === 'none') {
                $('#loginModalTitle').html('Back to Login.')
            } else {
                $('#loginModalTitle').html('Don\'t have account? SignUp')
            }
            registration.toggle();
            userlogin.toggle();
            // loginModalFooter.toggle();
        }

        $(".register").on('click', function() {
            if (registration.css('display') === 'none') {
                $('#loginModalTitle').html('Back to Login.')
            } else {
                $('#loginModalTitle').html('Don\'t have account? SignUp')
            }
            registration.toggle();
            userlogin.toggle();
        });

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
    </script>

    @yield('js')

    <div class="text-center" id="fullpage_loader">
        <div>
            <div class="loader spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</body>

</html>
