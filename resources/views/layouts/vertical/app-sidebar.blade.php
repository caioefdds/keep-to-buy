				<!--APP-SIDEBAR-->
				<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
				<aside class="app-sidebar">
					<div class="side-header">
						<a class="header-brand1" href="{{ url('/admin/index') }}">
							<img src="{{ asset('assets/images/logo/logo-retangular.png') }}" class="header-brand-img desktop-logo" alt="logo" width="1000px" height="auto">
							<img src="{{ asset('assets/images/logo/logo-quadrada.png') }}" class="header-brand-img toggle-logo" alt="logo" width="1000px" height="auto">
							<img src="{{ asset('assets/images/logo/logo-quadrada.png') }}" class="header-brand-img light-logo" alt="logo" width="1000px" height="auto">
							<img src="{{ asset('assets/images/logo/logo-retangular.png') }}" class="header-brand-img light-logo1" alt="logo" width="1000px" height="auto">
						</a><!-- LOGO -->
					</div>
					<ul class="side-menu">
						<li><h3>Principal</h3></li>
						<li class="slide">
							<a class="side-menu__item"  data-bs-toggle="slide" href="{{ url('/admin') }}"><i class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Início</span></a>
						</li>

                        <li><h3>Recursos</h3></li>
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fa fa-thumbs-o-up"></i><span class="side-menu__label">Receitas</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{{ url('admin/profits') }}" class="slide-item">Visualizar</a></li>
                                <li><a href="{{ url('admin/profits/create') }}" class="slide-item">Criar nova</a></li>
                            </ul>
                        </li>

                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide" href="#"><i class="side-menu__icon fa fa-thumbs-o-down"></i><span class="side-menu__label">Despesas</span><i class="angle fa fa-angle-right"></i></a>
                            <ul class="slide-menu">
                                <li><a href="{{ url('admin/expenses') }}" class="slide-item">Visualizar</a></li>
                                <li><a href="{{ url('admin/expenses/create') }}" class="slide-item">Criar nova</a></li>
                            </ul>
                        </li>
					</ul>
				</aside>
				<!--/APP-SIDEBAR-->
