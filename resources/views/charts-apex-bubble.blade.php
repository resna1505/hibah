@extends('layouts.master-components')
@section('title') @lang('translation.Apex_Bubble_Chart') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') Apexcharts @endslot
@slot('title') Bubble Charts @endslot
@endcomponent

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Basic Bubble Chart</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="simple_bubble" data-colors='["--tb-primary", "--tb-info", "--tb-warning", "--tb-success"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">3D Bubble Chart</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="bubble_chart" data-colors='["--tb-primary", "--tb-success", "--tb-warning", "--tb-danger"]' class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/apexcharts-bubble.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
