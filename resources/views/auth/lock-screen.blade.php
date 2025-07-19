@extends('auth.app')

@section('title') Login @endsection

@section('content')
<div class="auth-page-wrapper pt-5">
    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
				<div class="col-lg-12">
					<div class="text-center mt-sm-5 mb-4 text-white-50">
						<div>
							<a href="/" class="d-inline-block auth-logo">
								<img src="{{ asset('assets/images/kostash-logo-tp-white.png') }}" alt="kostash.id" height="35">
							</a>
						</div>
						<p class="mt-3 fs-15 fw-medium">Kos asik, Bayar tinggal klik! di KostASH</p>
					</div>
				</div>
			</div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Lock Screen</h5>
                                <p class="text-muted">Enter your password to unlock the screen!</p>
                            </div>
                            
                            <div class="user-thumb text-center">
                                @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/uploads/profile/' . auth()->user()->photo) }}" 
                                         class="rounded-circle img-thumbnail avatar-lg" 
                                         alt="Profile Picture" 
                                         style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff&size=120&font-size=0.4"
                                         class="rounded-circle img-thumbnail avatar-lg" 
                                         alt="Avatar">
                                @endif
                                <h5 class="font-size-15 mt-3">{{ auth()->user()->name }}</h5>
                            </div>
                            
                            @if(session('lock_time'))
                                <div class="text-center mb-3">
                                    <small class="text-muted">Locked at {{ session('lock_time')->format('H:i:s') }} WIB</small>
                                </div>
                            @endif
                            
                            <div class="p-2 mt-4">
                                <form action="{{ route('auth.unlock.process') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                            id="password" name="password" placeholder="Enter password" required autofocus>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 mt-4">
                                        <button class="btn btn-success w-100" type="submit">Unlock</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-0">Not you? return <a href="{{ route('auth.login') }}" class="fw-semibold text-primary text-decoration-underline">Sign in</a></p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>

@endsection
