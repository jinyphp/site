@extends($layout ?? 'jiny-site::layouts.app')

@section('title', 'Homepage | Geeks - Bootstrap 5 Template')

@push('styles')
<link rel="canonical" href="https://geeksui.codescandy.com/geeks/index.html" />
<link rel="stylesheet" href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" />
@endpush

@section('content')
      @includeIf('jiny-site::www.blocks.hero')
      <section>
        <div class="container">
          <div class="row">
            <div class="col-12">
              <hr />
            </div>
          </div>
        </div>
      </section>
      @includeIf('jiny-site::www.blocks.hero_categories')
      @includeIf('jiny-site::www.blocks.hero_courses')
      @includeIf('jiny-site::www.blocks.hero_testimonials')
      @includeIf('jiny-site::www.blocks.hero_hiring')
      @includeIf('jiny-site::www.blocks.hero_trusted')
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/vendors/tnsSlider.js') }}"></script>
@endpush
