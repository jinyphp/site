<!-- Collapse -->
<div class="collapse navbar-collapse" id="navbar-default">
    <ul class="navbar-nav ms-auto">
        @foreach (Site::menuItems('job') as $menuItem)
            @if (isset($menuItem['type']) && $menuItem['type'] === 'dropdown')
                <li class="nav-item dropdown">
                    <a class="{{ $menuItem['css_class'] ?? 'nav-link dropdown-toggle' }}" href="#"
                       id="{{ $menuItem['id'] ?? '' }}"
                       data-bs-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        {{ $menuItem['title'] ?? '' }}
                    </a>
                    <ul class="{{ $menuItem['dropdown_class'] ?? 'dropdown-menu' }}" aria-labelledby="{{ $menuItem['id'] ?? '' }}">
                        @if(isset($menuItem['children']) && is_array($menuItem['children']))
                            @foreach ($menuItem['children'] as $child)
                                @include('jiny-site::partials.navs.right.menu-item', ['item' => $child])
                            @endforeach
                        @endif
                    </ul>
                </li>
            @elseif (isset($menuItem['type']) && $menuItem['type'] === 'special_dropdown')
                <li class="nav-item dropdown">
                    <a class="{{ $menuItem['css_class'] ?? 'nav-link' }}" href="#"
                       id="{{ $menuItem['id'] ?? '' }}"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <i class="{{ $menuItem['icon'] ?? '' }}"></i>
                    </a>
                    <div class="{{ $menuItem['dropdown_class'] ?? 'dropdown-menu' }}" aria-labelledby="{{ $menuItem['id'] ?? '' }}">
                        @if(isset($menuItem['children']) && is_array($menuItem['children']))
                            @foreach ($menuItem['children'] as $child)
                                @if (isset($child['type']) && $child['type'] === 'list_group' && isset($child['items']))
                                    <div class="list-group">
                                        @foreach ($child['items'] as $listItem)
                                            <a class="{{ $listItem['css_class'] ?? 'list-group-item' }}"
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
                                                        <p class="mb-0 fs-6">{{ $listItem['description'] ?? '' }}</p>
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
            @elseif (isset($menuItem['type']) && $menuItem['type'] === 'link')
                <li class="nav-item">
                    <a class="{{ $menuItem['css_class'] ?? 'nav-link' }}" href="{{ $menuItem['url'] ?? '#' }}">
                        {{ $menuItem['title'] ?? '' }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>