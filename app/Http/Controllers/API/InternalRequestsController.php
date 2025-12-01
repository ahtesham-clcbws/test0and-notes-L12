<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class InternalRequestsController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function getCitiesByStateId($stateId)
    {
        $returnResponse = ['success' => false, 'message' => 'Server error, please try after some time.'];
        $returnResponse['message'] = getCitiesByState($stateId);
        return getCitiesByState($returnResponse);
    }
}
