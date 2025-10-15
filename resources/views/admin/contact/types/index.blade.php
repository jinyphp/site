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
                                <i class="fe fe-folder me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.contact.types.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 타입 추가
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 타입</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-folder"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">활성화</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['enabled']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">비활성화</h4>
                            <h2 class="text-secondary mb-0">{{ number_format($stats['disabled']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-secondary text-white rounded-circle">
                            <i class="fe fe-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="타입명, 코드" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">활성화</label>
                            <select name="enable" class="form-select">
                                <option value="all">전체</option>
                                <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>활성화</option>
                                <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>비활성화</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.contact.types.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 타입 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Contact 타입 목록</h4>
                </div>
                <div class="card-body">
                    @if($types->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">순서</th>
                                        <th>코드</th>
                                        <th>타입명</th>
                                        <th>설명</th>
                                        <th width="100">활성화</th>
                                        <th width="150">관리</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach($types as $type)
                                    <tr data-id="{{ $type->id }}">
                                        <td>
                                            <span class="badge bg-secondary">{{ $type->pos }}</span>
                                            <i class="fe fe-move ms-2 text-muted" style="cursor: move;"></i>
                                        </td>
                                        <td>
                                            <code>{{ $type->code }}</code>
                                        </td>
                                        <td>
                                            <strong>{{ $type->title }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($type->description ?? '', 50) }}</span>
                                        </td>
                                        <td>
                                            @if($type->enable)
                                                <span class="badge bg-success">활성화</span>
                                            @else
                                                <span class="badge bg-secondary">비활성화</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.cms.contact.types.edit', $type->id) }}"
                                                   class="btn btn-outline-primary btn-sm">수정</a>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteType({{ $type->id }})">삭제</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- 페이지네이션 -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $types->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-folder fs-1 text-muted"></i>
                            <h4 class="mt-3 text-muted">타입이 없습니다</h4>
                            <p class="text-muted">등록된 Contact 타입이 없습니다.</p>
                            <a href="{{ route('admin.cms.contact.types.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>첫 번째 타입 추가
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// 정렬 기능
const sortable = Sortable.create(document.getElementById('sortable'), {
    handle: '.fe-move',
    animation: 150,
    onEnd: function(evt) {
        const items = Array.from(evt.to.children).map(row => row.dataset.id);

        fetch('{{ route("admin.cms.contact.types.updateOrder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 순서 번호 업데이트
                evt.to.querySelectorAll('tr').forEach((row, index) => {
                    const badge = row.querySelector('.badge');
                    if (badge) {
                        badge.textContent = index + 1;
                    }
                });
            }
        });
    }
});

// 개별 삭제
function deleteType(id) {
    if (!confirm('이 타입을 삭제하시겠습니까?')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/cms/contact/types/${id}`;

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
