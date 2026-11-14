# Process Logs

## Log 26 (2026-11-09): Question Bank Import - Sample Spreadsheet Fix & Formatted Text Parser
- **Context:** User identified two defects at `/administrator/questions-bank/import` (`App\Livewire\Admin\Questions\QuestionImport`):
  1. `public/samples/question_import_sample.xlsx` had an alignment error where the demo subjective question in row 2 had its active status displaced to column 13 (`""`) with an invalid status string `"active"`.
  2. Need for a formatted text / paste MCQ importer (identical to the assessment quiz import workflow in `SchoolManagementSystem`), parsing text directly into structured records for preview and batch save.
- **Remediation Implemented:**
  - **Sample Excel Spreadsheet Alignment:**
    - Re-generated `public/samples/question_import_sample.xlsx` using PhpSpreadsheet.
    - Standardized exactly 12 columns (`question`, `solution`, `explanation`, `question_type`, `mcq_options`, `ans_1`..`ans_5`, `mcq_answer`, `status`).
    - Fixed row 2 so status is located in column index 11 (`status`) with valid enum value `'approved'`.
  - **Formatted Text MCQ Parser:**
    - Updated `QuestionImport.php`: Added `$importMode` (`'file'` vs `'paste'`) and `$pastedText`.
    - Added `insertSampleFormat()` prefilling 3 structured questions with options, answers, and explanations.
    - Implemented `parseFormattedMcqText(string $pastedData): array` supporting patterns: numbered questions (`1. `, `1) `, `Q1. `), option letters (`(A)`, `A) `, `A. `), answer keys (`Ans: B`, `Answer: (C)`, `Correct Answer: A`), and optional explanations (`Explanation: ...`, `Solution: ...`).
    - Fixed database persistence in `saveAll()`: Coerced empty string values `""` on nullable foreign keys (`board_agency_state_id`, `subject_part`, `subject_lesson_chapter`) to `null` to eliminate MySQL 1366 errors.
  - **Livewire UI:**
    - Updated `question-import.blade.php` with pill tabs switching between "Upload Spreadsheet" and "Paste Formatted Text".
    - Added text area with "Insert Sample Format" and "Clear" helper actions.
    - Integrated with existing editable preview table and `saveAll()` persistence flow.
- **Verification:**
  - Tested parsing via Tinker: Sample text parsed accurately into 3 MCQs with mapped answer keys (`ans_3`, `ans_3`, `ans_2`).
  - Tested batch insertion: Successfully saved records into `question_bank` with valid enum values.
  - Formatted codebase using `vendor/bin/pint --dirty`.

## Log 25 (2026-11-09): Multi-Select Checkbox Dropdown Conversion
- **UI/UX Enhancement:** Replaced the legacy raw `<select multiple>` controls for "Type of Institution" and "Interested For" in `bussiness-enquiry.blade.php` with a modern Bootstrap 5 checkbox dropdown component (`.custom-multi-select`).
- **Interaction Model:**
  - Standard click opens a dropdown menu (`data-bs-auto-close="outside"`) without requiring users to hold `Ctrl` or `Cmd`.
  - When 0 selected: Shows placeholder ("Select Type of Institution" / "Select Interested For").
  - When 1 selected: Displays the full option name (e.g., `Kids School (PG - 5th)`).
  - When 2+ selected: Displays first selected option + badge indicator (e.g., `Kids School (PG - 5th) +1`, `+2`).
  - Cap enforced: Enforces maximum 3 selections by disabling unchecked items and updating the indicator counter. Includes a one-click "Clear" button.
- **Verification:**
  - Automated browser test verified dynamic label updates on toggle, max-3 disable constraint, and payload serialization.
  - Successfully submitted and saved to `corporate_enquiries` (Record ID: 23) with correct JSON encoded array columns.


