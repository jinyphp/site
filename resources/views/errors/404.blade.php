@extends('jiny-site::layouts.app')

@section('title', '404 - 페이지를 찾을 수 없습니다')

@section('body-class', 'bg-white')

@section('content')
<!-- 404 Error Page Content -->
<section class="container d-flex flex-column min-vh-100 justify-content-center py-5">
    <div class="row align-items-center justify-content-center g-0">
        <!-- Content -->
        <div class="col-xl-4 col-lg-6 col-md-8 col-12 text-center text-lg-start">
            <div class="d-flex flex-column gap-4">
                <div class="d-flex flex-column gap-3">
                    <h1 class="display-1 mb-0 fw-bold">404</h1>
                    <p class="mb-0 lead">
                        죄송합니다. 요청하신 페이지를 찾을 수 없습니다.
                        문제가 있다고 생각되시면
                        <a href="/contact" class="btn-link">문의하기</a>를 통해 알려주세요.
                    </p>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="/" class="btn btn-primary">홈으로 돌아가기</a>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">이전 페이지</a>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="col-xl-6 col-lg-6 col-md-8 col-12 mt-5 mt-lg-0">
            <div class="text-center">
                @if(file_exists(public_path('assets/images/error/404-error-img.svg')))
                    <img src="{{ asset('assets/images/error/404-error-img.svg') }}" alt="404 오류" class="img-fluid" style="max-width: 500px;" />
                @else
                    <!-- Fallback SVG illustration -->
                    <svg viewBox="0 0 400 300" class="img-fluid" style="max-width: 400px;">
                        <rect width="400" height="300" fill="#f8f9fa" rx="10"/>
                        <circle cx="200" cy="150" r="80" fill="#e9ecef"/>
                        <text x="200" y="160" text-anchor="middle" font-family="Arial" font-size="28" font-weight="bold" fill="#6c757d">404</text>
                        <text x="200" y="200" text-anchor="middle" font-family="Arial" font-size="14" fill="#adb5bd">페이지를 찾을 수 없습니다</text>
                    </svg>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush
