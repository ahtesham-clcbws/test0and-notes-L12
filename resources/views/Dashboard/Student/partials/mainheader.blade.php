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

    .flex-container {
      display: flex;
      flex-direction: row;
      font-size: 30px;
      text-align: center;
      margin-top:100px;
    }
    .flex-item-left {
      /*background-color: #f1f1f1;*/
      padding: 10px;
      flex: 50%;
      color:brown;
      font-family:'cursive-font', serif;

    }

</style>
<header class="navbar navbar-dark sticky-top bg-white flex-md-nowrap p-0 shadow cust-header" style="background-color: #c4e9fa !important;">
    <div class="navbar-brand col-md-3 col-lg-2 m-0 p-2 bg-white text-center">
        <img src="{{ asset('super/images/logo big size.png') }}" style="max-height: 50px; width: auto;">
    </div>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav w-100 nav-panel info-panel" style="background-color: #c4e9fa !important;">
        <li class="nav-item" style="margin: 0px 10px">
            <span class="required_text">
                @if(auth()->user()->franchise_code)
                    {{ auth()->user()->myInstitute->institute_name }} : {{ DB::table('cities')->select('name')->where('id',auth()->user()->myInstitute->city_id)->first()->name }}
                @else
                    <span class="required_num">21</span>
                @endif
            </span>
        </li>
        <li class="nav-item" style="margin: 0px 10px">
            <i class="watch_ic bi bi-clock-history"></i>
            <span class="required_text">
                Subscription : 17 March 2023
            </span>
        </li>
        <li class="nav-item" style="margin: 0px 10px">
            <i class="watch_ic bi bi-clock-history"></i>
            <span class="required_text">
                My Study Packages
            </span>
            <span class="required_num">21</span>
        </li>
    </ul>
    <ul class="nav nav-panel icons-panel justify-content-end me-4" style="background-color: #c4e9fa !important;">
        <li class="nav-item user-menu dropdown profile-dropdown">
            <img class="nav-link rounded-circle dropdown-toggle" data-bs-toggle="dropdown" id="userMenu"
                src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/'.auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <div class="dropdown-content panel-collapse profile-noti dropdown-menu dropdown-menu-end"
                aria-labelledby="userMenu">
                <div class="profile-box">
                    <img src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/'.auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
                    <h6>{{auth()->user()->name}}</h6>
                </div>
                <ul>
                    <li><a href="{{route('student.profile')}}"><i class="bi bi-person" aria-hidden="true"></i> <span> Profile</span></a></li>

                    <li><a href="{{ url('resetpassword_student')}}"><i class="bi bi-key" aria-hidden="true"></i><span> Reset Password</span></a></li>
                    <li class="last_rad"><a href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                            <span> Sign Out</span>
                        </a>
                     </li>
                </ul>
            </div>
        </li>
    </ul>

</header>
