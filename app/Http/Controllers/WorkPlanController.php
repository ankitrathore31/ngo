<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Plan;
use App\Models\Signature;
use App\Models\WorkPlan;
use Illuminate\Http\Request;

class WorkPlanController extends Controller
{
    public function AddWorkPlan()
    {
        $states = config('states');
        $data = academic_session::all();
        return view('ngo.workplan.workplan', compact('states', 'data'));
    }

    public function StoreWorkPlan(Request $request)
    {
        // Validate the request (optional but highly recommended)
        $validated = $request->validate([
            'session' => 'required',
            'project_code' => 'required|numeric',
            'project_name' => 'required|string',
            'center' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'animator_code' => 'required|numeric',
            'name' => 'required|string',
            'month_of' => 'required|string',
            'date' => 'required|date',
            'to' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.work_date' => 'required|date',
            'items.*.work_address' => 'required|string',
            'items.*.work_name' => 'required|string',
            'items.*.work_type' => 'required|string',
            'items.*.worker_name' => 'required|string',
            'items.*.work_with' => 'required|string',
            'items.*.benefits' => 'required|string',
        ]);

        // Create main work plan (bill)
        $workplan = WorkPlan::create([
            'academic_session' => $request->session,
            'project_code' => $request->project_code,
            'project_name' => $request->project_name,
            'center' => $request->center,
            'state' => $request->state,
            'district' => $request->district,
            'animator_code' => $request->animator_code,
            'name' => $request->name,
            'month_of' => $request->month_of,
            'date' => $request->date,
            'to' => $request->to,
        ]);

        // Create each work item
        foreach ($request->items as $item) {
            Plan::create([
                'workplan_id' => $workplan->id,
                'work_date' => $item['work_date'],
                'work_address' => $item['work_address'],
                'work_name' => $item['work_name'],
                'work_type' => $item['work_type'],
                'worker_name' => $item['worker_name'],
                'work_with' => $item['work_with'],
                'benefits' => $item['benefits'],
            ]);
        }

        return redirect()->route('workplan-list')->with('success', 'WorkPlan Saved successfully!');
    }


    public function WorkPlanList(Request $request)
    {
        $session = academic_session::all();

        $records = WorkPlan::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('date'), fn($q) => $q->whereDate('date', $request->date))
            ->when($request->filled('project_code'), fn($q) => $q->where('project_code', 'like', '%' . $request->project_code . '%'))
            ->when($request->filled('project_name'), fn($q) => $q->where('project_name', 'like', '%' . $request->project_name . '%'))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ngo.workplan.workplan-list', compact('session', 'records'));
    }


    public function EditWorkPLan($id)
    {
        $workplan = WorkPlan::find($id);

        $work_id = $workplan->id;

        $plans = Plan::where('workplan_id', $work_id)->get();
        $data = academic_session::all();
        return view('ngo.workplan.edit-workplan', compact('data','workplan', 'plans'));
    }

    public function UpdateWorkPlan(Request $request, $id)
    {
        $validated = $request->validate([
            'project_code' => 'required|numeric',
            'project_name' => 'required|string',
            'center' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'animator_code' => 'required|numeric',
            'name' => 'required|string',
            'session' => 'required|string',
            'month_of' => 'required|string',
            'date' => 'required|date',
            'to' => 'required|date',
            'items.*.work_date' => 'required|date',
            'items.*.work_address' => 'required|string',
            'items.*.work_name' => 'required|string',
            'items.*.work_type' => 'required|string',
            'items.*.worker_name' => 'required|string',
            'items.*.work_with' => 'required|string',
            'items.*.benefits' => 'required|string',
        ]);

        $workplan = WorkPlan::findOrFail($id);

        $workplan->update($request->only([
            'project_code',
            'project_name',
            'center',
            'state',
            'district',
            'animator_code',
            'name',
            'session',
            'month_of',
            'date',
            'to'
        ]));

        // Delete existing plans and re-insert
        $workplan->plans()->delete();

        foreach ($request->items as $item) {
            $workplan->plans()->create($item);
        }

        return redirect()->route('workplan-list')->with('success', 'WorkPlan updated successfully!');
    }



    public function ViewWorkPlan($id)
    {
        $workplan = WorkPlan::find($id);

        $work_id = $workplan->id;

        $plans = Plan::where('workplan_id', $work_id)->get();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.workplan.view-workplan', compact('workplan', 'plans', 'signatures'));
    }

    public function DeleteWorkPlan($id)
    {

        $workplan = WorkPlan::find($id);
        $workplan->plans()->delete();
        $workplan->delete();

        return redirect()->back()->with('success', 'WorkPlan Deleted successfully!');
    }
}
