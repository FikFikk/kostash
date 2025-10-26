<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Room;

class PublicController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['users' => function ($query) {
            $query->select('id', 'name', 'room_id');
        }])
            ->select('id', 'name', 'image', 'facilities')
            ->get();

        $users = $rooms->pluck('users')->flatten();

        // Strict: load only galleries explicitly flagged for each display
        $viewGalleries = Gallery::select('id', 'filename', 'title', 'categories', 'uploader_name', 'created_at')
            ->where('is_carousel', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $galleries = Gallery::select('id', 'filename', 'title', 'categories', 'uploader_name', 'created_at')
            ->where('is_gallery', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.home.index', compact('rooms', 'galleries', 'viewGalleries', 'users'));
    }
}
