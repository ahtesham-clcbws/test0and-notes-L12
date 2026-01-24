<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\Studymaterial;
use App\Models\Educationtype;
use App\Models\UserDetails;
use App\Models\FranchiseDetails;
use App\Http\Requests\StoreStudymaterialRequest;
use App\Http\Requests\UpdateStudymaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Facades\DataTables;

class StudymaterialController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = array();
        $this->data['pagename'] = 'Add Study Material';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_admin = $is_franchies = $is_staff = '';
        if (Auth::user()->roles == 'superadmin')
            $is_admin = Auth::user()->isAdminAllowed;
        if (Auth::user()->roles == 'franchise')
            $is_franchies = Auth::user()->is_franchise;
        if (Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher')
            $is_staff = Auth::user()->is_staff;


        if ($request->ajax()) {
            $published = isset($request->published) ? $request->published : '';
            $study_material_cat = isset($request->study_material_cat) ? $request->study_material_cat : '';

            $model = Studymaterial::query()
                ->select("study_material.id", "title", "sub_title", "is_featured", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "category", "users.name as name", "classes_groups_exams.name as class_group")
                ->withRelations();

            if ($is_franchies == 1) {
                $model = $model->where("franchise_details.id", Auth::user()->institute->id);
            }
            if ($is_staff == 1) {
                $model = $model->where("franchise_details.id", Auth::user()->myInstitute->id);
                $model = $model->where("users.id", Auth::user()->id);
            }

            if (!empty($published)) {
                $model = $model->where('publish_status', $published);
            }

            if (!empty($study_material_cat)) {
                $model = $model->byCategory($study_material_cat);
            }

            $model = $model->where("study_material.status", 1)
                ->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::eloquent(new EloquentDataTable($model))
                ->smart(true)
                // ->addIndexColumn()
                ->setRowId('id')
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('is_featured', function ($model) {
                    if ($model['is_featured']) {
                        $test_data = '<a href="' . 'material/is_featured/' . $model['id'] . '/0' . '" class="btn btn-sm btn-warning">UnFeatured</a>';
                    } else {
                        $test_data = '<a href="' . 'material/is_featured/' . $model['id'] . '/1' . '" class="btn btn-sm btn-primary" >Featured</a>';
                    }
                    return $test_data;
                })
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    $is_admin = $is_franchies = $is_staff = '';
                    if (Auth::user()->roles == 'superadmin')
                        $is_admin = Auth::user()->isAdminAllowed;
                    if (Auth::user()->roles == 'franchise')
                        $is_franchies = Auth::user()->is_franchise;
                    if (Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher')
                        $is_staff = Auth::user()->is_staff;
                    if ($is_admin == 1) {
                        return $model['name'];
                    }
                    if ($is_franchies == 1) {
                        return $model['name'] . ' (' . Auth::user()->institute['institute_name'] . ')';
                    }
                    if ($is_staff == 1) {
                        return $model['name'] . ' (' . Auth::user()->myInstitute->institute_name . ')';
                    }
                })
                ->addColumn('category', '{{ $category }}')
                ->addColumn('view', function ($model) {
                    $is_admin = $is_franchies = $is_staff = '';
                    if (Auth::user()->roles == 'superadmin')
                        $is_admin = Auth::user()->isAdminAllowed;
                    if (Auth::user()->roles == 'franchise')
                        $is_franchies = Auth::user()->is_franchise;
                    if (Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher')
                        $is_staff = Auth::user()->is_staff;
                    if ($is_admin == 1) {
                        return $viewHtml = '<a href="' . route('administrator.edit', [$model['id']]) . '" class="btn btn-info btn-sm" title="View Study Material!">View</a>';
                    }
                    if ($is_franchies == 1) {
                        return $viewHtml = '<a href="' . route('franchise.management.edit', [$model['id']]) . '" class="btn btn-info btn-sm" title="View Study Material!">View</a>';
                    }
                    if ($is_staff == 1 && Auth::user()->roles == 'publisher') {
                        return $viewHtml = '<a href="' . route('franchise.management.publisher.edit', [$model['id']]) . '" class="btn btn-info btn-sm" title="View Study Material!">View</a>';
                    }
                    if ($is_staff == 1 && Auth::user()->roles == 'creator') {
                        return $viewHtml = '<a href="' . route('franchise.management.creater.edit', [$model['id']]) . '" class="btn btn-info btn-sm" title="View Study Material!">View</a>';
                    }
                })
                ->addColumn('status', function ($model) {
                    if ($model['publish_status'] == 'Submit')
                        return '<label class="btn btn-sm btn-primary">' . $model['publish_status'] . '</label>';
                    if ($model['publish_status'] == 'Published')
                        return '<label class="btn btn-sm btn-success">' . $model['publish_status'] . '</label>';
                    if ($model['publish_status'] == 'Paused')
                        return '<label class="btn btn-sm btn-danger">' . $model['publish_status'] . '</label>';
                    if ($model['publish_status'] == 'Paused & Send Back')
                        return '<label class="btn btn-sm btn-danger">' . $model['publish_status'] . '</label>';
                })
                ->addColumn('edit', function ($model) {
                    $is_admin = $is_franchies = $is_staff = '';
                    if (Auth::user()->roles == 'superadmin')
                        $is_admin = Auth::user()->isAdminAllowed;
                    if (Auth::user()->roles == 'franchise')
                        $is_franchies = Auth::user()->is_franchise;
                    if (Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher')
                        $is_staff = Auth::user()->is_staff;
                    if ($is_admin == 1) {
                        return $actionsHtml = '<a href="' . route('administrator.edit', [$model['id']]) . '" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>
                    <a href="javascript:void(0);" class="delete_material" id=' . $model['id'] . ' data=' . $model['file'] . ' title="Delete Study Material!"><i class="bi bi-trash2-fill text-danger me-2"></i></a>';
                    }
                    if ($is_franchies == 1) {
                        return $actionsHtml = '<a href="' . route('franchise.management.edit', [$model['id']]) . '" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>';
                    }
                    if ($is_staff == 1 && Auth::user()->roles == 'publisher') {
                        return $actionsHtml = '<a href="' . route('franchise.management.publisher.edit', [$model['id']]) . '" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>';
                    }
                    if ($is_staff == 1 && Auth::user()->roles == 'creator') {
                        return $actionsHtml = '<a href="' . route('franchise.management.creater.edit', [$model['id']]) . '" title="Edit Study Material!"><i class="bi bi-pencil-square text-success me-2"></i></a>';
                    }
                })
                ->rawColumns(['is_featured', 'availability', 'status', 'view', 'edit'])
                ->make(true);
        }

        if ($is_admin == 1)
            return view("Dashboard/Admin/Material/materialtable", compact('is_admin', 'is_franchies', 'is_staff'));

        if ($is_franchies == 1) {
            $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $FranchiseDetails->submit_content;
            $publish_content = $FranchiseDetails->allowed_to_upload;
            return view("Dashboard/Franchise/Material/materialtable", compact('is_franchies', 'submit_content', 'publish_content'));
        }
        if ($is_staff == 1 && Auth::user()->roles == 'publisher') {

            $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $UserDetails->submit_content;
            $publish_content = $UserDetails->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Publisher/Material/materialtable", compact('is_staff', 'submit_content', 'publish_content'));
        }
        if ($is_staff == 1 && Auth::user()->roles == 'creator') {

            $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $UserDetails->submit_content;
            $publish_content = $UserDetails->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Creater/Material/materialtable", compact('is_staff', 'submit_content', 'publish_content'));
        }
    }

    public function adminIndex(Request $request)
    {
        $published = isset($request->published) ? $request->published : '';
        $study_material_cat = isset($request->study_material_cat) ? $request->study_material_cat : '';

        $query = Studymaterial::select("id", "title", "sub_title", "is_featured", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "category", "class")
            ->with('created_by_user:id,name', 'study_class:id,name', 'institute');

        if (!empty($published)) {
            $query =  $query->where('publish_status', $published);
            $count = $query->count();
        }
        if (!empty($study_material_cat)) {
            if ($study_material_cat == 1) {
                $query =  $query->where('category', 'Study Notes & E-Books');
            }
            if ($study_material_cat == 2) {
                $query =  $query->where('category', 'Live & Video Classes');
            }
            if ($study_material_cat == 3) {
                $query =  $query->where('category', 'Static GK & Current Affairs');
            }
            if ($study_material_cat == 4) {
                $query =  $query->where('category', 'Comprehensive Study Material');
            }
            if ($study_material_cat == 5) {
                $query =  $query->where('category', 'Short Notes & One Liner');
            }
            if ($study_material_cat == 6) {
                $query =  $query->where('category', 'Premium Study Notes');
            }
            $count = $query->count();
        }

        $query = $query->where("status", 1);
        $query = $query->orderBy('id', 'desc');

        $model = $query->get();
        // return print_r($model->toArray());

        return view("Dashboard/Admin/Material/materialtable_admin", compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gn_EduTypes      = Educationtype::get();
        $is_admin = $is_franchies = $is_staff = '';
        if (Auth::user()->roles == 'superadmin')
            return view("Dashboard/Admin/Material/add_edit_material", compact('gn_EduTypes'));
        if (Auth::user()->roles == 'franchise')
            return view("Dashboard/Franchise/Material/add_edit_material", compact('gn_EduTypes'));
        if (Auth::user()->roles == 'publisher') {
            $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $UserDetails->submit_content;
            $publish_content = $UserDetails->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Publisher/Material/add_edit_material", compact('gn_EduTypes', 'submit_content', 'publish_content'));
        }
        if (Auth::user()->roles == 'creator') {
            $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $UserDetails->submit_content;
            $publish_content = $UserDetails->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Creater/Material/add_edit_material", compact('gn_EduTypes', 'submit_content', 'publish_content'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudymaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //code...
            // return "test";
            $data = $request->all();

            if ($data['material_id'] != 0) {
                $Studymaterial = Studymaterial::get()->where('id', $data['material_id'])->first();
            }

            $is_admin = $is_franchies = '';
            if (Auth::user()->roles == 'superadmin') {
                $is_admin = Auth::user()->isAdminAllowed;
                if ($is_admin == 1) {
                    $institute = 0;
                    $publish_by = Auth::user()->id;
                }
            }
            if (Auth::user()->roles == 'franchise') {
                $is_franchies = Auth::user()->is_franchise;
                if ($is_franchies == 1) {
                    $institute = Auth::user()->institute->id;
                    $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($FranchiseDetails->allowed_to_upload == 1)
                        $publish_by = Auth::user()->id;
                    else
                if (isset($Studymaterial->publish_by) != 0)
                        $publish_by = $Studymaterial->publish_by;
                    else
                        $publish_by = 0;
                }
            }

            if (Auth::user()->roles == 'creator' || Auth::user()->roles == 'publisher') {
                $is_staff = Auth::user()->is_staff;
                if ($is_staff == 1) {
                    $institute = Auth::user()->myInstitute->id;
                    $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($UserDetails->allowed_to_upload == 1)
                        $publish_by = Auth::user()->id;
                    else
                    if (isset($Studymaterial->publish_by) != 0)
                        $publish_by = $Studymaterial->publish_by;
                    else
                        $publish_by = 0;
                }
            }

            if ($data['publish_date'] == date("Y-m-d")) {
                if (Auth::user()->allowed_to_upload == 1)
                    $publish_status = 'Published';
                else
                if ($is_admin == 1)
                    $publish_status = 'Published';
                elseif ($is_franchies == 1) {
                    $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($FranchiseDetails->allowed_to_upload == 1)
                        $publish_status = 'Published';
                    else
                        if (isset($Studymaterial->publish_by) != 0)
                        $publish_status = $Studymaterial->publish_status;
                    else
                        $publish_status = 'Submit';
                } elseif ($is_staff == 1) {
                    $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($UserDetails->allowed_to_upload == 1) {
                        $publish_status = 'Published';
                    } else {
                        if (isset($Studymaterial->publish_by) != 0) {
                            if ($Studymaterial->publish_by == 'Paused & Send Back')
                                $publish_status = $Studymaterial->publish_status;
                            else
                                $publish_status = 'Submit';
                        } else {
                            $publish_status = 'Submit';
                        }
                    }
                } else {
                    $publish_status = 'Submit';
                }
            } else {
                // $material = Studymaterial::get()->where('id',$data['material_id'])->first();
                if ($is_admin == 1) {
                    $publish_status = 'Published';
                } elseif ($is_franchies == 1) {
                    $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($FranchiseDetails->allowed_to_upload == 1)
                        $publish_status = 'Published';
                    else
                        if (isset($Studymaterial->publish_by) != 0)
                        $publish_status = $Studymaterial->publish_status;
                    else
                        $publish_status = 'Submit';
                } elseif ($is_staff == 1) {
                    $UserDetails = UserDetails::get()->where('user_id', Auth::user()->id)->first();
                    if ($UserDetails->allowed_to_upload == 1) {
                        $publish_status = 'Published';
                    } else {
                        if (isset($Studymaterial->publish_by) != 0) {
                            if ($Studymaterial->publish_by == 'Paused & Send Back')
                                $publish_status = $Studymaterial->publish_status;
                            else
                                $publish_status = 'Submit';
                        } else {
                            $publish_status = 'Submit';
                        }
                    }
                } else {
                    $publish_status = 'Submit';
                }
            }

            $Studymaterial = new Studymaterial();
            if ($data['material_id'] != 0) {
                $Studymaterial->exists = true;
                $Studymaterial->id = $data['material_id']; //already exists in database.
            }
            $Studymaterial->title = $data['title'];
            $Studymaterial->sub_title = $data['sub_title'];
            $Studymaterial->education_type = $data['education_type_id'];
            $Studymaterial->class = $data['class_group_exam_id'];
            $Studymaterial->board = $data['exam_agency_board_university_id'];
            $Studymaterial->other_exam = $data['other_exam_class_detail_id'];
            $Studymaterial->subject = $data['part_subject_id'];
            $Studymaterial->subject_part = $data['lesson_subject_part_id'];
            $Studymaterial->permission_to_download = $data['permission'];
            $Studymaterial->document_type = $data['document_type'];
            $Studymaterial->publish_date = $data['publish_date'];
            $Studymaterial->student_rating = $data['student_rating'];
            $Studymaterial->total_student = $data['total_student'];
            $Studymaterial->price = (isset($data['price'])) ? $data['price'] : NULL;
            if ($is_franchies != 1) {
                $Studymaterial->study_material_type = $data['study_material_type'];
                $Studymaterial->select_package = (isset($data['select_package'])) ? $data['select_package'] : NULL;
            }
            $Studymaterial->video_link = (isset($data['video_link'])) ? $data['video_link'] : NULL;
            if (isset($request->study_material_image)) {
                $Studymaterial->study_material_image = (isset($request->study_material_image)) ? $request->study_material_image->store('study_material_image', 'public') : 'NA';
            }

            // if ($data['document_type'] != 'YOUTUBE') {
            if (isset($request->material_file)) {
                $Studymaterial->file = (isset($request->material_file)) ? $request->material_file->store('study_material', 'public') : 'NA';
            }
            // if (isset($data['material_file'])) {
            //     $Studymaterial->file = (isset($data['material_file'])) ? $data['material_file']->store('study_material', preg_replace('/\s+/', '', $data['material_file']->getClientOriginalName())) : 'NA';
            //     // $Studymaterial->file = $request->material_file->store('study_material', 'public');
            // }
            // } else {
            //     $Studymaterial->file = 'NA';
            // }
            if ($data['material_id'] == 0) {
                $Studymaterial->created_by = Auth::user()->id;
                $Studymaterial->institute_id = $institute;
            }
            $Studymaterial->publish_by = $publish_by;
            $Studymaterial->publish_status = $publish_status;
            if ($data['material_id'] != 0) {
                $Studymaterial->material_seen = 1;
            }
            $Studymaterial->remarks = (isset($data['remarks'])) ? $data['remarks'] : NULL;
            $Studymaterial->other_remark = (isset($data['other_remark'])) ? $data['other_remark'] : NULL;
            $Studymaterial->category = (isset($data['category'])) ? $data['category'] : NULL;

            // if(isset($data['pause_material']) && $data['pause_material'] == 'Pause Material')
            //     $Studymaterial->material_seen = (isset($data['pause_val']) && $data['pause_val'] == 1) ? 0 : 1;

            if ($Studymaterial->save()) {
                if ($data['material_id'] == 0)
                    return response()->json(['status' => 200, 'message' => 'Study Material Saved Successfully!'], 200);
                else
                    return response()->json(['status' => 200, 'message' => 'Study Material Updated Successfully!'], 200);
            } else {
                return response()->json(['status' => 500, 'message' => 'Problem In Save Data!'], 500);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Studymaterial  $studymaterial
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                // ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0))
                ->where("study_material.category", 'Study Notes & E-Books');
            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute ? Auth::user()->myInstitute->institute_name : 'Test and Notes';
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] != 'YOUTUBE' || $model['document_type'] != 'AUDIO' || $model['document_type'] != 'VIDEO') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }
        if ($name == 'student.show')
            $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">Study Notes & E-Books</b>';
        if ($name == 'student.showvideo')
            $title = '<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Live & Video Classes</b>';
        if ($name == 'student.showgk')
            $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Static GK & Current Affairs</b>';
        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    public function showvideo(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model      = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0))
                ->where("study_material.category", 'Live & Video Classes');
            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute->institute_name;
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] == 'PDF' || $model['document_type'] == 'WORD' || $model['document_type'] == 'EXCEL') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['document_type'] != 'AUDIO' || $model['document_type'] != 'VIDEO' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['document_type'] != 'AUDIO' || $model['document_type'] != 'VIDEO' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['document_type'] != 'AUDIO' || $model['document_type'] != 'VIDEO' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        if ($model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = route('student.download', [$file[1]]);
                        } elseif ($model['document_type'] == 'YOUTUBE') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = $model['video_link'];
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }
        if ($name == 'student.show')
            $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">Study Notes & E-Books</b>';
        if ($name == 'student.showvideo')
            $title = '<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Live & Video Classes</b>';
        if ($name == 'student.showgk')
            $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Static GK & Current Affairs</b>';
        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    public function showgk(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model      = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0));
            if ($student->education_type == 51)
                $model->where("study_material.category", 'Static GK & Current Affairs');
            if ($student->education_type == 52)
                $model->where("study_material.category", 'Comprehensive Study Material');

            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute->institute_name;
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] == 'PDF' || $model['document_type'] == 'WORD' || $model['document_type'] == 'EXCEL') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        if ($model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = route('student.download', [$file[1]]);
                        } elseif ($model['document_type'] == 'YOUTUBE') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = $model['video_link'];
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }
        if ($name == 'student.show')
            $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">Study Notes & E-Books</b>';
        if ($name == 'student.showvideo')
            $title = '<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Live & Video Classes</b>';
        if ($name == 'student.showgk') {
            if ($student->education_type == 51)
                $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Static GK & Current Affairs</b>';
            if ($student->education_type == 52)
                $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Comprehensive Study Material</b>';
        }
        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    public function showComprehensive(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model      = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0))
                ->where("study_material.category", 'Comprehensive Study Material');

            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute->institute_name;
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] == 'PDF' || $model['document_type'] == 'WORD' || $model['document_type'] == 'EXCEL') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        if ($model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = route('student.download', [$file[1]]);
                        } elseif ($model['document_type'] == 'YOUTUBE') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = $model['video_link'];
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }

        if ($name == 'student.showComprehensive')
             $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Comprehensive Study Material</b>';

        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    public function showShortNotes(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model      = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0))
                ->where("study_material.category", 'Short Notes & One Liner');

            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute->institute_name;
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] == 'PDF' || $model['document_type'] == 'WORD' || $model['document_type'] == 'EXCEL') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        if ($model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = route('student.download', [$file[1]]);
                        } elseif ($model['document_type'] == 'YOUTUBE') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = $model['video_link'];
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }

        if ($name == 'student.showShortNotes')
             $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Short Notes & One Liner</b>';

        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    public function showPremium(Request $request)
    {
        $name = Route::currentRouteName();

        $student = UserDetails::get()->where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $model      = Studymaterial::select("study_material.id", "title", "sub_title", "institute_id", "publish_status", "publish_date", "document_type", "created_by", "file", "video_link", "permission_to_download", "users.name as name", "classes_groups_exams.name as class_group")
                ->leftJoin("users", "users.id", "study_material.created_by")
                ->leftJoin("classes_groups_exams", "classes_groups_exams.id", "study_material.class")
                ->where("study_material.status", 1)
                ->where("study_material.material_seen", 1)
                ->where("study_material.class", $student->class)
                ->whereIn("study_material.institute_id", array(Auth::user()->myInstitute->id, 0))
                ->where("study_material.category", 'Premium Study Notes');

            $model = $model->orderBy('study_material.id', 'desc');
            $model->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('title', '{{ $title }}')
                ->addColumn('class', '{{ $class_group }}')
                ->addColumn('sub_title', '{{ $sub_title }}')
                ->addColumn('availability', function ($model) {
                    $type = '';
                    if ($model['document_type'] == 'PDF')
                        $type = '<i class="bi bi-file-pdf"></i>';
                    if ($model['document_type'] == 'WORD')
                        $type = '<i class="bi bi-file-word"></i>';
                    if ($model['document_type'] == 'EXCEL')
                        $type = '<i class="bi bi-file-excel"></i>';
                    if ($model['document_type'] == 'VIDEO')
                        $type = '<i class="bi bi-camera-video"></i>';
                    if ($model['document_type'] == 'AUDIO')
                        $type = '<i class="bi bi-file-music"></i>';
                    if ($model['document_type'] == 'YOUTUBE')
                        $type = '<i class="bi bi-youtube"></i>';

                    if ($model['publish_status'] == 'Submit')
                        return $type . ' <label style="color:#AA336A;">Scheduled</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                    else
                        return $type . ' <label style="color: #00A300;">' . $model['publish_status'] . '</label>' . '</br>' . date('d-m-Y', strtotime($model['publish_date']));
                })
                ->addColumn('created_by', function ($model) {
                    if ($model['institute_id'] == 0)
                        return 'Test and Notes';
                    else
                        return Auth::user()->myInstitute->institute_name;
                })
                ->addColumn('view', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                        $href = "#";
                    } else {
                        if ($model['document_type'] == 'PDF' || $model['document_type'] == 'WORD' || $model['document_type'] == 'EXCEL') {
                            $href = route('student.viewmaterial', [$file[1]]);
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    }

                    if ($model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } elseif ($model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE' || $model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO')
                            return $downloadHtml = '-';
                        else
                            return $downloadHtml = '<a href=' . $href . ' target="_blank" class="download" data=' . $model['file'] . ' ' . $style . ' title="View File">View</a>';
                    }
                })
                ->addColumn('download', function ($model) {
                    $style = '';
                    $file = '';
                    $href = '';
                    if ($model['file'] != "NA")
                        $file = explode('/', $model['file']);
                    if ($model['publish_status'] == 'Submit' || $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' || $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download') {
                        if ($model['document_type'] == 'AUDIO' || $model['document_type'] == 'VIDEO') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = route('student.download', [$file[1]]);
                        } elseif ($model['document_type'] == 'YOUTUBE') {
                            $style = 'style=margin:0 auto;display:block;text-align: center;';
                            $href = $model['video_link'];
                        } else {
                            $style = "style=color:currentColor;cursor:not-allowed;opacity:0.5;text-decoration:none;margin:0 auto;display:block;text-align: center;";
                            $href = "#";
                        }
                    } else {
                        $style = 'style=margin:0 auto;display:block;text-align: center;';
                        if ($model['document_type'] != 'YOUTUBE')
                            $href = route('student.download', [$file[1]]);
                        else
                            $href = $model['video_link'];
                    }


                    if ($model['file'] != "NA" && $model['permission_to_download'] == 'Free View' || $model['permission_to_download'] == 'Free View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Paid View' || $model['permission_to_download'] == 'Paid View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } elseif ($model['file'] != "NA" && $model['permission_to_download'] == 'Premium View' || $model['permission_to_download'] == 'Premium View & Download' && $model['file'] != 'NA') {
                        return $downloadHtml = '<a href=' . $href . ' class="download" data=' . $model['file'] . ' ' . $style . ' title="Download File"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    } else {
                        if ($model['document_type'] == 'YOUTUBE')
                            return $downloadHtml = '<a href="' . $href . '" target="_blank"  class="download" data="#" ' . $style . ' title="View Video"><i class="bi bi-play text-danger me-2" aria-hidden="true"></i></a>';
                        else
                            return $downloadHtml = '<a href="#"  class="download" data="#" ' . $style . ' title="Coming Soon"><i class="bi bi-download text-danger me-2" aria-hidden="true"></i></a>';
                    }
                })
                ->rawColumns(['availability', 'view', 'download'])
                ->make(true);
        }

        if ($name == 'student.showPremium')
             $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp;<i class="bi bi-camera-video text-danger"></i>&nbsp;<i class="bi bi-file-music text-warning"></i>&nbsp;<i class="bi bi-youtube text-danger"></i>&nbsp; <b class="text-primary">Premium Study Notes</b>';

        return view("Dashboard/Student/Material/materialtable", compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Studymaterial  $studymaterial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $is_admin = Auth::user()->isAdminAllowed;
        $is_franchies = Auth::user()->is_franchise;
        if ($is_franchies == 1) {
            $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
            $publish_content = $FranchiseDetails->allowed_to_upload;
        }
        $is_staff = Auth::user()->is_staff;
        $gn_EduTypes      = Educationtype::get();

        $UserDetails = Studymaterial::get()->where('id', $id)->first();
        //return $UserDetails;

        if ($is_admin == 1)
            //return "test";
            return view("Dashboard/Admin/Material/add_edit_material", compact('UserDetails', 'gn_EduTypes'));
        if ($is_franchies == 1)
            return view("Dashboard/Franchise/Material/add_edit_material", compact('UserDetails', 'gn_EduTypes', 'publish_content'));
        if ($is_staff == 1 && Auth::user()->roles == 'publisher') {
            $User = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $User->submit_content;
            $publish_content = $User->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Publisher/Material/add_edit_material", compact('UserDetails', 'gn_EduTypes', 'submit_content', 'publish_content'));
        }
        if ($is_staff == 1 && Auth::user()->roles == 'creator') {
            $User = UserDetails::get()->where('user_id', Auth::user()->id)->first();
            $submit_content = $User->submit_content;
            $publish_content = $User->allowed_to_upload;
            return view("Dashboard/Franchise/Management/Creater/Material/add_edit_material", compact('UserDetails', 'gn_EduTypes', 'submit_content', 'publish_content'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudymaterialRequest  $request
     * @param  \App\Models\Studymaterial  $studymaterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudymaterialRequest $request, Studymaterial $studymaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Studymaterial  $studymaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $res=Studymaterial::where('id',$request->study_material_id)->delete();
        $Studymaterial = new Studymaterial();
        if ($request->study_material_id != 0) {
            $Studymaterial->exists = true;
            $Studymaterial->id = $request->study_material_id; //already exists in database.
        }
        $Studymaterial->status = 0;

        if ($Studymaterial->save()) {
            if ($request->file != 'NA')
                unlink(storage_path('app/' . $request->file));
            return response()->json(['status' => 200, 'message' => 'Study Material Deleted Successfully!']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Problem In Study Material Delete!']);
        }
    }

    public function pauseMaterial(Request $request)
    {
        $Studymaterial = new Studymaterial();
        if ($request->material_id != 0) {
            $Studymaterial->exists = true;
            $Studymaterial->id = $request->material_id; //already exists in database.
        }

        $Studymaterial = Studymaterial::get()->where('id', $request->material_id)->first();
        $publish_status = '';
        if (isset($request->pause_value) && $request->pause_value == 1) {
            $publish_status = 'Paused';
        } else {
            if (Auth::user()->roles == 'franchise') {
                $FranchiseDetails = FranchiseDetails::get()->where('user_id', Auth::user()->id)->first();
                if ($FranchiseDetails->allowed_to_upload == 1) {
                    if ($Studymaterial->publish_by != 0) {
                        $publish_status = 'Published';
                    } else {
                        $publish_status = 'Submit';
                    }
                } else {
                    $publish_status = 'Submit';
                }
            }
            if (Auth::user()->roles == 'superadmin') {
                if ($Studymaterial->publish_by != 0) {
                    $publish_status = 'Published';
                } else {
                    $publish_status = 'Submit';
                }
            }
        }

        $Studymaterial->material_seen = (isset($request->pause_value) && $request->pause_value == 1) ? 0 : 1;
        $Studymaterial->publish_status = $publish_status;

        if ($Studymaterial->save()) {
            if ($request->pause_value == 1)
                return response()->json(['status' => 200, 'message' => 'Study Material Pause Successfully!']);
            else
                return response()->json(['status' => 200, 'message' => 'Study Material Active Successfully!']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Problem In Study Material Pause/Active!']);
        }
    }

    public function sendbackMaterial(Request $request)
    {
        $Studymaterial = new Studymaterial();
        if ($request->material_id != 0) {
            $Studymaterial->exists = true;
            $Studymaterial->id = $request->material_id; //already exists in database.
        }

        $Studymaterial->material_seen = 0;
        $Studymaterial->publish_status = 'Paused & Send Back';
        $Studymaterial->remarks = $request->remarks;

        if ($Studymaterial->save()) {
            return response()->json(['status' => 200, 'message' => 'Study Material Send Back Successfully!']);
        } else {
            return response()->json(['status' => 500, 'message' => 'Problem In Study Material Send Back!']);
        }
    }

    public function download($file)
    {
        $path = storage_path('app/study_material/' . $file);
        // dd($path);
        return response()->download($path);
    }

    public function viewMaterial($file)
    {
        $filename = url('/storage/study_material/' . $file);
        $title = '<i class="bi bi-file-pdf text-danger"></i>&nbsp;<i class="bi bi-file-word text-info"></i>&nbsp;<i class="bi bi-file-excel text-success"></i>&nbsp; <b class="text-primary">View Study Material</b>';
        return view("Dashboard/Student/Material/viewmaterial", compact('filename', 'title'));
    }

    public function getpackage(Request $req, $education_type_id, $class_group_exam_id, $value)
    {

        $arr = DB::table('gn__package_plans')->where('education_type', $education_type_id)->where('class', $class_group_exam_id)->where('package_category', $value)->get();

        foreach ($arr as $list) {
            echo "<option value=" . $list->id . ">$list->plan_name</option>";
        }
    }

    public function is_featured(Request $request, $plan_id, $status)
    {
        // return $plan_id;
        $model = Studymaterial::find($plan_id);
        $model->is_featured = $status;
        $model->save();
        $request->session()->flash('message', 'blog status updated');
        return redirect()->back();
    }
}
