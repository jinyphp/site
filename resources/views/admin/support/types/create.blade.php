@extends('jiny-admin::layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">지원 요청 유형 생성</h1>
            <p class="text-muted">새로운 지원 요청 유형을 등록합니다.</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.support.types.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> 목록으로
            </a>
        </div>
    </div>

    {{-- Main Form --}}
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.cms.support.types.store') }}" method="POST" id="supportTypeForm">
                @csrf

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
                                   value="{{ old('name') }}"
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
                                   value="{{ old('code') }}"
                                   placeholder="예: bug_report, feature_request"
                                   required>
                            <div class="form-text">영문, 숫자, 언더스코어만 사용 가능합니다.</div>
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
                                      rows="3">{{ old('description') }}</textarea>
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
                                       value="{{ old('icon', 'fa fa-question-circle') }}"
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
                                       value="{{ old('color', '#007bff') }}"
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
                                       value="{{ old('sort_order', 0) }}"
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
                                    <option value="low" {{ old('default_priority') === 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="normal" {{ old('default_priority', 'normal') === 'normal' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ old('default_priority') === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ old('default_priority') === 'urgent' ? 'selected' : '' }}>긴급</option>
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
                                            <option value="{{ $user->id }}" {{ old('default_assignee_id') == $user->id ? 'selected' : '' }}>
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
                                       value="{{ old('expected_resolution_hours', 24) }}"
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
                                      placeholder="이 유형의 지원 요청을 작성할 때 고객에게 표시될 안내 메시지를 입력하세요.">{{ old('customer_instructions') }}</textarea>
                            @error('customer_instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Required Fields --}}
                        <div class="mb-3">
                            <label class="form-label">필수 입력 필드</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="phone" id="req_phone" {{ in_array('phone', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_phone">전화번호</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="company" id="req_company" {{ in_array('company', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_company">회사명</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="department" id="req_department" {{ in_array('department', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_department">부서</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="urgency" id="req_urgency" {{ in_array('urgency', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_urgency">긴급도</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="attachment" id="req_attachment" {{ in_array('attachment', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_attachment">첨부파일</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="required_fields[]" value="environment" id="req_environment" {{ in_array('environment', old('required_fields', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="req_environment">사용 환경</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Enable Status --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="enable" id="enable" value="1" {{ old('enable', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable">
                                활성화
                            </label>
                            <div class="form-text">체크 해제시 이 유형은 선택할 수 없습니다.</div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.support.types.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times me-1"></i> 취소
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" id="previewBtn">
                                    <i class="fa fa-eye me-1"></i> 미리보기
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
                                <i id="preview-icon" class="fa fa-question-circle fa-2x" style="color: #007bff;"></i>
                            </div>
                            <div>
                                <h6 id="preview-name" class="mb-1">유형명을 입력하세요</h6>
                                <small id="preview-code" class="text-muted">code</small>
                            </div>
                        </div>

                        <div id="preview-description" class="text-muted mb-3">
                            설명을 입력하세요.
                        </div>

                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div id="preview-priority" class="h6 mb-1">보통</div>
                                    <small class="text-muted">우선순위</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div id="preview-hours" class="h6 mb-1">24시간</div>
                                    <small class="text-muted">예상 해결</small>
                                </div>
                            </div>
                        </div>

                        <div id="preview-instructions" class="mt-3 p-2 bg-light rounded">
                            <small class="text-muted">고객 안내 메시지가 여기에 표시됩니다.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    };

    // Bind preview updates to form inputs
    ['name', 'code', 'description', 'icon', 'color', 'default_priority', 'expected_resolution_hours', 'customer_instructions'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    // Auto-generate code from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const code = name.toLowerCase()
            .replace(/[^a-z0-9가-힣]/g, '_')
            .replace(/_+/g, '_')
            .replace(/^_|_$/g, '');
        document.getElementById('code').value = code;
        updatePreview();
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
});
</script>
@endsection