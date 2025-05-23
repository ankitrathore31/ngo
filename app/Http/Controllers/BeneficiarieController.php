<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use Carbon\Carbon;

class BeneficiarieController extends Controller
{
    public function beneficiarieList()
    {
        $beneficiarie = beneficiarie::where('status', 1)->get();
        return view('ngo.beneficiarie.add-beneficiarie', compact('beneficiarie'));
    }
}
