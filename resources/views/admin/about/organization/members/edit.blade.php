@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '팀원 수정')

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
                            <li class="breadcrumb-item active">{{ $member->name }} 수정</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0">팀원 수정: {{ $member->name }}</h1>
                    <p class="text-muted">팀원 정보를 수정합니다.</p>
                </div>
                <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>목록으로
                </a>
            </div>

            <!-- 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">팀원 정보</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.about.organization.members.update', [$organization->id, $member->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- 활성화 상태 -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <strong>활성화</strong>
                                        <small class="text-muted d-block">체크하면 공개적으로 표시됩니다.</small>
                                    </label>
                                </div>
                            </div>

                            <!-- 기본 정보 -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $member->name) }}" required
                                       placeholder="홍길동">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="position" class="form-label">직책 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       id="position" name="position" value="{{ old('position', $member->position) }}" required
                                       placeholder="예: 팀장, 선임연구원, 매니저">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 연락처 정보 -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">이메일</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $member->email) }}"
                                       placeholder="user@company.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">전화번호</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $member->phone) }}"
                                       placeholder="010-1234-5678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 현재 사진 표시 및 새 사진 업로드 -->
                            <div class="col-12">
                                <label for="photo" class="form-label">프로필 사진</label>
                                @if($member->photo)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                             class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        <small class="text-muted">현재 사진</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                       id="photo" name="photo" accept="image/*">
                                <div class="form-text">새 사진을 업로드하면 기존 사진이 교체됩니다. JPG, PNG, GIF 파일만 업로드 가능합니다. (최대 2MB)</div>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 소개글 -->
                            <div class="col-12">
                                <label for="bio" class="form-label">소개글</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror"
                                          id="bio" name="bio" rows="4"
                                          placeholder="팀원의 경력, 전문분야, 소개 등을 입력하세요.">{{ old('bio', $member->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 소셜 미디어 링크 -->
                            <div class="col-md-4">
                                <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                       id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $member->linkedin_url) }}"
                                       placeholder="https://linkedin.com/in/username">
                                @error('linkedin_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="twitter_url" class="form-label">Twitter URL</label>
                                <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                                       id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $member->twitter_url) }}"
                                       placeholder="https://twitter.com/username">
                                @error('twitter_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="github_url" class="form-label">GitHub URL</label>
                                <input type="url" class="form-control @error('github_url') is-invalid @enderror"
                                       id="github_url" name="github_url" value="{{ old('github_url', $member->github_url) }}"
                                       placeholder="https://github.com/username">
                                @error('github_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 정렬 순서 -->
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">정렬 순서</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0">
                                <div class="form-text">낮은 숫자가 먼저 표시됩니다. (0이 최우선)</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>수정
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
    const name = document.getElementById('name');
    const position = document.getElementById('position');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // 이름 검증
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            isValid = false;
        } else {
            name.classList.remove('is-invalid');
        }

        // 직책 검증
        if (!position.value.trim()) {
            position.classList.add('is-invalid');
            isValid = false;
        } else {
            position.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            alert('필수 항목을 모두 입력해주세요.');
        }
    });

    // 실시간 유효성 검사
    name.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });

    position.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });

    // 사진 업로드 검증
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // 파일 크기 체크 (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('파일 크기는 2MB를 초과할 수 없습니다.');
                    this.value = '';
                    return;
                }

                // 파일 타입 체크
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('JPG, PNG, GIF 파일만 업로드 가능합니다.');
                    this.value = '';
                    return;
                }
            }
        });
    }
});
</script>
@endpush