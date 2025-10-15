@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

@includeIf("jiny-site::www.help.partials.hero")
@includeIf("jiny-site::www.help.partials.menu")

<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="col-12">
                <div class="mb-6">
                    <h2 class="mb-4 h1 fw-semibold">내 지원 요청</h2>
                    <p class="lead">제출한 지원 요청의 진행 상황을 확인하실 수 있습니다.</p>
                </div>

                <!-- Status Filter -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex gap-2">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">모든 상태</option>
                                <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>대기중 ({{ $statusCounts['pending'] }})</option>
                                <option value="in_progress" {{ $currentStatus == 'in_progress' ? 'selected' : '' }}>처리중 ({{ $statusCounts['in_progress'] }})</option>
                                <option value="resolved" {{ $currentStatus == 'resolved' ? 'selected' : '' }}>해결완료 ({{ $statusCounts['resolved'] }})</option>
                                <option value="closed" {{ $currentStatus == 'closed' ? 'selected' : '' }}>종료 ({{ $statusCounts['closed'] }})</option>
                            </select>
                            <input type="text" name="search" class="form-control" placeholder="검색..." value="{{ $searchKeyword }}" />
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fe fe-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ url('/help/support') }}" class="btn btn-primary">
                            <i class="fe fe-plus me-2"></i>새 요청 작성
                        </a>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($supports->count() > 0)
                    @foreach($supports as $support)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex gap-2 mb-2">
                                        <span class="badge {{ $support->status_class }}">{{ $support->status_label }}</span>
                                        <span class="badge {{ $support->priority_class }}">{{ $support->priority_label }}</span>
                                        <span class="badge bg-light text-dark">{{ $support->type_label }}</span>
                                    </div>

                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('help.support.show', $support->id) }}" class="text-decoration-none">#{{ $support->id }} {{ $support->subject }}</a>
                                    </h5>

                                    <p class="card-text text-muted mb-2">{{ $support->excerpt }}</p>

                                    <div class="small text-muted">
                                        <span><i class="fe fe-calendar me-1"></i>{{ $support->created_at->format('Y-m-d H:i') }}</span>
                                        @if($support->resolved_at)
                                        <span class="ms-3"><i class="fe fe-check-circle me-1"></i>{{ $support->resolved_at->format('Y-m-d H:i') }} 해결</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 text-end">
                                    <div class="d-flex flex-column gap-2">
                                        @if($support->isEditable())
                                        <a href="{{ url('/help/support/' . $support->id . '/edit') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fe fe-edit-2 me-1"></i>수정
                                        </a>
                                        @endif

                                        @if($support->isDeletable())
                                        <form method="POST" action="{{ url('/help/support/' . $support->id . '/delete') }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('정말 삭제하시겠습니까?')">
                                                <i class="fe fe-trash-2 me-1"></i>삭제
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($support->admin_reply)
                            <hr>
                            <div class="mt-3">
                                <h6 class="text-success mb-2">
                                    <i class="fe fe-message-square me-1"></i>관리자 답변
                                </h6>
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($support->admin_reply)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $supports->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox text-muted">
                                <polyline points="22,12 16,12 14,15 10,15 8,12 2,12"></polyline>
                                <path d="M5.45 5.11l2-2 7.55 7.55a2 2 0 0 1 0 2.83l-7.55 7.55-2-2L12.9 12z"></path>
                            </svg>
                        </div>
                        <h4 class="text-muted">지원 요청이 없습니다</h4>
                        <p class="text-muted mb-4">아직 제출한 지원 요청이 없습니다.</p>
                        <a href="{{ url('/help/support') }}" class="btn btn-primary">
                            <i class="fe fe-plus me-2"></i>첫 지원 요청 작성하기
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
