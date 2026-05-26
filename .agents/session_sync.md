# Laravel Backlog

## Pending Tasks
- [x] Phase 7: Database Integrity Hardening (Schema Sentinel)
- [x] Phase 8: Bug Fixes (Timer Flicker & Modal Closure)
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
- [x] Phase 5: Test Conduct Redesign & Security Hardening
    - [x] Redesign Instructions page (Compact UI, Header dots, Sidebar card).
    - [x] Implement Server-side guards for sequential navigation.
    - [x] Switch to Absolute Timestamp Timer (Flicker-free).
    - [x] Visual Question Bubble Grid in Results with Solution Modal.
    - [x] Unify Global Sidebar Profile (Add Institute name).
- [x] Phase 6: Final Verification & Session Sync
- [x] Phase 7: Database Integrity Hardening
    - [x] Install `clcbws/laravel-schema-sentinel`.
    - [x] Publish Sentinel configuration.
    - [x] Verify environment with `schema:sentinel-doctor`.

## Completed Tasks
- [x] Implement Assessment Engine APIs (`getTests`, `getTestDetails`, `endTest`)
- [x] Implement Razorpay Order & Verification APIs
- [x] DB Integration: Laravel Schema Sentinel (v1.0) for drift detection and migration integrity.
- [x] Verification: PHPUnit (Unit/Feature tests), Sentinel Doctor.
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

## Session Handoff - 2026-05-26 (V3.1.2: Project-Wide Null-Safety Hardening Audit)
- **Objective:** Secure the entire portal from null pointer exceptions (`Attempt to read property "branch_code" on null`) when logged in as direct platform contributors or superadmins who do not belong to an institute (`in_franchise = 0`).
- **Key Achievements:**
  - **Hardened StudymaterialController**: Updated all references to `myInstitute` to be null-safe. Implemented conditional branching for staff based on `in_franchise == 1` so that direct creators and publishers are not filtered by a null institute relationship, allowing them to manage their own materials flawlessly.
  - **Secured Student Views & Components**: Handled edge cases in `mainheader.blade.php` to prevent crashes when rendering institute branding for direct contributors or superadmins.
  - **Clean Formatting**: Passed formatting checks cleanly using `vendor/bin/pint --dirty`.

## Session Handoff - 2026-05-26 (V3.1.1: Fix Test Creator and Test Publisher Dropdowns Matching)
- **Objective:** Fix the Test Creator and Test Publisher dropdown list matches in the Admin Panel's Manage Test Sections view to display the active superadmin and direct contributors.
- **Key Achievements:**
  - **Corrected Role String Queries**: Removed JSON double quotes from the database queries (from `%"creator"%` to `%creator%`) so they match the actual comma-separated string formatting inside the `roles` database column.
  - **Included Superadmins**: Updated the Eloquent filters to explicitly pull users with the `superadmin` role, bypassing `directContributorCriteria()` restrictions that require `is_staff = 1` which is `0` for the platform's superadmin accounts.
  - **Formatting Consistency**: Standardized the Livewire `TestSectionManager` changes using `vendor/bin/pint --dirty` with perfect style compliance.

## Session Handoff - 2026-05-22 (V3.1.0: Laravel Agent-Debugger Package Replacement)
- **Objective:** Replace custom basic logger with the feature-rich `clcbws/laravel-agents-debug` package.
- **Key Achievements:**
  - **Local Composer Package Symlinking**: Added local path repository mapping `/mnt/BWS/public_projects/Local_Debug_Activity` and required `"clcbws/laravel-agents-debug": "*"` in `composer.json`. Successfully updated composer dependencies to symlink the package.
  - **Removed Basic/Custom Logger Files**: Cleanly deleted the custom middleware `DebugActivityLoggerMiddleware.php`, removed its registration from `bootstrap/app.php`, deleted the POST `debug-log` route from `routes/web.php`, and removed the custom `debug_log` function from `app/Helper/GlobalHelper.php` to prevent conflicts.
  - **Wired and Enabled the Package**: Appended `AGENT_DEBUGGER_ENABLED=true` to the `.env` configuration, published the package's configuration file, and activated it via `php artisan agent:debug-on`.
  - **Viewport Indicator Registration Fix**: Resolved a bug where the package checked for `appendMiddleware()` which does not exist on the standard Laravel 11/12 HTTP Kernel class. Patched `DebugActivityServiceProvider.php` inside the local package codebase (`/mnt/BWS/public_projects/Local_Debug_Activity`) to gracefully fall back to the standard `pushMiddleware()` method, enabling successful injection of the glassmorphic status badge.
  - **Verified Stable Status**: Executed `php artisan agent:debug-status` to verify that the debugging suite is active and running cleanly, followed by a successful Pint code formatting sweep.

