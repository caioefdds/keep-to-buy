				<!-- Mobile Header -->
				<div class="app-header header">
					<div class="container-fluid">
						<div class="d-flex">
							<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
							<a class="header-brand1 d-flex d-md-none" href="{{ url('/admin/index') }}">
								<img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
								<img src="{{ asset('assets/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo" alt="logo">
								<img src="{{ asset('assets/images/brand/logo-2.png') }}" class="header-brand-img light-logo" alt="logo">
								<img src="{{ asset('assets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo">
							</a>
							<div class="d-flex order-lg-2 ms-auto header-right-icons">
								<button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon fe fe-more-vertical text-dark"></span>
								</button>
								<div class="dropdown d-none d-md-flex">
									<a class="nav-link icon theme-layout nav-link-bg layout-setting">
										<span class="dark-layout" data-bs-placement="bottom" data-bs-toggle="tooltip" title="Dark Theme"><i class="fe fe-moon"></i></span>
										<span class="light-layout" data-bs-placement="bottom" data-bs-toggle="tooltip" title="Light Theme"><i class="fe fe-sun"></i></span>
									</a>
								</div>
								<div class="dropdown d-none d-md-flex profile-1">
									<a href="#" data-bs-toggle="dropdown" class="nav-link pe-2 leading-none d-flex">
										<span>
											<img src="{{ Session::get('image') ?? asset('assets/images/users/1.jpg') }}" alt="profile-user" class="avatar  profile-user brround cover-image">
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow ml">
										<div class="drop-heading">
											<div class="text-center">
												<h5 class="text-dark mb-0">{{ Session::get('nameExhibition') ?? '' }}</h5>
												<small class="text-muted">Usuário</small>
											</div>
										</div>
										<div class="dropdown-divider m-0"></div>
										<a class="dropdown-item" href="{{ url('/admin/profile') }}">
											<i class="dropdown-icon fe fe-user"></i> Perfil
										</a>
                                        <a class="dropdown-item" href="{{ url('logout') }}">
                                            <i class="dropdown-icon fe fe-alert-circle"></i> Sair
                                        </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
					<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
						<div class="d-flex order-lg-2 ms-auto justify-content-between">
							<div class="dropdown d-md-flex">
								<a class="nav-link icon theme-layout nav-link-bg layout-setting">
									<span class="dark-layout" data-bs-placement="bottom" data-bs-toggle="tooltip" title="Dark Theme"><i class="fe fe-moon"></i></span>
									<span class="light-layout" data-bs-placement="bottom" data-bs-toggle="tooltip" title="Light Theme"><i class="fe fe-sun"></i></span>
								</a>
							</div>
							<div class="dropdown d-md-flex profile-1">
								<a href="#" data-bs-toggle="dropdown" class="nav-link pe-2 leading-none d-flex">
									<span>
										<img src="{{ Session::get('image') ?? asset('assets/images/users/1.jpg') }}" alt="profile-user" class="avatar  profile-user brround cover-image">
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
									<div class="drop-heading">
										<div class="text-center">
											<h5 class="text-dark mb-0">{{ Session::get('nameExhibition') ?? '' }}</h5>
											<small class="text-muted">Usuário</small>
										</div>
									</div>
									<div class="dropdown-divider m-0"></div>
									<a class="dropdown-item" href="{{url('/admin/profile')}}">
                                        <i class="dropdown-icon fe fe-user"></i> Perfil
									</a>
									<a class="dropdown-item" href="{{ url('logout') }}">
										<i class="dropdown-icon fe fe-alert-circle"></i> Sair
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Mobile Header -->
