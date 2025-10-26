@extends('dashboard.admin.layouts.app')

@section('title', 'Room')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Create Room</h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <!-- <label for="form-grid-showcode" class="form-label text-muted">Show Code</label>
                        <input class="form-check-input code-switcher"  type="checkbox" id="form-grid-showcode"> -->
                    </div>
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <!-- <p class="text-muted">More complex forms can be built using our grid classes. Use these for form layouts that require multiple columns, varied widths, and additional alignment options. <span class="fw-medium">Requires the <code>$enable-grid-classes</code> Sass variable to be enabled</span> (on by default).</p> -->
                <div class="live-preview">
                    <form action="{{ route('dashboard.room.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter room name">
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Room Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*"
                                onchange="validateFileSize(this)">
                            <br><small id="image-error" style="color:red;"></small>
                        </div>

                        <div class="mb-3">
                            <label for="width" class="form-label">Width (m)</label>
                            <input type="number" step="0.1" class="form-control" name="width" id="width"
                                placeholder="Enter width" value="3.5">
                        </div>

                        <div class="mb-3">
                            <label for="length" class="form-label">Length (m)</label>
                            <input type="number" step="0.1" class="form-control" name="length" id="length"
                                placeholder="Enter length" value="5">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Room description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="facilities" class="form-label text-muted">Facilities</label>
                            <p class="text-muted">Select up to 3 facilities.</p>
                            <input type="text" class="form-control" name="facilities[]" id="facilities" data-choices
                                data-choices-limit="3" data-choices-removeItem multiple />
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
                <div class="d-none code-view">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const facilitiesInput = document.getElementById('facilities');
            if (facilitiesInput) {
                new Choices(facilitiesInput, {
                    removeItemButton: true,
                    maxItemCount: 3,
                });
            }
        });
    </script>
@endsection
