@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<div class="py-8 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- breadcrumb  -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/help') }}">도움말 센터</a></li>
                        @if($category)
                        <li class="breadcrumb-item"><a href="{{ url('/help/category/' . $category->code) }}">{{ $category->title }}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $help->title }}</li>
                    </ol>
                </nav>
                <!-- caption-->
                <h1 class="fw-bold mb-3 display-5">{{ $help->title }}</h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    @if($category)
                    <span class="badge bg-primary">{{ $category->title }}</span>
                    @endif
                    <small class="text-muted">
                        <i class="fe fe-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($help->created_at)->format('Y.m.d') }}
                    </small>
                    @if($help->manager)
                    <small class="text-muted">
                        <i class="fe fe-user me-1"></i>
                        {{ $help->manager }}
                    </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <!-- 도움말 내용 -->
                <div class="card">
                    <div class="card-body">
                        @if($help->image)
                        <div class="mb-4">
                            <img src="{{ asset($help->image) }}" alt="{{ $help->title }}" class="img-fluid rounded">
                        </div>
                        @endif

                        <div class="content">
                            {!! $help->content !!}
                        </div>

                        <!-- 좋아요 버튼 -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5>이 도움말이 유용했나요?</h5>
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm me-2" onclick="likeHelp({{ $help->id }})">
                                        <i class="fe fe-thumbs-up me-1"></i>
                                        유용해요 ({{ $help->like }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 관련 도움말 -->
                @if($relatedHelps && $relatedHelps->count() > 0)
                <div class="mt-6">
                    <h3 class="mb-4">관련 도움말</h3>
                    <div class="row">
                        @foreach($relatedHelps as $related)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ url('/help/' . $related->id) }}" class="text-inherit">{{ $related->title }}</a>
                                    </h5>
                                    <p class="card-text text-muted">
                                        {{ Str::limit(strip_tags($related->content), 100) }}
                                    </p>
                                    <a href="{{ url('/help/' . $related->id) }}" class="btn btn-outline-primary btn-sm">
                                        자세히 보기
                                        <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- 사이드바 -->
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">도움이 더 필요하신가요?</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ url('/help/faq') }}" class="btn btn-outline-primary">
                                <i class="fe fe-help-circle me-2"></i>
                                자주 묻는 질문
                            </a>
                            <a href="{{ url('/help/search') }}" class="btn btn-outline-primary">
                                <i class="fe fe-search me-2"></i>
                                도움말 검색
                            </a>
                            <a href="{{ url('/help/support') }}" class="btn btn-primary">
                                <i class="fe fe-life-buoy me-2"></i>
                                고객지원 문의
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 최근 도움말 -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">최근 도움말</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <!-- 여기에 최근 도움말 목록이 들어갈 수 있음 -->
                            <a href="{{ url('/help') }}" class="list-group-item list-group-item-action border-0 px-0">
                                도움말 센터 홈
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function likeHelp(helpId) {
    // 좋아요 기능 구현
    fetch(`/help/${helpId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 좋아요 수 업데이트
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection
