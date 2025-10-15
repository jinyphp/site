@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '팀원 상세')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cms.about.organization.index') }}">조직 관리</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}">{{ $organization->name }} 팀원</a></li>
                            <li class="breadcrumb-item active">{{ $member->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0">팀원 상세: {{ $member->name }}</h1>
                    <p class="text-muted">팀원의 상세 정보입니다.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.cms.about.organization.members.edit', [$organization->id, $member->id]) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>수정
                    </a>
                    <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- 왼쪽: 기본 정보 -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">기본 정보</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-4">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                             class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width: 120px; height: 120px;">
                                            <i class="bi bi-person text-white fs-1"></i>
                                        </div>
                                    @endif
                                    <div>
                                        @if($member->is_active)
                                            <span class="badge bg-success">활성</span>
                                        @else
                                            <span class="badge bg-secondary">비활성</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">이름</strong>
                                            <p class="mb-0">{{ $member->name }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">직책</strong>
                                            <p class="mb-0">
                                                <span class="badge bg-primary">{{ $member->position }}</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">이메일</strong>
                                            <p class="mb-0">
                                                @if($member->email)
                                                    <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">전화번호</strong>
                                            <p class="mb-0">
                                                @if($member->phone)
                                                    <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">정렬 순서</strong>
                                            <p class="mb-0">{{ $member->sort_order }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong class="text-muted d-block">등록일</strong>
                                            <p class="mb-0">{{ $member->created_at->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($member->bio)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">소개글</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{!! nl2br(e($member->bio)) !!}</p>
                        </div>
                    </div>
                    @endif

                    @if($member->linkedin_url || $member->twitter_url || $member->github_url)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">소셜 미디어</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-3">
                                @if($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-linkedin me-2"></i>LinkedIn
                                    </a>
                                @endif
                                @if($member->twitter_url)
                                    <a href="{{ $member->twitter_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-twitter me-2"></i>Twitter
                                    </a>
                                @endif
                                @if($member->github_url)
                                    <a href="{{ $member->github_url }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                        <i class="bi bi-github me-2"></i>GitHub
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- 오른쪽: 조직 정보 및 액션 -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">소속 조직</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="bi bi-building fs-2 text-primary"></i>
                            </div>
                            <h6 class="text-center mb-3">{{ $organization->name }}</h6>
                            @if($organization->description)
                                <p class="text-muted small text-center">{{ $organization->description }}</p>
                            @endif
                            <div class="d-grid">
                                <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-people me-2"></i>팀원 목록 보기
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">관리 작업</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.cms.about.organization.members.edit', [$organization->id, $member->id]) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-2"></i>정보 수정
                                </a>

                                <form method="POST" action="{{ route('admin.cms.about.organization.members.toggle', [$organization->id, $member->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn {{ $member->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                        @if($member->is_active)
                                            <i class="bi bi-pause-circle me-2"></i>비활성화
                                        @else
                                            <i class="bi bi-play-circle me-2"></i>활성화
                                        @endif
                                    </button>
                                </form>

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash me-2"></i>삭제
                                </button>
                            </div>
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
                <h5 class="modal-title">팀원 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 팀원을 삭제하시겠습니까?</p>
                <p class="text-danger"><strong>{{ $member->name }}</strong></p>
                <p class="text-muted small">삭제된 데이터는 복구할 수 없습니다.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form method="POST" action="{{ route('admin.cms.about.organization.members.destroy', [$organization->id, $member->id]) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection