@extends('layouts.app')

@section('styles')

@endsection

@section('content')

										<!-- PAGE-HEADER -->
										<div class="page-header">
											<div>
												<h1 class="page-title">Headers</h1>
												<ol class="breadcrumb">
													<li class="breadcrumb-item"><a href="#">Advanced Elements</a></li>
													<li class="breadcrumb-item active" aria-current="page">Headers</li>
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
				
										<div class="row">
											<div class="col-md-12">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">Default Header</h3>
													</div>
													<div class="header header-1 p-4">
														<div class="container">
															<div class="d-flex">
																<a class="animated-arrow horizontal-navtoggle-1"><span></span></a>
																<a class="header-brand" href="{{ url('index')}}">
																	<img src="{{ asset('assets/images/brand/logo-3.png')}}" class="header-brand-img logo-3" alt="Zanex logo">
																	<img src="{{ asset('assets/images/brand/logo.png')}}" class="header-brand-img logo" alt="Zanex logo">
																</a><!-- LOGO -->
																<div class="d-flex order-lg-2 ms-auto header-right-icons">
																	<a href="#" data-bs-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="ion ion-search"></i></a>
																	<div class="default-header">
																		<form class="form-inline">
																			<div class="search-element">
																				<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
																				<button class="btn btn-primary-color" type="submit"><i class="ion ion-search"></i></button>
																			</div>
																		</form>
																	</div><!-- SEARCH -->
																	<div class="dropdown d-md-flex">
																		<a class="nav-link icon full-screen-link nav-link-bg">
																			<i class="fe fe-maximize-2" id="fullscreen-button1"></i>
																		</a>
																	</div><!-- FULL-SCREEN -->
																	<div class="dropdown d-md-flex notifications">
																		<a class="nav-link icon" data-bs-toggle="dropdown">
																			<i class="fe fe-bell"></i>
																			<span class="nav-unread badge bg-success rounded-pill">2</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<a href="#" class="dropdown-item mt-2 d-flex pb-3">
																				<div class="notifyimg bg-success">
																					<i class="fa fa-thumbs-o-up"></i>
																				</div>
																				<div>
																					<strong>Someone likes our posts.</strong>
																					<div class="small text-muted">3 hours ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-warning">
																					<i class="fa fa-commenting-o"></i>
																				</div>
																				<div>
																					<strong> 3 New Comments</strong>
																					<div class="small text-muted">5  hour ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-danger">
																					<i class="fa fa-cogs"></i>
																				</div>
																				<div>
																					<strong> Server Rebooted.</strong>
																					<div class="small text-muted">45 mintues ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item text-center p-3 text-muted">View all Notification</a>
																		</div>
																	</div><!-- NOTIFICATIONS -->
																	<div class="dropdown d-md-flex message">
																		<a class="nav-link icon text-center" data-bs-toggle="dropdown">
																			<i class="fe fe-message-square"></i>
																			<span class=" nav-unread badge bg-danger  rounded-pill">6</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<a href="#" class="dropdown-item d-flex mt-2 pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/4.jpg')}}">
																					<span class="avatar-status bg-green"></span>
																				</div>
																				<div>
																					<strong>Madeleine</strong>
																					<p class="mb-0 fs-13 text-muted ">Hey! there I' am available</p>
																					<div class="small text-muted">3 hours ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/1.jpg')}}">
																					<span class="avatar-status bg-red"></span>
																				</div>
																				<div>
																					<strong>Anthony</strong>
																					<p class="mb-0 fs-13 text-muted ">New product Launching</p>
																					<div class="small text-muted">5  hour ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/18.jpg')}}">
																					<span class="avatar-status bg-yellow"></span>
																				</div>
																				<div>
																					<strong>Olivia</strong>
																					<p class="mb-0 fs-13 text-muted ">New Schedule Realease</p>
																					<div class="small text-muted">45 mintues ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item text-center p-3 text-muted">See all Messages</a>
																		</div>
																	</div><!-- MESSAGE-BOX -->
																	<div class="dropdown text-center selector profile-1">
																		<a href="#" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
																			<span><img src="{{ asset('assets/images/users/8.jpg')}}" alt="profile-user" class="avatar avatar-sm brround cover-image mb-1 ms-0"></span>
																			<span class=" ms-3 d-none d-lg-block ">
																				<span class="text-dark">Elizabeth Dyer</span>
																			</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<div class="drop-heading">
																				<div class="text-center">
																					<h5 class="text-dark mb-0">Elizabeth Dyer</h5>
																					<small class="text-muted">Administrator</small>
																				</div>
																			</div>
																			<div class="dropdown-divider m-0"></div>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-account-outline"></i> Profile
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon  mdi mdi-settings"></i> Settings
																			</a>
																			<a class="dropdown-item" href="#">
																				<span class="float-end"></span>
																				<i class="dropdown-icon mdi  mdi-message-outline"></i> Inbox
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-comment-check-outline"></i> Message
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-compass-outline"></i> Need help?
																			</a>
																			<a class="dropdown-item" href="{{ url('login')}}">
																				<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
																			</a>
																		</div>
																	</div><!-- PROFILE -->
																</div>
															</div>
														</div>
													</div>
													<!-- HEADER END -->
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">Header Style-01</h3>
													</div>
													<div class="header header-2 p-4">
														<div class="container">
															<nav class=" navbar header-nav navbar-expand-lg main-navbar p-0">
																<a class="animated-arrow horizontal-navtoggle-1"><span></span></a>
																<a class="header-brand" href="{{ url('index')}}">
																	<img src="{{ asset('assets/images/brand/logo-3.png')}}" class="header-brand-img logo-3" alt="Zanex logo">
																	<img src="{{ asset('assets/images/brand/logo.png')}}" class="header-brand-img logo" alt="Zanex logo">
																</a>
																<ul class="navbar-nav navbar-right me-auto">
																	<li class="dropdown dropdown-list-toggle envelope"><a href="#" data-bs-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><span class="badge bg-danger nav-link-badge">5</span><i class="fe fe-message-square"></i></a>
																		<div class="dropdown-menu dropdown-list dropdown-menu-end">
																			<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow show">
																				<a href="#" class="dropdown-item d-flex mt-2 pb-3">
																					<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/4.jpg')}}">
																						<span class="avatar-status bg-green"></span>
																					</div>
																					<div>
																						<strong>Madeleine</strong>
																						<p class="mb-0 fs-13 text-muted ">Hey! there I' am available</p>
																						<div class="small text-muted">3 hours ago</div>
																					</div>
																				</a>
																				<a href="#" class="dropdown-item d-flex pb-3">
																					<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/1.jpg')}}">
																						<span class="avatar-status bg-red"></span>
																					</div>
																					<div>
																						<strong>Anthony</strong>
																						<p class="mb-0 fs-13 text-muted ">New product Launching</p>
																						<div class="small text-muted">5  hour ago</div>
																					</div>
																				</a>
																				<a href="#" class="dropdown-item d-flex pb-3">
																					<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/18.jpg')}}">
																						<span class="avatar-status bg-yellow"></span>
																					</div>
																					<div>
																						<strong>Olivia</strong>
																						<p class="mb-0 fs-13 text-muted ">New Schedule Realease</p>
																						<div class="small text-muted">45 mintues ago</div>
																					</div>
																				</a>
																				<a href="#" class="dropdown-item text-center p-3 text-muted">See all Messages</a>
																			</div>
																		</div>
																	</li>
																	<li class="dropdown dropdown-list-toggle d-none d-sm-block"><a href="#" data-bs-toggle="dropdown" class="nav-link  nav-link-lg "><span class="badge bg-secondary nav-link-badge">6</span><i class="fe fe-bell"></i></a>
																		<div class="dropdown-menu  dropdown-menu-arrow ">
																			<a href="#" class="dropdown-item mt-2 d-flex pb-3">
																				<div class="notifyimg bg-success">
																					<i class="fa fa-thumbs-o-up"></i>
																				</div>
																				<div>
																					<strong>Someone likes our posts.</strong>
																					<div class="small text-muted">3 hours ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-warning">
																					<i class="fa fa-commenting-o"></i>
																				</div>
																				<div>
																					<strong> 3 New Comments</strong>
																					<div class="small text-muted">5  hour ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-danger">
																					<i class="fa fa-cogs"></i>
																				</div>
																				<div>
																					<strong> Server Rebooted.</strong>
																					<div class="small text-muted">45 mintues ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item text-center p-3 text-muted">View all Notification</a>
																		</div>
																	</li>
																	<li class="dropdown dropdown-list-toggle d-none d-lg-block">
																		<a href="#" class="nav-link nav-link-lg full-screen-link">
																			<i class="fe fe-maximize-2 " id="fullscreen-button2"></i>
																		</a>
																	</li>
																</ul>
																<div class="header2">
																	<form class="form-inline">
																		<div class="search-element">
																			<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
																			<button class="btn btn-primary-color" type="submit"><i class="ion ion-search"></i></button>
																		</div>
																	</form>
																</div>
																<div class="dropdown ms-2 ">
																	<a href="#" data-bs-toggle="dropdown" class="nav-link header-style-2 dropdown-toggle nav-link-lg d-flex">
																		<span><img src="{{ asset('assets/images/users/8.jpg')}}" alt="profile-user" class="avatar avatar-sm brround cover-image w-32 me-2"></span>
																	</a>
																	<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrowy">
																		<div class="drop-heading">
																			<div class="text-center">
																				<h5 class="text-dark mb-0">Elizabeth Dyer</h5>
																				<small class="text-muted">Administrator</small>
																			</div>
																		</div>
																		<div class="dropdown-divider m-0"></div>
																		<a class="dropdown-item" href="#">
																			<i class="dropdown-icon mdi mdi-account-outline"></i> Profile
																		</a>
																		<a class="dropdown-item" href="#">
																			<i class="dropdown-icon  mdi mdi-settings"></i> Settings
																		</a>
																		<a class="dropdown-item" href="#">
																			<span class="float-end"></span>
																			<i class="dropdown-icon mdi  mdi-message-outline"></i> Inbox
																		</a>
																		<a class="dropdown-item" href="#">
																			<i class="dropdown-icon mdi mdi-comment-check-outline"></i> Message
																		</a>
																		<a class="dropdown-item" href="#">
																			<i class="dropdown-icon mdi mdi-compass-outline"></i> Need help?
																		</a>
																		<a class="dropdown-item" href="{{ url('login')}}">
																			<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
																		</a>
																	</div>
																</div>
															</nav>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="card">
													<div class="card-header">
														<h3 class="card-title">Header style 2</h3>
													</div>
													<div class="header header-1 header-style p-4">
														<div class="container">
															<div class="d-flex">
																<a class="animated-arrow horizontal-navtoggle-1"><span></span></a>
																<a class="header-brand" href="{{ url('index')}}">
																	<img src="{{ asset('assets/images/brand/logo-3.png')}}" class="header-brand-img logo-3" alt="Zanex logo">
																	<img src="{{ asset('assets/images/brand/logo.png')}}" class="header-brand-img logo" alt="Zanex logo">
																</a><!-- LOGO -->
																<div class="header3">
																	<form class="form-inline">
																		<div class="search-element">
																			<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
																			<button class="btn btn-primary-color" type="submit"><i class="ion ion-search"></i></button>
																		</div>
																	</form>
																</div><!-- SEARCH -->
																<div class="d-flex order-lg-2 ms-auto header-right-icons ">
																	<a href="#" data-bs-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="ion ion-search"></i></a>
																	<div class="dropdown d-md-flex">
																		<a class="nav-link icon full-screen-link nav-link-bg">
																			<i class="fe fe-maximize-2" id="fullscreen-button3"></i>
																		</a>
																	</div><!-- FULL-SCREEN -->
																	<div class="dropdown d-md-flex notifications">
																		<a class="nav-link icon" data-bs-toggle="dropdown">
																			<i class="fe fe-bell"></i>
																			<span class="nav-unread badge bg-success rounded-pill">3</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<a href="#" class="dropdown-item mt-2 d-flex pb-3">
																				<div class="notifyimg bg-success">
																					<i class="fa fa-thumbs-o-up"></i>
																				</div>
																				<div>
																					<strong>Someone likes our posts.</strong>
																					<div class="small text-muted">3 hours ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-warning">
																					<i class="fa fa-commenting-o"></i>
																				</div>
																				<div>
																					<strong> 3 New Comments</strong>
																					<div class="small text-muted">5  hour ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="notifyimg bg-danger">
																					<i class="fa fa-cogs"></i>
																				</div>
																				<div>
																					<strong> Server Rebooted.</strong>
																					<div class="small text-muted">45 mintues ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item text-center p-3 text-muted">View all Notification</a>
																		</div>
																	</div><!-- NOTIFICATIONS -->
																	<div class="dropdown d-md-flex message">
																		<a class="nav-link icon text-center" data-bs-toggle="dropdown">
																			<i class="fe fe-message-square"></i>
																			<span class=" nav-unread badge bg-danger  rounded-pill">6</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<a href="#" class="dropdown-item d-flex mt-2 pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/41.jpg')}}">
																					<span class="avatar-status bg-green"></span>
																				</div>
																				<div>
																					<strong>Madeleine</strong>
																					<p class="mb-0 fs-13 text-muted ">Hey! there I' am available</p>
																					<div class="small text-muted">3 hours ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/1.jpg')}}">
																					<span class="avatar-status bg-red"></span>
																				</div>
																				<div>
																					<strong>Anthony</strong>
																					<p class="mb-0 fs-13 text-muted ">New product Launching</p>
																					<div class="small text-muted">5  hour ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item d-flex pb-3">
																				<div class="avatar avatar-md brround me-3 d-block cover-image" data-bs-image-src="{{ asset('assets/images/users/18.jpg')}}">
																					<span class="avatar-status bg-yellow"></span>
																				</div>
																				<div>
																					<strong>Olivia</strong>
																					<p class="mb-0 fs-13 text-muted ">New Schedule Realease</p>
																					<div class="small text-muted">45 mintues ago</div>
																				</div>
																			</a>
																			<a href="#" class="dropdown-item text-center p-3 text-muted">See all Messages</a>
																		</div>
																	</div><!-- MESSAGE-BOX -->
																	<div class="dropdown text-center selector profile-1">
																		<a href="#" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
																			<span><img src="{{ asset('assets/images/users/8.jpg')}}" alt="profile-user" class="avatar avatar-sm brround cover-image mb-1 ms-0"></span>
																			<span class=" ms-3 d-none d-lg-block ">
																				<span class="text-dark">Elizabeth Dyer</span>
																			</span>
																		</a>
																		<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
																			<div class="drop-heading">
																				<div class="text-center">
																					<h5 class="text-dark mb-0">Elizabeth Dyer</h5>
																					<small class="text-muted">Administrator</small>
																				</div>
																			</div>
																			<div class="dropdown-divider m-0"></div>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-account-outline"></i> Profile
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon  mdi mdi-settings"></i> Settings
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi  mdi-message-outline"></i> Inbox
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-comment-check-outline"></i> Message
																			</a>
																			<a class="dropdown-item" href="#">
																				<i class="dropdown-icon mdi mdi-compass-outline"></i> Need help?
																			</a>
																			<a class="dropdown-item" href="{{ url('login')}}">
																				<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
																			</a>
																		</div>
																	</div><!-- PROFILE -->
																</div>
																<a href="#" class="header-toggler d-lg-none ms-lg-0" data-bs-toggle="collapse" data-target="#headerMenuCollapse">
																	<span class="header-toggler-icon"></span>
																</a>
															</div>
														</div>
													</div>
													<!-- HEADER END -->
												</div>
											</div>
										</div>

@endsection('content')

@section('scripts')

        <!-- HORIZONTAL-MENU JS -->
		<script src="{{ asset('assets/plugins/horizontal-menu/horizontal-menu.js') }}"></script>
		
		<!-- C3 CHART JS -->
		<script src="{{ asset('assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
		<script src="{{ asset('assets/plugins/charts-c3/c3-chart.js')}}"></script>

@endsection
