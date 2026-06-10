<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NOC;
// use App\Models\NOC as ModelsNOC;

class NOCController extends Controller
{
    // ─── List ────────────────────────────────────────────────────────────────
    public function index()
    {
        $nocs = NOC::latest()->paginate(10);
        return view('ngo.noc.index', compact('nocs'));
    }

    // ─── Create form ─────────────────────────────────────────────────────────
    public function create()
    {
        return view('ngo.noc.create');
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'noc_date'           => 'required|date',
            'noc_area'           => 'required|string|max:255',
            'issuer_name'        => 'required|string|max:255',
            'issuer_designation' => 'required|string|max:255',
            'noc_file'           => 'required|file|max:10240', // 10 MB
        ]);

        $file      = $request->file('noc_file');
        $mime      = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());

        // Determine file type category
        $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        if (in_array($extension, $imageExts)) {
            $fileType = 'image';
        } elseif ($extension === 'pdf') {
            $fileType = 'pdf';
        } else {
            $fileType = 'other';
        }

        $filename = time() . '_' . uniqid() . '.' . $extension;
        $file->move(public_path('noc_files'), $filename);

        NOC::create([
            'noc_date'           => $request->noc_date,
            'noc_area'           => $request->noc_area,
            'issuer_name'        => $request->issuer_name,
            'issuer_designation' => $request->issuer_designation,
            'file_path'          => $filename,
            'file_original_name' => $file->getClientOriginalName(),
            'file_type'          => $fileType,
        ]);

        return redirect()->route('noc.index')
            ->with('success', 'NOC uploaded successfully.');
    }

    // ─── Show / View ─────────────────────────────────────────────────────────
    public function show($id)
    {
        $noc = NOC::findOrFail($id);
        return view('ngo.noc.show', compact('noc'));
    }

    // ─── Edit form ────────────────────────────────────────────────────────────
    public function edit($id)
    {
        $noc = NOC::findOrFail($id);
        return view('ngo.noc.edit', compact('noc'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $noc = NOC::findOrFail($id);

        $request->validate([
            'noc_date'           => 'required|date',
            'noc_area'           => 'required|string|max:255',
            'issuer_name'        => 'required|string|max:255',
            'issuer_designation' => 'required|string|max:255',
            'noc_file'           => 'nullable|file|max:10240',
        ]);

        $data = [
            'noc_date'           => $request->noc_date,
            'noc_area'           => $request->noc_area,
            'issuer_name'        => $request->issuer_name,
            'issuer_designation' => $request->issuer_designation,
        ];

        // Replace file only if a new one is uploaded
        if ($request->hasFile('noc_file')) {
            // Delete old file
            $oldPath = public_path('noc_files/' . $noc->file_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file      = $request->file('noc_file');
            $extension = strtolower($file->getClientOriginalExtension());

            $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
            if (in_array($extension, $imageExts)) {
                $fileType = 'image';
            } elseif ($extension === 'pdf') {
                $fileType = 'pdf';
            } else {
                $fileType = 'other';
            }

            $filename = time() . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('noc_files'), $filename);

            $data['file_path']          = $filename;
            $data['file_original_name'] = $file->getClientOriginalName();
            $data['file_type']          = $fileType;
        }

        $noc->update($data);

        return redirect()->route('noc.index')
            ->with('success', 'NOC updated successfully.');
    }

    // ─── Delete ───────────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $noc = NOC::findOrFail($id);

        $filePath = public_path('noc_files/' . $noc->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $noc->delete();

        return redirect()->route('noc.index')
            ->with('success', 'NOC deleted successfully.');
    }
}