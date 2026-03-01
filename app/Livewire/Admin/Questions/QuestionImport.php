<?php

namespace App\Livewire\Admin\Questions;

use App\Imports\QuestionBankImport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('Layouts.admin')]
class QuestionImport extends Component
{
    use WithFileUploads;

    public $file;

    public $isImporting = false;

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        $this->isImporting = true;

        try {
            Excel::import(new QuestionBankImport($this->file->getRealPath()), $this->file->getRealPath());

            session()->flash('success', 'Questions successfully integrated into architectural bank.');

            return redirect()->route('administrator.dashboard_question_list');
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Structural failure during import: '.$e->getMessage()]);
        } finally {
            $this->isImporting = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.questions.question-import', [
            'data' => ['pagename' => 'Import Questions'],
        ]);
    }
}
