@extends('layouts.app')

@section('styles')

@endsection

@section('content')

						<!-- PAGE-HEADER -->
						<div class="page-header">
							<div>
								<h1 class="page-title">Thumbnails</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Elements</a></li>
									<li class="breadcrumb-item active" aria-current="page">Thumbnails</li>
								</ol>
							</div>
							<div class="ms-auto pageheader-btn">
								<a href="#" class="btn btn-primary btn-icon text-white me-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Account
								</a>
								<a href="#" class="btn btn-success btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
								</a>
							</div>
						</div>
						<!-- PAGE-HEADER END -->

						<!-- ROW-1 OPEN -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Basic Thumbnails</h3>
									</div>
									<div class="card-body">
										<div class="example">
											<div class="row mt-4">
												<div class="col-md-6 col-xl-3">
													<a href="#" class="thumbnail ">
														<img src="{{ asset('assets/images/media/1.jpg')}}" alt="thumb1" class="thumbimg">
													</a>
												</div>
												<div class="col-md-6 col-xl-3">
													<a href="#" class="thumbnail">
														<img src="{{ asset('assets/images/media/2.jpg')}}" alt="thumb1" class="thumbimg">
													</a>
												</div>
												<div class="col-md-6 col-xl-3">
													<a href="#" class="thumbnail">
														<img src="{{ asset('assets/images/media/3.jpg')}}" alt="thumb1" class="thumbimg">
													</a>
												</div>
												<div class="col-md-6 col-xl-3">
													<a href="#" class="thumbnail">
														<img src="{{ asset('assets/images/media/5.jpg')}}" alt="thumb1" class="thumbimg">
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- ROW-1 CLOSED -->

						<!-- ROW-2 OPEN -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Custom content Thumbnails</h3>
									</div>
									<div class="card-body">
										<div class="example">
											<div class="row mt-4">
												<div class="col-md-12 col-xl-4">
													<div class="thumbnail">
														<a href="#">
															<img src="{{ asset('assets/images/media/19.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
															<p>
																<a href="#" class="btn btn-primary" role="button">Button</a>
																<a href="#" class="btn btn-secondary" role="button">Button</a>
															</p>
														</div>
													</div>
												</div><!-- COL-END -->
												<div class="col-md-12 col-xl-4">
													<div class="thumbnail">
														<a href="#">
															<img src="{{ asset('assets/images/media/20.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
															<p>
																<a href="#" class="btn btn-primary" role="button">Button</a>
																<a href="#" class="btn btn-secondary" role="button">Button</a>
															</p>
														</div>
													</div>
												</div><!-- COL-END -->
												<div class="col-md-12 col-xl-4">
													<div class="thumbnail">
														<a href="#">
															<img src="{{ asset('assets/images/media/21.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
															<p>
																<a href="#" class="btn btn-primary" role="button">Button</a>
																<a href="#" class="btn btn-secondary" role="button">Button</a>
															</p>
														</div>
													</div>
												</div><!-- COL-END -->
											</div>
										</div>
									</div>
								</div>
							</div><!-- COL-END -->
						</div>
						<!-- ROW-2 CLOSED -->

						<!-- ROW-3 OPEN -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Custom content Thumbnails</h3>
									</div>
									<div class="card-body">
										<div class="example">
											<div class="row mt-4">
												<div class="col-md-12 col-lg-6 col-xl-3">
													<div class="thumbnail">
														<a href="#">
															<img src="{{ asset('assets/images/media/22.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incidi dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
														</div>
													</div>
												</div>
												<div class="col-md-12 col-lg-6 col-xl-3">
													<div class="thumbnail">
														<a href="#">
															<img src="{{ asset('assets/images/media/23.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incidi dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
														</div>
													</div>
												</div>
												<div class="col-md-12 col-lg-6 col-xl-3">
													<div class="thumbnail">
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incidi dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
														</div>
														<a href="#">
															<img src="{{ asset('assets/images/media/24.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
													</div>
												</div>
												<div class="col-md-12 col-lg-6 col-xl-3">
													<div class="thumbnail">
														<div class="caption">
															<h4><strong>Thumbnail label</strong></h4>
															<p>sed do eiusmod tempor incidi dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
														</div>
														<a href="#">
															<img src="{{ asset('assets/images/media/25.jpg')}}" alt="thumb1" class="thumbimg">
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- COL-END -->
						</div>
						<!-- ROW-3 CLOSED -->

@endsection('content')

@section('scripts')

		<!-- C3 CHART JS -->
		<script src="{{ asset('assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
		<script src="{{ asset('assets/plugins/charts-c3/c3-chart.js')}}"></script>

@endsection
