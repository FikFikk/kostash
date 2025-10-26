@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible alert-label-icon rounded-label fade show" role="alert">
        <i class="ri-check-double-line label-icon"></i>
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
        <i class="ri-error-warning-line label-icon"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label fade show" role="alert">
        <i class="ri-alert-line label-icon"></i>
        <strong>Warning!</strong> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-info alert-dismissible alert-label-icon rounded-label fade show" role="alert">
        <i class="ri-information-line label-icon"></i>
        <strong>Info!</strong> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
        <i class="ri-error-warning-line label-icon"></i>
        <strong>Validation Error!</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
