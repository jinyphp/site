@foreach($rows as $i => $item)
    @if(isset($item['header']) && $item['header'] )
    <li>
        @includeIf("jiny-site::site.menus.sidebar.style1.header")
    </li>
    @elseif (isset($item['items']))
    <li>
        @includeIf("jiny-site::site.menus.sidebar.style1.sub")
    </li>
    @else
    <li>
        @includeIf( "jiny-site::site.menus.sidebar.style1.item")
    </li>
    @endif
@endforeach
