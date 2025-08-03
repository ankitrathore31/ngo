<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Bill;
use App\Models\Bill_Item;
use App\Models\Bill_Voucher;
use App\Models\GbsBill;
use App\Models\Signature;
use App\Models\Voucher_Item;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function AddBill()
    {
        $person = Bill_Voucher::get();
        $data = academic_session::all();
        return view('ngo.bill.feed-bill', compact('data','person'));
    }

    public function StoreBill(Request $request)
    {
        $voucher = Bill_Voucher::create([
            'bill_no'            => $request->bill_no,
            'date'               => $request->date,
            'academic_session'   => $request->academic_session,
            // Seller details
            'shop'               => $request->shop,
            'role'               => $request->role,
            'name'             => $request->s_name,
            'address'          => $request->s_address,
            'mobile'           => $request->s_mobile,
            'email'            => $request->s_email,
            'gst'                => $request->gst,
            's_pan'              => $request->s_pan,
            // Buyer details
            'b_name'             => $request->b_name,
            'b_mobile'           => $request->b_mobile,
            'b_email'            => $request->b_email,
            'b_address'          => $request->b_address,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
            'igst' => $request->igst,
        ]);
        foreach ($request->items as $item) {
            Voucher_Item::create([
                'bill_voucher_id' => $voucher->id,
                'product' => $item['product'] ?? null,
                'qty' => $item['qty'] ?? null,
                'rate' => $item['rate'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Voucher saved successfully!');
    }

    public function BillList(Request $request)
    {
        $session = academic_session::all();

        // Base certificate query
        $query = Bill_Voucher::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        $record = $query->orderBy('created_at', 'desc')->get();

        $filtered = $record->filter(function ($record) use ($request) {

            $matchesApp = $request->filled('bill_no')
                ? str_contains($person->biil_no ?? '', $request->bill_no)
                : true;

            $matchesName = $request->filled('name')
                ? str_contains(strtolower($person->name ?? ''), strtolower($request->name))
                : true;

            return $matchesApp && $matchesName;
        });

        return view('ngo.bill.bill-list', [
            'session' => $session,
            'record' => $filtered,
        ]);
    }

    public function EditBill($id)
    {
        $bill = Bill_Voucher::find($id);

        $bill_id = $bill->id;

        $bill_items = Voucher_Item::where('bill_voucher_id', $bill_id)->get();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.bill.edit-bill', compact('bill', 'bill_items', 'signatures'));
    }

    public function UpdateBill(Request $request, $id)
    {
        $bill = Bill_Voucher::findOrFail($id);
        $bill->update([
            'bill_no' => $request->bill_no,
            'date' => $request->date,
            'shop' => $request->shop,
            'role' => $request->role,
            'name' => $request->s_name,
            'address' => $request->s_address,
            'mobile' => $request->s_mobile,
            'email' => $request->s_email,
            's_pan' => $request->s_pan,
            'gst_type' => $request->gst_type,
            'gst' => $request->gst_type == 'Yes' ? $request->gst : 0,
            'b_name' => $request->b_name,
            'b_mobile' => $request->b_mobile,
            'b_email' => $request->b_email,
            'b_address' => $request->b_address,
        ]);


        // Delete old items
        $bill->items()->delete();

        // Recreate updated items
        foreach ($request->items as $item) {
            $bill->items()->create($item);
        }

        return redirect()->route('bill-list')->with('success', 'Bill updated successfully!');
    }


    public function ViewBill($id)
    {
        $bill = Bill_Voucher::find($id);

        $bill_id = $bill->id;

        $bill_items = Voucher_Item::where('bill_voucher_id', $bill_id)->get();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.bill.view-bill', compact('bill', 'bill_items', 'signatures'));
    }

    public function DeleteBill($id)
    {

        $bill = Bill_Voucher::find($id);
        $bill->items()->delete();
        $bill->delete();

        return redirect()->back()->with('success', 'Voucher Deleted successfully!');
    }

    public function GenerateBill()
    {
        $states = config('states');
        $data = academic_session::all();
        return view('ngo.bill.generate-bill', compact('states', 'data'));
    }

    public function StorePersonBill(Request $request)
    {
        $validated = $request->validate([
            'academic_session' => 'required',
            'bill_date' => 'required|date',
            'name' => 'required|string',
            'guardian_name' => 'required|string',
            'village' => 'nullable|string',
            'post' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'branch' => 'required|string',
            'centre' => 'required|string',
            'date' => 'required|date',
            'work' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'cheque_no' => 'nullable|string',
            'transaction_no' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'branch_name' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'place' => 'required|string',
        ]);

        $bill = GbsBill::create($validated);

        return redirect()->route('gbs-bill-list')->with('success', 'Bill created successfully.');
    }

    public function EditPersonBill($id)
    {

        $states = config('states');
        $data = academic_session::all();
        $bill = GbsBill::find($id);
        return view('ngo.bill.edit-person-bill', compact('states', 'data', 'bill'));
    }

    public function UdatePersonBill(Request $request, $id)
    {
        $validated = $request->validate([
            'academic_session' => 'nullable|string',
            'ngo_id' => 'nullable|string',
            'bill_date' => 'required|date',
            'name' => 'required|string',
            'guardian_name' => 'required|string',
            'village' => 'nullable|string',
            'post' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'branch' => 'required|string',
            'centre' => 'required|string',
            'date' => 'required|date',
            'work' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'cheque_no' => 'nullable|string',
            'transaction_no' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'branch_name' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
            'place' => 'required|string',
        ]);

        $bill = GbsBill::findOrFail($id);
        $bill->update($validated);

        return redirect()->route('gbs-bill-list')->with('success', 'Bill update successfully.');
    }

    public function DeletePersonBill($id)
    {

        $bill = GbsBill::find($id);
        $bill->delete();

        return redirect()->back()->with('success', 'Gbs Bill Deleted successfully!');
    }

    public function PersonBillList(Request $request)
    {
        $session = academic_session::all();

        // Base certificate query
        $query = GbsBill::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        $record = $query->orderBy('created_at', 'desc')->get();

        $filtered = $record->filter(function ($record) use ($request) {

            $matchesApp = $request->filled('centre')
                ? str_contains($person->centre ?? '', $request->centre)
                : true;

            $matchesName = $request->filled('name')
                ? str_contains(strtolower($person->name ?? ''), strtolower($request->name))
                : true;

            return $matchesApp && $matchesName;
        });

        return view('ngo.bill.person-bill-list', [
            'session' => $session,
            'record' => $filtered,
        ]);
    }

    public function ViewPersonBill($id)
    {
        $bill = GbsBill::find($id);
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.bill.view-person-bill', compact('bill', 'signatures'));
    }


    public function StoreGbsBill(Request $request)
    {
        $voucher = Bill::create([
            'bill_no'            => $request->bill_no,
            'date'               => $request->date,
            'academic_session'   => $request->academic_session,
            'shop'               => $request->shop,
            'name'             => $request->name,
            'email'          => $request->email,
            'mobile'           => $request->mobile,
            'address'            => $request->address,
            'block'            => $request->block,
            'district'            => $request->district,
            'state'            => $request->state,
            'gst'                => $request->gst,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
        ]);
        foreach ($request->items as $item) {
            Bill_Item::create([
                'bill_id' => $voucher->id,
                'product' => $item['product'] ?? null,
                'qty' => $item['qty'] ?? null,
                'rate' => $item['rate'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'GBS Bill saved successfully!');
    }

    public function GbsBillList(Request $request)
    {
        $session = academic_session::all();

        // Build query with filters
        $query = Bill::query();

        if ($request->filled('session_filter')) {
            $query->where('academic_session', $request->session_filter);
        }

        if ($request->filled('bill_no')) {
            $query->where('bill_no', 'like', '%' . $request->bill_no . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        $record = $query->orderBy('created_at', 'desc')->get();

        return view('ngo.bill.gbs-bill-list', [
            'session' => $session,
            'record' => $record,
        ]);
    }


    public function EditGbsBill($id)
    {
        $gbsBill = Bill::find($id);
        $bill_id = $gbsBill->id;
        $bill_items = Bill_Item::where('bill_id', $bill_id)->get();
        $data = academic_session::all();
        $states = config('states');
        return view('ngo.bill.edit-gbs-bill', compact('gbsBill', 'bill_items', 'data', 'states'));
    }

    public function UpdateGbsBill(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);
        $bill->update([
            'bill_no'            => $request->bill_no,
            'date'               => $request->date,
            'academic_session'   => $request->academic_session,
            'shop'               => $request->shop,
            'name'             => $request->name,
            'email'          => $request->email,
            'mobile'           => $request->mobile,
            'address'            => $request->address,
            'block'            => $request->block,
            'district'            => $request->district,
            'state'            => $request->state,
            'gst'                => $request->gst,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst,
        ]);


        // Delete old items
        $bill->items()->delete();

        // Recreate updated items
        foreach ($request->items as $item) {
            $bill->items()->create($item);
        }

        return redirect()->route('gbs-bill-list')->with('success', 'Gbs Bill updated successfully!');
    }


    public function ViewGbsBill($id)
    {
        $bill = Bill::find($id);
        $bill_id = $bill->id;
        $bill_items = Bill_Item::where('bill_id', $bill_id)->get();
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.bill.view-gbs-bill', compact('bill', 'bill_items', 'signatures'));
    }

    public function DeleteGbsBill($id)
    {

        $bill = Bill::find($id);
        $bill->items()->delete();
        $bill->delete();

        return redirect()->back()->with('success', 'GBS Bill Deleted successfully!');
    }
}
