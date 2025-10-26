<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Handle FilePond process (async upload).
     * Expects the file field name to be 'file'. Returns a short token (the stored path).
     */
    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'file.max' => 'Ukuran gambar maksimal 2MB.',
            'file.image' => 'File harus berupa gambar.'
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension() ?: 'png';
        // Build readable temporary filename: {timestamp}_{slug(original_name)}_{rand}.{ext}
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($originalName) ?: 'file';
        $filename = 'uploads/tmp/' . time() . '_' . $slug . '_' . Str::random(6) . '.' . $ext;
        Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));

        // Return the token as plain text (FilePond will use the response text as the file id)
        return response($filename, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Handle FilePond revert (delete temporary file).
     * FilePond sends the file id in the request body.
     */
    public function revert(Request $request)
    {
        $token = $request->getContent();
        if ($token && Storage::disk('public')->exists($token)) {
            Storage::disk('public')->delete($token);
        }

        return response('', 200);
    }
}
