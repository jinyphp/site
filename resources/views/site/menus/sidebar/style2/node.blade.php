@foreach($rows as $i => $item)
    @if(isset($item['header']) && $item['header'] )
    <li class="sidebar-header">
        @includeIf("jiny-site::site.menus.sidebar.style2.header")
    </li>
    @elseif (isset($item['items']))
    <li class="sidebar-item">
        @includeIf("jiny-site::site.menus.sidebar.style2.sub")
    </li>
    @else
    <li class="sidebar-item">
        @includeIf( "jiny-site::site.menus.sidebar.style2.item")
    </li>
    @endif
@endforeach
