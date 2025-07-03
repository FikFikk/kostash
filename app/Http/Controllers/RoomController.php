<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $roomsQuery = Room::query();

        $totalRooms = (clone $roomsQuery)->count();
        
        $occupiedRooms = (clone $roomsQuery)->whereHas('user')->count();
        
        $availableRooms = $totalRooms - $occupiedRooms;

        $rooms = $roomsQuery->with('user')->latest('name')->paginate(10);

        return view('dashboard.admin.room.index', compact(
            'rooms',
            'totalRooms',
            'occupiedRooms',
            'availableRooms'
        ));
    }

    public function create()
    {
        return view('dashboard.admin.room.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRoom($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request);
        }

        $validated['facilities'] = $this->processFacilities($request);

        Room::create($validated);

        return redirect()->route('dsahboard.room.index')->with('success', 'Room berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('dashboard.admin.room.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $this->validateRoom($request, $room->id);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($room->image);
            $validated['image'] = $this->uploadImage($request);
        }

        $validated['facilities'] = $this->processFacilities($request);

        $room->update($validated);

        return redirect()->route('dashboard.room.index')->with('success', 'Room berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $this->deleteOldImage($room->image);
        $room->delete();

        return redirect()->route('dashboard.room.index')->with('success', 'Room berhasil dihapus.');
    }

    // -----------------------
    // ✅ Helper Methods Below
    // -----------------------

    protected function validateRoom(Request $request, $roomId = null)
    {
        $uniqueNameRule = 'required|unique:rooms,name';
        if ($roomId) {
            $uniqueNameRule .= ',' . $roomId;
        }

        return $request->validate([
            'name'        => $uniqueNameRule,
            'image'       => 'nullable|image|max:2048',
            'width'       => 'nullable|numeric',
            'length'      => 'nullable|numeric',
            'description' => 'nullable|string',
            'status'      => 'required|in:available,occupied',
            'facilities'  => 'nullable|array',
        ], [
            'image.max' => 'The image size must not exceed 2MB.',
            'image.image' => 'The uploaded file must be an image (jpg, png, etc.).',
        ]);
    }

    protected function uploadImage(Request $request)
    {
        return $request->file('image')->store('uploads/rooms', 'public');
    }

    protected function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    protected function processFacilities(Request $request)
    {
        $facilities = $request->facilities;

        if (is_string($facilities)) {
            $facilities = array_map('trim', explode(',', $facilities));
        }

        return $facilities ? json_encode($facilities) : null;
    }
}