## Log 24 (2026-11-09): Corporate Enquiry Flow Audit & End-to-End Browser Resolution
- **Root Cause Analysis (`/corporate-enquiry`):**
  1. **City Dropdown Disappearance:** `InternalRequestsController:get_cities` erroneously called `getAvailableCitiesByState($stateId)` which only returned cities with an existing active franchise. For almost all states, this returned `[]`, triggering JS to hide `#citiesDiv`. The form was then submitted with empty `city_id`, triggering backend 422 `The city id field is required.`
  2. **GET Form Submission:** `<form id="corporate">` lacked `method="POST"`, `action`, and `onsubmit="return false;"`. Any Enter press or detached handler triggered a native browser GET dump into the address bar.
  3. **Silent 422 Failures:** `.fail()` showed generic `'Server Error, please try again later.'` without surfacing validation errors (`xhr.responseJSON.errors`).
  4. **OTP Script Bugs:** `mobile_input` vs `mobileInput` variable mismatch in `custom.js` caused `ReferenceError` on verify. Also, `JSON.parse(data)` on pre-parsed JSON objects threw `SyntaxError`.
  5. **Logo Upload Script Errors:** Called legacy `swal()` which threw `ReferenceError` and had an unescaped `alert(...)` debugging statement.
  6. **Unique Mobile Check Contamination:** `unique_mobile_check` checked `User::where('mobile', $mobile)` for corporate enquiries, preventing legitimate users or existing students from enquiring about a franchise.
- **Remediation Implemented:**
  - `InternalRequestsController.php`: Updated `get_cities` to call `getCitiesByState($stateId)`. Adjusted `unique_mobile_check` for `type === 'corporate'` to only block if an active franchise user already exists.
  - `FormsController.php` & `InternalRequestsController.php`: Set `corporate_logo` and `institute_images_pdf` validation rules to `nullable|file` instead of `sometimes|file`.
  - `public/skillup/js/custom.js`: Fixed `mobileInput` naming, relaxed JSON parsing, and checked boolean/string equality for OTP responses.
  - `bussiness-enquiry.blade.php`: Added `method="POST" action="{{ route('bussines_enquiry') }}" onsubmit="return false;"`. Replaced legacy `swal()` with `showAlert()`, bound select2 on `$(document).ready`, and surfaced 422 validation errors to user.
- **Verification:**
  - Automated headless Firefox browser test via Geckodriver: Selected Uttar Pradesh (state 4022) -> verified 625 cities populated dynamically -> selected city -> verified OTP -> submitted form -> received 200 OK + "Thank you! We will reach back to you within 72 hours." popup.
  - Database record ID 22 successfully persisted in `corporate_enquiries`.


## Log 23 (2026-11-09): Form GET Submission Mechanism & Livewire DOM Disconnect
- **Mechanism of GET Submission Identified:**
  1. Livewire sends AJAX POST to `/livewire/update`.
  2. If the backend throws a 500 error (e.g., missing `$user->username`, missing `user_details.country`, or null pointer `$inst->user_id`), Livewire 3 enters a detached/error state.
  3. Subsequent clicks or Enter keypresses bypass Livewire's crashed JavaScript event listeners.
  4. The browser falls back to native HTML form submission. Because `<form>` omits `method="POST"`, the browser natively converts the submission into a GET request, appending all form inputs to the URL.
- **Client Script Crash Vector:** In non-Livewire forms (`bussiness-enquiry.blade.php`), deferred `select2.min.js` causes synchronous inline scripts to fail with `TypeError: $(...).select2 is not a function`, preventing the `submit(preventDefault)` handler from attaching at all.

- **Form Submission Failure Root Cause:**
  - `<form>` tags in both `register.blade.php` and `bussiness-enquiry.blade.php` omitted `method="POST"`.
  - In `bussiness-enquiry.blade.php`, `select2.min.js` loaded via `<script defer>`, while the inline script executed synchronously during HTML parsing. Calling `$('#institute_type').select2()` threw an uncaught `TypeError`, killing script execution before the `$('#corporate').submit(...)` handler was bound.
  - In `register.blade.php`, any uncaught JavaScript error or Enter keypress without `method="POST"` causes browser native fallback to standard HTML GET submission with query parameters.
- **Production Schema & Field Reconciliation:**
  - Active institutes exist in `franchise_details` (14 records), NOT `corporate_enquiries` (0 records).
  - Missing `$user->username` (maps to `email`) and `$userDetailsDb->country` (default `101`).



