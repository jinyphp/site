@foreach($rows as $i => $item)
    @if(isset($item['header']) && $item['header'])
        @includeIf("jiny-site::site.submenu.header")
    @else
        @if(isset($item['items']))
            @includeIf("jiny-site::site.submenu.subitem")
        @else
            @includeIf("jiny-site::site.submenu.item")
        @endif
    @endif
@endforeach
