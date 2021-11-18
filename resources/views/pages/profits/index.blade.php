@extends('layouts.app')

@section('styles')

        <!-- SINGLE-PAGE CSS -->
		<link href="{{ asset('assets/plugins/single-page/css/main.css') }}" rel="stylesheet" type="text/css">

        <!-- SELECT2 CSS -->
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

        <!-- DATA TABLE CSS -->
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}"  rel="stylesheet">
        <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />

        <!-- INTERNAL SELECT2 CSS -->
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')

						<!-- PAGE-HEADER -->
						<div class="page-header">
							<div>
								<h1 class="page-title">Receitas</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Recursos</a></li>
									<li class="breadcrumb-item active" aria-current="page">Receitas</li>
								</ol>
							</div>
							<div class="ms-auto pageheader-btn">
								<a href="/admin/profits/create" class="btn btn-primary btn-icon text-white me-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Adicionar
								</a>
							</div>
						</div>
						<!-- PAGE-HEADER END -->

						<!-- ROW-1 OPEN -->
						<div class="row">
                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-nowrap border-bottom w-100" id="responsive-datatable">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">Nome</th>
                                                        <th class="wd-15p border-bottom-0">Valor</th>
                                                        <th class="wd-20p border-bottom-0">Data</th>
                                                        <th class="wd-15p border-bottom-0">Status</th>
                                                        <th class="wd-15p border-bottom-0">Repete</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($dataTable as $item)
                                                        <tr>
                                                            <td>Bella</td>
                                                            <td>Chloe</td>
                                                            <td>System Developer</td>
                                                            <td>2018/03/12</td>
                                                            <td>$654,765</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->
                        </div>

@endsection('content')

@section('scripts')

    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <!-- DATA TABLE JS-->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>

    <!-- C3 CHART JS -->
    <script src="{{ asset('assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/charts-c3/c3-chart.js')}}"></script>

@endsection