## Log 21 (2026-05-22): Laravel Agent-Debugger Package Replacement
- **Major Shift (Package Transition):** Replaced the custom basic Zero-Touch Debug Activity Logger with the feature-rich `clcbws/laravel-agents-debug` package.
- **Local Integration:** Added a local path repository configuration in `composer.json` and symlinked `/mnt/BWS/public_projects/Local_Debug_Activity` under `require-dev`.
- **Cleanup:** Purged `app/Http/Middleware/DebugActivityLoggerMiddleware.php`, removed it from `bootstrap/app.php`, deleted the custom `debug_log` function from `app/Helper/GlobalHelper.php`, and deleted the `/debug-log` POST route block from `routes/web.php` to prevent namespace/route collisions.
- **Configuration & Verification:** Added `AGENT_DEBUGGER_ENABLED=true` to `.env`, published config, enabled the suite with `php artisan agent:debug-on`, and verified status via `php artisan agent:debug-status`.
- **Viewport Indicator Registration Fix:** Discovered that the standard Laravel 11/12 HTTP Kernel class does not define `appendMiddleware()`. Modified the local package code in `src/DebugActivityServiceProvider.php` to check for and use `pushMiddleware()` as a fallback, successfully registering the `ViewportBorderInjector` middleware.

## Log 4 (2026-04-14): Test Conduct Redesign & Security Hardening
- **Major Shift (Timer Protocol):** Migrated from Livewire Polling to **Absolute Unix Timestamps**. Frontend now calculates remaining time against a fixed `end_time` in JS, eliminating flickering.
- **Major Shift (Security Guards):** Successfully implemented server-side `selectQuestion` guards to prevent out-of-order navigation during tests.
- **UI Architecture:** Finalized **Ultra-Compact Instructions Page** (1300px width, reduced padding, sidebar institute branding).
- **Code Health:** Ran `vendor/bin/pint --dirty` - all new files passing standards.

## Log 1 (2026-02-27): Livewire Refactor State
- **Major Shift:** The whole TestSection creation UI was refactored into a hierarchy of Livewire components (`TestForm` -> `TestSectionManager` -> `TestSectionRow`).
- **Fix Pattern:** Fixed common `QueryException` during subject hierarchy cascading. Common issue with `Gn_ClassSubject` relationships: `class_id` was being treated as unknown, fixed by returning `->pluck('subject')` directly.
- **Sync Logic:** Automatically syncing sections in the database based on `no_of_sections` in `TestForm.php`. 
- **Alpine Integration:** Successfully implemented browser-side event dispatching for UI notifications (`$this->dispatch('notify')`). This pattern will be used for all future Livewire notifications.

## Log 2 (2026-03-01): Workspace Stabilization
- Initialized official `.agent/` folder structure (architecture.md, session_sync.md, backlog.md, process_logs.md, standards.md) to comply with the workspace governance rule.
- Synced context from `current_work_status.md` and `task.md`.

## Log 3 (2026-03-08): Package Access & Auto-Unpublishing
- **Major Shift:** Moved validation logic (completeness checks) out of standard Controller flows and into Observers (`TestObserver`, `TestSectionObserver`, `TestQuestionObserver`) via a centralized `TestCompletenessService`.
- **Fix Pattern:** Strict Subject/Part filtering in component logic (`TestQuestionsManager`) overreaches when querying. Explicitly map `Subject` and `Part` columns; verify against `in_array` instead of trying to map through relationships to avoid soft-delete/null errors.
- **Frontend Sync:** UI elements (`home.blade.php`) now leverage `Auth::user()` properties and a pre-compiled `$purchased_packages` array from `HomeController` to conditionally render CTA buttons, minimizing view-level DB queries.
- **SweetAlert Standard:** Shifted away from Alpine.js based toasts for Livewire responses (`$event.detail` wrapping issues in LW3). Implemented standard `Livewire.on('notify')` catching SweetAlert triggers in layout scripts.

## Log 5 (2026-05-18): MSG91 Flow Integration & DLT Compliance
- **Major Shift (DLT Payload Structuring):** Migrated from implicit flow mapping to explicitly passing `DLT_TE_ID` inside the `recipients` payload block to bypass telecom carrier blocking.
- **Environment Parity:** Aligned the `.env` configuration keys and `config/services.php` settings to map MSG91 credentials cleanly.
- **Verification:** Verified immediate delivery to the test handset (`9873350509`) with a 200 OK API status response.
- **Code Health:** Formatted codebase with `vendor/bin/pint --dirty` to maintain Laravel design excellence.

## Log 6 (2026-05-18): Premium Result Screen REDESIGN (Parity with Template)
- **Major Shift (Score Display):** Removed the final obtained score from the result header in ShowResult view and implemented a premium, horizontal row of 5 color-coded stats boxes.
- **Color-Coded Parity Cards:** Designed 5 beautiful cards matching the exact HEX colors and circular icons of the template screenshot: beige/tan (Total Questions/Marks), coral/rose (Correct Answers/Obtain Marks), amber/orange (Wrong Answers/Negative Marks), terracotta (Skipped Questions/Effected Marks), and energetic crimson (Total Obtained Marks).
- **Dynamic Header:** Replaced the header score section on the right with a clean, dynamic test duration text (`Duration: {{ $test->time_to_complete }} Minutes`).
- **Code Health:** Pint formatted and standard check passed.

## Log 7 (2026-05-18): Centered Review Screen REDESIGN (Parity with 2nd Template)
- **Major Shift (Visual Isolation):** Split the `ShowResult` blade view completely between `@if($mode === 'review')` and `@else` to achieve isolated layouts for the Review screen and the Results screen.
- **Centered Layout & Progress Gauge:** Rebuilt the Review Page header with centered `Test Review & Submission` text, followed by the test title in deep rose/maroon color.
- **Progress Gauge Card:** Designed a wide left card rendering `Completion` next to a beautiful circular stroke progress gauge showing dynamic completion percent (e.g. `84%`).
- **Color-Coded Stats Cards Grid:** Integrated a 2x2 grid on the right displaying Attempted (soft green), Not Attempted (soft grey), For Review (soft yellow with a 3px yellow border), and Total Visit (soft purple/indigo) counts to establish an immediate, intuitive visual guide of what each color stands for.
- **Unified Color Code Bubble Grid:** Styled the question bubble grid on the Review page to use the exact same color scheme as the runner and results: fully green (`#16a34a`) for Answered/Attempted, grey (`bg-gray-400`) for Visited/Skipped, white for Unvisited, with a `3px` yellow border (`border-yellow-400`) if the question is marked for review.
- **Strict Review Interactivity:** Only questions flagged as "Marked for Review" are clickable on the review screen. Clicking them opens the modal to let students select (if skipped) or change (if answered) their response, and on save, `'is_marked_for_review' => false` is updated to lock the question. All other completed/unattempted questions are fully locked (`disabled` / `opacity-60`) to enforce test integrity.
- **Explicit Student Guide:** Positioned a premium "Student Guide" card cleanly **below the bubble grid** explaining re-attempt logic, locked questions, and how clicking "Back to Exam / Resume" redirects back to the active test runner.
- **Code Health:** Pint styled and verified standard check successfully.

## Log 8 (2026-05-18): Screen Separation & Pure Pre-Submit Review Architecture
- **Major Shift (True Screen Separation):** Refactored the unified review/results code into two strictly separated Livewire components: `TestReview` (handles pre-submit active exam reviews) and `ShowResult` (handles post-submit static score cards).
- **Decoupled Business Logic:** Cleanly migrated ticking timers, interactive modal forms, database re-answering handlers, and incomplete checks to `TestReview.php`, keeping `ShowResult.php` 100% read-only and ultra-fast.
- **Removed Resume Navigation:** Completely removed the "Back to Exam / Resume" button and guide links from the pre-submit Review screen as per the latest requirements, locking the user strictly to marked-for-review answers.
- **Database Sanitization:** Cleared out all records in `test_attempts` and `test_attempt_answers` in the database, allowing for pure, isolated, clean-slate testing.
- **Code Density Standards:** Achieved <230 line components for both classes, fully complying with standard 5 of our Global standards. All style checks formatted with `vendor/bin/pint --dirty`.

## Log 9 (2026-05-19): MSG91 Signup & Profile OTP Integration
- **Major Shift (OTP SMS Integration):** Integrated `Msg91Service` into all signup and mobile profile update flows where OTPs were being saved to the database but never transmitted to the user's phone.
- **Wired Components:**
  - `App\Livewire\Frontend\Auth\Register` (Student registration form)
  - `App\Livewire\Frontend\Auth\ContributorSignUp` (Contributor registration form)
  - `App\Livewire\Student\Profile\Index` (Student profile edit screen)
  - `App\Http\Controllers\InternalRequests\InternalRequestsController` (Legacy signup AJAX controller)
  - `App\Http\Controllers\Student\DashboardController` (Student mobile update controller)
  - `App\Http\Controllers\Frontend\Franchise\UserController` (Franchise profile update controller)
