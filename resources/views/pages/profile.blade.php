@extends('layouts.app')

@section('styles')

        <!-- INTERNAL GALLERY CSS -->
        <link href="{{ asset('assets/plugins/gallery/gallery.css') }}" rel="stylesheet">

        <!--BOOTSTRAP-DATERANGEPICKER CSS-->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">

        <!-- TIME PICKER CSS -->
        <link href="{{ asset('assets/plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet"/>

        <!-- INTERNAL Date Picker css -->
        <link href="{{ asset('assets/plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

        <!-- INTERNAL Bootstrap DatePicker css-->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">

@endsection

@section('content')

						<!-- PAGE-HEADER -->
						<div class="page-header">
							<div>
								<h1 class="page-title">Perfil</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/admin">Início</a></li>
									<li class="breadcrumb-item active" aria-current="page">Perfil</li>
								</ol>
							</div>
						</div>
						<!-- PAGE-HEADER END -->

                        <p-profile
                            data="{{ json_encode($userData ?? []) }}"
                        ></p-profile>

@endsection('content')

@section('scripts')

    <!-- INTERNAL Bootstrap-Datepicker js-->
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- BOOTSTRAP-DATERANGEPICKER JS -->
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- INTERNAL Bootstrap-Datepicker js-->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    <!-- TIMEPICKER JS -->
    <script src="{{ asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/time-picker/toggles.min.js') }}"></script>

    <!-- DATEPICKER JS -->
    <script src="{{ asset('assets/plugins/date-picker/date-picker.js') }}"></script>
    <script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL GALLERY JS -->
    <script src="{{ asset('assets/plugins/gallery/picturefill.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lightgallery.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lightgallery-1.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-pager.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-autoplay.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-fullscreen.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-zoom.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-hash.js') }}"></script>
    <script src="{{ asset('assets/plugins/gallery/lg-share.js') }}"></script>

    <!-- MONEY MASK -->
    <script src="{{ asset('assets/js/jquery-mask-money.js') }}"></script>

    <!-- FORMELEMENTS JS -->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>

@endsection
