@extends('jiny-site::layouts.app')

@section('title', 'Request Access | Geeks - Academy Admin Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/request-access.html" />
<link href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <main>
    @includeIf('jiny-site::www.blocks.hero08_hero')
    @includeIf('jiny-site::www.blocks.hero08_form')
    @includeIf('jiny-site::www.blocks.hero08_features')
    @includeIf('jiny-site::www.blocks.hero08_testimonials')
    @includeIf('jiny-site::www.blocks.hero08_cta')
    </main>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
@endpush
