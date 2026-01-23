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
    <title>{{env('APP_NAME')}}</title>
    <!-- Site Icons -->
    <link rel="icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="shortcut-icon" href="{{ asset('logos/logo-white-square.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('logos/logo-white-square.png') }}">
    <link rel="stylesheet" href="{{ URL::asset('frontend/sweetalert2/sweetalert2.min.css') }}">

    <link href="{{ asset('skillup/css/styles.css') }}"" rel=" stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .call_action_wrap {
height: 2px; /* Change this value to adjust the height */
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
}
        #userid_new_error,
        #statusUsername,
        #citiesRegisterDiv,
        #citiesDiv {
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

        #userid_new_error,
        #statusUsername,
        #citiesRegisterDiv,
        #citiesDiv {
            display: none;
        }

        #branchRemove,
        #branchcehck {
            cursor: pointer;
        }

        /* Import custom fort */
        @font-face {
            font-family: arial_bold;
            src: url({{ asset('fonts/ARLRDBD.ttf') }});
        }

        /* Import custom fort */
        @font-face {
            font-family: bree_serif;
            src: url({{ asset('fonts/BreeSerif-Regular.ttf') }});
        }

        /* Import custom fort */
        @font-face {
            font-family: geometric_black_bt;
            src: url({{ asset('fonts/geometric_415_black_bt.ttf') }});
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

        .Column{
      width: 12%;
      float: left;
    }
    td{
      border: 1px solid black;
    }
    .sticky {
      position: -webkit-sticky;
      position: sticky;
      top: 0;
    }
    .accordion {
      background-color: #eee;
      color: #444;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.4s;
    }

<!--.active, .accordion:hover {-->
<!--  background-color: #ccc;-->
<!--}-->

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

<!--.active:after {-->
<!--  content: "\2212";-->
<!--}-->

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
@media only screen and (max-width: 1200px) {
  .Column {
    width: 48%;
    margin: 5px 3px !important;
  }

  .sticky {
      position: unset;
    }
}

@media only screen and (max-width: 767px) {
  .section1 {
    text-align: center;
  }
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
                                    alt="" />
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

                                <!--<li><a href="{{ route('page') }}">Academics<span class="submenu-indicator"></span></a>-->
                                <!--<li><a href="{{ route('page') }}">Academics<span class="submenu-indicator"></span></a>-->
                                <!--<li><a href="{{ route('page') }}">Competition<span class="submenu-indicator"></span></a>-->
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
                                <li><a href="{{ route('contact_us') }}">Free For You<span class="submenu-indicator"></span></a>
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

        <!--page start-->
        <div style="background-color: #d9eeef;">
            <div class="container-fluid pt-5 pb-2" style="background-color:#8cd9e3;">
                <div class="container">
    <div class="row section1">
      <div class="col-lg-1 col-md-2 col-sm-12 rounded" style="padding: 0px; margin: 1px;">
          <img class="mx-auto d-block" src="icon1.png">
      </div>
      <div class="col-lg-7 col-md-7 col-sm-12 bg-white rounded" style=" margin: 1px;">
        <div class="row my-1">
          <div class="col-lg-10 col-sm-12 mt-2">
            <h4>SSC- CGL 2023</h4>
            <p>123.4K+ Students Intrested</p>
          </div>
          <div class="col-lg-2 col-sm-12 my-auto">
              <button class="btn btn-success">Start Free</button>
          </div>
        </div>

      </div>
      <div class="col-lg-3 col-md-2 col-sm-12 rounded" style="border: 1px solid black; margin:1px 3px;">
        <img class="mx-auto d-block" src="icon1.png">
      </div>
    </div>
    <div class="row mt-4">
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-8 p-0">
              <h5>Course Overview</h5>
            </div>
            <div class="col-4 my-auto">
              <i style="font-size:30px; color:green;" class="fa-solid fa-download"></i>
            </div>
          </div>
        </div>
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-8 my-2">
              <h5>Packages</h5>
            </div>
            <div class="col-4 my-auto">
              <i style="font-size:30px; color:green;" class="fa-solid fa-download"></i>
            </div>
          </div>
        </div>
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-12">
              <h5>Free Test & Quizes </h5>
            </div>
          </div>
        </div>
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-8 p-0">
              <h5>Free Study Notes</h5>
            </div>
            <div class="col-4 my-auto">
              <i style="font-size:30px; color:green;" class="fa-solid fa-download"></i>
            </div>
          </div>
        </div>
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-8 p-0">
              <h5>Previous Year Papers</h5>
            </div>
            <div class="col-4 my-auto">
              <i style="font-size:30px; color:green;" class="fa-solid fa-download"></i>
            </div>
          </div>
        </div>
        <div class="Column bg-white text-center rounded" style="margin: 1px 3px;">
          <div class="row">
            <div class="col-8 p-0">
              <h5>Important Websites</h5>
            </div>
            <div class="col-4 my-auto">
              <i style="font-size:30px; color:green;" class="fa-solid fa-download"></i>
            </div>
          </div>
        </div>

    </div>
  </div>
            </div>

            <div class="container mt-5">
                <div class="row">
    <div class="col-lg-8 col-sm-12" style="margin-right: 10px;">
      <div style="margin: 1px;">
        <h4 style = "color:#0d6efd;">Course / Exam Name</h4>
        <p class="bg-white p-3" style="border:1px solid black;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <div class="my-5">
          <div>
            <button class="accordion bg-white">Study Notes & E-Books</button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion">Comprehensive Notes</button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion bg-white">Static Gk & Current Affairs</button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion">Video Classes (By Experts</button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion bg-white">Important Information & Other Details</button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion">Tests (Free/ Premium/ Previous Year Papers) </button>
            <div class="panel">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

          </div>
      </div>

      <div class="mb-5" style="border:1px solid #d4cfcf; background-color:#d4cfcf;">
          <div class="bg-white rounded m-3">
            <div class="row  p-2 py-3">
              <div class="col-lg-9 col-sm-12">
                <button class="btn btn-success">Free</button>
                <div>
                  <span style="font-size: 20px;">SSC MTS Full Mock Test</span>
                  <span style="font-size: 12px;">
                    <i class="fa fa-bolt fa-fw fa-2x" style="font-size: 15px; color: yellow;"></i>227.0k Users</span>
                </div>
                <div class="row">
                  <div class="col-9">
                    <div class="row">
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-circle-question"></i> 100 Quetions
                      </div>
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-file-lines"></i> 100 Marks
                      </div>
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-clock"></i> 90 Mins
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-lg-3 col-sm-12 my-auto">
                <button class="btn btn-primary px-5">Start Now</button>
              </div>
            </div>
            <div class="rounded" style="background-color:#f2efe4; color: blue; padding-left: 20px;">
                Syllabus | <i class="fa-regular fa-language"></i> English , Hindi
            </div>
          </div>

          <div class="bg-white rounded m-3">
            <div class="row  p-2 py-3">
              <div class="col-lg-9 col-sm-12">
                <button class="btn btn-success">Free</button>
                <div>
                  <span style="font-size: 20px;">SSC MTS Full Mock Test</span>
                  <span style="font-size: 12px;">
                    <i class="fa fa-bolt fa-fw fa-2x" style="font-size: 15px; color: yellow;"></i>227.0k Users</span>
                </div>
                <div class="row">
                  <div class="col-9">
                    <div class="row">
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-circle-question"></i> 100 Quetions
                      </div>
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-file-lines"></i> 100 Marks
                      </div>
                      <div class="col-lg-4 col-sm-12">
                        <i class="fa-regular fa-clock"></i> 90 Mins
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-lg-3 col-sm-12 my-auto">
                <button class="btn btn-primary px-5">Start Now</button>
              </div>
            </div>
            <div class="rounded" style="background-color:#f2efe4; color: blue; padding-left: 20px;">
                Syllabus | <i class="fa-regular fa-language"></i> English , Hindi
            </div>
          </div>
      </div>
    </div>

    <div class="col-lg-3 col-sm-12" style=" margin-left: 3px;">
      <div class="sticky">
      <div>
          <h4 style="color:blue;">Authorised Detail</h4>
          <table class="table border bg-white">
              <tbody>
                <tr>
                  <td class="px-1 py-2">Registration:</td>
                  <td class="px-1 py-2">24 Sep 2021 - 26 Oct 2021</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Exam Date:</td>
                  <td class="px-1 py-2">28 Dec 2021 - 06 Jan 2022</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Exam Mode:</td>
                  <td class="px-1 py-2">Written & Computer Based</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Vacancies:</td>
                  <td class="px-1 py-2">5500</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Eligibility:</td>
                  <td class="px-1 py-2">Graduate / Final Appearing</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Official Site:</td>
                  <td class="px-1 py-2">https://sssc.nic.in/</td>
                </tr>
                <tr>
                  <td class="px-1 py-2">Salary:</td>
                  <td class="px-1 py-2">I21,700 - I69,100</td>
                </tr>

              </tbody>
          </table>
      </div>
      <div class="mt-5">
          <h4 style="color:blue;">Important Websites</h4>
          <div class="bg-white p-2 pb-5" style="border:1px solid black;">
            <div>
              <a href="#" class="text-dark text-decoration-none">http://testandnotes.com/</a>
            </div>
            <div>
              <a href="#" class="text-dark text-decoration-none">http://testandnotes.com/</a>
            </div>
            <div>
              <a href="#" class="text-dark text-decoration-none">http://testandnotes.com/</a>
            </div>
            <div>
              <a href="#" class="text-dark text-decoration-none">http://testandnotes.com/</a>
            </div>
            <div>
              <a href="#" class="text-dark text-decoration-none">http://testandnotes.com/</a>
            </div>
          </div>

      </div>
      </div>
    </div>
  </div>
            </div>
        </div>
        <!--page end-->
        <!-- ============================ Call To Action ================================== -->
        <section class="theme-bg call_action_wrap-wrap" style="height: 85px; padding:40px 0px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="call_action_wrap">
                            <div class="call_action_wrap-head">
                                <h3>Do You Have Questions ?</h3>
                                <span>We'll help you to grow your career and growth.</span>
                            </div>
                            <a href="#" class="btn btn-call_action_wrap">Contact Us Today</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- ============================ Call To Action End ================================== -->

        <!-- ============================ Footer Start ================================== -->
        <footer class="dark-footer skin-dark-footer style-2">
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
                                {{-- <div class="foot-news-last">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Email Address">
                                        <div class="input-group-append">
                                            <button type="button"
                                                class="input-group-text theme-bg b-0 text-light">Subscribe</button>
                                        </div>
                                    </div>
                                </div> --}}
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
                                            <li><a href="http://testandnotes.com/contact">Contact Us</a></li>
                                            <!-- <li><a href="{{ route('corporate_signup') }}">Admin Signup</a></li>
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
        </footer>
        <!-- ============================ Footer End ================================== -->

        <!-- Log In Modal -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered login-pop-form" role="document">
                <div class="modal-content overli" id="loginmodal">
                    <div class="modal-header">
                        <h5 class="modal-title theme-cl pointerCursor" id="loginModalTitle" onclick="toggleLogin()">
                            Don't have account? SignUp
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true"><i class="fas fa-times-circle"></i></span> --}}
                        </button>
                    </div>
                    <div class="modal-body">
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
                                    {{-- <div class="input-with-icon">
                                        <input type="text" name="username" id="username" required
                                            class="form-control" placeholder="Mobile or email">
                                        <i class="ti-user"></i>
                                    </div> --}}
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
                                        <button class="btn theme-bg togglePassword" type="button">
                                            <i class="fas fa-eye text-white"></i>
                                        </button>
                                    </div>
                                    {{-- <div class="input-with-icon">
                                        <input type="password" name="password" id="userpass" class="form-control"
                                            placeholder="*******">
                                        <i class="ti-unlock"></i>
                                    </div> --}}
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
                                            {{-- <div class="input-with-icon">
                                                <input type="text" class="form-control" name="full_name"
                                                    id="fname_new" placeholder="Student's name" required>
                                                <i class="ti-user"></i>
                                            </div> --}}
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
                                            {{-- <div class="input-with-icon">
                                                <input type="email" name="email" id="email_new"
                                                    oninput="uniqueEmailCheck(this)"
                                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    class="form-control" placeholder="E-mail" required>
                                                <i class="ti-email"></i>
                                            </div> --}}
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
                                                <button class="btn theme-bg text-white append"
                                                    onclick="sendOtp('register')" type="button">
                                                    Get Otp
                                                </button>
                                            </div>
                                            {{-- <div class="input-with-icon with-append">
                                                <input type="number" id="mobile_register"
                                                    oninput="mobileNumberCheck(this, 'register')" name="mobile_number"
                                                    minlength="10" maxlength="10" required class="form-control"
                                                    placeholder="Mobile number">
                                                <i class="ti-mobile"></i>
                                                <button class="btn theme-bg text-white append"
                                                    onclick="sendOtp('register')" type="button">
                                                    Get Otp
                                                </button>
                                            </div> --}}
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
                                                <button class="btn theme-bg text-white append"
                                                    onclick="verifyOtp('register')" type="button">
                                                    Verify
                                                </button>
                                            </div>
                                            {{-- <div class="input-with-icon with-append">
                                                <input type="number" name="mobile_otp" id="mobile_otp_register"
                                                    minlength="6" maxlength="6" required class="form-control"
                                                    placeholder="Input OTP">
                                                <i class="ti-key"></i>
                                                <button class="btn theme-bg text-white append"
                                                    onclick="verifyOtp('register')" type="button">
                                                    Verify
                                                </button>
                                            </div> --}}
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
                                                    <button class="btn theme-bg togglePassword" type="button">
                                                        <i class="fas fa-eye text-white"></i>
                                                    </button>
                                            </div>
                                            {{-- <div class="input-with-icon">
                                                <input type="password" name="password" id="password" type="password"
                                                    class="form-control" placeholder="Password" required
                                                    minlength="5" oninput="validatePassword(this)">
                                                <i class="ti-unlock"></i>
                                            </div> --}}
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
                                                <button class="btn theme-bg togglePassword" type="button">
                                                    <i class="fas fa-eye text-white"></i>
                                                </button>
                                            </div>
                                            {{-- <div class="input-with-icon">
                                                <input type="password" name="confirm_password" id="confirm_password_new"
                                                    class="form-control" placeholder="Confirm Password" required
                                                    minlength="5" oninput="inputConfirmPassword(this)">
                                                <i class="ti-unlock"></i>
                                            </div> --}}
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
                                                <button class="btn theme-bg text-white append"
                                                    onclick="verifyInstitute()" type="button">
                                                    Verify
                                                </button>
                                                {{-- <button class="btn theme-bg text-white append" type="button"
                                                    onclick="verifyInstitute()">
                                                    <i class="ti-check-box"></i>
                                                </button> --}}
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
                                            Test and Notes's <a href="{{ url('public/'. $pdf->url) }}" class="theme-cl" target="_blank">Terms of
                                                Services</a></label>
                                                @else
                                                <label for="required_check_registration" class="checkbox-custom-label">I agree
                                            to The
                                            Test and Notes's <a href="#" class="theme-cl">Terms of
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

    var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
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

        $(".register").on('click',function(){
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
    }).done(function (data) {
        console.log(data);
        if (data && data.success) {
            const classes = data.message;
            var options = '<option value="">Class / Group / Exam</option>';
            if (classes.length > 0) {
                $(classes).each(function (index, item) {
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
    }).fail(function (data) {
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
