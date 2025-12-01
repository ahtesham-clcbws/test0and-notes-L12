<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BooksModel;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $data;
    protected $req;

    public function __construct(Request $request)
    {
        $this->data = array();
        $this->req = $request;
    }

    public function index()
    {
        return view('Dashboard/Admin/Books/index')->with('data', $this->data);
    }
    public function save($id = 0)
    {
        $booksDb = new BooksModel();
        if ($id > 0) {
            $booksDb = BooksModel::find($id);
        }
        if ($this->req->isMethod('post')) {
        }

        $this->data['book'] = $booksDb;
        return view('Dashboard/Admin/Books/addbook')->with('data', $this->data);
    }
    public function view($id)
    {
        return view('Dashboard/Admin/Books/viewbook')->with('data', $this->data);
    }
    public function delete($id)
    {
        // return view('Dashboard/Admin/Books/index')->with('data', $this->data);
    }
}
