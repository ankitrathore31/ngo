<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\donor_data;

class DonationController extends Controller
{
    public function onlineDonor(){
        $data= academic_session::all();
        $donor= donor_data::where('status', 'Successful')->get();
        return view('ngo.donation.online-donor-list', compact('data','donor'));
    }

    public function donationList(Request $request){

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data =academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-list', compact('data','donor'));
    }

    public function donation(){

        $data = academic_session::all();

        return view('ngo.donation.donation', compact('data'));
    }

    public function saveDonation(Request $request){

        $request->validate([
            'receipt_no' => 'required',
            'session' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'mobile' => 'required',
            'gurdian_name' => 'required',
            'address' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);

        $donation = new Donation;

        $donation->academic_session = $request->session;
        $donation->receipt_no = $request->receipt_no;
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

    public function viewDonation($id){

        $donor = Donation::find($id);

        return view('ngo.donation.view-donation', compact('donor'));
    }

    public function donationCardList(Request $request){

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data =academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-card-list', compact('data','donor'));
    }

}