## Session Handoff - 2026-05-22 (V2.9.2: Student Test Results and Review Mode Upgrades)
- **Objective:** Update terminology on results page and add response clearing/skipping features in review mode.
- **Key Achievements:**
  - **Terminology update**: Renamed "Left Questions" and "Left Marks" to "Skip Questions" and "Skip Marks" in `show-result.blade.php`.
  - **Livewire response clearing**: Added standard `clearReviewAnswer()` method in the `TestReview.php` Livewire component class to set selections to `null` inside the database, recalculate completion statistics, and close the solution modal.
  - **UI Integration**: Added a beautiful "Clear Response & Skip" button aligned to the left of the re-attempt modal footer in `test-review.blade.php`.
  - **Static Analysis Fixes**: Replaced all procedural global `session()` helper actions with the static `Session` facade to eliminate IDE "Expected type 'object'. Found 'null'." warnings completely.

## Session Handoff - 2026-05-22 (V2.9.1: Type Hardening & Static Analysis Resolutions)
- **Objective:** Fix static analysis and IDE warnings across `GlobalFunctions.php` and `OptimizeExistingImages.php` to align with strict PHP 8.2 type declarations.
- **Key Achievements:**
  - **Console Command Type Hardening**: Fully type-hinted `OptimizeExistingImages` properties (`ImageService $imageService`), parameters, and return statements (`shouldOptimize(string $filename): bool`, `processImage(string $relativePath, int $maxWidth): ?string`, `handle(): int`, and `void` layout actions).
  - **Global Procedural Functions Typing**: Applied explicit parameter type hinting and return types to all core procedural helper functions (`getCitiesByState`, `getAvailableCitiesByState`, `generateBranchCode`, `getClassesByEducation`, `getBoardsbyClass`, `defaultNumberCheck`, `numberInUse`, `sendSMS`, `verifyOtp`, and relation loaders) inside `GlobalFunctions.php`.
  - **Formatting Consistency**: Standards-verified and formatted the changes using `vendor/bin/pint --dirty` with zero styling violations remaining.

## Session Handoff - 2026-05-21 (V2.9.0: Local environment server-level activity logger)
- **Objective:** Add an advanced, zero-touch activity logging system that automatically tracks all HTTP URLs visited, controllers, database queries with timings, composed Blade views, and provides manual/frontend logging controls, active ONLY in local environment when `DEBUG_LOGGING=true`.
- **Key Achievements:**
  - **Dynamic Global Middleware**: Designed and implemented `DebugActivityLoggerMiddleware` which logs client IP, duration in milliseconds, authenticated user info, controller routes, and inputs.
  - **Livewire Interceptor**: Parsed Livewire request payload structures, logging components, updates, and method calls dynamically.
  - **Server-Level Insights**: Captured all database queries with precise timings and bindings, along with all composed Blade views, to log them into `storage/logs/debug_activity.log`.
  - **Dynamic JS Injection**: Embedded an automated frontend error handler and the `window.debugLog(message, context)` helper function right before `</body>` in HTML responses. This enables capturing all uncaught frontend Javascript crashes and button click events directly in the server log.
  - **Manual PHP Helper**: Exposed `debug_log($message, $context)` to allow developers to trigger server-level logging from any Blade views, plain controllers, or Livewire components manually.
  - **Environment-Locked Protection**: Secured all handlers strictly under the `config('app.env') === 'local'` and `env('DEBUG_LOGGING') === true` conditions to prevent performance degradation or leak risks in production.

