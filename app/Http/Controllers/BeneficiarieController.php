<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use Carbon\Carbon;

class BeneficiarieController extends Controller
{
    public function AddbeneficiarieList()
    {
        $beneficiarie = Beneficiarie::where('status', 1)
            ->whereNull('help_by_ngo')
            ->get();
        return view('ngo.beneficiarie.add-beneficiarie-list', compact('beneficiarie'));
    }

    public function viewbeneficiarie($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.beneficiarie.view-beneficiarie', compact('beneficiarie'));
    }

    public function addbeneficiarie($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.beneficiarie.add-beneficiarie', compact('beneficiarie'));
    }

    public function storeBeneficiarie(Request $request, $id)
    {
        // print_r($request->all());
        // die();
        $request->validate([
            'survey_details' => 'required|string',
            'help_by_ngo' => 'required|string',
            'survey_date' => 'required',
        ]);

        $beneficiarie = beneficiarie::find($id);
        $beneficiarie->survey_details = $request->input('survey_details');
        $beneficiarie->help_by_ngo = $request->input('help_by_ngo');
        $beneficiarie->survey_date = Carbon::parse($request->input('survey_date'));
        $beneficiarie->save();

        return redirect()->route('beneficiarie-list')->with('success', 'Beneficiare added successfully.');
    }

    public function beneficiarieList()
    {
        $beneficiarie = Beneficiarie::where('status', 1)
            ->whereNotNull('help_by_ngo')
            ->get();
        return view('ngo.beneficiarie.beneficiarie-list', compact('beneficiarie'));
    }

    public function editbeneficiarie($id)
    {
        $beneficiarie = Beneficiarie::find($id);
        return view('ngo.beneficiarie.edit-beneficiarie', compact('beneficiarie'));
    }

    public function updateBeneficiarie(Request $request, $id)
    {
        // print_r($request->all());
        // die();
        // $request->validate([
        //     'survey_details' => 'required|string',
        //     'help_by_ngo' => 'required|string',
        //     'survey_date' => 'required',
        // ]);

        $beneficiarie = beneficiarie::find($id);
        $beneficiarie->survey_details = $request->input('survey_details');
        $beneficiarie->help_by_ngo = $request->input('help_by_ngo');
        $beneficiarie->survey_date = Carbon::parse($request->input('survey_date'));
        $beneficiarie->update();

        return redirect()->route('beneficiarie-list')->with('success', 'Beneficiare added successfully.');
    }

    public function showbeneficiarie($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.beneficiarie.show-beneficiarie', compact('beneficiarie'));
    }

    public function beneficiarieReportList()
    {
        $beneficiarie = Beneficiarie::where('status', 1)
            ->whereNotNull('help_by_ngo')
            ->get();
        return view('ngo.beneficiarie.beneficiarie-report-list', compact('beneficiarie'));
    }

     public function showbeneficiariereport($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.beneficiarie.show-beneficiarie-report', compact('beneficiarie'));
    }
}
