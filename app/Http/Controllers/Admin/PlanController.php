<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Educationtype;
use App\Models\FranchiseDetails;
use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackagePlanTest;
use App\Models\Studymaterial;
use App\Models\TestModal;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PlanController extends Controller
{
    protected $data;

    protected $insert_data;

    protected $diff_data;

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->data = [];
        $this->data['educations'] = Educationtype::get();
        $this->data['pagename'] = 'Add Package';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Gn_PackagePlan::select('gn__package_plans.id', 'gn__package_plans.study_material_id', 'gn__package_plans.video_id', 'gn__package_plans.static_gk_id', 'is_featured', 'plan_name', 'package_type', 'duration', 'free_duration', 'final_fees', 'status', 'package_image', 'package_category', 'special_remark_1', 'special_remark_2', 'student_rating', 'franchise_details.institute_name as my_institute_name', 'classes_groups_exams.name as class_name')
                ->leftJoin('franchise_details', function ($join) {
                    $join->on('gn__package_plans.institute_id', '=', 'franchise_details.id')
                        ->whereNull('franchise_details.deleted_at');
                })
                ->leftjoin('classes_groups_exams', function ($join) {
                    $join->on('classes_groups_exams.id', '=', 'gn__package_plans.class')
                        ->whereNull('classes_groups_exams.deleted_at');
                })
                ->orderBy('gn__package_plans.id', 'desc')
                ->get();

            $path = 'business';
            $institute = [];

            // foreach ($model as $key => $package) {
            //     if ($package->package_type == 1) {
            //         $institute[$key] = $package->myInstitute;
            //     }
            //     else {
            //         $institute[$key] = "Test and Notes";
            //     }
            // }
            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('plan_image', function ($model) {
                    if ($model['package_image'] != '') {
                        return $img = '<img id="profile_img" src="/storage/'.$model['package_image'].'" style="width:50px;height:50px;border:1px solid #c2c2c2;border-radius:50%;">';
                    } else {
                        return $img = '<img id="profile_img" src="'.asset('noimg.png').'" style="width:50px;height:50px;border:1px solid #c2c2c2;border-radius:50%;">';
                    }
                })
            // ->addColumn('plan_name', '{{ $plan_name }}')
                ->addColumn('plan_name', function ($model) {
                    return $package_name = '<p>'.$model['plan_name'].'</br>'.$model['class_name'].'</p>';
                })
                ->addColumn('is_featured', function ($model) {

                    if ($model['is_featured']) {
                        return $test_data = '<a href="'.'plan/is_featured/'.$model['id'].'/1'.'" class="btn btn-sm btn-warning">UnFeatured</a>';
                    } else {
                        return $test_data = '<a href="'.'plan/is_featured/'.$model['id'].'/0'.'" class="btn btn-sm btn-primary" >Featured</a>';
                    }
                })
            // ->addColumn('package_type','{{ $package_type == 1 ? "Institute" : "Test and Notes" }}')
                ->addColumn('institute_id', '{{ $my_institute_name == null ? "Test and Notes" : $my_institute_name}}')
                ->addColumn('tests', function ($model) {
                    $tests = '';
                    $test_data = '';
                    foreach ($model->test()->get()->pluck('title') as $key => $mytest) {
                        if (count($model->test()->get()->pluck('title')) != $key + 1) {
                            $tests .= $mytest.', ';
                        } else {
                            $tests .= $mytest;

                        }
                    }
                    // $study_material_id = explode(',',$model['study_material_id']);
                    $study_material_id = '';
                    foreach (Studymaterial::whereIn('id', explode(',', $model['study_material_id']))->get()->pluck('title') as $key => $mystudymaterial) {
                        if (count(Studymaterial::whereIn('id', explode(',', $model['study_material_id']))->get()->pluck('title')) != $key + 1) {
                            $study_material_id .= $mystudymaterial.', ';
                        } else {
                            $study_material_id .= $mystudymaterial;

                        }
                    }

                    $video_id = '';

                    foreach (Studymaterial::whereIn('id', explode(',', $model['video_id']))->get()->pluck('title') as $key => $myvideo) {
                        if (count(Studymaterial::whereIn('id', explode(',', $model['video_id']))->get()->pluck('title')) != $key + 1) {
                            $video_id .= $myvideo.', ';
                        } else {
                            $video_id .= $myvideo;

                        }
                    }

                    $static_gk_id = '';

                    foreach (Studymaterial::whereIn('id', explode(',', $model['static_gk_id']))->get()->pluck('title') as $key => $mystatic_gk) {
                        if (count(Studymaterial::whereIn('id', explode(',', $model['static_gk_id']))->get()->pluck('title')) != $key + 1) {
                            $static_gk_id .= $mystatic_gk.', ';
                        } else {
                            $static_gk_id .= $mystatic_gk;

                        }
                    }

                    // return $video_id;
                    return $test_data = '<button class="btn btn-sm btn-primary view_test" id="'.$model['plan_name'].'" data="'.$tests.'"  study_material_id="'.$study_material_id.'" video_id="'.$video_id.'"  static_gk_id="'.$static_gk_id.'">View</button>';
                })
                ->addColumn('duration', '{{ $duration + $free_duration }} days')
            // ->addColumn('final_fees','{{ $final_fees }}')
                ->addColumn('final_fees', function ($model) {
                    $fees = '';
                    if ($model['package_category'] == 'Free') {
                        return $fees = '<p style="color:#198754;font-weight:1000;">'.$model['package_category'].'</p>';
                    }
                    if ($model['package_category'] == 'Paid') {
                        return $fees = '<p style="color:#A020F0;font-weight:1000;">'.$model['package_category'].'</br><span style="color:#A020F0;font-weight:1000;">'.$model['final_fees'].' &#8377;</span></p>';
                    }

                })
            // ->addColumn('status','{{ $status == 1 ? "Active" : "Inactive" }}')
                ->addColumn('status', function ($model) {
                    $status = '';
                    if ($model['status'] == 1) {
                        return $status = '<p style="color:#198754;font-weight:1000;">Active</p>';
                    }
                    if ($model['status'] == 0) {
                        return $status = '<p style="color:#FF0000;font-weight:1000;">Deactive</p>';
                    }
                })
                ->addColumn('edit', function ($model) {
                    return $actionsHtml = '<a href="'.route('administrator.plan_view', [$model['id']]).'" title="Edit Test"><i class="bi bi-pencil-square text-success me-2"></i></a>
                    <a href="javascript:void(0);" class="delete_plan" id='.$model['id'].' data='.$model['status'].' title="Delete Test"><i class="bi bi-trash2-fill text-danger me-2"></i></a>';
                    // // return view('Admin.Partial.options',compact('model','path'));
                })
                ->rawColumns(['plan_image', 'is_featured', 'tests', 'plan_name', 'final_fees', 'status', 'edit'])
                ->make(true);
        }

        return view('Dashboard/Admin/Plan/plantable');
    }

    public function addPlan(Request $request, $id = '')
    {
        if ($request->post()) {
            if ($request->form_name == 'package_plan') {
                $package_plan = new Gn_PackagePlan;
                if ($request->plan_id != '') {
                    $package_plan->exists = true;
                    $package_plan->id = $request->plan_id; // already exists in database.
                }
                $package_plan->plan_name = $request->plan_name;
                $package_plan->package_type = $request->package_type;
                $package_plan->institute_id = $request->institute_id;
                $package_plan->duration = $request->duration;
                $package_plan->free_duration = $request->free_duration;
                $package_plan->actual_fees = $request->actual_fees;
                $package_plan->discount = $request->discount;
                $package_plan->final_fees = $request->final_fees;
                $package_plan->status = $request->status;
                $package_plan->remark = $request->remark;
                $package_plan->special_remark_1 = $request->special_remark_1;
                $package_plan->special_remark_2 = $request->special_remark_2;
                $package_plan->student_rating = $request->student_rating;
                $package_plan->other_remark = $request->other_remark;
                $package_plan->enrol_student_no = $request->enrol_student_no;
                if ($request->hasFile('package_image')) {
                    $fullPath = $this->imageService->handleUpload($request->file('package_image'), 'package_image', 800);
                    $package_plan->package_image = $fullPath;
                }
                $package_plan->expire_date = $request->expire_date;
                $package_plan->education_type = $request->education_type_id;
                $package_plan->class = $request->class_group_exam_id;
                $package_plan->video_id = (isset($request->video_id)) ? implode(',', $request->video_id) : 0;
                $package_plan->study_material_id = (isset($request->study_material_id)) ? implode(',', $request->study_material_id) : 0;
                $package_plan->static_gk_id = (isset($request->current_affairs_id)) ? implode(',', $request->current_affairs_id) : 0;
                $package_plan->package_category = $request->package_category;
                $package_plan->active_date = $request->active_date;
                $package_plan->total_test = (isset($request->total_test) && $request->total_test != 0) ? $request->total_test : 0;
                $package_plan->total_video = (isset($request->total_video) && $request->total_video) ? $request->total_video : 0;
                $package_plan->total_notes = (isset($request->total_notes) && $request->total_notes != 0) ? $request->total_notes : 0;
                $package_plan->total_gk = (isset($request->total_gk) && $request->total_gk != 0) ? $request->total_gk : 0;
                $package_plan->current_affairs_allow = (isset($request->current_affairs_allow) && $request->current_affairs_allow != 0) ? $request->current_affairs_allow : 0;
                $package_plan->comprehensive_study_material = (isset($request->comprehensive_study_material) && $request->comprehensive_study_material != 0) ? $request->comprehensive_study_material : 0;

                $package_plan->save();

                if (! empty($request->test_id)) {
                    if ($request->plan_id != '') {
                        Gn_PackagePlanTest::where('gn_package_plan_id', $package_plan->id)->delete();
                    }
                    foreach ($request->test_id as $id) {
                        $package_plan_test = new Gn_PackagePlanTest;
                        $package_plan_test->gn_package_plan_id = $package_plan->id;
                        $package_plan_test->test_id = $id;
                        $package_plan_test->save();
                    }
                }
                if (isset($id) && $id != '') {
                    return redirect()->route('administrator.plan');
                } else {
                    return redirect()->route('administrator.plan_add');
                }
            }
        }
        // $this->data['test']         = TestModal::select('id','title')->where('published',1)->get();
        $this->data['institute'] = FranchiseDetails::select('id', 'institute_name')->get();
        $this->data['gn_EduTypes'] = Educationtype::get();
        if (isset($id) && $id != '') {
            $this->data['package'] = Gn_PackagePlan::where('id', $id)->get();
            $this->data['test_data'] = Gn_PackagePlanTest::select('test_id')->where('gn_package_plan_id', $id)->get();
        }

        return view('Dashboard/Admin/Plan/add_edit_plan')->with('data', $this->data);
    }

    public function view($id)
    {
        $this->data['test'] = TestModal::select('id', 'title')->where('published', 1)->where('test_type', 0)->get();
        $this->data['institute'] = FranchiseDetails::select('id', 'institute_name')->where('allowed_to_package', 1)->get();
        $this->data['package'] = Gn_PackagePlan::where('id', $id)->get();
        $this->data['test_data'] = Gn_PackagePlanTest::where('gn_package_plan_id', $id)->get();

        // return $this->data;
        return view('Dashboard/Admin/Plan/add_edit_plan')->with('data', $this->data);
    }

    // function to delete data
    public function destroy(Request $request)
    {
        $Gn_PackagePlan = new Gn_PackagePlan;
        if ($request->plan_id != '') {
            $Gn_PackagePlan->exists = true;
            $Gn_PackagePlan->id = $request->plan_id; // already exists in database.
        }

        $Gn_PackagePlan->status = ($request->status == 1) ? 0 : 1;

        if ($Gn_PackagePlan->save()) {
            if ($request->status == 1) {
                return response()->json(['status' => 200, 'message' => 'Plan Inactive Successfully!']);
            } else {
                return response()->json(['status' => 200, 'message' => 'Plan Active Successfully!']);
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'Problem In Plan Active/Inactive!']);
        }
    }

    public function is_featured(Request $request, $plan_id, $status)
    {
        $model = Gn_PackagePlan::find($plan_id);

        $model->is_featured = ! intval($status);
        $model->save();
        $request->session()->flash('message','blog status updated');

        return redirect()->back();
    }
}
