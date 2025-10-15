@extends('jiny-site::layouts.admin.sidebar')

@section('title', '사이드바 관리')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">사이드바 관리</h5>
                    <a href="{{ route('admin.cms.templates.sidebar.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> 새 사이드바 추가
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(count($sidebars) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>사이드바 키</th>
                                        <th>이름</th>
                                        <th>설명</th>
                                        <th>위치</th>
                                        <th>접을 수 있음</th>
                                        <th>고정</th>
                                        <th class="text-center">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sidebars as $sidebar)
                                        <tr>
                                            <td>{{ $sidebar['id'] }}</td>
                                            <td><code>{{ $sidebar['sidebar_key'] }}</code></td>
                                            <td>{{ $sidebar['name'] }}</td>
                                            <td>{{ Str::limit($sidebar['description'] ?? '', 50) }}</td>
                                            <td>
                                                @if($sidebar['position'] === 'left')
                                                    <span class="badge bg-primary">왼쪽</span>
                                                @else
                                                    <span class="badge bg-info">오른쪽</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sidebar['collapsible'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sidebar['fixed'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.cms.templates.sidebar.show', $sidebar['id']) }}"
                                                       class="btn btn-outline-info" title="상세보기">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.sidebar.edit', $sidebar['id']) }}"
                                                       class="btn btn-outline-primary" title="수정">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.cms.templates.sidebar.destroy', $sidebar['id']) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('정말로 이 사이드바를 삭제하시겠습니까?')">
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
                            등록된 사이드바가 없습니다. <a href="{{ route('admin.cms.templates.sidebar.create') }}">새 사이드바를 추가</a>해보세요.
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
