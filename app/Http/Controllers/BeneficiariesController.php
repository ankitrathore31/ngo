<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeneficiariesController extends Controller
{
    public function addbene(){
        return view ('ngo.beneficiaries.add-bene');
    }
}
