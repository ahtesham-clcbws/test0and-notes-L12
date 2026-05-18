# Test Conduct Deep UI Redesign & Security Hardening

This plan outlines the UI redesigns to match the provided screenshots and enforces strict test-taking security, including server-side navigation locks and a robust timer implementation.

## User Review Required

> [!IMPORTANT]
> **Strict Navigation Enforcement (Client & Server)**: 
> Students are blocked from skipping ahead in the test. The UI will disable future unvisited questions. Crucially, the **backend server** will also reject arbitrary jumping. A student can only select a question if it has been marked as visited (via saving/skipping sequentially).
>
> **Review Mode Security**:
> In the Review grid, only questions flagged with "Mark for Review" (Yellow Star) will be clickable. The backend will strictly defend against returning to any other question type from this screen.
>
> **Timer Synchronization Logic**:
> To resolve the `00:00:00` flickering and confusion, the backend will calculate a strict *absolute end time* (Epoch timestamp). The frontend will use Javascript to run a continuous, unflickering countdown towards this absolute timestamp. The backend will enforce this cutoff upon submission, eliminating the need for continuous Livewire timer syncing.

## Proposed Changes

### Component: Instructions
#### [MODIFY] [instructions.blade.php](file:///mnt/WebliesNew/test-and-notes-upgrading/resources/views/livewire/student/exams/instructions.blade.php)
- Restructure the UI to match Screenshot 1 (White background with green right-side block).
- Add the visual "Legend" showing icons/colors: Attempted (Green), Not Attempted (Grey), Mark for Review (Yellow Star/Green).
- Move the profile card and "Start Test" button into the right-side green panel.

### Component: Test Runner Front-end & Logic
#### [MODIFY] [OnlineTestRunner.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Tests/OnlineTestRunner.php)
- **Timer Security**: Retain absolute `$endTimestamp`. Remove logic relying on constant `$timeLeft` recalibrations during mid-test navigation.
- **Server Guard (`selectQuestion`)**: Update the method to abort/ignore requests if the requested question index is not in `visitedQuestions` AND is not the immediately sequential next question.
- **Server Guard (`reviewSelectQuestion`)**: Create a specific method for the Review screen. It will only permit navigation if `in_array($questionId, $this->markedQuestions)`.
- **Save & Next**: Ensure this action properly unlocks the next sequential question and commits it to the `visitedQuestions` array securely.

#### [MODIFY] [online-test-runner.blade.php](file:///mnt/WebliesNew/test-and-notes-upgrading/resources/views/livewire/student/tests/online-test-runner.blade.php)
- **Unflickering Timer**: Update the `x-data` Javascript to unconditionally count down to the backend-provided `endTimestamp`. Remove Livewire sync logic from the timer component.
- **Header & Tabs**: Flatten to simple green/grey boxes with the total questions count right-aligned.
- **Question Layout**: Standardize radio buttons and implement the exact action buttons ("Mark for Review", "Clear Response", "Save & Next") matching the mock sizes and colors.
- **Sidebar Palette**: 
    - Standardize circles to Grey, Green, or have a Yellow Star. 
    - Add HTML `disabled="true"` to any circle that represents a locked/unvisited question.
    - Change button to "Review & Submit".
- **Dedicated Review View (Screenshot 3)**: 
    - Remove the `x-modal`. Replace with a full `wire:if` view state.
    - Show the grid of all 100+ questions. Only yellow stars will have a `wire:click` action securely tied to the backend. Add a large "Final Submit" button at the bottom.

### Component: Test Results
#### [MODIFY] [ShowResult.php](file:///mnt/WebliesNew/test-and-notes-upgrading/app/Livewire/Student/Tests/ShowResult.php)
- Add state variable `$selectedQuestionId` and a toggler method `viewSolution($questionId)` to enable modal pop-ups.

#### [MODIFY] [show-result.blade.php](file:///mnt/WebliesNew/test-and-notes-upgrading/resources/views/livewire/student/tests/show-result.blade.php)
- Remove the stacked accordion solution viewer.
- Implement the flat overview grid (Screenshot 4).
- Top row: counts for "Right Answer" (Green), "Wrong Answer" (Red), "Not Attempted" (Grey).
- Grid layout showing color-coded circles for every question based on the evaluation logic.
- Clicking any grid circle will dispatch the `$selectedQuestionId` to a minimalist modal showing the original question, correct answer, and explanation.

## Verification Plan

### Manual Verification
1. Open the Instructions page to check split layout and Legend rendering.
2. Start test. Observe timer count down smoothly without flickering upon navigating.
3. Validate sidebar: Further questions must be unclickable. Attempting to force-click via DevTools must fail server-side.
4. Go to Review screen: Only Yellow stars should be clickable. Attempting to force-click green/grey via DevTools must fail server-side.
5. Finish test. Validate result grid renders color-coding reliably. Clicking a circle should pop up the specific solution.
