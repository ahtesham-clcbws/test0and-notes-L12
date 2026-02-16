<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackagePlanTest;
use App\Models\Gn_PackageTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Yajra\DataTables\DataTables;

class StudentPlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $model = Gn_PackagePlan::select('gn__package_plans.id', 'plan_name', 'package_type', 'duration', 'final_fees', 'gn__package_plans.status', 'franchise_details.institute_name as my_institute_name')
                ->leftJoin('franchise_details', 'gn__package_plans.institute_id', 'franchise_details.id')
                ->where(function ($query) {
                    $query->where('franchise_details.branch_code', '=', Auth::user()->franchise_code)
                        ->orWhere('gn__package_plans.package_type', '=', 0);
                })
                ->where('gn__package_plans.status', '=', 1);

            if ($type == 'premium') {
                $model->where('gn__package_plans.final_fees', '>', 0);
            } elseif ($type == 'free') {
                $model->where('gn__package_plans.final_fees', '=', 0);
            }

            $model = $model->get();

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('plan_name', '{{ $plan_name }}')
                ->addColumn('package_type', '{{ $package_type == 1 ? "Institute" : "Test and Notes" }}')
                ->addColumn('institute_id', '{{ $my_institute_name == null ? "Test and Notes" : $my_institute_name}}')
                ->addColumn('tests', function ($model) {
                    $tests = '';
                    foreach ($model->test()->get()->pluck('title') as $key => $mytest) {
                        if (count($model->test()->get()->pluck('title')) != $key + 1) {
                            $tests .= $mytest . ', ';
                        } else {
                            $tests .= $mytest;
                        }
                    }
                    return $tests;
                })
                ->addColumn('duration', '{{ $duration }} days')
                ->addColumn('final_fees', function ($model) {
                    return $model->final_fees > 0 ? $model->final_fees : 'Free';
                })
                ->addColumn('status', '{{ $status == 1 ? "Active" : "Inactive" }}')
                ->addColumn('edit', function ($model) {
                    return '<a href="' . route('student.plan-checkout', [$model->id]) . '" class="btn btn-success pull-right">Buy</a>';
                })
                ->rawColumns(['edit'])
                ->make(true);
        }
        return view('Dashboard/Student/MyPlan/planlist');
    }

    public function myPlan(Request $request)
    {
        if ($request->ajax()) {
            // $model      = Gn_PackagePlan::select("gn__package_plans.id","plan_name","package_type","duration","final_fees","gn__package_plans.status","franchise_details.institute_name as my_institute_name")->
            // leftJoin("franchise_details","gn__package_plans.institute_id","franchise_details.id")->
            // where("franchise_details.branch_code","=",Auth::user()->franchise_code)->
            // orWhere("gn__package_plans.package_type","=",0)->
            // where("gn__package_plans.status","=",1)->
            // get();

            $model = Gn_PackageTransaction::select('gn__package_transactions.id', 'gn__package_transactions.plan_name', 'gn__package_plans.package_type', 'gn__package_transactions.plan_start_date', 'gn__package_transactions.plan_end_date',
                    'gn__package_plans.duration', 'gn__package_plans.final_fees', 'gn__package_transactions.plan_status')
                ->leftJoin('gn__package_plans', 'gn__package_transactions.plan_id', 'gn__package_plans.id')
                ->where('gn__package_transactions.student_id', Auth::user()->id)
                ->get();

            return Datatables::of($model)
                ->addIndexColumn()
                ->addColumn('plan_name', '{{ $plan_name }}')
                ->addColumn('package_type', '{{ $package_type == 1 ? "Institute" : "Test and Notes" }}')
                ->addColumn('plan_start_date', '{{ date("d-m-Y",$plan_start_date) }}')
                ->addColumn('plan_end_date', '{{ date("d-m-Y",$plan_end_date) }}')
                // ->addColumn('package_type','{{ $package_type == 1 ? "Institute" : "Test and Notes" }}')
                // ->addColumn('institute_id','{{ $my_institute_name == null ? "Test and Notes" : $my_institute_name}}')
                // ->addColumn('tests',function($model){
                //     $tests = '';
                //     foreach ($model->test()->get()->pluck('title') as $key => $mytest) {
                //         if (count($model->test()->get()->pluck('title')) != $key+1) {
                //             $tests .= $mytest.", ";
                //         }
                //         else {
                //             $tests .= $mytest;
                //         }
                //     }
                //     return $tests;
                // })
                ->addColumn('duration', '{{ $duration }} days')
                ->addColumn('final_fees', '{{ $final_fees }}')
                ->addColumn('plan_status', function ($model) {
                    switch ($model->plan_status) {
                        case 0:
                            return 'InQueue';
                            break;

                        case 1:
                            return 'Active';
                            break;

                        case 2:
                            return 'Expired';
                            break;

                        case 3:
                            return 'Inactive';
                            break;

                        default:
                            return 'Inactive';
                            break;
                    }
                })
                // ->addColumn('edit',function($model){
                //     return '<a href="'. route('student.plan-checkout',[$model->id]) .'" class="btn btn-success pull-right">Buy</a>';
                // })
                ->rawColumns(['edit'])
                ->make(true);
        }
        return view('Dashboard/Student/MyPlan/myplanlist');
    }

    public function checkout(Request $request, $plan_id)
    {
        $package_plan = Gn_PackagePlan::find($plan_id);
        if ($package_plan == null || $package_plan->status != 1) {
            return redirect()->route('student.plan');
        }
        $transaction_id = 'gyn-' . uniqid();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $response = $api->order->create(array('amount' => intval($package_plan->final_fees * 100), 'currency' => 'INR'));
        $order_id = $response['id'];
        $already_plan = Gn_PackageTransaction::select('id')->where('student_id', Auth::user()->id)->where('plan_id', $plan_id)->get();
        if ($response) {
            $package_checkout = new Gn_PackageTransaction();
            $package_checkout->student_id = Auth::user()->id;
            $package_checkout->plan_id = $package_plan->id;
            $package_checkout->plan_amount = $package_plan->final_fees;
            $package_checkout->plan_name = $package_plan->plan_name;
            $package_checkout->plan_duration = $package_plan->duration;
            $package_checkout->razorpay_order_id = $order_id;
            $package_checkout->transaction_id = $transaction_id;
            $package_checkout->transaction_date = strtotime(date('m/d/Y'));
            if (count($already_plan) > 0) {
                $package_checkout->plan_in_queue = 1;
            }
            // if(Auth::user()->is_active_package == 0) {
            //     $profile_plan->plan_start_date  = null;
            //     $profile_plan->plan_end_date    = null;
            //     $profile_plan->plan_status      = 0;
            // }
            // else {
            //     $profile_plan->plan_start_date      = strtotime(date('m/d/Y'));
            //     $profile_plan->plan_end_date        = strtotime(date('m/d/Y', strtotime("+". $package_plan->duration ." days")));
            //     $profile_plan->plan_status          = 1;
            //     Auth::user()->is_active_package   = 1;
            //     Auth::user()->package_expiry_date = strtotime(date('m/d/Y', strtotime("+". $package_plan->duration ." days")));
            // }
            $package_checkout->save();
        } else {
            return redirect()->route('student.plan');
        }
        $user_detail = Auth::user();
        return view('Dashboard/Student/MyPlan/plan_checkout', compact('package_plan', 'user_detail', 'transaction_id', 'order_id'));
    }

    public function finalCheckout(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if ($payment['status'] == 'captured') {
            $package_plan = Gn_PackageTransaction::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($package_plan->plan_in_queue == 1) {
                $package_plan->razorpay_payment_id = $request->razorpay_payment_id;
                $package_plan->razorpay_signature = $request->razorpay_signature;
                $package_plan->plan_status = 0;
                $package_plan->plan_start_date = null;
                $package_plan->plan_end_date = null;
            } else {
                $package_plan->razorpay_payment_id = $request->razorpay_payment_id;
                $package_plan->razorpay_signature = $request->razorpay_signature;
                $package_plan->plan_start_date = strtotime(date('m/d/Y'));
                $package_plan->plan_end_date = strtotime(date('m/d/Y', strtotime('+' . $package_plan->plan_duration . ' days')));
                $package_plan->plan_status = 1;
            }
            $package_plan->save();

            return response()->json(['data' => 'success']);
        }

        if ($payment['status'] == 'failed') {
            return response()->json(['data' => 'failed']);
        }

        return response()->json(['data' => false]);
    }

    public function paymentSuccess()
    {
        return view('Dashboard/Student/MyPlan/payment-success');
    }

    public function paymentFail()
    {
        return view('Dashboard/Student/MyPlan/payment-failed');
    }
}
