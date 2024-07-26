<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Models\lead;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewContact;

class LeadController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
    }
    $lead = new lead();
    $lead->fill($data);
    $lead->save();
    // send email
    Mail::to('prova@example.com')->send(new NewContact($lead));

    return response()->json([
        'status' => 'success',
        'message' => 'Message sent successfully',
    ], 200);
    }
}
