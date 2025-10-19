@extends('jiny-site::layouts.admin.sidebar')

@section('title', '헤더 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">헤더 관리</h1>
                    <p class="mb-0 text-muted">사이트 템플릿 헤더를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.header.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 헤더 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.header.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i> 새 헤더 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">총 템플릿</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_templates'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-layout-navbar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">브랜드 설정</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($stats['has_brand_name'])
                                    <span class="text-success">설정됨</span>
                                @else
                                    <span class="text-warning">미설정</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-badge-tm fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">주 메뉴</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['primary_nav_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">보조 메뉴</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['secondary_nav_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-menu-button-wide fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">헤더 목록</h5>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($headers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>경로</th>
                                        <th>제목 / 설명</th>
                                        <th>사용중</th>
                                        <th>기본</th>
                                        <th width="150">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($headers as $header)
                                        <tr>
                                            <td>{{ $header['id'] }}</td>
                                            <td>
                                                <div>
                                                    <code class="text-primary d-block">{{ $header['path'] ?? $header['header_key'] ?? 'N/A' }}</code>
                                                    <div class="mt-1">
                                                        <span class="badge bg-info me-1" title="네비게이션">
                                                            <i class="bi bi-list me-1"></i>네비
                                                            @if($header['navbar'] ?? false)
                                                                <i class="bi bi-check text-success ms-1"></i>
                                                            @else
                                                                <i class="bi bi-x text-danger ms-1"></i>
                                                            @endif
                                                        </span>
                                                        <span class="badge bg-warning me-1" title="로고">
                                                            <i class="bi bi-image me-1"></i>로고
                                                            @if($header['logo'] ?? false)
                                                                <i class="bi bi-check text-success ms-1"></i>
                                                            @else
                                                                <i class="bi bi-x text-danger ms-1"></i>
                                                            @endif
                                                        </span>
                                                        <span class="badge bg-secondary" title="검색">
                                                            <i class="bi bi-search me-1"></i>검색
                                                            @if($header['search'] ?? false)
                                                                <i class="bi bi-check text-success ms-1"></i>
                                                            @else
                                                                <i class="bi bi-x text-danger ms-1"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong class="d-block">
                                                        {{ $header['title'] ?? $header['name'] ?? 'N/A' }}
                                                        <button class="badge border-0 enable-badge ms-2 {{ ($header['enable'] ?? true) ? 'bg-success' : 'bg-danger' }}"
                                                                data-header-id="{{ $header['id'] }}"
                                                                data-current-enable="{{ ($header['enable'] ?? true) ? 'true' : 'false' }}"
                                                                title="클릭하여 {{ ($header['enable'] ?? true) ? '비활성화' : '활성화' }}">
                                                            {{ ($header['enable'] ?? true) ? '활성화' : '비활성화' }}
                                                        </button>
                                                    </strong>
                                                    <small class="text-muted d-block mt-1">{{ $header['description'] ?? '설명 없음' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($header['enable'] ?? true)
                                                    <button class="badge border-0 active-badge {{ ($header['active'] ?? false) ? 'bg-primary' : 'bg-secondary' }}"
                                                            data-header-id="{{ $header['id'] }}"
                                                            data-current-active="{{ ($header['active'] ?? false) ? 'true' : 'false' }}"
                                                            title="클릭하여 {{ ($header['active'] ?? false) ? '비활성화' : '활성화' }}">
                                                        {{ ($header['active'] ?? false) ? '사용중' : '대기중' }}
                                                    </button>
                                                @else
                                                    <span class="badge bg-light text-muted">비활성화됨</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($header['default'] ?? false)
                                                    <button class="badge bg-success border-0 default-badge"
                                                            data-header-id="{{ $header['id'] }}"
                                                            data-current-default="true"
                                                            title="현재 기본 헤더 (클릭하여 변경 불가)">
                                                        기본
                                                    </button>
                                                @else
                                                    <button class="badge bg-secondary border-0 default-badge"
                                                            data-header-id="{{ $header['id'] }}"
                                                            data-current-default="false"
                                                            title="클릭하여 기본 헤더로 설정">
                                                        일반
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cms.templates.header.show', $header['id']) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.header.edit', $header['id']) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $header['id'] }})" title="삭제">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end align-items-center p-3 border-top bg-light">
                            <small class="text-muted">총 {{ count($headers) }}개의 헤더</small>
                        </div>
                    @else
                        <div class="text-center py-5 m-3">
                            <i class="bi bi-layout-navbar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">헤더가 없습니다</h5>
                            <p class="text-muted">첫 번째 헤더를 생성해보세요</p>
                            <a href="{{ route('admin.cms.templates.header.create') }}" class="btn btn-primary">
                                헤더 생성
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 헤더를 삭제하시겠습니까?</p>
                <p><strong>헤더 경로:</strong> <span id="delete-header-path"></span></p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>주의:</strong> 이 작업은 되돌릴 수 없습니다. 이 헤더를 사용하는 템플릿이 있다면 오류가 발생할 수 있습니다.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(headerId) {
    // 해당 행에서 헤더 경로 가져오기 - 더 안전한 방법
    const buttons = document.querySelectorAll('.btn-outline-danger');
    let headerPath = '';

    buttons.forEach(btn => {
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(headerId)) {
            const row = btn.closest('tr');
            headerPath = row.querySelector('code').textContent;
        }
    });

    document.getElementById('delete-header-path').textContent = headerPath;
    document.getElementById('delete-form').action = `/admin/cms/templates/header/${headerId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// AJAX functionality for header management
document.addEventListener('DOMContentLoaded', function() {
    // Default header setting
    const defaultBadges = document.querySelectorAll('.default-badge');
    defaultBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const headerId = this.dataset.headerId;
            const isCurrentDefault = this.dataset.currentDefault === 'true';

            // Don't allow clicking on already default header
            if (isCurrentDefault) {
                return;
            }

            // Show loading state
            const originalText = this.textContent;
            this.textContent = '설정중...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/admin/cms/templates/header/${headerId}/set-default`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all badges
                    updateDefaultBadges(headerId);
                    updateActiveBadges(headerId);

                    // Show success message
                    showNotification('기본 헤더가 성공적으로 설정되었습니다.', 'success');
                } else {
                    throw new Error(data.error || '설정 중 오류가 발생했습니다.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message, 'error');

                // Restore original state
                this.textContent = originalText;
                this.disabled = false;
            });
        });
    });

    // Enable/Disable toggle
    const enableBadges = document.querySelectorAll('.enable-badge');
    enableBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const headerId = this.dataset.headerId;
            const isCurrentlyEnabled = this.dataset.currentEnable === 'true';

            // Show loading state
            const originalText = this.textContent;
            this.textContent = '처리중...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/admin/cms/templates/header/${headerId}/toggle-enable`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update enable badge
                    updateEnableBadge(headerId, data.enabled);

                    // If disabled, update other badges too
                    if (!data.enabled) {
                        updateActiveBadge(headerId, false);
                        updateDefaultBadge(headerId, false);
                    }

                    // Show success message
                    showNotification(data.message, 'success');
                } else {
                    throw new Error(data.error || '처리 중 오류가 발생했습니다.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message, 'error');

                // Restore original state
                this.textContent = originalText;
                this.disabled = false;
            });
        });
    });

    // Active header setting
    const activeBadges = document.querySelectorAll('.active-badge');
    activeBadges.forEach(badge => {
        attachActiveBadgeListener(badge);
    });
});

