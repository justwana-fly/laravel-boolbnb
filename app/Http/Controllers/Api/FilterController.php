<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filter;

use App\Models\User;
use Illuminate\Support\Facades\DB; 


class FilterController extends Controller
{
    public function index(Request $request)
    {

        try {
            $lon = $request->input('longitude');
            $lat = $request->input('latitude');
            $radius = $request->input('radius');
            
            // Verifica che i parametri siano numerici
            //  if (!is_numeric($lat) || !is_numeric($lon) || !is_numeric($radius)) {
            //     throw new \Exception('I parametri latitude, longitude e radius devono essere numerici.');
            // }

            // Query per cercare gli appartamenti entro un certo raggio
            $query = "
                SELECT id, slug, name, beds, bathrooms, visibility, description, rooms, square_meters, image_cover, address,
                ST_Distance_Sphere(location, POINT(?, ?)) AS distance 
                FROM apartments 
                HAVING distance <= ?
                ORDER BY distance
            ";

            $apartments = DB::select($query, [
                $lon,
                $lat,
                $radius * 1000 // Converti il raggio in metri
            ]);

            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in ApartmentController@index:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore durante il recupero degli appartamenti.',
                'error' => $e->getMessage()
            ], 500);
        }


    }
}