<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Union;
use Illuminate\Http\Request;

class UnionController extends Controller
{

    public function AddUnion()
    {
        $data = academic_session::all();
        $states = config('states');

        $lastUnion = Union::orderBy('id', 'desc')->first();

        if ($lastUnion && $lastUnion->union_no) {

            // Remove UIDN prefix (4 characters)
            $lastNumber = intval(substr($lastUnion->union_no, 4));

            $nextNumber = $lastNumber + 1;

            // UIDN + 4 digit padded number
            $nextUnionNo = 'UIDN' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } else {

            $nextUnionNo = 'UIDN0001';
        }

        return view(
            'ngo.union.add-union',
            compact('data', 'states', 'nextUnionNo')
        );
    }

    public function StoreUnion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'union_no' => 'required|unique:unions,union_no',
            'academic_session' => 'required',
            'formation_date' => 'nullable|date',
            'state' => 'required',
            'district' => 'required',
        ]);

        Union::create([
            'name' => $request->name,
            'union_no' => $request->union_no,
            'union_certificate_format' => $request->union_certificate_format,
            'academic_session' => $request->academic_session,
            'formation_date' => $request->formation_date,
            'area_type' => $request->area_type,
            'address' => $request->address,
            'block' => $request->block,
            'state' => $request->state,
            'district' => $request->district,
        ]);

        return redirect()->route('union.list')
            ->with('success', 'Union Created Successfully');
    }

    public function EditUnion($id)
    {
        $union = Union::findOrFail($id);
        $data = academic_session::all();
        $states = config('states');

        return view(
            'ngo.union.edit-union',
            compact('union', 'data', 'states')
        );
    }

    public function UpdateUnion(Request $request, $id)
    {
        $union = Union::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'academic_session' => 'required',
            'formation_date' => 'nullable|date',
            'state' => 'required',
            'district' => 'required',
        ]);

        $union->update([
            'name' => $request->name,
            'union_certificate_format' => $request->union_certificate_format,
            'academic_session' => $request->academic_session,
            'formation_date' => $request->formation_date,
            'area_type' => $request->area_type,
            'address' => $request->address,
            'block' => $request->block,
            'state' => $request->state,
            'district' => $request->district,
        ]);

        return redirect()->route('union.list')
            ->with('success', 'Union Updated Successfully');
    }

    public function DeleteUnion($id)
    {
        $union = Union::findOrFail($id);
        $union->delete();

        return redirect()->back()
            ->with('success', 'Union Deleted Successfully');
    }

    public function ListUnion(Request $request)
    {
        $query = Union::query();

        // Search Filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('union_no')) {
            $query->where('union_no', 'like', '%' . $request->union_no . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('area_type')) {
            $query->where('area_type', $request->area_type);
        }

        if ($request->filled('academic_session')) {
            $query->where('academic_session', $request->academic_session);
        }

        $unions = $query->get();

        $states = config('districts');

        return view('ngo.union.list-union', compact('unions', 'states'));
    }
}
