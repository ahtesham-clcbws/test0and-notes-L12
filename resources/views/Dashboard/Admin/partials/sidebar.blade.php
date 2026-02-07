<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" id="sidebarMenu">
    <div class="position-sticky">
        <div class="user-details py-3 text-center">
            <img class="rounded-circle"
                src="{{ auth()->user()->user_details && auth()->user()->user_details['photo_url'] ? '/storage/' . auth()->user()->user_details['photo_url'] : asset('super/images/default-avatar.jpg') }}">
            <h5>
                {{ auth()->user()->name }}<br>
                {{-- <small><small>Director</small></small> --}}
            </h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('administrator.dashboard') ? 'active' : '' }}"
                    href="{{ route('administrator.dashboard') }}" aria-current="page">
                    <i class="bi bi-house-fill"></i>
                    Dashboard
                </a>
            </li>

            {{-- Corporate Enquiries --}}
            @php $corporateActive = request()->routeIs('administrator.corporate_enquiry*'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $corporateActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#home-collapse"
                    aria-expanded="{{ $corporateActive ? 'true' : 'false' }}">
                    <i class="bi bi-briefcase-fill"></i>
                    Corporate Enquiries
                </a>
                <div class="{{ $corporateActive ? 'show' : '' }} collapse" id="home-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.corporate_enquiry_type', ['new']) ? 'active' : '' }}"
                                href="{{ route('administrator.corporate_enquiry_type', ['new']) }}">
                                New Enquiries
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.corporate_enquiry_type', ['signup']) ? 'active' : '' }}"
                                href="{{ route('administrator.corporate_enquiry_type', ['signup']) }}">
                                New Sign Up
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.corporate_enquiry_type', ['approved']) ? 'active' : '' }}"
                                href="{{ route('administrator.corporate_enquiry_type', ['approved']) }}">
                                Approved Enquiries
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.corporate_enquiry_type', ['rejected']) ? 'active' : '' }}"
                                href="{{ route('administrator.corporate_enquiry_type', ['rejected']) }}">
                                Rejected Enquiries
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Franchise --}}
            @php $franchiseActive = request()->routeIs('administrator.franchise_*') || request()->routeIs('administrator.admin_franchise_view'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $franchiseActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#franchise-collapse"
                    aria-expanded="{{ $franchiseActive ? 'true' : 'false' }}">
                    <i class="bi bi-briefcase-fill"></i>
                    Franchise
                </a>
                <div class="{{ $franchiseActive ? 'show' : '' }} collapse" id="franchise-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.franchise_type', ['compitition']) ? 'active' : '' }}"
                                href="{{ route('administrator.franchise_type', ['compitition']) }}">
                                Competition Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.franchise_type', ['academics']) ? 'active' : '' }}"
                                href="{{ route('administrator.franchise_type', ['academics']) }}">
                                Academics Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.franchise_type', ['school']) ? 'active' : '' }}"
                                href="{{ route('administrator.franchise_type', ['school']) }}">
                                School Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.franchise_type', ['other']) ? 'active' : '' }}"
                                href="{{ route('administrator.franchise_type', ['other']) }}">
                                Others Franchise
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.franchise_type', ['multi']) ? 'active' : '' }}"
                                href="{{ route('administrator.franchise_type', ['multi']) }}">
                                Multi Franchise
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Franchise Users --}}
            @php
                $franchiseUserActive =
                    request()->routeIs('administrator.admin_users_list') &&
                    strpos(request()->fullUrl(), 'franchise') !== false;
            @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $franchiseUserActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#franchise-user-collapse"
                    aria-expanded="{{ $franchiseUserActive ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i>
                    Franchise Users
                </a>
                <div class="{{ $franchiseUserActive ? 'show' : '' }} collapse" id="franchise-user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['new', 'franchise']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['new', 'franchise']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['students', 'franchise']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['students', 'franchise']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['creators', 'franchise']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['creators', 'franchise']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['publishers', 'franchise']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['publishers', 'franchise']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['managers', 'franchise']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['managers', 'franchise']) }}">
                                Managers
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Direct Users --}}
            @php
                $directUserActive =
                    request()->routeIs('administrator.admin_users_list') &&
                    strpos(request()->fullUrl(), 'franchise') === false;
            @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $directUserActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#user-collapse"
                    aria-expanded="{{ $directUserActive ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i>
                    Direct Users
                </a>
                <div class="{{ $directUserActive ? 'show' : '' }} collapse" id="user-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['new']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['new']) }}">
                                New Signup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['students']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['students']) }}">
                                Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['creators']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['creators']) }}">
                                Creators
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['publishers']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['publishers']) }}">
                                Publishers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->fullUrl() == route('administrator.admin_users_list', ['managers']) ? 'active' : '' }}"
                                href="{{ route('administrator.admin_users_list', ['managers']) }}">
                                Managers
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Admin & Contributors --}}
            @php $adminActive = request()->routeIs('administrator.add_user') || request()->routeIs('administrator.admin_panel_profile'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $adminActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#admin-contributors-collapse"
                    aria-expanded="{{ $adminActive ? 'true' : 'false' }}">
                    <i class="bi bi-sliders"></i>
                    Admin & Contributors
                </a>
                <div class="{{ $adminActive ? 'show' : '' }} collapse" id="admin-contributors-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.add_user') ? 'active' : '' }}"
                                href="{{ route('administrator.add_user') }}">
                                Add Contributor
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Test & Quizes --}}
            @php
                $testActive =
                    request()->routeIs('administrator.dashboard_tests_*') ||
                    request()->routeIs('administrator.dashboard_add_exams') ||
                    request()->routeIs('administrator.dashboard_tests_attempt') ||
                    request()->routeIs('administrator.manage_test_cat*') ||
                    request()->routeIs('administrator.add_category') ||
                    request()->routeIs('administrator.edit_category');
            @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $testActive ? '' : 'collapsed' }} rounded" data-bs-toggle="collapse"
                    data-bs-target="#test-quizes-collapse" aria-expanded="{{ $testActive ? 'true' : 'false' }}">
                    <i class="bi bi-easel2-fill"></i>
                    Test & Quizes
                </a>
                <div class="{{ $testActive ? 'show' : '' }} collapse" id="test-quizes-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_tests_list') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_tests_list') }}">
                                Tests List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_add_exams') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_add_exams') }}">
                                Add Test
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_tests_attempt') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_tests_attempt') }}">
                                Test Attempts
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('administrator.dashboard_eductaion_type') ? 'active' : '' }}"
                    href="{{ route('administrator.dashboard_eductaion_type') }}">
                    <i class="bi bi-sliders"></i>Education Types
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('administrator.dashboard_subjects') ? 'active' : '' }}"
                    href="{{ route('administrator.dashboard_subjects') }}">
                    <i class="bi bi-sliders"></i>Subjects
                </a>
            </li>

            {{-- Study Material --}}
            @php $materialActive = request()->routeIs('administrator.material*') || request()->routeIs('administrator.store'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $materialActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#study-material-collapse"
                    aria-expanded="{{ $materialActive ? 'true' : 'false' }}">
                    <i class="bi bi-sliders"></i>
                    Study Material
                </a>
                <div class="{{ $materialActive ? 'show' : '' }} collapse" id="study-material-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.material') ? 'active' : '' }}"
                                href="{{ route('administrator.material') }}">
                                Study Material List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.material_add') ? 'active' : '' }}"
                                href="{{ route('administrator.material_add') }}">
                                Add Study Material
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Package --}}
            @php $packageActive = request()->routeIs('administrator.plan*'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $packageActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#plans-list-collapse"
                    aria-expanded="{{ $packageActive ? 'true' : 'false' }}">
                    <i class="bi bi-coin"></i>
                    Package
                </a>
                <div class="{{ $packageActive ? 'show' : '' }} collapse" id="plans-list-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.plan') ? 'active' : '' }}"
                                href="{{ route('administrator.plan') }}">
                                View Package
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.plan_add') ? 'active' : '' }}"
                                href="{{ route('administrator.plan_add') }}">
                                Add Package
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Question Bank --}}
            @php $questionActive = request()->routeIs('administrator.dashboard_question_*'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $questionActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#my-homepage-collapse"
                    aria-expanded="{{ $questionActive ? 'true' : 'false' }}">
                    <i class="bi bi-question-octagon-fill"></i>
                    Question Bank
                </a>
                <div class="{{ $questionActive ? 'show' : '' }} collapse" id="my-homepage-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_question_list') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_question_list') }}">
                                All Questions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_question_add') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_question_add') }}">
                                Add Question
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_question_import') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_question_import') }}">
                                Import Question
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Books --}}
            @php $bookActive = request()->routeIs('administrator.books') || request()->routeIs('administrator.book_*'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $bookActive ? '' : 'collapsed' }} rounded" data-bs-toggle="collapse"
                    data-bs-target="#books-list-collapse" aria-expanded="{{ $bookActive ? 'true' : 'false' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    Books
                </a>
                <div class="{{ $bookActive ? 'show' : '' }} collapse" id="books-list-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.books') ? 'active' : '' }}"
                                href="{{ route('administrator.books') }}">
                                All Books
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.book_add') ? 'active' : '' }}"
                                href="{{ route('administrator.book_add') }}">
                                Add Book
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Course Details --}}
            @php $courseActive = request()->routeIs('administrator.course-detail-*'); @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $courseActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#course-details-collapse"
                    aria-expanded="{{ $courseActive ? 'true' : 'false' }}">
                    <i class="bi bi-sliders"></i>
                    Course Details
                </a>
                <div class="{{ $courseActive ? 'show' : '' }} collapse" id="course-details-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.course-detail-list') ? 'active' : '' }}"
                                href="{{ route('administrator.course-detail-list') }}">
                                Course List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.course-detail-add') ? 'active' : '' }}"
                                href="{{ route('administrator.course-detail-add') }}">
                                Course Detail Add
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Settings --}}
            @php
                $settingsActive =
                    request()->routeIs('administrator.dashboard_default_numbers') ||
                    request()->routeIs('administrator.website_pages*') ||
                    request()->routeIs('administrator.manage.faq*') ||
                    request()->routeIs('administrator.manage.important_links*') ||
                    request()->routeIs('administrator.manage.contact*') ||
                    request()->routeIs('administrator.manage_home*') ||
                    request()->routeIs('administrator.dashboard_add_test_category') ||
                    request()->routeIs('administrator.dashboard_add_pdf_content');
            @endphp
            <li class="nav-item">
                <a class="nav-link btn-toggle {{ $settingsActive ? '' : 'collapsed' }} rounded"
                    data-bs-toggle="collapse" data-bs-target="#settings-collapse"
                    aria-expanded="{{ $settingsActive ? 'true' : 'false' }}">
                    <i class="bi bi-sliders"></i>
                    Settings
                </a>
                <div class="{{ $settingsActive ? 'show' : '' }} collapse" id="settings-collapse">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_default_numbers') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_default_numbers') }}">
                                Default Numbers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.website_pages*') ? 'active' : '' }}"
                                href="{{ route('administrator.website_pages') }}">
                                Website Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.manage.faq*') ? 'active' : '' }}"
                                href="{{ route('administrator.manage.faq') }}">
                                Manage FAQ's
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.manage.important_links*') ? 'active' : '' }}"
                                href="{{ route('administrator.manage.important_links') }}">
                                Important Links
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.manage.contact*') ? 'active' : '' }}"
                                href="{{ route('administrator.manage.contactEnquiry') }}">
                                Contact Submissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.manage_home*') ? 'active' : '' }}"
                                href="{{ route('administrator.manage_home') }}">
                                Manage Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_add_test_category') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_add_test_category') }}">
                                Add Test Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('administrator.dashboard_add_pdf_content') ? 'active' : '' }}"
                                href="{{ route('administrator.dashboard_add_pdf_content') }}">
                                Pdf Content List
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const activeLink = document.querySelector("#sidebarMenu .nav-link.active");
        if (activeLink) {
            activeLink.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        }
    });
</script>
