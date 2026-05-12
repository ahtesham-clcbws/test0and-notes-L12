<?php

use App\Models\TestModal;
use App\Models\TestSections;
use App\Models\QuestionBankModel;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$student_id = 449; // Gyanedh Kumar
$education_type = 53;
$class_id = 212; // SSC-CGL
$cat_id = 1;

$subjects = [
    ['id' => 29, 'name' => 'English Language', 'part' => 11],
    ['id' => 30, 'name' => 'Quantitative Aptitude', 'part' => 11],
    ['id' => 57, 'name' => 'General Intelligence & Reasoning', 'part' => 11],
    ['id' => 87, 'name' => 'General Awareness (History)', 'part' => 11]
];

function createTest($title, $sections_data, $edu_type, $class_id, $cat_id) {
    echo "Creating test: $title\n";
    
    $test = new TestModal();
    $test->title = $title;
    $test->education_type_id = $edu_type;
    $test->education_type_child_id = $class_id;
    $test->test_cat = $cat_id;
    $test->time_to_complete = count($sections_data) * 15;
    $test->marks = count($sections_data) * 50;
    $test->published = 1;
    $test->published_status = 1;
    $test->show_result = 1;
    $test->show_answer = 1;
    $test->test_type = 1;
    $test->sections = count($sections_data);
    $test->total_questions = count($sections_data) * 5;
    $test->questions_submitted = count($sections_data) * 5;
    $test->questions_approved = count($sections_data) * 5;
    $test->save();

    foreach ($sections_data as $sIndex => $sData) {
        $section = new TestSections();
        $section->test_id = $test->id;
        $section->section_index = $sIndex;
        $section->subject = $sData['id'];
        $section->subject_part = $sData['part'];
        $section->number_of_questions = 5;
        $section->duration = 15;
        $section->question_type = 0;
        $section->mcq_options = 4;
        $section->save();

        for ($i = 1; $i <= 5; $i++) {
            $q = new QuestionBankModel();
            $q->education_type_id = $edu_type;
            $q->class_group_exam_id = $class_id;
            $q->subject = $sData['id'];
            $q->question = "This is a sample question for {$sData['name']} in test {$title}. Question #{$i}";
            $q->mcq_options = 4;
            $q->ans_1 = "Option A for Q{$i}";
            $q->ans_2 = "Option B for Q{$i}";
            $q->ans_3 = "Option C for Q{$i}";
            $q->ans_4 = "Option D for Q{$i}";
            $q->mcq_answer = "ans_" . rand(1, 4);
            $q->status = 'approved';
            $q->save();

            DB::table('test_questions')->insert([
                'test_id' => $test->id,
                'question_id' => $q->id,
                'section_id' => $section->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    // Final force publish to bypass any race conditions in observers
    $test->published = 1;
    $test->saveQuietly();
}

for ($i = 1; $i <= 5; $i++) {
    $subj = $subjects[array_rand($subjects)];
    createTest("Mini Quiz: {$subj['name']} Part {$i}", [$subj], $education_type, $class_id, $cat_id);
}

for ($i = 1; $i <= 5; $i++) {
    $keys = array_rand($subjects, 2);
    $selected_subjs = [$subjects[$keys[0]], $subjects[$keys[1]]];
    createTest("Skill Builder: Mixed Sections Set {$i}", $selected_subjs, $education_type, $class_id, $cat_id);
}

for ($i = 1; $i <= 5; $i++) {
    createTest("Full Length Mock: SSC-CGL Standard Paper #{$i}", $subjects, $education_type, $class_id, $cat_id);
}

echo "Done!\n";
