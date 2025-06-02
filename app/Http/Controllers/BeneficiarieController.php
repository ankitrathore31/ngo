<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Beneficiarie_Survey;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
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

    public function addbeneficiarieFacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        return view('ngo.beneficiarie.add-beneficiarie-facilities', compact('beneficiarie', 'survey'));
    }

    public function storebeneficiariefacilities(Request $request, $beneficiarie_id, $survey_id)
    {

        $request->validate([
            'facilities_category' => 'required',
            'facilities' => 'required',
        ]);

        try {
            $facilities = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->with('beneficiarie')
                ->firstOrFail();

            $facilities->facilities_category = $request->input('facilities_category');
            $facilities->facilities = $request->input('facilities');
            $facilities->save();

            return redirect()->route('beneficiarie-facilities-list')->with('success', 'Facilities added successfully');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update facilities.']);
        }
    }

    public function editbeneficiarieFacilities($id)
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($id);
        return view('ngo.beneficiarie.edit-beneficiarie-facilities', compact('beneficiarie'));
    }


    public function beneficiarieFacilitiesList(Request $request)
    {
        $query = beneficiarie::with(['surveys' => function ($q) use ($request) {
            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        $beneficiarie = $query->orderBy('id', 'desc')->get();

        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.beneficiarie-facilities-list', compact('data', 'categories', 'beneficiarie'));
    }


    public function showbeneficiariefacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->find($beneficiarie_id);
        return view('ngo.beneficiarie.show-beneficiarie-facilities', compact('beneficiarie', 'survey'));
    }

    public function distributebeneficiarieFacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        return view('ngo.beneficiarie.distribute-beneficiarie-facilities', compact('beneficiarie', 'survey'));
    }



    public function storedistributefacilities(Request $request, $beneficiarie_id, $survey_id)
    {
        $request->validate([
            'distribute_date' => 'required|date',
            'status' => 'required',
            'distribute_place' => 'required|string',
        ]);

        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->with('beneficiarie')
                ->firstOrFail();

            $distribute->distribute_date = Carbon::parse($request->input('distribute_date'));
            $distribute->distribute_place = $request->input('distribute_place'); // FIXED here
            $distribute->status = $request->input('status');
            $distribute->save();

            return redirect()->route('beneficiarie-facilities-list')->with('success', 'Distributed successfully');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update distribution.']);
        }
    }

    public function distributefacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        // Get only beneficiaries who actually have at least one distributed survey
        $beneficiarie = $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Distributed');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        })->orderBy('id', 'desc')->get();

        // For dropdowns/filters
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.distributed-facilities-list', compact('beneficiarie', 'data', 'categories'));
    }


     public function pendingfacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Pending');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        // Get only beneficiaries who actually have at least one distributed survey
        $beneficiarie = $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Pending');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        })->orderBy('id', 'desc')->get();

        // For dropdowns/filters
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.pending-facilities-list', compact('beneficiarie', 'data', 'categories'));
    }

     public function allbeneficiarielist(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        // Get only beneficiaries who actually have at least one distributed survey
        $beneficiarie = $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Distributed');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        })->orderBy('id', 'desc')->get();

        // For dropdowns/filters
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.all-beneficiarie-list', compact('beneficiarie', 'data', 'categories'));
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
