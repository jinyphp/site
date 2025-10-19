@extends('jiny-site::layouts.admin.sidebar')

@section('title', '푸터 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">푸터 관리</h1>
                    <p class="mb-0 text-muted">사이트 템플릿 푸터를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.footer.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 푸터 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.footer.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i> 새 푸터 추가
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-layout-footer fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">활성화됨</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['enabled'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">사용중</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-play-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">기본 푸터</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['default'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-star fa-2x text-gray-300"></i>
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
                    <h5 class="card-title mb-0">푸터 목록</h5>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($footers) > 0)
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
                                    @foreach($footers as $footer)
                                        <tr>
                                            <td>{{ $footer['id'] }}</td>
                                            <td>
                                                <code class="text-primary">{{ $footer['path'] ?? $footer['footer_key'] ?? 'N/A' }}</code>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong class="d-block">
                                                        {{ $footer['title'] ?? $footer['name'] ?? 'N/A' }}
                                                        <button class="badge border-0 enable-badge ms-2 {{ ($footer['enable'] ?? true) ? 'bg-success' : 'bg-danger' }}"
                                                                data-footer-id="{{ $footer['id'] }}"
                                                                data-current-enable="{{ ($footer['enable'] ?? true) ? 'true' : 'false' }}"
                                                                title="클릭하여 {{ ($footer['enable'] ?? true) ? '비활성화' : '활성화' }}">
                                                            {{ ($footer['enable'] ?? true) ? '활성화' : '비활성화' }}
                                                        </button>
                                                    </strong>
                                                    <small class="text-muted d-block mt-1">{{ $footer['description'] ?? '설명 없음' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($footer['enable'] ?? true)
                                                    <button class="badge border-0 active-badge {{ ($footer['active'] ?? false) ? 'bg-primary' : 'bg-secondary' }}"
                                                            data-footer-id="{{ $footer['id'] }}"
                                                            data-current-active="{{ ($footer['active'] ?? false) ? 'true' : 'false' }}"
                                                            title="클릭하여 {{ ($footer['active'] ?? false) ? '비활성화' : '활성화' }}">
                                                        {{ ($footer['active'] ?? false) ? '사용중' : '대기중' }}
                                                    </button>
                                                @else
                                                    <span class="badge bg-light text-muted">비활성화됨</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($footer['default'] ?? false)
                                                    <button class="badge bg-success border-0 default-badge"
                                                            data-footer-id="{{ $footer['id'] }}"
                                                            data-current-default="true"
                                                            title="현재 기본 푸터 (클릭하여 변경 불가)">
                                                        기본
                                                    </button>
                                                @else
                                                    <button class="badge bg-secondary border-0 default-badge"
                                                            data-footer-id="{{ $footer['id'] }}"
                                                            data-current-default="false"
                                                            title="클릭하여 기본 푸터로 설정">
                                                        일반
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cms.templates.footer.show', $footer['id']) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.footer.edit', $footer['id']) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $footer['id'] }})" title="삭제">
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
                            <small class="text-muted">총 {{ count($footers) }}개의 푸터</small>
                        </div>
                    @else
                        <div class="text-center py-5 m-3">
                            <i class="bi bi-layout-footer fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">푸터가 없습니다</h5>
                            <p class="text-muted">첫 번째 푸터를 생성해보세요</p>
                            <a href="{{ route('admin.cms.templates.footer.create') }}" class="btn btn-primary">
                                푸터 생성
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
                <p>정말로 이 푸터를 삭제하시겠습니까?</p>
                <p><strong>푸터 경로:</strong> <span id="delete-footer-path"></span></p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>주의:</strong> 이 작업은 되돌릴 수 없습니다. 이 푸터를 사용하는 템플릿이 있다면 오류가 발생할 수 있습니다.
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
function confirmDelete(footerId) {
    // 해당 행에서 푸터 경로 가져오기 - 더 안전한 방법
    const buttons = document.querySelectorAll('.btn-outline-danger');
    let footerPath = '';

    buttons.forEach(btn => {
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(footerId)) {
            const row = btn.closest('tr');
            footerPath = row.querySelector('code').textContent;
        }
    });

    document.getElementById('delete-footer-path').textContent = footerPath;
    document.getElementById('delete-form').action = `/admin/cms/templates/footer/${footerId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// AJAX functionality for footer management
document.addEventListener('DOMContentLoaded', function() {
    // Default footer setting
    const defaultBadges = document.querySelectorAll('.default-badge');
    defaultBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const footerId = this.dataset.footerId;
            const isCurrentDefault = this.dataset.currentDefault === 'true';

            // Don't allow clicking on already default footer
            if (isCurrentDefault) {
                return;
            }

            // Show loading state
            const originalText = this.textContent;
            this.textContent = '설정중...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/admin/cms/templates/footer/${footerId}/set-default`, {
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
                    updateDefaultBadges(footerId);
                    updateActiveBadges(footerId);

                    // Show success message
                    showNotification('기본 푸터가 성공적으로 설정되었습니다.', 'success');
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
            const footerId = this.dataset.footerId;
            const isCurrentlyEnabled = this.dataset.currentEnable === 'true';

            // Show loading state
            const originalText = this.textContent;
            this.textContent = '처리중...';
            this.disabled = true;

            // Make AJAX request
            fetch(`/admin/cms/templates/footer/${footerId}/toggle-enable`, {
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
                    updateEnableBadge(footerId, data.new_enable_status);

                    // If disabled, update other badges too
                    if (!data.new_enable_status) {
                        updateActiveBadge(footerId, false);
                        updateDefaultBadge(footerId, false);
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

    // Active footer setting
    const activeBadges = document.querySelectorAll('.active-badge');
    activeBadges.forEach(badge => {
        attachActiveBadgeListener(badge);
    });
});

function attachActiveBadgeListener(badge) {
    badge.addEventListener('click', function() {
        const footerId = this.dataset.footerId;
        const isCurrentlyActive = this.dataset.currentActive === 'true';

        // Don't allow clicking on already active footer
        if (isCurrentlyActive) {
            return;
        }

        // Show loading state
        const originalText = this.textContent;
        this.textContent = '설정중...';
        this.disabled = true;

        // Make AJAX request
        fetch(`/admin/cms/templates/footer/${footerId}/set-active`, {
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
                updateActiveBadges(footerId);

                // Show success message
                showNotification('활성 푸터가 성공적으로 설정되었습니다.', 'success');
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
        const footerId = badge.dataset.footerId;

        if (footerId === newDefaultId) {
            // Set as new default
            badge.className = 'badge bg-success border-0 default-badge';
            badge.textContent = '기본';
            badge.dataset.currentDefault = 'true';
            badge.title = '현재 기본 푸터 (클릭하여 변경 불가)';
            badge.disabled = false;
        } else {
            // Set as regular
            badge.className = 'badge bg-secondary border-0 default-badge';
            badge.textContent = '일반';
            badge.dataset.currentDefault = 'false';
            badge.title = '클릭하여 기본 푸터로 설정';
            badge.disabled = false;
        }
    });
}

function updateDefaultBadge(footerId, isDefault) {
    const badge = document.querySelector(`.default-badge[data-footer-id="${footerId}"]`);
    if (badge) {
        if (isDefault) {
            badge.className = 'badge bg-success border-0 default-badge';
            badge.textContent = '기본';
            badge.dataset.currentDefault = 'true';
            badge.title = '현재 기본 푸터 (클릭하여 변경 불가)';
        } else {
            badge.className = 'badge bg-secondary border-0 default-badge';
            badge.textContent = '일반';
            badge.dataset.currentDefault = 'false';
            badge.title = '클릭하여 기본 푸터로 설정';
        }
        badge.disabled = false;
    }
}

function updateActiveBadges(newActiveId) {
    const activeBadges = document.querySelectorAll('.active-badge');

    activeBadges.forEach(badge => {
        const footerId = badge.dataset.footerId;

        if (footerId === newActiveId) {
            // Set as new active
            badge.className = 'badge bg-primary border-0 active-badge';
            badge.textContent = '사용중';
            badge.dataset.currentActive = 'true';
            badge.title = '현재 사용중인 푸터';
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

function updateActiveBadge(footerId, isActive) {
    const badge = document.querySelector(`.active-badge[data-footer-id="${footerId}"]`);
    if (badge) {
        if (isActive) {
            badge.className = 'badge bg-primary border-0 active-badge';
            badge.textContent = '사용중';
            badge.dataset.currentActive = 'true';
            badge.title = '현재 사용중인 푸터';
        } else {
            badge.className = 'badge bg-secondary border-0 active-badge';
            badge.textContent = '대기중';
            badge.dataset.currentActive = 'false';
            badge.title = '클릭하여 활성화';
        }
        badge.disabled = false;
    }
}

function updateEnableBadge(footerId, isEnabled) {
    const enableBadge = document.querySelector(`.enable-badge[data-footer-id="${footerId}"]`);
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
                        data-footer-id="${footerId}"
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