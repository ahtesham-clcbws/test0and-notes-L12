<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky">
        <div class="user-details text-center py-3">
            <img class="rounded-circle" 
            src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/'.auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{auth()->user()->name}}<br>
                {{-- <small><small>Director</small></small> --}}
            </h5>
        </div>
        <ul class="nav flex-column">
        <li class="nav-item" style="border: 1px solid black;">
                <a class="nav-link active" aria-current="page" href="{{ route('home_page') }}">
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
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link" aria-current="page" href="{{ route('student.dashboard') }}">
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
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#course-details-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-course.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Course Details
                        </div>
                    </div>
                </a>
                <div class="collapse" id="course-details-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
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
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
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
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
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
                                @if(auth()->user()->user_details['education_type'] == 51)                              
                                    Static GK & Current Affairs
                                @endif
                                @if(auth()->user()->user_details['education_type'] == 52)                              
                                    Comprehensive Study Material
                                @endif
                               
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#schedule-tests-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-shedual.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Schedule Tests
                        </div>
                    </div>
                    
                </a>
                <div class="collapse" id="schedule-tests-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#upload-download-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/test_attempt.png') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Upload & Download
                        </div>
                    </div>
                    
                </a>
                <div class="collapse" id="upload-download-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#solution-suggestion-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/test_attempt.png') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                           Solution & Suggestion
                        </div>
                    </div>
                    
                </a>
                <div class="collapse" id="solution-suggestion-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#result-rank-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-result.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Result & Rank
                        </div>
                    </div>
                    
                </a>
                <div class="collapse" id="result-rank-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item" style="border-bottom: 1px solid black;">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#settings-collapse" aria-expanded="false">
                    <div class="row">
                        <div class="col-4">
                            <img class="box_icon" src="{{ asset('student1/images/menu-setting.jpeg') }}">
                        </div>
                        <div class="col-8" style="margin:auto;">
                            Settings
                        </div>
                    </div>
                    
                </a>
                <div class="collapse" id="settings-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard_settings') }}">
                                Dashboard Boxes
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
