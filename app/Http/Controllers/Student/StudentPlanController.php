<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Gn_PackagePlan;
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
                ->leftJoin('franchise_details', function ($join) {
                    $join->on('gn__package_plans.institute_id', '=', 'franchise_details.id')
                        ->whereNull('franchise_details.deleted_at');
                })
                ->where(function ($query) {
                    $query->where('franchise_details.branch_code', '=', Auth::user()->franchise_code)
                        ->orWhere('gn__package_plans.package_type', '=', 0);
                })
                ->where('gn__package_plans.status', '=', 1);

            $active_plans = Gn_PackageTransaction::where('student_id', Auth::user()->id)
                ->where('plan_status', 1)
                ->pluck('plan_id')
                ->toArray();

            if ($type == 'premium') {
                $model->where('gn__package_plans.final_fees', '>', 0)
                    ->whereNotIn('gn__package_plans.id', $active_plans);
            } elseif ($type == 'free') {
                $model->where('gn__package_plans.final_fees', '=', 0);
            } elseif ($type == 'purchased') {
                $model->whereIn('gn__package_plans.id', $active_plans)
                    ->where('gn__package_plans.final_fees', '>', 0);
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
                            $tests .= $mytest.', ';
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
                ->addColumn('edit', function ($model) use ($active_plans) {
                    if (in_array($model->id, $active_plans)) {
                        return '<a href="'.route('student.package_manage', [$model->id]).'" class="btn btn-sm btn-info">View</a>';
                    }
                    if ($model->final_fees == 0) {
                        return '<a href="'.route('student.plan-checkout', [$model->id]).'" class="btn btn-sm btn-info">View</a>';
                    }

                    return '<a href="'.route('student.plan-checkout', [$model->id]).'" class="btn btn-success pull-right">Buy</a>';
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
                'gn__package_plans.duration', 'gn__package_plans.final_fees', 'gn__package_transactions.plan_status', 'gn__package_transactions.plan_id')
                ->leftJoin('gn__package_plans', 'gn__package_transactions.plan_id', 'gn__package_plans.id')
                ->where('gn__package_transactions.student_id', Auth::user()->id)
                ->where('gn__package_plans.final_fees', '>', 0)
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
                ->addColumn('actions', function ($model) {
                    if ($model->plan_status == 1) {
                        return '<a href="'.route('student.package_manage', [$model->plan_id]).'" class="btn btn-sm btn-info">View</a>';
                    }

                    return '-';
                })
                ->rawColumns(['actions'])
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

        // Handle Free Plan Acquisition
        if ($package_plan->final_fees == 0) {
            $already_active = Gn_PackageTransaction::where('student_id', Auth::user()->id)
                ->where('plan_id', $plan_id)
                ->where('plan_status', 1)
                ->exists();

            if ($already_active) {
                return redirect()->route('student.package_manage', [$plan_id]);
            }

            $transaction_id = 'gyn-free-'.uniqid();
            $package_checkout = new Gn_PackageTransaction;
            $package_checkout->student_id = Auth::user()->id;
            $package_checkout->plan_id = $package_plan->id;
            $package_checkout->plan_amount = 0;
            $package_checkout->plan_name = $package_plan->plan_name;
            $package_checkout->plan_duration = $package_plan->duration;
            $package_checkout->transaction_id = $transaction_id;
            $package_checkout->transaction_date = strtotime(date('m/d/Y'));
            $package_checkout->plan_start_date = strtotime(date('m/d/Y'));
            $package_checkout->plan_end_date = strtotime(date('m/d/Y', strtotime('+'.$package_plan->duration.' days')));
            $package_checkout->plan_status = 1;
            $package_checkout->save();

            return redirect()->route('student.package_manage', [$package_checkout->plan_id]);
        }

        $transaction_id = 'gyn-'.uniqid();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $response = $api->order->create(['amount' => intval($package_plan->final_fees * 100), 'currency' => 'INR']);
        $order_id = $response['id'];
        $already_plan = Gn_PackageTransaction::select('id')->where('student_id', Auth::user()->id)->where('plan_id', $plan_id)->get();
        if ($already_plan->count() > 0) {
            // If user already has a pending or previous transaction for this plan, we might want to queue it or just continue
        }
        if ($response) {
            $package_checkout = new Gn_PackageTransaction;
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
                $package_plan->plan_end_date = strtotime(date('m/d/Y', strtotime('+'.$package_plan->plan_duration.' days')));
                $package_plan->plan_status = 1;
            }
            $package_plan->save();

            return response()->json(['data' => 'success', 'plan_id' => $package_plan->plan_id]);
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
