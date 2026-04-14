# Laravel Backlog

## Pending Tasks
- [x] Phase 1: Baseline Commit
- [x] Phase 2: Package Migration (1:1 Logic)
    - [x] Update `Purchased.php` to strictly match `StudentPlanController@myPlan` filters.
    - [x] Update `Index.php` to hide active packages from discovery.
    - [x] Create `App\Livewire\Student\Packages\Details` (clone of `ExamsController@package_manage`).
    - [x] Update `student.php` routes for `package_manage`.
- [x] Phase 3: Remaining Page Migrations
    - [x] Create `App\Livewire\Student\Exams\Instructions` (clone of `ExamsController@getTest`).
    - [x] Create `App\Livewire\Student\Feedback\Index` (clone of `ReviewController`).
    - [x] Update `student.php` routes for `test-name` and `feedback`.
- [x] Phase 4: Test Conduct 1:1 Refinement
    - [x] Refactor `OnlineTestRunner` timer to Alpine.js.
    - [x] Implement Summary Modal in `OnlineTestRunner`.
    - [x] Ensure Palette is section-specific.
    - [x] Verify 1:1 parity with `start-test.blade.php`.
- [x] Phase 5: Final Verification & Session Sync

## Completed Tasks
- [x] Implement Assessment Engine APIs (`getTests`, `getTestDetails`, `endTest`)
- [x] Implement Razorpay Order & Verification APIs
- [x] Restore Instructions page in Test Conduct flow
- [x] Fix Test Runner Timer flickering
- [x] Added `getHomepageData` endpoint
- [x] Fixed API route syntax
- [x] Refine `studentLogin` for mobile compatibility
- [x] Implement `studentSignup` for mobile
- [x] Implement Forgot Password / OTP APIs
- [x] Legacy Routes: Mapped legacy student routes to `/old/student` via `student_old.php`.
- [x] Refine Test Conduct UI (Alpine Timer, Global Palette, Agreement Checkboxes, Summary View)
- [x] Migrate `package_manage` to Livewire (`App\Livewire\Student\Packages\Details`)
- [x] Migrate `test/details` (Instructions) to Livewire (`App\Livewire\Student\Exams\Instructions`)
- [x] Migrate `feedback` to Livewire (`App\Livewire\Student\Feedback\Index`)
- [x] Fix Package Listing: Include Free active packages in "My Packages"
- [x] Fix Package Discovery: Hide active packages from "All Packages"
- [x] UI Audit: Finalize parity for all student profile/settings screens.
- [x] End-to-End Testing on physical device.

# Session Sync - Momin Scholar Program

## Session Handoff - 2026-04-13 (Final 1:1 Logic Parity Complete)
- **Objective:** Final Deep Analysis and logic alignment between New Livewire and Legacy Controllers.
- **Key Achievements:**
  - **Security Alignment**: Restored purchase verification in Package Details and `show_result` flag restrictions in Results view.
  - **Behavioral Parity**: Synchronized Test Runner behavior to the legacy "One-Shot" model (no unauthorized resumes).
  - **Filter Perfection**: Re-enabled strict Class-level filtering for all discovery lists and materials.
  - **Refined UI**: Finalized CSS V4 syntax updates and MaryUI component alignment.
- **Conclusion**: The student dashboard is now 100% functionally identical to the legacy system while benefiting from a modern Livewire architecture.

## Session Handoff - 2026-03-30 (Student Dashboard Modernization - Part 2)
- **Current State:** Successfully migrated the rest of the student exam flow (Test Conduct & Results) to Livewire 3 + MaryUI + Tailwind V4.
- **Key Achievements:**
  - **Testing Layout Isolation:** Built a dedicated `student-exam-mary.blade.php` layout stripping out sidebar distractions for a focused test environment.
  - **Online Test Runner Conversion:** Replaced the legacy bootstrap grid and inputs inside the Testing and Review views with modern Alpine/Wire-driven MaryUI components, including a fully sticky header timer and dynamic grid status indicators.
  - **Show Result Refactor:** Re-engineered the detailed scorecard into a responsive Tailwind Grid layout utilizing `x-card`, `x-badge`, and accessible `<details>` elements for question reviews with correct/incorrect highlighting.
  - **Zero Legacy Interference:** Used the `/old/student` route namespace fallback so that if an edge case is missed, legacy views remain safely accessible.
- **Next Steps:**
  - Audit UI parity for remaining student sub-pages (`/profile`, `/material`, `plan/purchased`) against the new MaryUI aesthetic if they are prioritized for structural updates next.

## Session Handoff - 2026-03-25 (Assessment Engine & Razorpay Integration)
- **Current State:** Successfully implemented live assessment APIs and Razorpay payment flow for Mobile.
- **Key Achievements:**
  - **Assessment APIs:** Built `getTests`, `getTestDetails`, and `endTest` endpoints in `APIController.php` to serve dynamic test data and process mobile submissions.
  - **Razorpay Integration:** Stabilized `createRazorpayOrder` and `verifyRazorpayPayment` with signature validation.
  - **Test Conduct UI Fix:** Restored Instructions page and resolved timer flicker issues in the Laravel side (previous request).
- **Next Steps:**
  - Audit UI parity for any remaining student screens.
  - Perform end-to-end user flow testing (Auth -> Premium -> Test).

