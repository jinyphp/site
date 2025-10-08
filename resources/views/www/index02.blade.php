@extends('jiny-site::layouts.app')

@section('title', 'Geeks - Bootstrap 5 Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/home-academy.html" />
<link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
<link href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero02_main')
    @includeIf('jiny-site::www.blocks.hero02_courses')
    @includeIf('jiny-site::www.blocks.hero02_content')
    @includeIf('jiny-site::www.blocks.hero02_testimonials')
    @includeIf('jiny-site::www.blocks.hero02_cta')
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
<script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
@endpush
