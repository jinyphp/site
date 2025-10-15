@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '연혁 상세보기')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">연혁 상세보기</h1>
                    <p class="text-muted">회사 연혁의 상세 정보를 확인합니다.</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.cms.about.history.edit', $history->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>수정
                    </a>
                    <a href="{{ route('admin.cms.about.history.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>

            <!-- 연혁 정보 -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">연혁 정보</h5>
                        <div>
                            <span class="badge {{ $history->enable ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ $history->enable ? '활성화' : '비활성화' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- 기본 정보 -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">기본 정보</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 100px;">ID</td>
                                    <td><strong>{{ $history->id }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">연혁 일자</td>
                                    <td><strong>{{ date('Y년 m월 d일', strtotime($history->event_date)) }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">출력 순서</td>
                                    <td><strong>{{ $history->sort_order }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">상태</td>
                                    <td>
                                        <span class="badge {{ $history->enable ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $history->enable ? '활성화' : '비활성화' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- 시스템 정보 -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">시스템 정보</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 100px;">등록일</td>
                                    <td>{{ date('Y년 m월 d일 H:i:s', strtotime($history->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">수정일</td>
                                    <td>{{ date('Y년 m월 d일 H:i:s', strtotime($history->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- 제목 -->
                        <div class="col-12">
                            <h6 class="text-muted mb-2">주요 제목</h6>
                            <div class="p-3 bg-light rounded">
                                <h4 class="mb-0">{{ $history->title }}</h4>
                            </div>
                        </div>

                        <!-- 서브 내용 -->
                        @if($history->subtitle)
                        <div class="col-12">
                            <h6 class="text-muted mb-2">서브 내용</h6>
                            <div class="p-3 bg-light rounded">
                                <div style="white-space: pre-wrap;">{{ $history->subtitle }}</div>
                            </div>
                        </div>
                        @endif

                        <!-- 미리보기 -->
                        <div class="col-12">
                            <h6 class="text-muted mb-2">미리보기</h6>
                            <div class="p-4 bg-light rounded">
                                <div class="timeline-item">
                                    <div class="d-flex align-items-start">
                                        <div class="timeline-marker bg-primary rounded-circle me-3" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                                        <div>
                                            <div class="text-muted small">{{ date('Y.m.d', strtotime($history->event_date)) }}</div>
                                            <h5 class="mb-2">{{ $history->title }}</h5>
                                            @if($history->subtitle)
                                            <p class="text-muted mb-0">{{ $history->subtitle }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                            <i class="bi bi-trash me-2"></i>삭제
                        </button>
                        <div class="btn-group">
                            <a href="{{ route('admin.cms.about.history.edit', $history->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.cms.about.history.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-list me-2"></i>목록
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">연혁 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 연혁을 삭제하시겠습니까?</p>
                <p class="text-danger"><strong>{{ $history->title }}</strong></p>
                <p class="text-muted small">삭제된 데이터는 복구할 수 없습니다.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form method="POST" action="{{ route('admin.cms.about.history.destroy', $history->id) }}" style="display: inline;">
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
function confirmDelete() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
