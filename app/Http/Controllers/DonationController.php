<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\donor_data;
use App\Models\beneficiarie;
use App\Models\Member;

class DonationController extends Controller
{
    public function onlineDonor()
    {
        $data = academic_session::all();
        $donor = donor_data::where('status', 'Successful')->get();
        return view('ngo.donation.online-donor-list', compact('data', 'donor'));
    }

    public function donationList(Request $request)
    {

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-list', compact('data', 'donor'));
    }

    public function donation(Request $request)
    {
        $data = academic_session::all();
        $searchKey = $request->search_key;

        $record = null;

        if ($searchKey) {
            // Search in Beneficiaries
            $query = beneficiarie::where('registration_no', $searchKey)
                ->orWhere('name', 'like', '%' . $searchKey . '%')
                ->first();

            // If not found, search in Members
            if (!$query) {
                $query = Member::where('registration_no', $searchKey)
                    ->orWhere('name', 'like', '%' . $searchKey . '%')
                    ->first();
            }

            $record = $query;
        }

        $newReceiptNo = (\App\Models\Donation::max('receipt_no') ?? 0) + 1;

        return view('ngo.donation.donation', compact('data', 'record','newReceiptNo'));
    }


    public function saveDonation(Request $request)
    {

        $request->validate([
            // 'receipt_no' => 'required',
            'session' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'mobile' => 'required',
            'gurdian_name' => 'required',
            'address' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);

        // Get the last receipt_no (assuming it's numeric)
        $lastReceipt = \App\Models\Donation::orderBy('receipt_no', 'desc')->first();

        // Generate new receipt number
        $newReceiptNo = $lastReceipt ? ((int) $lastReceipt->receipt_no + 1) : 1;


        $donation = new Donation;
        // Assign it to the model
        $donation->receipt_no = 'REC-' . str_pad($newReceiptNo, 3, '0', STR_PAD_LEFT);
        $donation->academic_session = $request->session;
        $donation->date = $request->date;
        $donation->name = $request->name;
        $donation->mobile = $request->mobile;
        $donation->gurdian_name = $request->gurdian_name;
        $donation->address = $request->address;
        $donation->amount = $request->amount;
        $donation->payment_method = $request->payment_method;

        $donation->save();

        return redirect()->route('donation-list')->with('success', 'Donation Save Successfully');
    }

    public function viewDonation($id)
    {

        $donor = Donation::find($id);

        return view('ngo.donation.view-donation', compact('donor'));
    }

    public function donationCardList(Request $request)
    {

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-card-list', compact('data', 'donor'));
    }
}
