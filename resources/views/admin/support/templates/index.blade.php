@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 템플릿 관리')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fe fe-file-text me-2"></i>
                지원 요청 템플릿 관리
            </h1>
            <p class="text-muted">고객 지원 응답에 사용할 수 있는 템플릿을 관리합니다.</p>
        </div>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#previewModal">
                <i class="fe fe-eye me-1"></i> 미리보기
            </button>
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="템플릿 제목 또는 내용으로 검색...">
                <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="categoryFilter">
                <option value="">모든 카테고리</option>
                <option value="status">상태 알림</option>
                <option value="inquiry">문의 응답</option>
                <option value="guide">가이드</option>
                <option value="technical">기술 지원</option>
                <option value="general">일반</option>
            </select>
        </div>
    </div>

    {{-- Template Cards --}}
    <div class="row" id="templatesContainer">
        @foreach($templates as $key => $template)
        <div class="col-lg-6 col-xl-4 mb-4 template-card" data-category="{{ $template['category'] ?? 'general' }}">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $template['title'] }}</h5>
                    <span class="badge bg-secondary">{{ ucfirst($template['category'] ?? 'general') }}</span>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">{{ $template['description'] ?? '설명이 없습니다.' }}</p>

                    {{-- Template Preview --}}
                    <div class="template-preview">
                        <small class="text-muted">내용 미리보기:</small>
                        <div class="bg-light p-2 rounded mt-1" style="max-height: 120px; overflow-y: auto;">
                            <small>{{ Str::limit($template['content'], 150) }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="previewTemplate('{{ $key }}')">
                            <i class="fe fe-eye me-1"></i> 미리보기
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm"
                                onclick="useTemplate('{{ $key }}')">
                            <i class="fe fe-copy me-1"></i> 사용하기
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="text-center py-5" style="display: none;">
        <i class="fe fe-search display-4 text-muted"></i>
        <h4 class="mt-3">검색 결과가 없습니다</h4>
        <p class="text-muted">다른 검색어나 필터를 시도해 보세요.</p>
    </div>
</div>

{{-- Preview Modal --}}
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">템플릿 미리보기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent">
                    <div class="text-center py-4">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">로딩 중...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard()">
                    <i class="fe fe-copy me-1"></i> 클립보드에 복사
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

{{-- Use Template Modal --}}
<div class="modal fade" id="useTemplateModal" tabindex="-1" role="dialog" aria-labelledby="useTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="useTemplateModalLabel">템플릿 사용하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="templateForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="customerName" class="form-label">고객명</label>
                            <input type="text" class="form-control" id="customerName" placeholder="홍길동">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supportId" class="form-label">지원 요청 번호</label>
                            <input type="text" class="form-control" id="supportId" placeholder="#12345">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="subject" class="form-label">제목</label>
                            <input type="text" class="form-control" id="subject" placeholder="문의 제목">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="processedContent" class="form-label">처리된 내용</label>
                        <textarea class="form-control" id="processedContent" rows="10" readonly></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="processTemplate()">
                    <i class="fe fe-refresh-cw me-1"></i> 템플릿 적용
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="copyProcessedContent()">
                    <i class="fe fe-copy me-1"></i> 복사
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<script>
// 전역 변수
let templates = @json($templates);
let currentTemplateKey = null;
let previewContent = '';

// 검색 기능
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        searchTemplates();
    }
});

document.getElementById('searchBtn').addEventListener('click', searchTemplates);
document.getElementById('categoryFilter').addEventListener('change', searchTemplates);

function searchTemplates() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('categoryFilter').value;

    const cards = document.querySelectorAll('.template-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const content = card.querySelector('.template-preview small').textContent.toLowerCase();
        const cardCategory = card.dataset.category;

        const matchesQuery = !query || title.includes(query) || content.includes(query);
        const matchesCategory = !category || cardCategory === category;

        if (matchesQuery && matchesCategory) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // 빈 상태 표시
    document.getElementById('emptyState').style.display = visibleCount === 0 ? 'block' : 'none';
}

// 템플릿 미리보기
function previewTemplate(templateKey) {
    currentTemplateKey = templateKey;

    // 로딩 표시
    document.getElementById('previewContent').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">로딩 중...</span>
            </div>
        </div>
    `;

    // 모달 열기
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();

    // 미리보기 요청
    fetch(`{{ url()->current() }}/${templateKey}/preview`)
        .then(response => response.text())
        .then(content => {
            previewContent = content;
            document.getElementById('previewContent').innerHTML = `
                <div class="bg-light p-3 rounded">
                    <pre style="white-space: pre-wrap; font-family: inherit;">${content}</pre>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('previewContent').innerHTML = `
                <div class="alert alert-danger">
                    미리보기를 불러오는 중 오류가 발생했습니다.
                </div>
            `;
        });
}

// 템플릿 사용하기
function useTemplate(templateKey) {
    currentTemplateKey = templateKey;

    // 모달 열기
    const modal = new bootstrap.Modal(document.getElementById('useTemplateModal'));
    modal.show();

    // 초기 템플릿 적용
    processTemplate();
}

// 템플릿 처리
function processTemplate() {
    if (!currentTemplateKey) return;

    const formData = {
        template_key: currentTemplateKey,
        variables: {
            customer_name: document.getElementById('customerName').value || '고객님',
            support_id: document.getElementById('supportId').value || '#{지원요청번호}',
            subject: document.getElementById('subject').value || '{제목}'
        }
    };

    fetch('{{ url()->current() }}/process', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('processedContent').value = data.processed_content;
        } else {
            alert('템플릿 처리 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('템플릿 처리 중 오류가 발생했습니다.');
    });
}

// 클립보드에 복사
function copyToClipboard() {
    if (previewContent) {
        navigator.clipboard.writeText(previewContent).then(() => {
            // 성공 토스트 (선택사항)
            showToast('클립보드에 복사되었습니다.', 'success');
        });
    }
}

function copyProcessedContent() {
    const content = document.getElementById('processedContent').value;
    if (content) {
        navigator.clipboard.writeText(content).then(() => {
            showToast('클립보드에 복사되었습니다.', 'success');
        });
    }
}

// 간단한 토스트 알림
function showToast(message, type = 'info') {
    // 간단한 알림 구현 (필요에 따라 토스트 라이브러리 사용 가능)
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'info'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// 폼 필드 변경 시 자동으로 템플릿 재처리
document.getElementById('customerName').addEventListener('input', processTemplate);
document.getElementById('supportId').addEventListener('input', processTemplate);
document.getElementById('subject').addEventListener('input', processTemplate);
</script>
@endsection
