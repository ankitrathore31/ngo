<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\donor_data;
use App\Models\beneficiarie;
use App\Models\Member;
use Illuminate\Support\Facades\DB;


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

        // Get all Beneficiaries and Members, and merge them
        $beneficiaries = beneficiarie::all();
        $members = Member::all();
        $record = $beneficiaries->merge($members);

        $lastReceiptNo = Donation::max('receipt_no');
        $newReceiptNo = is_numeric($lastReceiptNo) ? ((int) $lastReceiptNo + 1) : 1;

        return view('ngo.donation.donation', compact('data', 'record', 'newReceiptNo'));
    }



    public function saveDonation(Request $request)
    {
        $request->validate([
            'session' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'mobile' => 'required',
            'gurdian_name' => 'required',
            'address' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);

        $lastReceipt = \App\Models\Donation::orderBy('id', 'desc')->first();
        if ($lastReceipt && is_numeric($lastReceipt->receipt_no)) {
            $newReceiptNo = (int)$lastReceipt->receipt_no + 1;
        } else {
            $newReceiptNo = 1;
        }
        $formattedReceiptNo = str_pad($newReceiptNo, 3, '0', STR_PAD_LEFT);

        $donation = new Donation;
        $donation->receipt_no = $formattedReceiptNo;
        $donation->academic_session = $request->session;
        $donation->date = $request->date;
        $donation->name = $request->name;
        $donation->mobile = $request->mobile;
        $donation->gurdian_name = $request->gurdian_name;
        $donation->address = $request->address;
        $donation->amount = $request->amount;
        $donation->payment_method = $request->payment_method;

        // Conditional Cheque fields
        if ($request->payment_method == 'Cheque') {
            $donation->cheque_no = $request->cheque_no;
            $donation->bank_name = $request->bank_name;
            $donation->bank_branch = $request->bank_branch;
            $donation->cheque_date = $request->cheque_date;
        }

        // Conditional UPI fields
        if ($request->payment_method == 'UPI') {
            $donation->transaction_no = $request->transaction_no;
            $donation->transaction_date = $request->transaction_date;
        }

        $donation->save();

        return redirect()->route('donation-list')->with('success', 'Donation saved successfully!');
    }


    public function viewDonation($id)
    {

        $donor = Donation::find($id);

        return view('ngo.donation.view-donation', compact('donor'));
    }

    public function viewDonationCertificate($id)
    {

        $donor = Donation::find($id);

        return view('ngo.donation.donation-certificate', compact('donor'));
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

    public function allDonations(Request $request)
    {
        $query = DB::table('donations')
            ->leftJoin('donors', 'donations.mobile', '=', 'donors.donor_mobile')
            ->select(
                'donations.*',
                'donors.donor_name as donor_name',
                'donors.donor_address as donor_address',
                'donors.donor_mobile as donor_mobile'
            );

        $donors = Donation::query();

        if ($request->filled('session_filter')) {
            $donors->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $donors->where('name', 'like', '%' . $request->name . '%');
        }
        $donors = $query->get();
        $data = academic_session::all(); // for session filter dropdown    
        return view('ngo.donation.all-donation-list', compact('data', 'donors'));
    }
}
