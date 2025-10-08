@extends('jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    {{-- 페이지 헤더 --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h2 fw-bold">
                        {{ $config['title'] }}
                    </h1>
                    <p class="mb-0">
                        {{ $config['subtitle'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- 통계 카드 --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                            <p class="text-muted mb-0">전체 문의</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-3">
                            <i class="bi bi-envelope fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['pending']) }}</h4>
                            <p class="text-muted mb-0">대기중</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-warning text-warning rounded-3">
                            <i class="bi bi-clock fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['processing']) }}</h4>
                            <p class="text-muted mb-0">처리중</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-info text-info rounded-3">
                            <i class="bi bi-gear fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['completed']) }}</h4>
                            <p class="text-muted mb-0">완료</p>
                        </div>
                        <div class="icon-shape icon-md bg-light-success text-success rounded-3">
                            <i class="bi bi-check-circle fs-4"></i>
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
                    <h4 class="mb-0">문의 목록</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.site.contact.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">검색</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="이름, 이메일, 제목, 내용 검색...">
                        </div>

                        <div class="col-md-3">
                            <label for="status" class="form-label">상태</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>전체</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>대기중</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>처리중</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>완료</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>거부</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="sort_by" class="form-label">정렬</label>
                            <select class="form-select" id="sort_by" name="sort_by">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>등록일</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>이름</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>상태</option>
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

    {{-- Contact 목록 테이블 --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60px">ID</th>
                                    <th>이름</th>
                                    <th>이메일</th>
                                    <th>제목</th>
                                    <th width="100px">상태</th>
                                    <th width="120px">등록일</th>
                                    <th width="100px">작업</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if($contact->phone)
                                        <br><small class="text-muted">{{ $contact->phone }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.site.contact.show', $contact->id) }}"
                                           class="text-decoration-none">
                                            {{ Str::limit($contact->subject, 40) }}
                                        </a>
                                        @if($contact->user_id)
                                        <span class="badge bg-info ms-1">회원</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($contact->status)
                                            @case('pending')
                                                <span class="badge bg-warning">대기중</span>
                                                @break
                                            @case('processing')
                                                <span class="badge bg-info">처리중</span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-success">완료</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">거부</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($contact->created_at)->format('Y-m-d H:i') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.site.contact.show', $contact->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.site.contact.edit', $contact->id) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        등록된 문의가 없습니다.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($contacts->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">
                                전체 {{ number_format($contacts->total()) }}건 중
                                {{ number_format($contacts->firstItem()) }} - {{ number_format($contacts->lastItem()) }}
                            </p>
                        </div>
                        <div>
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
