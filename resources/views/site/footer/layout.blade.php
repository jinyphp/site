{{-- Footer: 사이트빌더 jiny.site.footer 설정값에 의해서 동작 --}}
<footer {{ $attributes->merge(['class' => '']) }}>
    @if ($layout1)
    {{view($layout1)}}
    @endif

    {{$slot}}

    @if ($layout2)
    {{view($layout2)}}
    @endif

</footer>
