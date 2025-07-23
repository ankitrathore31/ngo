<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Problem;
use App\Models\Signature;
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

    public function StoreProblem(Request $request)
    {
        // Validate incoming request
        $validate = $request->validate([
            'problem_no' => 'required|string|unique:problems',
            'problem_date' => 'required|date',
            'session' => 'required|string',
            'address' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'description' => 'required|string',
            'problem_by' => 'required|string',
        ]);


        $problem = new Problem();
        $problem->problem_no = $validate['problem_no'];
        $problem->problem_date = $validate['problem_date'];
        $problem->academic_session = $validate['session'];
        $problem->address = $validate['address'];
        $problem->block = $validate['block'];
        $problem->state = $validate['state'];
        $problem->district = $validate['district'];
        $problem->description = $validate['description'];
        $problem->problem_by = $validate['problem_by'];
        $problem->status = 0;

        $problem->save();

        return redirect()->route('problem.list')->with('success', 'Social Problem Discovred. ');
    }

    public function EditProblem($id)
    {
        $data = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        $problem = Problem::findorFail($id);
        return view('ngo.problem.edit-problem', compact('data', 'states', 'staff','problem'));
    }

    public function UpdateProblem(Request $request,$id)
    {
        // Validate incoming request
        $validate = $request->validate([
            'problem_no' => 'required|string|unique:problems,problem_no,'. $id,
            'problem_date' => 'required|date',
            'session' => 'required|string',
            'address' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'description' => 'required|string',
            'problem_by' => 'required|string',
        ]);


        $problem = Problem::findorFail($id);
        $problem->problem_no = $validate['problem_no'];
        $problem->problem_date = $validate['problem_date'];
        $problem->academic_session = $validate['session'];
        $problem->address = $validate['address'];
        $problem->block = $validate['block'];
        $problem->state = $validate['state'];
        $problem->district = $validate['district'];
        $problem->description = $validate['description'];
        $problem->problem_by = $validate['problem_by'];
        $problem->status = 0;

        $problem->save();

        return redirect()->route('problem.list')->with('success', 'Social Problem Updated. ');
    }

     public function DeleteProblem(Request $request,$id)
    {
        $problem = Problem::findorFail($id);
        $problem->delete();

        return redirect()->back()->with('success', 'Social Problem Deleted. ');
    }

    public function ProblemList(Request $request)
    {
        $session = academic_session::all();
        $states = config('states');
        $staffList = Staff::all()->keyBy('id');
        $records = Problem::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('problem_date'), fn($q) => $q->where('problem_date', $request->problem_date))
            ->when($request->filled('problem_no'), fn($q) => $q->where('problem_no', 'like', '%' . $request->problem_no . '%'))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('block'), fn($q) => $q->where('blcok', 'like', '%' . $request->block . '%'))
            ->where('status', 0)
            ->get();

        return view('ngo.problem.problem-list', compact('session', 'records', 'staffList'));
    }

    public function ListForSolution(Request $request)
    {
        $session = academic_session::all();
        $states = config('states');
        $staffList = Staff::all()->keyBy('id');
        $records = Problem::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('problem_date'), fn($q) => $q->where('problem_date', $request->problem_date))
            ->when($request->filled('problem_no'), fn($q) => $q->where('problem_no', 'like', '%' . $request->problem_no . '%'))
            ->when($request->filled('problem_by'), fn($q) => $q->where('problem_by', $request->problem_by))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('block'), fn($q) => $q->where('blcok', 'like', '%' . $request->block . '%'))
            ->where('status', 0)
            ->get();

        return view('ngo.problem.list-for-solution', compact('session', 'records', 'staffList'));
    }

    public function Solution($id)
    {
        $data = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        $problem = Problem::findorFail($id);
        return view('ngo.problem.solution', compact('data', 'states', 'staff', 'problem'));
    }

    public function StoreSolution(Request $request, $id)
    {
        // Validate incoming request
        $validate = $request->validate([
            'solution_date' => 'required|date',
            'solution_description' => 'required|string',
            'solution_by' => 'required|string',
        ]);


        $solution = Problem::findorFail($id);
        $solution->solution_date = $validate['solution_date'];
        $solution->solution_description = $validate['solution_description'];
        $solution->solution_by = $validate['solution_by'];
        $solution->status = 1;

        $solution->save();

        return redirect()->route('solution.list')->with('success', 'Social Problem Solved. ');
    }

     public function EditSolution($id)
    {
        $data = academic_session::all();
        $states = config('states');
        $staff = Staff::get();
        $problem = Problem::findorFail($id);
        return view('ngo.problem.edit-solution', compact('data', 'states', 'staff', 'problem'));
    }

    public function UpdateSolution(Request $request, $id)
    {
        // Validate incoming request
        $validate = $request->validate([
            'solution_date' => 'required|date',
            'solution_description' => 'required|string',
            'solution_by' => 'required|string',
        ]);


        $solution = Problem::findorFail($id);
        $solution->solution_date = $validate['solution_date'];
        $solution->solution_description = $validate['solution_description'];
        $solution->solution_by = $validate['solution_by'];
        $solution->status = 1;

        $solution->save();

        return redirect()->route('solution.list')->with('success', 'Social Problem solution Updated. ');
    }

    public function DeleteSolution(Request $request, $id)
    {
        $solution = Problem::findorFail($id);
        $solution->solution_date = null;
        $solution->solution_description = null;
        $solution->solution_by = null;
        $solution->status = 0;

        $solution->save();

        return redirect()->back()->with('success', 'Social Problem solution Deleted. ');
    }

    public function SolutionList(Request $request)
    {
        $session = academic_session::all();
        $states = config('states');

        // Load all staff records and map them by ID
        $staffList = Staff::all()->keyBy('id'); // [id => Staff instance]

        $records = Problem::query()
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('problem_date'), fn($q) => $q->where('problem_date', $request->problem_date))
            ->when($request->filled('problem_by'), fn($q) => $q->where('problem_by', $request->problem_by))
            ->when($request->filled('problem_no'), fn($q) => $q->where('problem_no', 'like', '%' . $request->problem_no . '%'))
            ->when($request->filled('solution_by'), fn($q) => $q->where('solution_by', $request->solution_by))
            ->when($request->filled('state'), fn($q) => $q->where('state', 'like', '%' . $request->state . '%'))
            ->when($request->filled('district'), fn($q) => $q->where('district', 'like', '%' . $request->district . '%'))
            ->when($request->filled('block'), fn($q) => $q->where('blcok', 'like', '%' . $request->block . '%'))
            ->where('status', 1)
            ->get();

        return view('ngo.problem.solution-list', compact('session', 'records', 'staffList'));
    }

    public function ViewProblem($id){
        $staffList = Staff::all()->keyBy('id'); // [id => Staff instance]
        $record = Problem::findorFail($id);
        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.problem.view-problem',compact('signatures','staffList','record'));
    }
}
