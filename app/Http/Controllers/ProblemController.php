<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Problem;
use App\Models\Staff;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function Problem()
    {
        $data = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        return view('ngo.problem.add-problem', compact('data', 'states', 'staff'));
    }

    public function ProblemList(Request $request)
    {
        $session = academic_session::all();
        $states = config('states');
        $records = Problem::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('problem_date'), fn($q) => $q->where('problem_date', $request->problem_date))
            ->when($request->filled('problem_no'), fn($q) => $q->where('problem_no', 'like', '%' . $request->problem_no . '%'))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('block'), fn($q) => $q->where('blcok', 'like', '%' . $request->block . '%'))
            ->get();

        return view('ngo.problem.problem-list',compact('session','records'));
    }

}
