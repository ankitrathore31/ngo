<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\Position;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function JobList()
    {
        $jobs = Job::with('position')->latest()->get();
        return view('ngo.job.job-list', compact('jobs'));
    }

    public function AddJob()
    {
        $positions = Position::orderBy('position', 'asc')->get();
        return view('ngo.job.add-job', compact('positions'));
    }

    public function StoreJob(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'position_id' => 'nullable|exists:positions,id',
            'vacancy' => 'required|integer|min:1',
            'job_type' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'status' => 'required|in:active,closed',
        ]);

        Job::create($validated);

        return redirect()->route('list.job')->with('success', 'Job published successfully!');
    }

    public function EditJob($id)
    {
        $job = Job::findOrFail($id);
        $positions = Position::orderBy('position', 'asc')->get();
        return view('ngo.job.edit-job', compact('job', 'positions'));
    }

    public function UpdateJob(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'position_id' => 'nullable|exists:positions,id',
            'vacancy' => 'required|integer|min:1',
            'job_type' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'status' => 'required|in:active,closed',
        ]);

        $job->update($validated);

        return redirect()->route('list.job')->with('success', 'Job updated successfully!');
    }

    public function DeleteJob($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('list.job')->with('success', 'Job deleted successfully!');
    }

    public function Apply($id)
    {
        $job = Job::with('position')->latest()->findorFail($id);

        return view('home.job.apply', compact('job'));
    }

    public function StoreVacancies(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'address'  => 'required|string|max:500',
            'resume'   => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            $file     = $request->file('resume');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('resumes'), $filename); // moves to /public/resumes
            $resumePath = 'resumes/' . $filename; // save relative path in DB
        }

        Candidate::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'position' => $request->position,
            'address'  => $request->address,
            'resume'   => $resumePath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    public function ApplyCandidate(){ 
        $candidate = Candidate::get();
        return view('ngo.job.candidate-list',compact('candidate'));
    }
}
