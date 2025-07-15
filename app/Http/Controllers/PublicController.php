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

        $galleries = Gallery::select(
            'id', 
            'filename', 
            'title', 
            'categories', 
            'uploader_name', 
            'created_at'
        )->get();

        $viewGalleries = $galleries->filter(function ($gallery) {
            return is_array($gallery->categories) && in_array('view', $gallery->categories);
        });
        
        return view('public.home.index', compact('rooms', 'galleries', 'viewGalleries', 'users'));
    }
}
