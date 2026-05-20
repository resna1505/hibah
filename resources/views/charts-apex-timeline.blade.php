@extends('layouts.master-components')
@section('title') @lang('translation.Apex_Timeline_Chart') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') Apexcharts @endslot
@slot('title') Timeline Charts @endslot
@endcomponent

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Basic TimeLine Charts</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="basic_timeline" data-colors='["--tb-primary"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Different Color For Each Bar</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="color_timeline" data-colors='["--tb-primary", "--tb-danger", "--tb-success", "--tb-warning", "--tb-info"]' class="apex-charts" dir="ltr"></div>
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
                <h4 class="card-title mb-0">Multi Series Timeline</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="multi_series" data-colors='["--tb-primary","--tb-success"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Advanced Timeline (Multiple Range)</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="advanced_timeline" data-colors='["--tb-primary", "--tb-success", "--tb-warning"]' class="apex-charts" dir="ltr"></div>
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
                <h4 class="card-title mb-0">Multiple series � Group rows</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="multi_series_group" data-colors='["--tb-primary", "--tb-success", "--tb-warning", "--tb-danger", "--tb-info","--tb-gray","--tb-pink","--tb-purple","--tb-secondary", "--tb-dark"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/apexcharts-timeline.init.js') }}"></script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
