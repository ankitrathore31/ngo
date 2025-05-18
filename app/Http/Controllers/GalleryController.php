<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\academic_session;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function gallery()
    {
        $images = Gallery::all(); // Fetch all images
        return view('ngo.gallery.gallery', compact('images'));
    }

    public function addPhotos()
    {
        return view('ngo.gallery.add_photos');
    }

    public function storePhoto(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'date' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gallery_type' => 'required',
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $file->move(public_path('gallery'), $filename);

                $date = $request->filled('date')
                    ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                    : now()->format('Y-m-d');

                Gallery::create([
                    'image' => $filename,
                    'date' => $date,
                    'gallery_type' => $request->input('gallery_type'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    public function deletePhoto($id)
    {
        $gallery = Gallery::findOrFail($id);

        
        $imagePath = public_path('gallery/' . $gallery->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
