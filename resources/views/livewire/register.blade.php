@extends('layouts.custom-app')

@section('styles')

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
							<img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img" alt="">
						</div>
					</div>
					<p-register></p-register>
				</div>
			</div>
			<!-- END PAGE -->

@endsection('content')

@section('scripts')
@endsection
