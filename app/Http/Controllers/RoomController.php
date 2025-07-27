<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('user')->latest('name')->paginate(10);

        // Optimized calculation using joins
        $roomStats = Room::leftJoin('users', 'rooms.id', '=', 'users.room_id')
            ->selectRaw('
                COUNT(DISTINCT rooms.id) as total_rooms,
                COUNT(DISTINCT users.id) as occupied_rooms,
                COUNT(DISTINCT rooms.id) - COUNT(DISTINCT users.id) as available_rooms
            ')->first();

        return view('dashboard.admin.room.index', [
            'rooms' => $rooms,
            'totalRooms' => $roomStats->total_rooms,
            'occupiedRooms' => $roomStats->occupied_rooms,
            'availableRooms' => $roomStats->available_rooms
        ]);
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

        return redirect()->route('dashboard.room.index')->with('success', 'Room berhasil ditambahkan.');
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
        DB::transaction(function () use ($room) {
            // Remove tenant from room if exists (assuming relationship is users.room_id = rooms.id)
            if ($room->user) {
                $room->user->update(['room_id' => null]);
            }

            // Delete room image
            $this->deleteOldImage($room->image);
            
            // Delete room
            $room->delete();
        });

        return redirect()->route('dashboard.room.index')->with('success', 'Room berhasil dihapus dan penyewa telah dipindahkan.');
    }

    /**
     * Remove tenant from room (vacate room)
     */
    public function vacate(Room $room)
    {
        if (!$room->user) {
            return redirect()->route('dashboard.room.index')->with('error', 'Kamar sudah kosong.');
        }

        DB::transaction(function () use ($room) {
            // Remove user from room
            $room->user->update(['room_id' => null]);
        });

        return redirect()->route('dashboard.room.index')->with('success', 'Kamar berhasil dikosongkan.');
    }

    // -----------------------
    // ✅ Helper Methods Below
    // -----------------------

    protected function validateRoom(Request $request, $roomId = null)
    {
        $uniqueNameRule = 'required|string|max:255|unique:rooms,name';
        if ($roomId) {
            $uniqueNameRule .= ',' . $roomId;
        }

        return $request->validate([
            'name'        => $uniqueNameRule,
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'width'       => 'nullable|numeric|min:0',
            'length'      => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'status'      => 'required|in:available,occupied',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'string|max:100',
        ], [
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'name.unique' => 'Nama kamar sudah digunakan.',
            'width.min' => 'Lebar kamar tidak boleh negatif.',
            'length.min' => 'Panjang kamar tidak boleh negatif.',
        ]);
    }

    protected function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('uploads/rooms', $filename, 'public');
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

        if (empty($facilities)) {
            return null;
        }

        if (is_string($facilities)) {
            $facilities = array_filter(array_map('trim', explode(',', $facilities)));
        }

        if (is_array($facilities)) {
            $facilities = array_filter($facilities, function($item) {
                return !empty(trim($item));
            });
        }

        return !empty($facilities) ? json_encode(array_values($facilities)) : null;
    }
}