- **Code Health:** Automatically formatted all modified files using `vendor/bin/pint --dirty`.
- **Type Checking Optimization:** Resolved multiple IDE/static analysis type-checking errors (e.g. `Expected type 'object'. Found 'array<string, mixed>'`) inside `UserController`, `InternalRequestsController`, and `DashboardController` by replacing direct `request()` helper calls with class-level `$request` or `$req` parameters, as well as fixing a namespace type-error for the `Log` facade in `DashboardController`.
- **Livewire AJAX Payload Fix:** Fixed a critical bug where the OTP button got stuck on "Sending OTP..." on the frontend. The issue was caused by debug `echo` statements in `Msg91Service` printing directly to stdout during the API response phase, which corrupted the Livewire JSON payload structure and crashed the browser's JSON parser. Removing these `echo` statements resolved the loading state lockup.

## Log 10 (2026-05-19): Premium Interactive OTP Verification UI
- **Major Shift (Interactive State Bindings):** Bound inputs and button states directly to the OTP lifecycle variables (`$isOtpSend` and `$otpVerificationStatus`). The mobile input and "Get OTP" button are marked readonly/disabled as soon as the SMS is sent. The OTP field and "Verify" button remain disabled until the SMS is sent, and go readonly/disabled once verified.
- **Contextual UI Feedbacks**: Integrated clear success information messages below the input grouping (e.g. "OTP successfully sent to your mobile number." and "Mobile number verified.") to guide the user.
- **Unified Validation Exception Hooks**: Modified `getOtp()` and `verifyOtp()` on both Student and Contributor registration components to intercept `ValidationException` and display the error message as a SweetAlert2 error toast via the global `error()` JS function.
- **Security Hardening**: Enforced registration guardrails in `register()` to block registration attempts if the OTP has not been verified.
- **Code Health & pint**: Formatted all changed files using `vendor/bin/pint --dirty` to ensure strict compliance.

- **Role-Based Guest Routing & Redirect Safeguards:** Modified all guest-facing auth middleware (`IsStudentGuest`, `IsAdminGuest`, `IsFranchiseGuest`, and `IsManagementGuest`) to intercept authenticated sessions and redirect them dynamically to their respective dashboard portals (Admin, Franchise, Management, or Student) instead of performing a hard logout or letting them access guest pages.
- **Unified Routing Bindings:** Applied `studentguest` middleware to `login`, `registration`, `forgot-password`, and `corporate-signup` in `routes/web.php`, and `contributor-signup` in `routes/franchise.php` to prevent logged-in users from accessing them.
- **Robust Student Profile OTP Validation:** Refactored OTP and password update methods in `App\Livewire\Student\Profile\Index` to capture `ValidationException` and display it as an error toast notification to the user, ensuring a premium user experience.
- **Code Formatting:** Cleaned and verified all changes with `vendor/bin/pint --dirty`.

## Log 12 (2026-05-19): Universal Question Re-attempts & Light Gray Skipped Color
- **Major Shift (Pre-submit Re-attempt for All Questions):** Lifted the check restricting review mode to only "marked for review" questions. Students can now open and answer/re-answer *any* question from the review screen.
- **Dynamic Database Update/Create:** Switched to using `updateOrCreate` inside `saveReviewAnswer()` to safely handle cases where an unattempted/unvisited question is answered for the first time directly from the review page.
- **Light Gray Skipped Color Scheme:** Changed the background color of visited-but-unanswered (skipped) questions from dark gray (`bg-gray-400 text-white`) to a soft light gray (`bg-gray-200 text-gray-700`) across `test-review.blade.php`, `online-test-runner.blade.php`, and the `show-result.blade.php` legend.
- **Formatted & Tested:** Formatted code using `vendor/bin/pint --dirty` and ensured zero errors.

## Log 13 (2026-05-19): Attempt Screen Width Expansion & Sidebar Bubble Layout Refactoring
- **Layout Expansion:** Removed the `max-w-400` constraint from the test runner wrapper, replacing it with `max-w-none` to make the content page expand to full width matching the header.
- **Sidebar Widened:** Increased the sidebar container width from `w-80` (320px) to `w-96` (384px) to afford more horizontal canvas space.
- **Compact Question Bubbles:** Reduced the question bubble circle size by 20% (from `h-10 w-10 text-sm` to `h-8 w-8 text-xs`) for both locked divs and active buttons.
- **Flexible Grid Wrapping:** Converted the rigid grid layout (`grid grid-cols-5`) to a flexible, self-wrapping flexbox structure (`flex flex-wrap gap-1.5 justify-start`) enabling up to 10 bubbles per row dynamically wrapping as screen real estate dictates.

