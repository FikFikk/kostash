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

        // include display flags so frontend can filter by carousel/gallery
        $allGalleries = Gallery::select(
            'id',
            'filename',
            'title',
            'categories',
            'uploader_name',
            'created_at',
            'is_gallery',
            'is_carousel'
        )->get();

        // keep a reference to all galleries (used for sensible fallbacks)
        $galleries = $allGalleries;

        // For the homepage carousel (swiper) we want items marked as carousel.
        $viewGalleries = $galleries->filter(function ($gallery) {
            return !empty($gallery->is_carousel);
        });

        // For the gallery grid, show items marked as gallery. If none are marked
        // (older data or migration not run), fall back to showing all galleries.
        $filteredGalleries = $galleries->filter(function ($gallery) {
            return !empty($gallery->is_gallery);
        });

        if ($filteredGalleries->isNotEmpty()) {
            $galleries = $filteredGalleries;
        } else {
            // fallback: if no is_gallery flags present, keep all galleries
            $galleries = $allGalleries;
        }

        // If viewGalleries is empty, try the old categories-based filter ('view').
        // Note: categories is stored as JSON in DB, so decode if needed.
        if ($viewGalleries->isEmpty()) {
            $viewGalleries = $allGalleries->filter(function ($gallery) {
                $cats = is_array($gallery->categories)
                    ? $gallery->categories
                    : json_decode($gallery->categories ?? '[]', true);

                return is_array($cats) && in_array('view', array_map('strtolower', $cats));
            });
        }

        return view('public.home.index', compact('rooms', 'galleries', 'viewGalleries', 'users'));
    }
}
