@extends('dashboard.admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Users Table</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary btn-label">
                    <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Room</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->room ? $user->room->name : '-' }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                            <td>
                                <a href="{{ route('dashboard.user.show', $user->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->links('dashboard.admin.layouts.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection
