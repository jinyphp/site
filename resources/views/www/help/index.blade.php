@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

    @includeIf("jiny-site::www.help.partials.hero")
    @includeIf("jiny-site::www.help.partials.menu")


    <!-- container  -->
    <section class="py-8">
        <div class="container my-lg-8">
            <div class="row">
                <div class="offset-lg-2 col-lg-6 col-12">
                    <div class="mb-8 pe-lg-8">
                        <!-- heading  -->
                        <h2 class="mb-4 h1 fw-semibold">자주 묻는 질문</h2>
                        <p class="lead">시작하기 전에 확인해볼 수 있는 자주 묻는 질문들입니다</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-lg-2 col-lg-8 col-12">
                    <!-- accordions  -->
                    @if($helps && $helps->count() > 0)
                    <div class="accordion accordion-flush" id="helpAccordion">
                        @foreach($helps->take(6) as $index => $help)
                        <div class="border p-3 rounded-3 mb-2" id="heading{{ $index + 1 }}">
                            <h3 class="mb-0 fs-4">
                                <a href="#" class="d-flex align-items-center text-inherit" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index + 1 }}">
                                    <span class="me-auto">{{ $help->title }}</span>
                                    <span class="collapse-toggle ms-4">
                                        <i class="fe fe-chevron-down"></i>
                                    </span>
                                </a>
                            </h3>
                            <!-- collapse  -->
                            <div id="collapse{{ $index + 1 }}" class="collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index + 1 }}" data-bs-parent="#helpAccordion">
                                <div class="pt-2">
                                    {!! $help->content !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- container  -->
    <section class="py-8">
        <div class="container">
            <div class="row">
                <div class="offset-lg-2 col-lg-4 col-12">
                    <div class="mb-8">
                        <h2 class="mb-0 h1 fw-semibold">찾고 있는 내용이 없나요?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-lg-2 col-lg-8 col-12">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <!-- card  -->
                            <div class="card border mb-md-0 mb-4">
                                <!-- card body  -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle text-primary">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                        </svg>
                                    </div>
                                    <!-- para  -->
                                    <h3 class="mb-2 fw-semibold">문의하기</h3>
                                    <p>도움이 필요하십니까? 필요한 지원을 제공해드릴 수 있습니다. 문의해주시면 저희 팀이 빠르게 답변드리겠습니다.</p>
                                    <!-- btn  -->
                                    <a href="#" class="btn btn-primary btn-sm">문의하기</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <!-- card  -->
                            <div class="card border">
                                <!-- card body  -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#754ffe" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-life-buoy text-primary">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
                                            <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
                                            <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
                                            <line x1="14.83" y1="9.17" x2="18.36" y2="5.64"></line>
                                            <line x1="4.93" y1="19.07" x2="9.17" y2="14.83"></line>
                                        </svg>
                                    </div>
                                    <!-- para  -->
                                    <h3 class="mb-2 fw-semibold">고객지원</h3>
                                    <p>좋은 소식은 당신이 혼자가 아니며, 올바른 곳에 있다는 것입니다. 자세한 지원을 위해 문의하세요.</p>
                                    <!-- btn  -->
                                    <a href="{{ url('/help/support') }}" class="btn btn-outline-secondary btn-sm">티켓 제출</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
