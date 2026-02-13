<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebarMenu">
    <div class="position-sticky">
        <div class="user-details py-3 text-center">
            <img class="rounded-circle"
                src="{{ auth()->user()->institute['logo'] ? '/storage/' . auth()->user()->institute['logo'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{ auth()->user()->institute['institute_name'] }}<br>
                <small>{{ auth()->user()->institute->branch_code }}</small><br>
                <small class="required_text">
                    <i class="telephone_ic bi bi-telephone"></i> {{ auth()->user()->mobile }}
                </small><br>

                <small class="nav-item">
                    <i class="watch_ic bi bi-clock-history"></i>
                    <span class="required_text">
                        {{ date('d-M-Y', strtotime(auth()->user()->institute['started_at'] . ' + ' . intval(auth()->user()->institute['days']) . ' days ')) }}
                    </span>
                    <span
                        style="border: 1px solid #42444a;
    background: #ebebec;
    border-radius: 5px;
    color: #ff0000;
    font-size: 15px;
    text-align: center;
    font-weight: bold;
    padding: 0 5px;
    margin: 0 5px;
    line-height: 26px;">{{ intval(auth()->user()->institute['days']) - round((time() - strtotime(auth()->user()->institute['started_at'])) / (60 * 60 * 24)) . ' days Left' }}</span>
                </small>
            </h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('franchise.dashboard') }}" aria-current="page">
                    <i class="bi bi-house-fill"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#franchise-user-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Users
                </a>
                <div class="collapse" id="franchise-user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['new']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['students']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['creators']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['publishers']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['managers']) }}">
                                Managers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.users_type', ['multi']) }}">
                                Multi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#franchise-adduser-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Add Users
                </a>
                <div class="collapse" id="franchise-adduser-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.add_user') }}">
                                Add User
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#test-quizes-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Test & Quizes
                </a>
                <div class="collapse" id="test-quizes-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.dashboard_tests_list') }}">
                                All Test
                            </a>
                            <a class="nav-link" href="{{ route('franchise.dashboard_add_exams') }}">
                                Add Test
                            </a>
                            <a class="nav-link" href="{{ route('franchise.dashboard_tests_attempt') }}">
                                Test Attempts
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
                    data-bs-target="#study-material-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Study Material
                </a>
                <div class="collapse" id="study-material-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('franchise.management.material') }}">
                                Add Study Material
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
                <a class="nav-link btn-toggle collapsed rounded" data-bs-toggle="collapse"
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
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('franchise.review.index') }}" aria-current="page">
                    <i class="bi bi-star-fill"></i>
                    Review
                </a>
            </li>
        </ul>
    </div>
</nav>
