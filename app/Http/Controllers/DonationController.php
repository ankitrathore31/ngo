<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\donor_data;
use App\Models\beneficiarie;
use App\Models\Member;
use Illuminate\Support\Facades\DB;


class DonationController extends Controller
{
    public function onlineDonor()
    {
        $data = academic_session::all();
        $donor = donor_data::where('status', 'Successful')->get();
        return view('ngo.donation.online-donor-list', compact('data', 'donor'));
    }

    public function donationList(Request $request)
    {

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-list', compact('data', 'donor'));
    }

    public function donation(Request $request)
    {
        $data = academic_session::all();
        $beneficiaries = beneficiarie::all();
        $members = Member::all();
        $record = $beneficiaries->merge($members);
        $lastReceiptNo = Donation::max('receipt_no');
        $newReceiptNo = is_numeric($lastReceiptNo) ? ((int) $lastReceiptNo + 1) : 1;

        return view('ngo.donation.donation', compact('data', 'record', 'newReceiptNo'));
    }



    public function saveDonation(Request $request)
    {
        $request->validate([
            'session' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'mobile' => 'required',
            'gurdian_name' => 'required',
            'address' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
        ]);

        $lastReceipt = \App\Models\Donation::orderBy('id', 'desc')->first();
        if ($lastReceipt && is_numeric($lastReceipt->receipt_no)) {
            $newReceiptNo = (int)$lastReceipt->receipt_no + 1;
        } else {
            $newReceiptNo = 1;
        }
        $formattedReceiptNo = str_pad($newReceiptNo, 3, '0', STR_PAD_LEFT);

        $donation = new Donation;
        $donation->receipt_no = $formattedReceiptNo;
        $donation->academic_session = $request->session;
        $donation->date = $request->date;
        $donation->name = $request->name;
        $donation->mobile = $request->mobile;
        $donation->gurdian_name = $request->gurdian_name;
        $donation->payment_method = $request->payment_method;
        $donation->address = $request->address;
        $donation->amount = $request->amount;
        $donation->depositor_name = $request->depositor_name;
        $donation->relationship = $request->relationship;
        $donation->recipient_name = $request->recipient_name;
        $donation->remark = $request->remark;


        // Conditional Cheque fields
        if ($request->payment_method == 'Cheque') {
            $donation->cheque_no = $request->cheque_no;
            $donation->bank_name = $request->bank_name;
            $donation->bank_branch = $request->bank_branch;
            $donation->cheque_date = $request->cheque_date;
        }

        // Conditional UPI fields
        if ($request->payment_method == 'UPI') {
            $donation->transaction_no = $request->transaction_no;
            $donation->transaction_date = $request->transaction_date;
        }

        $donation->save();

        return redirect()->route('donation-list')->with('success', 'Donation saved successfully!');
    }

    public function viewDonation($id)
    {

        $donor = Donation::find($id);
        $donor = donor_data::find($id);

        return view('ngo.donation.view-donation', compact('donor'));
    }

    public function viewDonationCertificate($id)
    {

        $donor = Donation::find($id);
        $donor = donor_data::find($id);
        return view('ngo.donation.donation-certificate', compact('donor'));
    }

    public function donationCardList(Request $request)
    {

        $query = Donation::query();
        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = academic_session::all();
        $donor = $query->get();

        return view('ngo.donation.donation-card-list', compact('data', 'donor'));
    }

    public function allDonations(Request $request)
    {
        $online = donor_data::where('status', 'successfully')->get();

        if ($request->filled('name')) {
            $online->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $online->where('academic_session', $request->session_filter);
        }

        // Apply filters to Donation (offline donations)
        $offline = Donation::query();

        if ($request->filled('name')) {
            $offline->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $offline->where('academic_session', $request->session_filter);
        }

        // Get both collections and merge
        $donations = $online->get()->merge($offline->get());

        // Optional: sort the merged collection (e.g., by date)
        $donations = $donations->sortByDesc('created_at'); // or any other column you have

        // For academic session dropdown
        $data = academic_session::all();

        return view('ngo.donation.all-donation-list', compact('data', 'donations'));
    }


    public function TTDonationReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = academic_session::all(); // session list

        $donationsQuery = Donation::query(); // base query

        // Apply filters (session + date range)
        if ($request->filled('session_filter')) {
            $donationsQuery->where('session', $request->input('session_filter'));
        }

        if ($request->filled('start_date')) {
            $donationsQuery->whereDate('date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $donationsQuery->whereDate('date', '<=', $request->input('end_date'));
        }

        $filteredDonations = $donationsQuery->get();

        // 🟢 This is your "Range Donation"
        $rangeDonation = $filteredDonations->sum('amount');

        // Unfiltered general stats
        $totalDonation = Donation::sum('amount');
        $thisYear = Donation::whereYear('date', now()->year)->sum('amount');
        $thisMonth = Donation::whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
        $today = Donation::whereDate('date', now())->sum('amount');

        return view('ngo.donation.donation-report', compact(
            'data',
            'totalDonation',
            'thisYear',
            'thisMonth',
            'today',
            'rangeDonation'
        ));
    }

    public function DonationReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = academic_session::all(); // For session dropdown

        // ----- Base Queries -----
        $offlineQuery = Donation::query();      // Offline
        $onlineQuery = donor_data::query();     // Online

        // ----- Apply Filters to Both -----
        if ($request->filled('session_filter')) {
            $offlineQuery->where('session', $request->input('session_filter'));
            $onlineQuery->where('session', $request->input('session_filter'));
        }

        if ($request->filled('start_date')) {
            $offlineQuery->whereDate('date', '>=', $request->input('start_date'));
            $onlineQuery->whereDate('date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $offlineQuery->whereDate('date', '<=', $request->input('end_date'));
            $onlineQuery->whereDate('date', '<=', $request->input('end_date'));
        }

        // Check if user applied any range filter
        $hasDateRange = $request->filled('start_date') || $request->filled('end_date');

        // Calculate only if a range is selected
        $rangeDonation = 0;

        if ($hasDateRange) {
            $filteredOffline = $offlineQuery->get();
            $filteredOnline = $onlineQuery->get();
            $filteredDonations = $filteredOffline->merge($filteredOnline);

            $rangeDonation = $filteredDonations->sum('amount');
        }

        // ----- Global Stats (All-Time) -----
        $totalOffline = Donation::sum('amount');
        $totalOnline = donor_data::sum('amount');
        $totalDonation = $totalOffline + $totalOnline;

        // ----- This Year -----
        $thisYear = Donation::whereYear('date', now()->year)->sum('amount')
            + donor_data::whereYear('date', now()->year)->sum('amount');

        // ----- This Month -----
        $thisMonth = Donation::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)->sum('amount')
            + donor_data::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)->sum('amount');

        // ----- Today -----
        $today = Donation::whereDate('date', now())->sum('amount')
            + donor_data::whereDate('date', now())->sum('amount');

        return view('ngo.donation.donation-report', compact(
            'data',
            'totalDonation',
            'thisYear',
            'thisMonth',
            'today',
            'rangeDonation'
        ));
    }
}
