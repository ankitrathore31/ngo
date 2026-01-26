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
        $staff = Staff::where('status', 1)->findOrFail($id);
        $salary = Sallary::where('position', $staff->position)->first();

        $joiningDate  = \Carbon\Carbon::parse($staff->joining_date);
        $joiningYear  = $joiningDate->year;
        $joiningMonth = $joiningDate->month;

        $currentYear  = now()->year;
        $currentMonth = now()->month;

        if ($staff->status == 1) {
            for ($year = $joiningYear; $year <= $currentYear; $year++) {

                // ✅ determine start month
                $startMonth = ($year == $joiningYear) ? $joiningMonth : 1;

                // ✅ determine end month
                $endMonth = ($year == $currentYear) ? $currentMonth : 12;

                for ($month = $startMonth; $month <= $endMonth; $month++) {
                    SalaryTransaction::firstOrCreate(
                        [
                            'staff_id' => $staff->id,
                            'year'     => $year,
                            'month'    => $month,
                        ],
                        [
                            'amount'   => $salary->salary,
                            'status'   => 'unpaid',
                        ]
                    );
                }
            }
        }

        $selectedYear = $request->input('year', $currentYear);

        $transactions = SalaryTransaction::where('staff_id', $staff->id)
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('year');

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

        $paidSoFar = $transaction->payments()->sum('amount');
        $remaining = $transaction->amount - $paidSoFar;

        if ($transaction->status === 'paid') {
            return back()->with('error', 'This salary is already fully paid.');
        }

        if ($request->amount > $remaining) {
            return back()->with('error', 'Payment exceeds remaining balance.');
        }

        $transaction->payments()->create([
            'staff_id'      => $staffId,
            'amount'        => $request->amount,
            'payment_date'  => $request->payment_date,
            'payment_mode'  => $request->payment_mode,
            'bank_no'       => $request->bank_no,
            'bank_name'     => $request->bank_name,
            'ifsc_code'     => $request->ifsc_code,
            'cheque_no'     => $request->cheque_no,
            'upi_id'        => $request->upi_id,
            'transaction_id_ref' => $request->transaction_id,
        ]);

        $paidSoFar += $request->amount;
        if ($paidSoFar >= $transaction->amount) {
            $transaction->status = 'paid';
        } elseif ($paidSoFar > 0) {
            $transaction->status = 'partial';
        } else {
            $transaction->status = 'unpaid';
        }

        $transaction->save();

        return back()->with('success', 'Payment recorded successfully');
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

        // Fetch only transactions that have payments (skip unpaid)
        $transactions = SalaryTransaction::with('payments')
            ->where('staff_id', $id)
            ->whereHas('payments') // ensures at least one payment exists
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        // Recalculate status based on payments
        foreach ($transactions as $t) {
            $paid = $t->payments->sum('amount');
            if ($paid >= $t->amount) {
                $t->status = 'paid';
            } else {
                $t->status = 'partial'; // since unpaid are excluded
            }
        }

        $signatures = Signature::pluck('file_path', 'role');

        return view('ngo.salary.staff-salary-transaction', compact('staff', 'transactions', 'signatures'));
    }


    public function staffPassbook(Request $request, $id)
    {
        $staff = Staff::where('status', 1)->findOrFail($id);

        // ✅ Fetch ALL salary transactions
        $transactions = SalaryTransaction::with('payments')
            ->where('staff_id', $staff->id)
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('year');

        $years = $transactions->keys();
        $selectedYear = $request->input('year', now()->year);

        // ✅ Selected year transactions
        $yearTransactions = $transactions->get($selectedYear, collect());

        /* -------------------------
       YEAR-WISE TOTALS
    --------------------------*/
        $totalAmount = $yearTransactions->sum('amount');
        $totalPaid   = $yearTransactions->flatMap->payments->sum('amount');
        $remaining   = $totalAmount - $totalPaid;

        /* -------------------------
       OVERALL TOTALS (FROM JOINING)
    --------------------------*/
        $allTransactions = $transactions->flatten();

        $overallTotalSalary = $allTransactions->sum('amount');
        $overallPaid        = $allTransactions->flatMap->payments->sum('amount');
        $overallRemaining   = $overallTotalSalary - $overallPaid;

        return view('ngo.salary.passbook', compact(
            'staff',
            'transactions',
            'yearTransactions',
            'selectedYear',
            'years',
            'totalAmount',
            'totalPaid',
            'remaining',
            'overallTotalSalary',
            'overallPaid',
            'overallRemaining'
        ));
    }
}
