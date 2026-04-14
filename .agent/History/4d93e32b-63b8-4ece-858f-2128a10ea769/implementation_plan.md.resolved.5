# Implementation Plan - Strict 1:1 Student Dashboard Migration

The objective is to achieve perfect functional parity between the old Controller-based dashboard and the new Livewire dashboard. We will replicate all data filters, navigation behaviors, and views as they existed, while only updating the aesthetic using MaryUI/Tailwind.

## User Review Required

> [!IMPORTANT]
> -   **No Enhancements**: We will NOT add new mandatory checkboxes or global palettes to the main view if they were absent in the old version.
> -   **Strict Data Filters**: We will replicate the exact filters for packages (e.g., excluding Free packages from "Purchased Packages" if that was the old behavior).
> -   **Modal Reproduction**: The "Summary View" will be implemented as a Modal, matching the `loc-Modal` behavior from the legacy `start-test` page.

## Proposed Changes

### 1. Test Conduct (OnlineTestRunner) - Logical Clone
-   **Main View**:
    -   Palette will show questions for the **active section only** (as per legacy behavior).
    -   "Review & Submit" button will trigger a **Summary Modal**.
-   **Summary Modal**:
    -   Show Time Left.
    -   Show counts for Attempted, Not-Attempted, and Marked for Review.
    -   Provide a global list of all questions (across all sections) purely for overview.
-   **Technical**: Refactor Timer to Alpine.js (`x-data`) for cleaner Livewire integration without changing its countdown behavior.

### 2. Package Management Migration
-   **[NEW] [PackageDetails.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Packages/Details.php)**: 
    -   Clone the grouping logic from `ExamsController@package_manage` (Tests, Materials, Videos, GK).
    -   Maintain the same data structure passed to the view.
-   **[MODIFY] [Purchased.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Packages/Purchased.php)**: 
    -   Ensure it **excludes** free packages (`final_fees == 0`) to match `StudentPlanController@myPlan`.

### 3. Remaining Page Migrations (1:1 Logic)
-   **Instructions View**: Create a Livewire component for the test overview screen, inheriting the same authorization checks from `ExamsController@getTest`.
-   **Feedback View**: Create a simple Livewire form for student reviews, replacing `ReviewController`.

### 4. Routing & Baseline
-   **Baseline Commit**: `git commit -m "chore: strict 1:1 migration baseline for student dashboard"`
-   **Route Sync**: Point `student.package_manage` and `student.feedback` to the new Livewire components in `routes/student.php`.

## Open Questions
-   None. We are proceeding with **Strict Parity**.

---

## Verification Plan

### Manual Verification
1.  Compare `/old/student/test/start-test/{id}` side-by-side with the new version.
2.  Verify the "Summary Modal" content matches exactly (counts and question grid).
3.  Verify "Purchased Packages" list shows identical items to the old dashboard.
4.  Verify homepage "Start" buttons open the new Livewire Package view.