## Log 14 (2026-05-19): Sidebar Circle Size Reversion, Width Expansion & Black Text Indicators
- **Circle Size Reversion:** Reverted the question bubble circles inside the attempt screen sidebar back to their original size (`h-10 w-10 text-sm`) as requested.
- **Width Expansion:** Increased the sidebar container width further to `w-120` (equivalent to `w-[480px]`) to support rendering exactly 10 questions per row at their original size.
- **Micro Spacing:** Optimized bubble packing with a custom compact gap spacing of `gap-1.25` (equivalent to `gap-[5px]`) in the wrapping flexbox container to fit exactly 10 full-sized bubbles horizontally.
- **Question Number Contrast & Header Color:** Changed the text color of the main question header ("Question No X") from red to black (`text-black`). Updated the unvisited, visited, and locked bubble text colors to solid black/black opacity to ensure maximum contrast and clear numbers.
- **Tailwind warning cleanup:** Changed `flex-shrink-0` to `shrink-0`, bracket custom spacing to standard variables (`w-120`, `gap-1.25`, `min-h-22.5`, `min-h-35`, `border-2`, `z-100`, `z-110`, `z-130`) across `online-test-runner.blade.php`, `show-result.blade.php`, and `test-review.blade.php` to clean all current Tailwind warnings. Added type declarations in `Register.php`.

## Log 15 (2026-05-19): Review Re-attempt Modal Button Placement & Close Flow Refinements
- **Remove Redundant Cancel Button:** Removed the redundant "Cancel & Close" button from the re-attempt modal footer since the modal already supports modal backdrop clicks to close and has an "X" button in the header.
- **Footer Button Alignment:** Aligned the "Save & Update Answer" button to the right side of the footer using `flex justify-end`.

## Log 16 (2026-05-19): Backdrop Click Outside Dismissal for Re-attempt Modal
- **Added Backdrop Click dismissal:** Added `wire:click.self="$set('showSolutionModal', false)"` on the backdrop outer container of the re-attempt modal to close it when the user clicks outside.

## Log 17 (2026-05-21): Portable GD Extension Dynamic Loader
- **Major Shift (Dynamic extension injection):** Resolved `gd` extension missing dependency using `PHP_INI_SCAN_DIR=:./.agents/php-config` to dynamically append local `gd.ini` loading `gd.so` without needing root/sudo access.
- **Composer integration:** Pre-pended `PHP_INI_SCAN_DIR=:./.agents/php-config` to `composer dev` script in `composer.json` to seamlessly boot up Vite and Artisan server out-of-the-box.
- **Style compliance:** Formatted and styled all modified files with `vendor/bin/pint --dirty`.

## Log 18 (2026-05-21): Local Environment Server-Level Activity Logger
- **Major Shift (Zero-Touch Logging):** Created a global request and database query interceptor `DebugActivityLoggerMiddleware` which logs full HTTP requests, Livewire method calls/updates, database queries with execution millisecond times/bindings, and all composed Blade views.
- **Frontend Integration:** Automatically injected custom `window.debugLog(message, context)` global Javascript helper and frontend global JS exception catching right before `</body>` on all web HTML pages.
- **Manual Triggers:** Added `debug_log($message, $context)` global PHP helper function to allow developers to trigger server logs manually from any code (views, plain controllers, or Livewire components).
- **Environment Locks:** Fully locked all loggers and scripts under `config('app.env') === 'local'` and `env('DEBUG_LOGGING') === true` conditions to ensure complete environment safety.
- **IDE static analysis hardening:** Fully type-hinted middleware properties (`array $queries`, `array $views`, `?float $startTime`) and replaced the `view()->composer(...)` helper call with the explicit `View` Facade (`View::composer('*', ...)`) to eliminate static analyzer warnings and errors.

