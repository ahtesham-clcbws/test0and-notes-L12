<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionBankImport;
use App\Models\Educationtype;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuestionBankController extends Controller
{
    protected $req;

    protected $data;

    public function __construct(Request $req)
    {
        $this->data = [];

        // $this->data['classes'] = ClassGoupExamModel::get();
        $this->data['educations'] = Educationtype::get();
        // $this->data['boards'] = BoardAgencyStateModel::get();
        // $this->data['others'] = OtherCategoryClass::get();
        $this->data['pagename'] = 'Question Bank';
        $this->data['test_sections'] = ['1', '2', '3', '4', '5'];
        $this->data['difficulty_level'] = ['25', '35', '40', '50', '60', '70', '75', '80', '90', '100'];
        $this->req = $req;
    }

    public function index($type = 'all')
    {
        $this->data['pagename'] = 'Questions';

        return view('Dashboard.Admin.QuestionBank.index')->with('data', $this->data);
    }

    public function add_update($id = 0)
    {
        $this->data['id'] = $id;
        if ($id > 0) {
            $this->data['pagename'] = 'Update Question';
        } else {
            $this->data['pagename'] = 'Add Question';
        }

        return view('Dashboard.Admin.QuestionBank.add_update')->with('data', $this->data);
    }

    public function show($id)
    {
        return view('Dashboard/Admin/QuestionBank/show')->with('data', $this->data);
    }

    public function importView()
    {
        return view('Dashboard/Admin/QuestionBank/import');
    }

    public function import()
    {
        Excel::import(new QuestionBankImport, request()->file('question'));

        return back();
    }
}
