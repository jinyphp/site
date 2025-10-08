@extends('jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    {{-- 페이지 헤더 --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1 h2 fw-bold">
                        {{ $config['title'] }}
                    </h1>
                    <p class="mb-0">
                        {{ $config['subtitle'] }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.site.faq.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> FAQ 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 통계 카드 --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                            <p class="text-muted mb-0">전체 FAQ</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-3">
                            <i class="bi bi-question-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['categories']) }}</h4>
                            <p class="text-muted mb-0">카테고리 수</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-info text-info rounded-3">
                            <i class="bi bi-folder fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
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

    {{-- 필터 및 검색 --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">FAQ 목록</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.site.faq.index') }}" method="GET" class="row g-3">
                        <div class="col-md-5">
                            <label for="search" class="form-label">검색</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="질문, 답변 검색...">
                        </div>

                        <div class="col-md-3">
                            <label for="category" class="form-label">카테고리</label>
                            <select class="form-select" id="category" name="category">
                                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>전체</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="sort_by" class="form-label">정렬</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="order" {{ request('sort_by') == 'order' ? 'selected' : '' }}>순서</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>등록일</option>
                                <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>조회수</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> 검색
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ 목록 테이블 --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60px">순서</th>
                                    <th width="120px">카테고리</th>
                                    <th>질문</th>
                                    <th width="100px">조회수</th>
                                    <th width="120px">등록일</th>
                                    <th width="100px">작업</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faqs as $faq)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $faq->order }}</span>
                                    </td>
                                    <td>
                                        @if($faq->category)
                                        <span class="badge bg-info">{{ $faq->category }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.site.faq.show', $faq->id) }}"
                                           class="text-decoration-none fw-bold">
                                            {{ Str::limit($faq->question, 60) }}
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            {{ Str::limit(strip_tags($faq->answer), 80) }}
                                        </small>
                                    </td>
                                    <td>
                                        <i class="bi bi-eye text-muted"></i>
                                        {{ number_format($faq->views) }}
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($faq->created_at)->format('Y-m-d') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.site.faq.edit', $faq->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('정말 삭제하시겠습니까?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        등록된 FAQ가 없습니다.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($faqs->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">
                                전체 {{ number_format($faqs->total()) }}건 중
                                {{ number_format($faqs->firstItem()) }} - {{ number_format($faqs->lastItem()) }}
                            </p>
                        </div>
                        <div>
                            {{ $faqs->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
