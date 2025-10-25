@extends($layout ?? "jiny-site::layouts.admin.sidebar")

@section('title')
    Welcome 페이지 관리
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">웰컴 페이지 블록 관리</h1>
                    <p class="text-muted">그룹별로 웰컴 페이지를 관리하고 스케줄 배포하세요</p>
                </div>
                <div>
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#previewModal">
                        <i class="fas fa-eye"></i> 미리보기
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlockModal">
                        <i class="fas fa-plus"></i> 블록 추가
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-layer-group"></i> 그룹 관리
                        </h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deployModal">
                                <i class="fas fa-rocket"></i> 배포 관리
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#historyModal">
                                <i class="fas fa-history"></i> 배포 이력
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="groupSelect" class="form-label">현재 그룹</label>
                            <select class="form-select" id="groupSelect">
                                @foreach($groups as $group)
                                    <option value="{{ $group->group_name }}"
                                            {{ $group->group_name === $currentGroup ? 'selected' : '' }}
                                            data-group='@json($group)'>
                                        {{ $group->group_title ?? $group->group_name }}
                                        @if($group->is_active) (활성화됨) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="group-info">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $groupInfo['is_active'] ? 'success' : 'secondary' }} me-2">
                                        {{ $groupInfo['deploy_status'] }}
                                    </span>
                                    @if($groupInfo['deploy_at'])
                                        <small class="text-muted">
                                            배포 예정: {{ $groupInfo['deploy_at']->format('Y-m-d H:i') }}
                                        </small>
                                    @endif
                                </div>
                                @if($groupInfo['group_description'])
                                    <small class="text-muted d-block mt-1">{{ $groupInfo['group_description'] }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            @if(!$groupInfo['is_active'])
                                <button type="button" class="btn btn-warning btn-sm activate-group" data-group="{{ $currentGroup }}">
                                    <i class="fas fa-power-off"></i> 활성화
                                </button>
                            @endif
                            <a href="{{ url('/?preview=' . $currentGroup) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                <i class="fas fa-external-link-alt"></i> 미리보기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Block Library and Current Blocks -->
    <div class="row">
        <!-- Block Library -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="fas fa-cubes"></i> 블록 라이브러리
                            </h5>
                            <small class="text-muted">드래그하여 블록을 추가하세요</small>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.cms.blocks.create') }}" class="btn btn-primary btn-sm" target="_blank" title="새 블록 생성">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" id="library-search" placeholder="블록 검색...">
                    </div>
                    <div class="mb-3">
                        <select class="form-select form-select-sm" id="library-category">
                            <option value="">모든 카테고리</option>
                        </select>
                    </div>

                    <!-- Library Actions -->
                    <div class="mb-3">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-info btn-sm" id="refresh-library">
                                <i class="fas fa-sync-alt me-1"></i> 라이브러리 새로고침
                            </button>
                        </div>
                    </div>

                    <div id="block-library" class="block-library">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">로딩중...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Library Footer -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                <i class="fas fa-external-link-alt me-1"></i> 전체 블록 관리
                            </a>
                        </div>
                        <small class="text-muted d-block text-center mt-2">
                            <i class="fas fa-info-circle"></i> 새 블록 생성 후 새로고침하세요
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Blocks -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-th-list"></i> 현재 블록 설정
                        </h5>
                        <div class="drop-zone-info">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 왼쪽에서 블록을 드래그하여 추가하거나 순서를 변경하세요
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="blocks-drop-zone" class="blocks-drop-zone">
                        @if(empty($blocks))
                            <div class="empty-blocks-message text-center py-5">
                                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">설정된 블록이 없습니다</h5>
                                <p class="text-muted">왼쪽 라이브러리에서 블록을 드래그하여 추가하세요</p>
                            </div>
                        @else
                            <div id="blocks-container" class="blocks-sortable">
                                @foreach($blocks as $block)
                                    <div class="block-item card mb-3" data-block-id="{{ $block['id'] }}" data-order="{{ $block['order'] }}">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <!-- Drag Handle -->
                                                <div class="col-auto">
                                                    <div class="drag-handle cursor-move">
                                                        <i class="fas fa-grip-vertical text-muted"></i>
                                                    </div>
                                                </div>

                                                <!-- Block Info -->
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">{{ $block['name'] }}</h6>
                                                            <small class="text-muted">{{ $block['view'] }}</small>
                                                        </div>
                                                        <div class="me-2">
                                                            <span class="badge {{ $block['enabled'] ? 'bg-success' : 'bg-secondary' }} me-1">
                                                                {{ $block['enabled'] ? '활성화' : '비활성화' }}
                                                            </span>
                                                            <span class="badge bg-{{ $block['is_active'] ? 'primary' : 'light' }} text-{{ $block['is_active'] ? 'white' : 'dark' }} me-1">
                                                                {{ $block['deploy_status'] }}
                                                            </span>
                                                            <span class="badge bg-light text-dark">순서: {{ $block['order'] }}</span>
                                                        </div>
                                                    </div>
                                                    @if($block['deploy_at'])
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="fas fa-clock"></i> 배포 예정: {{ $block['deploy_at'] }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Actions -->
                                                <div class="col-auto">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary edit-block"
                                                                data-block='@json($block)'
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editBlockModal"
                                                                title="블록 수정">
                                                            <i class="fas fa-edit me-1"></i>수정
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-{{ $block['enabled'] ? 'warning' : 'success' }} toggle-block"
                                                                data-id="{{ $block['id'] }}"
                                                                title="블록 {{ $block['enabled'] ? '비활성화' : '활성화' }}">
                                                            <i class="fas fa-{{ $block['enabled'] ? 'eye-slash' : 'eye' }} me-1"></i>
                                                            {{ $block['enabled'] ? '숨김' : '표시' }}
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-block"
                                                                data-id="{{ $block['id'] }}"
                                                                data-name="{{ $block['name'] }}"
                                                                title="블록 삭제">
                                                            <i class="fas fa-trash me-1"></i>삭제
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Config Preview -->
                                            @if(!empty($block['config']))
                                                <div class="mt-3">
                                                    <small class="text-muted">설정값:</small>
                                                    <div class="bg-light p-2 rounded mt-1">
                                                        <small>
                                                            @foreach($block['config'] as $key => $value)
                                                                <span class="badge bg-info me-1">{{ $key }}: {{ is_string($value) ? $value : json_encode($value) }}</span>
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Block Modal -->
<div class="modal fade" id="addBlockModal" tabindex="-1" aria-labelledby="addBlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBlockModalLabel">새 블록 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBlockForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_group_name" class="form-label">그룹명</label>
                                <input type="text" class="form-control" id="add_group_name" name="group_name" value="{{ $currentGroup }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_group_title" class="form-label">그룹 제목</label>
                                <input type="text" class="form-control" id="add_group_title" name="group_title" value="{{ $groupInfo['group_title'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_group_description" class="form-label">그룹 설명</label>
                        <input type="text" class="form-control" id="add_group_description" name="group_description" value="{{ $groupInfo['group_description'] }}">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_block_name" class="form-label">블록 이름</label>
                                <input type="text" class="form-control" id="add_block_name" name="block_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_view_template" class="form-label">뷰 템플릿</label>
                                <input type="text" class="form-control" id="add_view_template" name="view_template" required
                                       placeholder="예: jiny-site::www.blocks.hero">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_status" class="form-label">상태</label>
                                <select class="form-select" id="add_status" name="status" required>
                                    <option value="draft">임시저장</option>
                                    <option value="scheduled">스케줄됨</option>
                                    <option value="active">활성화</option>
                                    <option value="archived">보관됨</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_deploy_at" class="form-label">배포 예정일시</label>
                                <input type="datetime-local" class="form-control" id="add_deploy_at" name="deploy_at">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="add_is_enabled" name="is_enabled" checked>
                            <label class="form-check-label" for="add_is_enabled">
                                활성화
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_config" class="form-label">설정 (JSON)</label>
                        <textarea class="form-control" id="add_config" name="config" rows="4"
                                  placeholder='{"title": "블록 제목", "background": "#ffffff"}'></textarea>
                        <div class="form-text">유효한 JSON 형식으로 설정을 입력하세요</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">블록 추가</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Block Modal -->
<div class="modal fade" id="editBlockModal" tabindex="-1" aria-labelledby="editBlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBlockModalLabel">블록 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBlockForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_group_title" class="form-label">그룹 제목</label>
                                <input type="text" class="form-control" id="edit_group_title" name="group_title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_group_description" class="form-label">그룹 설명</label>
                                <input type="text" class="form-control" id="edit_group_description" name="group_description">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_block_name" class="form-label">블록 이름</label>
                                <input type="text" class="form-control" id="edit_block_name" name="block_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_view_template" class="form-label">뷰 템플릿</label>
                                <input type="text" class="form-control" id="edit_view_template" name="view_template" required
                                       placeholder="예: jiny-site::www.blocks.hero">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">상태</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="draft">임시저장</option>
                                    <option value="scheduled">스케줄됨</option>
                                    <option value="active">활성화</option>
                                    <option value="archived">보관됨</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_deploy_at" class="form-label">배포 예정일시</label>
                                <input type="datetime-local" class="form-control" id="edit_deploy_at" name="deploy_at">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_enabled" name="is_enabled">
                            <label class="form-check-label" for="edit_is_enabled">
                                활성화
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_config" class="form-label">설정 (JSON)</label>
                        <textarea class="form-control" id="edit_config" name="config" rows="4"
                                  placeholder='{"title": "블록 제목", "background": "#ffffff"}'></textarea>
                        <div class="form-text">유효한 JSON 형식으로 설정을 입력하세요</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">블록 수정</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">그룹 미리보기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-list">
                    @foreach($groups as $group)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                            <div>
                                <h6 class="mb-1">{{ $group->group_title ?? $group->group_name }}</h6>
                                <small class="text-muted">{{ $group->group_description }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-{{ $group->is_active ? 'success' : 'secondary' }}">
                                        {{ $group->deploy_status }}
                                    </span>
                                    @if($group->deploy_at)
                                        <small class="text-muted ms-2">배포: {{ $group->deploy_at->format('Y-m-d H:i') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ url('/?preview=' . $group->group_name) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> 미리보기
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deploy Modal -->
<div class="modal fade" id="deployModal" tabindex="-1" aria-labelledby="deployModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deployModalLabel">배포 관리</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>현재 그룹 스케줄 설정</h6>
                        <form id="scheduleForm">
                            <div class="mb-3">
                                <label for="schedule_group_name" class="form-label">그룹명</label>
                                <input type="text" class="form-control" id="schedule_group_name" name="group_name" value="{{ $currentGroup }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="schedule_deploy_at" class="form-label">배포 예정일시</label>
                                <input type="datetime-local" class="form-control" id="schedule_deploy_at" name="deploy_at" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-alt"></i> 스케줄 설정
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h6>현재 그룹 즉시 배포</h6>
                        <div class="alert alert-info">
                            <strong>{{ $groupInfo['group_title'] ?? $currentGroup }}</strong> 그룹을 즉시 라이브로 배포합니다.
                            <br><small class="text-muted">현재 활성화된 그룹은 비활성화되고, 이 그룹이 활성화됩니다.</small>
                        </div>
                        <button type="button" class="btn btn-success" id="deploy-current-group" data-group="{{ $currentGroup }}">
                            <i class="fas fa-rocket"></i> {{ $currentGroup }} 그룹 즉시 배포
                        </button>

                        <hr class="my-3">

                        <h6>배포 가능한 그룹</h6>
                        <div id="deployable-groups">
                            <!-- 동적으로 로드됨 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deployment History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">배포 이력</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 통계 섹션 -->
                <div class="row mb-4" id="deployment-stats">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-primary" id="total-deployments">-</h5>
                                <p class="card-text">전체 배포</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-success" id="successful-deployments">-</h5>
                                <p class="card-text">성공한 배포</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-warning" id="today-deployments">-</h5>
                                <p class="card-text">오늘 배포</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-info" id="month-deployments">-</h5>
                                <p class="card-text">이번 달 배포</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 필터 섹션 -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select class="form-select" id="history-group-filter">
                            <option value="">모든 그룹</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->group_name }}">{{ $group->group_title ?? $group->group_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="history-type-filter">
                            <option value="">모든 타입</option>
                            <option value="manual">수동 배포</option>
                            <option value="scheduled">예약 배포</option>
                            <option value="auto">자동 배포</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-secondary" id="refresh-history">
                            <i class="fas fa-sync-alt"></i> 새로고침
                        </button>
                    </div>
                </div>

                <!-- 배포 이력 목록 -->
                <div id="deployment-history-list">
                    <div class="text-center py-4">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">로딩중...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.cms.welcome.history.index') }}" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-external-link-alt"></i> 전체 이력 보기
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
/* Block Library Styles */
.block-library {
    max-height: 500px;
    overflow-y: auto;
}

.library-block-item {
    border: 1px solid #e9ecef;
    border-radius: 0.375rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    cursor: grab;
    transition: all 0.2s ease;
    background: #fff;
}

.library-block-item:hover {
    border-color: #007bff;
    background: #f8f9ff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.library-block-item:active {
    cursor: grabbing;
}

.library-block-item.dragging {
    opacity: 0.7;
    transform: rotate(5deg);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.library-block-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #212529;
}

.library-block-category {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.library-block-description {
    font-size: 0.75rem;
    color: #868e96;
    line-height: 1.3;
}

/* Drop Zone Styles */
.blocks-drop-zone {
    min-height: 200px;
    border: 2px dashed transparent;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    position: relative;
}

.blocks-drop-zone.drag-over {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.blocks-drop-zone.drag-over::after {
    content: "여기에 블록을 드롭하세요";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #007bff;
    color: white;
    padding: 1rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    pointer-events: none;
    z-index: 10;
}

.empty-blocks-message {
    opacity: 0.7;
}

/* Current Blocks Styles */
.blocks-sortable {
    min-height: 100px;
}

.block-item {
    transition: transform 0.2s ease;
    border: 1px solid #dee2e6;
}

.block-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.block-item.sortable-ghost {
    opacity: 0.5;
}

.block-item.sortable-chosen {
    transform: rotate(5deg);
}

.drag-handle {
    cursor: move;
    padding: 0.5rem;
}

.drag-handle:hover {
    background-color: #f8f9fa;
    border-radius: 4px;
}

.cursor-move {
    cursor: move;
}

/* Action buttons styling */
.btn-group .btn {
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.btn-group .btn i {
    font-size: 0.875rem;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Drag feedback */
.block-library .library-block-item.sortable-chosen {
    transform: rotate(5deg) scale(1.05);
    z-index: 1000;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

/* Ensure icons are visible */
.fas, .fa-solid {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1;
}

/* Responsive design */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }

    .btn-group .btn {
        margin-bottom: 2px;
        border-radius: 0.375rem !important;
        justify-content: center;
    }

    .block-library {
        max-height: 300px;
    }
}

/* Loading state */
.block-library .spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

/* Search and filter styling */
#library-search:focus, #library-category:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

/* Category badges in library */
.library-block-category .badge {
    font-size: 0.65rem;
}

/* Extra small buttons for library actions */
.btn-xs {
    padding: 0.125rem 0.25rem;
    font-size: 0.625rem;
    line-height: 1.2;
    border-radius: 0.125rem;
}

.library-block-actions {
    opacity: 0;
    transition: opacity 0.2s ease;
}

.library-block-item:hover .library-block-actions {
    opacity: 1;
}

/* Prevent action buttons from interfering with drag */
.library-block-actions a {
    pointer-events: auto;
}

.library-block-item.dragging .library-block-actions {
    pointer-events: none;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Load block library
    loadBlockLibrary();

    // Initialize Drop Zone for blocks
    initializeDropZone();

    // Initialize Sortable for existing blocks
    initializeBlocksSortable();

    // Refresh library button
    document.getElementById('refresh-library').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> 새로고침 중...';

        loadBlockLibrary();

        setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-sync-alt me-1"></i> 라이브러리 새로고침';
        }, 1000);
    });

    // Block Library Functions
    function loadBlockLibrary() {
        fetch('{{ route("admin.cms.blocks.index") }}?per_page=50', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayBlockLibrary(data.blocks, data.categories);
                setupLibraryFilters(data.categories);
            } else {
                showLibraryError('블록 라이브러리를 불러올 수 없습니다.');
            }
        })
        .catch(error => {
            console.error('Error loading block library:', error);
            showLibraryError('블록 라이브러리 로딩 중 오류가 발생했습니다.');
        });
    }

    function displayBlockLibrary(blocks, categories) {
        const libraryContainer = document.getElementById('block-library');
        libraryContainer.innerHTML = '';

        if (blocks.length === 0) {
            libraryContainer.innerHTML = '<div class="text-center py-3 text-muted">사용 가능한 블록이 없습니다.</div>';
            return;
        }

        blocks.forEach(block => {
            const blockElement = createLibraryBlockElement(block);
            libraryContainer.appendChild(blockElement);
        });

        // Initialize drag functionality for library items
        initializeLibraryDrag();
    }

    function createLibraryBlockElement(block) {
        const blockDiv = document.createElement('div');
        blockDiv.className = 'library-block-item';
        blockDiv.draggable = true;
        blockDiv.dataset.blockTemplate = block.path_param;
        blockDiv.dataset.blockName = block.filename;
        blockDiv.dataset.blockCategory = block.category;
        blockDiv.dataset.blockDescription = block.description;

        blockDiv.innerHTML = `
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="library-block-title">${block.filename}</div>
                <div class="library-block-actions">
                    <a href="${block.preview_url}" class="btn btn-outline-info btn-xs me-1" target="_blank" title="미리보기">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="${block.edit_url}" class="btn btn-outline-primary btn-xs" target="_blank" title="편집">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="library-block-category mb-1">
                <span class="badge bg-secondary">${block.category}</span>
            </div>
            <div class="library-block-description">${block.description}</div>
        `;

        return blockDiv;
    }

    function initializeLibraryDrag() {
        const libraryItems = document.querySelectorAll('.library-block-item');

        libraryItems.forEach(item => {
            item.addEventListener('dragstart', function(e) {
                // 액션 버튼을 클릭한 경우 드래그를 방지
                if (e.target.closest('.library-block-actions')) {
                    e.preventDefault();
                    return false;
                }

                this.classList.add('dragging');
                e.dataTransfer.setData('text/plain', JSON.stringify({
                    template: this.dataset.blockTemplate,
                    name: this.dataset.blockName,
                    category: this.dataset.blockCategory,
                    description: this.dataset.blockDescription
                }));
                e.dataTransfer.effectAllowed = 'copy';
            });

            item.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
            });

            // 액션 버튼 클릭 시 드래그 비활성화
            const actionButtons = item.querySelectorAll('.library-block-actions a');
            actionButtons.forEach(button => {
                button.addEventListener('mousedown', function(e) {
                    e.stopPropagation();
                });
            });
        });
    }

    function initializeDropZone() {
        const dropZone = document.getElementById('blocks-drop-zone');

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
            this.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', function(e) {
            if (!this.contains(e.relatedTarget)) {
                this.classList.remove('drag-over');
            }
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');

            try {
                const blockData = JSON.parse(e.dataTransfer.getData('text/plain'));
                addBlockFromLibrary(blockData);
            } catch (error) {
                console.error('Error parsing dropped data:', error);
                showAlert('danger', '잘못된 블록 데이터입니다.');
            }
        });
    }

    function addBlockFromLibrary(blockData) {
        const data = {
            group_name: '{{ $currentGroup }}',
            group_title: '{{ $groupInfo["group_title"] ?? "" }}',
            group_description: '{{ $groupInfo["group_description"] ?? "" }}',
            block_name: blockData.name,
            view_template: `jiny-site::www.blocks.${blockData.template}`,
            is_enabled: true,
            status: 'draft',
            config: {}
        };

        fetch('{{ route("admin.cms.welcome.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', '블록이 성공적으로 추가되었습니다');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('danger', data.message || '블록 추가에 실패했습니다');
            }
        })
        .catch(error => {
            console.error('Error adding block:', error);
            showAlert('danger', '블록 추가 중 오류가 발생했습니다');
        });
    }

    function setupLibraryFilters(categories) {
        const categorySelect = document.getElementById('library-category');
        const searchInput = document.getElementById('library-search');

        // Populate category filter
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            categorySelect.appendChild(option);
        });

        // Filter functionality
        function filterLibrary() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categorySelect.value;
            const libraryItems = document.querySelectorAll('.library-block-item');

            libraryItems.forEach(item => {
                const name = item.dataset.blockName.toLowerCase();
                const category = item.dataset.blockCategory;
                const description = item.dataset.blockDescription.toLowerCase();

                const matchesSearch = !searchTerm ||
                    name.includes(searchTerm) ||
                    description.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;

                item.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
            });
        }

        searchInput.addEventListener('input', filterLibrary);
        categorySelect.addEventListener('change', filterLibrary);
    }

    function showLibraryError(message) {
        const libraryContainer = document.getElementById('block-library');
        libraryContainer.innerHTML = `
            <div class="text-center py-3 text-danger">
                <i class="fas fa-exclamation-triangle mb-2"></i><br>
                ${message}
            </div>
        `;
    }

    function initializeBlocksSortable() {
        const container = document.getElementById('blocks-container');
        if (container) {
            const sortable = Sortable.create(container, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                onEnd: function(evt) {
                    updateBlockOrder();
                }
            });
        }
    }

    // Update block order after drag & drop
    function updateBlockOrder() {
        const blocks = [];
        document.querySelectorAll('.block-item').forEach((item, index) => {
            blocks.push({
                id: parseInt(item.dataset.blockId),
                order: index + 1
            });
        });

        fetch('{{ route("admin.cms.welcome.updateOrder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ blocks: blocks })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', '블록 순서가 성공적으로 업데이트되었습니다');
                // Update order badges
                document.querySelectorAll('.block-item').forEach((item, index) => {
                    const orderBadge = item.querySelector('.badge.bg-light');
                    if (orderBadge) {
                        orderBadge.textContent = `순서: ${index + 1}`;
                    }
                });
            } else {
                showAlert('danger', data.error || '순서 업데이트에 실패했습니다');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', '순서 업데이트 중 오류가 발생했습니다');
        });
    }

    // Group Selection
    document.getElementById('groupSelect').addEventListener('change', function() {
        const selectedGroup = this.value;
        window.location.href = `{{ route("admin.cms.welcome.index") }}?group=${selectedGroup}`;
    });

    // Activate Group
    document.querySelectorAll('.activate-group').forEach(button => {
        button.addEventListener('click', function() {
            const groupName = this.dataset.group;

            if (confirm(`'${groupName}' 그룹을 활성화하시겠습니까? 현재 활성화된 그룹은 비활성화됩니다.`)) {
                fetch('{{ route("admin.cms.welcome.activateGroup") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ group_name: groupName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showAlert('danger', data.message || '그룹 활성화에 실패했습니다');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', '그룹 활성화 중 오류가 발생했습니다');
                });
            }
        });
    });

    // Add Block Form
    document.getElementById('addBlockForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = {
            group_name: formData.get('group_name'),
            group_title: formData.get('group_title'),
            group_description: formData.get('group_description'),
            block_name: formData.get('block_name'),
            view_template: formData.get('view_template'),
            is_enabled: formData.has('is_enabled'),
            status: formData.get('status'),
            deploy_at: formData.get('deploy_at'),
            config: {}
        };

        // Parse JSON config
        const configText = formData.get('config');
        if (configText.trim()) {
            try {
                data.config = JSON.parse(configText);
            } catch (e) {
                showAlert('danger', '설정 필드의 JSON이 유효하지 않습니다');
                return;
            }
        }

        fetch('{{ route("admin.cms.welcome.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || '블록이 성공적으로 추가되었습니다');
                bootstrap.Modal.getInstance(document.getElementById('addBlockModal')).hide();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('danger', data.message || '블록 추가에 실패했습니다');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', '블록 추가 중 오류가 발생했습니다');
        });
    });

    // Edit Block
    document.querySelectorAll('.edit-block').forEach(button => {
        button.addEventListener('click', function() {
            const blockData = JSON.parse(this.dataset.block);

            document.getElementById('edit_id').value = blockData.id;
            document.getElementById('edit_group_title').value = blockData.group_title || '';
            document.getElementById('edit_group_description').value = blockData.group_description || '';
            document.getElementById('edit_block_name').value = blockData.name;
            document.getElementById('edit_view_template').value = blockData.view;
            document.getElementById('edit_is_enabled').checked = blockData.enabled;
            document.getElementById('edit_status').value = blockData.status || 'draft';

            // Handle deploy_at field
            if (blockData.deploy_at) {
                // Convert to local datetime format for input
                const deployDate = new Date(blockData.deploy_at);
                const offset = deployDate.getTimezoneOffset() * 60000;
                const localDate = new Date(deployDate.getTime() - offset);
                document.getElementById('edit_deploy_at').value = localDate.toISOString().slice(0, 16);
            } else {
                document.getElementById('edit_deploy_at').value = '';
            }

            document.getElementById('edit_config').value = JSON.stringify(blockData.config || {}, null, 2);
        });
    });

    // Edit Block Form
    document.getElementById('editBlockForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const id = formData.get('id');
        const data = {
            group_title: formData.get('group_title'),
            group_description: formData.get('group_description'),
            block_name: formData.get('block_name'),
            view_template: formData.get('view_template'),
            is_enabled: formData.has('is_enabled'),
            status: formData.get('status'),
            deploy_at: formData.get('deploy_at'),
            config: {}
        };

        // Parse JSON config
        const configText = formData.get('config');
        if (configText.trim()) {
            try {
                data.config = JSON.parse(configText);
            } catch (e) {
                showAlert('danger', '설정 필드의 JSON이 유효하지 않습니다');
                return;
            }
        }

        fetch(`{{ route("admin.cms.welcome.update", ":id") }}`.replace(':id', id), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || '블록이 성공적으로 수정되었습니다');
                bootstrap.Modal.getInstance(document.getElementById('editBlockModal')).hide();
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('danger', data.message || '블록 수정에 실패했습니다');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', '블록 수정 중 오류가 발생했습니다');
        });
    });

    // Toggle Block
    document.querySelectorAll('.toggle-block').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;

            fetch('{{ route("admin.cms.welcome.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: parseInt(id) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', '블록 상태가 성공적으로 변경되었습니다');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showAlert('danger', data.error || '블록 상태 변경에 실패했습니다');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', '블록 상태 변경 중 오류가 발생했습니다');
            });
        });
    });

    // Delete Block
    document.querySelectorAll('.delete-block').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;

            if (confirm(`"${name}" 블록을 정말 삭제하시겠습니까?`)) {
                fetch(`{{ route("admin.cms.welcome.destroy", ":id") }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', '블록이 성공적으로 삭제되었습니다');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showAlert('danger', data.error || '블록 삭제에 실패했습니다');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', '블록 삭제 중 오류가 발생했습니다');
                });
            }
        });
    });

    // Schedule Form
    document.getElementById('scheduleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = {
            group_name: formData.get('group_name'),
            deploy_at: formData.get('deploy_at')
        };

        fetch('{{ route("admin.cms.welcome.deploy.schedule") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                loadDeployableGroups();
            } else {
                showAlert('danger', data.message || '스케줄 설정에 실패했습니다');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', '스케줄 설정 중 오류가 발생했습니다');
        });
    });

    // Deploy Current Group Button
    document.getElementById('deploy-current-group').addEventListener('click', function() {
        const groupName = this.dataset.group;
        const groupTitle = document.querySelector('#groupSelect option:checked').textContent;

        if (confirm(`'${groupTitle}' 그룹을 즉시 라이브로 배포하시겠습니까?\n\n현재 활성화된 그룹은 비활성화되고, 이 그룹이 활성화됩니다.`)) {
            fetch('{{ route("admin.cms.welcome.deploy.now") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ group_name: groupName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showAlert('danger', data.message || '배포에 실패했습니다');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', '배포 중 오류가 발생했습니다');
            });
        }
    });

    // Load Deployable Groups
    function loadDeployableGroups() {
        fetch('{{ route("admin.cms.welcome.deploy.deployable") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('deployable-groups');
                container.innerHTML = '';

                if (data.deployable_groups && data.deployable_groups.length > 0) {
                    data.deployable_groups.forEach(group => {
                        const groupDiv = document.createElement('div');
                        groupDiv.className = 'mb-2 p-2 border rounded';
                        groupDiv.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${group.group_title || group.group_name}</strong>
                                    <br>
                                    <small class="text-muted">배포 예정: ${new Date(group.deploy_at).toLocaleString()}</small>
                                </div>
                                <span class="badge bg-warning">${group.status}</span>
                            </div>
                        `;
                        container.appendChild(groupDiv);
                    });
                } else {
                    container.innerHTML = '<p class="text-muted">배포 가능한 그룹이 없습니다.</p>';
                }
            }
        })
        .catch(error => {
            console.error('Error loading deployable groups:', error);
        });
    }

    // Load deployable groups when deploy modal opens
    document.getElementById('deployModal').addEventListener('show.bs.modal', function() {
        loadDeployableGroups();
    });

    // Deployment History Functions
    function loadDeploymentStats() {
        fetch('{{ route("admin.cms.welcome.history.stats") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-deployments').textContent = data.summary.total_deployments;
                document.getElementById('successful-deployments').textContent = data.summary.successful_deployments;
                document.getElementById('today-deployments').textContent = data.summary.today_deployments;
                document.getElementById('month-deployments').textContent = data.summary.month_deployments;
            }
        })
        .catch(error => {
            console.error('Error loading deployment stats:', error);
        });
    }

    function loadDeploymentHistory() {
        const groupFilter = document.getElementById('history-group-filter').value;
        const typeFilter = document.getElementById('history-type-filter').value;

        let url = '{{ route("admin.cms.welcome.history.recent") }}?limit=10';
        if (groupFilter) url += '&group_name=' + groupFilter;
        if (typeFilter) url += '&deployment_type=' + typeFilter;

        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('deployment-history-list');
                container.innerHTML = '';

                if (data.deployments.length > 0) {
                    data.deployments.forEach(deployment => {
                        const deploymentDiv = document.createElement('div');
                        deploymentDiv.className = 'mb-3 p-3 border rounded';
                        deploymentDiv.innerHTML = `
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <span class="badge bg-primary me-2">${deployment.group_name}</span>
                                        ${deployment.group_title || deployment.group_name}
                                    </h6>
                                    <div class="mb-2">
                                        <span class="badge bg-info me-1">${deployment.deployment_type_korean}</span>
                                        <span class="badge bg-success me-1">${deployment.deployment_status_korean}</span>
                                        <span class="badge bg-light text-dark">${deployment.blocks_count}개 블록</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> ${deployment.deployed_by_name || 'System'}
                                        ${deployment.previous_active_group ? ' | 이전: ' + deployment.previous_active_group : ''}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted small">${deployment.deployed_at}</div>
                                    <div class="text-muted smaller">${deployment.deployed_at_human}</div>
                                </div>
                            </div>
                        `;
                        container.appendChild(deploymentDiv);
                    });
                } else {
                    container.innerHTML = '<div class="text-center text-muted py-4">배포 이력이 없습니다.</div>';
                }
            }
        })
        .catch(error => {
            console.error('Error loading deployment history:', error);
            document.getElementById('deployment-history-list').innerHTML =
                '<div class="text-center text-danger py-4">이력을 불러오는 중 오류가 발생했습니다.</div>';
        });
    }

    // Load deployment history when modal opens
    document.getElementById('historyModal').addEventListener('show.bs.modal', function() {
        loadDeploymentStats();
        loadDeploymentHistory();
    });

    // History filters
    document.getElementById('history-group-filter').addEventListener('change', loadDeploymentHistory);
    document.getElementById('history-type-filter').addEventListener('change', loadDeploymentHistory);
    document.getElementById('refresh-history').addEventListener('click', function() {
        loadDeploymentStats();
        loadDeploymentHistory();
    });

    // Alert function
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
@endpush
