@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

@includeIf("jiny-site::www.help.partials.hero")
@includeIf("jiny-site::www.help.partials.menu")

<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="offset-lg-3 col-lg-6 col-12">
                <div class="text-center">
                    <div class="mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                    </div>

                    <h2 class="mb-4 h1 fw-semibold">지원 요청이 접수되었습니다!</h2>

                    <p class="lead text-muted mb-6">
                        {{ $message ?? '지원 요청이 성공적으로 제출되었습니다.' }}
                    </p>

                    @if($supportId)
                    <div class="alert alert-info mb-6">
                        <strong>요청 ID: #{{ $supportId }}</strong><br>
                        이 번호로 진행 상황을 확인하실 수 있습니다.
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">다음 단계</h5>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2">
                                    <i class="fe fe-check-circle text-success me-2"></i>
                                    담당자가 요청을 검토하여 처리 과정을 시작합니다
                                </li>
                                <li class="mb-2">
                                    <i class="fe fe-clock text-warning me-2"></i>
                                    우선순위에 따라 24-48시간 내에 첫 응답을 드립니다
                                </li>
                                <li class="mb-2">
                                    <i class="fe fe-mail text-info me-2"></i>
                                    진행 상황은 등록된 이메일로 알려드립니다
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ url('/help') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>도움말 센터
                            </a>

                            @auth
                            <a href="{{ url('/help/support/my') }}" class="btn btn-primary">
                                <i class="fe fe-list me-2"></i>내 요청 확인
                            </a>
                            @endauth

                            <a href="{{ url('/help/support') }}" class="btn btn-outline-primary">
                                <i class="fe fe-plus me-2"></i>새 요청
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
