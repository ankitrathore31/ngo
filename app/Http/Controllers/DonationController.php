<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use Illuminate\Http\Request;
use App\Models\donor_data;

class DonationController extends Controller
{
    public function onlineDonor(){
        $data= academic_session::all();
        $donor= donor_data::where('status', 'Successful')->get();
        return view('ngo.donation.online-donor-list', compact('data','donor'));
    }

}
