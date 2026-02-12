# Broaden Student Content Access to Education Type

The goal is to allow students to access all tests and study materials within their selected **Education Type**, rather than being restricted to only their specific **Class/Group/Exam**.

## Proposed Changes

### [Component] Controllers

#### [MODIFY] [DashboardController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/Student/DashboardController.php)
- Update `index()` to filter tests and study materials by `education_type` instead of `class`.
- Ensure counts reflect all items within the `education_type`.

#### [MODIFY] [ExamsController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/Student/ExamsController.php)
- Update `index()` (listing available tests) to filter by `education_type_id` instead of `education_type_child_id` (class).

#### [MODIFY] [StudymaterialController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/StudymaterialController.php)
- Update `show()`, `showvideo()`, and `showgk()` to filter by `education_type` instead of `class`.

## Verification Plan

### Automated Tests
- I will check for existing tests related to student dashboard and content listing.
- I will verify if I can create a simple feature test to check if content from different classes but same education type is visible.

### Manual Verification
1. Log in as a student registered for a specific Education Type (e.g., Higher Education) and Class (e.g., Grade 10).
2. Ensure the dashboard counts include items from other classes within "Higher Education".
3. Check "All Tests" and "Study Materials" to see if items from other classes within the same Education Type are visible.
