@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '연혁 수정')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">연혁 수정</h1>
                    <p class="text-muted">회사 연혁 정보를 수정합니다.</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.cms.about.history.show', $history->id) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye me-2"></i>보기
                    </a>
                    <a href="{{ route('admin.cms.about.history.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>

            <!-- 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">연혁 정보</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.about.history.update', $history->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- 활성화 상태 -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="enable" name="enable" value="1"
                                           {{ old('enable', $history->enable) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable">
                                        <strong>활성화</strong>
                                        <small class="text-muted d-block">체크하면 공개적으로 표시됩니다.</small>
                                    </label>
                                </div>
                            </div>

                            <!-- 날짜 -->
                            <div class="col-md-6">
                                <label for="event_date" class="form-label">연혁 일자 <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('event_date') is-invalid @enderror"
                                       id="event_date" name="event_date"
                                       value="{{ old('event_date', $history->event_date) }}" required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 순서 -->
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">출력 순서</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order"
                                       value="{{ old('sort_order', $history->sort_order) }}" min="0">
                                <div class="form-text">낮은 숫자가 먼저 표시됩니다. (0이 최우선)</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 제목 -->
                            <div class="col-12">
                                <label for="title" class="form-label">주요 제목 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $history->title) }}" required
                                       placeholder="예: 회사 설립, 본사 이전, 신규 사업 진출 등">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 서브 내용 -->
                            <div class="col-12">
                                <label for="subtitle" class="form-label">서브 내용</label>
                                <textarea class="form-control @error('subtitle') is-invalid @enderror"
                                          id="subtitle" name="subtitle" rows="4"
                                          placeholder="연혁에 대한 자세한 설명을 입력하세요.">{{ old('subtitle', $history->subtitle) }}</textarea>
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 메타 정보 -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>등록일: {{ date('Y년 m월 d일 H:i', strtotime($history->created_at)) }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>수정일: {{ date('Y년 m월 d일 H:i', strtotime($history->updated_at)) }}
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms.about.history.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>수정 저장
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 폼 유효성 검사
    const form = document.querySelector('form');
    const eventDate = document.getElementById('event_date');
    const title = document.getElementById('title');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // 날짜 검증
        if (!eventDate.value) {
            eventDate.classList.add('is-invalid');
            isValid = false;
        } else {
            eventDate.classList.remove('is-invalid');
        }

        // 제목 검증
        if (!title.value.trim()) {
            title.classList.add('is-invalid');
            isValid = false;
        } else {
            title.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            alert('필수 항목을 모두 입력해주세요.');
        }
    });

    // 실시간 유효성 검사
    eventDate.addEventListener('change', function() {
        if (this.value) {
            this.classList.remove('is-invalid');
        }
    });

    title.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush
