@extends('jiny-site::layouts.app')

@section('title', 'Education - Geeks Bootstrap 5 Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/landing-education.html" />
<link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero05_hero')
    @includeIf('jiny-site::www.blocks.hero05_features')
    @includeIf('jiny-site::www.blocks.hero05_courses')
    @includeIf('jiny-site::www.blocks.hero05_numbers')
    @includeIf('jiny-site::www.blocks.hero05_testimonials')
    @includeIf('jiny-site::www.blocks.hero05_cta')
        </main>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
@endpush
