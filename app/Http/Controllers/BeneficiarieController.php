<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Beneficiarie_Survey;
use App\Models\academic_session;
use App\Models\Category;
use App\Models\Signature;
use App\Models\Staff;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeneficiarieController extends Controller
{
    public function AddbeneficiarieList(Request $request)
    {
        $beneficiarie = beneficiarie::where('status', 1)
            ->where('survey_status', 0)

            ->when($request->session_filter, function ($query, $session_filter) {
                return $query->where('session_date', $session_filter);
            })

            ->when($request->application_no, function ($query, $application_no) {
                return $query->where('application_no', $application_no);
            })

            ->when($request->registration_no, function ($query, $registration_no) {
                return $query->where(function ($q) use ($registration_no) {
                    $q->where('registration_no', $registration_no)
                        ->orWhere('mobile_no', $registration_no)
                        ->orWhere('identity_no', $registration_no);
                });
            })

            ->when($request->name, function ($query, $name) {
                return $query->where(function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%')
                        ->orWhere('gurdian_name', 'like', '%' . $name . '%');
                });
            })

            ->when($request->state, function ($query, $state) {
                return $query->where('state', $state);
            })

            ->when($request->district, function ($query, $district) {
                return $query->where('district', $district);
            })

            ->when($request->block, function ($query, $block) {
                return $query->where('block', 'like', '%' . $block . '%');
            })

            ->when($request->village, function ($query, $village) {
                return $query->where('village', 'like', '%' . $village . '%');
            })

            ->get();

        $data = academic_session::all();
        $states = config('states');
        $staff = Staff::get();

        return view(
            'ngo.beneficiarie.add-beneficiarie-list',
            compact('beneficiarie', 'data', 'states', 'staff')
        );
    }

    public function viewbeneficiarie($id)
    {

        $beneficiarie = beneficiarie::find($id);
        return view('ngo.beneficiarie.view-beneficiarie', compact('beneficiarie'));
    }

    public function addbeneficiarie($id)
    {

        $beneficiarie = beneficiarie::find($id);
        $staff = Staff::get();
        return view('ngo.beneficiarie.add-beneficiarie', compact('beneficiarie', 'staff'));
    }

    public function storeBeneficiarie(Request $request, $id)
    {
        $request->validate([
            'beneficiarie_id' => 'required',
            'survey_details' => 'required|string',
            'survey_date' => 'required',
            'bene_category' => 'required',
            'survey_officer' => 'required', // <-- Add this
        ]);

        $survey = new Beneficiarie_Survey;
        $survey->beneficiarie_id = $request->beneficiarie_id;
        $survey->survey_details = $request->survey_details;
        $survey->survey_officer = $request->survey_officer; // <-- Saves text
        $survey->bene_category = $request->bene_category;
        $survey->survey_date = Carbon::parse($request->survey_date);
        $survey->surveyfacility_status = $request->surveyfacility_status ?? [];
        $survey->save();

        beneficiarie::where('id', $id)->update(['survey_status' => 1]);
        logWork(
            'Survey',
            $survey->id,
            'New Survey Submit',
            'Survey Date: ' . $survey->survey_date . ' | Details: ' . $survey->bene_category
        );

        beneficiarie::where('id', $id)->update(['survey_status' => 1]);

        return redirect()->route('beneficiarie-facilities')->with('success', 'Beneficiare added successfully.');
    }

    public function storeBulkBeneficiarie(Request $request)
    {
        $request->validate([
            'beneficiarie_ids' => 'required|string',
            'survey_details'   => 'required|string',
            'survey_date'      => 'required|date',
            'bene_category'    => 'required|string',
            'survey_officer'   => 'required|string',
        ]);

        $ids = explode(',', $request->beneficiarie_ids);

        foreach ($ids as $id) {

            Beneficiarie_Survey::create([
                'beneficiarie_id'        => $id,
                'survey_details'         => $request->survey_details,
                'survey_officer'         => $request->survey_officer,
                'bene_category'          => $request->bene_category,
                'survey_date'            => Carbon::parse($request->survey_date),
                'surveyfacility_status'  => $request->surveyfacility_status ?? [],
            ]);

            Beneficiarie::where('id', $id)
                ->update(['survey_status' => 1]);

            logWork(
                'Survey',
                $id,
                'Bulk Survey Submit',
                'Survey Date: ' . $request->survey_date
            );
        }

        return redirect()
            ->route('beneficiarie-facilities')
            ->with('success', count($ids) . ' surveys added successfully.');
    }

    public function editbeneficiarie($id)
    {
        $beneficiarie = Beneficiarie::find($id);
        $staff = Staff::get();
        return view('ngo.beneficiarie.edit-beneficiarie', compact('beneficiarie', 'staff'));
    }

    public function updateBeneficiarie(Request $request, $id)
    {
        $beneficiarie = beneficiarie::find($id);
        $beneficiarie->survey_details = $request->input('survey_details');
        $beneficiarie->help_by_ngo = $request->input('help_by_ngo');
        $beneficiarie->bene_category  = $request->input('bene_category');
        $beneficiarie->survey_date = Carbon::parse($request->input('survey_date'));
        $beneficiarie->update();

        return redirect()->route('beneficiarie-list')->with('success', 'Beneficiare update successfully.');
    }

    public function beneficiarieFacilities(Request $request)
    {
        // Step 1: Get first survey IDs for each beneficiary
        $firstSurveyIds = DB::table('beneficiarie__surveys')
            ->selectRaw('MIN(id) as id')
            ->groupBy('beneficiarie_id')
            ->pluck('id');

        // Step 2: Load the surveys with related beneficiary data
        $surveys = Beneficiarie_Survey::with('beneficiarie')
            ->whereIn('id', $firstSurveyIds)
            ->orderBy('id', 'asc');

        // Step 3: Apply filters from the form

        if ($request->filled('session_filter')) {
            $surveys->where('session_date', $request->session_filter);
        }

        /* ===== Beneficiarie-based search ===== */

        if ($request->filled('application_no')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('application_no', $request->application_no);
            });
        }

        if ($request->filled('registration_no')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('registration_no', $request->registration_no)
                    ->orWhere('mobile_no', $request->registration_no)
                    ->orWhere('identity_no', $request->registration_no);
            });
        }

        if ($request->filled('name')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('state')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('state', $request->state);
            });
        }

        if ($request->filled('district')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('district', $request->district);
            });
        }

        if ($request->filled('block')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('block', 'like', '%' . $request->block . '%');
            });
        }

        if ($request->filled('village')) {
            $surveys->whereHas('beneficiarie', function ($query) use ($request) {
                $query->where('village', 'like', '%' . $request->village . '%');
            });
        }

        /* ===== Survey-based search ===== */

        if ($request->filled('survey_officer')) {
            $surveys->where('survey_officer', $request->survey_officer);
        }

        if ($request->filled('bene_category')) {
            $surveys->where('bene_category', $request->bene_category);
        }

        // Fetch the filtered results
        $surveys = $surveys->get();

        $staff = Staff::get();
        $data = academic_session::all();
        $states = config('states');
        $categories = Category::orderBy('category', 'asc')->get();

        return view(
            'ngo.beneficiarie.beneficiarie-facilities',
            compact('surveys', 'data', 'states', 'categories', 'staff')
        );
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


        beneficiarie::where('id', $beneficiarie_id)->update(['survey_status' => 0]);

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
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.beneficiarie.add-beneficiarie-facilities', compact('session', 'beneficiarie', 'survey', 'category'));
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
            logWork(
                'Facilities',
                $newSurvey->id,
                'Benefries Facilities Added',
                'Category: ' . $newSurvey->facilities_category . ' | Facilities: ' . $newSurvey->facilities
            );

            return redirect()->route('beneficiarie-facilities-list')->with('success', 'Facility added successfully');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update facilities.']);
        }
    }

    public function deleteBeneficiarieFacilities($id)
    {
        try {
            $survey = Beneficiarie_Survey::findOrFail($id);

            $survey->facilities_category = null;
            $survey->facilities = null;
            $survey->academic_session = null;
            $survey->facilities_status = null;

            $survey->save();

            logWork(
                'Facilities',
                $survey->id,
                'Benefries Facilities Cleared',
                'All facility values set to Reset'
            );

            return redirect()
                ->route('beneficiarie-facilities-list')
                ->with('success', 'Facility removed successfully');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Failed to remove facility.']);
        }
    }

    public function storeBulkBeneficiarieFacilities(Request $request)
    {
        $request->validate([
            'survey_ids' => 'required|json',
            'facilities_category' => 'required|string',
            'facilities' => 'required|string',
            'session' => 'required|string',
        ]);

        try {
            // Decode survey IDs
            $surveyIds = json_decode($request->input('survey_ids'), true);

            if (empty($surveyIds)) {
                return back()->withErrors(['error' => 'No surveys selected.']);
            }

            $successCount = 0;
            $errors = [];

            // Loop through each selected survey
            foreach ($surveyIds as $surveyId) {
                try {
                    // Get the original survey
                    $previousSurvey = Beneficiarie_Survey::findOrFail($surveyId);

                    // Create new survey entry with facilities
                    $newSurvey = new Beneficiarie_Survey();
                    $newSurvey->beneficiarie_id = $previousSurvey->beneficiarie_id;
                    $newSurvey->survey_details = $previousSurvey->survey_details;
                    $newSurvey->survey_officer = $previousSurvey->survey_officer;
                    $newSurvey->survey_date = $previousSurvey->survey_date;
                    $newSurvey->surveyfacility_status = $previousSurvey->surveyfacility_status;
                    $newSurvey->bene_category = $previousSurvey->bene_category;

                    // Add new facility data
                    $newSurvey->facilities_category = $request->input('facilities_category');
                    $newSurvey->academic_session = $request->input('session');
                    $newSurvey->facilities = $request->input('facilities');
                    $newSurvey->facilities_status = 1;

                    $newSurvey->save();
                    logWork(
                        'Facilities',
                        $newSurvey->id,
                        'Benefries Facilities Added',
                        'Category: ' . $newSurvey->facilities_category . ' | Facilities: ' . $newSurvey->facilities
                    );
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to add facility for Survey ID: {$surveyId}";
                }
            }

            $message = "Facilities added successfully to {$successCount} beneficiaries.";

            if (!empty($errors)) {
                $message .= " However, " . count($errors) . " survey(s) failed.";
                return redirect()->route('beneficiarie-facilities-list')
                    ->with('warning', $message)
                    ->withErrors($errors);
            }

            return redirect()->route('beneficiarie-facilities-list')
                ->with('success', $message);
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to add facilities: ' . $th->getMessage()]);
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
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.beneficiarie.edit-facilities', compact('session', 'beneficiarie', 'survey', 'category'));
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

            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        }])

            // Survey-level filtering
            ->whereHas('surveys', function ($q) use ($request) {
                $q->where('facilities_status', 1)
                    ->whereNull('status');

                if ($request->session_filter) {
                    $q->where('academic_session', $request->session_filter);
                }

                if ($request->category_filter) {
                    $q->where('facilities_category', $request->category_filter);
                }

                if ($request->bene_category) {
                    $q->where('bene_category', $request->bene_category);
                }
            })

            // Beneficiarie-level search filters
            ->where('status', 1)

            ->when($request->application_no, function ($q) use ($request) {
                $q->where('application_no', $request->application_no);
            })

            ->when($request->registration_no, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('registration_no', $request->registration_no)
                        ->orWhere('mobile_no', $request->registration_no)
                        ->orWhere('identity_no', $request->registration_no);
                });
            })

            ->when($request->name, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->name . '%')
                        ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
                });
            })

            ->orderBy('id', 'desc');

        $beneficiarie = $query->get();

        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');
        $staff = Staff::get();

        return view(
            'ngo.beneficiarie.beneficiarie-facilities-list',
            compact('data', 'categories', 'beneficiarie', 'category', 'staff')
        );
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
            'distribute_date'  => 'required|date',
            'distribute_place' => 'required|string',
        ]);

        try {

            DB::transaction(function () use ($request, $beneficiarie_id, $survey_id) {

                $distribute = Beneficiarie_Survey::lockForUpdate()
                    ->where('beneficiarie_id', $beneficiarie_id)
                    ->where('id', $survey_id)
                    ->firstOrFail();

                $distribute->distribute_date  = Carbon::parse($request->distribute_date);
                $distribute->distribute_place = $request->distribute_place;

                // Set status as STRING '0'
                $distribute->status = '0';

                /*
         |-------------------------------------------------
         | TOKEN GENERATION LOGIC (RESET IF NO STATUS = '0')
         |-------------------------------------------------
         */
                if ($distribute->status === '0' && empty($distribute->token_no)) {

                    // Get last token ONLY from status = '0'
                    $lastToken = Beneficiarie_Survey::where('status', '0')
                        ->whereNotNull('token_no')
                        ->orderByRaw('CAST(token_no AS UNSIGNED) DESC')
                        ->lockForUpdate()
                        ->value('token_no');

                    // If no status = '0' exists → restart from 01
                    $nextToken = $lastToken
                        ? str_pad(((int) $lastToken + 1), 2, '0', STR_PAD_LEFT)
                        : '01';

                    $distribute->token_no = $nextToken;
                }

                $distribute->save();

                logWork(
                    'Distribute Facilities',
                    $distribute->id,
                    'Benefries Facilities Distribute',
                    'Distribute Date: ' . $distribute->distribute_date
                );
            });

            return redirect()
                ->route('distributed-list-for-approve')
                ->with('success', 'Facilities Now For Distribute');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update distribution.']);
        }
    }

    public function DeleteDistribueFacilities($beneficiarie_id, $survey_id)
    {
        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $distribute->distribute_date     = null;
            $distribute->distribute_place    = null;
            $distribute->status = null;

            $distribute->save();

            return back()->with('success', 'Distribution data has been reset successfully.');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'error' => 'Failed to reset distribution data.'
            ]);
        }
    }

    public function storeBulkDistribute(Request $request)
    {
        $request->validate([
            'distribute_items' => 'required|string',
            'distribute_date'  => 'required|date',
            'distribute_place' => 'required|string',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $items = explode(',', $request->distribute_items);

                foreach ($items as $item) {

                    [$beneficiarie_id, $survey_id] = explode('|', $item);

                    $distribute = Beneficiarie_Survey::lockForUpdate()
                        ->where('beneficiarie_id', $beneficiarie_id)
                        ->where('id', $survey_id)
                        ->firstOrFail();

                    // Update distribute data
                    $distribute->distribute_date  = Carbon::parse($request->distribute_date);
                    $distribute->distribute_place = $request->distribute_place;

                    // Set status as STRING '0'
                    $distribute->status = '0';

                    /*
                |-------------------------------------------------
                | TOKEN GENERATION LOGIC (GLOBAL SEQUENCE)
                |-------------------------------------------------
                */
                    if ($distribute->status === '0' && empty($distribute->token_no)) {

                        $lastToken = Beneficiarie_Survey::where('status', '0')
                            ->whereNotNull('token_no')
                            ->orderByRaw('CAST(token_no AS UNSIGNED) DESC')
                            ->lockForUpdate()
                            ->value('token_no');

                        $nextToken = $lastToken
                            ? str_pad(((int)$lastToken + 1), 2, '0', STR_PAD_LEFT)
                            : '01';

                        $distribute->token_no = $nextToken;
                    }

                    $distribute->save();

                    logWork(
                        'Distribute Facilities',
                        $distribute->id,
                        'Bulk Beneficiarie Facilities Distribute',
                        'Distribute Date: ' . $distribute->distribute_date
                    );
                }
            });

            return redirect()
                ->route('distributed-list-for-approve')
                ->with('success', 'Facilities successfully distributed for selected beneficiaries.');
        } catch (\Throwable $th) {

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Failed to distribute facilities. Please try again.'
                ]);
        }
    }

    public function DistributeFacilitiesStatus($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        $staff = Staff::get();
        return view('ngo.beneficiarie.approve-facilities', compact('beneficiarie', 'survey', 'staff'));
    }

    public function storedistributefacilitiesStatus(Request $request, $beneficiarie_id, $survey_id)
    {
        $request->validate([
            'officer'         => 'nullable|string|max:255',
            'status'          => 'required|in:Pending,Distributed,Reject',
            'pending_reason'  => 'required_if:status,Pending,Reject|nullable|string|max:500',
        ]);

        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $distribute->survey_officer = $request->input('officer');
            $distribute->status = $request->input('status');

            // Handle Pending / Reject reason
            if (in_array($request->input('status'), ['Pending', 'Reject'])) {
                $distribute->pending_reason = $request->input('pending_reason');
            } else {
                $distribute->pending_reason = null;
            }

            $distribute->save();

            // Redirect based on status
            return match ($distribute->status) {
                'Distributed' => redirect()
                    ->route('distributed-list')
                    ->with('success', 'Facilities successfully distributed.'),

                'Reject' => redirect()
                    ->route('pending-distribute-list')
                    ->with('success', 'Facilities rejected.'),

                default => redirect()
                    ->route('pending-distribute-list')
                    ->with('success', 'Facilities marked as pending.'),
            };
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update distribution status.']);
        }
    }

    
    public function storeBulkDistributeStatus(Request $request)
    {
        $request->validate([
            'distribute_items' => 'required|string',
            'officer'          => 'nullable|string',
            'status'           => 'required|in:Pending,Distributed,Reject',
            'pending_reason'   => 'required_if:status,Pending,Reject|nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $items = explode(',', $request->distribute_items);

                foreach ($items as $item) {

                    [$beneficiarie_id, $survey_id] = explode('|', trim($item));

                    $distribute = Beneficiarie_Survey::lockForUpdate()
                        ->where('beneficiarie_id', $beneficiarie_id)
                        ->where('id', $survey_id)
                        ->firstOrFail();

                    // Update officer and status
                    $distribute->officer = $request->officer;
                    $distribute->status  = $request->status;

                    // Update pending/reject reason if applicable
                    if (in_array($request->status, ['Pending', 'Reject'])) {
                        $distribute->pending_reason = $request->pending_reason;
                    } else {
                        $distribute->pending_reason = null; // Clear reason for Distributed status
                    }

                    // Set distribute date for Distributed status
                    if ($request->status === 'Distributed') {
                        $distribute->distribute_date = now();
                    }

                    $distribute->save();

                    // Log the action
                    logWork(
                        'Distribute Facilities',
                        $distribute->id,
                        'Bulk Facilities Distribution',
                        'Officer: ' . ($request->officer ?? 'N/A') . ' | Status: ' . $request->status .
                            ($request->pending_reason ? ' | Reason: ' . $request->pending_reason : '')
                    );
                }
            });

            // Redirect based on status
            if ($request->status === 'Distributed') {
                return redirect()
                    ->route('distributed-list')
                    ->with('success', count(explode(',', $request->distribute_items)) . ' facilities distributed successfully.');
            } elseif ($request->status === 'Pending') {
                return redirect()
                    ->route('pending-distribute-list')
                    ->with('success', count(explode(',', $request->distribute_items)) . ' facilities moved to pending.');
            } else {
                return redirect()
                    ->route('pending-distribute-list')
                    ->with('success', count(explode(',', $request->distribute_items)) . ' facilities rejected.');
            }
        } catch (\Throwable $th) {
            \Log::error('Bulk distribution failed: ' . $th->getMessage());

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Bulk distribution failed: ' . $th->getMessage()
                ]);
        }
    }

    public function DistributeFacilitiesForApprove(Request $request)
    {
        /* Survey filter (STATUS MUST BE STRING '0') */
        $surveyFilter = function ($q) use ($request) {
            $q->where('status', '0')
                ->orderBy('updated_at', 'asc');

            if ($request->filled('session_filter')) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->filled('category_filter')) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->filled('distribute_date')) {
                $q->whereDate('distribute_date', $request->distribute_date);
            }

            if ($request->filled('bene_category')) {
                $q->where('bene_category', $request->bene_category);
            }
        };

        /* Main Query */
        $query = beneficiarie::where('status', 1)
            ->whereHas('surveys', $surveyFilter)
            ->with(['surveys' => $surveyFilter]);

        /* Beneficiarie Search Filters */
        if ($request->filled('application_no')) {
            $query->where('application_no', $request->application_no);
        }

        if ($request->filled('registration_no')) {
            $query->where(function ($q) use ($request) {
                $q->where('registration_no', $request->registration_no)
                    ->orWhere('mobile_no', $request->registration_no)
                    ->orWhere('identity_no', $request->registration_no);
            });
        }

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
            });
        }

        /* Location Filters */
        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        /* Fetch Data */
        $beneficiarie = $query->orderBy('id', 'desc')->get();

        /* Supporting Data */
        $data = academic_session::all();

        $category = Category::orderBy('category', 'asc')->get();

        $categories = Beneficiarie_Survey::where('status', '0')
            ->select('facilities_category')
            ->distinct()
            ->pluck('facilities_category');

        $staff = Staff::get();

        return view(
            'ngo.beneficiarie.pending-facility-list',
            compact('beneficiarie', 'data', 'categories', 'category', 'staff')
        );
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
            'distribute_place' => 'required|string',
        ]);

        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $distribute->distribute_date = Carbon::parse($request->input('distribute_date'));
            $distribute->distribute_place = $request->input('distribute_place');

            $distribute->save();

            return redirect()->route('distributed-list-for-approve')->with('success', 'Facilities successfully distributed.');
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors(['error' => 'Failed to update distribution.']);
        }
    }

    public function EditDistributeFacilitiesStatus($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        $staff = Staff::get();
        return view('ngo.beneficiarie.edit-approve-facilities', compact('survey', 'beneficiarie', 'staff'));
    }

    public function updateDistributeFacilitiesStatus(Request $request, $beneficiarie_id, $survey_id)
    {
        $request->validate([
            'officer'         => 'nullable|string|max:255',
            'status'          => 'required|in:Pending,Distributed,Reject',
            'pending_reason'  => 'required_if:status,Pending,Reject|nullable|string|max:500',
        ]);

        try {
            $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $survey->update([
                'survey_officer' => $request->input('officer'),
                'status'         => $request->input('status'),
                'pending_reason' => in_array($request->input('status'), ['Pending', 'Reject'])
                    ? $request->input('pending_reason')
                    : null,
            ]);

            return match ($survey->status) {
                'Distributed' => redirect()
                    ->route('distributed-list')
                    ->with('success', 'Facilities successfully distributed.'),

                'Reject' => redirect()
                    ->route('pending-distribute-list')
                    ->with('success', 'Facilities rejected.'),

                default => redirect()
                    ->route('pending-distribute-list')
                    ->with('success', 'Facilities marked as pending.'),
            };
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update distribution status.']);
        }
    }


    public function DeleteDistribueFacilitiesStatus($beneficiarie_id, $survey_id)
    {
        try {
            $distribute = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $distribute->pending_reason      = null;
            $distribute->officer             = null;
            $distribute->status              = '0';

            $distribute->save();

            return back()->with('success', 'Distribution Status has been reset successfully.');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'error' => 'Failed to reset distribution data.'
            ]);
        }
    }

    public function distributefacilities(Request $request)
    {
        $query = beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed')
                ->orderBy('updated_at', 'asc');

            if ($request->session_filter) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->distribute_date) {
                $q->where('distribute_date', $request->distribute_date);
            }

            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        }])->where('status', 1);

        /* Beneficiarie Search Filters */
        if ($request->filled('application_no')) {
            $query->where('application_no', $request->application_no);
        }

        if ($request->filled('registration_no')) {
            $query->where(function ($q) use ($request) {
                $q->where('registration_no', $request->registration_no)
                    ->orWhere('mobile_no', $request->registration_no)
                    ->orWhere('identity_no', $request->registration_no);
            });
        }

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
            });
        }

        /* Location Filters */
        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        /* Filter only those with matching surveys */
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

            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        });

        $beneficiarie = $query->orderBy('id', 'desc')->get();

        /* Dropdown values */
        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view(
            'ngo.beneficiarie.distributed-facilities-list',
            compact('beneficiarie', 'data', 'categories', 'category')
        );
    }


    public function pendingfacilities(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->whereIn('status', ['Pending', 'Reject'])
                ->orderBy('updated_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        }])->where('status', 1);

        /* Beneficiarie Search Filters */
        if ($request->filled('application_no')) {
            $query->where('application_no', $request->application_no);
        }

        if ($request->filled('registration_no')) {
            $query->where(function ($q) use ($request) {
                $q->where('registration_no', $request->registration_no)
                    ->orWhere('mobile_no', $request->registration_no)
                    ->orWhere('identity_no', $request->registration_no);
            });
        }

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
            });
        }

        /* Filter only beneficiaries with matching surveys */
        $beneficiarie = $query->whereHas('surveys', function ($q) use ($request) {
            $q->whereIn('status', ['Pending', 'Reject'])
                ->orderBy('created_at', 'asc');

            if ($request->session_filter) {
                $q->where('academic_session', $request->session_filter);
            }

            if ($request->category_filter) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        })
            ->orderBy('id', 'desc')
            ->get();

        /* Dropdowns / Filters */
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');
        $category = Category::orderBy('category', 'asc')->get();

        return view(
            'ngo.beneficiarie.reject-facilities-list',
            compact('beneficiarie', 'data', 'categories', 'category')
        );
    }


    public function allbeneficiarielist(Request $request)
    {
        $query = Beneficiarie::with(['surveys' => function ($q) use ($request) {
            $q->where('status', 'Distributed')->orderBy('updated_at', 'asc');

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
            if ($request->bene_category) {
                $q->where('bene_category', $request->bene_category);
            }
        });

        $beneficiarie = $query->orderBy('id', 'desc')->get();

        // Filters for the view
        $data = academic_session::all();
        $categories = Beneficiarie_Survey::select('facilities_category')->distinct()->pluck('facilities_category');

        return view('ngo.beneficiarie.all-beneficiarie-list', compact('beneficiarie', 'data', 'categories'));
    }

    public function deleteBeneficiarieFacilitiesAll($beneficiarie_id, $survey_id)
    {
        try {
            $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
                ->where('id', $survey_id)
                ->firstOrFail();

            $survey->delete();

            logWork(
                'Facilities',
                $survey->id,
                'Beneficiarie Facilities & Distribution Reset',
                'All facility, distribution, and status fields Deleted'
            );

            return redirect()
                ->back()
                ->with('success', 'Facilities and distribution data delete successfully.');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'error' => 'Failed to reset facilities and distribution data.'
            ]);
        }
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

    public function showbeneficiarietoken(Request $request)
    {
        $surveyFilter = function ($q) use ($request) {
            $q->where('status', '0')
                ->orderBy('updated_at', 'asc');

            if ($request->filled('session_filter')) {
                $q->where('session_date', $request->session_filter);
            }

            if ($request->filled('category_filter')) {
                $q->where('facilities_category', $request->category_filter);
            }

            if ($request->filled('distribute_date')) {
                $q->whereDate('distribute_date', $request->distribute_date);
            }

            if ($request->filled('bene_category')) {
                $q->where('bene_category', $request->bene_category);
            }
        };

        /* Main Query */
        $query = beneficiarie::where('status', 1)
            ->whereHas('surveys', $surveyFilter)
            ->with(['surveys' => $surveyFilter]);

        /* Beneficiarie Search Filters */
        if ($request->filled('application_no')) {
            $query->where('application_no', $request->application_no);
        }

        if ($request->filled('registration_no')) {
            $query->where(function ($q) use ($request) {
                $q->where('registration_no', $request->registration_no)
                    ->orWhere('mobile_no', $request->registration_no)
                    ->orWhere('identity_no', $request->registration_no);
            });
        }

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('gurdian_name', 'like', '%' . $request->name . '%');
            });
        }

        /* Location Filters */
        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        /* Fetch Data */
        $beneficiarie = $query->orderBy('id', 'asc')
            ->get();

        /* Supporting Data */
        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();

        $categories = Beneficiarie_Survey::where('status', '0')
            ->select('facilities_category')
            ->distinct()
            ->pluck('facilities_category');

        $staff = Staff::get();
        $signatures = Signature::pluck('file_path', 'role');
        $tokenCounter = 1;

        foreach ($beneficiarie as $beneficiary) {
            foreach ($beneficiary->surveys as $survey) {
                $survey->token_no = $tokenCounter++;
            }
        }
        return view(
            'ngo.beneficiarie.token',
            compact('beneficiarie', 'data', 'categories', 'category', 'staff', 'signatures')
        );
    }

    public function showbeneficiarieRecipt($beneficiarie_id, $survey_id)
    {
        $survey = Beneficiarie_Survey::where('beneficiarie_id', $beneficiarie_id)
            ->where('id', $survey_id)
            ->with('beneficiarie')
            ->firstOrFail();
        $beneficiarie = beneficiarie::with('surveys')->where('status', 1)->find($beneficiarie_id);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.beneficiarie.recipt', compact('beneficiarie', 'survey', 'signatures'));
    }
}
