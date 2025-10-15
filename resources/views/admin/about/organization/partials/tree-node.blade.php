@foreach($organizations as $organization)
    <div class="tree-node" data-id="{{ $organization->id }}" style="margin-left: {{ $level * 20 }}px;">
        <div class="card mb-2">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="drag-handle me-3" style="cursor: move;">
                            <i class="ri-drag-move-line text-muted"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">
                                @if($level > 0)
                                    <span class="text-muted me-2">
                                        {{ str_repeat('└ ', $level) }}
                                    </span>
                                @endif
                                {{ $organization->name }}
                                <span class="badge bg-secondary ms-2">{{ $organization->code }}</span>
                            </h6>
                            @if($organization->description)
                                <p class="text-muted small mb-1">{{ Str::limit($organization->description, 80) }}</p>
                            @endif
                            <div class="small text-muted">
                                <span class="me-3">
                                    <i class="ri-layer-line me-1"></i>Level {{ $organization->level }}
                                </span>
                                <span class="me-3">
                                    <i class="ri-sort-asc me-1"></i>Order {{ $organization->sort_order }}
                                </span>
                                @if($organization->teamMembers->count() > 0)
                                    <span class="me-3">
                                        <i class="ri-team-line me-1"></i>{{ $organization->teamMembers->count() }} members
                                    </span>
                                @endif
                                @if($organization->children->count() > 0)
                                    <span class="me-3">
                                        <i class="ri-building-line me-1"></i>{{ $organization->children->count() }} sub-orgs
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($organization->is_active)
                            <span class="badge bg-success me-2">활성</span>
                        @else
                            <span class="badge bg-danger me-2">비활성</span>
                        @endif
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.cms.about.organization.edit', $organization->id) }}"
                               class="btn btn-sm btn-outline-primary" title="수정">
                                <i class="ri-edit-line"></i>
                            </a>
                            <a href="{{ route('admin.cms.about.organization.create', ['parent_id' => $organization->id]) }}"
                               class="btn btn-sm btn-outline-success" title="하위 조직 추가">
                                <i class="ri-add-line"></i>
                            </a>
                            @if($organization->children->count() == 0 && $organization->teamMembers->count() == 0)
                                <form method="POST"
                                      action="{{ route('admin.cms.about.organization.destroy', $organization->id) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('정말 삭제하시겠습니까?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="삭제">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="하위 조직 또는 팀원이 있어 삭제할 수 없습니다">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 하위 조직들을 재귀적으로 표시 -->
        @if($organization->children->count() > 0)
            @include('jiny-site::admin.about.organization.partials.tree-node', [
                'organizations' => $organization->children->sortBy('sort_order'),
                'level' => $level + 1
            ])
        @endif
    </div>
@endforeach