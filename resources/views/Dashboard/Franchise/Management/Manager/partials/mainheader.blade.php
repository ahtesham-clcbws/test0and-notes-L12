<style>
    .profile-noti {
        padding: 0;
        border-radius: 10px;
        width: 220px;
    }


    .profile-box {
        width: 100%;
        float: left;
        border-bottom: 1px solid #d8d8da;
        background: #18c968 !important;
        text-align: center;
        padding: 10px 0 10px 0;
        border-top: 0;
        box-shadow: 0 6px 14px 2px rgb(0 0 0 / 20%);
        border-radius: 10px 10px 0px 0px;
    }

    .profile-box img {
        width: 100px;
        height: 100px;
        display: inline-block;
        border: 1px solid #fff;
        border-radius: 50px;
    }

    .profile-dropdown ul {
        list-style: none;
        padding: 0;
    }

    .profile-dropdown .dropdown-content ul li:nth-child(1) {
        border-top: 0px;
    }

    .last_rad {
        background: rgb(25, 70, 122) !important;
        border-radius: 0px 0px 10px 10px;
    }

    .last_rad a {
        color: #fff !important;
    }

    .profile-dropdown .dropdown-content ul li {
        list-style-type: none;
        border-top: 1px solid #a9a8a5;
        width: 100%;
        float: left;
        margin-left: 0;
        font-weight: 700;
    }

    .profile-dropdown .dropdown-content ul li a {
        padding: 7px 15px;
        float: left;
        width: 100%;
        font-size: 20px;
    }

    .profile-dropdown .dropdown-content ul li a i {
        float: left;
        margin-right: 10px;
    }

    .profile-dropdown .dropdown-content ul li a i,
    .profile-dropdown .dropdown-content ul li a span {
        float: left;
        line-height: 16px;
        font-size: 14px;
        margin-left: 5px;
    }

</style>
<header class="navbar navbar-dark sticky-top bg-white flex-md-nowrap p-0 shadow cust-header">
    {{-- <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Gyanology</a> --}}
    <div class="navbar-brand col-md-3 col-lg-2 m-0 p-2 bg-white text-center">
        <img src="{{ asset('super/images/logo big size.png') }}" style="max-height: 50px; width: auto;">
    </div>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    {{-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> --}}
    <ul class="nav w-100 nav-panel info-panel">
        <li class="nav-item">
            <i class="watch_ic bi bi-clock-history"></i>
            <span class="required_text">
                Required Text
            </span>
            <span class="required_num">21</span>
        </li>
        <li class="nav-item">
            <i class="watch_ic bi bi-clock-history"></i>
            <span class="required_text">
                Required Text
            </span>
            <span class="required_num">21</span>
        </li>
        <li class="nav-item">
            <i class="watch_ic bi bi-clock-history"></i>
            <span class="required_text">
                Required Text
            </span>
            <span class="required_num">21</span>
        </li>
    </ul>
    <ul class="nav nav-panel icons-panel text-end">
        <li class="nav-item">
            <button class="btn btn-link nav-link dropdown-toggle" type="button" id="notifications1"
                data-bs-toggle="dropdown">
                <i class="bi bi-envelope"></i>
                <span class="notify-count">3</span>
            </button>
            <div class="dropdown-content panel-collapse noti_box dropdown-menu dropdown-menu-end"
                aria-labelledby="notifications1">
                <div class="profile-box">
                    <span class="notif_text">New notifications (5)</span>
                    <span class="all_read">Mark all read</span>
                </div>
                <ul>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                </ul>
                <div class="view_area">
                    <a href=""> View All</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <button class="btn btn-link nav-link dropdown-toggle" type="button" id="notifications2"
                data-bs-toggle="dropdown">
                <i class="bi bi-clock-history"></i>
                <span class="notify-count">3</span>
            </button>
            <div class="dropdown-content panel-collapse noti_box dropdown-menu dropdown-menu-end"
                aria-labelledby="notifications2">
                <div class="profile-box">
                    <span class="notif_text">New notifications (5)</span>
                    <span class="all_read">Mark all read</span>
                </div>
                <ul>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                </ul>
                <div class="view_area">
                    <a href=""> View All</a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown custom-dropdown">
            <button class="btn btn-link nav-link dropdown-toggle" type="button" id="notifications3"
                data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="notify-count">3</span>
            </button>
            <div class="dropdown-content panel-collapse noti_box dropdown-menu dropdown-menu-end"
                aria-labelledby="notifications3">
                <div class="profile-box">
                    <span class="notif_text">New notifications (5)</span>
                    <span class="all_read">Mark all read</span>
                </div>
                <ul>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ asset('super/images/watch.png') }}" class="noti_icon">
                            <span class="noti_text"> Course Package / Book Name Details</span>
                            <span class="sub_text">Further Details<span>
                        </a>
                    </li>
                </ul>
                <div class="view_area">
                    <a href=""> View All</a>
                </div>
            </div>
        </li>
        <li class="nav-item user-menu dropdown profile-dropdown">
            <img class="nav-link rounded-circle dropdown-toggle" data-bs-toggle="dropdown" id="userMenu"
                src="{{ auth()->user()->user_details['photo_url'] ? '/storage/' . auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <div class="dropdown-content panel-collapse profile-noti dropdown-menu dropdown-menu-end"
                aria-labelledby="userMenu">
                <div class="profile-box">
                    <img
                        src="{{ auth()->user()->user_details['photo_url'] ? '/storage/' . auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
                    <h6>{{ auth()->user()->name }}</h6>
                    {{-- <p>Admin Manager</p> --}}
                </div>
                <ul>
                    <li>
                        <a href="{{ route('franchise.panel_profile') }}"><i class="bi bi-person"></i> <span>
                            Profile</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-gear"></i><span> Setting</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-clock"></i><span> Offers</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-sliders"></i><span> Information</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-sliders"></i><span> Activity</span></a>
                    </li>
                    <li><a href="{{ url('resetpassword')}}"><i class="bi bi-key" aria-hidden="true"></i><span> Reset Password</span></a></li>
                    <li class="last_rad"><a href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span> Sign Out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    {{-- <div class="navbar-nav d-none d-md-flex d-lg-flex d-xlg-flex d-xxlg-flex">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="{{ route('logout') }}"><span data-feather="log-out"></span></a>
        </div>
    </div> --}}
</header>