## Log 19 (2026-05-22): PHP 8.2 Strict Type Hardening Across Image Optimizer & Global Legacy Functions
- **Command Typings (OptimizeExistingImages):** Declared typed properties (`ImageService $imageService`), parameters, and return types for methods (`shouldOptimize`, `processImage`, `handle`, and helper subroutines) to comply with high code quality guidelines.
- **Procedural Typings (GlobalFunctions):** Hardened all 15 core procedural helper functions (`getCitiesByState`, `getAvailableCitiesByState`, `generateBranchCode`, `getClassesByEducation`, `getBoardsbyClass`, `defaultNumberCheck`, `numberInUse`, `sendSMS`, and `verifyOtp`) with explicit scalar, union (`int|string`), nullability (`?string`), array, and object type hints.
- **Styling Alignment:** Standardized and verified all changes with `vendor/bin/pint --dirty`.

## Log 20 (2026-05-22): Student Test Results and Review Mode Upgrades
- **Terminology Shift:** Renamed "Left Questions" and "Left Marks" to "Skip Questions" and "Skip Marks" respectively inside `show-result.blade.php` statistics grid.
- **Review Mode Re-attempt Upgrades:** Added standard `clearReviewAnswer()` method inside `TestReview` Livewire component class to set `$selectedAnswer` and db recorded selection to `null` to safely skip answered questions.
- **UI Actions:** Integrated a premium styled "Clear Response & Skip" footer button in the re-attempt popup modal of `test-review.blade.php`.
- **IDE Static Analysis Resolution:** Imported and utilized explicit `Illuminate\Support\Facades\Session` facade calls (`Session::flash(...)`) instead of loose global `session()` procedural helper calls, resolving the type analyzer's "Expected type 'object'. Found 'null'." error completely.

## Log 21 (2026-05-22): Package Details Test Flow Recovery & External Link Interceptions Fixes
- **Status-Aware Test Action Rendering:** Updated `Details.php` component to eager-evaluate each package test's status using `TestAttempt` model constraints. Modified the test action button inside `details.blade.php` to render status-aware actions:
  - Bounces to `student.show-result` with encrypted parameters for `completed` test attempts.
  - Links to `student.start-test` to direct resume for `running` test attempts.
  - Routes to `student.test-name` to display instructions and the agreement screen for `not_started` attempts.
- **SPA Link Interception Bypass:** Resolved video link, note download, and GK preview redirections to the home page by explicitly declaring the `external` attribute on Mary UI `<x-button>` tags, bypassing Livewire's client-side SPA route interceptor.
- **Formattings:** Standardized codebase styling with `vendor/bin/pint --dirty`.

## Log 22 (2026-05-26): Fix Test Creator and Test Publisher Dropdown Matching Logic
- **Major Shift (Dropdown Matching Fix):** Fixed the bug where the Test Creator and Test Publisher dropdowns in "Manage Test Sections" were empty.
- **Query Resolution:** Removed the double quotes around role names (from `%"creator"%` to `%creator%`) in the query builder. The string in the database column is comma-separated text (e.g. `creator` or `manager,creator,publisher`) and does not contain serialized JSON quotes.
- **Superadmin Inclusion:** Updated the query to explicitly include superadmin users (whose `is_staff` flag is `0` and therefore excluded by `User::directContributorCriteria()`) so they appear correctly in both dropdown lists alongside other active direct contributors.
- **Code Health:** Formatted changes using `vendor/bin/pint --dirty` with no style violations remaining.


## Log 23 (2026-11-02): Implement Admin 2FA (Password + OTP) and Forgot/Reset Password
- **2FA Flow (Credentials First, Then OTP):** Updated `AuthController::adminlogin` so Step 1 (`get_otp`) validates `email` and `password` with `Hash::check($password, $user->password)` against `User` records with `isAdminAllowed = 1`. Sets a 10-minute pre-auth session token before dispatching OTP to prevent OTP abuse/enumeration.
- **Step 2 Verification:** Verified pre-auth session token in `login_otp` before validating dynamic OTP, master OTP (`DefaultOtp`), or config default OTP (`config('app.default_otp')`).
- **Forgot & Reset Password Support:** Enabled forgotten password retrieval and reset:
  - Added `forget_password` handler in `adminlogin` (AJAX) and direct route `administrator.forget_password` in `routes/administrator.php`.
  - Completed `AuthController::adminPasswordReset` and `adminForgetPassword` with `PasswordResetModel` (status tracking and one-time use token).
  - Enhanced `resources/views/Auth/superadmin_login.blade.php` with password input, "Forgot password?" toggle, and reset request handling.
  - Linked `resources/views/Dashboard/Admin/Auth/reset_form.blade.php` to administrative auth flow.
