<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->query('promoted')) {
                 // Ottieni solo gli appartamenti sponsorizzati e visibili
                $apartments = Apartment::with('services', 'promotions')
                    ->where('visibility', 1)
                    ->whereHas('promotions', function($query) {
                        $query->where('end_date', '>=', now());
                    })
                    ->get();
    
                // Ordina gli appartamenti in base al prezzo della promozione più alta
                $apartments = $apartments->sortByDesc(function($apartment) {
                    return $apartment->promotions->max('price');
                });
            } else {
                // Ottieni solo gli appartamenti visibili
                $apartments = Apartment::with('services')->where('visibility', 1)->get();
            }
    
            $cleanApartments = $apartments->map(function ($apartment) {
                $data = $apartment->toArray();
                unset($data['location']);
                return $data;
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Ok',
                'results' => $cleanApartments
            ], 200);
        } catch (\Exception $e) {
            // Log dell'errore
            \Log::error('Errore durante il recupero degli appartamenti: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Errore durante il recupero degli appartamenti',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    


    public function show($slug)

{
    $apartment = Apartment::where('slug', $slug)
    ->where('visibility', 1) // Filtra solo gli appartamenti visibili
    ->with('user', 'services')
    ->first();

    if ($apartment) {
        // Converti l'appartamento in un array
        $data = $apartment->toArray();
        // Rimuovi il campo 'location'
        unset($data['location']);

        return response()->json([
            'success' => true,
            'message' => 'Ok',
            'results' => $data
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'apartment not found'
        ], 404);

    }
}




}