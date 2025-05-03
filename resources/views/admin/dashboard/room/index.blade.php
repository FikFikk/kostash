@extends('admin.dashboard.layouts.app')

@section('title', 'Room')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Room Tables</h4>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
                    <a href="{{ route('room.create') }}" class="btn btn-primary btn-label waves-effect waves-light"><i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Add Room</a>
                </div>
            </div>
        </div><!-- end card header -->  
        <div class="card-body">
            <!-- <p class="text-muted">Use <code>table-responsive</code> class to make any table responsive across all viewports. Responsive tables allow tables to be scrolled horizontally with ease.</p> -->
            <div class="live-preview">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <!-- <th scope="col" style="width: 42px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th> -->
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Facilities</th>
                                <th scope="col">Tenants</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $key => $room)
                                <tr>
                                    <!-- <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $room->id }}" name="selected_rooms[]">
                                        </div>
                                    </th> -->
                                    <td><a href="#" class="fw-medium">{{ ($rooms->currentPage() - 1) * $rooms->perPage() + $key + 1 }}</a></td>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="flex-shrink-0">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $room->id }}">
                                                    @if($room->image && file_exists(public_path('storage/'.str_replace('public/', '', $room->image))))
                                                        <img src="{{ asset('storage/'.str_replace('public/', '', $room->image)) }}" 
                                                            alt="Room Image" 
                                                            class="avatar-xs rounded-circle" 
                                                            style="cursor: pointer;" />
                                                    @else
                                                        <img src="{{ asset('assets/images/rocket-img.png') }}" 
                                                            alt="No Image" 
                                                            class="avatar-xs rounded-circle" 
                                                            style="cursor: pointer;" />
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal Popup Image -->
                                        <div class="modal fade" id="imageModal{{ $room->id }}" tabindex="-1" 
                                            aria-labelledby="imageModalLabel{{ $room->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel{{ $room->id }}">Room Image</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        @if($room->image && file_exists(public_path('storage/'.str_replace('public/', '', $room->image))))
                                                            <img src="{{ asset('storage/'.str_replace('public/', '', $room->image)) }}" 
                                                                alt="Room Image" 
                                                                class="img-fluid rounded">
                                                        @else
                                                            <div class="alert alert-info">
                                                                No image available for this room.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="{{ $room->status == 'available' ? 'text-success' : 'text-danger' }}">
                                        <i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ ucfirst($room->status) }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                        @foreach(json_decode($room->facilities ?? '[]') as $facility)
                                            @foreach(explode(',', $facility) as $item)
                                                <span class="badge badge-soft-primary badge-border">{{ trim($item) }}</span>
                                            @endforeach
                                        @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @if($room->user)
                                            <span class="text-primary">{{ $room->user->name }}</span><br>
                                            <small class="text-muted">{{ $room->user->email }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('room.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('room.destroy', $room->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table responsive -->

                <div class="d-flex justify-content-end mt-3">
                    {{ $rooms->links('admin.dashboard.layouts.pagination') }}
                </div>

                
                
            </div>
        </div><!-- end card-body -->
    </div>
</div>

@endsection
