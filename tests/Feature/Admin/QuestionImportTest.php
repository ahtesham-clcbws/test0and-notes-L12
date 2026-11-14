<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Questions\QuestionImport;
use App\Models\QuestionBankModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class QuestionImportTest extends TestCase
{
    use DatabaseTransactions;

    public function test_question_import_can_insert_sample_format(): void
    {
        Livewire::test(QuestionImport::class)
            ->call('insertSampleFormat')
            ->assertSet('pastedText', function ($val) {
                return str_contains($val, 'What is the capital of France?') &&
                       str_contains($val, 'What is the powerhouse of the cell?');
            });
    }

    public function test_question_import_parses_formatted_pasted_text_into_preview(): void
    {
        $rawText = "1. Which gas do plants absorb from the atmosphere?\nA) Oxygen\nB) Carbon Dioxide\nC) Nitrogen\nD) Hydrogen\nCorrect Answer: (B)\nExplanation: Photosynthesis uses carbon dioxide.\n\n2. How many continents are there on Earth?\nA) 5\nB) 6\nC) 7\nD) 8\nAnswer: C";

        Livewire::test(QuestionImport::class)
            ->set('education_type_id', 1)
            ->set('class_id', 1)
            ->set('subject_id', 1)
            ->set('question_type', 1)
            ->set('pastedText', $rawText)
            ->call('parsePastedText')
            ->assertSet('showPreview', true)
            ->assertCount('previewData', 2)
            ->assertSet('previewData.0.question', 'Which gas do plants absorb from the atmosphere?')
            ->assertSet('previewData.0.mcq_answer', 'ans_2')
            ->assertSet('previewData.0.ans_1', 'Oxygen')
            ->assertSet('previewData.0.ans_2', 'Carbon Dioxide')
            ->assertSet('previewData.1.question', 'How many continents are there on Earth?')
            ->assertSet('previewData.1.mcq_answer', 'ans_3');
    }

    public function test_question_import_save_all_persists_questions_to_database(): void
    {
        $admin = User::first() ?? User::factory()->create();
        $this->actingAs($admin);

        $initialCount = QuestionBankModel::count();

        $rawText = "1. Test Question Sample?\nA) Alpha\nB) Beta\nC) Gamma\nD) Delta\nCorrect Answer: (A)";

        Livewire::test(QuestionImport::class)
            ->set('education_type_id', 1)
            ->set('class_id', 1)
            ->set('subject_id', 1)
            ->set('question_type', 1)
            ->set('pastedText', $rawText)
            ->call('parsePastedText')
            ->call('saveAll');

        $this->assertEquals($initialCount + 1, QuestionBankModel::count());

        $latest = QuestionBankModel::latest('id')->first();
        $this->assertEquals('Test Question Sample?', $latest->question);
        $this->assertEquals('ans_1', $latest->mcq_answer);
        $this->assertEquals('Alpha', $latest->ans_1);
        $this->assertEquals('approved', $latest->status);
    }
}
