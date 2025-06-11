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
        $beneficiarie = Beneficiarie::where('status', 1)
            ->where('survey_status', 1)
            ->with(['surveys' => function ($query) {
                $query->orderBy('id', 'asc')->limit(1); // Just get the first row
            }])
            ->orderBy('created_at', 'asc')
            ->get();

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
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
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

    public function distributefacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed')
                ->orderBy('created_at', 'asc');

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
            $q->where('status', 'Distributed')
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
            $q->where('status', 'Distributed')
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
