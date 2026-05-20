@extends('layouts.master-components')
@section('title') @lang('translation.Apex_Scatter_Chart') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') Apexcharts @endslot
@slot('title') Scatter Charts @endslot
@endcomponent

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Basic Scatter Chart</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="basic_scatter" data-colors='["--tb-primary", "--tb-success", "--tb-warning"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Scatter - Datetime Chart</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="datetime_scatter" data-colors='["--tb-primary", "--tb-success", "--tb-warning", "--tb-warning", "--tb-info"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Scatter Images Chart</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="images_scatter" data-colors='["--tb-primary", "--tb-danger"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/apexcharts-scatter.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
