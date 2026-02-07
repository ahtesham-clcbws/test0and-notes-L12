# Implementation Plan - Sidebar Navigation Improvements

Improve the sidebar user experience by ensuring active sections are expanded and the active link is scrolled into view.

## Proposed Changes

### [MODIFY] [sidebar.blade.php](file:///i:/test-and-notes-upgrading/resources/views/Dashboard/Admin/partials/sidebar.blade.php)

- Add a dynamic `active` class to all `nav-link` elements using `request()->routeIs()`.
- For each `collapse` div:
    - Add the `show` class if any sub-route is active.
- For each `btn-toggle` (trigger):
    - Remove the `collapsed` class if the section is active.
    - Set `aria-expanded="true"` if the section is active.
- Add a `<script>` block at the end of the file to:
    - Find the active link.
    - Scroll it into view using `scrollIntoView()`.

#### Section Route Mappings:
- **Dashboard**: `administrator.dashboard`
- **Corporate Enquiries**: `administrator.corporate_enquiry*`
- **Franchise**: `administrator.franchise_*`, `administrator.admin_franchise_view`
- **Franchise Users**: Prefix `administrator/users/type/*/franchise`
- **Direct Users**: Prefix `administrator/users/type/*` (excluding franchise)
- **Admin & Contributors**: `administrator.add_user`, `administrator.admin_panel_profile`
- **Test & Quizes**: `administrator.dashboard_tests_*`, `administrator.dashboard_add_exams`, `administrator.dashboard_tests_attempt`, `administrator.manage_test_cat*`, `administrator.add_category`, `administrator.edit_category`
- **Education Types**: `administrator.dashboard_eductaion_type`
- **Subjects**: `administrator.dashboard_subjects`
- **Study Material**: `administrator.material*`, `administrator.store`
- **Package**: `administrator.plan*`
- **Question Bank**: `administrator.dashboard_question_*`
- **Books**: `administrator.books`, `administrator.book_*`
- **Course Details**: `administrator.course-detail-*`
- **Settings**: `administrator.dashboard_default_numbers`, `administrator.website_pages*`, `administrator.manage.faq*`, `administrator.manage.important_links*`, `administrator.manage.contact*`, `administrator.manage_home*`, `administrator.dashboard_add_test_category`, `administrator.dashboard_add_pdf_content`

## Verification Plan

### Manual Verification
- Navigate to "Course List": Observe that "Course Details" is expanded, the link is highlighted, and it scrolls to it if necessary.
- Navigate to "Add Course": Same observation.
- Navigate to "Edit Course": Same observation.
- Navigate to "New Signup" (Franchise Users): Observe "Franchise Users" is expanded.
- Navigate to "New Signup" (Direct Users): Observe "Direct Users" is expanded.