function attachActiveBadgeListener(badge) {
    badge.addEventListener('click', function() {
        const headerId = this.dataset.headerId;
        const isCurrentlyActive = this.dataset.currentActive === 'true';

        // Don't allow clicking on already active header
        if (isCurrentlyActive) {
            return;
        }

        // Show loading state
        const originalText = this.textContent;
        this.textContent = '설정중...';
        this.disabled = true;

        // Make AJAX request
        fetch(`/admin/cms/templates/header/${headerId}/set-active`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all active badges
                updateActiveBadges(headerId);

                // Show success message
                showNotification('활성 헤더가 성공적으로 설정되었습니다.', 'success');
            } else {
                throw new Error(data.error || '설정 중 오류가 발생했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message, 'error');

            // Restore original state
            this.textContent = originalText;
            this.disabled = false;
        });
    });
}

function updateDefaultBadges(newDefaultId) {
    const defaultBadges = document.querySelectorAll('.default-badge');

    defaultBadges.forEach(badge => {
        const headerId = badge.dataset.headerId;

        if (headerId === newDefaultId) {
            // Set as new default
            badge.className = 'badge bg-success border-0 default-badge';
            badge.textContent = '기본';
            badge.dataset.currentDefault = 'true';
            badge.title = '현재 기본 헤더 (클릭하여 변경 불가)';
            badge.disabled = false;
        } else {
            // Set as regular
            badge.className = 'badge bg-secondary border-0 default-badge';
            badge.textContent = '일반';
            badge.dataset.currentDefault = 'false';
            badge.title = '클릭하여 기본 헤더로 설정';
            badge.disabled = false;
        }
    });
}

