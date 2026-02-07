# Fix Package Edit Page JS Errors

This plan addresses a JavaScript syntax error and a reference error on the package edit page (`administrator/plan/add/{id}`). The image 404 error will not be addressed per user request.

## Technical Analysis
- **Syntax Error**: Variables like `video`, `notes`, and `gk` are being injected directly from Blade without quotes. Since these values are often comma-separated strings of IDs (e.g., "1,2"), they result in invalid JavaScript like `let video = 1,2;`.
- **Reference Error**: `class_group` is reported as undefined because the script block containing its definition fails to parse entirely due to the syntax error.
- **JSON Encoding**: The `test` variable in the layout is being rendered with `{{ $test }}`, which escapes quotes and breaks the JSON structure.

## Proposed Changes

### [Admin Layout]
#### [MODIFY] [admin.blade.php](file:///i:/test-and-notes-upgrading/resources/views/Layouts/admin.blade.php)
- Wrap ID list variables (`video`, `notes`, `gk`) in quotes or use `json_encode` to ensure they are treated as strings in JS.
- Change `{{ $test }}` to `{!! $test !!}` to prevent escaping JSON characters.
- Rename `package` variable to `package_info` to avoid potential reserved word conflicts.

## Verification Plan

### Manual Verification
- Load the package edit page and check the browser console for any `SyntaxError` or `ReferenceError`.
- Verify that the "Add Test", "Add Video", and "Add Study Notes" multi-selects are correctly pre-populated with existing data.
- Ensure the "Class/Group/Exam Name" dropdown is correctly populated on page load.