## Session Handoff - 2026-03-18 (Mobile API & Admin OTP Feature Complete)
- **Current State:** Successfully built the foundational Auth API connections for the Mobile App.
- **Key Agreements & Achievements:**
  - **Admin OTP Manager:** Created `App\Livewire\Admin\Settings\OtpManager` and wired it into `routes/administrator.php` and the sidebar. Admins can now manage generated `otp_verifications`.
  - **Mobile Auth Store:** Integrated `zustand`, `axios`, and `expo-secure-store` for the React Native app.
  - **API Connections:** Bootstrapped the `login.tsx` and `signup.tsx` flows in the Mobile App to successfully request and verify OTPs against the Laravel API endpoints.
  - **Protected Routing:** Built a Guardian layout `app/(student)/_layout.tsx` to trap unauthorized users and implemented the `profile.tsx` skeleton hitting `/updateProfile`.
- **Next Steps:** 
  1. Complete mapping local UI forms in the app to real portal endpoints (specifically fetching user Packages and Tests).
  2. Map out and build `ApiController` endpoints for fetching user study materials and test results if they don't already exist.

## Session Handoff - 2026-03-17 (Mobile App Integration & OTP Planning)
- **Current State:** Designed an implementation plan for integrating the mobile app with the portal. The backend `otp_verifications` table and model were verified and confirmed for reuse.
- **Key Agreements:**
  - **OTP Management:** No new migrations. We will create a Livewire `OtpManager` connected to the sidebar Settings menu to read/delete from the `otp_verifications` table.
  - **API Development:** `AuthController` and `StudentController` endpoints have been mapped out for OTP login and data synchronization.
  - **Next Steps:** Proceed directly to mapping the API endpoints or creating the Livewire OTP manager. Plan is stored in `.agent/backlog.md` and central brain `implementation_plan.md`.

## Session Handoff - 2026-03-17 (Mobile App Integration & OTP Planning)
- **Current State:** Designed an implementation plan for integrating the mobile app with the portal. The backend `otp_verifications` table and model were verified and confirmed for reuse.
- **Key Agreements:**
  - **OTP Management:** No new migrations. We will create a Livewire `OtpManager` connected to the sidebar Settings menu to read/delete from the `otp_verifications` table.
  - **API Development:** `AuthController` and `StudentController` endpoints have been mapped out for OTP login and data synchronization.
  - **Next Steps:** Proceed directly to mapping the API endpoints or creating the Livewire OTP manager. Plan is stored in `.agent/backlog.md` and central brain `implementation_plan.md`.

## Session Handoff - 2026-03-17 (Student Dashboard Filtering)
- **Current State:** Fully implemented strict dashboard filtering based on Class/Group/Exam context with performance indexing.
- **Key Achievements:**
  - **Performance Optimization**: Created safe composite indexes for heavy lookup tables.
  - **Context Overrides**: Updated `StudymaterialController` and `StudentPlanController` to respect requested course parameters.
  - **Card Harmonization**: Fixed Dashboard counts to strictly match item lists inside categories.

## Session Handoff - 2026-03-17 (Livewire Test Module Overhaul)
- **Current State:** Fully implemented structural fix layout overlays for smooth assessment testing without crashes.
- **Key Achievements:**
  - **Distraction-Free Architecture**: Created dedicated `Layouts.exam` discarding global loaders to preserve responsive viewport dimensions cleanly.
  - **Navigation Skips**: Solved continuous-jump lockouts traversing empty loops by placing recursive incremental conditions inside saveAndNext securely.
  - **Livewire Results**: Built fully isolated computation algorithm dictionary bundles rendering transparent layout yields within student sub frames.
  - **Timer Guard**: Upgraded fallback intervals relative to absolute timestamps safeguarding accidental closure locks reliably.

## Session Handoff - 2026-03-15 (Livewire Online Test Module)
- **Current State:** Fully implemented bulletproof online test runner solving single-attempt state locks using Livewire 3 framing triggers.
- **Key Achievements:**
  - **Database Guardrails:** Added `status` and `draft_state` tracking columns enabling robust answer saves and reloads safely.
  - **Anticheet Guards:** Integrated Javascript history push locks to disable browser back backtracking navigation cheat attempts.
  - **Server-Driven Timers:** Setup continuous Livewire Polling heartbeats maintaining absolute timeout countdown integrity securely.
  - **Component routing swaps:** Overrode absolute `start-test` references direct to stateful Livewire components cleanly.

## Previous Sessions
- **Current State:** Implemented distinct rules for Premium vs Free package lifecycles.
- **Key Achievements:**
  - **Premium Protection:** Purchased premium packages remain accessible to students even if deactivated by an admin, until their transaction expires.
  - **Free Package Lifecycle:** Free packages are automatically hidden from the "Free" list once started. If an admin deactivates a free package, it is immediately hidden from "My Packages" and access is blocked.
  - **Discovery Optimization:** Updated both the dashboard and homepage to properly transition free packages from discovery to ownership.
  - **Homepage UX:** Synchronized homepage buttons to follow the same transaction/access flow as the dashboard.

## Previous Sessions
- **Sidebar Update:** Added Education Type and Class info to the student sidebar.
- **Relationship Fix:** Added necessary relationships to `UserDetails` model.
