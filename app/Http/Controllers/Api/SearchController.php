<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    // Metodo per ottenere gli appartamenti basati sulla località
    public function searchByLocation(Request $request)
    {
        try {
            $lon = (float) $request->input('longitude');
            $lat = (float) $request->input('latitude');
            $radius = (int) $request->input('radius');
            
            // Verifica che i parametri siano numerici
            if (!is_numeric($lat) || !is_numeric($lon) || !is_numeric($radius)) {
                throw new \Exception('I parametri latitude, longitude e radius devono essere numerici.');
            }

            // Base query per cercare gli appartamenti entro un certo raggio
            $query = "
                SELECT a.id, a.slug, a.name, a.beds, a.bathrooms, a.visibility, a.description, a.rooms, 
                    a.square_meters, a.image_cover, a.address, a.latitude, a.longitude,
                    COALESCE(p.price, 0) AS promotion_price,
                    ST_Distance_Sphere(point(a.longitude, a.latitude), point(?, ?)) AS distance 
                FROM apartments a
                LEFT JOIN apartment_promotion ap ON a.id = ap.apartment_id
                LEFT JOIN promotions p ON ap.promotion_id = p.id
                WHERE a.visibility = 1
                AND ST_Distance_Sphere(point(a.longitude, a.latitude), point(?, ?)) <= ?
                ORDER BY promotion_price DESC, distance ASC
            ";

            $bindings = [$lon, $lat, $lon, $lat, $radius * 1000]; // Parametri per la query

            $apartments = DB::select($query, $bindings);

            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in SearchController@searchByLocation:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore durante il recupero degli appartamenti.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Metodo per ottenere gli appartamenti basati sui filtri
    public function filterApartments(Request $request)
    {
        try {
            $lon = (float) $request->input('longitude');
            $lat = (float) $request->input('latitude');
            $radius = (int) $request->input('radius');
            $beds = (int) $request->input('beds');
            $rooms = (int) $request->input('rooms');
            $services = $request->input('services', []); // Assumi che sia un array di ID dei servizi

            // Base query per cercare gli appartamenti entro un certo raggio
            $query = "
                SELECT a.id, a.slug, a.name, a.beds, a.bathrooms, a.visibility, a.description, a.rooms, 
                    a.square_meters, a.image_cover, a.address, a.latitude, a.longitude,
                    COALESCE(p.price, 0) AS promotion_price,
                    ST_Distance_Sphere(point(a.longitude, a.latitude), point(?, ?)) AS distance 
                FROM apartments a
                LEFT JOIN apartment_promotion ap ON a.id = ap.apartment_id
                LEFT JOIN promotions p ON ap.promotion_id = p.id
                WHERE a.visibility = 1
                AND ST_Distance_Sphere(point(a.longitude, a.latitude), point(?, ?)) <= ?
            ";

            $bindings = [$lon, $lat, $lon, $lat, $radius * 1000]; // Parametri per la query

            if ($beds) {
                $query .= " AND a.beds >= ?";
                $bindings[] = $beds;
            }

            if ($rooms) {
                $query .= " AND a.rooms >= ?";
                $bindings[] = $rooms;
            }

            // Aggiungi filtro per i servizi se presenti
            if (!empty($services)) {
                $serviceIds = array_map('intval', $services);
                $serviceCount = count($serviceIds);

                $placeholders = implode(',', array_fill(0, $serviceCount, '?'));

                $query .= " AND a.id IN (
                    SELECT apartment_id 
                    FROM apartment_service 
                    WHERE service_id IN ($placeholders)
                    GROUP BY apartment_id
                    HAVING COUNT(DISTINCT service_id) = ?
                )";

                $bindings = array_merge($bindings, $serviceIds, [$serviceCount]);
            }

            $query .= " ORDER BY promotion_price DESC, distance ASC";

            $apartments = DB::select($query, $bindings);

            return response()->json([
                'success' => true,
                'results' => $apartments
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in SearchController@filterApartments:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore durante il recupero degli appartamenti.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
