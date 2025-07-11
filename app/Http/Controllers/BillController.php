<?php

namespace App\Http\Controllers;

use App\Models\Bill_Voucher;
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
}
