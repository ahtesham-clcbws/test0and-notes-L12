# Implementation Plan - Livewire Online Test Module

Refactor the "Online Conduct Test" into a **Livewire 3 stateful component** to enforce single-attempt security locks and implement real-time, reload-safe navigation answers logging.

## Proposed Changes

### 1. Database & Migrations
Add tracking fields to securely locks attempts and supports resuming states safely without resetting timers:
- **[NEW] Migration**: Add `status` and `draft_state` to `gn__student_test_attempts` table.
    - `status`: String (`running`, `completed`) to track attempt lock status.
    - `draft_state`: Text/JSON payload to store temporary UI layouts (Visited, Marked, Skipped) for seamless re-entry hydration on reload.

### 2. Livewire Components
#### **[NEW] `OnlineTestRunner`**
**Path:** `app/Livewire/Student/Tests/OnlineTestRunner.php`
Stateful coordinate managing single attempt testing cycle:
- **Properties:**
    - `TestModal $test`: Initializing configuration model.
    - `array $questions`: Mapped sectional groups.
    - `array $answers`: Linked model caching loaded rows accurately on initialization.
    - `int $timeLeft`: Current server evaluated continuous ticking.
- **Methods:**
    - `mount($test_id)`: Creates attempts row at START with state `running`. Overrides duration triggers if re-entering.
    - `saveSelection($qId, $val)`: Persists answers instantly into `Gn_Test_Response`.
    - `submitTest()`: Marks status as `completed`, forcing immediate forward redirection.

### 3. Views & Layouts
#### **[NEW] `online-test-runner.blade.php`**
- **Timer Sub-module**: Polling server heartbeat `<div wire:poll.10s>` verifying absolute expiry safely overriding client slow CPU stalls.
- **Question Dashboard**: Displaying active question metadata, answers nodes layout dynamically.
- **Navigation Grid**: Rendering visisted vs marked indexes correctly hydrated on page reloads to prevent state loss mid-crash.
- **🔒 Anti-Cheat Browser Guards**:
    - Add Javascript navigation history trap (`history.pushState` and `window.onpopstate = history.go(1)`) to **disable the browser back button completely** during an active session, forcing students forward.
- **Offline Triggers**: `<div wire:offline>` status locks preventing crashes while shaky internet reconnects.

---

## Verification Plan

1. **Attempt verification**: Start test, leave active, re-open. Verify remaining duration DID NOT reset.
2. **Review checks**: Mark indexes, reload frame. Validate VISITED/MARKED lightbulb flags persist exactly on dashboard resume grids.
3. **Back-button verification**: Press back on the navigation bar. Validate the page keeps the student trapped in the continuous run loop safely.
