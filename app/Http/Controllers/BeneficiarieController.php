<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Beneficiarie_Survey;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeneficiarieController extends Controller
{
    public function AddbeneficiarieList()
    {
        $beneficiarie = beneficiarie::where('status', 1)
            ->where('survey_status', 0)
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
        $request->validate([
            'beneficiarie_id' => 'required',
            'survey_details' => 'required|string',
            'survey_date' => 'required',
        ]);

        $survey = new Beneficiarie_Survey;
        $survey->beneficiarie_id = $request->input('beneficiarie_id');
        $survey->survey_details = $request->input('survey_details');
        $survey->survey_officer = $request->input('survey_officer');
        $survey->survey_date = Carbon::parse($request->input('survey_date'));
        $survey->surveyfacility_status = $request->input('surveyfacility_status', []);
        $survey->save();

        beneficiarie::where('id', $id)->update(['survey_status' => 1]);

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
        $firstSurveyIds = DB::table('beneficiarie__surveys')
            ->selectRaw('MIN(id) as id')
            ->groupBy('beneficiarie_id')
            ->pluck('id');

        // Step 2: Load the surveys with related beneficiary data
        $surveys = Beneficiarie_Survey::with('beneficiarie')
            ->whereIn('id', $firstSurveyIds)
            ->orderBy('id', 'asc')
            ->get();

        return view('ngo.beneficiarie.beneficiarie-facilities', compact('surveys'));
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

    public function deletesurvey($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->firstOrFail();


        $survey->delete();


        Beneficiarie::where('id', $beneficiarie_id)->update(['survey_status' => 0]);

        return redirect()->back()->with('success', 'Survey deleted successfully');
    }

    public function addbeneficiarieFacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        $session = academic_session::all();
        return view('ngo.beneficiarie.add-beneficiarie-facilities', compact('session', 'beneficiarie', 'survey'));
    }

    public function storebeneficiariefacilities(Request $request, $beneficiarie_id, $survey_id)
    {
        $request->validate([
            'facilities_category' => 'required',
            'facilities' => 'required', // Single text value
            'session' => 'required',
        ]);

        try {
            // Get previous survey
            $previousSurvey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            // Create a new row using previous survey details + new facility
            $newSurvey = new Beneficiarie_Survey;
            $newSurvey->beneficiarie_id = $previousSurvey->beneficiarie_id;
            $newSurvey->survey_details = $previousSurvey->survey_details;
            $newSurvey->survey_officer = $previousSurvey->survey_officer;
            $newSurvey->survey_date = $previousSurvey->survey_date;
            $newSurvey->surveyfacility_status = $previousSurvey->surveyfacility_status;
            $newSurvey->facilities_category = $request->input('facilities_category');
            $newSurvey->academic_session = $request->input('session');
            $newSurvey->facilities = $request->input('facilities'); // Single facility
            $newSurvey->facilities_status = 1;
            $newSurvey->save();

            return redirect()->route('beneficiarie-facilities-list')->with('success', 'Facility added successfully');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update facilities.']);
        }
    }

    public function editFacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->find($beneficiarie_id);
        $session = academic_session::all();
        return view('ngo.beneficiarie.edit-facilities', compact('session', 'beneficiarie', 'survey'));
    }

    public function updateFacilities(Request $request, $beneficiarie_id, $survey_id)
    {

        try {
            $facilities = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->with('beneficiarie')
                ->firstOrFail();

            $facilities->facilities_category = $request->input('facilities_category');
            $facilities->academic_session = $request->input('session');
            $facilities->facilities = $request->input('facilities');
            $facilities->save();

            return redirect()->route('beneficiarie-facilities-list')->with('success', 'Facilities Update successfully');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update facilities.']);
        }
    }


    public function beneficiarieFacilitiesList(Request $request)
    {
        $query = beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('facilities_status', 1)
                ->whereNull('status')
                ->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])
            // Filter only beneficiaries that have surveys matching the same conditions
            ->whereHas('surveys', function ($q) use ($request) {
                $q->where('facilities_status', 1)
                    ->whereNull('status');

                if ($request->session_filter) {
                    $q->where('academic_session', $request->session_filter);
                }

                if ($request->category_filter) {
                    $q->where('facilities_category', $request->category_filter);
                }
            })
            ->where('status', 1)
            ->orderBy('id', 'desc');

        $beneficiarie = $query->get();

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

    public function deletefacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();

        // beneficiarie::where('id', $beneficiarie_id)->update(['survey_status' => 0]);

        return redirect()->back()->with('success', 'Facilities Delete Successfully');
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
            'pending_reason' => 'required_if:status,Pending',
        ]);

        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->with('beneficiarie')
                ->firstOrFail();

            $distribute->distribute_date = Carbon::parse($request->input('distribute_date'));
            $distribute->distribute_place = $request->input('distribute_place'); // FIXED here
            $distribute->status = $request->input('status');
            $distribute->pending_reason = $request->input('pending_reason');
            $distribute->save();

            if ($request->input('status') === 'Disributed') {
                return redirect()->route('distributed-list')->with('success', 'Distributed successfully');
            } else {
                return redirect()->route('pending-distribute-list')->with('success', 'Facilities Now Pending');
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update distribution.']);
        }
    }

    public function EditDistributeFacilities($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        return view('ngo.beneficiarie.edit-distribute-facilities', compact('survey', 'beneficiarie'));
    }

    public function updateDistributeFacilities(Request $request, $beneficiarie_id, $survey_id)
    {
        $request->validate([
            'distribute_date' => 'required|date',
            'status' => 'required',
            'distribute_place' => 'required|string',
            'pending_reason' => 'required_if:status,Pending',
        ]);

        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $distribute->distribute_date = Carbon::parse($request->input('distribute_date'));
            $distribute->distribute_place = $request->input('distribute_place');
            $distribute->status = $request->input('status');
            $distribute->pending_reason = $request->input('status') === 'Pending'
                ? $request->input('pending_reason')
                : null;

            $distribute->save();

            if ($distribute->status === 'Distributed') {
                return redirect()->route('distributed-list')->with('success', 'Facilities successfully distributed.');
            } else {
                return redirect()->route('pending-distribute-list')->with('success', 'Facilities marked as pending.');
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update distribution.']);
        }
    }


    public function distributefacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed')->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->distribute_date) {
                $q->where('distribute_date', $request->distribute_date);
            }
        }])->where('status', 1);

        // Filter by block, district, and state
        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        // Filter only those with matching surveys
        $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Distributed');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->distribute_date) {
                $q->where('distribute_date', $request->distribute_date);
            }
        });

        $beneficiarie = $query->orderBy('id', 'desc')->get();

        // Dropdown values
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.distributed-facilities-list', compact('beneficiarie', 'data', 'categories'));
    }



    public function pendingfacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Pending')
                ->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        // Get only beneficiaries who actually have at least one distributed survey
        $beneficiarie = $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Pending')
                ->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
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
            $q->where('status', 'Distributed')->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        }])->where('status', 1);

        // Apply state, district, block filters
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        // Only get beneficiaries with at least one matching survey
        $query->whereHas('surveys', function ($q) use ($request) {
            $q->where('status', 'Distributed')->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }
        });

        $beneficiarie = $query->orderBy('id', 'desc')->get();

        // Filters for the view
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.all-beneficiarie-list', compact('beneficiarie', 'data', 'categories'));
    }



    public function showbeneficiariereport($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        return view('ngo.beneficiarie.show-beneficiarie-report', compact('beneficiarie', 'survey'));
    }

    public function surveyrecivedlist()
    {
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->where('survey_status', 1)->get();

        return view('ngo.beneficiarie.survey-received-list', compact('beneficiarie'));
    }
}
