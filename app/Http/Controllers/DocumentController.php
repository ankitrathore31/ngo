<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    // Show list of all forms
    public function index()
    {
        $forms = Document::with('uploader')
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get();

        return view('ngo.document.document-list', compact('forms'));
    }

    // Show upload form
    public function create()
    {
        return view('ngo.document.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240' // 10MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Create destination folder if not exists
        $destinationPath = public_path('documents');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // ✅ Get file size BEFORE moving
        $fileSize = round($file->getSize() / 1024, 2); // in KB

        // Move file
        $file->move($destinationPath, $fileName);

        // Relative path for database
        $filePath = 'documents/' . $fileName;

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $fileSize,
            'uploaded_by' => Auth::id()
        ]);

        return redirect()->route('form-downloads.index')
            ->with('success', 'Form uploaded successfully!');
    }



    // Download file
    public function download($id)
    {
        $document = Document::findOrFail($id);
        $filePath = public_path($document->file_path);
        $document->increment('download_count');

        if (file_exists($filePath)) {
            return response()->download($filePath, $document->file_name);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }



    // Preview file (for images)
    public function preview($id)
    {
        $form = Document::findOrFail($id);

        $path = public_path($form->file_path);

        if (in_array(strtolower($form->file_type), ['jpg', 'jpeg', 'png'])) {
            if (file_exists($path)) {
                return response()->file($path);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        }

        // For PDF, redirect to download
        return redirect()->route('form-downloads.download', $id);
    }


    // Delete form (Admin only)
    public function destroy($id)
    {
        $form = Document::findOrFail($id);
        $filePath = public_path($form->file_path);

        // Delete file from public/documents
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete record
        $form->delete();

        return redirect()->route('form-downloads.index')
            ->with('success', 'Form deleted successfully!');
    }
}
