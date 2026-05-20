@extends('layouts.master-components')
@section('title') @lang('translation.remix') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Icons @endslot
@slot('title') Remix @endslot
@endcomponent

<div class="row">

</div><!-- end row -->

<div class="row">
    <div class="col-12" id="icons"></div> <!-- end col-->
</div><!-- end row -->

@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/remix-icons-listing.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
