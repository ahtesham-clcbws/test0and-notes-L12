<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebarMenu">
    <style>
        .box_icon {
            width: 45px !important;
            height: 45px !important;
        }
    </style>
    <div class="position-sticky">
        <div class="user-details py-3 text-center">
            <img class="rounded-circle"
                src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/' . auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{ auth()->user()->name }}<br>
            </h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item" style="border: 1px solid black;">
                <a class="nav-link active" href="{{ route('home_page') }}" aria-current="page">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-home.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Homepage
                        </div>
                    </div>

                </a>
            </li>
            <li class="nav-item" style="border: 1px solid black;border-top: 0;">
                <a class="nav-link" href="{{ route('student.dashboard') }}" aria-current="page">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/test_attempt.png') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Dashboard
                        </div>
                    </div>

                </a>
            </li>
            <li class="nav-item" style="border: 1px solid black;border-top: 0;">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#test-quizes-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-test.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Test & Quizes
                        </div>
                    </div>

                </a>
                <div class="collapse" id="test-quizes-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_tests_list') }}">
                                Institute Test
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.test-attempt') }}">
                                My Test
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border: 1px solid black;border-top: 0;">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#packages-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-package.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Packages
                        </div>
                    </div>

                </a>
                <div class="collapse" id="packages-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.plan') }}">
                                Packages
                            </a>
                            <a class="nav-link" href="{{ route('student.my-plan') }}">
                                My Packages
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border: 1px solid black;border-top: 0;">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#study-material-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/studymatirial.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Study Material
                        </div>
                    </div>

                </a>
                <div class="collapse" id="study-material-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.show') }}">
                                Study Notes & E-Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.showvideo') }}">
                                Live & Video Classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.showgk') }}">
                                @if (auth()->user()->user_details['education_type'] == 51)
                                    Static GK & Current Affairs
                                @endif
                                @if (auth()->user()->user_details['education_type'] == 52)
                                    Comprehensive Study Material
                                @endif

                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border: 1px solid black;border-top: 0;">
                <a class="nav-link" href="{{ route('student.review.index') }}" aria-current="page">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/test_attempt.png') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Review
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>
