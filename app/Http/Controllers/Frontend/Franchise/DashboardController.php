<?php

namespace App\Http\Controllers\Frontend\Franchise;

use App\Http\Controllers\Controller;
use App\Models\Count;
use App\Models\FranchiseDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $myDetails = FranchiseDetails::where('user_id', $id)->first();
        $branchCode = $myDetails->branch_code;

        $matchNew           = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '0'];
        $matchStudents      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '0', 'status' => 'active'];
        $matchManagers      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $matchCreators      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $matchPublishers    = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $newSignup          = User::where($matchNew)->where(function ($query) {
            $query->where('status', 'unread')->orWhere('status', 'inactive');
        })->get()->count();
        $totalStudents      = User::where($matchStudents)->where('roles','student')->get()->count();
        $totalManagers      = User::where($matchManagers)->where('roles', 'like', 'manager')->get()->count();
        $totalCreators      = User::where($matchCreators)->where('roles', 'like', 'creator')->get()->count();
        $totalPublishers    = User::where($matchPublishers)->where('roles', 'like', 'publisher')->get()->count();
        $totalMulti         = User::where($matchPublishers)->where('roles', 'like', '%,%')->get()->count();

        $data = array();
        $data = [
            'newSignup'         => $newSignup,
            'totalStudents'     => $totalStudents,
            'totalManagers'     => $totalManagers,
            'totalCreators'     => $totalCreators,
            'totalPublishers'   => $totalPublishers,
            'totalMulti'        => $totalMulti,
        ];

        $countsData = Count::all();
        foreach ($countsData as $value) {
            $data['cards'][] = $value->toArray();
        }
        return view('Dashboard/Franchise/Dashboard/index')->with('data', $data);
    }
}
