@if (isset($item['type']) && $item['type'] === 'header')
    <li>
        <h4 class="{{ $item['css_class'] ?? 'dropdown-header' }}">{{ $item['title'] ?? '' }}</h4>
    </li>
@elseif (isset($item['type']) && $item['type'] === 'divider')
    <li class="{{ $item['css_class'] ?? 'border-bottom my-2' }}"></li>
@elseif (isset($item['type']) && $item['type'] === 'hr')
    <li>
        <hr class="{{ $item['css_class'] ?? 'mx-3' }}" />
    </li>
@elseif (isset($item['type']) && $item['type'] === 'submenu')
    <li class="{{ $item['submenu_class'] ?? 'dropdown-submenu dropend' }}">
        <a class="{{ $item['css_class'] ?? 'dropdown-item dropdown-list-group-item dropdown-toggle' }}" href="#"
           @if(isset($item['dropdown_class']))
               data-bs-popper="{{ $item['data_bs_popper'] ?? 'static' }}"
           @endif>
            {{ $item['title'] ?? '' }}
            @if(isset($item['badge']) && isset($item['badge']['class']) && isset($item['badge']['text']))
                <span class="{{ $item['badge']['class'] }}">{{ $item['badge']['text'] }}</span>
            @endif
        </a>
        <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
            @if(isset($item['data_bs_popper'])) data-bs-popper="{{ $item['data_bs_popper'] }}" @endif>
            @if(isset($item['children']) && is_array($item['children']))
                @foreach ($item['children'] as $subItem)
                    @include('jiny-site::partials.navs.left.menu-item', ['item' => $subItem])
                @endforeach
            @endif
        </ul>
    </li>
@elseif (isset($item['type']) && $item['type'] === 'info')
    <li class="{{ $item['css_class'] ?? 'text-wrap' }}">
        <h5 class="dropdown-header text-dark">{{ $item['title'] ?? '' }}</h5>
        <p class="dropdown-text mb-0">{{ $item['description'] ?? '' }}</p>
    </li>
@elseif (isset($item['type']) && $item['type'] === 'button')
    <li class="{{ $item['container_class'] ?? 'px-3 d-grid' }}">
        <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'btn btn-sm btn-primary' }}">{{ $item['title'] ?? '' }}</a>
    </li>
@else
    {{-- Regular menu item or link type --}}
    <li>
        <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'dropdown-item' }}">
            @if(isset($item['title']))
                {{ $item['title'] }}
            @endif
            @if(isset($item['badge']) && isset($item['badge']['class']) && isset($item['badge']['text']))
                <span class="{{ $item['badge']['class'] }}">{{ $item['badge']['text'] }}</span>
            @endif
        </a>
    </li>
@endif