<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ asset('super/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('super/css/all.min.css') }}">
    <!-- <link rel="stylesheet" href="css/tempusdominus-bootstrap-4.min.css"> -->
    <link rel="stylesheet" href="{{ asset('super/css/icheck-bootstrap.min.css') }}">
    <link rel=" stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- <link rel="stylesheet" href="css/adminlte.min.css"> -->
    <link rel="stylesheet" href="{{ asset('super/css/OverlayScrollbars.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento+Sans:wght@400;700&amp;display=swap"
        rel="stylesheet">


    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @yield('css')
</head>

<body>
    <div id="wrapper" class="toggled">
        {{-- <div class="overlay"></div> --}}

        @include('Dashboard.Admin.partials.sidebar')

        @include('Dashboard.Admin.partials.mainheader')
        <!-- Page Content -->
        <div class="content-wrapper" style="min-height: 694.65px; height: 100vh; background-color: #f4f6f9;">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <i class="fa fa-home" aria-hidden="true" style="position: absolute;
                                    font-size: 29px;
                                    margin-left: -38px;
                                    color: gray;
                                    top: 76px;"></i>
                        <div class="col-sm-6">
                            <h1>Super Admin Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">

                            <ul class="navbar-nav dashboard2 second_row_nav">
                                <li class="">
                                    <button class="panel-heading">
                                        <img src="{{ asset('super/images/watch.png') }}" class="watch_ic">
                                    </button>
                                    <div class="dropdown-content panel-collapse noti_box">
                                        <div class="profile-box">
                                            <span class="notif_text">New notifications (5)</span>
                                            <span class="all_read">Mark All Read</span>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                        </ul>
                                        <div class="view_area"><a href="">View All</a></div>
                                    </div>
                                </li>
                                <li class="">
                                    <button class="panel-heading">
                                        <img src="{{ asset('super/images/watch.png') }}" class="watch_ic">
                                    </button>
                                    <div class="dropdown-content panel-collapse noti_box">
                                        <div class="profile-box">
                                            <span class="notif_text">New notifications (5)</span>
                                            <span class="all_read">Mark All Read</span>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                        </ul>
                                        <div class="view_area"><a href="">View All</a></div>
                                    </div>
                                </li>




                                <li class="right_li">
                                    <button class="panel-heading">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <span class="qty">5</span>
                                    </button>


                                    <div class="dropdown-content panel-collapse noti_box">
                                        <div class="profile-box">
                                            <span class="notif_text">New notifications (5)</span>
                                            <span class="all_read">Mark All Read</span>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                        </ul>
                                        <div class="view_area"><a href="">View All</a></div>
                                    </div>




                                </li>

                                <li class="">
                                    <button class="panel-heading">
                                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                                        <span class="qty">5</span>
                                    </button>
                                    <div class="dropdown-content panel-collapse noti_box">
                                        <div class="profile-box">
                                            <span class="notif_text">New notifications (5)</span>
                                            <span class="all_read">Mark All Read</span>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="{{ asset('super/images/watch.png') }}"
                                                        class="noti_icon">
                                                    <span class="noti_text"> Course Package / Book Name
                                                        Details</span>
                                                    <span class="sub_text">Further Details<span>
                                                        </span></span></a>
                                            </li>
                                        </ul>
                                        <div class="view_area"><a href="">View All</a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>


                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            @yield('main')

        </div>
        <!-- /#page-content-wrapper -->

    </div>

    <!-- /#wrapper -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('super/index.js') }}"></script>
    @yield('javascript')

</body>

</html>