## Session Handoff - 2026-05-21 (V2.8.1: Portable GD Extension Dynamic Loader)
- **Objective:** Resolve GD PHP extension dependency crash (`Intervention\Image\Exceptions\DriverException`) on systems where the extension library is installed but commented out/disabled in the system's `php.ini`.
- **Key Achievements:**
  - **Dynamic Extension Injection**: Established a highly portable, zero-overhead workspace solution using the standard `PHP_INI_SCAN_DIR` environment variable to append a local project directory (`.agents/php-config/`) where a `gd.ini` file enables the `gd` extension on-demand.
  - **Relative Path Optimization**: Configured `PHP_INI_SCAN_DIR=:./.agents/php-config` so it resolves dynamically to the local project root, ensuring portability across multiple environments and developers without hardcoded absolute paths or side effects on unrelated projects.
  - **Composer Dev Integration**: Patched the primary `composer dev` script in `composer.json` to automatically prefix execution with `PHP_INI_SCAN_DIR=:./.agents/php-config`, allowing both Vite and the Artisan serve processes to boot successfully out-of-the-box.
  - **Verified Parity & Hot reloading**: Verified the server runs flawlessly without any `DriverException` crashes, allowing the system to boot up instantly.

## Session Handoff - 2026-05-19 (V2.2.1: Premium Interactive OTP Verification UI)
- **Objective:** Fix button states, disable inputs correctly upon OTP transmission/verification, display contextual status messages below inputs, trigger error toasts, make success toasts fully green, ensure toasts close on click, and block registration bypasses.
- **Key Achievements:**
  - **Premium SweetAlert2 Toast Formatting**: Styled the success toast to be fully green (background `#16a34a`, white icon/text) and error toast to be fully red (background `#dc2626`, white icon/text).
  - **Toast Dismissal on Click**: Added click event listener (`toast.addEventListener('click', Swal.close)`) to standard SweetAlert2 toasts to enable instant closing on click.
  - **Interactive State Bindings**: Configured mobile inputs and "Get OTP" buttons to disable and go readonly upon successful SMS sending. Configured OTP inputs and "Verify" buttons to remain disabled until SMS is sent, and disable completely with a "Verified" badge once verified.
  - **Contextual Status Helper Tags**: Added status/info texts directly below the inputs (e.g. "OTP successfully sent to your mobile number." and "Mobile number verified.").
  - **Exception & Toast Synchronization**: Intercepted validation exceptions on `getOtp()` and `verifyOtp()` to automatically trigger SweetAlert2 error toasts using the global `error()` JS function.
  - **Security Guardrails**: Enforced backend validation checks in `register()` to block registration attempts if the OTP has not been verified.
  - **Pre-Push Automation**: Incremented version to `v2.0.7`, ran `npm run build` to compile production assets, and ran `vendor/bin/pint --dirty`.

## Session Handoff - 2026-05-19 (V2.2.0: MSG91 Signup & Profile OTP Integration)
- **Objective:** Fix the OTP flow in the portal's sign-up pages and user profile pages where the OTP verification records were being generated in the database but never transmitted to the user's phone number.
- **Key Achievements:**
  - **Integrated MSG91 SMS Service**: Wired the `Msg91Service` gateway to automatically trigger SMS transmissions whenever a new mobile OTP is requested and saved.
  - **Wired 6 Flow Endpoints**:
    - **Student Registration**: Integrated SMS dispatch into `App\Livewire\Frontend\Auth\Register`.
    - **Contributor Registration**: Integrated SMS dispatch into `App\Livewire\Frontend\Auth\ContributorSignUp`.
    - **Student Profile**: Integrated SMS dispatch into `App\Livewire\Student\Profile\Index` mobile updates.
    - **Franchise Profile**: Integrated SMS dispatch into `App\Http\Controllers\Frontend\Franchise\UserController` mobile verification.
    - **Student Dashboard Controller**: Integrated SMS dispatch into `App\Http\Controllers\Student\DashboardController` mobile verification.
    - **Legacy AJAX Route**: Integrated SMS dispatch into `App\Http\Controllers\InternalRequests\InternalRequestsController`.
  - **Code Quality & Type Hardening**: Resolved multiple static analysis type warnings (`Expected type 'object'. Found 'array<string, mixed>'`) across the controllers by converting `request()` calls to utilize typed request parameters, initialized `$returnResponse` inside `app_login` to solve the undefined variable warning, and formatted all changes with `vendor/bin/pint --dirty`.
  - **Livewire AJAX Payload Fix**: Resolved the loading state lockup ("Sending OTP...") by removing debug `echo` outputs from `Msg91Service::sendSms` that were corrupting JSON response structures.

