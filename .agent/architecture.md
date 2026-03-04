# Architecture Overview

## Technology Stack
- **Framework:** Laravel 12.51.0
- **Language:** PHP 8.4.16
- **Frontend Framework:** Livewire 3.7.10
- **UI/Admin:** Filament 4.7.1
- **Styling:** TailwindCSS 4.1.18
- **Database:** MariaDB
- **Tools:** Laravel Boost (MCP), Laravel Pail, Laravel Pint, PHPUnit 11

## Core Modules & Data Flow

### 1. Test Creation & Management
- **Models:** `TestModal`, `TestSections`
- **Logic:** `TestForm` (Livewire) handles the high-level test metadata (Total Questions, Number of Sections). `TestSectionManager` (Livewire) orchestrates multiple `TestSectionRow` child components to manage per-section settings.
- **Cascading Logic:** Subject selections cascade: `subject_id` -> `part_id` -> `chapter_id` -> `lesson_id` (representing the 4th level "Topic/Lesson").

### 2. Question Bank
- **Model:** `QuestionBankModel`
- **Mapping:** Questions will be mapped to `TestSections` via a mapping layer (likely `TestTable` or `ExamsController` logic).

### 3. Subject Hierarchy
- Uses legacy naming conventions like `Gn_ClassSubject`, `Gn_SubjectPartLessionNew`, etc.
- Logic is centralized in `TestSectionRow` for cascading dropdowns.

## Directory Structure Highlights
- `/app/Livewire/Admin/Tests/`: Contains the core logic for the new Test Creation UI.
- `/app/Models/`: Contains a mix of legacy and newer Eloquent models.
- `/.agent/`: Persists workspace state and logic maps.
