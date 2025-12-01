<?php

namespace App\Http\Controllers\Frontend\Franchise\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Count;
use App\Models\FranchiseDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user_role_type = Auth::user()->role->pluck('role_id')->toArray();
        //manager
        if (empty(array_diff($user_role_type,[6])) || count($user_role_type) >= 2) {
            return redirect()->route('franchise.management.manager.dashboard');
        }
        //publisher
        if (empty(array_diff($user_role_type,[7]))) {
            return redirect()->route('franchise.management.publisher.dashboard');
        }
        //creater
        if (empty(array_diff($user_role_type,[8]))) {
            return redirect()->route('franchise.management.creater.dashboard');
        }

        $id = Auth::user()->id;
        $myDetails = User::find($id);
        $branchCode = $myDetails->franchise_code;

        $matchNew           = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '0', 'status' => 'unread'];
        $matchStudents      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '0', 'status' => 'active'];
        $matchManagers      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $matchCreators      = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $matchPublishers    = ['in_franchise' => '1', 'franchise_code' => $branchCode, 'isAdminAllowed' => '0', 'is_staff' => '1', 'status' => 'active'];
        $newSignup          = User::where($matchNew)->get()->count();
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
        return view('Dashboard/Franchise/Management/Publisher/Dashboard/index')->with('data', $data);
    }
}
