@extends($layout ?? 'jiny-site::layouts.app')

@section('title', 'Landing Course | Geeks - Bootstrap 5 Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/landing-courses.html" />
<link href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero04_hero')
    @includeIf('jiny-site::www.blocks.hero04_features')
    @includeIf('jiny-site::www.blocks.hero04_courses')
    @includeIf('jiny-site::www.blocks.hero04_testimonials')
    @includeIf('jiny-site::www.blocks.hero04_instructors')
    @includeIf('jiny-site::www.blocks.hero04_cta')
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/libs/tippy.js/dist/tippy-bundle.umd.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tooltip.js') }}"></script>
<script src="{{ asset('assets/libs/typed.js/dist/typed.umd.js') }}"></script>
<script src="{{ asset('assets/js/vendors/typed.js') }}"></script>
@endpush
