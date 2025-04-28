<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\donor_data;

class PaymentController extends Controller
{
    public function savedonor(Request $request){

        $validated = $request->validate([
            'donor_name'        => 'required|string|max:255',
            'donor_email'       => 'nullable|email|max:255',
            'donor_number'      => 'nullable|string|max:20',
            'donor_country'     => 'nullable|string|max:100',
            'donor_state'       => 'nullable|string|max:100',
            'donor_district'    => 'nullable|string|max:100',
            'donor_post'        => 'nullable|string|max:100',
            'donor_pincode'     => 'nullable|string|max:20',
            'donor_village'     => 'nullable|string|max:100',
            'donation_category' => 'nullable|string|max:100',
            'donor_remark'      => 'nullable|string|max:500',
            'donation_amount'   => 'required|numeric|min:1',
        ]);

        $donor = new donor_data();
        $donor->donor_name        = $request->donor_name;
        $donor->donor_email       = $request->donor_email ?? null;
        $donor->donor_number      = $request->donor_number ?? null;
        $donor->donor_country     = $request->donor_country ?? null;
        $donor->donor_state       = $request->donor_state ?? null;
        $donor->donor_district    = $request->donor_district ?? null;
        $donor->donor_post        = $request->donor_post ?? null;
        $donor->donor_pincode     = $request->donor_pincode ?? null;
        $donor->donor_village     = $request->donor_village ?? null;
        $donor->donation_category = $request->donation_category ?? null;
        $donor->donor_remark      = $request->donor_remark ?? null;
        $donor->donation_amount   = $request->donation_amount;
        $donor->donate_date       = now();

        $donor->save();

        return response()->json([
            'message' => 'Donation saved successfully!',
            'donor_id' => $donor->id,
        ], 201);
    }
}
