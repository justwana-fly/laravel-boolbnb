<?php

use App\Http\Controllers\Api\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PromotionController;

use App\Http\Controllers\Api\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/search/location', [SearchController::class, 'searchByLocation']);
Route::get('/search/filter', [SearchController::class, 'filterApartments']);

Route::get('apartments', [ApartmentController::class, 'index']);
Route::get('apartments/{slug}', [ApartmentController::class, 'show']);
Route::get('apartments/nearby', [ApartmentController::class, 'searchNearby']);
Route::get('services', [ServiceController::class, 'index']);
Route::get('promotions', [PromotionController::class, 'index']);

// Contacts 
Route::Post('/contacts', [LeadController::class, 'store']);
//passare le promotion a vue
