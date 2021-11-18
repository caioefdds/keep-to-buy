@extends('layouts.app')

@section('styles')
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
    <div class="page-header">
        <div>
            <h1 class="page-title">Receitas</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Recursos</a></li>
                <li class="breadcrumb-item"><a href="/admin/profits">Receitas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Incluir</li>
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

    <p-profits-create></p-profits-create>


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

    <!-- MONEY MASK -->
    <script src="{{ asset('assets/js/jquery-mask-money.js') }}"></script>

    <!-- FORMELEMENTS JS -->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>


@endsection
