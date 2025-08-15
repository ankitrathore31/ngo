<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function AddVendor()
    {
        $data = academic_session::get();
        $states = config('states');
        $lastVendor = Vendor::orderBy('id', 'desc')->first();
        $lastNumber = $lastVendor ? intval(substr($lastVendor->registration_no, -5)) : 0;
        $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        $nextRegistrationNo = '3126VSF' . $nextNumber;
        return view('ngo.vendor.add-vendor', compact('data', 'states', 'nextRegistrationNo'));
    }

    public function VendorList(Request $request)
    {
        $query = Vendor::query();

        if ($request->filled('session')) {
            $query->where('academic_session', $request->session);
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $vendor = $query->get();
        $data = academic_session::all();
        $states = config('states');

        return view('ngo.vendor.vendor-list', compact('vendor', 'data', 'states'));
    }


    public function StoreVendor(Request $request)
    {
        // Get the last vendor
        $lastVendor = Vendor::orderBy('id', 'desc')->first();
        $lastNumber = $lastVendor ? intval(substr($lastVendor->registration_no, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        $registration_no = '3126VSF' . $newNumber;

        $validated = $request->validate([
            'academic_session'       => 'required',
            'registration_no'        => 'required|string|max:255',
            'registration_date'      => 'required|date',
            'shop'                   => 'required|string|max:255',
            'vendor_type'            => 'nullable|string|max:255',
            'name'                   => 'required|string|max:255',
            'village'                => 'nullable|string|max:255',
            'post'                   => 'required|string|max:255',
            'block'                  => 'required|string|max:255',
            'state'                  => 'required|string|max:255',
            'district'               => 'required|string|max:255',
            'mobile'                 => 'required|string|max:20',
            'email'                  => 'required|email|max:255',
            'shop_gst_no'            => 'nullable|string|max:50',
            'operator_gst_no'        => 'nullable|string|max:50',
            'shop_gst'               => 'nullable|mimes:jpg,jpeg,png,pdf|mimetypes:application/pdf,image/jpeg,image/png|max:5120',
            'operator_gst'           => 'nullable|mimes:jpg,jpeg,png,pdf|mimetypes:application/pdf,image/jpeg,image/png|max:5120',
            'vendor_pan_no'          => 'nullable|string|max:50',
            'operator_pan_no'        => 'nullable|string|max:50',
            'shop_pan'               => 'nullable|mimes:jpg,jpeg,png,pdf|mimetypes:application/pdf,image/jpeg,image/png|max:5120',
            'operator_pan'           => 'nullable|mimes:jpg,jpeg,png,pdf|mimetypes:application/pdf,image/jpeg,image/png|max:5120',

            // Vendor/Shop/Farm Account Detail
            'vendor_account_no'      => 'nullable|string|max:50',
            'vendor_account_holder'  => 'nullable|string|max:100',
            'vendor_bank_name'       => 'nullable|string|max:100',
            'vendor_bank_branch'     => 'nullable|string|max:100',
            'vendor_bank_ifsc'       => 'nullable|string|max:20',

            // Operator Account Detail
            'operator_account_no'    => 'nullable|string|max:50',
            'operator_account_holder' => 'nullable|string|max:100',
            'operator_bank_name'     => 'nullable|string|max:100',
            'operator_bank_branch'   => 'nullable|string|max:100',
            'operator_bank_ifsc'     => 'nullable|string|max:20',
        ]);


        $validated['registration_no'] = $registration_no;

        if ($request->hasFile('shop_gst')) {
            $file = $request->file('shop_gst');
            $filename = time() . '_shop_gst.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['shop_gst_file'] = 'images/' . $filename;
        }

        if ($request->hasFile('operator_gst')) {
            $file = $request->file('operator_gst');
            $filename = time() . '_operator_gst.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['operator_gst_file'] = 'images/' . $filename;
        }

        if ($request->hasFile('shop_pan')) {
            $file = $request->file('shop_pan');
            $filename = time() . '_shop_pan.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['shop_pan_file'] = 'images/' . $filename;
        }

        if ($request->hasFile('operator_pan')) {
            $file = $request->file('operator_pan');
            $filename = time() . '_operator_pan.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['operator_pan_file'] = 'images/' . $filename;
        }

        $vendor = Vendor::create($validated);
        $vendor->save();

        return redirect()->route('vendor.list')->with('success', 'Vendor registered successfully!');
    }

    public function EditVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $data = academic_session::all();
        return view('ngo.vendor.edit-vendor', compact('vendor', 'data'));
    }

    public function UpdateVendor(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $validated = $request->validate([
            'academic_session' => 'required',
            'registration_date' => 'required|date',
            'shop' => 'required|string|max:255',
            'vendor_type' => 'nullable|string',
            'name' => 'required|string|max:255',
            'village' => 'nullable|string',
            'post' => 'required|string',
            'block' => 'required|string',
            'state' => 'required|string',
            'district' => 'required|string',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email',
            // Vendor/Shop/Farm Account Detail
            'vendor_account_no'      => 'nullable|string|max:50',
            'vendor_account_holder'  => 'nullable|string|max:100',
            'vendor_bank_name'       => 'nullable|string|max:100',
            'vendor_bank_branch'     => 'nullable|string|max:100',
            'vendor_bank_ifsc'       => 'nullable|string|max:20',

            // Operator Account Detail
            'operator_account_no'    => 'nullable|string|max:50',
            'operator_account_holder' => 'nullable|string|max:100',
            'operator_bank_name'     => 'nullable|string|max:100',
            'operator_bank_branch'   => 'nullable|string|max:100',
            'operator_bank_ifsc'     => 'nullable|string|max:20',
        ]);

        // Handle file uploads
        foreach (['shop_gst_file', 'operator_gst_file', 'shop_pan_file', 'operator_pan_file'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('images/gst', 'public');
                $validated[$fileField] = 'storage/' . $path;
            }
        }

        $vendor->update($validated);

        return redirect()->route('vendor.list')->with('success', 'Vendor updated successfully.');
    }

    public function DeleteVendor($id)
    {

        $vendor = Vendor::findOrFail($id);
        foreach (['shop_gst_file', 'operator_gst_file', 'shop_pan_file', 'operator_pan_file'] as $fileField) {
            if (!empty($vendor->$fileField)) {
                $filePath = public_path($vendor->$fileField);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        $vendor->delete();

        return redirect()->route('vendor.list')->with('success', 'Vendor deleted successfully.');
    }

    public function ViewVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $data = academic_session::all();
        return view('ngo.vendor.view-vendor', compact('vendor', 'data'));
    }
}
