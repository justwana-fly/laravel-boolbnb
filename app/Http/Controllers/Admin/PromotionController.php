<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    // Mostra il form per creare una nuova sponsorizzazione
     public function index()
    {
        // Recupera tutti gli appartamenti dell'utente autenticato
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->with('promotions')->get();

        // Filtra solo gli appartamenti che hanno almeno una sponsorizzazione
        $sponsoredApartments = $apartments->filter(function ($apartment) {
            return $apartment->promotions->isNotEmpty();
        });

        return view('admin.apartments.sponsorl.sponsor-index', ['apartments' => $sponsoredApartments]);

    }


    // Salva la sponsorizzazione
    public function store(Request $request)
    {
        // Trova l'appartamento specificato nel form tramite il suo ID
        $apartment = Apartment::findOrFail($request->apartment_id);

      // Controlla se l'appartamento è già sponsorizzato
        if ($this->isApartmentSponsored($apartment)) {
            // Se l'appartamento è già sponsorizzato, mostra un messaggio di errore
            return redirect()->back()->withErrors('Questo appartamento è già sponsorizzato.');
        }
       }


       public function removeExpiredPromotions()
       {
           $now = Carbon::now();
           Apartment::whereHas('promotions', function ($query) use ($now) {
               $query->where('end_date', '<', $now);
           })->each(function ($apartment) use ($now) {
               $apartment->promotions()->wherePivot('end_date', '<', $now)->detach();
           });
  
           return response()->json(['status' => 'success']);
       }
}