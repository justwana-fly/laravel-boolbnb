<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(Request $request)
    {

        $services = Service::all();
        // dd($services);
        return response()->json([
            'status' => 'success',
            'message' => 'Ok',
            'results' => $services
        ], 200);
    }
}
