{{-- Unified Menu Item Template: nav-default + simple integration --}}
@if(isset($item['type']))
    @if($item['type'] === 'dropdown')
        <li class="nav-item dropdown">
            <a class="{{ $item['css_class'] ?? 'nav-link dropdown-toggle' }}" href="#"
               role="button" data-bs-toggle="dropdown" aria-expanded="false"
               @if(isset($item['id'])) id="{{ $item['id'] }}" @endif
               @if(isset($item['data_bs_display'])) data-bs-display="{{ $item['data_bs_display'] }}" @endif
               @if(isset($item['data_display'])) data-display="{{ $item['data_display'] }}" @endif>
                {{ $item['title'] ?? '' }}
            </a>
            <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
                @if(isset($item['id'])) aria-labelledby="{{ $item['id'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.nav-default.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </ul>
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
                        @include('jiny-site::partials.navs.nav-default.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </div>
        </li>
    @elseif($item['type'] === 'submenu')
        <li class="{{ $item['submenu_class'] ?? 'dropdown-submenu dropend' }}">
            <a class="{{ $item['css_class'] ?? 'dropdown-item dropdown-list-group-item dropdown-toggle' }}" href="#"
               @if(isset($item['dropdown_class'])) data-bs-popper="{{ $item['data_bs_popper'] ?? 'static' }}" @endif
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
                        @include('jiny-site::partials.navs.nav-default.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </ul>
        </li>
    @elseif($item['type'] === 'link')
        @if(isset($item['url']))
            {{-- Top-level navigation link --}}
            <li class="nav-item">
                <a class="{{ $item['css_class'] ?? 'nav-link' }}" href="{{ $item['url'] }}"
                   @if(isset($item['target'])) target="{{ $item['target'] }}" @endif>
                    {{ $item['title'] ?? '' }}
                    @if(isset($item['badge']))
                        <span class="{{ $item['badge']['class'] ?? 'badge' }}">{{ $item['badge']['text'] ?? '' }}</span>
                    @endif
                </a>
            </li>
        @else
            {{-- Dropdown menu link --}}
            <li>
                <a class="{{ $item['css_class'] ?? 'dropdown-item' }}" href="{{ $item['url'] ?? '#' }}"
                   @if(isset($item['target'])) target="{{ $item['target'] }}" @endif>
                    {{ $item['title'] ?? '' }}
                    @if(isset($item['badge']))
                        <span class="{{ $item['badge']['class'] ?? 'badge' }}">{{ $item['badge']['text'] ?? '' }}</span>
                    @endif
                </a>
            </li>
        @endif
    @elseif($item['type'] === 'header')
        <li>
            <h6 class="{{ $item['css_class'] ?? 'dropdown-header' }}">{{ $item['title'] ?? '' }}</h6>
        </li>
    @elseif($item['type'] === 'divider')
        <li class="{{ $item['css_class'] ?? 'border-bottom my-2' }}"></li>
    @elseif($item['type'] === 'hr')
        <li>
            <hr class="{{ $item['css_class'] ?? 'dropdown-divider' }}" />
        </li>
    @elseif($item['type'] === 'info')
        <li class="{{ $item['css_class'] ?? 'px-3 text-wrap' }}">
            <h6 class="mb-1 text-dark">{{ $item['title'] ?? '' }}</h6>
            <p class="mb-0 small text-muted">{{ $item['description'] ?? '' }}</p>
        </li>
    @elseif($item['type'] === 'button')
        <li class="{{ $item['container_class'] ?? 'px-3 d-grid' }}">
            <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'btn btn-sm btn-primary' }}">
                {{ $item['title'] ?? '' }}
            </a>
        </li>
    @elseif($item['type'] === 'list_group')
        @if(isset($item['items']) && is_array($item['items']))
            <div class="list-group list-group-flush">
                @foreach($item['items'] as $listItem)
                    <a href="{{ $listItem['url'] ?? '#' }}"
                       class="{{ $listItem['css_class'] ?? 'list-group-item' }}"
                       @if(isset($listItem['target'])) target="{{ $listItem['target'] }}" @endif>
                        <div class="d-flex align-items-center">
                            @if(isset($listItem['icon']))
                                <i class="{{ $listItem['icon'] }}"></i>
                            @endif
                            <div class="ms-3">
                                <h5 class="mb-0">{{ $listItem['title'] ?? '' }}
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
@else
    {{-- Regular menu item or link type (fallback for items without type) --}}
    <li>
        <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'dropdown-item' }}"
           @if(isset($item['target'])) target="{{ $item['target'] }}" @endif>
            @if(isset($item['title']))
                {{ $item['title'] }}
            @endif
            @if(isset($item['badge']))
                <span class="{{ $item['badge']['class'] ?? 'badge' }}">{{ $item['badge']['text'] ?? '' }}</span>
            @endif
        </a>
    </li>
@endif