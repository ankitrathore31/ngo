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
        try {
            // ✅ Validate input
            $validated = $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:12288', // 12MB
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'link' => 'nullable|string',
                'date' => 'nullable|date',
            ]);

            $filePaths = [];

            // ✅ Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('gallery'), $filename);
                        $filePaths[] = 'gallery/' . $filename;
                    } else {
                        \Log::warning('Invalid file skipped: ' . $file->getClientOriginalName());
                    }
                }
            }

            // ✅ Default date
            $date = $request->input('date', now()->format('Y-m-d'));

            // ✅ Convert YouTube or embed link
            $embedLink = $request->filled('link') ? $this->convertYouTubeLink($request->link) : null;

            // ✅ Save to DB
            Story::create([
                'file_path'   => json_encode($filePaths),
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'link'        => $embedLink,
                'date'        => $date,
            ]);

            return back()->with('success', 'Story added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Story upload failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while saving the story.')->withInput();
        }
    }

    /**
     * ✅ Converts YouTube URLs or embed links to a valid embeddable format
     */
    private function convertYouTubeLink($url)
    {
        if (empty($url)) return null;
        $url = trim($url);

        // Already in embed form
        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Standard YouTube link
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Non-YouTube link → keep as-is
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
