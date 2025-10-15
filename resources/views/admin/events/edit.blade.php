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
                                <i class="bi bi-pencil-square me-2"></i>{{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}: {{ $event->title }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            @if($event->enable && ($event->status === 'active' || $event->status === 'planned' || $event->status === 'completed'))
                            <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                               class="btn btn-success" target="_blank">
                                <i class="fe fe-external-link me-2"></i>사이트에서 보기
                            </a>
                            @endif
                            <a href="{{ route('admin.site.event.show', $event->id) }}" class="btn btn-outline-info">
                                <i class="fe fe-eye me-2"></i>보기
                            </a>
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
    <form action="{{ route('admin.site.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xl-8 col-lg-10">
                <!-- Section 1: 이벤트 정보 수정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="bi bi-calendar-event me-2"></i>이벤트 정보 수정
                        </h4>
                    </div>
                    <div class="card-body">
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
                                           value="{{ old('title', $event->title) }}"
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
                                           value="{{ old('code', $event->code) }}"
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
                                                {{ old('status', $event->status) === $value ? 'selected' : '' }}>
                                                {{ $text }}
                                            </option>
                                            @endforeach
                                        @else
                                        <option value="active" {{ old('status', $event->status) === 'active' ? 'selected' : '' }}>활성</option>
                                        <option value="inactive" {{ old('status', $event->status) === 'inactive' ? 'selected' : '' }}>비활성</option>
                                        <option value="planned" {{ old('status', $event->status) === 'planned' ? 'selected' : '' }}>계획중</option>
                                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>완료</option>
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
                                           value="{{ old('manager', $event->manager) }}"
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
                                      placeholder="이벤트에 대한 상세한 설명을 입력하세요">{{ old('description', $event->description) }}</textarea>
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
                                    @if($event->image)
                                    <div class="mb-2">
                                        <img src="{{ $event->image }}" alt="현재 이미지"
                                             class="img-thumbnail" style="max-height: 100px;">
                                        <div class="small text-muted mt-1">현재 이미지</div>
                                    </div>
                                    @endif
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
                                           value="{{ old('blade', $event->blade) }}"
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

                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('enable') is-invalid @enderror"
                                       type="checkbox"
                                       id="enable"
                                       name="enable"
                                       value="1"
                                       {{ old('enable', $event->enable) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    {{ $fields['enable']['label'] ?? '활성화' }}
                                </label>
                                @error('enable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: 참여 신청 설정 -->
                <div class="card mb-4">
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
                                       {{ old('allow_participation', $event->allow_participation) ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_participation">
                                    참여 신청 기능 활성화
                                </label>
                                @error('allow_participation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">이 옵션을 활성화하면 사용자가 이벤트에 참여 신청할 수 있습니다.</div>
                        </div>

                        <div id="participation_settings" style="display: {{ old('allow_participation', $event->allow_participation) ? 'block' : 'none' }};">
                            <!-- 참여 인원 제한 -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_participants" class="form-label">최대 참여 인원</label>
                                        <input type="number"
                                               class="form-control @error('max_participants') is-invalid @enderror"
                                               id="max_participants"
                                               name="max_participants"
                                               value="{{ old('max_participants', $event->max_participants) }}"
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
                                            <option value="auto" {{ old('approval_type', $event->approval_type) === 'auto' ? 'selected' : '' }}>자동 승인</option>
                                            <option value="manual" {{ old('approval_type', $event->approval_type) === 'manual' ? 'selected' : '' }}>수동 승인</option>
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
                                               value="{{ old('participation_start_date', $event->participation_start_date?->format('Y-m-d\TH:i')) }}">
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
                                               value="{{ old('participation_end_date', $event->participation_end_date?->format('Y-m-d\TH:i')) }}">
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
                                          placeholder="참여자에게 보여줄 안내 메시지를 입력하세요">{{ old('participation_description', $event->participation_description) }}</textarea>
                                <div class="form-text">참여 신청 페이지에서 사용자에게 표시됩니다.</div>
                                @error('participation_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($event->allow_participation)
                            <!-- 참여자 통계 -->
                            <div class="alert alert-info">
                                <h6><i class="bi bi-bar-chart me-2"></i>참여자 현황</h6>
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="h5 mb-0">{{ $event->participants()->count() }}</div>
                                        <small>총 신청자</small>
                                    </div>
                                    <div class="col">
                                        <div class="h5 mb-0 text-success">{{ $event->approvedParticipants()->count() }}</div>
                                        <small>승인됨</small>
                                    </div>
                                    <div class="col">
                                        <div class="h5 mb-0 text-warning">{{ $event->pendingParticipants()->count() }}</div>
                                        <small>대기중</small>
                                    </div>
                                    @if($event->max_participants)
                                    <div class="col">
                                        <div class="h5 mb-0 text-primary">{{ $event->getRemainingSpots() }}</div>
                                        <small>남은 자리</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section 3: 저장/취소 버튼 -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('admin.site.event.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-x me-2"></i>취소
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-2"></i>변경사항 저장
                    </button>
                </div>
            </div>

            <!-- 사이드바 -->
            <div class="col-xl-4 col-lg-2">
                <!-- 이벤트 정보 사이드바 -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-info me-2"></i>이벤트 정보
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="small text-muted">ID</div>
                            <div class="fw-bold">{{ $event->id }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted">조회수</div>
                            <div class="fw-bold">
                                <i class="bi bi-eye me-1"></i>{{ $event->formatted_view_count }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="small text-muted">등록일</div>
                            <div>{{ $event->created_at->format('Y년 m월 d일 H:i') }}</div>
                        </div>

                        @if($event->updated_at && $event->updated_at != $event->created_at)
                        <div class="mb-3">
                            <div class="small text-muted">최종 수정일</div>
                            <div>{{ $event->updated_at->format('Y년 m월 d일 H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- 도움말 카드 -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-help-circle me-2"></i>도움말
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>참여 신청 기능</h6>
                            <p class="small text-muted">
                                사용자가 이벤트에 참여 신청할 수 있는 기능입니다. 인원 제한, 승인 방식, 참여 기간을 설정할 수 있습니다.
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6>승인 방식</h6>
                            <ul class="small text-muted">
                                <li><strong>자동 승인:</strong> 신청과 동시에 참여 확정</li>
                                <li><strong>수동 승인:</strong> 관리자가 개별 승인</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// 활성화 토글
function toggleEnable(id) {
    fetch(`/admin/site/event/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || '상태 변경에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('상태 변경 중 오류가 발생했습니다.');
    });
}

// 이벤트 삭제
function deleteEvent(id, title) {
    document.getElementById('deleteEventTitle').textContent = title;
    document.getElementById('deleteForm').action = `/admin/site/event/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

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
                <div class="small text-muted mb-1">새 이미지 미리보기:</div>
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
