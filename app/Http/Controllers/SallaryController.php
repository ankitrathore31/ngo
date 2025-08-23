<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Position;
use App\Models\SalaryTransaction;
use App\Models\Sallary;
use App\Models\Signature;
use App\Models\Staff;
use Illuminate\Http\Request;

class SallaryController extends Controller
{
    public function SalaryList()
    {
        $salary = Sallary::get();
        return view('ngo.salary.salary-list', compact('salary'));
    }

    public function ManageSalary()
    {
        $position = Position::orderBy('position', 'asc')->get();
        return view('ngo.salary.manage-salary', compact('position'));
    }

    public function StoreSalary(Request $request)
    {
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
        return view('ngo.salary.edit-salary', compact('salary', 'position'));
    }

    public function UpdateSalary(Request $request, $id)
    {
        $validate = $request->validate([
            'position' => 'required|string|unique:sallaries,position,' . $id,
            'salary'   => 'required',
        ]);

        $salary = Sallary::findorFail($id);
        $salary->update($validate);

        return redirect()->route('list.salary')->with('success', 'Salary Update Successfully. ');
    }

    public function DeleteSalary($id)
    {

        $salary = Sallary::findorFail($id);
        $salary->delete();

        return redirect()->back()->with('success', 'Position Sallary Deleted. ');
    }

    public function StaffSalary(Request $request)
    {
        $data = academic_session::all();
        $staffquery = Staff::query();

        if ($request->filled('session_filter')) {
            $staffquery->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $staffquery->where('application_no', $request->application_no);
        }

        if ($request->filled('name')) {
            $staffquery->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('block')) {
            $staffquery->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $staffquery->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $staffquery->where('district', $request->district);
        }

        $staff = $staffquery->orderBy('created_at', 'asc')->get();
        $states = config('states');
        return view('ngo.salary.staff-salary-list', compact('states', 'data', 'staff'));
    }

    public function PaySalary(Request $request, $id)
    {
        $staff = Staff::where('status', 1)->findOrFail($id); // ✅ Only active staff
        $salary = Sallary::where('position', $staff->position)->first();

        $joiningYear = \Carbon\Carbon::parse($staff->joining_date)->year;
        $currentYear = now()->year;

        // ✅ Only generate salaries for active staff
        if ($staff->status == 1) {
            for ($year = $joiningYear; $year <= $currentYear; $year++) {
                $startMonth = ($year == $joiningYear) ? \Carbon\Carbon::parse($staff->joining_date)->month : 1;

                for ($month = $startMonth; $month <= 12; $month++) {
                    SalaryTransaction::firstOrCreate([
                        'staff_id' => $staff->id,
                        'year'     => $year,
                        'month'    => $month,
                    ], [
                        'amount'   => $salary->salary,
                        'status'   => 'unpaid',
                    ]);
                }
            }
        }

        // Get selected year (default: current year)
        $selectedYear = $request->input('year', $currentYear);

        // Fetch transactions grouped by year
        $transactions = SalaryTransaction::where('staff_id', $staff->id)
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('year');

        // Filter transactions for only selected year
        $yearTransactions = $transactions->get($selectedYear, collect());

        return view('ngo.salary.pay-salary', compact(
            'staff',
            'salary',
            'transactions',
            'selectedYear',
            'yearTransactions',
            'joiningYear',
            'currentYear'
        ));
    }


    public function storeSalaryPayment(Request $request, $staffId)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:cash,bank,cheque,upi',
        ]);

        $transaction = SalaryTransaction::where('staff_id', $staffId)
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->firstOrFail();

        if ($transaction->status === 'paid') {
            return back()->with('error', 'Already Paid');
        }

        $transaction->update([
            'amount'        => $request->amount,
            'status'        => 'paid',
            'payment_date'  => $request->payment_date,
            'payment_mode'  => $request->payment_mode,
            'bank_no'       => $request->bank_no,
            'bank_name'     => $request->bank_name,
            'ifsc_code'     => $request->ifsc_code,
            'cheque_no'     => $request->cheque_no,
            'upi_id'        => $request->upi_id,
            'transaction_id' => $request->transaction_id,
        ]);

        return back()->with('success', 'Salary Paid Successfully');
    }
    public function unpaySalary($id)
    {
        $transaction = SalaryTransaction::findOrFail($id);

        if ($transaction->status === 'unpaid') {
            return back()->with('error', 'Already unpaid');
        }

        $transaction->update([
            'status'        => 'unpaid',
            'payment_date'  => null,
            'payment_mode'  => null,
            'bank_name'     => null,
            'bank_no'       => null,
            'ifsc_code'     => null,
            'cheque_no'     => null,
            'upi_id'        => null,
            'transaction_id' => null,
        ]);

        return back()->with('success', 'Payment Reverted Successfully');
    }

    public function salaryTransactions($id)
{
    $staff = Staff::findOrFail($id);

    $transactions = SalaryTransaction::where('staff_id', $id)
        ->where('status', 'paid') // show only paid transactions for receipt
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->get();
        $signatures = Signature::pluck('file_path', 'role');

    return view('ngo.salary.staff-salary-transaction', compact('staff', 'transactions'));
}
}
