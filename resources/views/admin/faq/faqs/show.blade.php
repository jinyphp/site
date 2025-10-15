@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="fe fe-eye me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.faq.faqs.edit', $faq->id) }}" class="btn btn-primary">
                                <i class="fe fe-edit-2 me-2"></i>수정
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ 상세 정보 -->
    <div class="row">
        <div class="col-xl-10 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">FAQ 상세 정보</h4>
                        <div>
                            @if($faq->enable)
                                <span class="badge bg-success">게시됨</span>
                            @else
                                <span class="badge bg-secondary">초안</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">ID</label>
                                <div class="fw-bold">{{ $faq->id }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">카테고리</label>
                                <div class="fw-bold">
                                    @if($faq->category_title)
                                        {{ $faq->category_title }}
                                        <code class="ms-2 small">{{ $faq->category }}</code>
                                    @else
                                        <span class="text-muted">미분류</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">순서</label>
                                <div class="fw-bold">{{ $faq->order ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">조회수</label>
                                <div class="fw-bold">{{ number_format($faq->views ?? 0) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">질문</label>
                        <div class="p-3 bg-light rounded">
                            <h5 class="mb-0">{{ $faq->question }}</h5>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">답변</label>
                        <div class="p-3 bg-light rounded">
                            <div class="content">{!! nl2br(e($faq->answer)) !!}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">생성일</label>
                                <div>
                                    {{ $faq->created_at ? \Carbon\Carbon::parse($faq->created_at)->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">수정일</label>
                                <div>
                                    {{ $faq->updated_at ? \Carbon\Carbon::parse($faq->updated_at)->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.cms.faq.faqs.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-arrow-left me-2"></i>목록으로
                        </a>
                        <div>
                            <a href="{{ route('admin.cms.faq.faqs.edit', $faq->id) }}" class="btn btn-primary me-2">
                                <i class="fe fe-edit-2 me-2"></i>수정
                            </a>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteFaq({{ $faq->id }})">
                                <i class="fe fe-trash-2 me-2"></i>삭제
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteFaq(id) {
    if (!confirm('이 FAQ를 삭제하시겠습니까?')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/cms/faq/faqs/${id}`;

    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';

    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '{{ csrf_token() }}';

    form.appendChild(methodInput);
    form.appendChild(tokenInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush
@endsection
