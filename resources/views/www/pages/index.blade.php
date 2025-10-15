@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(isset($page))
        {{-- 페이지 헤더 --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                {{ $page->title }}
            </h1>

            @if($page->excerpt)
                <p class="text-xl text-gray-600 leading-relaxed">
                    {{ $page->excerpt }}
                </p>
            @endif

            {{-- 페이지 메타 정보 --}}
            <div class="flex items-center text-sm text-gray-500 mt-4 space-x-4">
                @if($page->published_at)
                    <span>
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ $page->published_at->format('Y년 m월 d일') }}
                    </span>
                @endif

                @if($page->view_count > 0)
                    <span>
                        <i class="far fa-eye mr-1"></i>
                        조회 {{ number_format($page->view_count) }}회
                    </span>
                @endif
            </div>
        </div>

        {{-- 페이지 콘텐츠 --}}
        <div class="prose prose-lg max-w-none">
            @php
                // 블럭 콘텐츠가 있는지 확인
                $hasBlockContent = isset($page->id) && \Jiny\Site\Models\SitePageContent::where('page_id', $page->id)->active()->exists();
            @endphp

            @if($hasBlockContent)
                {{-- 블럭 기반 콘텐츠 렌더링 --}}
                @foreach(\Jiny\Site\Models\SitePageContent::where('page_id', $page->id)->active()->ordered()->get() as $block)
                    <div class="content-block content-block-{{ $block->block_type }}"
                         data-block-id="{{ $block->id }}"
                         @if($block->css_class) class="{{ $block->css_class }}" @endif>

                        @if($block->title && !$block->hide_title && $block->block_type !== 'divider')
                            <h3 class="block-title">{{ $block->title }}</h3>
                        @endif

                        <div class="block-content">
                            {!! $block->rendered_content !!}
                        </div>
                    </div>
                @endforeach
            @else
                {{-- 기존 단일 콘텐츠 렌더링 (하위 호환성) --}}
                {!! nl2br(e(str_replace('\\n', "\n", $page->content))) !!}
            @endif
        </div>

        {{-- 사용자 정의 필드 (있는 경우) --}}
        @if($page->custom_fields && count($page->custom_fields) > 0)
            <div class="mt-12 p-6 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">추가 정보</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($page->custom_fields as $key => $value)
                        <div>
                            <dt class="font-medium text-gray-900">{{ ucfirst($key) }}</dt>
                            <dd class="text-gray-600">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        @endif
    @else
        {{-- 페이지가 없는 경우 기본 메시지 --}}
        <div class="text-center py-16">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">페이지를 찾을 수 없습니다</h1>
            <p class="text-gray-600 mb-8">요청하신 페이지가 존재하지 않습니다.</p>
            <a href="/" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                홈으로 돌아가기
            </a>
        </div>
    @endif
</div>

{{-- SEO 메타 태그 --}}
@if(isset($page))
    @push('meta')
        <meta name="description" content="{{ $page->meta_description ?: $page->excerpt }}">
        @if($page->meta_keywords)
            <meta name="keywords" content="{{ $page->meta_keywords }}">
        @endif

        {{-- Open Graph --}}
        <meta property="og:title" content="{{ $page->og_title ?: $page->meta_title ?: $page->title }}">
        <meta property="og:description" content="{{ $page->og_description ?: $page->meta_description ?: $page->excerpt }}">
        <meta property="og:url" content="{{ url($page->url) }}">
        <meta property="og:type" content="article">
        @if($page->og_image)
            <meta property="og:image" content="{{ $page->og_image }}">
        @endif

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $page->og_title ?: $page->meta_title ?: $page->title }}">
        <meta name="twitter:description" content="{{ $page->og_description ?: $page->meta_description ?: $page->excerpt }}">
        @if($page->og_image)
            <meta name="twitter:image" content="{{ $page->og_image }}">
        @endif
    @endpush
@endif
@endsection
