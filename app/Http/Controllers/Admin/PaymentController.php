<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Models\Promotion;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function show(Request $request, Gateway $gateway)
    {
        $apartment_id = $request->input('apartment_id');
        $promotion_id = $request->input('promotion_id');
        $promotion = Promotion::findOrFail($promotion_id);

        $clientToken = $gateway->clientToken()->generate();
        return view('admin.apartments.payment.form', compact('apartment_id', 'promotion_id', 'promotion', 'clientToken'));
    }

    public function process(Request $request)
    {
        $apartment_id = $request->input('apartment_id');
        $promotion_id = $request->input('promotion_id');

        $promotion = Promotion::findOrFail($promotion_id);
        $start_date = now();
        $duration = explode(':', $promotion->duration);
        $end_date = Carbon::parse($start_date)->addHours($duration[0])->addMinutes($duration[1])->addSeconds($duration[2]);

        $apartment = Apartment::findOrFail($apartment_id);
        $existingPromotion = $apartment->promotions()->where('promotion_id', $promotion_id)->first();

        if ($existingPromotion) {
            $current_end_date = Carbon::parse($existingPromotion->pivot->end_date);
            $new_end_date = $current_end_date->greaterThan($end_date) ? $current_end_date->copy()->addHours($duration[0])->addMinutes($duration[1])->addSeconds($duration[2]) : $end_date;
            $apartment->promotions()->updateExistingPivot($promotion_id, ['start_date' => $start_date, 'end_date' => $new_end_date]);
        } else {
            $apartment->promotions()->attach($promotion_id, ['start_date' => $start_date, 'end_date' => $end_date]);
        }

        return redirect()->route('admin.payment.success')->with(['apartment' => $apartment, 'promotions' => $apartment->promotions]);
    }

    public function success()
    {
        session()->flash('success', 'Payment completed successfully!');
        return redirect()->back();
    }
}
