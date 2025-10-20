<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Category;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Project;
use App\Models\Signature;
use App\Models\SurveyBenefries;
use App\Models\WorkLog;
use App\Models\WorkPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffWorkController extends Controller
{
    public function WorkList(Request $request)
    {
        $user = Auth::user();
        $date_from = $request->input('date_from', now()->toDateString());
        $date_to = $request->input('date_to', now()->toDateString());
        $session = academic_session::all();

        $query = WorkLog::query();

        // Role-based filter
        if ($user->user_type === 'staff') {
            $query->where('user_id', $user->id);
        } else {
            if ($request->user_filter === 'staff') {
                $query->where('user_type', 'staff');
            } elseif ($request->user_filter === 'ngo') {
                $query->where('user_type', 'ngo');
            }

            $query->when($request->name, fn($q) => $q->where('user_name', 'like', '%' . $request->name . '%'));
            $query->when($request->code, fn($q) => $q->where('user_code', 'like', '%' . $request->code . '%'));
        }

        // Date range filter
        $query->whereBetween('work_date', [$date_from, $date_to]);

        // Session filter (optional)
        $query->when($request->session_filter, fn($q) => $q->where('work_date', 'like', '%' . $request->session_filter . '%'));

        $logs = $query
            ->orderBy('user_name')
            ->orderByDesc('work_date')
            ->get()
            ->groupBy('user_name');

        // Stats
        if ($user->user_type === 'staff') {
            $totalLogs = WorkLog::where('user_id', $user->id)->count();
            $todayLogs = WorkLog::where('user_id', $user->id)->whereDate('work_date', now())->count();
        } else {
            $totalLogs = WorkLog::count();
            $todayLogs = WorkLog::whereDate('work_date', now())->count();
        }

        return view('ngo.staff-work.staff-work-list', compact('logs', 'date_from', 'date_to', 'session', 'user', 'totalLogs', 'todayLogs'));
    }


    public function Survey()
{
    $user = Auth::user();
    $states = config('states');
    $data = academic_session::all();

    // Determine user info
    if ($user->user_type === 'ngo') {
        $user_name = $user->name;
        $user_code = 'Ngo';
    } elseif ($user->user_type === 'staff') {
        $user_name = $user->staff->name ?? null;
        $user_code = $user->staff->staff_code ?? null;
    }
    $user_id = $user->id;

    // Generate next Survey ID
    $lastSurvey = SurveyBenefries::latest('id')->first();
    $prefix = '3126SID';
    $nextNumber = $lastSurvey ? intval(substr($lastSurvey->survey_id, -7)) + 1 : 1;
    $newSurveyId = sprintf("%s%07d", $prefix, $nextNumber);

    // Combine beneficiaries and members
    $beneficiaries = beneficiarie::all();
    $members = Member::all();
    $record = $beneficiaries->merge($members);

    // Fetch projects with code and category
    $projects = Project::select('id', 'name', 'code', 'category')->get();
    $categories = Category::orderBy('category', 'asc')->get();

    return view('ngo.staff-work.survey', compact(
        'data', 
        'states', 
        'user_name', 
        'user_code', 
        'user_id', 
        'newSurveyId', 
        'record', 
        'projects',
        'categories'
    ));
}


    public function StoreSurvey(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'user_id'        => 'required',
                'category'         =>'required|string',
                'project_code'   => 'required|string|max:255',
                'project_name'   => 'required|string|max:255',
                'center'         => 'required|string|max:255',
                'animator_code'  => 'required|string|max:255',
                'animator_name'  => 'required|string|max:255',
                'session'        => 'required|string',
                'date'           => 'required|date',
                'beneficiaries'  => 'required|array|min:1',
                'beneficiaries.*.survey_id'     => 'required|string',
                'beneficiaries.*.mobile_no'     => 'required|digits:10',
                'beneficiaries.*.beneficiaries_type' => 'required|string',
            ], [
                'beneficiaries.required' => 'Please add at least one beneficiary.',
                'beneficiaries.min' => 'Please add at least one beneficiary.',
                'beneficiaries.*.mobile_no.required' => 'Mobile number is required for all beneficiaries.',
                'beneficiaries.*.mobile_no.digits' => 'Mobile number must be 10 digits.',
                'beneficiaries.*.beneficiaries_type.required' => 'Scheme type is required for all beneficiaries.',
            ]);

            // Common data for all beneficiaries
            $commonData = [
                'user_id'       => $request->user_id,
                'category'      =>$request->category,
                'project_code'  => $request->project_code,
                'project_name'  => $request->project_name,
                'center'        => $request->center,
                'animator_code' => $request->animator_code,
                'animator_name' => $request->animator_name,
                'session'       => $request->session,
                'date'          => $request->date,
            ];

            $insertData = [];

            foreach ($request->beneficiaries as $ben) {
                // Skip if essential fields are missing
                if (empty($ben['mobile_no']) || empty($ben['beneficiaries_type']) || empty($ben['survey_id'])) {
                    continue;
                }

                // Merge common data with beneficiary-specific data
                $insertData[] = array_merge($commonData, [
                    'survey_id'                => $ben['survey_id'] ?? null,
                    'identity_type'            => $ben['identity_type'] ?? null,
                    'identity_no'              => $ben['identity_no'] ?? null,
                    'name'                     => $ben['name'] ?? null,
                    'father_husband_name'      => $ben['father_husband_name'] ?? null,
                    'state'                    => $ben['state'] ?? null,
                    'district'                 => $ben['district'] ?? null,
                    'area_type'                => $ben['area_type'] ?? null,
                    'block'                    => $ben['block'] ?? null,
                    'post_town'                => $ben['post_town'] ?? null,
                    'address'                  => $ben['address'] ?? null,
                    'mobile_no'                => $ben['mobile_no'] ?? null,
                    'caste'                    => $ben['caste'] ?? null,
                    'caste_category'           => $ben['caste_category'] ?? null,
                    'age'                      => $ben['age'] ?? null,
                    'beneficiaries_type'       => $ben['beneficiaries_type'] ?? null,
                    'disability_percentage'    => $ben['disability_percentage'] ?? null,
                    'widow_since'              => $ben['widow_since'] ?? null,
                    'type_of_victim'           => $ben['type_of_victim'] ?? null,
                    'class_name'               => $ben['class_name'] ?? null,
                    'death_date'               => $ben['death_date'] ?? null,
                    'labour_card_no'           => $ben['labour_card_no'] ?? null,
                    'labour_card_date'         => $ben['labour_card_date'] ?? null,
                    'land'                     => $ben['land'] ?? null,
                    'remark'                   => $ben['remark'] ?? null,
                    'place_identification_mark' => $ben['place_identification_mark'] ?? null,
                    'created_at'               => now(),
                    'updated_at'               => now(),
                ]);
            }

            // Insert data if available
            if (!empty($insertData)) {
                SurveyBenefries::insert($insertData);

                // ✅ Added logWork() for survey_id and name
                $surveyDetails = collect($request->beneficiaries)
                    ->map(function ($b) {
                        return 'Survey ID: ' . ($b['survey_id'] ?? '-') . ' | Name: ' . ($b['name'] ?? '-');
                    })
                    ->implode(' || ');

                logWork(
                    'Survey',
                    null,
                    'New Survey Entry',
                    'Added ' . count($insertData) . ' beneficiary record(s) for project: ' . $request->project_name .
                        ' — ' . $surveyDetails
                );

                return redirect()->route('survey.list')
                    ->with('success', '✅ ' . count($insertData) . ' beneficiary/beneficiaries saved successfully!');
            } else {
                return redirect()->back()
                    ->with('error', '⚠️ No valid beneficiary data to save.')
                    ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', '⚠️ Please fix the validation errors.');
        } catch (\Exception $e) {
            \Log::error('Survey Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', '❌ An error occurred while saving: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function SurveyList(Request $request)
    {
        $user = Auth::user();

        $date_from = $request->input('date_from', now()->toDateString());
        $date_to = $request->input('date_to', now()->toDateString());

        // Base query depending on user type
        if ($user->user_type === 'ngo') {
            $query = SurveyBenefries::query();
        } else {
            $query = SurveyBenefries::where('user_id', $user->id);
        }

        // 🔹 Apply search filters only if filled
        if ($request->filled('session_filter')) {
            $query->where('session', $request->session_filter);
        }

        // ✅ Date range filter (default: today)
        $query->whereBetween('date', [$date_from, $date_to]);

        if ($request->filled('user_filter')) {
            if ($request->user_filter === 'ngo') {
                $query->where('animator_code', 'Ngo');
            } elseif ($request->user_filter === 'staff') {
                $query->where('animator_code', '!=', 'Ngo');
            }
        }

        if ($request->filled('name')) {
            $query->where('animator_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code')) {
            $query->where('animator_code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        // Get the filtered results
        $surveys = $query->latest()->get();

        // Additional data for filters
        $session = academic_session::all();

        return view('ngo.staff-work.survey-list', compact('surveys', 'user', 'session', 'date_from', 'date_to'));
    }


    public function ViewSurvey($id)
    {
        $survey = SurveyBenefries::findOrFail($id);
        return view('ngo.staff-work.show-survey', compact('survey'));
    }

    public function editSurvey($id)
    {
        try {
            $survey = SurveyBenefries::findOrFail($id);
            $data = academic_session::all();

            return view('ngo.staff-work.edit-survey', compact('survey', 'data'));
        } catch (\Exception $e) {
            return redirect()->route('survey.list')
                ->with('error', '❌ Survey not found.');
        }
    }

    // Update Survey
    public function UpdateSurvey(Request $request, $id)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'user_id'                  => 'required',
                'project_code'             => 'required|string|max:255',
                'project_name'             => 'required|string|max:255',
                'center'                   => 'required|string|max:255',
                'animator_code'            => 'required|string|max:255',
                'animator_name'            => 'required|string|max:255',
                'session'                  => 'required|string',
                'date'                     => 'required|date',
                'survey_id'                => 'required|string',
                'identity_type'            => 'required|string',
                'identity_no'              => 'required|string',
                'name'                     => 'required|string|max:255',
                'father_husband_name'      => 'required|string|max:255',
                'state'                    => 'required|string',
                'district'                 => 'required|string',
                'area_type'                => 'required|string',
                'address'                  => 'required|string',
                'mobile_no'                => 'required|digits:10',
                'caste_category'           => 'required|string',
                'age'                      => 'required|integer|min:1|max:120',
                'beneficiaries_type'       => 'required|string',
                'block'                    => 'nullable|string',
                'post_town'                => 'nullable|string',
                'caste'                    => 'nullable|string',
                'disability_percentage'    => 'nullable|numeric|min:0|max:100',
                'widow_since'              => 'nullable|string',
                'type_of_victim'           => 'nullable|string',
                'class_name'               => 'nullable|string',
                'death_date'               => 'nullable|date',
                'labour_card_no'           => 'nullable|string',
                'labour_card_date'         => 'nullable|date',
                'land'                     => 'nullable|string',
                'remark'                   => 'nullable|string',
                'place_identification_mark' => 'nullable|string',
            ], [
                'mobile_no.required' => 'Mobile number is required.',
                'mobile_no.digits'   => 'Mobile number must be 10 digits.',
                'name.required'      => 'Name is required.',
                'age.required'       => 'Age is required.',
                'age.min'            => 'Age must be at least 1.',
                'age.max'            => 'Age cannot be more than 120.',
            ]);

            // Find and update survey
            $survey = SurveyBenefries::findOrFail($id);

            $survey->update([
                'user_id'                  => $request->user_id,
                'project_code'             => $request->project_code,
                'project_name'             => $request->project_name,
                'center'                   => $request->center,
                'animator_code'            => $request->animator_code,
                'animator_name'            => $request->animator_name,
                'session'                  => $request->session,
                'date'                     => $request->date,
                'survey_id'                => $request->survey_id,
                'identity_type'            => $request->identity_type,
                'identity_no'              => $request->identity_no,
                'name'                     => $request->name,
                'father_husband_name'      => $request->father_husband_name,
                'state'                    => $request->state,
                'district'                 => $request->district,
                'area_type'                => $request->area_type,
                'block'                    => $request->block,
                'post_town'                => $request->post_town,
                'address'                  => $request->address,
                'mobile_no'                => $request->mobile_no,
                'caste'                    => $request->caste,
                'caste_category'           => $request->caste_category,
                'age'                      => $request->age,
                'beneficiaries_type'       => $request->beneficiaries_type,
                'disability_percentage'    => $request->disability_percentage,
                'widow_since'              => $request->widow_since,
                'type_of_victim'           => $request->type_of_victim,
                'class_name'               => $request->class_name,
                'death_date'               => $request->death_date,
                'labour_card_no'           => $request->labour_card_no,
                'labour_card_date'         => $request->labour_card_date,
                'land'                     => $request->land,
                'remark'                   => $request->remark,
                'place_identification_mark' => $request->place_identification_mark,
            ]);

            return redirect()->route('survey.list')
                ->with('success', '✅ Survey updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', '⚠️ Please fix the validation errors.');
        } catch (\Exception $e) {
            \Log::error('Survey Update Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', '❌ An error occurred while updating: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function SurveyDelete($id)
    {

        $survey = SurveyBenefries::findOrFail($id);
        $survey->delete();
        return redirect()->route('survey.list')->with('success', 'Survey deleted successfully.');
    }

    public function checkIdentity(Request $request)
    {
        $identity = $request->identity_no;
        $beneficiary = SurveyBenefries::where('identity_no', $identity)->first();

        if ($beneficiary) {
            $person = $beneficiary;
            return response()->json([
                'exists' => true,
                'message' => '❌ Identity Number already registered.',
                'name' => $person->name ?? '',
                'survey_id' => $person->survey_id ?? '',
                'father_husband_name' => $person->father_husband_name ?? '',
                'animator_name' => $person->animator_name ?? ''
            ]);
        }

        return response()->json([
            'exists' => false,
            'message' => '✅ Identity Number available.',
            'name' => null,
            'survey_id' => null,
            'father_husband_name' => null,
            'animator_name' => null
        ]);
    }
}
