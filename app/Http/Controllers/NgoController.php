<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Ngo;
use App\Models\User;
use App\Models\academic_session;
use App\Models\Activity;
use App\Models\beneficiarie;
use App\Models\Bill;
use App\Models\Bill_Voucher;
use App\Models\Donation;
use App\Models\donor_data;
use App\Models\GbsBill;
use App\Models\Member;
use App\Models\Staff;
use Illuminate\Support\Facades\Session;

class NgoController extends Controller
{

    public function totalngo()
    {

        $ngo = Ngo::get();
        // $totalngo = Ngo::where('status', 0)->count();

        return view('admin.ngo.totalngo-list', compact('ngo'));
    }

    public function activengo()
    {

        $ngo = Ngo::where('status', 1)->get();
        // $totalngo = Ngo::where('status', 1)->count();

        return view('admin.ngo.activengo-list', compact('ngo'));
    }

    public function deactivengo()
    {

        $ngo = Ngo::where('status', 0)->get();
        // $totalngo = Ngo::where('status', 0)->count();

        return view('admin.ngo.deactivengo-list', compact('ngo'));
    }

    public function savengo(Request $request)
    {
        $request->validate([
            'established_date' => 'required|date',
            'ngo_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ngos,email',
            'phone_number' => 'required|string|max:10|unique:ngos,phone_number',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pin_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'end_date' => 'required|date',
            'start_date' => 'required|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'This email is already registered with another account.',
            'phone_number.unique' => 'This number is already registered with another account.',
        ]);


        $ngo = new Ngo;

        $ngo->established_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->established_date)->format('Y-m-d');
        $ngo->ngo_name = $request->ngo_name;
        $ngo->founder_name = $request->founder_name;
        $ngo->email = $request->email;
        $ngo->phone_number = $request->phone_number;
        $ngo->address = $request->address;
        $ngo->state = $request->state;
        $ngo->pin_code = $request->pin_code;
        $ngo->country = $request->country;
        $ngo->post = $request->post;
        $ngo->district = $request->district;
        $ngo->package = $request->package;
        $ngo->start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $ngo->end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
        $ngo->password = Hash::make($request->password);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $ngo->logo = $filename;
        }

        $ngo->save();

        $user = new User;

        $user->name = $request->ngo_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->user_type = 'ngo';

        $user->save();

        return redirect()->back()->with('success', 'NGO created successfully!');
    }

    public function toggleStatus($id)
    {
        $ngo = Ngo::findOrFail($id);

        $ngo->status = $ngo->status == 0 ? 1 : 1;

        $ngo->save();

        return redirect()->back()->with('success', 'NGO status updated successfully.');
    }

    public function editngo($id)
    {
        $ngo = Ngo::find($id);
        return view('admin.ngo.edit-ngo', compact('ngo'))->with('password', $ngo->password);
    }

    public function updatengo(Request $request, $id)
    {
        $request->validate([
            'established_date' => 'required|date',
            'ngo_name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:ngos,email,' . $id, // Corrected unique validation rule
            'phone_number' => 'required|string|max:10|unique:ngos,phone_number,' . $id, // Corrected unique validation rule
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pin_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'email.unique' => 'This email is already registered with another account.',
            'phone_number.unique' => 'This number is already registered with another account.',
        ]);

        $ngo = Ngo::find($id);

        // Update the fields with the validated input
        $ngo->established_date = \Carbon\Carbon::parse($request->established_date)->format('Y-m-d');
        $ngo->ngo_name = $request->ngo_name;
        $ngo->founder_name = $request->founder_name;
        $ngo->email = $request->email;
        $ngo->phone_number = $request->phone_number;
        $ngo->address = $request->address;
        $ngo->state = $request->state;
        $ngo->pin_code = $request->pin_code;
        $ngo->country = $request->country;
        $ngo->post = $request->post;
        $ngo->district = $request->district;
        $ngo->package = $request->package;
        $ngo->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $ngo->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $ngo->password = Hash::make($request->password);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $ngo->logo = $filename;
        }

        $ngo->save();

        return redirect()->back()->with('success', 'NGO updated successfully!');
    }


    public function deletengo($id)
    {
        $ngo = Ngo::find($id);

        if (!$ngo) {
            return redirect()->back()->with('error', 'NGO not found.');
        }

        if ($ngo->logo && file_exists(public_path('images/' . $ngo->logo))) {
            unlink(public_path('images/' . $ngo->logo));
        }

        $ngo->delete();

        return redirect()->back()->with('success', 'NGO deleted successfully!');
    }

    public function viewngo($id)
    {
        $ngo = Ngo::find($id);

        return view('admin.ngo.view-ngo', compact('ngo'));
    }

    public function ngo()
    {
        // regsitration data
        $allbene = beneficiarie::count();
        $penbene = beneficiarie::where('status', 0)->count();
        $apbene = beneficiarie::where('status', 1)->count();
        $rebene = Beneficiarie::onlyTrashed()->count();
        // acativity data 
        $allacti = Activity::count();
        $todayacti = Activity::whereDate('created_at', Carbon::today())->count();
        $totalStaff = Staff::count();
        $allmem = Member::count();
        $appmem = Member::where('status', 1)->count();
        $penmem = Member::where('status', 0)->count();
        // donation data 
        $offlinedonate = Donation::sum('amount');
        $succdonate = donor_data::where('status', 'Successful')->sum('amount');
        $totaldonation = $offlinedonate + $succdonate;
        $todayOffline = Donation::whereDate('created_at', Carbon::today())->sum('amount');
        $todayOnline = donor_data::where('status', 'Successful')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $todaydonate = $todayOffline + $todayOnline;

        // cost data 
        // Total sum of all amounts
        $billTotal = Bill::with('items')->get()
            ->sum(fn($bill) => $bill->items->sum(fn($item) => $item->qty * $item->rate));

        $voucherTotal = Bill_Voucher::with('items')->get()
            ->sum(fn($voucher) => $voucher->items->sum(fn($item) => $item->qty * $item->rate));

        $gbsTotal = GbsBill::sum('amount');

        $totalCostAmount = $billTotal + $voucherTotal + $gbsTotal;

        // Today's total sum amount
        $billToday = Bill::with('items')->whereDate('date', now())->get()
            ->sum(fn($bill) => $bill->items->sum(fn($item) => $item->qty * $item->rate));

        $voucherToday = Bill_Voucher::with('items')->whereDate('date', now())->get()
            ->sum(fn($voucher) => $voucher->items->sum(fn($item) => $item->qty * $item->rate));

        $gbsToday = GbsBill::whereDate('bill_date', now())->sum('amount');

        $todayCostAmount = $billToday + $voucherToday + $gbsToday;

        // Income Data 
        // Total income amount
        $onlineTotal = donor_data::where('status', 'Successful')->sum('amount');
        $offlineTotal = Donation::sum('amount');
        $totalIncome = $onlineTotal + $offlineTotal;

        // Today's income amount
        $today = now()->toDateString();
        $onlineToday = donor_data::where('status', 'Successful')
            ->whereDate('created_at', $today)
            ->sum('amount');
        $offlineToday = Donation::whereDate('created_at', $today)->sum('amount');

        $todayIncome = $onlineToday + $offlineToday;

        // Remaing Balance 
        // Remaining balance (income - cost)
        $remainingBalance = $totalIncome - $totalCostAmount;

        return view('ngo.dashboard', compact(
            'allbene',
            'penbene',
            'apbene',
            'rebene',
            'allacti',
            'todayacti',
            'allmem',
            'appmem',
            'penmem',
            'succdonate',
            'todaydonate',
            'offlinedonate',
            'totaldonation',
            'totalStaff',
            'totalCostAmount',
            'todayCostAmount',
            'totalIncome',
            'todayIncome',
            'remainingBalance'
        ));
    }

}
