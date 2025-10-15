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
                                <i class="fe fe-mail me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.contact.contacts.export') }}" class="btn btn-outline-success">
                                <i class="fe fe-download me-2"></i>내보내기
                            </a>
                            <a href="{{ route('admin.cms.contact.contacts.statistics') }}" class="btn btn-outline-info">
                                <i class="fe fe-bar-chart me-2"></i>통계
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 문의</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-mail"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">대기 중</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['pending']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">답변 완료</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['replied']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">미읽음</h4>
                            <h2 class="text-danger mb-0">{{ number_format($stats['unread']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-danger text-white rounded-circle">
                            <i class="fe fe-eye-off"></i>
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
                        <div class="col-md-3">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="이름, 이메일, 제목, 내용" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">타입</label>
                            <select name="type" class="form-select">
                                <option value="all">전체</option>
                                @foreach($types as $type)
                                <option value="{{ $type->code }}" {{ request('type') == $type->code ? 'selected' : '' }}>
                                    {{ $type->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">상태</label>
                            <select name="status" class="form-select">
                                <option value="all">전체</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>대기</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>답변완료</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>종료</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>이름</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>상태</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">순서</label>
                            <select name="order" class="form-select">
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>내림차순</option>
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>오름차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.contact.contacts.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">문의 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            선택 삭제
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="bulkAction('read')">
                            읽음 처리
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($contacts->count() > 0)
                        <form id="bulkForm" method="POST" action="{{ route('admin.cms.contact.contacts.bulkAction') }}">
                            @csrf
                            <input type="hidden" name="action" id="bulkAction">
                            <input type="hidden" name="ids" id="bulkIds">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                            <th>이름</th>
                                            <th>이메일</th>
                                            <th>제목</th>
                                            <th>타입</th>
                                            <th>상태</th>
                                            <th>생성일</th>
                                            <th width="100">관리</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contacts as $contact)
                                        <tr class="{{ $contact->read_at ? '' : 'table-warning' }}">
                                            <td>
                                                <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" class="form-check-input contact-checkbox">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(!$contact->read_at)
                                                        <span class="badge bg-danger me-2">new</span>
                                                    @endif
                                                    {{ $contact->name }}
                                                </div>
                                            </td>
                                            <td>{{ $contact->email }}</td>
                                            <td>
                                                <a href="{{ route('admin.cms.contact.contacts.show', $contact->id) }}" class="text-decoration-none">
                                                    {{ Str::limit($contact->subject, 30) }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($contact->type_title)
                                                    <span class="badge bg-info">{{ $contact->type_title }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge
                                                    @if($contact->status === 'pending') bg-warning
                                                    @elseif($contact->status === 'replied') bg-success
                                                    @else bg-secondary @endif">
                                                    @if($contact->status === 'pending') 대기
                                                    @elseif($contact->status === 'replied') 답변완료
                                                    @else 종료 @endif
                                                </span>
                                            </td>
                                            <td>{{ $contact->created_at ? \Carbon\Carbon::parse($contact->created_at)->format('Y-m-d H:i') : '' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.cms.contact.contacts.show', $contact->id) }}"
                                                       class="btn btn-outline-primary btn-sm">보기</a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="deleteContact({{ $contact->id }})">삭제</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- 페이지네이션 -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $contacts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-mail fs-1 text-muted"></i>
                            <h4 class="mt-3 text-muted">문의가 없습니다</h4>
                            <p class="text-muted">등록된 문의가 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 대량 작업
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');

    if (checkedBoxes.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (!confirm(`선택된 ${checkedBoxes.length}개 항목을 ${action === 'delete' ? '삭제' : '읽음 처리'}하시겠습니까?`)) {
        return;
    }

    const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);
    document.getElementById('bulkAction').value = action;
    document.getElementById('bulkIds').value = ids.join(',');
    document.getElementById('bulkForm').submit();
}

// 개별 삭제
function deleteContact(id) {
    if (!confirm('이 문의를 삭제하시겠습니까?')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/cms/contact/contacts/${id}`;

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
