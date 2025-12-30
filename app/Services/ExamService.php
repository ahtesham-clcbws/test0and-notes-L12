<?php

namespace App\Services;

use App\Models\TestModal;
use App\Models\TestSections;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExamService
{
    /**
     * Get paginated tests for administrator dashboard.
     *
     * @param array $params
     * @return array
     */
    public function getPaginatedTests(array $params): array
    {
        $start = $params['start'] ?? 0;
        $length = $params['length'] ?? 10;
        $searchValue = $params['search']['value'] ?? '';
        $testCat = $params['test_cat'] ?? '';
        $published = $params['published'] ?? '';

        $query = TestModal::select([
            'test.id as id', 
            'test.user_id',
            'title', 
            'sections', 
            'total_questions', 
            'questions_submitted', 
            'education_type_id',
            'test_cat', 
            'price',
            'test_type',
            'questions_approved', 
            'reviewed', 
            'reviewed_status', 
            'published',
            'test.created_at as created_at',
            'education_type_child_id',
            'published_status',
            'featured',
            'users.name as username',
            'franchise_details.institute_name as institute_name'
        ])
        ->leftJoin('users', 'users.id', '=', 'test.user_id')
        ->leftJoin('franchise_details', 'franchise_details.user_id', '=', 'users.id')
        ->with(['EducationClass', 'EducationType', 'getTestCat'])
        ->withCount(['getQuestions as confirmed_questions_count' => function ($query) {
            $query->whereNull('test_questions.deleted_at');
        }]);

        if (!empty($searchValue)) {
            $query->where("title", "like", "%" . $searchValue . "%");
        }

        if (!empty($testCat)) {
            $query->where('test_cat', $testCat);
        }

        if ($published !== '') {
            $publishId = ($published === 'true') ? 1 : 0;
            $query->where('published', $publishId);
        }

        $recordsTotal = TestModal::count();
        $recordsFiltered = $query->count();

        $tests = $query->orderBy('test.id', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $data = $tests->map(function ($test) {
            return $this->formatTestDataForTable($test);
        });

        return [
            "draw" => intval($params['draw'] ?? 0),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ];
    }

    /**
     * Format a single test model for the datatables.
     *
     * @param TestModal $test
     * @return array
     */
    protected function formatTestDataForTable($test): array
    {
        $questionSummary = $test->total_questions . ' / ' . $test->confirmed_questions_count;
        $status = $this->getTestStatusHtml($test);
        $featured = $this->getFeaturedButtonHtml($test);
        $sectionButtons = $this->getSectionButtonsHtml($test);

        return [
            'id' => $test->id,
            'title' => $test->title,
            'total_questions' => $questionSummary,
            'sections' => $sectionButtons,
            'status' => $status,
            'featured' => $featured,
            'created_by' => $test->institute_name ?? $test->username ?? 'Admin',
            'created_date' => $test->created_at ? $test->created_at->format('d-m-Y') : '',
            'class_name' => $test->EducationClass->name ?? '',
            'class_type' => $test->EducationType->name ?? '',
            'test_cat' => $test->getTestCat->cat_name ?? '',
            'test_type' => $test->test_type,
            'test_fees' => $test->price ?? '',
            'actions' => $this->getActionButtonsHtml($test)
        ];
    }

    /**
     * Generate HTML for test status badge.
     */
    protected function getTestStatusHtml($test): string
    {
        if ($test->total_questions == 0) {
            return '<span class="badge bg-warning text-dark">Awaiting Sections</span>';
        }

        if ($test->total_questions != $test->confirmed_questions_count) {
            return '<span class="badge bg-warning text-dark">Awaiting Questions</span>';
        }

        if ($test->published == 1) {
            return '<a href="'.route('administrator.dashboard_publish_test_exam', [$test->id]).'"><span class="badge bg-success">Published</span></a>';
        }

        if ($test->reviewed) {
            switch ($test->reviewed_status) {
                case 'approved': return '<span class="badge bg-success">Approved</span>';
                case 'rejected': return '<span class="badge bg-danger">Rejected</span>';
                case 'onhold':   return '<span class="badge bg-warning text-dark">Hold Review</span>';
            }
        }

        return '<a href="'.route('administrator.dashboard_publish_test_exam', [$test->id]).'"><span class="badge bg-primary">Publish Test</span></a>';
    }

    /**
     * Generate HTML for featured button.
     */
    protected function getFeaturedButtonHtml($test): string
    {
        if ($test->published != 1) return '';

        $class = ($test->featured == 1) ? 'btn-success' : 'btn-warning';
        $text = ($test->featured == 1) ? 'Featured' : 'UnFeatured';
        
        return '<button data-id="'.$test->id.'" class="btn btn-sm '.$class.'" onclick="handleTestFeature('.$test->id.')">'.$text.'</button>';
    }

    /**
     * Generate HTML for section icons/links.
     */
    protected function getSectionButtonsHtml($test): string
    {
        if (!$test->sections) return '0 Sections';

        $sections = TestSections::where('test_id', $test->id)->get();
        $html = '';

        foreach ($sections as $index => $section) {
            if ($section->subject && $section->subject_part && $section->subject_part_lesson && $section->number_of_questions) {
                $url = route('administrator.dashboard_test_section_question', [$test->id, $section->id]);
                $html .= '<a href="' . $url . '" title="Section ' . ($index + 1) . ' Questions"><i class="bi bi-journal-text text-primary me-2"></i></a>';
            } else {
                $html .= '<a href="javascript:void(0)" onclick="noSection()"><i class="bi bi-journal-text text-primary me-2"></i></a>';
            }
        }

        return $html ?: '0 Sections';
    }

    /**
     * Generate HTML for action buttons.
     */
    protected function getActionButtonsHtml($test): string
    {
        $editUrl = route('administrator.dashboard_update_test_exam', [$test->id]);
        return '<a href="' . $editUrl . '" title="Edit Test"><i class="bi bi-pencil-square text-success me-2"></i></a>
                <a href="javascript:void(0);" title="Delete Test"><i class="bi bi-trash2-fill text-danger me-2" onclick="deleteTest('.$test->id.')"></i></a>';
    }
}
