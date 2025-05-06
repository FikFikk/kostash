<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class PublicController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        $viewGalleries = Gallery::whereJsonContains('categories', 'view')->get();
        return view('public.home.index', compact('galleries', 'viewGalleries'));
    }
}