## Session Handoff - 2026-05-18 (V2.1.2: Premium Review Mode & Secure Encryption)
- **Objective:** Design and implement a highly secure, premium Review Mode for test attempts with URL encryption, interactive re-answer capability, and color/border UI states.
- **Key Achievements:**
  - **Premium Review Screen & Secure URL Encryption**:
    - Replaced the summary popup modal with a full, dedicated **Review Mode** on the ShowResult page, fully matching the premium styling requested.
    - Encrypted all URL routing payloads (student ID, test ID, mode) dynamically with `Crypt::encrypt()` and `Crypt::decrypt()` to prevent any manual URL manipulation.
    - Designed the screen to display all attempted questions, user's options, and time spent on each question.
    - Configured the Review Mode to only allow the student to answer "Marked for Review" questions again (all other questions are view-only and cannot be changed).
    - Enabled seamless navigation from the Review Mode back to the specific question in the test runner.
  - **Skip & Next Confirmation Workflow**:
    - Renamed button to "Skip & Next" and colored it with slate color if no option is selected.
    - Proceeds directly via `saveAndNext()` without prompt when an option is selected.
    - Added the premium Confirm Skip confirmation modal.
    - Changed the 'marked for review' border indicator to a highly visible, premium `3px` yellow border.
    - Correctly colorized answered questions (fully green) and skipped questions (fully grey).
  - **Style Consistency**: Formatted all changes using Laravel Pint to ensure perfect style compliance.

## Session Handoff - 2026-05-18 (V2.1.1: Static Type Hardening, Skip/Next Confirmation, & .agents Folder Consolidation)
- **Objective:** Resolve all IDE static analysis type errors, compile warnings, implement a Skip & Next confirmation workflow, and consolidate the project governance directories into a single `.agents/` folder.
- **Key Achievements:**
  - **Skip & Next Confirmation Workflow**:
    - Conditionally renamed the primary test conductor navigation button to "Skip & Next" and colored it with a premium slate color if the student hasn't selected an option for the current question.
    - Implemented a premium Tailwind/Blade confirmation modal (`Confirm Skip`) prompting the user to confirm before skipping the unanswered question.
    - Changed the 'marked for review' border indicator to a highly visible, premium `3px` yellow border using Tailwind arbitrary properties (`border-[3px] border-yellow-400`).
    - Proceeds directly via `saveAndNext()` without prompt when an option is selected.
  - **IDE Type Hardening**:
    - Stricter Request-based route and parameter parsing inside `app/Livewire/Student/Exams/Index.php` to completely eliminate compile-time `Expected type 'object'` warnings.
    - Type-hinted and strictly declared property and parameter types for `App\Livewire\Student\Tests\OnlineTestRunner` and `App\Livewire\Student\Tests\ShowResult`.
    - Corrected `$attempt->draft_state` array casting logic inside `OnlineTestRunner` and eliminated double JSON serialization/decoding issues.
    - Resolved `APIController` OTP helper undefined variable and untyped `$returnResponse` property warnings.
  - **Workspace & Agent Governance Consolidation**: Renamed the deprecated `.agent` folder to `.agents` in absolute conformance with workspace rule specifications, fully staging all moved/added/modified files.
  - **Code Style Alignment**: Formatted all changes using `vendor/bin/pint --dirty` to ensure 100% adherence to Pint style.
- **Next Steps:** Proceed with standard deployment workflows and push staged changes to repository.

## Session Handoff - 2026-05-18 (V2.1.0: MSG91 OTP Integration & DLT Compliance)
- **Objective:** Configure, debug, and stabilize the MSG91 SMS gateway integration with the newly approved TRAI/DLT templates.
- **Key Achievements:**
  - **DLT Compliance Integration**: Embedded the explicit DLT Template ID (`1707177540051977802`) directly inside the MSG91 Flow API recipients payload (`DLT_TE_ID`), forcing immediate telecom operator delivery and bypassing automatic dashboard mapping latency.
  - **Config and Environment Alignment**: Wired keys and template configurations within the local `.env` and `config/services.php`.
  - **Service Optimization**: Refactored `App\Services\Msg91Service` to cleanly manage flow transmissions, format OTP templates dynamically, and provide precise raw cURL debugging data.
  - **Code Standard Enforcement**: Ran `vendor/bin/pint --dirty` on all modified files to fix all styling, spacing, and array format issues cleanly.
- **Next Steps:** Proceed with the rest of the Mobile Auth and page integrations in the backlog.

