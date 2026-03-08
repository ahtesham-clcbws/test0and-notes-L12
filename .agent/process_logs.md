# Process Logs

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
