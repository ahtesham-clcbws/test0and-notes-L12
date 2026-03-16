# [Student Dashboard & Navigation Filtering]

Implement strict filtering of student dashboard data based on their assigned Class/Group/Exam, while maintaining full access to all data from the homepage and contextual navigation from Course Details pages.

## User Review Required

> [!NOTE]
> This change introduces STRICT filtering in the Student Dashboard and sub-views (Tests, Study Material, Packages). If a student has no Class assigned in their profile, they might see empty lists until filtered or assigned.

## Proposed Changes

### 1. **Student Dashboard**
#### [MODIFY] [DashboardController.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Http/Controllers/Student/DashboardController.php)
-   Update `index()` to filter `TestModal` and `Studymaterial` queries by `$User->class` (Class/Group/Exam) in addition to `education_type`.
-   Query updates:
    -   `TestModal`: `->where('education_type_child_id', $class)`
    -   `Studymaterial`: `->where('class', $class)`

---

### 2. **Course details View**
#### [MODIFY] [index.blade.php](file:///mnt/WebliesNew/test-and-notes-upgrading/resources/views/Frontend/ClassDetail/index.blade.php)
-   Update navigation links (Tests, Study Material, Packages) to pass `class_id` and `edu_id` as query parameters so the destination pages can filter correctly.
-   Example: `route('student.dashboard_gyanology_list', ['cat' => $item->id, 'class_id' => $classes_groups_exams_data->id])`

---

### 3. **Livewire Components**
#### [MODIFY] [StudentTestList.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Tests/StudentTestList.php)
-   Add `public $class_id;` property.
-   In `render()`, filter by `$this->class_id` if present, otherwise fallback to `$userDetails->class`.
-   Query update: `->where('education_type_child_id', $this->class_id ?? $userDetails->class)`

---

### 4. **Controllers**
#### [MODIFY] [StudymaterialController.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Http/Controllers/StudymaterialController.php)
-   Update `show()`, `showvideo()`, `showgk()` to check for `$request->class` (or `class_id`).
-   Filter by query parameter if present, else fallback to `$student->class`.
-   Query update: `->where('study_material.class', $class)`

#### [MODIFY] [StudentPlanController.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Http/Controllers/Student/StudentPlanController.php)
-   Update `index()` to filter `Gn_PackagePlan` by `education_type` and `class`.
-   Look for `$request->class_id` or fallback to `$userDetails->class` (and education type).
-   Query update: `->where('gn__package_plans.class', $class)`

---

## Verification Plan

### Automated Tests
-   No existing automated tests target this specific filtering logic. We rely on manual verification as this is a UI/Query logic shift.

### Manual Verification
1.  **Dashboard View**:
    -   Log in as a student with a specific Class (e.g., Class X).
    -   Visit Dashboard. Verify that count and lists match ONLY Class X items.
2.  **Course Navigation**:
    -   Go to Homepage and visit a Course Detail page for Class Y.
    -   Click "Test & Quiz" or "Packages".
    -   Verify that the resulting page lists items for Class Y, not Class X.
3.  **Global View**:
    -   Verify that viewing from homepage/unauthenticated context (if applicable) operates Normally or prompts login correctly with full access as designed.
