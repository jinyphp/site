@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '베너 상세보기')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-bullhorn me-2"></i>베너 상세보기
                            </h1>
                            <p class="page-header-subtitle">베너 정보를 확인합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.banner.edit', $banner->id) }}" class="btn btn-primary me-2">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.site.banner.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 베너 정보 -->
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">베너 정보</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">베너 ID</label>
                                <p class="form-control-plaintext">{{ $banner->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">베너 타입</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $banner->type }}">{{ ucfirst($banner->type) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">베너 제목</label>
                        <p class="form-control-plaintext">{{ $banner->title }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">베너 메시지</label>
                        <p class="form-control-plaintext">{{ $banner->message }}</p>
                    </div>

                    @if($banner->link_url)
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">링크 URL</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $banner->link_url }}" target="_blank" class="text-decoration-none">
                                        {{ $banner->link_url }}
                                        <i class="fe fe-external-link ms-1"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">링크 텍스트</label>
                                <p class="form-control-plaintext">{{ $banner->link_text ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        @if($banner->icon)
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">아이콘</label>
                                <p class="form-control-plaintext">
                                    <i class="{{ $banner->icon }} me-2"></i>{{ $banner->icon }}
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($banner->background_color)
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">배경색</label>
                                <p class="form-control-plaintext">
                                    <span class="d-inline-block rounded me-2" style="width: 20px; height: 20px; background-color: {{ $banner->background_color }};"></span>
                                    {{ $banner->background_color }}
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($banner->text_color)
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">텍스트 색상</label>
                                <p class="form-control-plaintext">
                                    <span class="d-inline-block rounded me-2" style="width: 20px; height: 20px; background-color: {{ $banner->text_color }};"></span>
                                    {{ $banner->text_color }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">시작일</label>
                                <p class="form-control-plaintext">
                                    {{ $banner->start_date ? $banner->start_date->format('Y-m-d H:i') : '제한 없음' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">종료일</label>
                                <p class="form-control-plaintext">
                                    {{ $banner->end_date ? $banner->end_date->format('Y-m-d H:i') : '제한 없음' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">쿠키 유지일수</label>
                                <p class="form-control-plaintext">{{ $banner->cookie_days }}일</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">활성화 상태</label>
                                <p class="form-control-plaintext">
                                    @if($banner->enable)
                                        <span class="badge bg-success">활성화됨</span>
                                    @else
                                        <span class="badge bg-secondary">비활성화됨</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">닫기 버튼</label>
                                <p class="form-control-plaintext">
                                    @if($banner->is_closable)
                                        <span class="badge bg-info">표시됨</span>
                                    @else
                                        <span class="badge bg-secondary">숨김</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">표시 순서</label>
                                <p class="form-control-plaintext">{{ $banner->display_order }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">생성일</label>
                                <p class="form-control-plaintext">{{ $banner->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($banner->updated_at != $banner->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-bold">최종 수정일</label>
                        <p class="form-control-plaintext">{{ $banner->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 베너 미리보기 -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">베너 미리보기</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-{{ $banner->type }}" role="alert"
                         @if($banner->background_color || $banner->text_color)
                         style="
                         @if($banner->background_color)background-color: {{ $banner->background_color }}; border-color: {{ $banner->background_color }};@endif
                         @if($banner->text_color)color: {{ $banner->text_color }};@endif
                         "
                         @endif>
                        <div class="d-flex align-items-center">
                            @if($banner->icon)
                                <i class="{{ $banner->icon }} me-2"></i>
                            @endif
                            <div class="flex-grow-1">
                                <strong>{{ $banner->title }}</strong>
                                <div class="mt-1">{{ $banner->message }}</div>
                                @if($banner->link_url)
                                    <div class="mt-2">
                                        <a href="{{ $banner->link_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            {{ $banner->link_text ?: '링크' }}
                                            <i class="fe fe-external-link ms-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            @if($banner->is_closable)
                                <button type="button" class="btn-close" aria-label="Close"></button>
                            @endif
                        </div>
                    </div>

                    <!-- 상태 정보 -->
                    <div class="mt-3">
                        <h6 class="fw-bold">베너 상태</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <i class="fe fe-circle me-2 {{ $banner->enable ? 'text-success' : 'text-secondary' }}"></i>
                                {{ $banner->enable ? '활성화됨' : '비활성화됨' }}
                            </li>
                            <li class="mb-1">
                                <i class="fe fe-circle me-2 {{ $banner->isValid() ? 'text-success' : 'text-warning' }}"></i>
                                {{ $banner->isValid() ? '현재 표시 가능' : '표시 기간 외' }}
                            </li>
                            <li class="mb-1">
                                <i class="fe fe-circle me-2 {{ $banner->is_closable ? 'text-info' : 'text-secondary' }}"></i>
                                {{ $banner->is_closable ? '사용자가 닫을 수 있음' : '항상 표시됨' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 액션 버튼 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">관리 작업</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.site.banner.edit', $banner->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>베너 수정
                        </a>

                        <button type="button" class="btn btn-{{ $banner->enable ? 'warning' : 'success' }}"
                                onclick="toggleStatus({{ $banner->id }}, {{ $banner->enable ? 'false' : 'true' }})">
                            <i class="fe fe-{{ $banner->enable ? 'pause' : 'play' }} me-2"></i>
                            {{ $banner->enable ? '비활성화' : '활성화' }}
                        </button>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteBanner({{ $banner->id }})">
                            <i class="fe fe-trash-2 me-2"></i>베너 삭제
                        </button>

                        <hr>

                        <a href="{{ route('admin.site.banner.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 활성화/비활성화 토글
function toggleStatus(id, enabled) {
    fetch(`/admin/site/banner/${id}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ enable: enabled })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('오류가 발생했습니다.');
    });
}

// 베너 삭제
function deleteBanner(id) {
    if (confirm('정말 삭제하시겠습니까?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/site/banner/${id}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.page-header-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}

.form-control-plaintext {
    padding-left: 0;
    padding-right: 0;
    border: none;
    background-color: transparent;
}
</style>
@endsection
