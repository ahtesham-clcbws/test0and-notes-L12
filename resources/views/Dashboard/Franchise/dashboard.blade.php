@extends('Layouts.franchise')

@section('main')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <i class="fa fa-home" aria-hidden="true" style="    position: absolute;
                            font-size: 29px;
                            margin-left: -38px;
                            color: gray;
                            top: 76px;
                        "></i>
                <div class="col-sm-6">
                    <h1>Contributor Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">

                    <ul class="navbar-nav dashboard2 second_row_nav">
                        <li class="">
                            <button class="panel-heading">
                                <img src="{{ asset('franchise/images/watch.png') }}" class="watch_ic">
                            </button>
                            <div class="dropdown-content panel-collapse noti_box">
                                <div class="profile-box">
                                    <span class="notif_text">New notifications (5)</span>
                                    <span class="all_read">Mark All Read</span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
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
                                <img src="{{ asset('franchise/images/watch.png') }}" class="watch_ic">
                            </button>
                            <div class="dropdown-content panel-collapse noti_box">
                                <div class="profile-box">
                                    <span class="notif_text">New notifications (5)</span>
                                    <span class="all_read">Mark All Read</span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
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
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
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
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
                                            <span class="noti_text"> Course Package / Book Name
                                                Details</span>
                                            <span class="sub_text">Further Details<span>
                                                </span></span></a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset('franchise/images/watch.png') }}" class="noti_icon">
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content admin-1">

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-2 card-1">
                    <div class="card">
                        <div class="part1">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/1.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">New Business Enquiry</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#" style="color: red;"> Action Required!
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 card-2">
                    <div class="card">
                        <div class="part1">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/2.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">Approved Business Enquiry</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#"> View Detail
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-2 card-3">
                    <div class="card">
                        <div class="part1">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/3.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">Rejected Business Enquiry</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#"> View Detail
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 card-4">
                    <div class="card">
                        <div class="part1 new_col">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/4.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">Franchise Discontinue </div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#">View Detail
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 card-5">
                    <div class="card">
                        <div class="part1 new_col">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/5.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">Student Left Direct Portal</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#">View Detail
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-2 card-6">
                    <div class="card">
                        <div class="part1 new_col">
                            <div class="img_area">
                                <img class="box_icon" src="{{ asset('franchise/images/6.png') }}">
                            </div>
                            <div class="head_area">
                                <div class="number">3</div>
                                <div class="num_heading">Contact Forms (This Month)</div>
                            </div>
                        </div>
                        <div class="part2">
                            <div class="box_heading">
                                <a href="#"> View Detail
                                    <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <div class="containerMobile">
            <div class="horizontal-scroll">
                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-1">
                        <div class="card">
                            <div class="part1 ">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/1.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">New Business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#" style="color: red;"> Action Required!
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-2">
                        <div class="card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/2.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">Approved Business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#"> View Detail
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-3">
                        <div class="card">
                            <div class="part1">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/2.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">Approved Business Enquiry</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#"> View Detail
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="horizontal-scroll">
                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-4">
                        <div class="card">
                            <div class="part1 new_col">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/4.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">Franchise Discontinue </div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#">View Detail
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-5">
                        <div class="card">
                            <div class="part1 new_col">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/5.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">Student Left Direct Portal</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#">View Detail
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="horizontal-scroll__item">
                    <div class="col-md-2 card-6">
                        <div class="card">
                            <div class="part1 new_col">
                                <div class="img_area">
                                    <img class="box_icon" src="{{ asset('franchise/images/6.png') }}">
                                </div>
                                <div class="head_area">
                                    <div class="number">3</div>
                                    <div class="num_heading">Contact Forms (This Month)</div>
                                </div>
                            </div>
                            <div class="part2">
                                <div class="box_heading">
                                    <a href="#"> View Detail
                                        <i class="fa fa-arrow-circle-right icon_img" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


    </section>
@endsection
