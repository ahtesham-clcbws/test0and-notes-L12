# Fix Study Material View and Download Links

The user wants the study material links in the student dashboard to point directly to the storage path instead of using route proxies. There is also a discrepancy in `package_manage.blade.php` where some links have duplicated directory prefixes.

## Proposed Changes

### [Student Material Controller]

#### [MODIFY] [StudymaterialController.php](file:///i:/test-and-notes-upgrading/app/Http/Controllers/StudymaterialController.php)
- Update all material listing methods (`show`, `showvideo`, `showgk`, `showComprehensive`, `showShortNotes`, `showPremium`).
- Replace `route('student.viewmaterial', [$file[1]])` and `route('student.download', [$file[1]])` with `url('storage/' . $model['file'])`.
- This will provide direct links like `http://127.0.0.1:8000/storage/study_material/filename.pdf`.

### [Student Package Management View]

#### [MODIFY] [package_manage.blade.php](file:///i:/test-and-notes-upgrading/resources/views/Dashboard/Student/MyPlan/package_manage.blade.php)
- Fix View links: Replace hardcoded `http://testandnotes.com` with `url()` and ensure the path is correct.
- Fix Download links: Change `url('/storage/study_material/' . $onematerial->file)` to `url('storage/' . $onematerial->file)` to avoid duplicated `study_material/` prefix.

## Verification Plan

### Manual Verification
- Log in as a student.
- Navigate to "Study Notes & E-Books", "Live & Video Classes", etc.
- Hover over "View" and "Action" (download icon) for a material.
- Verify the URL points directly to `/storage/study_material/...`.
- Navigate to a purchased package in "My Packages".
- Verify that "View" and "Download" links work correctly there as well.
