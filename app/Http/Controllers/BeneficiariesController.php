<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeneficiariesController extends Controller
{
    public function registraition(){
        $states = config('states');
        return view ('ngo.beneficiaries.add-reg', compact('states'));
    }

    public function savebene(Request $request){
        $request->validate([
            'name' => 'required',
            ''
        ]);
    }

    public function pendingregistraition(){
        // $states = config('states');
        return view ('ngo.beneficiaries.pending-reg-list');
    }

    public function apporveregistraition(){
        // $states = config('states');
        return view ('ngo.beneficiaries.apporve-reg-list');
    }
}
