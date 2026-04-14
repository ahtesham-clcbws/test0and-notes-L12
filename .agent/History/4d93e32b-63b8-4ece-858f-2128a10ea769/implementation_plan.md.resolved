# Implementation Plan - Final 1:1 Logic Realignment

Based on a "Proper Re-Analysis", I have identified several logical gaps where the new Livewire components diverged from the legacy Controller logic. This plan focuses on closing those gaps to achieve 100% functional parity.

## User Review Required

> [!IMPORTANT]
> **Show Result Restriction**: In the old system, results were hidden if `show_result` was 0. The current Livewire `ShowResult` component does not check this field. I will implement this restriction.
> **Test Resume Behavior**: The old system redirected any existing test attempt to the Result page (effectively "One-Shot" tests). My new system allows resuming. I will align this to the legacy "One-Shot" behavior for strict parity unless instructed otherwise.

## Proposed Changes

### [Component Name] Exam & Results Logic

#### [MODIFY] [ShowResult.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Tests/ShowResult.php)
- Add check for `$test->show_result == 1`.
- If 0, redirect back with error message: "Result will be displayed soon...".
- Ensure negative marking formula strictly matches legacy `(Incorrect * NegativeRate * MarksPerQ)`.

#### [MODIFY] [OnlineTestRunner.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Tests/OnlineTestRunner.php)
- Align `mount` logic to legacy `ExamsController@startTest`: If an attempt exists (any status), redirect to results immediately. (Strict 1:1 Parity).

### [Component Name] Content Filtering

#### [MODIFY] [Index.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Material/Index.php)
- Uncomment the `$userDetails->class` filter to ensure materials are strictly filtered by student class, matching `DashboardController@index`.

#### [MODIFY] [Details.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Packages/Details.php)
- Ensure the purchase verification logic (Lines 82-91 in legacy controller) is fully replicated for premium packages.

### [Component Name] Profile & Verification

#### [NEW] [VerifiedProfile.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Profile/VerifiedProfile.php)
- Replicate the legacy `manage_profile_process` and OTP verification logic in the new Livewire profile component.

## Verification Plan

### Automated Tests
- `php artisan test --filter=StudentDashboardTest` (if available).
- Manual code walk-through comparing `ExamsController.php` with new components.

### Manual Verification
- Attempt to access a Result page for a test where `show_result` is 0. Expected: Redirect with "displayed soon" message.
- Start a test, leave, and try to start again. Expected: Redirect to result (Strict Parity).
- Check "Student Panel" Material lists. Expected: Only materials for the student's Class and EduType are visible.
