@extends('layouts.master-components')
@section('title') @lang('translation.vector-map') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Maps @endslot
@slot('title') Vector @endslot
@endcomponent


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Markers</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="world-map-line-markers" data-colors='["--tb-light"]' style="height: 420px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">World Vector Map with Markers</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="world-map-markers" data-colors='["--tb-light"]' style="height: 350px" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">World Vector Map with Image Markers</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="world-map-markers-image" data-colors='["--tb-light"]' style="height: 350px" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">USA Vector Map</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="usa-vectormap" data-colors='["--tb-primary"]' style="height: 350px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Canada Vector Map</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="canada-vectormap" data-colors='["--tb-info"]' style="height: 350px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Russia Vector Map</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="russia-vectormap" data-colors='["--tb-success"]' style="height: 350px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Spain Vector Map</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="spain-vectormap" data-colors='["--tb-secondary"]' style="height: 350px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
@section('script')

<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/js/maps/us-merc-en.js') }}"></script>
<script src="{{ URL::asset('build/js/maps/canada.js') }}"></script>
<script src="{{ URL::asset('build/js/maps/russia.js') }}"></script>
<script src="{{ URL::asset('build/js/maps/spain.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/vector-maps.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