## Session Handoff - 2026-05-08 (V2.0.3: Timer & Modal Stability)
- **Objective:** Fix high-priority UX bugs in the student test conduct module.
- **Key Achievements:**
  - **Flicker-Free Timer Protocol**: Solved the "00:00:00" transition flicker by implementing `wire:ignore` on the timer element and utilizing a stable Alpine.js countdown logic. The timer now runs independently of Livewire re-renders.
  - **Summary View Logic Correction**: Improved the "Review & Submit" flow to allow selecting *any* question (not just marked ones) and ensured the view correctly swaps back to the test interface immediately upon selection.
  - **Version v2.0.3**: Incremented version, performed `npm run build`, and pushed to production.
- **Next Steps:** Monitor for any further feedback on the student panel UX.

## Session Handoff - 2026-04-14 (Test Conduct Redesign & Security Hardening Complete)
- **Objective:** Modernize the student test conduct interface, enforce strict sequential navigation, and unify global profile styling.
- **Key Achievements:**
  - **Ultra-Compact Instructions Page**: Redesigned the instructions page based on Screenshot 1/2 logic. Features a one-line header, dot-separated specs, and a center-aligned student card with Institute branding.
  - **Security Hardening**: Implemented server-side guards in `OnlineTestRunner.php` to enforce sequential navigation. Skipping questions or out-of-order access is now strictly blocked at the controller level.
  - **Absolute Timer Protocol**: Eliminated timer flicker by syncing with an absolute Unix timestamp. The UI performs high-precision JS countdowns independent of Livewire polling cycles.
  - **Result Visuals**: Built a color-coded "bubble" grid on the results page with an interactive modal for reviewing solutions.
  - **Global Profile Consistency**: Unified the sidebar profile display (Avatar, Name, Education Type, Class, and Institute) across the dashboard and test flow for 1:1 design continuity.
- **Next Steps:** Proceed to production deployment (git push) after final verification.

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

## Session Handoff - 2026-05-18 (Pristine Screen Separation & Decoupled Architecture)
- **Current State:** Successfully split the unified exam review/results layout into two fully independent components: `TestReview` and `ShowResult`. All records in attempts tables have been cleanly cleared out to facilitate a perfect end-to-end user test.
- **Key Achievements:**
  - **Pruned Codebases**: Shifted ticking timer, active answers mutation modal, and validation rules into a standalone, lightweight `TestReview` screen. Kept `ShowResult` strictly read-only and static for scores and solution reviews.
  - **No Resume Link**: As per latest specifications, removed the "Back to Exam / Resume" buttons and references from the pre-submit Review screen, locking the student to finishing marked-for-review answers.
  - **Automatic Routing Safeguards**: Added server-side redirections. Active attempts accessing the result route get instantly bounced to `test-review`, while completed attempts accessing the review route get instantly bounced to `show-result`.
  - **Clean Slate**: Purged all entries from `TestAttempt` and `TestAttemptAnswer` tables.
- **Next Steps:** Have the user perform the final verified test run. All code fully formatted with `vendor/bin/pint --dirty`.


## Session Handoff - 2026-05-19 (V2.3.0: Guest Safeguards & Profile Validation)
- **Objective:** Secure guest routes with middleware redirects and ensure profile OTP changes display proper validation error messages.
- **Key Achievements:**
  - **Dynamic Portal Redirects:** Updated `IsStudentGuest`, `IsAdminGuest`, `IsFranchiseGuest`, and `IsManagementGuest` middleware to dynamically route logged-in users to their role-specific dashboard (Admin, Franchise, Management, or Student) without logging them out.
  - **Protected Entry Routes:** Applied `studentguest` middleware to guest pages (`login`, `registration`, `forgot-password`, `corporate-signup`, and `contributor-signup`) to block access for active sessions.
  - **Validation Toast Hooks:** Wrapped email/mobile OTP send and verification functions in the student profile component with try-catch blocks to catch `ValidationException` and display it as an error toast.
  - **Auto-Formatting:** Formatted all changed code with `vendor/bin/pint --dirty`.
- **Next Steps:** Proceed to git push.

## Session Handoff - 2026-05-19 (V2.4.0: Universal Review Re-attempts & Soft Gray Color Scheme)
- **Objective:** Enable students to re-answer all questions on the review screen and change the skipped gray color to bg-gray-200.
- **Key Achievements:**
  - **Universal Re-attempts:** Removed the filter restricting review mode to marked-for-review questions. Clicking any bubble on the review screen now launches the re-attempt modal.
  - **Safe Database Mutators:** Modified the backend save review answer code to utilize `updateOrCreate` to support answering unvisited/skipped questions directly.
  - **Soft Gray Theme:** Replaced `bg-gray-400` with `bg-gray-200` (text-gray-700) for all skipped/visited-but-unanswered bubbles in the review layout, active test runner, and the results legend.
  - **Compliance Check:** Ran Pint formatting checks on all changed files successfully.