- **Code Health:** Verified with `vendor/bin/pint` and syntax checked.

## Log 24 (2026-11-02): Harden Admin 2FA Against Fixation, Throttling & Zombie Sessions
- **Session Fixation Shield:** Added `$request->session()->regenerate()` immediately upon primary credential validation and upon OTP completion.
- **Brute-Force & Route Throttling:**
  - Added `throttle:20,1` to `administrator.login` and `throttle:5,1` to `administrator.forget_password`.
  - Added in-session OTP retry tracking: limits failed OTP attempts to 5 per session, invalidating the OTP upon breach (`HTTP 429`).
- **Response Contract Standard:** Switched from raw `json_encode()` to typed `response()->json($returnResponse, $statusCode)` with proper HTTP status codes (`200`, `401`, `419`, `422`, `429`).
- **Zombie Session Purge:** Invalidate `remember_token` via `Str::random(60)` upon password reset in `AuthController::adminPasswordReset`.
- **Master OTP Preserved:** Kept master OTP / `DEFAULT_OTP` active as explicitly instructed.
- **Pint & Syntax:** Formatted and syntax verified.

## Log 25 (2026-11-02): Production Gate Alignment & Exception Safety
- **Auth Gate Synchronization:** Aligned `AuthController::adminlogin`, `adminPasswordReset`, and `adminForgetPassword` with `IsAdmin` middleware contract (`isSuperAdmin()` and `status === 'active'`). Prevents unauthorized or non-superadmin users from executing 2FA only to be bounced by the middleware.
- **Mail Transport Exception Safety:** Wrapped synchronous `Mail::to()->send()` operations in try-catch with error reporting to eliminate uncaught `500` server errors caused by external SMTP latency/failures.
- **Pint & Syntax:** Formatted with `vendor/bin/pint` and verified with `php -l`.

## Log 26 (2026-11-05): Resolve CSRF Token Mismatch & Implement Password Visibility Toggle
- **Root-Cause Analysis of CSRF Mismatch:**
  - `session()->regenerate()` was being prematurely invoked in `AuthController::adminlogin()` during Step 1 (`get_otp`). In Laravel, regenerating the session automatically rolls the CSRF token (`_token`), causing Step 2 (`loginStep2`) to submit the initial page's stale token, which triggered HTTP 419 CSRF Token Mismatch.
  - Removed premature session regeneration from Step 1, preserving session ID until authentication completes at Step 2 (`Auth::login`).
  - Added `'csrf_token' => csrf_token()` to all JSON responses to ensure seamless dynamic token synchronization.
  - Added `<meta name="csrf-token">` and global `$.ajaxSetup` with `X-CSRF-TOKEN` to `Layouts/superadminauth.blade.php`.
  - Added automatic 419 session expiration handling with graceful reload in `superadmin_login.blade.php`.
  - Fixed `IsAdminGuest` middleware returning redirect on AJAX requests; now returns JSON redirect contract.
- **Universal Password Reveal:**
  - Added toggleable SVG eye/eye-slash icons to `#admin_password` in `resources/views/Auth/superadmin_login.blade.php`.
  - Added toggleable SVG eye/eye-slash icons to `#password` and `#confirm_password` in `resources/views/Dashboard/Admin/Auth/reset_form.blade.php`.
- **Code Health:** Verified with `vendor/bin/pint`, `php -l`, and Vite `npm run build`.

## Log 27 (2026-11-05): Production Deployment via SSH
- **Remote Host:** `u829699752@82.25.120.120:65002` (`domains/testandnotes.com/public_html`).
- **Deployment Operations:**
  - `git pull`: Updated code to commit `eff0f252`.
  - `/opt/alt/php84/usr/bin/php artisan migrate --force`: Database migrations up-to-date.
  - `/opt/alt/php84/usr/bin/php artisan optimize:clear && optimize`: Cleared and rebuilt events, routes, and compiled views.
  - Verification: Confirmed HTTP 200 on `https://testandnotes.com/administrator/login` with active `<meta name="csrf-token">` and password eye reveal icons.
