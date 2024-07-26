<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Search;
use Braintree\Gateway;
use App\Models\ApartmentPromotion;
use Illuminate\Support\Facades\DB;



class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // Recupera l'utente autenticato
        
        // Recupera gli appartamenti ordinati per data di creazione in ordine decrescente
        $apartments = $user->apartments()
                           ->where('deleted_at', null)
                           ->where('user_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        
        $totalApartments = DB::table('apartments')
                             ->where('user_id', $user->id)
                             ->where('deleted_at', null)
                             ->count();
    
        return view('admin.apartments.index', compact('apartments', 'totalApartments'));
    }
    // ciao

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services= Service::all();
         return view('admin.apartments.create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);

        $validatedData['user_id'] = Auth::id();
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
        }
        $client = new Client([
            'verify' => false,
        ]);
        $apiBaseUrl='https://api.tomtom.com/search/2/geocode/';
        $apiAdress= Search::apiFormatAddress($validatedData['address']);
        $response = $client->get("{$apiBaseUrl}{$apiAdress}.json", [
            'query' => [
                'key' => env('TOMTOM_API_KEY'),
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['results'][0]['position'])) {
            $validatedData['latitude'] = $data['results'][0]['position']['lat'];
            $validatedData['longitude'] = $data['results'][0]['position']['lon'];
        } else {
            return back()->withErrors(['address' => 'Could not retrieve coordinates for the given address.']);
        }
        
        $new_apartment = new Apartment();
        $new_apartment->fill($validatedData);
        $new_apartment->visibility = $request->has('visibility') ? 1 : 0;
        $new_apartment->setLocationAttribute($validatedData['longitude'], $validatedData['latitude']); 
        $new_apartment->save();
        if($request->has('services')){
            $new_apartment->services()->sync($request->services);
        }

        return redirect()->route('admin.apartments.index')->with('success', 'Apartment created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Gateway $gateway, $slug)
    {
        // Trova l'appartamento utilizzando lo slug
        $apartment = Apartment::where('slug', $slug)->with('promotions')->firstOrFail();

        // Controllo se l'utente è il proprietario dell'appartamento
        if ($apartment->user_id !== Auth::id()) {
            // Se l'utente non è il proprietario dell'appartamento, restituisci una risposta 404
            abort(404);
        }

        // Altrimenti, mostra la vista dell'appartamento
        $promotions = Promotion::all();
        //Genera il token per il gateway di pagament
        $clientToken = $gateway->clientToken()->generate();

        return view('admin.apartments.show', compact('apartment', 'promotions', 'clientToken'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment->user_id !== auth()->id()) {
            abort(404, 'Unauthorized action.');
        }
        $services= Service::all();
        return view('admin.apartments.edit', compact('apartment','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment, Gateway $gateway)
    {
        $validatedData = $request->validated();
        
        if ($request->hasFile('image_cover')) {
            $image_cover = Storage::put('img-apart-bnb', $request->image_cover);
            $validatedData['image_cover'] = $image_cover;
            $apartment->image_cover=$validatedData['image_cover'];
        }
        if($apartment->name !== $validatedData['name']){
            $validatedData['slug'] = Apartment::generateSlug($validatedData['name']);
            $apartment->slug= $validatedData['slug'];
        }
        if($apartment->address !==  $validatedData['address']){
            $client = new Client([
                'verify' => false,
            ]);
            $apiBaseUrl='https://api.tomtom.com/search/2/geocode/';
            $apiAdress= Search::apiFormatAddress($validatedData['address']);
            $response = $client->get( $apiBaseUrl . $apiAdress . '.json', [
                'query' => [
                    'key' => env('TOMTOM_API_KEY'),
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['results'][0]['position'])) {
                $validatedData['latitude'] = $data['results'][0]['position']['lat'];
                $validatedData['longitude'] = $data['results'][0]['position']['lon'];
            } else {
                return back()->withErrors(['address' => 'Could not retrieve coordinates for the given address.']);
            }
            
        
        }
        $fields = ['name', 'description', 'rooms', 'bathrooms', 'beds', 'square_meters', 'address', 'latitude', 'longitude', 'slug', 'image_cover'];
        
        foreach ($fields as $field) {
            if (!isset($validatedData[$field])) {
                $validatedData[$field] = $apartment->$field;
            }
        }
        $apartment->fill($validatedData);
        $apartment->visibility = $request->has('visibility') ? 1 : 0;
        $apartment->setLocationAttribute($validatedData['latitude'], $validatedData['longitude']); 
        $apartment->save();
        if($request->has('services')){
            $apartment->services()->sync($request->services);
        }
        $promotions = Promotion::all();
        $clientToken = $gateway->clientToken()->generate();
        return view('admin.apartments.show', compact('apartment','promotions', 'clientToken')); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $apartment = Apartment::findOrFail($id);
        $apartment->services()->detach();
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', "Apartment {$apartment->name}: eliminate with succes from db");
       
    }
}
