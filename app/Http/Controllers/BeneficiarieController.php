<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Beneficiarie_Survey;
use Carbon\Carbon;

class BeneficiarieController extends Controller
{
    public function AddbeneficiarieList()
    {
        $beneficiarie = beneficiarie::where('status', 1)->get();
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
        $request->validate([
            'beneficiarie_id' => 'required',
            'survey_details' => 'required|string',
            'survey_date' => 'required',
        ]);

        $beneficiarie = new Beneficiarie_Survey;
        $beneficiarie->beneficiarie_id = $request->input('beneficiarie_id');
        $beneficiarie->survey_details = $request->input('survey_details');
        $beneficiarie->survey_date = Carbon::parse($request->input('survey_date'));
        $beneficiarie->save();

        return redirect()->route('beneficiarie-facilities')->with('success', 'Beneficiare added successfully.');
    }

    public function editbeneficiarie($id)
    {
        $beneficiarie = Beneficiarie::find($id);
        return view('ngo.beneficiarie.edit-beneficiarie', compact('beneficiarie'));
    }

    public function updateBeneficiarie(Request $request, $id)
    {
        $beneficiarie = beneficiarie::find($id);
        $beneficiarie->survey_details = $request->input('survey_details');
        $beneficiarie->help_by_ngo = $request->input('help_by_ngo');
        $beneficiarie->survey_date = Carbon::parse($request->input('survey_date'));
        $beneficiarie->update();

        return redirect()->route('beneficiarie-list')->with('success', 'Beneficiare added successfully.');
    }

    public function beneficiarieFacilities()
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->get();
        
        return view('ngo.beneficiarie.beneficiarie-facilities', compact('beneficiarie'));
    }

    public function showbeneficiariesurvey($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                    ->where('id', $survey_id)
                    ->with('beneficiarie')
                    ->firstOrFail();

        $beneficiarie = beneficiarie::with('surveys')->find($beneficiarie_id);
        return view('ngo.beneficiarie.show-beneficiarie-survey', compact('beneficiarie', 'survey'));
    }

    public function addbeneficiarieFacilities($id)
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($id);
        return view('ngo.beneficiarie.add-beneficiarie-facilities', compact('beneficiarie'));
    }

    public function storebeneficiariefacilities(Request $request, $id)
    {

        $request->validate([
            'facilities_category' => 'required',
            'facilities' => 'required',
        ]);

        $beneficiarie = Beneficiarie_Survey::find($id);
        $beneficiarie->facilities_category = $request->input('facilities_category');
        $beneficiarie->facilities = $request->input('facilities');
        $beneficiarie->save();

        return redirect()->route('beneficiarie-facilities-list')->with('succes', 'Facilities Added successfully');

    }

    public function editbeneficiarieFacilities($id)
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($id);
        return view('ngo.beneficiarie.edit-beneficiarie-facilities', compact('beneficiarie'));
    }


    public function beneficiarieFacilitiesList()
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->get();
        return view('ngo.beneficiarie.beneficiarie-facilities-list', compact('beneficiarie'));
    }

    public function showbeneficiariefacilities($id)
    {

        $beneficiarie = beneficiarie::with('surveys')->find($id);
        return view('ngo.beneficiarie.show-beneficiarie-facilities', compact('beneficiarie'));
    }

    public function distributebeneficiarieFacilities($id)
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($id);
        return view('ngo.beneficiarie.distribute-beneficiarie-facilities', compact('beneficiarie'));
    }

    public function storedistributefacilities(Request $request, $id)
    {

        $request->validate([
            'distribute_date' => 'required',
            'status' => 'required',
        ]);

        $beneficiarie = Beneficiarie_Survey::find($id);
        $beneficiarie->distribute_date = Carbon::parse($request->input('distribute_date'));
        $beneficiarie->status = $request->input('status');
        $beneficiarie->save();

        return redirect()->route('beneficiarie-facilities-list')->with('succes', 'Distribute successfully');
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
