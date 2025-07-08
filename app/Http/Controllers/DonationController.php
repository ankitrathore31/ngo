<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\donor_data;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Signature;
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
        $states = config('states');
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
            'block' => 'required',
            'state' => 'required',
            'district' => 'required',
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
        $donation->block = $request->block;
        $donation->state = $request->state;
        $donation->district = $request->district;
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

    public function EditDonation($id)
    {
        $data = academic_session::all();
        $donation = Donation::find($id);
        return view('ngo.donation.edit-donation', compact('data', 'donation'));
    }

    public function updateDonation(Request $request, $id)
    {
        $request->validate([
            'session' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'mobile' => 'required',
            'gurdian_name' => 'required',
            'address' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
        ]);

        // Find the existing donation
        $donation = Donation::findOrFail($id);

        // Update fields
        $donation->academic_session = $request->session;
        $donation->date = $request->date;
        $donation->name = $request->name;
        $donation->mobile = $request->mobile;
        $donation->gurdian_name = $request->gurdian_name;
        $donation->payment_method = $request->payment_method;
        $donation->address = $request->address;
        $donation->block = $request->block;
        $donation->state = $request->state;
        $donation->district = $request->district;
        $donation->amount = $request->amount;
        $donation->depositor_name = $request->depositor_name;
        $donation->relationship = $request->relationship;
        $donation->recipient_name = $request->recipient_name;
        $donation->remark = $request->remark;

        // Reset conditional fields
        $donation->cheque_no = null;
        $donation->bank_name = null;
        $donation->bank_branch = null;
        $donation->cheque_date = null;
        $donation->transaction_no = null;
        $donation->transaction_date = null;

        // Conditional Cheque fields
        if ($request->payment_method === 'Cheque') {
            $donation->cheque_no = $request->cheque_no;
            $donation->bank_name = $request->bank_name;
            $donation->bank_branch = $request->bank_branch;
            $donation->cheque_date = $request->cheque_date;
        }

        // Conditional UPI fields
        if ($request->payment_method === 'UPI') {
            $donation->transaction_no = $request->transaction_no;
            $donation->transaction_date = $request->transaction_date;
        }

        $donation->save();

        return redirect()->route('donation-list')->with('success', 'Donation updated successfully!');
    }

    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();
        return redirect()->route('donation-list')->with('success', 'Donation deleted successfully!');
    }


    public function viewDonation($id)
    {

        // Try to find donor in offline donations first
        $donor = Donation::find($id);

        // If not found in offline, try in online
        if (!$donor) {
            $donor = donor_data::find($id);
        }

        // Optionally handle not found
        if (!$donor) {
            return redirect()->back()->with('error', 'Donation not found.');
        }

        return view('ngo.donation.view-donation', compact('donor'));
    }

    public function viewDonationCertificate($id)
    {
        // Try to find donor in offline donations first
        $donor = Donation::find($id);

        // If not found in offline, try in online
        if (!$donor) {
            $donor = donor_data::find($id);
        }

        // Optionally handle not found
        if (!$donor) {
            return redirect()->back()->with('error', 'Donation not found.');
        }
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.donation.donation-certificate', compact('donor', 'signatures'));
    }


    public function donationCardList(Request $request)
    {

        $query = Donation::query();
        // $query
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

    public function viewDonationCard($id)
    {

        // Try to find donor in offline donations first
        $donor = Donation::find($id);

        // If not found in offline, try in online
        if (!$donor) {
            $donor = donor_data::find($id);
        }

        // Optionally handle not found
        if (!$donor) {
            return redirect()->back()->with('error', 'Donation not found.');
        }

        return view('ngo.donation.donation-card', compact('donor'));
    }

    public function allDonations(Request $request)
    {
         $online = donor_data::where('status', 'Successful');

        if ($request->filled('name')) {
            $online->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $online->where('academic_session', $request->session_filter);
        }
        if ($request->filled('block')) {
            $online->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $online->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $online->where('district', $request->district);
        }

        // Apply filters to Donation (offline donations)
        $offline = Donation::query();

        if ($request->filled('name')) {
            $offline->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('session_filter')) {
            $offline->where('academic_session', $request->session_filter);
        }
        if ($request->filled('block')) {
            $offline->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $offline->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $offline->where('district', $request->district);
        }

        // Get both collections and merge
        $donations = $online->get()->merge($offline->get());

        // Optional: sort the merged collection (e.g., by date)
        $donations = $donations->sortByDesc('created_at'); // or any other column you have

        // For academic session dropdown
        $data = academic_session::all();
        $states = config('states');
        return view('ngo.donation.all-donation-list', compact('data', 'donations','states'));
    }

    public function DonationReport(Request $request)
    {
        $data = academic_session::all(); // For session dropdown

        $startDate = $request->input('start_date', now()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $donationType = $request->input('donation_type', 'all');

        // Base Queries
        $offlineQuery = Donation::query();
        $onlineQuery = donor_data::where('status', 'Successful');

        // Apply filters
        if ($request->filled('session_filter')) {
            $offlineQuery->where('academic_session', $request->input('session_filter'));
            // $onlineQuery->where('academic_session', $request->input('session_filter'));
        }

        // Add state, district, block filters
        if ($request->filled('state')) {
            $offlineQuery->where('state', $request->input('state'));
            $onlineQuery->where('state', $request->input('state'));
        }

        if ($request->filled('district')) {
            $offlineQuery->where('district', $request->input('district'));
            $onlineQuery->where('district', $request->input('district'));
        }

        if ($request->filled('block')) {
            $offlineQuery->where('block', 'like', '%' . $request->input('block') . '%');
            $onlineQuery->where('block', 'like', '%' . $request->input('block') . '%');
        }

        $offlineQuery->whereBetween('date', [$startDate, $endDate]);
        $onlineQuery->whereBetween('date', [$startDate, $endDate]);

        // Filter by donation type
        if ($donationType === 'offline') {
            $donations = $offlineQuery->get();
        } elseif ($donationType === 'online') {
            $donations = $onlineQuery->get();
        } else {
            $donations = $offlineQuery->get()->merge($onlineQuery->get());
        }

        // Calculate Range Total
        $rangeDonation = $donations->sum('amount');

        // Total Stats
        $totalOffline = Donation::sum('amount');
        $totalOnline = donor_data::where('status', 'Successful')->sum('amount');
        $totalDonation = $totalOffline + $totalOnline;
        $thisYear = Donation::whereYear('date', now()->year)->sum('amount')
            + donor_data::where('status', 'Successful')->whereYear('date', now()->year)->sum('amount');

        $thisMonth = Donation::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)->sum('amount')
            + donor_data::where('status', 'Successful')
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)->sum('amount');

        $today = Donation::whereDate('date', now())->sum('amount')
            + donor_data::where('status', 'Successful')
            ->whereDate('date', now())->sum('amount');

        // Prepare filter values for display
        $filters = [
            'session' => $request->input('session_filter'),
            'state' => $request->input('state'),
            'district' => $request->input('district'),
            'block' => $request->input('block'),
        ];

        return view('ngo.donation.donation-report', compact(
            'data',
            'donations',
            'totalDonation',
            'thisYear',
            'thisMonth',
            'today',
            'rangeDonation',
            'filters'
        ));
    }
}
