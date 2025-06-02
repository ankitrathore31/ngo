<?php

namespace App\Http\Controllers;

use App\Models\Working_Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\academic_session;
use Carbon\Carbon;

class WorkingAreaController extends Controller
{
    public function workingarea()
    {
        $states = config('states');
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        return view('ngo.workingArea.add-area', compact('states', 'data'));
    }

    public function storeArea(Request $request)
    {

        // echo($request);
        // die();
        $request->validate([
            'area_type' => 'required',
            // 'area' => 'required',
            'academic_session' => 'required',
        ]);

        // Handle state vs other area types
        $areaValue = $request->area_type === 'State' ? $request->state : $request->area;

        // Validate final area value
        if (empty($areaValue)) {
            return redirect()->back()->withErrors(['area' => 'The area field is required.'])->withInput();
        }

        $area = new Working_Area;

        $area->area_type = $request->area_type;
        $area->area = $areaValue;
        $area->academic_session = $request->academic_session;
        $area->save();

        return redirect()->back()->with('success', 'Working Area Saved Successfully');
    }

    public function workingAreaList(Request $request)
    {
        $query = Working_Area::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }

        if ($request->area_filter) {
            $query->where('area_type', $request->area_filter);
        }

        $area = $query->orderBy('area', 'asc')->get();

        $areaTypeCounts = Working_Area::select('area_type', \DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->orderBy('area_type')
            ->get();
        return view('ngo.workingArea.working-area-list', compact('area', 'areaTypeCounts'));
    }

    public function editarea($id)
    {

        $states = config('states');
        $area = Working_Area::find($id);
        $data = academic_session::all()->sortByDesc('session_date');
        Session::put('all_academic_session', $data);
        return view('ngo.workingArea.edit-area', compact('data', 'states', 'area'));
    }

    public function updatearea(request $request, $id)
    {

        $areaValue = $request->area_type === 'State' ? $request->state : $request->area;

        if (empty($areaValue)) {
            return redirect()->back()->withErrors(['area' => 'The area field is required.'])->withInput();
        }

        $area = Working_Area::find($id);

        $area->area_type = $request->area_type;
        $area->area = $areaValue;
        $area->academic_session = $request->academic_session;
        $area->save();

        return redirect()->route('working-area-list')->with('success', 'Working Area Updated Successfully');
    }
    public function removeArea($id)
    {

        $area = Working_Area::find($id);
        $area->delete();

        return redirect()->back()->with('success', 'Working Area Deleted Successfully');
    }
}
