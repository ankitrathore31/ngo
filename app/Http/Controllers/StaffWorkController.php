<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Plan;
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
        $date = $request->input('date', now()->toDateString());
        $session = academic_session::all();

        // ✅ Base query
        $query = WorkLog::query();

        // 🧠 Role-based filter
        if ($user->user_type === 'staff') {
            // Staff see only their own logs
            $query->where('user_id', $user->id);
        } else {
            // NGO/Admin filters
            if ($request->user_filter === 'staff') {
                $query->where('user_type', 'staff');
            } elseif ($request->user_filter === 'ngo') {
                $query->where('user_type', 'ngo');
            } // else show all by default

            $query->when($request->name, fn($q) => $q->where('user_name', 'like', '%' . $request->name . '%'));
            $query->when($request->code, fn($q) => $q->where('user_code', 'like', '%' . $request->code . '%'));
        }

        // 🗓️ Common filters
        $query->when($request->date, fn($q) => $q->whereDate('work_date', $request->date));
        $query->when($request->session_filter, fn($q) => $q->where('work_date', 'like', '%' . $request->session_filter . '%'));

        // 📋 Fetch logs
        $logs = $query
            ->orderBy('user_name')
            ->orderByDesc('work_date')
            ->get()
            ->groupBy('user_name');

        // 📊 Stats
        if ($user->user_type === 'staff') {
            $totalLogs = WorkLog::where('user_id', $user->id)->count();
            $todayLogs = WorkLog::where('user_id', $user->id)->whereDate('work_date', now())->count();
        } else {
            $totalLogs = WorkLog::count();
            $todayLogs = WorkLog::whereDate('work_date', now())->count();
        }

        return view('ngo.staff-work.staff-work-list', compact('logs', 'date', 'session', 'user', 'totalLogs', 'todayLogs'));
    }

    public function Survey()
    {
        $states = config('states');
        $data = academic_session::all();
        $user = Auth::user();
        $user_id = $user->id;
        $user_name = null;
        $user_code = null;

        if ($user->user_type == 'ngo') {
            $user_name = $user->name;
            $user_code = 'Ngo';
        } elseif ($user->user_type == 'staff') {
            $user_name = $user->staff->name;
            $user_code = $user->staff->staff_code;
        }

        return view('ngo.staff-work.survey', compact('data', 'states', 'user_name', 'user_code', 'user_id'));
    }

    public function StoreSurvey(Request $request)
    {
        // Debug: See all request data
        // dd([
        //     'all_data' => $request->all(),
        //     'beneficiaries' => $request->input('beneficiaries'),
        //     'has_beneficiaries' => $request->has('beneficiaries'),
        //     'all_keys' => array_keys($request->all())
        // ]);

        $request->validate([
            'user_id'      => 'required',
            'project_code' => 'required',
            'project_name' => 'required',
            'center' => 'required',
            'state' => 'required',
            'district' => 'required',
            'animator_code' => 'required',
            'animator_name' => 'required',
            'session' => 'required',
            'date' => 'required|date',
            'beneficiaries' => 'required|array|min:1',
        ]);

        foreach ($request->beneficiaries as $ben) {
            SurveyBenefries::create(array_merge($ben, [
                'user_id'      => $request->user_id,
                'project_code' => $request->project_code,
                'project_name' => $request->project_name,
                'center' => $request->center,
                'state' => $request->state,
                'district' => $request->district,
                'animator_code' => $request->animator_code,
                'animator_name' => $request->animator_name,
                'session' => $request->session,
                'date' => $request->date,
            ]));
        }

        return redirect()->route('survey.list')->with('success', 'Beneficiaries Survey saved successfully!');
    }
    // Show all surveys
    public function SurveyList(Request $request)
    {
        $user = Auth::user();

        // NGO can see all surveys
        if ($user->user_type === 'ngo') {
            $surveys = SurveyBenefries::latest()->get();
        }
        // Staff can see only their own
        else {
            $surveys = SurveyBenefries::where('user_id', $user->id)->latest()->get();
        }
        $session = academic_session::all();
        $date = $request->input('date', now()->toDateString());
        return view('ngo.staff-work.survey-list', compact('surveys', 'user','session','date'));
    }

    // Show single survey details
    public function show($id)
    {
        $survey = SurveyBenefries::findOrFail($id);
        return view('survey.survey_view', compact('survey'));
    }

    // Edit survey
    public function edit($id)
    {
        $survey = SurveyBenefries::findOrFail($id);
        return view('survey.survey_edit', compact('survey'));
    }

    // Delete survey (Only NGO)
    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->user_type !== 'ngo') {
            return redirect()->back()->with('error', 'You are not authorized to delete surveys.');
        }

        $survey = SurveyBenefries::findOrFail($id);
        $survey->delete();

        return redirect()->route('survey.index')->with('success', 'Survey deleted successfully.');
    }
}
