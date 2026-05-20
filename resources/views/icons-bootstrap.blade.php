@extends('layouts.master-components')
@section('title') @lang('translation.bootstrap-icons') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Icons @endslot
@slot('title') Bootstrap @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Examples</h4>
                <p class="text-muted mb-0">Use <code>&lt;i class="bi bi-**">&lt;/i></code> class.</p>
            </div>
            <div class="card-body pt-0">

                <div class="row icon-demo-content" id="iconList"></div>
                <!-- end row -->

            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/bootstrap-icons.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
