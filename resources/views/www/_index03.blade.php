@extends($layout ?? 'jiny-site::layouts.app')

@section('title', 'Geeks - Bootstrap 5 Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/landing-abroad.html" />
<link href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero03_hero')
    @includeIf('jiny-site::www.blocks.hero03_features')
    @includeIf('jiny-site::www.blocks.hero03_courses')
    @includeIf('jiny-site::www.blocks.hero03_benefits')
    @includeIf('jiny-site::www.blocks.hero03_testimonials')
    @includeIf('jiny-site::www.blocks.hero03_stats')
    @includeIf('jiny-site::www.blocks.hero03_cta')
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
<script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
@endpush
