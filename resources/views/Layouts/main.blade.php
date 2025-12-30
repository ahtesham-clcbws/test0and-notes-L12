<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="description" content="">
    <!-- responsive tag -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    <!-- bootstrap v4 css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}">
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
    <!-- rsmenu CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/rsmenu-main.css') }}">
    <!-- rsmenu transitions CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/rsmenu-transitions.css') }}">
    <!-- magnific popup css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/magnific-popup.css') }}">
    <!-- flaticon css  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/flaticon.css') }}">
    <!-- flaticon2 css  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fonts2/flaticon.css') }}">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .input-group .form-control {
            border-radius: .25rem !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

    </style>
</head>

<body class="inner-page">
    <div class="full-width-header">
        <!-- Toolbar Start -->
        <div class="rs-toolbar">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rs-toolbar-left">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="rs-toolbar-right">
                            <div class="toolbar-share-icon">
                                <a href="#" class="cource-btn2" data-toggle="modal" data-target="#myModal3">Corporate
                                    Enquiry</a>

                                <?php if (isset($_SESSION['users_logged_in']) && $_SESSION['users_logged_in'] == true) { ?>
                                <a href="logout.php" class="cource-btn2">Logout,
                                    <?= $_SESSION['users']['full_name'] ? $_SESSION['users']['full_name'] : $_SESSION['users']['user_name'] ?></a>
                                <?php } else { ?>
                                <a href="#" class="cource-btn2" data-toggle="modal" data-target="#myModal2">Login /
                                    Registration</a>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hedr2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="main-menu">
                            <a class="rs-menu-toggle"><i class="fa fa-bars"></i></a>
                            <nav class="rs-menu rs-menu-close pdnv tonv">
                                <ul class="nav-menu menu3">
                                    <!-- Home -->
                                    <li class="current-menu-item current_page_item menu-item-has-children"> <a
                                            href="#"><span class="spclr">Free For You</span></a>
                                        <span class="rs-menu-parent"><i class="fa fa-angle-down"
                                                aria-hidden="true"></i></span>
                                    </li>
                                    <!-- End Home -->
                                    <!--About Menu Start-->
                                    <li class="menu-item-has-children"> <a href="#">Previous Papers</a>
                                        <span class="rs-menu-parent"><i class="fa fa-angle-down"
                                                aria-hidden="true"></i></span>
                                    </li>
                                    <!--About Menu End-->
                                    <!-- Drop Down Pages Start -->
                                    <li class="rs-mega-menu mega-rs"> <a href="#">Important Links </a>
                                        <span class="rs-menu-parent"><i class="fa fa-angle-down"
                                                aria-hidden="true"></i></span>
                                    </li>
                                    <!--Drop Down Pages End -->
                                    <!--Courses Menu Start-->
                                    <li class="menu-item-has-children"> <a href="#">Notifications</a>
                                        <span class="rs-menu-parent"><i class="fa fa-angle-down"
                                                aria-hidden="true"></i></span>
                                    </li>
                                    <!--Courses Menu End-->
                                    <!--Events Menu Start-->
                                    <!--End Icons -->
                                    <!--blog Menu Start-->
                                    <li class="#"> <a href="#">GK & Current</a>
                                    </li>
                                    <li class="#"> <a href="#">Earn with Us</a>
                                    </li>
                                    <!--blog Menu End-->
                                    <!--Contact Menu Start-->
                                    <li> <a href="contact.html"><span class="spclr">Book Store</span></a></li>
                                    <!--Contact Menu End-->
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="srcc">
                            <i class="fa fa-search srcc_icn"></i>
                            <input type="text" class="search-query form-control txpdg">
                            <img class="spgbg" src="/images/icon/bg.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog md_wdd">
                <div class="modal-content mdlwd2">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <div class="lg_mn">
                            <img src="/images/lg.jpg" alt="logo">
                            <span>Log in to enter the New World of Education</span>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body mdbdy2">
                        <div class="form-div">
                            <form method="post" id="loginform">
                                <div class="input-group inpbdr">
                                    <div class="input-group-prepend clrpd">
                                        <span class="input-group-text urclr"><img src="/images/user.png"
                                                alt=""></span>
                                    </div>
                                    <input type="text" name="email" id="inputEmail" class="form-control"
                                        placeholder="Email address Or User Name">
                                </div>
                                <div class="input-group inpbdr">
                                    <div class="input-group-prepend clrpd">
                                        <span class="input-group-text urclr"><img src="/images/look.png"
                                                alt=""></span>
                                    </div>
                                    <input type="password" name="password" id="inputPassword" class="form-control"
                                        placeholder="password">
                                </div>
                                <div class="form-check ckbok2">
                                    <label class="form-check-label">
                                        <input class="form-check-input ckbok" type="checkbox">
                                        <p>Remember me </a>
                                    </label>
                                </div>
                                <span class="trg_tx"><a href="#">Forgot Password?</a></span>
                                <div id="loginmessage"></div>
                                <div class="smbtn2_mn">
                                    <button type="submit" id="loginbtn" name="login" class="smbtn2">Sign
                                        in</button>
                                    <span>or</span>
                                </div>
                                <button type="submit" class="smbtn3"><img src="/images/gml.png" alt="">
                                    Sign in with verified Gmail account</button>
                                <div class="ac_tx">
                                    <p>Don’t have an account <span><a href="#">Register now</a></span></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Corporate Enquiry Modal -->
        <div class="modal fade" id="myModal3">
            <div class="modal-dialog">
                <div class="mdlcl">
                    <div class="modal-content mdlwd">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <div class="mnw">
                                <div class="egls_mn">
                                    <img src="/images/icon/web2.jpg" alt="">
                                    <select class="form-control engg2">
                                        <option id="Male" value="M" selected="">English</option>
                                        <option id="FeMale" value="FM">Hidhi</option>
                                        <option id="NotInterested" value="NI">Not interested</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="res_mn">
                            <h2>Corporate Enquiry</h2>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body modl_hit">
                            <div class="form-div">
                                <form action="" method="post" id="franchiseForm" onsubmit="return false;">

                                    <div class="col-md-12" id="corporateMessage"></div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="nmclr"> Name*</label>
                                            <input name="name" id="fname" class="form-control fmbg2"
                                                placeholder="Your name" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Mobile*</label>
                                                    <input type="number" name="mobile" id="corporate_number"
                                                        minlength="10" maxlength="10" class="form-control fmbg2"
                                                        placeholder="Mobile no wthout zero" value="">
                                                    <button type="button" class="btn otp-btn contactsubmitbtn2"
                                                        onclick="getRegisterOtp('corporate_number')">Get OTP</button>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="nmclr">OTP*</label>
                                                    <input type="number" name="corporate_otp" id="corporate_otp"
                                                        minlength="6" maxlength="6" min="111111" max="999999"
                                                        class="form-control fmbg2" placeholder="Input your OTP here"
                                                        required="" autofocus="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Institute / School / Brand
                                                        Name</label>
                                                    <input name="institute_name" id="institute_name"
                                                        class="form-control fmbg2"
                                                        placeholder="Coaching Centre / Brand Name">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Address</label>
                                                    <input name="address" id="corporate_address"
                                                        class="form-control fmbg2"
                                                        placeholder="City / District Name (State)" type="text">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">City*</label>
                                                    <input name="city" id="corporate_city" class="form-control fmbg2"
                                                        placeholder="City/ District Name (State)">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Pin Code</label>
                                                    <input name="pincode" id="corporate_pincode"
                                                        class="form-control fmbg2" placeholder="Pin code">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">ESTABLISHED YEAR</label>
                                                    <select id="established_year" name="established_year"
                                                        class="form-control fmbg2 htee2" required=""
                                                        aria-required="true">
                                                        <option value="">2001</option>
                                                        <option value="1 Person">Test Series</option>
                                                        <option value="2 Person">Study Material</option>
                                                        <option value="3 Person">Scholarship</option>
                                                        <option value="Family Pack">Corporate Enquiry</option>
                                                        <option value="Family Pack">Other Reason</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Type of Institute or centre</label>
                                                    <select id="institute_type" name="institute_type"
                                                        class="form-control fmbg2 htee2" required=""
                                                        aria-required="true">
                                                        <option value="">Academics (6th -10th)</option>
                                                        <option value="1 Person">Test Series</option>
                                                        <option value="2 Person">Study Material</option>
                                                        <option value="3 Person">Scholarship</option>
                                                        <option value="Family Pack">Corporate Enquiry</option>
                                                        <option value="Family Pack">Other Reason</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">You are interested For </label>
                                                    <select id="interested_for" name="interested_for"
                                                        class="form-control fmbg2 htee2" required=""
                                                        aria-required="true">
                                                        <option value="">Test Series & Study Material</option>
                                                        <option value="1 Person">Test Series</option>
                                                        <option value="2 Person">Study Material</option>
                                                        <option value="3 Person">Scholarship</option>
                                                        <option value="Family Pack">Corporate Enquiry</option>
                                                        <option value="Family Pack">Other Reason</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="nmclr">E-MAIL id</label>
                                                    <input type="email" name="email" id="corporate_email"
                                                        class="form-control fmbg2" placeholder="Your e-mail id"
                                                        required="" autofocus="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="pkus_icon">
                                            <a href="javascript:void(0)" onclick="$('#pro-image').click()">
                                                <span><img src="/images/icon/att2.jpg" alt=""></span>
                                                <p>Institute / School / Brand (Logo)</p>
                                            </a>
                                            <input type="file" id="pro-image" name="pro-image[]" style="display: none;"
                                                class="form-control" multiple="">
                                        </div>
                                        <div class="form-check ckktx">
                                            <label class="form-check-label">
                                                <input class="form-check-input ckbok" name="corporate_terms"
                                                    type="checkbox">
                                                <p> I agree to The gyanology's </p>
                                                <a href="">Terms of Services</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="fm_smt2">
                                        <button type="submit" id="corporateSubmitBtn" name="formname"
                                            value="frachiseForm">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="mdlcl">
                    <div class="modal-content mdlwd">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <div class="mnw">
                                <div class="egls_mn">
                                    <img src="/images/icon/web2.jpg" alt="">
                                    <select class="form-control engg2">
                                        <option id="Male" value="M" selected="">English</option>
                                        <option id="FeMale" value="FM">Hidhi</option>
                                        <option id="NotInterested" value="NI">Not interested</option>
                                    </select>
                                </div>
                                <div class="alr_mn2">
                                    <p style="color: #ed028c; font-weight: 600; font-size: 18px; padding-top: 3px;">
                                        Already have an account?</p>
                                    <a href="javascript:void(0);" class="cource-btn2"
                                        onclick="loginModal();">Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="res_mn">
                            <h2>REGISTRATION FORM</h2>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body modl_hit">
                            <div class="form-div">
                                <form id="signup_form" method="post">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="nmclr"> Name*</label>
                                            <input name="full_name" id="full_name" class="form-control fmbg2"
                                                placeholder="Your name" type="text">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                   <label class="nmclr">Mobile*</label>
                                   <input type="text" name="mobile_number" id="mobile_number" class="form-control fmbg2" placeholder="Mobile no wthout zero" value="">
                                   <button type="submit" class="btn otp-btn contactsubmitbtn2">Get OTP</button>
                                </div>
                             </div> -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Mobile*</label>
                                                    <input type="number" minlength="10" maxlength="10"
                                                        name="mobile_number" id="mobile_number"
                                                        class="form-control fmbg2" placeholder="Mobile no wthout zero"
                                                        value="">
                                                    <button type="button" class="btn otp-btn contactsubmitbtn2"
                                                        onclick="getRegisterOtp('mobile_number')">Get OTP</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Otp*</label>
                                                    <input type="number" name="mobile_otp" minlength="6" maxlength="6"
                                                        min="111111" max="999999" id="mobile_otp"
                                                        class="form-control fmbg2" placeholder="Mobile OTP">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">City*</label>
                                                    <input name="city" id="city" class="form-control fmbg2"
                                                        placeholder="Your city name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="nmclr">Country *</label>
                                                    <select id="country" name="country"
                                                        class="form-control fmbg2 htee2" required=""
                                                        aria-required="true">
                                                        <option value="">India</option>
                                                        <option value="1 Person">Test Series</option>
                                                        <option value="2 Person">Study Material</option>
                                                        <option value="3 Person">Scholarship</option>
                                                        <option value="Family Pack">Corporate Enquiry</option>
                                                        <option value="Family Pack">Other Reason</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="nmclr">Email *</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control fmbg2" placeholder="Email" required=""
                                                        autofocus="">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="nmclr">User ID*</label>
                                                    <input type="text" name="user_name" id="user_name"
                                                        class="form-control fmbg2" placeholder="Create user ID"
                                                        required="" autofocus="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-6">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-group">
                                                    <label class="nmclr">Password*</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control fmbg2" placeholder="Create password"
                                                        required="" autofocus="">
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text"
                                                            onclick="togglePassword('password')"><i id="eyeIconpassword"
                                                                class="fa fa-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input-group">
                                                    <label class="nmclr">Confirm Password*</label>
                                                    <input type="password" name="confirm_password" id="confirm_password"
                                                        class="form-control fmbg2" placeholder="Retype your password"
                                                        required="" autofocus="">
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text"
                                                            onclick="togglePassword('confirm_password')"><i
                                                                id="eyeIconconfirm_password"
                                                                class="fa fa-eye"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group mb-otp">
                                            <label class="nmclr">Institute / Branch Code* </label>
                                            <input type="text" name="code" class="form-control fmbg2"
                                                placeholder="Your institute Code (Provided by the institute)" value="">
                                            <button type="submit" class="btn otp-btn contactsubmitbtn">confirm</button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="pkus_icon">
                                            <a href="javascript:void(0)" onclick="$('#pro-image').click()">
                                                <span><img src="/images/icon/att2.jpg" alt=""></span>
                                                <p>You can attach pdf / jpeg / png files (max size: 100 kb)</p>
                                            </a>
                                            <input type="file" id="pro-image" name="pro-image[]" style="display: none;"
                                                class="form-control" multiple="">
                                        </div>
                                        <div class="form-check ckktx">
                                            <label class="form-check-label">
                                                <input class="form-check-input ckbok" type="checkbox">
                                                <p> I agree to The gyanology's </p>
                                                <a href="">Terms of Services</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="registerMessage"></div>

                                    <div class="fm_smt2">
                                        <button type="submit" name="signup" id="signupbtn">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Header Start-->
        <header id="rs-header-2" class="rs-header-2">
            <!-- Menu Start -->
            <div class="menu-area menu-sticky">
                <div class="container">
                    <div class="row rs-vertical-middle">
                        <div class="col-lg-2 col-md-12">
                            <div class="logo-area">
                                <a href="index.php"><img src="/images/logo.png" alt="logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-12">
                            <div class="main-menu">
                                <a class="rs-menu-toggle"><i class="fa fa-bars"></i></a>
                                <nav class="rs-menu rs-menu-close pdnv">
                                    <ul class="nav-menu">
                                        <!-- Home -->
                                        <li class="current-menu-item current_page_item menu-item-has-children">
                                            <a href="index.php" class="home">HOME</a>
                                        </li>
                                        <!-- End Home -->
                                        <!--About Menu Start-->
                                        <li class="menu-item-has-children"> <a href="#">ABOUT US</a>
                                        </li>
                                        <!--About Menu End-->
                                        <!-- Drop Down Pages Start -->
                                        <li class="rs-mega-menu mega-rs">
                                            <a href="#">ACADEMIC </a>
                                            <ul class="mega-menu">
                                                <li class="mega-menu-container">
                                                    <div class="mega-menu-innner">
                                                        <div class="single-magemenu">
                                                            <ul class="sub-menu">
                                                                <li><a href="#">Blog</a></li>
                                                                <li><a href="#">Blog Details</a></li>
                                                                <li><a href="#">Blog Details</a></li>
                                                                <li><a href="#">Blog Details</a></li>
                                                                <li><a href="#">Blog Details</a></li>
                                                                <li><a href="#">Blog Details</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="single-magemenu">
                                                            <ul class="sub-menu">
                                                                <li> <a href="#">Teachers</a> </li>
                                                                <li> <a href="#">Teachers Without Filter</a> </li>
                                                                <li> <a href="#">Teachers Single</a> </li>
                                                                <li> <a href="#">Contact</a></li>
                                                                <li> <a href="#">Teachers Single</a> </li>
                                                                <li> <a href="#">Contact</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="single-magemenu">
                                                            <ul class="sub-menu">
                                                                <li> <a href="gallery.html">Gallery </a> </li>
                                                                <li> <a href="#">Gallery Two</a> </li>
                                                                <li> <a href="#">Gallery Three</a> </li>
                                                                <li> <a href="#">Gallery Three</a> </li>
                                                                <li> <a href="#">Gallery Three</a> </li>
                                                                <li> <a href="#">Gallery Three</a> </li>
                                                            </ul>
                                                        </div>
                                                        <div class="single-magemenu">
                                                            <ul class="sub-menu">
                                                                <li> <a href="#">Shop</a> </li>
                                                                <li> <a href="#">Shop Details</a> </li>
                                                                <li><a href="#">Cart</a></li>
                                                                <li><a href="#">Checkout</a></li>
                                                                <li><a href="#">Cart</a></li>
                                                                <li><a href="#">Checkout</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <!--Drop Down Pages End -->
                                        <!--Courses Menu Start-->
                                        <li class="menu-item-has-children"> <a href="#">GOVT EXAMS</a>
                                        </li>
                                        <!--Courses Menu End-->
                                        <!--Events Menu Start-->
                                        <li class="#">
                                            <a href="#">ONLINE TEST</a>
                                            <ul class="sub-menu">
                                                <li><a href="courses.html">Courses One</a></li>
                                                <li><a href="courses2.html">Courses Two</a></li>
                                                <li><a href="courses-details.html">Courses Details</a></li>
                                                <li><a href="courses-details2.html">Courses Details 2</a></li>
                                                <div class="sub-menu-close"><i class="fa fa-times"
                                                        aria-hidden="true"></i>Close</div>
                                            </ul>
                                        </li>
                                        <!--End Icons -->
                                        <!--blog Menu Start-->
                                        <li class="#">
                                            <a href="#">STUDY MATERIAL</a>
                                            <ul class="sub-menu">
                                                <li><a href="courses.html">Courses One</a></li>
                                                <li><a href="courses2.html">Courses Two</a></li>
                                                <li><a href="courses-details.html">Courses Details</a></li>
                                                <li><a href="courses-details2.html">Courses Details 2</a></li>
                                                <div class="sub-menu-close"><i class="fa fa-times"
                                                        aria-hidden="true"></i>Close</div>
                                            </ul>
                                        </li>
                                        <li class="#">
                                            <a href="#">VIDEO CLASSES </a>
                                            <ul class="sub-menu">
                                                <li><a href="courses.html">Courses One</a></li>
                                                <li><a href="courses2.html">Courses Two</a></li>
                                                <li><a href="courses-details.html">Courses Details</a></li>
                                                <li><a href="courses-details2.html">Courses Details 2</a></li>
                                                <div class="sub-menu-close"><i class="fa fa-times"
                                                        aria-hidden="true"></i>Close</div>
                                            </ul>
                                        </li>
                                        <!--blog Menu End-->
                                        <!--Contact Menu Start-->
                                        <li> <a href="contact.php">CONTACT US</a></li>
                                        <!--Contact Menu End-->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu End -->
        </header>
        <!--Header End-->
    </div>

    @yield('main')

    <div class="footer_btm">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="copyright">
                        <p>
                            <span>© 2021 BR TECHGEEKS PRIVATE LIMITED All Rights Reserved. </span>
                        </p>
                        <div class="credits">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="scrollUp">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Search Modal Start -->
    <div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="fa fa-close"></span>
        </button>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="search-block clearfix">
                    <form>
                        <div class="form-group">
                            <input class="form-control" placeholder="Search.." type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .input-group .fmbg2 {
            border-radius: 5px 0 0 5px !important;
        }
    </style>
    <!-- modernizr js -->
    <script src="{{ asset('js/modernizr-2.8.3.min.js') }}"></script>
    <!-- jquery latest version -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap4.min.js') }}"></script>
    <!-- owl.carousel js -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <!-- slick.min js -->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <!-- isotope.pkgd.min js -->
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <!-- imagesloaded.pkgd.min js -->
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <!-- counter top js -->
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <!-- rsmenu js -->
    <script src="{{ asset('js/rsmenu-main.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>

    <script>
        jQuery(document).ready(function($) {

            $(".btnrating").on('click', (function(e) {

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
        });
    </script>
    <script>
        function loginModal() {
            $("#myModal").modal('show');
            $("#myModal2").modal('hide');
        }
    </script>
    <script>
        jQuery(document).ready(function($) {

            $(".btnrating").on('click', (function(e) {

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


        });
    </script>
    <script>
        function getRegisterOtp(inputId) {
            // console.log('register otp clicked');
            if ($('#' + inputId) && $('#' + inputId).val() != '' || null) {
                if ($('#' + inputId).val().length == 10) {
                    const data = {
                        signup_otp: true,
                        mobile_number: $('#' + inputId).val()
                    }
                    console.log(data);
                    $.ajax({
                        url: 'signupajax.php',
                        type: 'POST',
                        data: data,
                        // dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            var res = JSON.parse(response);
                            if (res.success) {
                                var mobile = $('#' + inputId).val();
                                alert('Otp is send to your Number (' + mobile + '), please check.');
                            } else {
                                alert('There is some error sending OTP, please try again later.');
                            }
                        }
                    });
                } else {
                    alert('please enter valid mobile number.');
                }
            } else {
                alert('please input mobile number.');
            }
        }

        async function getOldOtp() {
            const data = {
                getOldOtp: true
            }
            await $.ajax({
                url: 'signupajax.php',
                type: 'POST',
                data: data,
                // dataType: 'json',
                success: function(response) {
                    console.log(response);
                    return response;
                }
            });
        }

        function verifyRegisterOtp(otp) {
            const data = {
                signup_otp_verify: true,
                otp_to_verify: otp
            }
            $.ajax({
                url: 'signupajax.php',
                type: 'POST',
                data: data,
                // dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        return true;
                    }
                    return false;
                }
            });
        }
        $(document).ready(function() {
            if ($('#loginform')) {
                $('#loginform').validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {
                        email: {
                            required: 'please enter email',
                        },
                        password: {
                            required: 'please enter password',
                        }
                    },
                    submitHandler: function() {
                        var formData = $('#loginform').serialize();
                        $('#loginbtn').attr('disabled', true);
                        $('#loginbtn').html('Please wait ...');

                        console.log('login started');

                        $.ajax({
                            url: 'loginajax.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                console.log('login request completed')
                                $('#loginbtn').removeAttr('disabled');
                                $('#loginbtn').html('Sign In');
                                if (response.error == 0) {
                                    $('.loginmessage').html(
                                        '<div class="alert alert-success">' + response
                                        .message + '</div>');
                                    $('#loginform').trigger("reset");
                                    // setTimeout(function() {
                                    window.location.reload();
                                    // }, 1500);
                                } else {
                                    $('#loginmessage').html(
                                        '<div class="alert alert-danger">' + response
                                        .message + '</div>');
                                }
                            }
                        });


                    }
                });
            }
            if ($('#signup_form')) {
                $('#signup_form').validate({
                    rules: {
                        full_name: {
                            required: true,
                        },
                        user_name: {
                            required: true,
                            minlength: 3
                        },
                        mobile_number: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10,
                        },
                        // mobile_otp_to_send: {
                        //    required: true
                        // },
                        mobile_otp: {
                            required: true,
                            number: true,
                            minlength: 6,
                            maxlength: 6,
                            // equalTo: 'getRegisterOtp()'
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password"
                        },
                        city: {
                            required: true,
                        },
                        country: {
                            required: true,
                        },
                        institute_code: {
                            minlength: 8,
                        },
                    },
                    messages: {
                        full_name: {
                            required: 'please enter full name',
                        },
                        user_name: {
                            required: 'please enter user name',
                        },
                        mobile_number: {
                            required: 'please enter valid mobile number',
                            number: 'Only numbers allowed',
                            minlength: 'please enter minimum 10 digit mobile number',
                            maxlength: 'please enter maximum 10 digit mobile number',
                        },
                        mobile_otp: {
                            required: 'please enter valid OTP',
                            number: 'Only numbers allowed',
                            minlength: 'please enter minimum 6 digit mobile number',
                            maxlength: 'please enter maximum 6 digit mobile number',
                            equalTo: 'OTP not match.'
                        },
                        email: {
                            required: 'please enter email',
                        },
                        password: {
                            required: 'please enter password',
                        },
                        confirm_password: {
                            required: 'please enter password again',
                            equalTo: 'Passwords must be same'
                        },
                        city: {
                            required: 'please enter City',
                        },
                        country: {
                            required: 'please select country',
                        },
                        institute_code: {
                            minlength: 'Institute code must be minimum 8 letters',
                        },
                    },
                    submitHandler: function() {
                        var formData = $('#signup_form').serialize();

                        console.log(formData);
                        // return;

                        const newOtp = $('#mobile_otp').val();

                        const otpData = {
                            getOldOtp: true
                        }
                        $.ajax({
                            url: 'signupajax.php',
                            type: 'POST',
                            data: otpData,
                            // dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                if (newOtp == response) {
                                    $('#signupbtn').attr('disabled', true);
                                    $('#signupbtn').html('Submiting ...');
                                    $.ajax({
                                        url: 'signupajax.php',
                                        type: 'POST',
                                        data: formData,
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response)
                                            $('#signupbtn').removeAttr(
                                                'disabled');
                                            $('#signupbtn').html('SUBMIT');
                                            if (response.error == 0) {
                                                $('#registerMessage').html(
                                                    '<div class="alert alert-success">' +
                                                    response.message +
                                                    '</div>');
                                                $('#signup_form').trigger(
                                                    "reset");
                                                setTimeout(function() {
                                                    window.location
                                                        .reload();
                                                }, 1500);
                                            } else {
                                                $('#registerMessage').html(
                                                    '<div class="alert alert-danger">' +
                                                    response.message +
                                                    '</div>');
                                            }
                                        }
                                    });
                                } else {
                                    $('#signupbtn').removeAttr('disabled');
                                    $('#signupbtn').html('SUBMIT');
                                    alert('your OTP is incorrect');
                                }
                            }
                        });

                    }
                });
            }
            if ($('#franchiseForm')) {
                $('#franchiseForm').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        mobile: {
                            required: true,
                            number: true,
                            minlength: 10,
                            maxlength: 10,
                        },
                        corporate_terms: {
                            required: true
                        },
                        corporate_otp: {
                            required: true,
                            number: true,
                            minlength: 6,
                            maxlength: 6,
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        address: {
                            required: true,
                        },
                        city: {
                            required: true,
                        },
                        institute_name: {
                            required: true,
                        },
                        pincode: {
                            required: true,
                        },
                        established_year: {
                            required: true,
                        },
                        institute_type: {
                            required: true,
                        },
                        interested_for: {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: 'please enter full name',
                        },
                        mobile: {
                            required: 'please enter valid mobile number',
                            number: 'Only numbers allowed',
                            minlength: 'please enter minimum 10 digit mobile number',
                            maxlength: 'please enter maximum 10 digit mobile number',
                        },
                        corporate_otp: {
                            required: 'please enter valid OTP',
                            number: 'Only numbers allowed',
                            minlength: 'please enter minimum 6 digit mobile number',
                            maxlength: 'please enter maximum 6 digit mobile number',
                            equalTo: 'OTP not match.'
                        },
                        email: {
                            required: 'please enter email',
                        },
                        city: {
                            required: 'please enter City',
                        },
                    },
                    submitHandler: function() {
                        var formData = $('#franchiseForm').serialize();

                        console.log(formData);
                        // return;

                        const newOtp = $('#corporate_otp').val();
                        const corporateSubmitBtn = $('#corporateSubmitBtn');

                        const otpData = {
                            getOldOtp: true
                        }
                        $.ajax({
                            url: 'signupajax.php',
                            type: 'POST',
                            data: otpData,
                            // dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                if (newOtp == response) {
                                    corporateSubmitBtn.attr('disabled', true);
                                    corporateSubmitBtn.html('Submiting ...');
                                    $.ajax({
                                        url: 'corporateAjax.php',
                                        type: 'POST',
                                        data: formData,
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response);
                                            // res
                                            // console.log(JSON.parse(response));
                                            corporateSubmitBtn.removeAttr(
                                                'disabled');
                                            corporateSubmitBtn.html('SUBMIT');
                                            // return;
                                            if (response) {
                                                $('#corporateMessage').html(
                                                    '<div class="alert alert-success">Your query has been successfully submitted, we will get back to you in 48 hours.</div>'
                                                );
                                                $('#franchiseForm').trigger(
                                                    "reset");
                                                setTimeout(function() {
                                                    window.location
                                                        .reload();
                                                }, 2000);
                                            } else {
                                                $('#corporateMessage').html(
                                                    '<div class="alert alert-danger">There has been some error submiting your request, please try agaain later</div>'
                                                );
                                            }
                                            return;
                                        }
                                    });
                                } else {
                                    corporateSubmitBtn.removeAttr('disabled');
                                    corporateSubmitBtn.html('SUBMIT');
                                    alert('your OTP is incorrect');
                                }
                            }
                        });

                    }
                });
            }

            if ($('#generateOtpForm')) {
                $('#generateOtpForm').validate({
                    rules: {
                        contact_mobile: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            number: true
                        }
                    },
                    messages: {
                        contact_mobile: 'Please enter mobile number'
                    }
                });
            }

            if ($('#generateOtpForm')) {
                $('#generateOtpForm').validate({
                    rules: {
                        contact_name: {
                            required: true,
                        },
                        contact_mobile: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            number: true
                        },
                        contact_otp: {
                            required: true,
                        },
                        contact_email: {
                            required: true,
                            email: true
                        },
                        contact_course: {
                            required: true,
                        },
                        contact_city: {
                            required: true,
                        }
                    }
                });
            }

            if ($('#contactsanchorubmitbtn')) {
                $('.contactsanchorubmitbtn').click(function() {
                    $('#submit_type').val(1);
                    $('input, select, textarea').each(function() {
                        $(this).rules('remove', 'required');
                    });
                    $('#contactUsForm').attr('id', 'generateOtpForm');
                    $('#generateOtpForm').submit();
                });
            }

        });
    </script>
    <script>
        function togglePassword(inputId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById('eyeIcon' + inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = 'password';
                icon.classList.remove("fa-eye-slash");
            }
        }
    </script>
</body>

</html>
