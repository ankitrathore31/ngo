<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Sallary;
use Illuminate\Http\Request;

class SallaryController extends Controller
{
    public function SalaryList()
    {
        $salary = Sallary::get();
        return view('ngo.salary.salary-list',compact('salary'));
    }

    public function ManageSalary()
    {
        $position = Position::orderBy('position', 'asc')->get();
        return view('ngo.salary.manage-salary',compact('position'));
    }

    public function StoreSalary(Request $request){
        $validate = $request->validate([
            'position' => 'required|string|unique:sallaries',
            'salary'   => 'required',
        ]);

        $salary = Sallary::create($validate);
        $salary->save();

        return redirect()->route('list.salary')->with('success', 'Salary Added Successfully. ');
    }

    public function EditSalary($id)
    {
        $salary = Sallary::findorFail($id);
        $position = Position::orderBy('position', 'asc')->get();
        return view('ngo.salary.edit-salary',compact('salary','position'));
    }

    public function UpdateSalary(Request $request,$id){
        $validate = $request->validate([
            'position' => 'required|string|unique:sallaries,position,'.$id,
            'salary'   => 'required',
        ]);

        $salary = Sallary::findorFail($id);
        $salary->update($validate);

        return redirect()->route('list.salary')->with('success', 'Salary Update Successfully. ');
    }

    public function DeleteSalary($id){

        $salary = Sallary::findorFail($id);
        $salary->delete();

        return redirect()->back()->with('success', 'Position Sallary Deleted. ');
    }
}
