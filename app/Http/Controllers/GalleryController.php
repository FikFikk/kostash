<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(8);
        return view('admin.dashboard.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.dashboard.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateGallery($request);

        $validated['filename'] = $this->handleFileUpload($request);
        $validated['categories'] = $this->parseCategories($request->categories ?? '');

        Gallery::create($validated);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diunggah.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.dashboard.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $this->validateGallery($request, false);

        if ($request->hasFile('filename')) {
            if (Storage::disk('public')->exists($gallery->filename)) {
                Storage::disk('public')->delete($gallery->filename);
            }
            $validated['filename'] = $this->handleFileUpload($request);
        }

        $validated['categories'] = $this->parseCategories($request->categories ?? '');

        $gallery->update($validated);

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if (Storage::disk('public')->exists($gallery->filename)) {
            Storage::disk('public')->delete($gallery->filename);
        }

        $gallery->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    // -----------------------
    // ✅ Helper Methods Below
    // -----------------------

    protected function validateGallery(Request $request, $isCreate = true)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'filename' => $isCreate ? 'required|image|max:2048' : 'nullable|image|max:2048',
            'uploader_name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'categories' => 'nullable|string',
        ]);
    }

    protected function handleFileUpload(Request $request)
    {
        return $request->file('filename')->store('uploads/gallery', 'public');
    }

    protected function parseCategories($categories)
    {
        return $categories ? array_map('trim', explode(',', $categories)) : [];
    }
}
