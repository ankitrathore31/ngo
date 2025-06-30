<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\donor_data;

class PaymentController extends Controller
{

    public function savedonor(Request $request)
    {
        $validated = $request->validate([
            'donor_name'        => 'required|string|max:255',
            'donor_email'       => 'nullable|email|max:255',
            'donor_number'      => 'nullable|string|max:20',
            'donor_country'     => 'nullable|string|max:100',
            'donor_state'       => 'nullable|string|max:100',
            'donor_district'    => 'nullable|string|max:100',
            'block'             => 'nullable|string|max:100',
            'donor_pincode'     => 'nullable|string|max:20',
            'donor_village'     => 'nullable|string|max:100',
            'donor_idtype'      => 'nullable|string|max:100',
            'donor_aadhar'      => 'nullable|string|max:12',
            'donor_pancard'     => 'nullable|string|max:100',
            'donation_category' => 'nullable|string|max:100',
            'donation_remark'      => 'nullable|string|max:500',
            'donation_amount'   => 'required|numeric|min:1',
        ]);

        $donate_date = now()->toDateString();

        // Save donor data
        $donor = new donor_data();
        $donor->name        = $request->donor_name;
        $donor->email       = $request->donor_email ?? null;
        $donor->mobile      = $request->donor_number ?? null;
        $donor->donor_country     = $request->donor_country ?? null;
        $donor->state       = $request->donor_state ?? null;
        $donor->district    = $request->donor_district ?? null;
        $donor->block        = $request->block ?? null;
        $donor->donor_pincode     = $request->donor_pincode ?? null;
        $donor->donor_village     = $request->donor_village ?? null;
        $donor->donor_idtype      = $request->donor_idtype ?? null;
        $donor->donor_aadhar      = $request->donor_aadhar ?? null;
        $donor->donor_pancard     = $request->donor_pancard ?? null;
        $donor->donation_category = $request->donation_category ?? null;
        $donor->donation_remark      = $request->donation_remark ?? null;
        $donor->amount   = $request->donation_amount;
        $donor->status = 'pending';
        $donor->date       = now();

        // Save donor to get the ID
        $donor->save();

        // Prepare for Cashfree payment
        $apiKey = "94308161032e16f494fbf7e96a180349";
        $secretKey = "cfsk_ma_prod_364ee546c89ef58263a4c205b60bf681_76335508";
        $apiVersion = "2025-01-01";

        $customerId = Str::random(12);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-api-version' => $apiVersion,
            'x-client-id' => $apiKey,
            'x-client-secret' => $secretKey,
        ])->post("https://api.cashfree.com/pg/orders", [
            'order_currency' => 'INR',
            'order_amount' => $request->donation_amount,
            'customer_details' => [
                'customer_id' => $customerId,
                'customer_phone' => $request->donor_number,
                'customer_name' => $request->donor_name,
            ],
            'order_meta' => [
                'return_url' => route('payment.success', ['id' => $donor->id]),
            ]
        ]);

        if ($response->successful()) {
            $res = $response->json();
            $donor->order_id = $res['order_id'];
            $donor->save();

            return redirect()->route('checkout', ['session_id' => $res['payment_session_id']]);
        }

        return back()->withErrors(['error' => 'Failed to initiate payment.']);
    }

    

    public function checkout(Request $request)
    {
        $sessionId = $request->session_id;
        $donorId = $request->donor_id;

        return view('home.donation.checkout', compact('sessionId', 'donorId'));
    }


    public function success(Request $request, $id)
    {
        // Find the donor by ID to update or show success
        $donor = donor_data::find($id);

        if ($donor) {

            $donor->status = 'Successful';
            $donor->save();

            return view('home.donation.certificate', compact('donor'));
        }

        return back()->withErrors(['error' => 'Donor not found!']);
    }
}
