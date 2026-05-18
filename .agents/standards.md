# Workspace Standards

## Naming Conventions
- **Livewire Components:** PascalCase (e.g., `TestSectionManager.php`). Parent-child relationships should reflect in directory structure.
- **Models/Legacy:** Standard CamelCase (`TestSections.php`), some use legacy naming conventions like `Gn_ClassSubject.php`.

## Coding Standards
- **Livewire 3 Syntax:** Use `$this->dispatch()` for events instead of `$this->emit()`.
- **Validation:** Always use Form Requests or internal validate methods in Livewire components for complex logic.
- **Cascading Dropdowns:** Centralize subject cascading/filtering logic in the respective child row components to keep the manager logic clean.
- **UI Interactivity:** Use `wire:loading` and Alpine.js for interactive feedback (spinners, notifications).
- **Styling:** Follow the existing Tailwind integration patterns. Avoid ad-hoc utility classes that break the existing theme.

## Architecture Guidelines
- **Parent-Child Sync:** Use Livewire events or reactive properties to sync state between `TestSectionManager` and `TestSectionRow`.
- **Automatic Sectioning:** `TestForm` is the source of truth for the `no_of_sections`. All CRUD operations for sections should be derived from this value.
