<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.gallery.index', [
            'galleries' => Gallery::latest()->paginate(8)
        ]);
    }

    public function create()
    {
        return view('dashboard.admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateGallery($request);
        $data = $this->prepareGalleryData($request, $validated);

        Gallery::create($data);

        return redirect()->route('dashboard.gallery.index')
            ->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('dashboard.admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $this->validateGallery($request, false);
        $data = $this->prepareGalleryData($request, $validated, $gallery);

        $gallery->update($data);

        return redirect()->route('dashboard.gallery.index')
            ->with('success', 'Gambar berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->deleteFile($gallery->filename);
        $gallery->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    // -----------------------
    // ✅ Helper Methods
    // -----------------------

    protected function validateGallery(Request $request, bool $isCreate = true): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'filename' => ($isCreate ? 'required' : 'nullable') . '|image|max:2048',
            'uploader_name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'preset_categories' => 'nullable|array',
            'preset_categories.*' => 'string|max:50',
            'custom_categories' => 'nullable|string',
        ]);
    }

    protected function prepareGalleryData(Request $request, array $validated, ?Gallery $gallery = null): array
    {
        // Handle file upload
        if ($request->hasFile('filename')) {
            if ($gallery) {
                $this->deleteFile($gallery->filename);
            }

            $validated['filename'] = $request->file('filename')->store('uploads/gallery', 'public');
        }

        // Parse categories
        $validated['categories'] = $this->parseCategories(
            $request->input('preset_categories', []),
            $request->input('custom_categories', '')
        );

        return $validated;
    }

    protected function parseCategories($preset = [], $custom = ''): array
    {
        $customArray = $custom ? array_map('trim', explode(',', $custom)) : [];
        return array_values(array_filter(array_unique(array_merge($preset, $customArray))));
    }

    protected function deleteFile(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
