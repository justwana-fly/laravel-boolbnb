<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Lead::with('apartment')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
                        
        $totalMessage = DB::table('leads')->count(); 
        
        return view('admin.leads.index', compact('messages', 'totalMessage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'apartment_id' => 'required|exists:apartments,id', // Valida che l'ID dell'appartamento esista
        ]);

        // Crea un nuovo lead
        $lead = new Lead();
        $lead->name = $validatedData['name'];
        $lead->email = $validatedData['email'];
        $lead->message = $validatedData['message'];
        $lead->apartment_id = $validatedData['apartment_id']; // Salva l'ID dell'appartamento
        $lead->save();

        return response()->json(['message' => 'Lead created successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted successfully');
    }
}


