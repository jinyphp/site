{{-- Header: 사이트빌더 jiny.site.header 설정값에 의해서 동작 --}}
<header {{ $attributes->merge(['class' => '']) }}>
    @if ($layout1)
    {{view($layout1)}}
    @endif

    {{$slot}}

    @if ($layout2)
    {{view($layout2)}}
    @endif

</header>
