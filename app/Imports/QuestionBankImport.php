<?php

namespace App\Imports;

use App\Models\BoardAgencyStateModel;
use App\Models\ClassGoupExamModel;
use App\Models\Educationtype;
use App\Models\QuestionBankModel;
use App\Models\Subject;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class QuestionBankImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */

    // public function startRow(): int
    // {
    //     return 2;
    // }

    protected $filePath;

    public function __construct($filePath = null)
    {
        $this->filePath = $filePath ?? request()->file('question');
    }

    public function collection(Collection $rows)
    {
        $spreadsheet = IOFactory::load($this->filePath);
        $images = [];
        foreach ($rows as $key => $row) {
            $images[] = $key;
        }
        // dd($images);
        // dd($rows[0]->getPath());
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            /** @var \PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing $drawing */
            $key = str_replace('I', '', $drawing->getCoordinates());
            $extension = 'png'; // Default
            $imageContents = '';

            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else {
                /** @var Drawing $drawing */
                $zipReader = fopen($drawing->getPath(), 'r');
                while (! feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = pathinfo($drawing->getPath(), PATHINFO_EXTENSION);
            }
            $myFileName = Str::uuid()->toString().'.'.$extension;
            file_put_contents('storage/app/public/questionImage/'.$myFileName, $imageContents);
            $images[$key - 2] = $myFileName;
        }
        // dd($images);
        foreach ($rows as $key => $row) {
            // dd($row->getDrawingCollection());
            QuestionBankModel::create(
                [
                    'education_type_id' => Educationtype::where('name', 'like', '%'.$row['education_type_id'].'%')->orWhere('id', $row['education_type_id'])->first()->id ?? null,
                    'class_group_exam_id' => ClassGoupExamModel::where('name', 'like', '%'.$row['class_group_exam_id'].'%')->orWhere('id', $row['class_group_exam_id'])->first()->id ?? null,
                    'board_agency_state_id' => BoardAgencyStateModel::where('name', 'like', '%'.$row['board_agency_state_id'].'%')->orWhere('id', $row['board_agency_state_id'])->first()->id ?? null,
                    'subject' => Subject::where('name', 'like', '%'.$row['subject'].'%')->orWhere('id', $row['subject'])->first()->id ?? null,
                    'subject_part' => SubjectPart::where('name', 'like', '%'.$row['subject_part'].'%')->orWhere('id', $row['subject_part'])->first()->id ?? null,
                    'subject_lesson_chapter' => SubjectPartLesson::where('name', 'like', '%'.$row['subject_lesson_chapter'].'%')->orWhere('id', $row['subject_lesson_chapter'])->first()->id ?? null,
                    'question_type' => $row['question_type'] == 'MCQ' ? '1' : '2',
                    'mcq_options' => $row['mcq_options'],
                    'question' => $images[$key] != $key ? '<img src="'.'/storage/questionImage/'.
$images[$key].'" />'.'<p>'.$row['question'].'</p>' : $row['question'],
                    'solution' => $row['solution'],
                    'explanation' => $row['explanation'],
                    'ans_1' => $row['ans_1'],
                    'ans_2' => $row['ans_2'],
                    'ans_3' => $row['ans_3'],
                    'ans_4' => $row['ans_4'],
                    'ans_5' => $row['ans_5'],
                    'mcq_answer' => $row['mcq_answer'],
                    'alloted_for_check_id' => $row['alloted_for_check_id'],
                    'creator_id' => User::where('name', 'like', '%'.$row['creator_id'].'%')->orWhere('id', $row['creator_id'])->first()->id ?? null,
                    'status' => $row['status'],
                    'checked_by_id' => $row['checked_by_id'],
                    'checker_comments' => $row['checker_comments'],
                ]
            );
        }
    }
}
