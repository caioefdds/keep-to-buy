@extends('layouts.custom-app')

@section('custom-styles')

        <!-- SINGLE-PAGE CSS -->
		<link href="{{ asset('assets/plugins/single-page/css/main.css') }}" rel="stylesheet" type="text/css">

@endsection

	@section('class')
	<div class="login-img">
	@endsection

@section('content')

			<!-- PAGE -->
			<div class="page">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="">
						</div>
					</div>
					<p-login></p-login>
				</div>
			</div>
			<!-- End PAGE -->

@endsection('content')

@section('custom-scripts')

@endsection
