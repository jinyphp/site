@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

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
                                <i class="bi bi-calendar-plus me-2"></i>{{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.event.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 알림 메시지 -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fe fe-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form -->
    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">이벤트 정보</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.site.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">
                                        {{ $fields['title']['label'] ?? '제목' }}
                                        @if($fields['title']['required'] ?? false)
                                        <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="이벤트 제목을 입력하세요"
                                           {{ ($fields['title']['required'] ?? false) ? 'required' : '' }}>
                                    @if(isset($fields['title']['help']))
                                    <div class="form-text">{{ $fields['title']['help'] }}</div>
                                    @endif
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">
                                        {{ $fields['code']['label'] ?? '코드' }}
                                        @if($fields['code']['required'] ?? false)
                                        <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="code"
                                           name="code"
                                           value="{{ old('code') }}"
                                           placeholder="고유한 이벤트 코드"
                                           {{ ($fields['code']['required'] ?? false) ? 'required' : '' }}>
                                    @if(isset($fields['code']['help']))
                                    <div class="form-text">{{ $fields['code']['help'] }}</div>
                                    @endif
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        {{ $fields['status']['label'] ?? '상태' }}
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status">
                                        @if(isset($fields['status']['options']))
                                            @foreach($fields['status']['options'] as $value => $text)
                                            <option value="{{ $value }}"
                                                {{ old('status', $fields['status']['default'] ?? '') === $value ? 'selected' : '' }}>
                                                {{ $text }}
                                            </option>
                                            @endforeach
                                        @else
                                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>활성</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>비활성</option>
                                        <option value="planned" {{ old('status') === 'planned' ? 'selected' : '' }}>계획중</option>
                                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>완료</option>
                                        @endif
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manager" class="form-label">
                                        {{ $fields['manager']['label'] ?? '담당자' }}
                                    </label>
                                    <input type="text"
                                           class="form-control @error('manager') is-invalid @enderror"
                                           id="manager"
                                           name="manager"
                                           value="{{ old('manager') }}"
                                           placeholder="담당자명을 입력하세요">
                                    @if(isset($fields['manager']['help']))
                                    <div class="form-text">{{ $fields['manager']['help'] }}</div>
                                    @endif
                                    @error('manager')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                {{ $fields['description']['label'] ?? '설명' }}
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="{{ $fields['description']['rows'] ?? 4 }}"
                                      placeholder="이벤트에 대한 상세한 설명을 입력하세요">{{ old('description') }}</textarea>
                            @if(isset($fields['description']['help']))
                            <div class="form-text">{{ $fields['description']['help'] }}</div>
                            @endif
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        {{ $fields['image']['label'] ?? '이미지' }}
                                    </label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           {{ isset($fields['image']['accept']) ? 'accept=' . $fields['image']['accept'] : 'accept=image/*' }}>
                                    @if(isset($fields['image']['help']))
                                    <div class="form-text">{{ $fields['image']['help'] }}</div>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blade" class="form-label">
                                        {{ $fields['blade']['label'] ?? '블레이드 파일' }}
                                    </label>
                                    <input type="text"
                                           class="form-control @error('blade') is-invalid @enderror"
                                           id="blade"
                                           name="blade"
                                           value="{{ old('blade') }}"
                                           placeholder="커스텀 블레이드 파일명">
                                    @if(isset($fields['blade']['help']))
                                    <div class="form-text">{{ $fields['blade']['help'] }}</div>
                                    @endif
                                    @error('blade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('enable') is-invalid @enderror"
                                       type="checkbox"
                                       id="enable"
                                       name="enable"
                                       value="1"
                                       {{ old('enable', $fields['enable']['default'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    {{ $fields['enable']['label'] ?? '활성화' }}
                                </label>
                                @error('enable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- 참여 신청 설정 -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-people me-2"></i>참여 신청 설정
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- 참여 신청 활성화 -->
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('allow_participation') is-invalid @enderror"
                                               type="checkbox"
                                               id="allow_participation"
                                               name="allow_participation"
                                               value="1"
                                               {{ old('allow_participation') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="allow_participation">
                                            참여 신청 기능 활성화
                                        </label>
                                        @error('allow_participation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">이 옵션을 활성화하면 사용자가 이벤트에 참여 신청할 수 있습니다.</div>
                                </div>

                                <div id="participation_settings" style="display: none;">
                                    <!-- 참여 인원 제한 -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="max_participants" class="form-label">최대 참여 인원</label>
                                                <input type="number"
                                                       class="form-control @error('max_participants') is-invalid @enderror"
                                                       id="max_participants"
                                                       name="max_participants"
                                                       value="{{ old('max_participants') }}"
                                                       min="1"
                                                       placeholder="무제한인 경우 비워두세요">
                                                <div class="form-text">비워두면 무제한으로 설정됩니다.</div>
                                                @error('max_participants')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="approval_type" class="form-label">승인 방식</label>
                                                <select class="form-select @error('approval_type') is-invalid @enderror"
                                                        id="approval_type"
                                                        name="approval_type">
                                                    <option value="auto" {{ old('approval_type', 'auto') === 'auto' ? 'selected' : '' }}>자동 승인</option>
                                                    <option value="manual" {{ old('approval_type') === 'manual' ? 'selected' : '' }}>수동 승인</option>
                                                </select>
                                                @error('approval_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 참여 기간 설정 -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="participation_start_date" class="form-label">참여 신청 시작일</label>
                                                <input type="datetime-local"
                                                       class="form-control @error('participation_start_date') is-invalid @enderror"
                                                       id="participation_start_date"
                                                       name="participation_start_date"
                                                       value="{{ old('participation_start_date') }}">
                                                <div class="form-text">비워두면 즉시 신청 가능합니다.</div>
                                                @error('participation_start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="participation_end_date" class="form-label">참여 신청 마감일</label>
                                                <input type="datetime-local"
                                                       class="form-control @error('participation_end_date') is-invalid @enderror"
                                                       id="participation_end_date"
                                                       name="participation_end_date"
                                                       value="{{ old('participation_end_date') }}">
                                                <div class="form-text">비워두면 마감일 없이 계속 신청 가능합니다.</div>
                                                @error('participation_end_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 참여 안내 메시지 -->
                                    <div class="mb-3">
                                        <label for="participation_description" class="form-label">참여 안내 메시지</label>
                                        <textarea class="form-control @error('participation_description') is-invalid @enderror"
                                                  id="participation_description"
                                                  name="participation_description"
                                                  rows="3"
                                                  placeholder="참여자에게 보여줄 안내 메시지를 입력하세요">{{ old('participation_description') }}</textarea>
                                        <div class="form-text">참여 신청 페이지에서 사용자에게 표시됩니다.</div>
                                        @error('participation_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.site.event.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-x me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>이벤트 생성
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 도움말 사이드바 -->
        <div class="col-xl-4 col-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-help-circle me-2"></i>도움말
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>이벤트 코드</h6>
                        <p class="small text-muted">
                            이벤트를 식별하는 고유한 코드입니다. 영문자, 숫자, 하이픈(-), 언더스코어(_)만 사용 가능합니다.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6>상태</h6>
                        <ul class="small text-muted">
                            <li><strong>활성:</strong> 현재 진행 중인 이벤트</li>
                            <li><strong>비활성:</strong> 일시 중단된 이벤트</li>
                            <li><strong>계획중:</strong> 준비 중인 이벤트</li>
                            <li><strong>완료:</strong> 종료된 이벤트</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6>블레이드 파일</h6>
                        <p class="small text-muted">
                            커스텀 템플릿 파일을 지정할 수 있습니다. 비워두면 기본 템플릿을 사용합니다.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 제목을 기반으로 코드 자동 생성 (선택사항)
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const codeField = document.getElementById('code');

    if (codeField.value === '') {
        // 한글을 영문으로 변환하고 특수문자 제거
        const code = title
            .toLowerCase()
            .replace(/[^a-z0-9가-힣\s]/g, '')
            .replace(/\s+/g, '-')
            .substring(0, 50);
        codeField.value = code;
    }
});

// 이미지 미리보기
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // 기존 미리보기 제거
        const existingPreview = document.getElementById('imagePreview');
        if (existingPreview) {
            existingPreview.remove();
        }

        // 새 미리보기 생성
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.id = 'imagePreview';
            preview.className = 'mt-2';
            preview.innerHTML = `
                <img src="${e.target.result}"
                     class="img-thumbnail"
                     style="max-width: 200px; max-height: 200px;">
                <div class="small text-muted mt-1">${file.name}</div>
            `;
            document.getElementById('image').parentElement.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});

// 참여 신청 설정 토글
document.getElementById('allow_participation').addEventListener('change', function() {
    const settingsDiv = document.getElementById('participation_settings');
    if (this.checked) {
        settingsDiv.style.display = 'block';
    } else {
        settingsDiv.style.display = 'none';
    }
});

// 페이지 로드시 초기 상태 확인
document.addEventListener('DOMContentLoaded', function() {
    const allowParticipation = document.getElementById('allow_participation');
    const settingsDiv = document.getElementById('participation_settings');

    if (allowParticipation.checked) {
        settingsDiv.style.display = 'block';
    }
});
</script>
@endpush
