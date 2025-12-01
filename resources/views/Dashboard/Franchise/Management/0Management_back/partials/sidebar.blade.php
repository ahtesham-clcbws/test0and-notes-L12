<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky">
        <div class="user-details text-center py-3">
            <img class="rounded-circle"
            src="{{ auth()->user()->user_details['photo_url'] ? '/storage/app/'. auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{ auth()->user()->name }} <br>
                <!-- <small>{{ auth()->user()->myInstitute['institute_name'] }}</small><br> -->
                <small>{{auth()->user()->myInstitute->branch_code}}</small>
            </h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('franchise.management.dashboard') }}">
                    <i class="bi bi-house-fill"></i>
                    Dashboard
                </a>
            </li>
            {{--<li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#franchise-user-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Users
                </a>
                <div class="collapse" id="franchise-user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['new']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['students']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['creators']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['publishers']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['managers']) }}">
                                Managers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.users_type', ['multi']) }}">
                                Multi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#franchise-adduser-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Add Users
                </a>
                <div class="collapse" id="franchise-adduser-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('franchise.add_user') }}">
                                Add User
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#admin-contributors-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Admin & Contributors
                </a>
                <div class="collapse" id="admin-contributors-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#course-details-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Course Details
                </a>
                <div class="collapse" id="course-details-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#test-quizes-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Test & Quizes
                </a>
                <div class="collapse" id="test-quizes-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.management.dashboard_tests_list') }}">
                                All Test
                            </a>
                            <a class="nav-link" href="{{ route('franchise.management.dashboard_add_exams') }}">
                                Add Test
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#study-material-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Study Material
                </a>
                <div class="collapse" id="study-material-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#schedule-tests-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Schedule Tests
                </a>
                <div class="collapse" id="schedule-tests-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#upload-download-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Upload & Download
                </a>
                <div class="collapse" id="upload-download-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#solution-suggestion-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Solution & Suggestion
                </a>
                <div class="collapse" id="solution-suggestion-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#result-rank-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Result & Rank
                </a>
                <div class="collapse" id="result-rank-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#settings-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Settings
                </a>
                <div class="collapse" id="settings-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_settings') }}">
                                Dashboard Boxes
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
        </ul>
    </div>
</nav>
