@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.site.products.index') }}" class="text-decoration-none">
                                    상품 목록
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $product->title }} - 이미지 갤러리
                            </li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.show', $product->id) }}" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-arrow-left me-2"></i>상품으로 돌아가기
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fe fe-upload me-2"></i>이미지 업로드
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 상품 정보 카드 -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->title }}"
                         class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="fe fe-package text-muted"></i>
                    </div>
                @endif
                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $product->title }}</h5>
                    <p class="text-muted mb-0">{{ $product->category_name ?: '카테고리 없음' }}</p>
                </div>
                @if($product->enable)
                    <span class="badge bg-success">판매중</span>
                @else
                    <span class="badge bg-secondary">준비중</span>
                @endif
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-image text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 이미지</h6>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">활성 이미지</h6>
                            <h4 class="mb-0">{{ $stats['enabled'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-star text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">대표 이미지</h6>
                            <h4 class="mb-0">{{ $stats['featured'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 드래그 앤 드롭 업로드 영역 -->
    <div class="card mb-4" id="dropZoneCard">
        <div class="card-body">
            <div id="dropZone" class="drop-zone text-center p-4 rounded border-2 border-dashed">
                <div class="drop-zone-content">
                    <i class="fe fe-upload fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">이미지를 여기에 드래그하거나 클릭하여 업로드</h5>
                    <p class="text-muted mb-3">JPG, PNG, WebP 파일만 업로드 가능 (최대 5MB, 여러 파일 선택 가능)</p>
                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('quickUpload').click()">
                        <i class="fe fe-plus me-2"></i>파일 선택
                    </button>
                    <input type="file" id="quickUpload" multiple accept="image/*" style="display: none;">
                </div>
                <div class="drop-zone-overlay d-none">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <i class="fe fe-upload fe-4x text-primary mb-3"></i>
                            <h4 class="text-primary">파일을 여기에 놓으세요</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 업로드 진행률 -->
            <div id="quickUploadProgress" class="d-none mt-3">
                <div class="progress mb-2">
                    <div id="quickProgressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <div id="quickUploadStatus" class="text-center text-muted"></div>
            </div>
        </div>
    </div>

    <!-- 이미지 갤러리 -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">이미지 갤러리</h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleView('grid')" id="gridBtn">
                        <i class="fe fe-grid"></i> 그리드
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleView('list')" id="listBtn">
                        <i class="fe fe-list"></i> 목록
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($images->count() > 0)
                <!-- 그리드 뷰 -->
                <div id="gridView" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach($images as $image)
                    <div class="col">
                        <div class="card h-100 image-card" data-image-id="{{ $image->id }}">
                            <div class="position-relative">
                                <img src="{{ $image->thumbnail_url ?: $image->image_url }}"
                                     alt="{{ $image->alt_text ?: $image->title }}"
                                     class="card-img-top"
                                     style="height: 200px; object-fit: cover; cursor: pointer;"
                                     onclick="viewImage('{{ $image->image_url }}', '{{ $image->title }}')">

                                <!-- 대표 이미지 배지 -->
                                @if($image->is_featured)
                                    <span class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fe fe-star me-1"></i>대표
                                        </span>
                                    </span>
                                @endif

                                <!-- 상태 배지 -->
                                <span class="position-absolute top-0 end-0 m-2">
                                    @if($image->enable)
                                        <span class="badge bg-success">활성</span>
                                    @else
                                        <span class="badge bg-secondary">비활성</span>
                                    @endif
                                </span>

                                <!-- 드래그 핸들 -->
                                <div class="position-absolute bottom-0 start-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75 drag-handle" style="cursor: move;">
                                        <i class="fe fe-move"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-3">
                                <h6 class="card-title mb-1">{{ $image->title ?: '제목 없음' }}</h6>
                                <p class="card-text small text-muted mb-2">
                                    {{ $image->description ? Str::limit($image->description, 60) : '설명 없음' }}
                                </p>

                                <!-- 이미지 정보 -->
                                <div class="row text-muted small mb-2">
                                    <div class="col-6">
                                        @if($image->image_type)
                                            <span class="badge bg-light text-dark">{{ $image->image_type_label }}</span>
                                        @endif
                                    </div>
                                    <div class="col-6 text-end">
                                        @if($image->formatted_file_size)
                                            {{ $image->formatted_file_size }}
                                        @endif
                                    </div>
                                </div>

                                <!-- 액션 버튼 -->
                                <div class="btn-group btn-group-sm w-100">
                                    <button type="button" class="btn btn-outline-info"
                                            onclick="editImage({{ $image->id }})" title="편집">
                                        <i class="fe fe-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning"
                                            onclick="toggleFeatured({{ $image->id }})" title="대표 이미지 토글">
                                        <i class="fe fe-star"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="toggleEnable({{ $image->id }})" title="활성/비활성">
                                        <i class="fe fe-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="deleteImage({{ $image->id }})" title="삭제">
                                        <i class="fe fe-trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- 리스트 뷰 -->
                <div id="listView" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="50"><i class="fe fe-move"></i></th>
                                    <th width="80">이미지</th>
                                    <th>제목</th>
                                    <th>타입</th>
                                    <th>크기</th>
                                    <th width="100">상태</th>
                                    <th width="150">등록일</th>
                                    <th width="120">관리</th>
                                </tr>
                            </thead>
                            <tbody id="sortableImages">
                                @foreach($images as $image)
                                <tr data-image-id="{{ $image->id }}">
                                    <td class="drag-handle" style="cursor: move;">
                                        <i class="fe fe-move text-muted"></i>
                                    </td>
                                    <td>
                                        <img src="{{ $image->thumbnail_url ?: $image->image_url }}"
                                             alt="{{ $image->alt_text ?: $image->title }}"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                             onclick="viewImage('{{ $image->image_url }}', '{{ $image->title }}')">
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $image->title ?: '제목 없음' }}</strong>
                                            @if($image->is_featured)
                                                <span class="badge bg-warning text-dark ms-1">대표</span>
                                            @endif
                                        </div>
                                        @if($image->description)
                                            <small class="text-muted">{{ Str::limit($image->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($image->image_type)
                                            <span class="badge bg-light text-dark">{{ $image->image_type_label }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($image->dimensions)
                                                {{ $image->dimensions }}<br>
                                            @endif
                                            {{ $image->formatted_file_size }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($image->enable)
                                            <span class="badge bg-success">활성</span>
                                        @else
                                            <span class="badge bg-secondary">비활성</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($image->created_at)->format('Y-m-d H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-info"
                                                    onclick="editImage({{ $image->id }})" title="편집">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger"
                                                    onclick="deleteImage({{ $image->id }})" title="삭제">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-image fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 이미지가 없습니다</h5>
                    <p class="text-muted">새 이미지를 업로드해보세요.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fe fe-upload me-2"></i>이미지 업로드
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 이미지 업로드 모달 -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">이미지 업로드</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="images" class="form-label">이미지 파일 <span class="text-danger">*</span></label>
                                <input type="file" id="images" name="images[]" class="form-control"
                                       accept="image/*" multiple required>
                                <small class="form-text text-muted">
                                    JPG, PNG, WebP 파일만 업로드 가능 (최대 5MB, 여러 파일 선택 가능)
                                </small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="image_type" class="form-label">이미지 타입</label>
                                <select id="image_type" name="image_type" class="form-control">
                                    <option value="main">메인 이미지</option>
                                    <option value="detail">상세 이미지</option>
                                    <option value="lifestyle">라이프스타일</option>
                                    <option value="tech_spec">기술 사양</option>
                                    <option value="packaging">패키징</option>
                                    <option value="comparison">비교 이미지</option>
                                    <option value="installation">설치 가이드</option>
                                    <option value="accessories">액세서리</option>
                                </select>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" id="is_featured" name="is_featured" class="form-check-input" value="1">
                                <label for="is_featured" class="form-check-label">대표 이미지로 설정</label>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" id="enable" name="enable" class="form-check-input" value="1" checked>
                                <label for="enable" class="form-check-label">즉시 활성화</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">제목</label>
                                <input type="text" id="title" name="title" class="form-control"
                                       placeholder="이미지 제목 (선택사항)">
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label">설명</label>
                                <textarea id="description" name="description" class="form-control" rows="3"
                                          placeholder="이미지 설명 (선택사항)"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="alt_text" class="form-label">Alt 텍스트</label>
                                <input type="text" id="alt_text" name="alt_text" class="form-control"
                                       placeholder="접근성을 위한 대체 텍스트">
                            </div>

                            <div class="form-group mb-3">
                                <label for="tags" class="form-label">태그</label>
                                <input type="text" id="tags" name="tags" class="form-control"
                                       placeholder="태그1, 태그2, 태그3">
                                <small class="form-text text-muted">쉼표로 구분하여 입력</small>
                            </div>
                        </div>
                    </div>

                    <!-- 업로드 진행률 -->
                    <div id="uploadProgress" class="d-none">
                        <div class="progress mb-3">
                            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="uploadStatus" class="text-center text-muted"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-upload me-2"></i>업로드
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 이미지 보기 모달 -->
<div class="modal fade" id="imageViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageViewTitle">이미지 보기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageViewImg" src="" alt="" class="img-fluid" style="max-height: 70vh;">
            </div>
        </div>
    </div>
</div>

<!-- 이미지 편집 모달 -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">이미지 편집</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_title" class="form-label">제목</label>
                        <input type="text" id="edit_title" name="title" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_description" class="form-label">설명</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_alt_text" class="form-label">Alt 텍스트</label>
                        <input type="text" id="edit_alt_text" name="alt_text" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_image_type" class="form-label">이미지 타입</label>
                        <select id="edit_image_type" name="image_type" class="form-control">
                            <option value="main">메인 이미지</option>
                            <option value="detail">상세 이미지</option>
                            <option value="lifestyle">라이프스타일</option>
                            <option value="tech_spec">기술 사양</option>
                            <option value="packaging">패키징</option>
                            <option value="comparison">비교 이미지</option>
                            <option value="installation">설치 가이드</option>
                            <option value="accessories">액세서리</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_tags" class="form-label">태그</label>
                        <input type="text" id="edit_tags" name="tags" class="form-control">
                        <small class="form-text text-muted">쉼표로 구분하여 입력</small>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" id="edit_is_featured" name="is_featured" class="form-check-input" value="1">
                        <label for="edit_is_featured" class="form-check-label">대표 이미지로 설정</label>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" id="edit_enable" name="enable" class="form-check-input" value="1">
                        <label for="edit_enable" class="form-check-label">활성화</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">저장</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">이미지 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 이미지를 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    삭제된 이미지는 복구할 수 있습니다 (소프트 삭제).
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* 통계 카드 원형 아이콘 스타일 */
.stat-circle {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px;
    min-height: 48px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.stat-circle i {
    font-size: 20px;
}

/* 이미지 카드 호버 효과 */
.image-card {
    transition: transform 0.2s ease-in-out;
}

.image-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* 드래그 앤 드롭 스타일 */
.drag-handle {
    cursor: move;
}

.sortable-ghost {
    opacity: 0.5;
}

.sortable-chosen {
    transform: scale(1.05);
}

/* 업로드 진행률 */
#uploadProgress .progress {
    height: 20px;
}

/* 드래그 앤 드롭 스타일 */
.drop-zone {
    position: relative;
    border-color: #dee2e6 !important;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.drop-zone:hover {
    border-color: #0d6efd !important;
    background-color: #e7f1ff;
}

.drop-zone.drag-over {
    border-color: #0d6efd !important;
    background-color: #e7f1ff;
    border-style: solid !important;
}

.drop-zone-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(13, 110, 253, 0.1);
    border-radius: inherit;
    z-index: 10;
}

.drop-zone-content {
    z-index: 5;
    position: relative;
}

.drop-zone.drag-over .drop-zone-content {
    opacity: 0.5;
}

/* 업로드 진행률 */
#quickUploadProgress .progress {
    height: 20px;
}

/* 반응형 그리드 */
@media (max-width: 768px) {
    .image-card .card-body {
        padding: 0.75rem;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
    }

    .drop-zone {
        min-height: 150px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let currentView = 'grid';

// 뷰 토글
function toggleView(view) {
    currentView = view;

    if (view === 'grid') {
        document.getElementById('gridView').classList.remove('d-none');
        document.getElementById('listView').classList.add('d-none');
        document.getElementById('gridBtn').classList.add('active');
        document.getElementById('listBtn').classList.remove('active');
    } else {
        document.getElementById('gridView').classList.add('d-none');
        document.getElementById('listView').classList.remove('d-none');
        document.getElementById('gridBtn').classList.remove('active');
        document.getElementById('listBtn').classList.add('active');
    }

    localStorage.setItem('imageViewMode', view);
}

// 이미지 정렬 (Sortable.js) 및 드래그 앤 드롭 초기화
document.addEventListener('DOMContentLoaded', function() {
    // 저장된 뷰 모드 복원
    const savedView = localStorage.getItem('imageViewMode') || 'grid';
    toggleView(savedView);

    // 리스트 뷰 정렬
    if (document.getElementById('sortableImages')) {
        new Sortable(document.getElementById('sortableImages'), {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateImageOrder();
            }
        });
    }

    // 드래그 앤 드롭 초기화
    initDropZone();
});

// 이미지 순서 업데이트
function updateImageOrder() {
    const rows = document.querySelectorAll('#sortableImages tr');
    const order = Array.from(rows).map((row, index) => ({
        id: row.dataset.imageId,
        pos: index + 1
    }));

    fetch(`/admin/site/products/{{ $product->id }}/images/reorder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ order })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시 (선택적)
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('순서 업데이트 중 오류가 발생했습니다.');
    });
}

// 이미지 보기
function viewImage(url, title) {
    document.getElementById('imageViewImg').src = url;
    document.getElementById('imageViewTitle').textContent = title || '이미지 보기';
    new bootstrap.Modal(document.getElementById('imageViewModal')).show();
}

// 이미지 편집
function editImage(id) {
    fetch(`/admin/site/products/{{ $product->id }}/images/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_title').value = data.title || '';
            document.getElementById('edit_description').value = data.description || '';
            document.getElementById('edit_alt_text').value = data.alt_text || '';
            document.getElementById('edit_image_type').value = data.image_type || 'main';
            document.getElementById('edit_tags').value = data.tags || '';
            document.getElementById('edit_is_featured').checked = data.is_featured;
            document.getElementById('edit_enable').checked = data.enable;

            document.getElementById('editForm').action = `/admin/site/products/{{ $product->id }}/images/${id}`;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('이미지 정보를 불러오는 중 오류가 발생했습니다.');
        });
}

// 대표 이미지 토글
function toggleFeatured(id) {
    fetch(`/admin/site/products/{{ $product->id }}/images/${id}/toggle-featured`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('상태 변경 중 오류가 발생했습니다.');
    });
}

// 활성/비활성 토글
function toggleEnable(id) {
    fetch(`/admin/site/products/{{ $product->id }}/images/${id}/toggle-enable`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('상태 변경 중 오류가 발생했습니다.');
    });
}

// 이미지 삭제
function deleteImage(id) {
    document.getElementById('deleteForm').action = `/admin/site/products/{{ $product->id }}/images/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// 이미지 업로드
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const statusDiv = document.getElementById('uploadStatus');

    progressDiv.classList.remove('d-none');
    progressBar.style.width = '0%';
    statusDiv.textContent = '업로드 준비 중...';

    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = percentComplete + '%';
            statusDiv.textContent = `업로드 중... ${Math.round(percentComplete)}%`;
        }
    });

    xhr.addEventListener('load', function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                statusDiv.textContent = '업로드 완료!';
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                statusDiv.textContent = '업로드 실패: ' + response.message;
                progressDiv.classList.add('d-none');
            }
        } else {
            statusDiv.textContent = '업로드 실패';
            progressDiv.classList.add('d-none');
        }
    });

    xhr.addEventListener('error', function() {
        statusDiv.textContent = '업로드 오류';
        progressDiv.classList.add('d-none');
    });

    xhr.open('POST', `/admin/site/products/{{ $product->id }}/images`);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(formData);
});

// 편집 폼 제출
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            location.reload();
        } else {
            alert('저장 중 오류가 발생했습니다: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('저장 중 오류가 발생했습니다.');
    });
});

// 드래그 앤 드롭 초기화
function initDropZone() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('quickUpload');

    // 페이지 전체 드래그 방지
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // 드롭존 이벤트
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);

    function highlight(e) {
        dropZone.classList.add('drag-over');
        document.querySelector('.drop-zone-overlay').classList.remove('d-none');
    }

    function unhighlight(e) {
        dropZone.classList.remove('drag-over');
        document.querySelector('.drop-zone-overlay').classList.add('d-none');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    // 파일 선택 이벤트
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        ([...files]).forEach(file => {
            if (validateFile(file)) {
                uploadFile(file);
            }
        });
    }

    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            alert(`${file.name}: 지원하지 않는 파일 형식입니다. JPG, PNG, WebP 파일만 업로드 가능합니다.`);
            return false;
        }

        if (file.size > maxSize) {
            alert(`${file.name}: 파일 크기가 너무 큽니다. 최대 5MB까지 업로드 가능합니다.`);
            return false;
        }

        return true;
    }
}

// 퀵 업로드 (드래그 앤 드롭용)
function uploadFile(file) {
    const formData = new FormData();
    formData.append('images[]', file);
    formData.append('title', file.name.split('.')[0]); // 확장자 제거한 파일명을 제목으로
    formData.append('image_type', 'detail'); // 기본값
    formData.append('enable', '1');
    formData.append('is_featured', '0');

    const progressDiv = document.getElementById('quickUploadProgress');
    const progressBar = document.getElementById('quickProgressBar');
    const statusDiv = document.getElementById('quickUploadStatus');

    progressDiv.classList.remove('d-none');
    progressBar.style.width = '0%';
    statusDiv.textContent = `${file.name} 업로드 중...`;

    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = percentComplete + '%';
            progressBar.textContent = Math.round(percentComplete) + '%';
        }
    });

    xhr.addEventListener('load', function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                statusDiv.textContent = `${file.name} 업로드 완료!`;
                progressBar.classList.add('bg-success');
                setTimeout(() => {
                    progressDiv.classList.add('d-none');
                    progressBar.classList.remove('bg-success');
                    location.reload();
                }, 1500);
            } else {
                statusDiv.textContent = `${file.name} 업로드 실패: ${response.message}`;
                progressBar.classList.add('bg-danger');
                setTimeout(() => {
                    progressDiv.classList.add('d-none');
                    progressBar.classList.remove('bg-danger');
                }, 3000);
            }
        } else {
            statusDiv.textContent = `${file.name} 업로드 실패`;
            progressBar.classList.add('bg-danger');
            setTimeout(() => {
                progressDiv.classList.add('d-none');
                progressBar.classList.remove('bg-danger');
            }, 3000);
        }
    });

    xhr.addEventListener('error', function() {
        statusDiv.textContent = `${file.name} 업로드 오류`;
        progressBar.classList.add('bg-danger');
        setTimeout(() => {
            progressDiv.classList.add('d-none');
            progressBar.classList.remove('bg-danger');
        }, 3000);
    });

    xhr.open('POST', `/admin/site/products/{{ $product->id }}/images`);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send(formData);
}
</script>
@endpush
