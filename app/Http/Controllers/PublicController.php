<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Room;
use App\Models\User;

class PublicController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $users = User::whereNotNull('room_id')->get();
        $galleries = Gallery::all();
        $viewGalleries = Gallery::whereJsonContains('categories', 'view')->get();
        return view('public.home.index', compact('galleries', 'viewGalleries', 'rooms', 'users'));
    }
}
