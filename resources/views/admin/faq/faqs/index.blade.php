@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="fe fe-help-circle me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.faq.faqs.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 FAQ 추가
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 FAQ</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-help-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">게시됨</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['published']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">초안</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['draft']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">총 좋아요</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['total_likes']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="질문, 답변" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">카테고리</label>
                            <select name="category" class="form-select">
                                <option value="all">전체</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->code }}" {{ request('category') == $category->code ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">활성화</label>
                            <select name="enable" class="form-select">
                                <option value="all">전체</option>
                                <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>게시됨</option>
                                <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>초안</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="order" {{ request('sort_by') == 'order' ? 'selected' : '' }}>순서</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                                <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>조회수</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">순서</label>
                            <select name="order" class="form-select">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>오름차순</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>내림차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.faq.faqs.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">FAQ 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            선택 삭제
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkEnable()">
                            <i class="fe fe-check-circle me-1"></i>선택 활성화
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="bulkDisable()">
                            <i class="fe fe-x-circle me-1"></i>선택 비활성화
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- 알림 메시지 영역 -->
                    <div id="alertContainer"></div>

                    @if($faqs->count() > 0)
                        <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th width="60">ID</th>
                                            <th>질문</th>
                                            <th width="120">카테고리</th>
                                            <th width="80">조회수</th>
                                            <th width="80">상태</th>
                                            <th width="200">관리</th>
                                            <th width="60" class="text-center" title="드래그하여 순서 변경">
                                                <i class="fe fe-move me-1"></i>순서
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @foreach($faqs as $faq)
                                        <tr data-id="{{ $faq->id }}">
                                            <td>
                                                <input type="checkbox" name="faq_ids[]" value="{{ $faq->id }}" class="form-check-input faq-checkbox">
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold text-primary">{{ $faq->id }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.cms.faq.faqs.show', $faq->id) }}" class="text-decoration-none">
                                                    <strong>{{ Str::limit($faq->question, 50) }}</strong>
                                                </a>
                                                <div class="text-muted small">
                                                    {{ Str::limit(strip_tags($faq->answer), 80) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($faq->category_title)
                                                    <span class="badge bg-info">{{ $faq->category_title }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ number_format($faq->views ?? 0) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($faq->enable)
                                                    <span class="badge bg-success">게시됨</span>
                                                @else
                                                    <span class="badge bg-secondary">초안</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                    <a href="{{ route('admin.cms.faq.faqs.show', $faq->id) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="fe fe-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.faq.faqs.edit', $faq->id) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="fe fe-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                            onclick="deleteFaq({{ $faq->id }})">
                                                        <i class="fe fe-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <i class="fe fe-move text-muted" style="cursor: move; font-size: 18px;" title="드래그하여 순서 변경"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        <!-- 페이지네이션 -->
                        <div class="row mt-4">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    총 {{ number_format($faqs->total()) }}개 중
                                    {{ number_format($faqs->firstItem() ?? 0) }}-{{ number_format($faqs->lastItem() ?? 0) }}개 표시
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="d-flex justify-content-end">
                                    {{ $faqs->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-help-circle fs-1 text-muted"></i>
                            <h4 class="mt-3 text-muted">FAQ가 없습니다</h4>
                            <p class="text-muted">등록된 FAQ가 없습니다.</p>
                            <a href="{{ route('admin.cms.faq.faqs.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>첫 번째 FAQ 추가
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dataTables_info {
    padding-top: 8px;
    font-size: 0.875rem;
    color: #6c757d;
}

/* 로딩 애니메이션 */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fe-loader {
    animation: spin 1s linear infinite;
}

/* 행 강조 효과 */
.table tbody tr {
    transition: background-color 0.3s ease;
}

/* 상태 배지 애니메이션 */
.badge {
    transition: all 0.3s ease;
}

/* 버튼 호버 효과 개선 */
.btn-outline-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.btn-outline-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
}

.btn-outline-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

/* 알림 메시지 애니메이션 */
.alert {
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* 드래그 핸들 스타일 */
.fe-move {
    color: #6c757d;
    transition: all 0.2s ease;
}

.fe-move:hover {
    color: #495057;
    transform: scale(1.2);
}

/* 드래그 중인 행 스타일 */
.sortable-ghost {
    opacity: 0.5;
    background-color: #f8f9fa;
}

.sortable-chosen {
    background-color: #e3f2fd;
}

/* 순서 컬럼 스타일 */
th:last-child, td:last-child {
    border-left: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

th:last-child {
    background-color: #e9ecef !important;
    font-weight: 600;
}

td:last-child:hover {
    background-color: #e9ecef;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// 페이지 로드 시 기존 세션 메시지 표시
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showAlert('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showAlert('{{ session('error') }}', 'error');
    @endif
});
</script>
<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.faq-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 정렬 기능
const sortable = Sortable.create(document.getElementById('sortable'), {
    handle: '.fe-move',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onStart: function(evt) {
        // 드래그 시작 시 피드백
        evt.item.style.cursor = 'grabbing';
    },
    onEnd: function(evt) {
        // 드래그 완료 시 커서 복원
        evt.item.style.cursor = '';

        const items = Array.from(evt.to.children).map(row => row.dataset.id);

        fetch('{{ route("admin.cms.faq.faqs.updateOrder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 순서 변경 완료 알림
                showAlert('순서가 성공적으로 업데이트되었습니다.', 'success');
            } else {
                showAlert('순서 업데이트 중 오류가 발생했습니다.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('순서 업데이트 중 오류가 발생했습니다.', 'error');
        });
    }
});

// 알림 메시지 표시 함수
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';

    const alert = document.createElement('div');
    alert.className = `alert ${alertClass} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    alertContainer.appendChild(alert);

    // 5초 후 자동 제거
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// 대량 삭제 (AJAX)
function bulkAction(action) {
    if (action !== 'delete') return;

    const checkedBoxes = document.querySelectorAll('.faq-checkbox:checked');

    if (checkedBoxes.length === 0) {
        showAlert('선택된 항목이 없습니다.', 'error');
        return;
    }

    if (!confirm(`선택된 ${checkedBoxes.length}개 항목을 삭제하시겠습니까?`)) {
        return;
    }

    const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);

    // 삭제 버튼 비활성화
    const deleteBtn = document.querySelector('.btn-outline-danger');
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fe fe-loader"></i> 삭제 중...';
    }

    // AJAX 요청
    fetch('{{ route("admin.cms.faq.faqs.bulkAction") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: action,
            ids: ids
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');

            // 삭제된 항목들을 테이블에서 애니메이션과 함께 제거
            data.ids.forEach(id => {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.style.transition = 'opacity 0.3s ease';
                    row.style.opacity = '0.5';
                    setTimeout(() => {
                        row.remove();
                    }, 300);
                }
            });

            // 전체 선택 체크박스 해제
            document.getElementById('selectAll').checked = false;

            // 페이지에 항목이 없으면 새로고침
            setTimeout(() => {
                if (document.querySelectorAll('tbody tr').length === 0) {
                    window.location.reload();
                }
            }, 500);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('작업 처리 중 오류가 발생했습니다.', 'error');
    })
    .finally(() => {
        // 삭제 버튼 재활성화
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '선택 삭제';
        }
    });
}

// 대량 활성화 (AJAX)
function bulkEnable() {
    const checkedBoxes = document.querySelectorAll('.faq-checkbox:checked');

    if (checkedBoxes.length === 0) {
        showAlert('활성화할 항목을 선택해주세요.', 'error');
        return;
    }

    if (!confirm(`선택된 ${checkedBoxes.length}개 항목을 활성화하시겠습니까?`)) {
        return;
    }

    const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);

    // 활성화 버튼 비활성화
    const enableBtn = document.querySelector('.btn-outline-success');
    if (enableBtn) {
        enableBtn.disabled = true;
        enableBtn.innerHTML = '<i class="fe fe-loader"></i> 활성화 중...';
    }

    // AJAX 요청
    fetch('{{ route("admin.cms.faq.faqs.bulkAction") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: 'enable',
            ids: ids
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');

            // UI 업데이트 - 상태 배지 변경
            data.ids.forEach(id => {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    const statusBadge = row.querySelector('td:nth-last-child(2) .badge');
                    if (statusBadge) {
                        // 애니메이션 효과
                        statusBadge.style.transition = 'all 0.3s ease';
                        statusBadge.style.transform = 'scale(1.1)';

                        setTimeout(() => {
                            statusBadge.className = 'badge bg-success';
                            statusBadge.textContent = '게시됨';
                            statusBadge.style.transform = 'scale(1)';
                        }, 150);
                    }

                    // 체크박스 해제
                    const checkbox = row.querySelector('.faq-checkbox');
                    if (checkbox) checkbox.checked = false;

                    // 행 강조 효과
                    row.style.backgroundColor = '#d4edda';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 1000);
                }
            });

            // 전체 선택 체크박스 해제
            document.getElementById('selectAll').checked = false;
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('활성화 처리 중 오류가 발생했습니다.', 'error');
    })
    .finally(() => {
        // 활성화 버튼 재활성화
        if (enableBtn) {
            enableBtn.disabled = false;
            enableBtn.innerHTML = '<i class="fe fe-check-circle me-1"></i>선택 활성화';
        }
    });
}

// 대량 비활성화 (AJAX)
function bulkDisable() {
    const checkedBoxes = document.querySelectorAll('.faq-checkbox:checked');

    if (checkedBoxes.length === 0) {
        showAlert('비활성화할 항목을 선택해주세요.', 'error');
        return;
    }

    if (!confirm(`선택된 ${checkedBoxes.length}개 항목을 비활성화하시겠습니까?`)) {
        return;
    }

    const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);

    // 비활성화 버튼 비활성화
    const disableBtn = document.querySelector('.btn-outline-secondary');
    if (disableBtn) {
        disableBtn.disabled = true;
        disableBtn.innerHTML = '<i class="fe fe-loader"></i> 비활성화 중...';
    }

    // AJAX 요청
    fetch('{{ route("admin.cms.faq.faqs.bulkAction") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: 'disable',
            ids: ids
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');

            // UI 업데이트 - 상태 배지 변경
            data.ids.forEach(id => {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    const statusBadge = row.querySelector('td:nth-last-child(2) .badge');
                    if (statusBadge) {
                        // 애니메이션 효과
                        statusBadge.style.transition = 'all 0.3s ease';
                        statusBadge.style.transform = 'scale(1.1)';

                        setTimeout(() => {
                            statusBadge.className = 'badge bg-secondary';
                            statusBadge.textContent = '초안';
                            statusBadge.style.transform = 'scale(1)';
                        }, 150);
                    }

                    // 체크박스 해제
                    const checkbox = row.querySelector('.faq-checkbox');
                    if (checkbox) checkbox.checked = false;

                    // 행 강조 효과
                    row.style.backgroundColor = '#f8d7da';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 1000);
                }
            });

            // 전체 선택 체크박스 해제
            document.getElementById('selectAll').checked = false;
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('비활성화 처리 중 오류가 발생했습니다.', 'error');
    })
    .finally(() => {
        // 비활성화 버튼 재활성화
        if (disableBtn) {
            disableBtn.disabled = false;
            disableBtn.innerHTML = '<i class="fe fe-x-circle me-1"></i>선택 비활성화';
        }
    });
}

// 개별 삭제 (AJAX)
function deleteFaq(id) {
    if (!confirm('이 FAQ를 삭제하시겠습니까?')) {
        return;
    }

    // 삭제 버튼 비활성화
    const deleteBtn = document.querySelector(`button[onclick="deleteFaq(${id})"]`);
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fe fe-loader"></i>';
    }

    fetch(`/admin/cms/faq/faqs/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('FAQ가 성공적으로 삭제되었습니다.', 'success');

            // 테이블에서 행 제거
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            }

            // 페이지에 항목이 없으면 새로고침
            if (document.querySelectorAll('tbody tr').length === 0) {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        } else {
            showAlert(data.message || 'FAQ 삭제 중 오류가 발생했습니다.', 'error');
            // 버튼 복원
            if (deleteBtn) {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fe fe-trash-2"></i>';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('FAQ 삭제 중 오류가 발생했습니다.', 'error');
        // 버튼 복원
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fe fe-trash-2"></i>';
        }
    });
}
</script>
@endpush
@endsection
