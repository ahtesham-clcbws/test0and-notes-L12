<?php

namespace App\Livewire\Student\Exams;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Attempted extends Component
{
    use \Livewire\WithPagination;

    public string $search = '';
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    #[Layout('components.layouts.student-mary')]
    public function render()
    {
        $attempts = \App\Models\Gn_StudentTestAttempt::query()
            ->with(['test.EducationClass', 'test.institude'])
            ->where('student_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->whereHas('test', function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'test.title', 'label' => 'Test Name'],
            ['key' => 'test.EducationClass.name', 'label' => 'Class / Group'],
            ['key' => 'created_at', 'label' => 'Attempted On'],
            ['key' => 'test_type', 'label' => 'Type'],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];

        return view('livewire.student.exams.attempted', [
            'attempts' => $attempts,
            'headers' => $headers,
        ]);
    }
}
