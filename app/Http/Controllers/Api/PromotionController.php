<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index(Request $request)
    {

        $promotions = Promotion::all();
        // dd($promotion);
        return response()->json([
            'status' => 'success',
            'message' => 'Ok',
            'results' => $promotions
        ], 200);
    }
}
