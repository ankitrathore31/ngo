<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\BudgetItem;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectReport;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function AddProject()
    {
        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.project.add-project', compact('data','category'));
    }

    public function StoreProject(Request $request)
    {
        $validated = $request->validate([
            'session' => 'required',
            'code' => 'required|string|unique:projects',
            'name' => 'required|string',
            'category' => 'required|string',
            'sub_category' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        Project::create([
            'academic_session' => $validated['session'],
            'code' => $validated['code'],
            'name' => $validated['name'],
            'category' => $validated['category'],
            'sub_category' => $validated['sub_category'],
            'image' => $imagePath,
        ]);

        return redirect()->route('list.project')->with('success', 'Project Added Successfully. ');
    }

    public function EditProject($id)
    {
        $project = Project::findorFail($id);
        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.project.edit-project', compact('data', 'project','category'));
    }

    public function UpdateProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'session' => 'required',
            'code' => 'required|string|unique:projects,code,' . $id,
            'name' => 'required|string',
            'category' => 'required|string',
            'sub_category' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image && File::exists(public_path($project->image))) {
                File::delete(public_path($project->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $project->image = 'images/' . $imageName;
        }

        $project->update([
            'session' => $validated['session'],
            'code' => $validated['code'],
            'name' => $validated['name'],
            'category' => $validated['category'],
            'sub_category' => $validated['sub_category'],
            'image' => $project->image,
        ]);

        return redirect()->route('list.project')->with('success', 'Project Update Successfully. ');
    }

    public function DeleteProject($id)
    {
        $project = Project::with('reports.items')->findOrFail($id);

        foreach ($project->reports as $report) {
            $report->items()->delete();
            $report->delete();
        }

        if ($project->image && File::exists(public_path($project->image))) {
            File::delete(public_path($project->image));
        }

        $project->delete();

        return redirect()->route('list.project')
            ->with('success', 'Project and its reports deleted successfully!');
    }


    public function ViewProject($id)
    {
        $project = Project::findorFail($id);
        return view('ngo.project.view-project', compact('project'));
    }

    public function ProjectList(Request $request)
    {
        $query = Project::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->category_filter) {
            $query->where('category', $request->category_filter);
        }
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $project = $query->get();
        $data = academic_session::all();
        $category = Category::orderBy('category', 'asc')->get();
        return view('ngo.project.project-list', compact('data', 'project','category'));
    }

    public function AddProjectReport($id)
    {
        $project = Project::findorFail($id);
        $data = academic_session::all();
        return view('ngo.project.add-report', compact('data', 'project'));
    }

    public function StoreProjectReport(Request $request)
    {
        $report = ProjectReport::create([
            'academic_session'   => $request->session,
            'project_id'         => $request->project_id,
            'report'               => $request->report,
            'mission'               => $request->mission,
            'conclusion'             => $request->conclusion,
        ]);
        foreach ($request->items as $item) {
            BudgetItem::create([
                'report_id' => $report->id,
                'category' => $item['category'] ?? null,
                'expense' => $item['expense'] ?? null,
                'details' => $item['details'] ?? null,
            ]);
        }

        return redirect()->route('list.project.report')->with('success', 'Report saved successfully!');
    }

    public function EditProjectReport($id)
    {
        $report = ProjectReport::with('items')->findOrFail($id);
        $signatures = Signature::pluck('file_path', 'role');
        $data = academic_session::all();
        return view('ngo.project.edit-report', compact('data', 'report', 'signatures'));
    }

    public function UpdateProjectReport(Request $request, $id)
    {
        $report = ProjectReport::findorFail($id);

        $report->update([
            'academic_session'   => $request->session,
            // 'project_id'         => $request->project_id,
            'report'               => $request->report,
            'mission'               => $request->mission,
            'conclusion'             => $request->conclusion,
        ]);

        $report->items()->delete();
        foreach ($request->items as $item) {
            $report->items()->create($item);
        }

        return redirect()->route('list.project.report')->with('success', 'Report update successfully!');
    }

    public function DeleteProjectReport(Request $request, $id)
    {
        $report = ProjectReport::findorFail($id);
        $report->items()->delete();
        $report->delete();
        return redirect()->back()->with('success', 'Report deleted successfully!');
    }

    public function ProjectReportList(Request $request)
    {
        $query = Project::query();
        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->category_filter) {
            $query->where('category', $request->category_filter);
        }
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $query->whereHas('reports');
        $project = $query->with('reports')->get();
        // $budgetItems = BudgetItem::where()
        $data = academic_session::all();
        return view('ngo.project.report-list', compact('data', 'project'));
    }

    public function ViewProjectReport($id)
    {
        // Get project
        $project = Project::findOrFail($id);

        // Get project report
        $report = ProjectReport::where('project_id', $project->id)->firstOrFail();

        // Get budget items related to this report
        $budgetItems = BudgetItem::where('report_id', $report->id)->get();

        // Get signatures (role => file_path)
        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.project.view-report', compact('report', 'project', 'budgetItems', 'signatures'));
    }
}
