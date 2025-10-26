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
            'is_gallery' => 'nullable',
            'is_carousel' => 'nullable',
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

        // Ensure boolean flags are set (checkboxes may not be sent when unchecked)
        $validated['is_gallery'] = $request->has('is_gallery') ? true : false;
        $validated['is_carousel'] = $request->has('is_carousel') ? true : false;

        // Only set uploader_name when creating. When updating, preserve the existing
        // uploader stored in the database so edits do not change who originally uploaded.
        if ($gallery) {
            // Updating: keep original uploader
            $validated['uploader_name'] = $gallery->uploader_name;
        } else {
            // Creating: set uploader to authenticated user's name when available,
            // otherwise keep provided value or null.
            if ($request->user()) {
                $validated['uploader_name'] = $request->user()->name;
            } else {
                $validated['uploader_name'] = $validated['uploader_name'] ?? null;
            }
        }

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