function updateDefaultBadge(headerId, isDefault) {
    const badge = document.querySelector(`.default-badge[data-header-id="${headerId}"]`);
    if (badge) {
        if (isDefault) {
            badge.className = 'badge bg-success border-0 default-badge';
            badge.textContent = '기본';
            badge.dataset.currentDefault = 'true';
            badge.title = '현재 기본 헤더 (클릭하여 변경 불가)';
        } else {
            badge.className = 'badge bg-secondary border-0 default-badge';
            badge.textContent = '일반';
            badge.dataset.currentDefault = 'false';
            badge.title = '클릭하여 기본 헤더로 설정';
        }
        badge.disabled = false;
    }
}

function updateActiveBadges(newActiveId) {
    const activeBadges = document.querySelectorAll('.active-badge');

    activeBadges.forEach(badge => {
        const headerId = badge.dataset.headerId;

        if (headerId === newActiveId) {
            // Set as new active
            badge.className = 'badge bg-primary border-0 active-badge';
            badge.textContent = '사용중';
            badge.dataset.currentActive = 'true';
            badge.title = '현재 사용중인 헤더';
            badge.disabled = false;
        } else {
            // Set as inactive
            badge.className = 'badge bg-secondary border-0 active-badge';
            badge.textContent = '대기중';
            badge.dataset.currentActive = 'false';
            badge.title = '클릭하여 활성화';
            badge.disabled = false;
        }
    });
}

function updateActiveBadge(headerId, isActive) {
    const badge = document.querySelector(`.active-badge[data-header-id="${headerId}"]`);
    if (badge) {
        if (isActive) {
            badge.className = 'badge bg-primary border-0 active-badge';
            badge.textContent = '사용중';
            badge.dataset.currentActive = 'true';
            badge.title = '현재 사용중인 헤더';
        } else {
            badge.className = 'badge bg-secondary border-0 active-badge';
            badge.textContent = '대기중';
            badge.dataset.currentActive = 'false';
            badge.title = '클릭하여 활성화';
        }
        badge.disabled = false;
    }
}

function updateEnableBadge(headerId, isEnabled) {
    const enableBadge = document.querySelector(`.enable-badge[data-header-id="${headerId}"]`);
    const activeBadgeContainer = enableBadge.closest('tr').cells[3]; // active column (사용중)

    if (enableBadge) {
        if (isEnabled) {
            enableBadge.className = 'badge bg-success border-0 enable-badge ms-2';
            enableBadge.textContent = '활성화';
            enableBadge.dataset.currentEnable = 'true';
            enableBadge.title = '클릭하여 비활성화';

            // Show active badge
            activeBadgeContainer.innerHTML = `
                <button class="badge border-0 active-badge bg-secondary"
                        data-header-id="${headerId}"
                        data-current-active="false"
                        title="클릭하여 활성화">
                    대기중
                </button>
            `;

            // Re-attach event listener to the new active badge
            const newActiveBadge = activeBadgeContainer.querySelector('.active-badge');
            if (newActiveBadge) {
                attachActiveBadgeListener(newActiveBadge);
            }
        } else {
            enableBadge.className = 'badge bg-danger border-0 enable-badge ms-2';
            enableBadge.textContent = '비활성화';
            enableBadge.dataset.currentEnable = 'false';
            enableBadge.title = '클릭하여 활성화';

            // Hide active badge
            activeBadgeContainer.innerHTML = '<span class="badge bg-light text-muted">비활성화됨</span>';
        }
        enableBadge.disabled = false;
    }
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';

    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endpush

@push('styles')
<style>
.badge {
    font-size: 0.75em;
}

.default-badge, .enable-badge, .active-badge {
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.75em;
    padding: 0.375em 0.75em;
}

.default-badge:hover:not([data-current-default="true"]),
.enable-badge:hover,
.active-badge:hover:not([data-current-active="true"]) {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.default-badge[data-current-default="true"],
.active-badge[data-current-active="true"] {
    cursor: default;
    opacity: 0.8;
}

.default-badge:disabled,
.enable-badge:disabled,
.active-badge:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.card-title {
    color: #495057;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush