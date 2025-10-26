<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        if (!isset($data['filename'])) {
            $data['filename'] = '';
        }

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
        // Adjust validation depending on whether filename is an uploaded file or a base64 data URL
        $rules = [
            'title' => 'required|string|max:255',
            'uploader_name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_gallery' => 'nullable',
            'is_carousel' => 'nullable',
            'preset_categories' => 'nullable|array',
            'preset_categories.*' => 'string|max:50',
            'custom_categories' => 'nullable|string',
        ];

        // If the request contains an uploaded file, validate as file image (max in KB)
        $messages = [];
        if ($request->hasFile('filename')) {
            // Multipart uploaded file — validate as an image with a 2MB max
            $rules['filename'] = ($isCreate ? 'required' : 'nullable') . '|image|max:2048';
        } else {
            // When a string is provided it should be a short token/path (e.g. uploads/tmp/...) or base64 data URL
            $rules['filename'] = ($isCreate ? 'required' : 'nullable') . '|string|max:500000';

            $filenameInput = $request->input('filename');
            if (is_string($filenameInput)) {
                // Allow any string input for filename
            }
        }

        return $request->validate($rules, $messages);
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

        // Handle FilePond async upload token: FilePond will upload the file to
        // a temporary location and submit a short token (the stored path). If the
        // provided filename is a string and exists on the public disk (tmp upload),
        // move it into the final gallery folder.
        if (!isset($validated['filename']) && $request->filled('filename') && is_string($request->input('filename'))) {
            $token = $request->input('filename');
            // Only accept tokens that reference our temporary folder for safety
            if (str_starts_with($token, 'uploads/tmp/') && Storage::disk('public')->exists($token)) {
                // Delete old file if exists
                if ($gallery) {
                    $this->deleteFile($gallery->filename);
                }

                $ext = pathinfo($token, PATHINFO_EXTENSION) ?: 'png';
                $newPath = 'uploads/gallery/' . Str::random(20) . '.' . $ext;
                Storage::disk('public')->move($token, $newPath);
                $validated['filename'] = $newPath;
            } elseif (str_starts_with($token, 'uploads/gallery/')) {
                // If it's already a gallery path, keep it
                $validated['filename'] = $token;
            } else {
                // Token is not valid — ensure we don't keep a bad filename value in the
                // validated data (prevents inserting HTML or arbitrary long strings).
                if (array_key_exists('filename', $validated)) {
                    unset($validated['filename']);
                }
            }
        }

        // Handle base64 data URL
        if (!isset($validated['filename']) && $request->filled('filename') && is_string($request->input('filename'))) {
            $input = $request->input('filename');
            if (str_starts_with($input, 'data:image/')) {
                // It's a base64 data URL
                if ($gallery) {
                    $this->deleteFile($gallery->filename);
                }

                $dataUrl = $input;
                $parts = explode(',', $dataUrl);
                if (count($parts) === 2) {
                    $mimePart = $parts[0];
                    $base64 = $parts[1];
                    $mime = explode(';', $mimePart)[0];
                    $ext = explode('/', $mime)[1] ?? 'png';
                    $content = base64_decode($base64);
                    if ($content !== false) {
                        $filename = 'uploads/gallery/' . Str::random(20) . '.' . $ext;
                        Storage::disk('public')->put($filename, $content);
                        $validated['filename'] = $filename;
                    }
                }
            }
        }        // Note: base64/data URL inputs are intentionally not supported here. File uploads must be sent
        // as multipart files (standard file upload) or via FilePond's async server.process flow. This
        // keeps filenames on disk as real files and avoids storing raw base64 in the DB.

        // If filename was present in the validated data but no file was uploaded,
        // keep it even if empty, to avoid DB error.
        // if (!$request->hasFile('filename') && array_key_exists('filename', $validated) && empty($validated['filename'])) {
        //     unset($validated['filename']);
        // }

        // Ensure only valid file paths are kept (starting with 'uploads/')
        // if (isset($validated['filename']) && !empty($validated['filename']) && !str_starts_with($validated['filename'], 'uploads/')) {
        //     unset($validated['filename']);
        // }

        // Prevent HTML injection
        if (isset($validated['filename']) && strpos($validated['filename'], '<') !== false) {
            unset($validated['filename']);
        }

        // Parse categories
        $validated['categories'] = $this->parseCategories(
            $request->input('preset_categories', []),
            $request->input('custom_categories', '')
        );

        // Ensure boolean flags are set (checkboxes may not be sent when unchecked)
        $validated['is_gallery'] = $request->has('is_gallery') ? true : false;
        $validated['is_carousel'] = $request->has('is_carousel') ? true : false;

        // Set uploader_name automatically from the authenticated user (if available).
        // If no authenticated user, preserve existing value when updating, or null on create.
        if ($request->user()) {
            $validated['uploader_name'] = $request->user()->name;
        } else {
            // If updating and no auth (edge case), keep existing gallery uploader_name
            if ($gallery) {
                $validated['uploader_name'] = $gallery->uploader_name;
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
