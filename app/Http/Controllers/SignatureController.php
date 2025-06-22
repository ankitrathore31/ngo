<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function addSignature()
    {
        $signatures = Signature::pluck('file_path', 'role');
        // Returns: ['program_manager' => 'images/pm.png', 'director' => 'images/director.png']

        return view('ngo.signature.signature', compact('signatures'));
    }
    public function saveSignature(Request $request)
    {
        // Handle Program Manager Signature
        if ($request->hasFile('signature_pm')) {
            $file = $request->file('signature_pm');
            $filename = time() . '_pm.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            Signature::updateOrCreate(
                ['role' => 'program_manager'],
                ['file_path' => 'images/' . $filename]
            );
        }

        // Handle Director Signature
        if ($request->hasFile('signature_director')) {
            $file = $request->file('signature_director');
            $filename = time() . '_director.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            Signature::updateOrCreate(
                ['role' => 'director'],
                ['file_path' => 'images/' . $filename]
            );
        }

        return back()->with('success', 'Signatures saved!');
    }
}