## Session Handoff - 2026-05-19 (V2.5.0: Attempt Screen Full Width & Flexible Sidebar)
- **Objective:** Adapt attempt screen (OnlineTestRunner) layout to be full width like the header, widen the sidebar, reduce question bubble size, and wrap bubbles up to 10 per row.
- **Key Achievements:**
  - **Header Alignment:** Replaced the `max-w-400` container wrapper class with `max-w-none` to make the question layout match the full horizontal span of the top header.
  - **Sidebar Expansion:** Widened the sidebar component from `w-80` (320px) to `w-96` (384px).
  - **Flexible Wrapping Layout:** Refactored the hardcoded `grid-cols-5` columns to a wrapping flex container (`flex flex-wrap gap-1.5 justify-start`).
  - **Sized Down Bubbles:** Shrunk question bubbles by 20% (to `w-8 h-8` and `text-xs`).
  - **Code Health:** Verified clean style checks with `vendor/bin/pint --dirty`.


## Session Handoff - 2026-05-19 (V2.6.0: Full Size Circles, 10 Per Row Sidebar Grid & Lint Refactoring)
- **Objective:** Revert circles back to full size (`h-10 w-10 text-sm`) while keeping 10 per row by expanding sidebar width, make question header black, and resolve all @[current_problems] warning indicators.
- **Key Achievements:**
  - **Reverted Bubble Dimensions:** Restored `h-10 w-10` dimensions and font size to `text-sm` for sidebar question bubbles.
  - **Wider Sidebar canvas:** Expanded sidebar width to `w-120` (equivalent to `w-[480px]`) to hold 10 full-sized bubbles horizontally.
  - **Tailwind Warn Resolving:** Changed `flex-shrink-0` to `shrink-0` across three view files, replaced custom bracket sizes with standard Tailwind 4 variables (`w-120`, `gap-1.25`, `min-h-22.5`, `min-h-35`, `border-2`, `z-100`, `z-110`, `z-130`), fixing all current Tailwind linters warnings.
  - **Type Declaration Checks:** Added type hints (`mixed $value`) and return types (`void`) in `Register.php`.
  - **Solid Black contrasting numbers:** Swapped `text-[#dc2626]` in the main content header to `text-black`. Changed bubble text colors to `text-black` (for visited/unvisited/locked) to maximize number legibility.
  - **Code Health:** Formatted codebase with `vendor/bin/pint --dirty`.


## Session Handoff - 2026-05-19 (V2.7.0: Re-attempt Modal Button Layout Adjustments)
- **Objective:** Improve button alignment and remove redundancy in the review re-attempt modal.
- **Key Achievements:**
  - **Cancel Button Removal:** Deleted the redundant "Cancel & Close" button from the footer.
  - **Save & Update Alignment:** Moved the "Save & Update Answer" button to the right end of the footer (`flex justify-end`).
  - **Formatting**: Verified clean styling using `vendor/bin/pint --dirty`.


## Session Handoff - 2026-05-22 (V2.9.0: Test Flow Instruction Screen & External Link Interception Fixes)
- **Objective:** Fix the Start Test flow on the Package Details page to show instructions/agreement screen, and prevent the "Watch Video" (and other media) links from redirecting to the homepage.
- **Key Achievements:**
  - **Start Test Flow Recovery:** Modified `Details.php` component to fetch the student's attempt status for each package test. Adjusted the package details Blade view to display the "View Results" button if completed, the "Resume" button if in progress, and the "Start Test" button pointing to the instructions/agreement screen (`student.test-name` route) if not started.
  - **External Link Interception Fix:** Added the `external` attribute to all Mary UI `<x-button>` tags in `details.blade.php` that link to external resources (YouTube classes, PDF e-books/notes in storage, and GK downloads). This prevents Livewire's `wire:navigate` SPA router from intercepting clicks and redirecting students to the homepage.
  - **Linter & Code Health:** Ran `vendor/bin/pint --dirty` successfully to enforce project style standards on the updated controller and view files.

