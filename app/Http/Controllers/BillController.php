<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Bill_Voucher;
use App\Models\Signature;
use App\Models\Voucher_Item;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function AddBill()
    {
        return view('ngo.bill.add-bill');
    }

    public function StoreBill(Request $request)
    {
        $voucher = Bill_Voucher::create([
            'bill_no' => $request->bill_no,
            'name' => $request->name,
            'shop' => $request->shop,
            'date' => $request->date,
            'address' => $request->address,
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
                ? str_contains($person->letterNo ?? '', $request->letterNo)
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
        $bill->update($request->only(['bill_no', 'shop', 'name', 'date', 'address']));

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
}
