<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\BalanceReport;
use App\Models\beneficiarie;
use App\Models\Bill;
use App\Models\Bill_Item;
use App\Models\Bill_Voucher;
use App\Models\Category;
use App\Models\Donation;
use App\Models\donor_data;
use App\Models\GbsBill;
use App\Models\Member;
use App\Models\SalaryPayment;
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

        /* ---------- Approved Education Facility Expenditure ---------- */

        $educationCardConstraint = function ($q) {
            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Approve');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Approve');
                }]);
        };

        $eduBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        $eduMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint);

        /* ---- Optional filters (keep aligned with Expenditure filters) ---- */

        $eduBene
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', "%{$request->name}%"));

        $eduMember
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', "%{$request->name}%"));

        $eduRecords = collect()
            ->merge($eduBene->get())
            ->merge($eduMember->get())
            ->flatMap(function ($person) {
                return $person->educationCards->flatMap(function ($card) use ($person) {
                    return $card->educationFacilities->map(function ($facility) use ($person, $card) {
                        return [
                            'type'          => 'education_fee',
                            'id'            => $facility->id,
                            'bill_no'       => $card->educationcard_no,
                            'work_category' => $facility->work_category,
                            'date'          => $facility->fees_submit_date,
                            'name'          => $person->name,
                            'address'       => collect([
                                $person->village ?? null,
                                $person->post ?? null,
                                $person->block ?? null,
                                $person->district ?? null,
                                $person->state ?? null,
                            ])->filter()->implode(', '),
                            'email'         => $person->email ?? null,
                            'mobile'        => $person->mobile ?? null,
                            'session'       => $person->academic_session,
                            'amount'        => $facility->clearness_amount,
                        ];
                    });
                });
            });

        /* ---------- Approved Health Facility Expenditure ---------- */

        $healthCardConstraint = function ($q) {
            $q->where('status', 1)
                ->whereHas('healthFacilities', function ($hf) {
                    $hf->where('status', 'Approve');
                })
                ->with(['healthFacilities' => function ($hf) {
                    $hf->where('status', 'Approve');
                }]);
        };

        $healthBene = beneficiarie::with(['healthCard' => $healthCardConstraint])
            ->where('status', 1)
            ->whereHas('healthCard', $healthCardConstraint);

        $healthMember = Member::with(['healthCard' => $healthCardConstraint])
            ->where('status', 1)
            ->whereHas('healthCard', $healthCardConstraint);

        /* ---- Optional alignment filters ---- */
        $healthBene
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', "%{$request->name}%"));

        $healthMember
            ->when($request->filled('session_filter'), fn($q) => $q->where('academic_session', $request->session_filter))
            ->when($request->filled('name'), fn($q) => $q->where('name', 'like', "%{$request->name}%"));

        $healthRecords = collect()
            ->merge($healthBene->get())
            ->merge($healthMember->get())
            ->flatMap(function ($person) {
                return $person->healthCard->flatMap(function ($card) use ($person) {
                    return $card->healthFacilities->map(function ($facility) use ($person, $card) {
                        return [
                            'type'          => 'health_fee',
                            'id'            => $facility->id,
                            'bill_no'       => $card->healthcard_no,
                            'work_category' => $facility->work_category,
                            'date'          => $facility->bill_date,
                            'name'          => $person->name,
                            'address'       => collect([
                                $person->village ?? null,
                                $person->post ?? null,
                                $person->block ?? null,
                                $person->district ?? null,
                                $person->state ?? null,
                            ])->filter()->implode(', '),
                            'email'         => $person->email ?? null,
                            'mobile'        => $person->mobile ?? null,
                            'session'       => $person->academic_session,
                            'amount'        => $facility->clearness_amount,
                        ];
                    });
                });
            });


        $salaries = SalaryPayment::with('staff')
            ->when($request->filled('session_filter'), function ($q) use ($request) {
                $q->whereHas('staff', function ($s) use ($request) {
                    $s->where('academic_session', $request->session_filter);
                });
            })
            ->when($request->filled('name'), function ($q) use ($request) {
                $q->whereHas('staff', function ($s) use ($request) {
                    $s->where('name', 'like', '%' . $request->name . '%');
                });
            })
            ->when($request->filled('address'), function ($q) use ($request) {
                $q->whereHas('staff', function ($s) use ($request) {
                    $s->where('village', 'like', '%' . $request->address . '%')
                        ->orWhere('post', 'like', '%' . $request->address . '%')
                        ->orWhere('block', 'like', '%' . $request->address . '%')
                        ->orWhere('district', 'like', '%' . $request->address . '%')
                        ->orWhere('state', 'like', '%' . $request->address . '%');
                });
            })
            ->when($request->filled('phone'), function ($q) use ($request) {
                $q->whereHas('staff', function ($s) use ($request) {
                    $s->where('phone', 'like', '%' . $request->mobile . '%');
                });
            })
            ->when(
                $request->filled('today'),
                fn($q) =>
                $q->whereDate('payment_date', now()->toDateString())
            )
            ->when(
                $request->filled('start_date') && $request->filled('end_date'),
                fn($q) => $q->whereBetween('payment_date', [$request->start_date, $request->end_date])
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

        $salaryList = $salaries->get()->map(function ($x) {
            return [
                'type'          => 'salary',
                'id'            => $x->id,
                'bill_no'       => $x->receipt_no ?? 'RCP-' . $x->id,
                'work_category' => 'Staff Salary',
                'date'          => $x->payment_date,
                'name'          => $x->staff->name,
                'address' => collect([$x->staff->village, $x->staff->post, $x->staff->block, $x->staff->district, $x->staff->state])
                    ->filter()
                    ->implode(', '),
                'email'         => $x->staff->email,
                'mobile'        => $x->staff->phone,
                'session'       => $x->staff->academic_session,
                'amount'        => $x->amount,
            ];
        });


        // Merge and sort by 'date'
        $records = collect()
            ->merge($bvList)
            ->merge($bList)
            ->merge($gList)
            ->merge($salaryList)
            ->merge($eduRecords)
            ->merge($healthRecords)
            ->sortBy('date');

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

        $salaryPayments = SalaryPayment::whereBetween('payment_date', [$startDate, $endDate])->get();

        foreach ($salaryPayments as $salary) {
            $expenses->push([
                'category' => 'Staff Salary',
                'amount'   => $salary->amount
            ]);
        }

        /* ===================== EDUCATION FACILITY EXPENSE ===================== */

        $educationCardConstraint = function ($q) {
            $q->where('status', 1)
                ->whereHas('educationFacilities', function ($ef) {
                    $ef->where('status', 'Approve');
                })
                ->with(['educationFacilities' => function ($ef) {
                    $ef->where('status', 'Approve');
                }]);
        };

        $eduBene = beneficiarie::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint)
            ->get();

        $eduMember = Member::with(['educationCards' => $educationCardConstraint])
            ->where('status', 1)
            ->whereHas('educationCards', $educationCardConstraint)
            ->get();

        collect()
            ->merge($eduBene)
            ->merge($eduMember)
            ->flatMap(
                fn($person) =>
                $person->educationCards->flatMap(
                    fn($card) =>
                    $card->educationFacilities
                        ->whereBetween('fees_submit_date', [$startDate, $endDate])
                        ->map(fn($facility) => $facility)
                )
            )
            ->each(function ($facility) use ($expenses) {
                $expenses->push([
                    'category' => $facility->work_category,
                    'amount'   => $facility->clearness_amount
                ]);
            });

        /* ===================== HEALTH FACILITY EXPENSE ===================== */

        $healthCardConstraint = function ($q) {
            $q->where('status', 1)
                ->whereHas('healthFacilities', function ($hf) {
                    $hf->where('status', 'Approve');
                })
                ->with(['healthFacilities' => function ($hf) {
                    $hf->where('status', 'Approve');
                }]);
        };

        $healthBene = beneficiarie::with(['healthCard' => $healthCardConstraint])
            ->where('status', 1)
            ->whereHas('healthCard', $healthCardConstraint)
            ->get();

        $healthMember = Member::with(['healthCard' => $healthCardConstraint])
            ->where('status', 1)
            ->whereHas('healthCard', $healthCardConstraint)
            ->get();

        collect()
            ->merge($healthBene)
            ->merge($healthMember)
            ->flatMap(
                fn($person) =>
                $person->healthCard->flatMap(
                    fn($card) =>
                    $card->healthFacilities
                        ->whereBetween('bill_date', [$startDate, $endDate])
                        ->map(fn($facility) => $facility)
                )
            )
            ->each(function ($facility) use ($expenses) {
                $expenses->push([
                    'category' => $facility->work_category,
                    'amount'   => $facility->clearness_amount
                ]);
            });


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
