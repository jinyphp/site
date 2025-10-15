@extends('jiny-admin::layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">지원 요청 유형 수정</h1>
            <p class="text-muted">{{ $supportType->name }} 유형을 수정합니다.</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.support.types.show', $supportType->id) }}" class="btn btn-secondary me-2">
                <i class="fa fa-eye me-1"></i> 상세보기
            </a>
            <a href="{{ route('admin.cms.support.types.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> 목록으로
            </a>
        </div>
    </div>

    {{-- Alert for existing requests --}}
    @if($supportType->total_requests > 0)
        <div class="alert alert-info mb-4">
            <i class="fa fa-info-circle me-2"></i>
            <strong>주의:</strong> 이 유형을 사용하는 지원 요청이 {{ number_format($supportType->total_requests) }}개 있습니다.
            변경사항이 기존 요청에 영향을 줄 수 있으니 신중하게 수정해주세요.
        </div>
    @endif

    {{-- Main Form --}}
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.cms.support.types.update', $supportType->id) }}" method="POST" id="supportTypeForm">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                유형명 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $supportType->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Code --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                코드 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('code') is-invalid @enderror"
                                   id="code"
                                   name="code"
                                   value="{{ old('code', $supportType->code) }}"
                                   placeholder="예: bug_report, feature_request"
                                   required>
                            <div class="form-text">영문, 숫자, 언더스코어만 사용 가능합니다.</div>
                            @if($supportType->total_requests > 0)
                                <div class="form-text text-warning">
                                    <i class="fa fa-exclamation-triangle me-1"></i>
                                    이 코드를 변경하면 기존 요청과의 연결이 끊어질 수 있습니다.
                                </div>
                            @endif
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">설명</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3">{{ old('description', $supportType->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Icon and Color --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="icon" class="form-label">아이콘</label>
                                <input type="text"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       id="icon"
                                       name="icon"
                                       value="{{ old('icon', $supportType->icon) }}"
                                       placeholder="fa fa-question-circle">
                                <div class="form-text">FontAwesome 아이콘 클래스를 입력하세요.</div>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label">
                                    색상 <span class="text-danger">*</span>
                                </label>
                                <input type="color"
                                       class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color"
                                       name="color"
                                       value="{{ old('color', $supportType->color) }}"
                                       required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Support Configuration --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">지원 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Sort Order --}}
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">
                                    정렬 순서 <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order"
                                       name="sort_order"
                                       value="{{ old('sort_order', $supportType->sort_order) }}"
                                       min="0"
                                       required>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Default Priority --}}
                            <div class="col-md-6">
                                <label for="default_priority" class="form-label">
                                    기본 우선순위 <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('default_priority') is-invalid @enderror"
                                        id="default_priority"
                                        name="default_priority"
                                        required>
                                    <option value="low" {{ old('default_priority', $supportType->default_priority) === 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="normal" {{ old('default_priority', $supportType->default_priority) === 'normal' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ old('default_priority', $supportType->default_priority) === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ old('default_priority', $supportType->default_priority) === 'urgent' ? 'selected' : '' }}>긴급</option>
                                </select>
                                @error('default_priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            {{-- Default Assignee --}}
                            <div class="col-md-6">
                                <label for="default_assignee_id" class="form-label">기본 담당자</label>
                                <select class="form-select @error('default_assignee_id') is-invalid @enderror"
                                        id="default_assignee_id"
                                        name="default_assignee_id">
                                    <option value="">담당자 없음</option>
                                    @if(isset($assignableUsers))
                                        @foreach($assignableUsers as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('default_assignee_id', $supportType->default_assignee_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('default_assignee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Expected Resolution Hours --}}
                            <div class="col-md-6">
                                <label for="expected_resolution_hours" class="form-label">
                                    예상 해결 시간 (시간) <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control @error('expected_resolution_hours') is-invalid @enderror"
                                       id="expected_resolution_hours"
                                       name="expected_resolution_hours"
                                       value="{{ old('expected_resolution_hours', $supportType->expected_resolution_hours) }}"
                                       min="1"
                                       max="8760"
                                       required>
                                <div class="form-text">1시간 ~ 8760시간(1년) 사이로 설정하세요.</div>
                                @error('expected_resolution_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Instructions --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">고객 안내</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_instructions" class="form-label">고객 안내 메시지</label>
                            <textarea class="form-control @error('customer_instructions') is-invalid @enderror"
                                      id="customer_instructions"
                                      name="customer_instructions"
                                      rows="4"
                                      placeholder="이 유형의 지원 요청을 작성할 때 고객에게 표시될 안내 메시지를 입력하세요.">{{ old('customer_instructions', $supportType->customer_instructions) }}</textarea>
                            @error('customer_instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Required Fields --}}
                        <div class="mb-3">
                            <label class="form-label">필수 입력 필드</label>
                            <div class="row">
                                @php
                                    $currentRequiredFields = old('required_fields', $supportType->required_fields ?? []);
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="phone" id="req_phone"
                                               {{ in_array('phone', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_phone">전화번호</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="company" id="req_company"
                                               {{ in_array('company', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_company">회사명</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="department" id="req_department"
                                               {{ in_array('department', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_department">부서</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="urgency" id="req_urgency"
                                               {{ in_array('urgency', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_urgency">긴급도</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="attachment" id="req_attachment"
                                               {{ in_array('attachment', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_attachment">첨부파일</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="environment" id="req_environment"
                                               {{ in_array('environment', $currentRequiredFields) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_environment">사용 환경</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Enable Status --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="enable" id="enable" value="1"
                                   {{ old('enable', $supportType->enable) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable">
                                활성화
                            </label>
                            <div class="form-text">체크 해제시 이 유형은 선택할 수 없습니다.</div>
                            @if($supportType->total_requests > 0)
                                <div class="form-text text-warning">
                                    <i class="fa fa-exclamation-triangle me-1"></i>
                                    이 유형을 비활성화하면 고객이 더 이상 선택할 수 없지만 기존 요청은 유지됩니다.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Change Summary --}}
                <div class="card mt-4" id="changesSummary" style="display: none;">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-edit me-1"></i> 변경 사항 요약
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="changesContent"></div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.cms.support.types.show', $supportType->id) }}" class="btn btn-secondary me-2">
                                    <i class="fa fa-times me-1"></i> 취소
                                </a>
                                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                    <i class="fa fa-eye me-1"></i> 미리보기
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-info me-2" onclick="resetForm()">
                                    <i class="fa fa-undo me-1"></i> 되돌리기
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i> 저장
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Preview Panel --}}
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 1rem;">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-eye me-1"></i> 미리보기
                    </h5>
                </div>
                <div class="card-body">
                    <div id="typePreview">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i id="preview-icon" class="{{ $supportType->icon }} fa-2x" style="color: {{ $supportType->color }};"></i>
                            </div>
                            <div>
                                <h6 id="preview-name" class="mb-1">{{ $supportType->name }}</h6>
                                <small id="preview-code" class="text-muted">{{ $supportType->code }}</small>
                            </div>
                        </div>

                        <div id="preview-description" class="text-muted mb-3">
                            {{ $supportType->description ?: '설명을 입력하세요.' }}
                        </div>

                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div id="preview-priority" class="h6 mb-1">
                                        @php
                                            $priorityTexts = ['low' => '낮음', 'normal' => '보통', 'high' => '높음', 'urgent' => '긴급'];
                                        @endphp
                                        {{ $priorityTexts[$supportType->default_priority] ?? $supportType->default_priority }}
                                    </div>
                                    <small class="text-muted">우선순위</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div id="preview-hours" class="h6 mb-1">{{ $supportType->expected_resolution_hours }}시간</div>
                                    <small class="text-muted">예상 해결</small>
                                </div>
                            </div>
                        </div>

                        <div id="preview-instructions" class="mt-3 p-2 bg-light rounded">
                            <small class="text-muted">
                                {{ $supportType->customer_instructions ?: '고객 안내 메시지가 여기에 표시됩니다.' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current Statistics --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">현재 통계</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2 mb-2">
                                <div class="h6 mb-1 text-primary">{{ number_format($supportType->total_requests) }}</div>
                                <small class="text-muted">총 요청</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 mb-2">
                                <div class="h6 mb-1 text-warning">{{ number_format($supportType->pending_requests) }}</div>
                                <small class="text-muted">대기 중</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h6 mb-1 text-success">{{ number_format($supportType->resolved_requests) }}</div>
                                <small class="text-muted">해결됨</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h6 mb-1 text-info">
                                    @if($supportType->total_requests > 0)
                                        {{ number_format($supportType->avg_resolution_hours, 1) }}h
                                    @else
                                        -
                                    @endif
                                </div>
                                <small class="text-muted">평균 해결</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store original values for change detection
    const originalValues = {
        name: '{{ $supportType->name }}',
        code: '{{ $supportType->code }}',
        description: '{{ $supportType->description }}',
        icon: '{{ $supportType->icon }}',
        color: '{{ $supportType->color }}',
        default_priority: '{{ $supportType->default_priority }}',
        expected_resolution_hours: '{{ $supportType->expected_resolution_hours }}',
        customer_instructions: '{{ $supportType->customer_instructions }}',
        enable: {{ $supportType->enable ? 'true' : 'false' }}
    };

    // Live Preview Updates
    const updatePreview = () => {
        const name = document.getElementById('name').value || '유형명을 입력하세요';
        const code = document.getElementById('code').value || 'code';
        const description = document.getElementById('description').value || '설명을 입력하세요.';
        const icon = document.getElementById('icon').value || 'fa fa-question-circle';
        const color = document.getElementById('color').value;
        const priority = document.getElementById('default_priority').value;
        const hours = document.getElementById('expected_resolution_hours').value || '24';
        const instructions = document.getElementById('customer_instructions').value || '고객 안내 메시지가 여기에 표시됩니다.';

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-code').textContent = code;
        document.getElementById('preview-description').textContent = description;
        document.getElementById('preview-icon').className = icon + ' fa-2x';
        document.getElementById('preview-icon').style.color = color;

        const priorityTexts = {
            'low': '낮음',
            'normal': '보통',
            'high': '높음',
            'urgent': '긴급'
        };
        document.getElementById('preview-priority').textContent = priorityTexts[priority] || '보통';
        document.getElementById('preview-hours').textContent = hours + '시간';
        document.getElementById('preview-instructions').innerHTML = '<small class="text-muted">' + instructions + '</small>';

        // Update change summary
        updateChangesSummary();
    };

    // Update changes summary
    const updateChangesSummary = () => {
        const changes = [];
        const currentValues = {
            name: document.getElementById('name').value,
            code: document.getElementById('code').value,
            description: document.getElementById('description').value,
            icon: document.getElementById('icon').value,
            color: document.getElementById('color').value,
            default_priority: document.getElementById('default_priority').value,
            expected_resolution_hours: document.getElementById('expected_resolution_hours').value,
            customer_instructions: document.getElementById('customer_instructions').value,
            enable: document.getElementById('enable').checked
        };

        for (const [key, originalValue] of Object.entries(originalValues)) {
            const currentValue = currentValues[key];
            if (originalValue != currentValue) {
                let fieldName = '';
                switch(key) {
                    case 'name': fieldName = '유형명'; break;
                    case 'code': fieldName = '코드'; break;
                    case 'description': fieldName = '설명'; break;
                    case 'icon': fieldName = '아이콘'; break;
                    case 'color': fieldName = '색상'; break;
                    case 'default_priority': fieldName = '기본 우선순위'; break;
                    case 'expected_resolution_hours': fieldName = '예상 해결 시간'; break;
                    case 'customer_instructions': fieldName = '고객 안내 메시지'; break;
                    case 'enable': fieldName = '활성화 상태'; break;
                }
                changes.push(`<strong>${fieldName}:</strong> '${originalValue}' → '${currentValue}'`);
            }
        }

        const summaryCard = document.getElementById('changesSummary');
        const summaryContent = document.getElementById('changesContent');

        if (changes.length > 0) {
            summaryContent.innerHTML = changes.map(change => `<div class="mb-1">${change}</div>`).join('');
            summaryCard.style.display = 'block';
        } else {
            summaryCard.style.display = 'none';
        }
    };

    // Bind preview updates to form inputs
    ['name', 'code', 'description', 'icon', 'color', 'default_priority', 'expected_resolution_hours', 'customer_instructions', 'enable'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    // Form validation
    document.getElementById('supportTypeForm').addEventListener('submit', function(e) {
        const code = document.getElementById('code').value;
        if (!/^[a-z0-9_]+$/.test(code)) {
            e.preventDefault();
            alert('코드는 영문 소문자, 숫자, 언더스코어만 사용할 수 있습니다.');
            document.getElementById('code').focus();
        }
    });

    // Initialize preview
    updatePreview();

    // Required fields handling for change detection
    document.querySelectorAll('input[name="required_fields[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateChangesSummary);
    });
});

// Reset form function
function resetForm() {
    if (confirm('모든 변경사항을 되돌리시겠습니까?')) {
        location.reload();
    }
}
</script>
@endsection