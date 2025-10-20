{{-- Second Menu Item Template --}}
@if(isset($item['type']))
    @if($item['type'] === 'dropdown')
        <li class="nav-item dropdown">
            <a class="{{ $item['css_class'] ?? 'nav-link dropdown-toggle' }}" href="#"
               @if(isset($item['id'])) id="{{ $item['id'] }}" @endif
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $item['title'] ?? '' }}
            </a>
            <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}"
                @if(isset($item['id'])) aria-labelledby="{{ $item['id'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.second.menu-item', ['item' => $child])
                    @endforeach
                @endif
            </ul>
        </li>
    @elseif($item['type'] === 'dropdown_fullwidth')
        <li class="nav-item dropdown dropdown-fullwidth">
            <a class="{{ $item['css_class'] ?? 'nav-link dropdown-toggle' }}" href="#"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $item['title'] ?? '' }}
            </a>
            <div class="{{ $item['dropdown_class'] ?? 'dropdown-menu dropdown-menu-md' }}">
                @if(isset($item['content']))
                    {!! $item['content'] !!}
                @endif
            </div>
        </li>
    @elseif($item['type'] === 'special_dropdown')
        <li class="nav-item dropdown">
            <a class="{{ $item['css_class'] ?? 'nav-link' }}" href="#"
               @if(isset($item['id'])) id="{{ $item['id'] }}" @endif
               role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(isset($item['icon']))
                    <i class="{{ $item['icon'] }}"></i>
                @endif
            </a>
            <div class="{{ $item['dropdown_class'] ?? 'dropdown-menu dropdown-menu-md' }}"
                 @if(isset($item['id'])) aria-labelledby="{{ $item['id'] }}" @endif>
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @if($child['type'] === 'list_group' && isset($child['items']))
                            <div class="list-group">
                                @foreach($child['items'] as $listItem)
                                    <a class="{{ $listItem['css_class'] ?? 'list-group-item list-group-item-action border-0' }}"
                                       href="{{ $listItem['url'] ?? '#' }}"
                                       @if(isset($listItem['target'])) target="{{ $listItem['target'] }}" @endif>
                                        <div class="d-flex align-items-center">
                                            @if(isset($listItem['icon']))
                                                <i class="{{ $listItem['icon'] }}"></i>
                                            @endif
                                            <div class="ms-3">
                                                <h5 class="mb-0">
                                                    {{ $listItem['title'] ?? '' }}
                                                    @if(isset($listItem['title_extra']))
                                                        {!! $listItem['title_extra'] !!}
                                                    @endif
                                                </h5>
                                                @if(isset($listItem['description']))
                                                    <p class="mb-0 fs-6">{{ $listItem['description'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </li>
    @elseif($item['type'] === 'submenu')
        <li class="{{ $item['submenu_class'] ?? 'dropdown-submenu dropend' }}">
            <a class="{{ $item['css_class'] ?? 'dropdown-item dropdown-list-group-item dropdown-toggle' }}" href="#">
                {{ $item['title'] ?? '' }}
                @if(isset($item['badge']))
                    <span class="{{ $item['badge']['class'] ?? 'badge bg-primary ms-2' }}">{{ $item['badge']['text'] ?? '' }}</span>
                @endif
            </a>
            <ul class="{{ $item['dropdown_class'] ?? 'dropdown-menu' }}">
                @if(isset($item['children']) && is_array($item['children']))
                    @foreach($item['children'] as $child)
                        @include('jiny-site::partials.navs.second.menu-item', ['item' => $child])
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
                    <span class="{{ $item['badge']['class'] ?? 'badge bg-primary ms-2' }}">{{ $item['badge']['text'] ?? '' }}</span>
                @endif
            </a>
        </li>
    @elseif($item['type'] === 'header')
        <li>
            <h4 class="{{ $item['css_class'] ?? 'dropdown-header' }}">{{ $item['title'] ?? '' }}</h4>
        </li>
    @elseif($item['type'] === 'divider')
        <li class="{{ $item['css_class'] ?? 'border-bottom my-2' }}"></li>
    @elseif($item['type'] === 'hr')
        <li>
            <hr class="{{ $item['css_class'] ?? 'mx-3' }}" />
        </li>
    @elseif($item['type'] === 'info')
        <li class="{{ $item['css_class'] ?? 'text-wrap' }}">
            <h5 class="dropdown-header text-dark">{{ $item['title'] ?? '' }}</h5>
            @if(isset($item['description']))
                <p class="dropdown-text mb-0">{{ $item['description'] }}</p>
            @endif
        </li>
    @elseif($item['type'] === 'button')
        <li class="{{ $item['container_class'] ?? 'px-3 d-grid' }}">
            <a href="{{ $item['url'] ?? '#' }}" class="{{ $item['css_class'] ?? 'btn btn-sm btn-primary' }}">
                {{ $item['title'] ?? '' }}
            </a>
        </li>
    @endif
@endif