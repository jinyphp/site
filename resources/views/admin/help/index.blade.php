@extends('jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <div class="row">
        <div class="col-12">
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1 h2 fw-bold">{{ $config['title'] }}</h1>
                    <p class="mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <a href="{{ route('admin.site.help.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Help 추가
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-lg-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                            <p class="text-muted mb-0">전체 Help</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-3">
                            <i class="bi bi-life-preserver fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['categories']) }}</h4>
                            <p class="text-muted mb-0">카테고리</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-info text-info rounded-3">
                            <i class="bi bi-folder fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_views']) }}</h4>
                            <p class="text-muted mb-0">총 조회수</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-success text-success rounded-3">
                            <i class="bi bi-eye fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header"><h4 class="mb-0">Help 목록</h4></div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="제목, 내용 검색...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="category">
                                <option value="all">전체</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="sort_by">
                                <option value="order">순서</option>
                                <option value="created_at">등록일</option>
                                <option value="views">조회수</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> 검색</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60px">순서</th>
                                <th width="120px">카테고리</th>
                                <th>제목</th>
                                <th width="100px">조회수</th>
                                <th width="100px">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($helps as $help)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $help->order }}</span></td>
                                <td>
                                    @if($help->category)
                                    <span class="badge bg-info">{{ $help->category }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $help->title }}</strong>
                                    <br><small class="text-muted">{{ Str::limit(strip_tags($help->content), 80) }}</small>
                                </td>
                                <td>{{ number_format($help->views) }}</td>
                                <td>
                                    <a href="{{ route('admin.site.help.edit', $help->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    등록된 Help가 없습니다.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($helps->hasPages())
                <div class="card-footer">
                    {{ $helps->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
