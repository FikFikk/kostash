<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::orderBy('created_at', 'asc')->with('user')->paginate(10);
        return view('admin.room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.room.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:rooms,name',
            'image' => 'nullable|image|max:2048',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied',
            'facilities' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/rooms', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->has('facilities')) {
            $facilities = $request->facilities;
        
            if (is_string($facilities)) {
                $facilities = array_map('trim', explode(',', $facilities));
            }
        
            $validated['facilities'] = json_encode($facilities);
        } else {
            $validated['facilities'] = null;
        }

        Room::create($validated);

        return redirect()->route('room.home')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.room.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|unique:rooms,name,' . $room->id,
            'image' => 'nullable|image|max:2048',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied',
            'facilities' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $imagePath = $request->file('image')->store('uploads/rooms', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['facilities'] = $request->has('facilities') ? json_encode($request->facilities) : null;

        $room->update($validated);

        return redirect()->route('room.home')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('room.home')->with('success', 'Room deleted successfully.');
    }
}
