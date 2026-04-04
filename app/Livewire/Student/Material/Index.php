<?php

namespace App\Livewire\Student\Material;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use \Livewire\WithPagination;

    public string $search = '';
    public string $category = 'Study Notes & E-Books'; // Default
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    #[Layout('components.layouts.student-mary')]
    public function mount(): void
    {
        $this->category = match (Route::currentRouteName()) {
            'student.showvideo' => 'Live & Video Classes',
            'student.showgk' => 'Static GK & Current Affairs',
            'student.showComprehensive' => 'Comprehensive Study Material',
            'student.showShortNotes' => 'Short Notes & One Liner',
            'student.showPremium' => 'Premium Study Notes',
            default => 'Study Notes & E-Books'
        };
    }
    public function render()
    {
        $stud_id = Auth::id();
        $userDetails = \App\Models\UserDetails::where('user_id', $stud_id)->first();

        if (! $userDetails) {
            return view('livewire.student.material.index', [
                'materials' => collect(),
                'headers' => [],
            ]);
        }

        $materials = \App\Models\Studymaterial::query()
            ->leftJoin('classes_groups_exams', 'study_material.class', 'classes_groups_exams.id')
            ->select('study_material.*', 'classes_groups_exams.name as class_group')
            ->where('study_material.status', 1)
            ->where('study_material.material_seen', 1)
            ->where('study_material.category', $this->category)
            ->where('study_material.education_type', $userDetails->education_type)
            // ->where('study_material.class', $userDetails->class) // Optional, some system layouts are different
            ->whereIn('study_material.institute_id', [Auth::user()->myInstitute?->id, 0])
            ->when($this->search, function ($query) {
                $query->where('study_material.title', 'like', '%'.$this->search.'%')
                      ->orWhere('study_material.sub_title', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'title', 'label' => 'Title'],
            ['key' => 'class_group', 'label' => 'Class / Exam'],
            ['key' => 'document_type', 'label' => 'Format'],
            ['key' => 'publish_date', 'label' => 'Date'],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];

        return view('livewire.student.material.index', [
            'materials' => $materials,
            'headers' => $headers,
        ]);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
}
