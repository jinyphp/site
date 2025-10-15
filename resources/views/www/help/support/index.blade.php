@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

@includeIf("jiny-site::www.help.partials.hero")
@includeIf("jiny-site::www.help.partials.menu")

<!-- container  -->
<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="offset-lg-2 col-lg-8 col-12">
                <div class="mb-8">
                    <!-- heading  -->
                    <h2 class="mb-4 h1 fw-semibold">지원 요청</h2>
                    <p class="lead">도움이 필요하신가요? 아래 양식을 작성해 주시면 빠르게 도움을 드리겠습니다.</p>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Support Form -->
                <form method="POST" action="{{ url('/help/support') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">전화번호</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">회사/조직</label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror"
                                   id="company" name="company" value="{{ old('company') }}">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">지원 유형 <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">지원 유형을 선택하세요</option>
                                @if(isset($supportTypesData) && $supportTypesData->count() > 0)
                                    @foreach($supportTypesData as $typeData)
                                        <option value="{{ $typeData->code }}"
                                                data-priority="{{ $typeData->default_priority }}"
                                                data-instructions="{{ $typeData->customer_instructions }}"
                                                data-required-fields="{{ json_encode($typeData->required_fields ?? []) }}"
                                                {{ old('type') == $typeData->code ? 'selected' : '' }}>
                                            <i class="{{ $typeData->icon }}"></i> {{ $typeData->name }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach($supportTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">우선순위</label>
                            <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>보통</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>낮음</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>높음</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>긴급</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 지원 유형별 안내 메시지 --}}
                    <div id="typeInstructions" class="alert alert-info" style="display: none;">
                        <i class="fe fe-info me-2"></i>
                        <span id="instructionsText"></span>
                    </div>

                    {{-- 동적 필수 필드들 --}}
                    <div id="dynamicFields">
                        {{-- 부서 필드 --}}
                        <div class="mb-3" id="departmentField" style="display: none;">
                            <label for="department" class="form-label">부서 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror"
                                   id="department" name="department" value="{{ old('department') }}">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 긴급도 필드 --}}
                        <div class="mb-3" id="urgencyField" style="display: none;">
                            <label for="urgency" class="form-label">긴급도 <span class="text-danger">*</span></label>
                            <select class="form-select @error('urgency') is-invalid @enderror" id="urgency" name="urgency">
                                <option value="">긴급도를 선택하세요</option>
                                <option value="urgent" {{ old('urgency') == 'urgent' ? 'selected' : '' }}>긴급</option>
                                <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>높음</option>
                                <option value="normal" {{ old('urgency') == 'normal' ? 'selected' : '' }}>보통</option>
                                <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>낮음</option>
                            </select>
                            @error('urgency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 사용 환경 필드 --}}
                        <div class="mb-3" id="environmentField" style="display: none;">
                            <label for="environment" class="form-label">사용 환경 <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('environment') is-invalid @enderror"
                                      id="environment" name="environment" rows="3"
                                      placeholder="운영체제, 브라우저, 버전 등 사용 환경을 자세히 입력해주세요.">{{ old('environment') }}</textarea>
                            @error('environment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">제목 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                               id="subject" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">내용 <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="6" required
                                  placeholder="문제에 대해 자세히 설명해 주세요. 오류 메시지, 스크린샷, 재현 단계 등을 포함하면 더 빠른 해결에 도움이 됩니다.">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="attachments" class="form-label">첨부파일</label>
                        <input type="file" class="form-control @error('attachments.*') is-invalid @enderror"
                               id="attachments" name="attachments[]" multiple
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                        <div class="form-text">
                            최대 10MB까지 업로드 가능합니다. 스크린샷이나 관련 문서를 첨부해 주세요.
                        </div>
                        @error('attachments.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/help') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-arrow-left me-2"></i>목록으로
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-send me-2"></i>지원 요청 제출
                        </button>
                    </div>
                </form>

                @auth
                <hr class="my-5">
                <div class="text-center">
                    <h5 class="mb-3">내 지원 요청 확인</h5>
                    <p class="text-muted mb-3">이전에 제출한 지원 요청의 진행 상황을 확인하실 수 있습니다.</p>
                    <a href="{{ url('/help/support/my') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fe fe-list me-2"></i>내 지원 요청 보기
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 지원 유형 선택 처리
    const typeSelect = document.getElementById('type');
    const prioritySelect = document.getElementById('priority');
    const instructionsDiv = document.getElementById('typeInstructions');
    const instructionsText = document.getElementById('instructionsText');
    const phoneField = document.getElementById('phone').closest('.col-md-6');
    const companyField = document.getElementById('company').closest('.col-md-6');
    const departmentField = document.getElementById('departmentField');
    const urgencyField = document.getElementById('urgencyField');
    const environmentField = document.getElementById('environmentField');
    const attachmentsField = document.getElementById('attachments').closest('.mb-4');

    // 필드 필수 상태 업데이트 함수
    function updateFieldRequirements(requiredFields) {
        // 모든 동적 필드 숨기기 및 필수 해제
        departmentField.style.display = 'none';
        urgencyField.style.display = 'none';
        environmentField.style.display = 'none';

        // 기존 필드의 필수 표시 제거
        updateFieldLabel(phoneField, false);
        updateFieldLabel(companyField, false);
        updateFieldLabel(attachmentsField, false);

        // 필수 필드에 따라 처리
        if (requiredFields && requiredFields.length > 0) {
            requiredFields.forEach(field => {
                switch (field) {
                    case 'phone':
                        updateFieldLabel(phoneField, true);
                        break;
                    case 'company':
                        updateFieldLabel(companyField, true);
                        break;
                    case 'department':
                        departmentField.style.display = 'block';
                        break;
                    case 'urgency':
                        urgencyField.style.display = 'block';
                        break;
                    case 'attachment':
                        updateFieldLabel(attachmentsField, true);
                        break;
                    case 'environment':
                        environmentField.style.display = 'block';
                        break;
                }
            });
        }
    }

    // 필드 라벨의 필수 표시 업데이트
    function updateFieldLabel(fieldContainer, required) {
        const label = fieldContainer.querySelector('label');
        if (label) {
            const requiredSpan = label.querySelector('.text-danger');
            if (required && !requiredSpan) {
                label.innerHTML += ' <span class="text-danger">*</span>';
            } else if (!required && requiredSpan) {
                requiredSpan.remove();
            }
        }
    }

    // 지원 유형 변경 이벤트
    typeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // 기본 우선순위 설정
            const defaultPriority = selectedOption.getAttribute('data-priority');
            if (defaultPriority) {
                prioritySelect.value = defaultPriority;
            }

            // 안내 메시지 표시
            const instructions = selectedOption.getAttribute('data-instructions');
            if (instructions && instructions.trim()) {
                instructionsText.textContent = instructions;
                instructionsDiv.style.display = 'block';
            } else {
                instructionsDiv.style.display = 'none';
            }

            // 필수 필드 처리
            const requiredFields = JSON.parse(selectedOption.getAttribute('data-required-fields') || '[]');
            updateFieldRequirements(requiredFields);
        } else {
            // 선택 해제 시 모든 동적 요소 숨기기
            instructionsDiv.style.display = 'none';
            updateFieldRequirements([]);
            prioritySelect.value = 'normal';
        }
    });

    // 페이지 로드 시 기존 선택값에 따른 처리
    if (typeSelect.value) {
        typeSelect.dispatchEvent(new Event('change'));
    }

    // File upload validation
    const fileInput = document.getElementById('attachments');
    const maxSize = 10 * 1024 * 1024; // 10MB in bytes

    fileInput.addEventListener('change', function(e) {
        const files = e.target.files;
        let totalSize = 0;

        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;

            if (files[i].size > maxSize) {
                alert(`파일 "${files[i].name}"이 10MB를 초과합니다.`);
                e.target.value = '';
                return;
            }
        }

        if (totalSize > maxSize * 5) {
            alert('전체 파일 크기가 50MB를 초과할 수 없습니다.');
            e.target.value = '';
        }
    });

    // 폼 제출 전 필수 필드 검증
    document.querySelector('form').addEventListener('submit', function(e) {
        const selectedOption = typeSelect.options[typeSelect.selectedIndex];
        if (selectedOption.value) {
            const requiredFields = JSON.parse(selectedOption.getAttribute('data-required-fields') || '[]');

            let hasError = false;

            requiredFields.forEach(field => {
                let fieldElement;
                switch (field) {
                    case 'phone':
                        fieldElement = document.getElementById('phone');
                        break;
                    case 'company':
                        fieldElement = document.getElementById('company');
                        break;
                    case 'department':
                        fieldElement = document.getElementById('department');
                        break;
                    case 'urgency':
                        fieldElement = document.getElementById('urgency');
                        break;
                    case 'attachment':
                        fieldElement = document.getElementById('attachments');
                        if (!fieldElement.files || fieldElement.files.length === 0) {
                            alert('첨부파일을 업로드해 주세요.');
                            hasError = true;
                        }
                        return;
                    case 'environment':
                        fieldElement = document.getElementById('environment');
                        break;
                }

                if (fieldElement && !fieldElement.value.trim()) {
                    fieldElement.focus();
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection
