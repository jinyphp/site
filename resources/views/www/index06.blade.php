@extends($layout ?? 'jiny-site::layouts.app')

@section('title', 'Job | Geeks - Academy Admin Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/landing-job.html" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero06_hero')
    @includeIf('jiny-site::www.blocks.hero06_brands')
    @includeIf('jiny-site::www.blocks.hero06_jobs')
    @includeIf('jiny-site::www.blocks.hero06_testimonials')
    @includeIf('jiny-site::www.blocks.hero06_companies')
    @includeIf('jiny-site::www.blocks.hero06_features')
    @includeIf('jiny-site::www.blocks.hero06_cta')
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tippy.js/dist/tippy-bundle.umd.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tooltip.js') }}"></script>
@endpush
