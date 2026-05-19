# Process Logs

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


