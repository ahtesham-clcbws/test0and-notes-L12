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
use Illuminate\Support\Facades\Auth;
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
    protected $importData;
    public $parsedData = [];

    public function __construct($filePath = null, $importData = [])
    {
        $this->filePath = $filePath ?? request()->file('question');
        $this->importData = $importData;
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
            $this->parsedData[] = [
                'education_type_id' => $this->importData['education_type_id'] ?? null,
                'class_group_exam_id' => $this->importData['class_group_exam_id'] ?? null,
                'board_agency_state_id' => $this->importData['board_agency_state_id'] ?? null,
                'subject' => $this->importData['subject'] ?? null,
                'subject_part' => $this->importData['subject_part'] ?? null,
                'subject_lesson_chapter' => $this->importData['subject_lesson_chapter'] ?? null,
                'question_type' => $this->importData['question_type'] ?? ($row['question_type'] == 'MCQ' ? '1' : '2'),
                'mcq_options' => $row['mcq_options'] ?? 4,
                'question' => isset($images[$key]) && $images[$key] != $key ? '<img src="'.'/storage/questionImage/'.$images[$key].'" />'.'<p>'.($row['question'] ?? '').'</p>' : ($row['question'] ?? ''),
                'solution' => $row['solution'] ?? null,
                'explanation' => $row['explanation'] ?? null,
                'ans_1' => $row['ans_1'] ?? null,
                'ans_2' => $row['ans_2'] ?? null,
                'ans_3' => $row['ans_3'] ?? null,
                'ans_4' => $row['ans_4'] ?? null,
                'ans_5' => $row['ans_5'] ?? null,
                'mcq_answer' => $row['mcq_answer'] ?? null,
                'alloted_for_check_id' => $row['alloted_for_check_id'] ?? null,
                'creator_id' => isset($row['creator_id']) ? (User::where('name', 'like', '%'.$row['creator_id'].'%')->orWhere('id', $row['creator_id'])->first()?->id ?? Auth::id() ?? null) : (Auth::id() ?? null),
                'status' => $row['status'] ?? 'pending',
                'checked_by_id' => $row['checked_by_id'] ?? null,
                'checker_comments' => $row['checker_comments'] ?? null,
            ];
        }
    }
}
