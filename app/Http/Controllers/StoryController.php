<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function TrueStory()
    {
        $stories = Story::latest()->get();
        return view('ngo.story.story', compact('stories'));
    }
    public function AddStory()
    {

        return view('ngo.story.add-story');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => [
                'nullable',
            ],
            'date' => 'nullable|date',
        ]);

        $filePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $file->move(public_path('gallery'), $filename);
                $filePaths[] = 'gallery/' . $filename;
            }
        }

        $date = $request->filled('date') ? $request->date : now()->format('Y-m-d');

        // 🧠 Optional: Convert YouTube link to embeddable format
        $embedLink = null;
        if ($request->filled('link')) {
            $embedLink = $this->convertYouTubeLink($request->link);
        }

        Story::create([
            'file_path' => json_encode($filePaths),
            'name' => $request->name,
            'description' => $request->description,
            'link' => $embedLink,
            'date' => $date,
        ]);

        return redirect()->back()->with('success', 'Story added successfully.');
    }

    /**
     * Convert YouTube URL to embed format
     */
    private function convertYouTubeLink($url)
    {
        if (
            preg_match('/youtu\.be\/([^\?]+)/', $url, $matches) ||
            preg_match('/youtube\.com\/(?:watch\?v=|embed\/)([^\&]+)/', $url, $matches)
        ) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }

    public function DeleteStory($id)
    {
        $story = Story::findOrFail($id);

        if ($story->file_path) {
            $images = json_decode($story->file_path, true);

            if (is_array($images)) {
                foreach ($images as $img) {
                    $path = public_path($img);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

        // Delete story record
        $story->delete();

        return redirect()->back()->with('success', 'Story deleted successfully.');
    }
}
