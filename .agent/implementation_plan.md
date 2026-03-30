# Implementation Plan: Student Panel Modernization (MaryUI + Livewire 3)

This plan outlines the architectural shift from the current Bootstrap/jQuery-based Student Panel to a high-performance, premium interface using **MaryUI**, **Tailwind CSS**, and **Livewire 3**.

## User Review Required

### ⚠️ Layout Isolation (Aesthetics & Compatibility)
> [!WARNING]
> Bootstrap and Tailwind CSS **will conflict** if loaded on the same page because they share identical utility class names (e.g., `p-4`, `container`, `m-2`) but apply different CSS properties.
> 
> **Solution**: **Layout Isolation**. We will use a dedicated `mary.blade.php` layout for the new panel that does NOT include Bootstrap. The existing Bootstrap-based views will remain on their current layout under the `/old` prefix.

### 🔄 The "Old URL" Strategy
> [!TIP]
> I suggest creating a dedicated `routes/old.php` file to house all legacy routes. This keeps the main route files clean and prevents confusion.
> We will wrap the legacy routes in a group: `Route::prefix('old/student')->as('old.student.')`.

---

## Proposed Changes

### [Phase 0] Deep JavaScript & Logic Audit
Goal: Map all client-side logic to its new modern equivalent.

#### [AUDIT] Client-side JavaScript
- **[AJAX] Dependent Dropdowns**: Hits `/api/lookup/get-cities` for state/city selection. Replaced by Livewire's declarative state management.
- **[AJAX] Mobile OTP**: Hits `InternalRequestsController::mobile_otp`. Replaced by `OtpService`.
- **[UI] Bootstrap Toasts**: Replaced by MaryUI `x-toast`.
- **[UI] Icons**: Feather icons replaced by MaryUI/Lucide icons.

### [Phase 1] Infrastructure & Legacy Fallback (Est. 2-3 hrs)
Goal: Setup the modern stack and secure the old version.
- **[NEW]** Install and configure `tailwindcss`, `alpinejs`, `daisyui`, and `mary-ui/mary`.
- **[NEW]** [mary.blade.php](file:///mnt/WebliesNew/test-and-notes-upgrading/resources/views/components/layouts/mary.blade.php): Create the base MaryUI layout.
- **[NEW]** [old.php](file:///mnt/WebliesNew/test-and-notes-upgrading/routes/old.php): Wrap current student routes in `/old/student` group for legacy mirror.

### [Phase 2] Navigation & Dashboard Migration (Est. 2-3 hrs)
Goal: Convert the main landing page and sidebar.
- **[NEW]** `App\Livewire\Student\Dashboard`: Create the primary Livewire component for the student home.
- **[MODIFY]** `routes/student.php`: Update the main `/student/dashboard` route to point to the new Livewire component.

### [Phase 3] Core Logic Migration - Tests & Exams (Est. 6-8 hrs)
Goal: Re-implement the complex mock test flow as a single stateful Livewire component.

---

## Verification Plan

### Manual Verification
- Access `/old/student/dashboard` to verify legacy UI is intact.
- Access `/student/dashboard` to verify new MaryUI dashboard performance.
- Roles: Must test with a valid `student` user account.
