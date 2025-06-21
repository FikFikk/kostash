<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $totalUsers = User::count();
        $totalTenants = User::where('role', 'tenants')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.admin.users.index', compact('users', 'search', 'totalTenants', 'totalAdmin', 'totalUsers'));
    }

    public function create()
    {
        $rooms = $this->getAvailableRooms();
        return view('dashboard.admin.users.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $validated['id'] = Str::uuid();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('dashboard.user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $rooms = $this->getAvailableRooms($user->room_id);
        return view('dashboard.admin.users.edit', compact('user', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $this->validateRequest($request, $user->id);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('dashboard.user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $rooms = Room::orderBy('name')->get();
        return view('dashboard.admin.users.show', compact('user', 'rooms'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Tidak bisa hapus admin
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $user->delete();

        return redirect()->route('dashboard.user.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    // --- PRIVATE FUNCTIONS ---

    private function validateRequest(Request $request, $userId = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', Rule::unique('users', 'phone')->ignore($userId)],
            'nik' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'date_entry' => ['nullable', 'date'],
            'role' => ['nullable', 'in:admin,tenants'],
            'status' => ['nullable', 'in:aktif,nonaktif'],
            'catatan' => ['nullable', 'string'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'password' => $userId
                ? ['nullable', 'string', 'min:6', 'confirmed']
                : ['required', 'string', 'min:6', 'confirmed'],
        ];

        return $request->validate($rules);
    }

    private function getAvailableRooms($currentRoomId = null)
    {
        $usedRoomIds = User::whereNotNull('room_id')
            ->when($currentRoomId, fn ($q) => $q->where('room_id', '!=', $currentRoomId))
            ->pluck('room_id');

        return Room::whereNotIn('id', $usedRoomIds)->orderBy('name')->get();
    }
}
