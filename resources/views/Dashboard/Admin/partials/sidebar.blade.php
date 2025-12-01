<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky">
        <div class="user-details text-center py-3">
            <img class="rounded-circle"
                src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/app/' . auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{ auth()->user()->name }}<br>
                {{-- <small><small>Director</small></small> --}}
            </h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('administrator.dashboard') }}">
                    <i class="bi bi-house-fill"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#home-collapse" aria-expanded="false">
                    <i class="bi bi-briefcase-fill"></i>
                    Corporate Enquiries
                </a>
                <div class="collapse" id="home-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.corporate_enquiry_type', 'new') }}">
                                New Enquiries
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.corporate_enquiry_type', 'signup') }}">
                                New Sign Up
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.corporate_enquiry_type', 'approved') }}">
                                Approved Enquiries
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.corporate_enquiry_type', 'rejected') }}">
                                Rejected Enquiries
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#franchise-collapse" aria-expanded="false">
                    <i class="bi bi-briefcase-fill"></i>
                    Franchise
                </a>
                <div class="collapse" id="franchise-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.franchise_type', 'compitition') }}">
                                Competition Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.franchise_type', 'academics') }}">
                                Academics Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.franchise_type', 'school') }}">
                                School Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.franchise_type', 'other') }}">
                                Others Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.franchise_type', 'multi') }}">
                                Multi Franchise
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#franchise-user-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Franchise Users
                </a>
                <div class="collapse" id="franchise-user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('administrator.admin_users_list', ['new', 'franchise']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('administrator.admin_users_list', ['students', 'franchise']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('administrator.admin_users_list', ['creators', 'franchise']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('administrator.admin_users_list', ['publishers', 'franchise']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('administrator.admin_users_list', ['managers', 'franchise']) }}">
                                Managers
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#user-collapse" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    Direct Users
                </a>
                <div class="collapse" id="user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.admin_users_list', ['new']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.admin_users_list', ['students']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.admin_users_list', ['creators']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.admin_users_list', ['publishers']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.admin_users_list', ['managers']) }}">
                                Managers
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
                            <a class="nav-link" href="{{ route('administrator.add_user') }}">
                                Add Contributor
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#test-quizes-collapse" aria-expanded="false">
                    <i class="bi bi-easel2-fill"></i>
                    Test & Quizes
                </a>
                <div class="collapse" id="test-quizes-collapse">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_tests_list') }}">
                                Tests List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_add_exams') }}">
                                Add Test
                            </a>
                        </li>
                        <a class="nav-link" href="{{ route('administrator.dashboard_tests_attempt') }}">
                            Test Attempts
                        </a>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.dashboard_eductaion_type') }}">
                    <i class="bi bi-sliders"></i>Education Types
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrator.dashboard_subjects') }}">
                    <i class="bi bi-sliders"></i>Subjects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#study-material-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Study Material
                </a>
                <div class="collapse" id="study-material-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.material') }}">
                                Study Material List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.material_add') }}">
                                Add Study Material
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#plans-list-collapse" aria-expanded="false">
                    <i class="bi bi-coin"></i>
                    Package
                </a>
                <div class="collapse" id="plans-list-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.plan') }}">
                                View Package
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.plan_add') }}">
                                Add Package
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#my-homepage-collapse" aria-expanded="false">
                    <i class="bi bi-question-octagon-fill"></i>
                    Question Bank
                </a>
                <div class="collapse" id="my-homepage-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_question_list') }}">
                                All Questions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_question_add') }}">
                                Add Question
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_question_import') }}">
                                Import Question
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#books-list-collapse" aria-expanded="false">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    Books
                </a>
                <div class="collapse" id="books-list-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.books') }}">
                                All Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.book_add') }}">
                                Add Book
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#students-list-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Students List
                </a>
                <div class="collapse" id="students-list-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
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
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('administrator.course-detail-add')}}">
                                Course Detail Add
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
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
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
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
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
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
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
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
                                Menu
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#revenue-earning-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Revenue & Earning
                </a>
                <div class="collapse" id="revenue-earning-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
                                Dashboard Boxes
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-toggle rounded collapsed" data-bs-toggle="collapse"
                    data-bs-target="#site-statistics-collapse" aria-expanded="false">
                    <i class="bi bi-sliders"></i>
                    Site Statistics
                </a>
                <div class="collapse" id="site-statistics-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
                                Dashboard Boxes
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
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_settings') }}">
                                Dashboard Boxes
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_default_numbers') }}">
                                Default Numbers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.manage_home') }}">
                                Manage Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_add_test_category') }}">
                                Add Test Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrator.dashboard_add_pdf_content') }}">
                                Pdf Content List
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
