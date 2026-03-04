[x] Implement `TestSectionManager` Livewire component
[x] Implement `TestSectionRow` child component
[x] Implement cascading dropdown logic in `TestSectionRow`
[x] Create premium UI for `TestSectionManager` and `TestSectionRow`
[x] Refactor `ExamsController@testSections` to use Livewire
[x] Refactor `sections.blade.php` to host the Livewire component
[x] Final manual verification of dynamic section addition/removal
[x] Verification of batch saving across all sections
[x] Debug "Link to Packages" in `TestForm.php`
[x] Review Laravel logs for component errors
[x] Fix `class_id` QueryException and subject hierarchy in TestSection components
[x] Add loaders and notifications for test section actions
[x] Document overall phase state for new agent in `.agent/current_work_status.md`

**Phase 2: Question Mapping & Migration Finetuning (COMPLETED)**
[x] Move Package Selection from `TestForm` to a new `PublishTest` Livewire Component.
[x] Implement validation in `TestSectionManager` and `TestSectionRow` to dynamically limit `number_of_questions` so that combined questions do not exceed `TestModal::total_questions`.
[x] Create `TestQuestionsManager` Livewire Component to map Question Bank questions to a Test Section.
[x] Add UI strict validation in `TestQuestionsManager` so exactly `Section::number_of_questions` are selectable and duplicates within a same section are prevented.
[x] Update relevant Routes to point to new Livewire components instead of Legacy Controllers.
