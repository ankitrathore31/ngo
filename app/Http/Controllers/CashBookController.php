<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\BalanceReport;
use App\Models\Bill;
use App\Models\Bill_Item;
use App\Models\Bill_Voucher;
use App\Models\Category;
use App\Models\Donation;
use App\Models\donor_data;
use App\Models\GbsBill;
use App\Models\Voucher_Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashBookController extends Controller
{
    public function IncomeList(Request $request)
    {
        $online = donor_data::where('status', 'Successful');
        $offline = Donation::query();

        if ($request->filled('name')) {
            $online->where('name', 'like', '%' . $request->name . '%');
            $offline->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $online->where('academic_session', $request->session_filter);
            $offline->where('academic_session', $request->session_filter);
        }
        if ($request->filled('block')) {
            $online->where('block', 'like', '%' . $request->block . '%');
            $offline->where('block', 'like', '%' . $request->block . '%');
        }
        if ($request->filled('amountType')) {
            // $online->where('block', 'like', '%' . $request->block . '%');
            $offline->where('amountType', 'like', '%' . $request->amountType . '%');
        }
        if ($request->filled('state')) {
            $online->where('state', $request->state);
            $offline->where('state', $request->state);
        }
        if ($request->filled('district')) {
            $online->where('district', $request->district);
            $offline->where('district', $request->district);
        }

        // Today filter
        if ($request->filled('today')) {
            $todayDate = now()->format('Y-m-d');
            $online->whereDate('created_at', $todayDate);
            $offline->whereDate('created_at', $todayDate);
        }

        // Date Range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $online->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            $offline->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        // Get donations
        $donations = $online->get()->merge($offline->get())->sortByDesc('created_at');

        $data = academic_session::all();
        $states = config('states');

        return view('ngo.cashbook.income-list', compact('data', 'donations', 'states'));
    }

    public function ExpenditureList(Request $request)
    {
        // Bill_Voucher
        $bv = Bill_Voucher::with('items')
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('bill_no'), fn($q) => $q->where('bill_no', $request->bill_no))
            ->when($request->filled('work_category'), fn($q) => $q->where('work_category', $request->work_category))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->when($request->filled('address'), fn($q) => $q->where('address', 'like', '%' . $request->address . '%'))
            ->when($request->filled('email'), fn($q) => $q->where('email', 'like', '%' . $request->email . '%'))
            ->when($request->filled('mobile'), fn($q) => $q->where('mobile', 'like', '%' . $request->mobile . '%'))
            ->when($request->filled('today'), fn($q) => $q->whereDate('date', now()->toDateString()))
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                fn($q) => $q->whereBetween('date', [$request->start_date, $request->end_date])
            );


        // Bill
        $b = Bill::with('items')
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('bill_no'), fn($q) => $q->where('bill_no', $request->bill_no))
            ->when($request->filled('work_category'), fn($q) => $q->where('work_category', $request->work_category))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->when(
                $request->filled('address') || $request->filled('block') || $request->filled('district') || $request->filled('state'),
                function ($q) use ($request) {
                    $q->where(function ($query) use ($request) {
                        $query->where('address', 'like', '%' . $request->input('address') . '%')
                            ->orWhere('address', 'like', '%' . $request->input('block') . '%')
                            ->orWhere('address', 'like', '%' . $request->input('district') . '%')
                            ->orWhere('address', 'like', '%' . $request->input('state') . '%');
                    });
                }
            )
            ->when($request->filled('email'), fn($q) => $q->where('email', 'like', '%' . $request->email . '%'))
            ->when($request->filled('mobile'), fn($q) => $q->where('mobile', 'like', '%' . $request->mobile . '%'))
            ->when($request->filled('today'), fn($q) => $q->whereDate('date', now()->toDateString()))
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                fn($q) => $q->whereBetween('date', [$request->start_date, $request->end_date])
            )
            ->get();



        // GbsBill
        $g = GbsBill::when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('bill_no'), fn($q) => $q->where('invoice_no', $request->bill_no))
            ->when($request->filled('work_category'), fn($q) => $q->where('work_category', $request->work_category))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->when($request->filled('address'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('village', 'like', '%' . $request->address . '%')
                        ->orWhere('post', 'like', '%' . $request->address . '%')
                        ->orWhere('block', 'like', '%' . $request->address . '%')
                        ->orWhere('district', 'like', '%' . $request->address . '%')
                        ->orWhere('state', 'like', '%' . $request->address . '%');
                });
            })
            ->when($request->filled('email'), fn($q) => $q->where('email', 'like', '%' . $request->email . '%'))
            ->when($request->filled('mobile'), fn($q) => $q->where('mobile', 'like', '%' . $request->mobile . '%'))
            ->when($request->filled('today'), fn($q) => $q->whereDate('bill_date', now()->toDateString()))
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                fn($q) => $q->whereBetween('bill_date', [$request->start_date, $request->end_date])
            );


        $bvList = $bv->get()->map(function ($x) {

            $baseAmount = $x->items->sum(fn($i) => $i->qty * $i->rate);

            $cgstAmount = ($baseAmount * ($x->cgst ?? 0)) / 100;
            $sgstAmount = ($baseAmount * ($x->sgst ?? 0)) / 100;

            $totalAmount = $baseAmount + $cgstAmount + $sgstAmount;

            return [
                'type' => 'voucher',
                'id' => $x->id,
                'bill_no' => $x->bill_no,
                'work_category' => $x->work_category,
                'date' => $x->date,
                'name' => $x->name,
                'address' => $x->address,
                'email' => $x->email,
                'mobile' => $x->mobile,
                'session' => $x->academic_session,
                'amount' => round($totalAmount, 2),
            ];
        });




        $bList = $b->map(function ($x) {

            $baseAmount = $x->items->sum(fn($i) => $i->qty * $i->rate);

            $cgstAmount = ($baseAmount * ($x->cgst ?? 0)) / 100;
            $sgstAmount = ($baseAmount * ($x->sgst ?? 0)) / 100;

            $totalAmount = $baseAmount + $cgstAmount + $sgstAmount;

            return [
                'type' => 'bill',
                'id' => $x->id,
                'bill_no' => $x->bill_no,
                'work_category' => $x->work_category,
                'date' => $x->date,
                'name' => $x->name,
                'address' => collect([$x->address, $x->block, $x->district, $x->state])
                    ->filter()
                    ->join(', '),
                'email' => $x->email,
                'mobile' => $x->mobile,
                'session' => $x->academic_session,
                'amount' => round($totalAmount, 2),
            ];
        });



        $gList = $g->get()->map(function ($x) {
            return [
                'type' => 'gbs',
                'id' => $x->id,
                'bill_no' => $x->invoice_no,
                'work_category' => $x->work_category,
                'date' => $x->bill_date, // Standardized to 'date'
                'name' => $x->name,
                'address' => collect([$x->village, $x->post, $x->block, $x->district, $x->state])
                    ->filter()
                    ->implode(', '),
                'email' => $x->email,
                'mobile' => $x->mobile,
                'session' => $x->academic_session,
                'amount' => $x->amount
            ];
        });

        // Merge and sort by 'date'
        $records = collect()
            ->merge($bvList)
            ->merge($bList)
            ->merge($gList)
            ->sortByDesc('date');

        // Total Amount
        $totalAmount = $records->sum('amount');

        // Session list
        $session = academic_session::all();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('ngo.cashbook.expenditure-list', [
            'records' => $records,
            'totalAmount' => $totalAmount,
            'session' => $session,
            'categories' => $categories
        ]);
    }

    public function generateMonthlyReport(Request $request)
    {
        $year = $request->input('year', now()->year);

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $online = donor_data::where('status', 'Successful')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount');

            $offline = Donation::whereBetween('date', [$startDate, $endDate])
                ->sum('amount');

            $totalIncome = $online + $offline;

            $bvExpense = Bill_Voucher::with('items')
                ->whereBetween('date', [$startDate, $endDate])
                ->get()
                ->sum(function ($x) {

                    $baseAmount = $x->items->sum(fn($i) => $i->qty * $i->rate);

                    $cgstAmount = ($baseAmount * ($x->cgst ?? 0)) / 100;
                    $sgstAmount = ($baseAmount * ($x->sgst ?? 0)) / 100;

                    return $baseAmount + $cgstAmount + $sgstAmount;
                });


            $bExpense = Bill::with('items')
                ->whereBetween('date', [$startDate, $endDate])
                ->get()
                ->sum(function ($x) {

                    $baseAmount = $x->items->sum(fn($i) => $i->qty * $i->rate);

                    $cgstAmount = ($baseAmount * ($x->cgst ?? 0)) / 100;
                    $sgstAmount = ($baseAmount * ($x->sgst ?? 0)) / 100;

                    return $baseAmount + $cgstAmount + $sgstAmount;
                });


            $gbsExpense = GbsBill::whereBetween('bill_date', [$startDate, $endDate])->sum('amount');

            $totalExpenditure = $bvExpense + $bExpense + $gbsExpense;
            $remaining = $totalIncome - $totalExpenditure;

            BalanceReport::updateOrCreate(
                ['year' => $year, 'month' => $month],
                [
                    'total_income' => $totalIncome,
                    'total_expenditure' => $totalExpenditure,
                    'remaining_amount' => $remaining,
                ]
            );
        }

        return redirect()->back()->with('success', 'Monthly financial reports generated for year ' . $year);
    }

    public function BalanceReportView(Request $request)
    {
        $year = $request->input('year', now()->year);
        $reports = BalanceReport::where('year', $year)->orderBy('month')->get();

        return view('ngo.cashbook.report', compact('reports', 'year'));
    }

    public function IncomeExpenditureReport(Request $request)
    {
        $now = now();

        // Correct financial year default
        if ($now->month >= 4) {
            $defaultSession = $now->year . '-' . ($now->year + 1);
        } else {
            $defaultSession = ($now->year - 1) . '-' . $now->year;
        }

        // Selected or default session
        $selectedSession = $request->input('session', $defaultSession);
        [$fromYear, $toYear] = explode('-', $selectedSession);

        // Financial year date range
        $startDate = Carbon::create($fromYear, 4, 1)->startOfDay();
        $endDate   = Carbon::create($toYear, 3, 31)->endOfDay();

        /* ===================== INCOME ===================== */

        $offlineIncome = Donation::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('amountType, SUM(amount) as total')
            ->groupBy('amountType')
            ->get();

        $offlineTotal = $offlineIncome->sum('total');

        $onlineTotal = donor_data::where('status', 'Successful')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $grandTotalIncome = $offlineTotal + $onlineTotal;

        /* ===================== EXPENSE ===================== */

        $expenses = collect();

        $bvBills = Bill_Voucher::with('items')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        foreach ($bvBills as $bill) {
            $base = $bill->items->sum(fn($i) => $i->qty * $i->rate);
            $gst  = ($base * ($bill->cgst ?? 0) / 100)
                + ($base * ($bill->sgst ?? 0) / 100);

            $expenses->push([
                'category' => $bill->work_category,
                'amount' => $base + $gst
            ]);
        }

        $bBills = Bill::with('items')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        foreach ($bBills as $bill) {
            $base = $bill->items->sum(fn($i) => $i->qty * $i->rate);
            $gst  = ($base * ($bill->cgst ?? 0) / 100)
                + ($base * ($bill->sgst ?? 0) / 100);

            $expenses->push([
                'category' => $bill->work_category,
                'amount' => $base + $gst
            ]);
        }

        $gbsBills = GbsBill::whereBetween('bill_date', [$startDate, $endDate])->get();

        foreach ($gbsBills as $bill) {
            $expenses->push([
                'category' => $bill->work_category,
                'amount' => $bill->amount
            ]);
        }

        $expenseSummary = $expenses
            ->groupBy('category')
            ->map(fn($row) => $row->sum('amount'));

        $grandTotalExpense = $expenseSummary->sum();

        return view('ngo.cashbook.expenditure-income-report', compact(
            'selectedSession',
            'offlineIncome',
            'onlineTotal',
            'grandTotalIncome',
            'expenseSummary',
            'grandTotalExpense'
        ));
    }
}
