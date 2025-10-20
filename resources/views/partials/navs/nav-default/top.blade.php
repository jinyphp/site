{{-- Unified Navigation: nav-default + simple integration --}}
@php
    // 정렬 옵션 설정
    $alignment = $alignment ?? 'auto'; // 기본값: auto
    $alignmentClass = match($alignment) {
        'left' => '',
        'center' => 'mx-auto',
        'right' => 'ms-auto',
        'auto' => 'mx-xxl-auto',
        default => 'mx-xxl-auto'
    };

    // 추가 여백 옵션
    $spacing = $spacing ?? ($alignment === 'center' ? 'mt-3 mt-lg-0' : '');
@endphp

<div class="collapse navbar-collapse" id="navbar-default">
    <ul class="navbar-nav {{ $spacing }} {{ $alignmentClass }}">
        @foreach ($menuItems as $menuItem)
            @include('jiny-site::partials.navs.nav-default.menu-item', ['item' => $menuItem])
        @endforeach
    </ul>
</div>
