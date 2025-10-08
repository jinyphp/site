@extends('jiny-site::layouts.app')

@section('content')
    <main>
        @include('jiny-site::www.blocks.about-hero')
        @include('jiny-site::www.blocks.about-gallery')
        @include('jiny-site::www.blocks.about-statistics')
        @include('jiny-site::www.blocks.about-core-values')
        @include('jiny-site::www.blocks.about-team')
        @include('jiny-site::www.blocks.about-cta')
    </main>

    <!-- Initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
