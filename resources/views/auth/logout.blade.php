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
						<div class="card-body p-4 text-center"> 
							<lord-icon
								src="https://cdn.lordicon.com/hzomhqxz.json"
								trigger="loop"
								colors="primary:#405189,secondary:#08a88a"
								style="width:180px;height:180px">
							</lord-icon>

							<div class="mt-4 pt-2">
								<h5>You are Logged Out</h5>
								<p class="text-muted">Thank you for using <span class="fw-semibold">KostASH</span> --</p>
								<div class="mt-4">
									<a href="{{ route('auth.login') }}" class="btn btn-success w-100">Sign In</a>
								</div>
							</div>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->

				</div>
				<!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end auth page content -->
</div>
@endsection
