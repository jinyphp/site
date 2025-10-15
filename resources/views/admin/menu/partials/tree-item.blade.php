@foreach($items as $item)
<div class="menu-item" data-item-id="{{ $item->id }}">
    <div class="item-header">
        <div class="item-left d-flex align-items-center">
            <div class="drag-handle me-2" title="드래그하여 이동">
                <i class="fe fe-menu"></i>
            </div>

            <input type="checkbox" class="menu-item-checkbox form-check-input me-2" value="{{ $item->id }}" onclick="event.stopPropagation();">

            @if($item->icon)
                <i class="{{ $item->icon }} me-2"></i>
            @endif

            <div class="item-content">
                <div class="fw-bold">
                    {{ $item->title }}
                    @if(!$item->enable)
                        <span class="badge bg-secondary ms-1">비활성</span>
                    @endif
                </div>

                @if($item->href || $item->description)
                    <div class="text-muted small">
                        @if($item->href)
                            <i class="fe fe-link"></i> {{ $item->href }}
                        @endif
                        @if($item->href && $item->description) | @endif
                        @if($item->description)
                            {{ $item->description }}
                        @endif
                    </div>
                @endif

                @if($item->name || $item->code)
                    <div class="text-muted small">
                        @if($item->code)
                            <span class="badge bg-light text-dark">{{ $item->code }}</span>
                        @endif
                        @if($item->name)
                            <span class="text-info">{{ $item->name }}</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="item-actions">
            @if($item->target === '_blank')
                <span class="badge bg-info me-1" title="새 창으로 열기">
                    <i class="fe fe-external-link"></i>
                </span>
            @endif

            @if($item->submenu)
                <span class="badge bg-success me-1" title="서브메뉴 포함">
                    <i class="fe fe-git-branch"></i>
                </span>
            @endif

            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary btn-sm"
                        onclick="event.stopPropagation(); addSubItem({{ $item->id }})"
                        title="하위 아이템 추가">
                    <i class="fe fe-plus"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm"
                        onclick="event.stopPropagation(); editMenuItem({{ $item->id }})"
                        title="수정">
                    <i class="fe fe-edit"></i>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm"
                        onclick="event.stopPropagation(); deleteMenuItem({{ $item->id }})"
                        title="삭제">
                    <i class="fe fe-trash-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 하위 메뉴 영역 (항상 생성하여 드롭 가능하게 함) -->
    <div class="menu-children" data-parent-id="{{ $item->id }}">
        @if($item->children && $item->children->count() > 0)
            @include('jiny-site::admin.menu.partials.tree-item', ['items' => $item->children])
        @else
            <!-- 빈 드롭 존 -->
            <div class="empty-drop-zone">
                <i class="fe fe-arrow-down me-2"></i>
                <span>여기에 하위 아이템을 드래그하세요</span>
            </div>
        @endif
    </div>
</div>
@endforeach

@if($items->isEmpty())
<div class="drop-zone">
    <i class="fe fe-plus-circle me-2"></i>
    여기에 메뉴 아이템을 드래그하거나 새 아이템을 추가하세요
</div>
@endif