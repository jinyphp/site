{{-- Simple Menu Item Template --}}
@if(isset($item['type']))
    @if($item['type'] === 'dropdown')
        <li class="nav-item dropdown">
            <a class="{{ $item['css_class'] ?? 'nav-link dropdown-toggle' }}" href="#"
               role="button" data-bs-toggle="dropdown" aria-expanded="false"
               @if(isset($item['id'])) id="{{ $item['id'] }}" @endif>
                {{ $item['title'] ?? '' }}
            </a>
            <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
                @if(isset($item['id'])) aria-labelledby="{{ $item['id'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.simple.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </ul>
        </li>
    @elseif($item['type'] === 'submenu')
        <li class="{{ $item['submenu_class'] ?? 'dropdown-submenu' }}">
            <a class="{{ $item['css_class'] ?? 'dropdown-item dropdown-toggle' }}" href="#"
               @if(isset($item['data_bs_popper'])) data-bs-popper="{{ $item['data_bs_popper'] }}" @endif>
                {{ $item['title'] ?? '' }}
                @if(isset($item['badge']))
                    <span class="{{ $item['badge']['class'] ?? 'badge' }}">{{ $item['badge']['text'] ?? '' }}</span>
                @endif
            </a>
            <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
                @if(isset($item['data_bs_popper'])) data-bs-popper="{{ $item['data_bs_popper'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.simple.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </ul>
        </li>
    @elseif($item['type'] === 'link')
        <li>
            <a class="{{ $item['css_class'] ?? 'dropdown-item' }}" href="{{ $item['url'] ?? '#' }}"
               @if(isset($item['target'])) target="{{ $item['target'] }}" @endif>
                {{ $item['title'] ?? '' }}
                @if(isset($item['badge']))
                    <span class="{{ $item['badge']['class'] ?? 'badge' }}">{{ $item['badge']['text'] ?? '' }}</span>
                @endif
            </a>
        </li>
    @elseif($item['type'] === 'header')
        <li><h6 class="{{ $item['css_class'] ?? 'dropdown-header' }}">{{ $item['title'] ?? '' }}</h6></li>
    @elseif($item['type'] === 'divider')
        <li><hr class="{{ $item['css_class'] ?? 'dropdown-divider' }}"></li>
    @elseif($item['type'] === 'hr')
        <li><hr class="{{ $item['css_class'] ?? 'dropdown-divider' }}"></li>
    @elseif($item['type'] === 'info')
        <li class="px-3">
            <div class="{{ $item['css_class'] ?? '' }}">
                <h6 class="mb-1">{{ $item['title'] ?? '' }}</h6>
                <p class="mb-0 small text-muted">{{ $item['description'] ?? '' }}</p>
            </div>
        </li>
    @elseif($item['type'] === 'button')
        <li class="{{ $item['container_class'] ?? 'px-3' }}">
            <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'btn btn-primary' }}">
                {{ $item['title'] ?? '' }}
            </a>
        </li>
    @elseif($item['type'] === 'special_dropdown')
        <li class="nav-item dropdown">
            <a class="{{ $item['css_class'] ?? 'nav-link' }}" href="#"
               role="button" data-bs-toggle="dropdown" aria-expanded="false"
               @if(isset($item['id'])) id="{{ $item['id'] }}" @endif>
                @if(isset($item['icon']))
                    <i class="{{ $item['icon'] }}"></i>
                @endif
            </a>
            <div class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
                 @if(isset($item['id'])) aria-labelledby="{{ $item['id'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.simple.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </div>
        </li>
    @elseif($item['type'] === 'list_group')
        @if(isset($item['items']) && is_array($item['items']))
            <div class="list-group list-group-flush">
                @foreach($item['items'] as $listItem)
                    <a href="{{ $listItem['url'] ?? '#' }}"
                       class="{{ $listItem['css_class'] ?? 'list-group-item' }}"
                       @if(isset($listItem['target'])) target="{{ $listItem['target'] }}" @endif>
                        <div class="d-flex">
                            @if(isset($listItem['icon']))
                                <i class="{{ $listItem['icon'] }}"></i>
                            @endif
                            <div class="ms-3">
                                <h5 class="mb-1">{{ $listItem['title'] ?? '' }}
                                    @if(isset($listItem['title_extra']))
                                        {!! $listItem['title_extra'] !!}
                                    @endif
                                </h5>
                                <p class="mb-0 fs-6">{{ $listItem['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @endif
@endif