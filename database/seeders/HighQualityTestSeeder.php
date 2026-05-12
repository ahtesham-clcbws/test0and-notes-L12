<?php

namespace Database\Seeders;

use App\Models\TestModal;
use App\Models\TestSections;
use App\Models\Subject;
use App\Models\SubjectPart;
use App\Models\QuestionBankModel;
use App\Models\TestQuestions;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighQualityTestSeeder extends Seeder
{
    public function run()
    {
        $studentEmail = 'gyanesh@kumar.com';
        $user = User::where('email', $studentEmail)->first();

        if (!$user) {
            echo "Target student not found. Skipping seeder.\n";
            return;
        }

        $userDetails = UserDetails::where('user_id', $user->id)->first();
        $eduTypeId = $userDetails->education_type;
        $eduChildId = $userDetails->class;

        $englishPassage = "The relentless acceleration of technological advancement, while ostensibly liberating, has engendered a profound ontological insecurity within modern society. We find ourselves in an epoch where the velocity of innovation has outstripped our cognitive and ethical capacities to assimilate its implications. The digital panopticon, constructed under the guise of convenience and connectivity, has fundamentally altered the architecture of human autonomy. Algorithms, once conceived as neutral tools of optimization, now function as architects of preference, subtly colonizing the inner landscape of individual choice.";

        $templates = [
            'English' => [
                'name' => 'English Comprehension',
                'qs' => [
                    [
                        'q' => $englishPassage . "<br><br><b>Which statement best captures the 'digital panopticon' concept?</b>",
                        'a1' => 'It represents a subtle, insidious erosion of personal autonomy, where the convenience of technological integration masks the manipulative nature of algorithmic control.',
                        'a2' => 'It is a necessary infrastructure that offers the only viable path to achieving global connectivity in modern bureaucratic processes.',
                        'a3' => 'It functions primarily as a protective mechanism designed to filter excessive information effectively.',
                        'a4' => 'It is an unintended byproduct of rapid innovation that serves as a neutral framework for societal organization.',
                        'ans' => 'ans_1'
                    ]
                ]
            ],
            'Quant' => [
                'name' => 'Quantitative Aptitude',
                'qs' => [
                    [
                        'q' => "A corporation invested Rs. 15,00,000 at 12% p.a. compounded semi-annually for 1.5 years. If the interest is lost in a failed venture, what is the remaining capital?",
                        'a1' => 'The remaining principal remains unchanged at Rs. 15,00,000 as the yield was specifically isolated.',
                        'a2' => 'The final amount is calculated by applying the semi-annual compounding formula resulting in net gain.',
                        'a3' => 'The amount is determined by subtracting the total interest earned during the 18-month period.',
                        'a4' => 'The remaining figure accounts for a 2% administrative fee deducted by the managers.',
                        'ans' => 'ans_1'
                    ]
                ]
            ]
        ];

        $testTypes = [
            ['title' => 'PRODUCTION: SSC CGL Ultra Mock #01', 'cat' => 'Original Test'],
            ['title' => 'PRODUCTION: Elite Scholar Program #15', 'cat' => 'New Test'],
        ];

        foreach ($testTypes as $tt) {
            $test = TestModal::create([
                'title' => $tt['title'],
                'test_cat' => DB::table('test_cat')->where('cat_name', $tt['cat'])->value('id') ?? 1,
                'duration' => 60,
                'education_type_id' => $eduTypeId,
                'education_type_child_id' => $eduChildId,
                'sections' => 4,
                'total_questions' => 100,
                'published' => 0,
                'published_status' => 'published',
                'reviewed' => 1,
                'reviewed_status' => 'approved',
                'show_result' => 1,
                'marks_per_question' => 2,
                'negative_marks' => 0.5,
                'status' => 'active',
            ]);

            $sectionNames = [
                'English Comprehension' => 'English',
                'Quantitative Aptitude' => 'Quant',
                'General Intelligence' => 'Reasoning',
                'General Awareness' => 'GA'
            ];

            $idx = 1;
            foreach ($sectionNames as $fullName => $shortName) {
                $baseSubject = Subject::firstOrCreate(['name' => 'General Syllabus']);
                $subjectPart = SubjectPart::firstOrCreate([
                    'name' => $fullName,
                    'classes_group_exams_id' => $eduChildId,
                    'subject_id' => $baseSubject->id
                ]);

                $section = TestSections::create([
                    'test_id' => $test->id,
                    'subject' => $baseSubject->id,
                    'subject_part' => $subjectPart->id,
                    'section_index' => $idx++,
                    'number_of_questions' => 25,
                    'mcq_options' => 4,
                    'difficulty_level' => 3,
                    'is_published' => 1,
                ]);

                $pool = $templates[$shortName]['qs'] ?? $templates['English']['qs'];

                for ($i = 0; $i < 25; $i++) {
                    $t = $pool[$i % count($pool)];
                    $qb = QuestionBankModel::create([
                        'education_type_id' => $eduTypeId,
                        'class_group_exam_id' => $eduChildId,
                        'subject' => $baseSubject->id,
                        'subject_part' => $subjectPart->id,
                        'question' => $t['q'] . " (ID: ".($i+100).")",
                        'ans_1' => $t['a1'],
                        'ans_2' => $t['a2'],
                        'ans_3' => $t['a3'],
                        'ans_4' => $t['a4'],
                        'mcq_options' => 4,
                        'mcq_answer' => $t['ans'],
                        'status' => 'approved',
                        'question_type' => 1,
                    ]);

                    TestQuestions::create([
                        'test_id' => $test->id,
                        'section_id' => $section->id,
                        'question_id' => $qb->id,
                    ]);
                }
            }

            $test->published = 1;
            $test->saveQuietly();
            echo "Seeded Test: " . $test->title . "\n";
        }
    }
}
