# Implementation Plan - Student Profile Photo Preview

The goal is to display a preview of the selected photo when a student uploads a profile picture in their profile management page.

## User Review Required
None.

## Proposed Changes

### Views

#### [MODIFY] [profile_manage.blade.php](file:///i:/test-and-notes-upgrading/resources/views/Dashboard/Student/profile/profile_manage.blade.php)

- Add `onchange="previewImage(event)"` to the file input.
- Add an `<img>` tag with `id="photo_preview"` below the file input. Initially hidden or showing current photo if available.
- Add JavaScript function `previewImage(event)` to read the file and update the `src` of the preview image.
- Since standard HTML/JS is used here (not Livewire), standard FileReader API will be used.

## Verification Plan

### Manual Verification
- **Browser Test**: Open `/student/profile`.
- **Action**: Select an image file.
- **Expectation**: The selected image should appear in the preview area immediately.
