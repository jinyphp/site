@extends('jiny-site::layouts.app')

@section('title', 'SASS | Geeks - Academy Admin Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/landing-sass.html" />
<link rel="stylesheet" href="{{ asset('assets/libs/odometer/themes/odometer-theme-default.css') }}" />
@endpush

@section('body-class', 'bg-white overflow-hidden')

@section('content')
    @includeIf('jiny-site::www.blocks.hero07_hero')
    @includeIf('jiny-site::www.blocks.hero07_features')
    @includeIf('jiny-site::www.blocks.hero07_how')
    @includeIf('jiny-site::www.blocks.hero07_pricing')
    @includeIf('jiny-site::www.blocks.hero07_testimonials')
    @includeIf('jiny-site::www.blocks.hero07_cta')
        </main>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/odometer/odometer.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/pricing.js') }}"></script>
@endpush
