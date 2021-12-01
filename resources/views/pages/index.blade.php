@extends('layouts.app')

@section('styles')
        <!-- DATA TABLE CSS -->
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}"  rel="stylesheet">
        <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />

        <!-- INTERNAL SELECT2 CSS -->
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Início</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Início</a></li>
            </ol>
        </div>
    </div>

    <p-invoice
        data="{{ json_encode($dataTable ?? []) }}"
        profits="{{ json_encode($totalProfits) }}"
        expenses="{{ json_encode($totalExpenses) }}"
    ></p-invoice>
@endsection('content')

@section('scripts')

    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

    <!-- COUNTERS JS-->
    <script src="{{ asset('assets/plugins/counters/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counters/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/counters/counters-1.js') }}"></script>

    <!-- C3 CHART JS -->
    <script src="{{ asset('assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/charts-c3/c3-chart.js')}}"></script>

    <!-- TIME COUNTER JS-->
    <script src="{{ asset('assets/plugins/counters/jquery.missofis-countdown.js') }}"></script>
    <script src="{{ asset('assets/plugins/counters/counter.js') }}"></script>

    <!-- COUNT-DOWN JS-->
    <script src="{{ asset('assets/plugins/counters/count-down.js') }}"></script>
    <script src="{{ asset('assets/plugins/countdown/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/countdown/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/countdown/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/countdown/countdowntime.js') }}"></script>

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

    <!-- MONEY MASK -->
    <script src="{{ asset('assets/js/jquery-mask-money.js') }}"></script>

    <!-- FORMELEMENTS JS -->
    <script src="{{ asset('assets/js/form-elements.js') }}"></script>
@endsection
