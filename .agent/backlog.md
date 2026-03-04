# Backlog & Sprints

## Phase 1: Test Form & Sections UI/UX (COMPLETED)
- [x] Implement `TestSectionManager` Livewire component
- [x] Implement `TestSectionRow` child component
- [x] Implement cascading dropdown logic in `TestSectionRow`
- [x] Create premium UI for `TestSectionManager` and `TestSectionRow`
- [x] Refactor `ExamsController@testSections` to use Livewire
- [x] Refactor `sections.blade.php` to host the Livewire component
- [x] Final manual verification of dynamic section addition/removal
- [x] Verification of batch saving across all sections
- [x] Debug "Link to Packages" in `TestForm.php`
- [x] Review Laravel logs for component errors
- [x] Fix `class_id` QueryException and subject hierarchy in TestSection components
- [x] Add loaders and notifications for test section actions
- [x] Document overall phase state for new agent in `.agent/current_work_status.md`

## Phase 2: Question Mapping (ACTIVE)
- [ ] Research `QuestionBankModel` selection patterns.
- [ ] Implement mapping for actual Questions to the `TestSections` (`QuestionBank` mapping via `Admin\Tests\TestTable` and `ExamsController`).
- [ ] Create UI for selecting/filtering questions based on Section criteria (Subject, Board, Class, Lesson/Topic).
- [ ] Implement batch mapping of multiple questions to a section.
- [ ] Add preview functionality for mapped questions within the `TestSections`.
- [ ] Verify interaction between `TestSections` and `TestQuestions` tables.

## Phase 3: Testing & Polish (UPCOMING)
- [ ] Unit/Feature tests for Test/Section/Question relationships.
- [ ] UI/UX final touch-ups (animations, accessibility).
- [ ] Verify Legacy compatibility.

## Phase 4: Question Bank Import Enhancement (COMPLETED)
- [x] Analyze Question Bank structure and import process.
- [x] Add categorization selectors (Education Type, Class, Subject, etc.) to `QuestionImport` Livewire component.
- [x] Implement cascading dropdowns in `question-import.blade.php`.
- [x] Modify `QuestionBankImport` logic to use UI-selected categories instead of excel columns.
- [x] Create a sample Excel format for easy client upload.

## Phase 5: Question Import Editable Preview Table (COMPLETED)
- [x] Refactor `QuestionBankImport.php` to return an array of parsed data instead of hitting DB.
- [x] Add `$previewData` and `$showPreview` state to `QuestionImport.php`.
- [x] Build the editable UI datatable in `question-import.blade.php`.
- [x] Implement the final `saveAll()` function to process the approved preview table.
