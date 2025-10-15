@extends('jiny-site::layouts.admin.sidebar')

@section('title', '네비게이션 관리')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">네비게이션 관리</h5>
                    <a href="{{ route('admin.cms.templates.nav.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> 새 네비게이션 추가
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(count($navs) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>네비게이션 키</th>
                                        <th>이름</th>
                                        <th>설명</th>
                                        <th>타입</th>
                                        <th>드롭다운</th>
                                        <th>모바일 반응형</th>
                                        <th class="text-center">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($navs as $nav)
                                        <tr>
                                            <td>{{ $nav['id'] }}</td>
                                            <td><code>{{ $nav['nav_key'] }}</code></td>
                                            <td>{{ $nav['name'] }}</td>
                                            <td>{{ Str::limit($nav['description'] ?? '', 50) }}</td>
                                            <td>
                                                @if($nav['type'] === 'horizontal')
                                                    <span class="badge bg-primary">수평</span>
                                                @elseif($nav['type'] === 'vertical')
                                                    <span class="badge bg-secondary">수직</span>
                                                @else
                                                    <span class="badge bg-info">{{ $nav['type'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($nav['dropdown'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($nav['mobile_responsive'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.cms.templates.nav.show', $nav['id']) }}"
                                                       class="btn btn-outline-info" title="상세보기">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.nav.edit', $nav['id']) }}"
                                                       class="btn btn-outline-primary" title="수정">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.cms.templates.nav.destroy', $nav['id']) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('정말로 이 네비게이션을 삭제하시겠습니까?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="삭제">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            등록된 네비게이션이 없습니다. <a href="{{ route('admin.cms.templates.nav.create') }}">새 네비게이션을 추가</a>해보세요.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    font-weight: 600;
    border-top: none;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.card-title {
    color: #495057;
}

.badge {
    font-size: 0.75em;
}

code {
    font-size: 0.875em;
    color: #e83e8c;
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}
</style>
@endpush
