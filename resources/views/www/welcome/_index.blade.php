<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Welcome') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body>
<!-- Welcome Page Container -->
<div class="welcome-page">
    <!-- Banner Section -->
    @if($banners && $banners->count() > 0)
        @foreach($banners as $banner)
            <div class="alert alert-{{ $banner->type }} banner-notification"
                 data-banner-id="{{ $banner->id }}"
                 data-cookie-days="{{ $banner->cookie_days }}"
                 @if($banner->style) style="{{ $banner->style }}" @endif>
                <div class="container d-flex align-items-center">
                    @if($banner->icon)
                        <i class="{{ $banner->icon }} me-2"></i>
                    @endif
                    <div class="flex-grow-1">
                        <strong>{{ $banner->title }}</strong>
                        <span class="ms-2">{{ $banner->message }}</span>
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="btn btn-sm btn-outline-light ms-3">
                                {{ $banner->link_text ?: '자세히 보기' }}
                            </a>
                        @endif
                    </div>
                    @if($banner->is_closable)
                        <button type="button" class="btn-close btn-close-white"
                                onclick="closeBanner({{ $banner->id }}, {{ $banner->cookie_days }})"
                                aria-label="Close"></button>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <!-- Welcome Blocks Section -->
    @includeIf("jiny-site::www.welcome.loop")
</div>

<!-- Banner Close Script -->
<script>
function closeBanner(bannerId, cookieDays) {
    // 베너를 숨김
    const banner = document.querySelector(`[data-banner-id="${bannerId}"]`);
    if (banner) {
        banner.style.display = 'none';
    }

    // 쿠키 설정
    const expires = new Date();
    expires.setDate(expires.getDate() + cookieDays);
    document.cookie = `banner_closed_${bannerId}=1; expires=${expires.toUTCString()}; path=/`;
}
</script>

<!-- Welcome Blocks Styles -->
<style>
.welcome-page {
    min-height: 100vh;
}

.welcome-blocks {
    position: relative;
}

.welcome-block {
    position: relative;
    overflow: hidden;
}

.block-wrapper {
    position: relative;
    z-index: 1;
}

/* Default welcome styling */
.default-welcome {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 70vh;
    display: flex;
    align-items: center;
}

/* Banner styling */
.banner-notification {
    margin-bottom: 0;
    border-radius: 0;
    z-index: 1000;
    position: relative;
}

/* Block spacing */
.welcome-block + .welcome-block {
    border-top: 1px solid rgba(0,0,0,0.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .default-welcome .display-4 {
        font-size: 2.5rem;
    }

    .default-welcome .lead {
        font-size: 1.1rem;
    }
}

/* Debug mode styling */
.alert-warning code {
    background-color: rgba(255,255,255,0.2);
    padding: 2px 4px;
    border-radius: 3px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
