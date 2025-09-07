<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Plan;
use App\Models\Signature;
use App\Models\WorkPlan;
use Illuminate\Http\Request;

class StaffWorkController extends Controller
{
    public function WorkList(Request $request)
    {
        $session = academic_session::all();

        $records = WorkPlan::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('date'), fn($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('project_code'), fn($q) => $q->where('project_code', 'like', '%' . $request->project_code . '%'))
            ->when($request->filled('project_name'), fn($q) => $q->where('project_name', 'like', '%' . $request->project_name . '%'))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'));

        if (auth()->user()->role == 'staff') {
            $records->where('animator_code', auth()->user()->staff_code);
        }

        $records = $records->orderBy('created_at', 'desc')->get();

        return view('ngo.staff-work.work-list', compact('session', 'records'));
    }

    public function WorkView($id)
    {
        $workplan = WorkPlan::find($id);
        $work_id = $workplan->id;

        $plans = Plan::where('workplan_id', $work_id)->get();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.staff-work.view-work', compact('workplan', 'plans', 'signatures'));
    }
}
