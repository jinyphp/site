@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

    {{-- hero --}}
    @includeIf("jiny-site::www.help.partials.hero_faq")

    <!-- Breadcrumb at top -->
    <div class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/help') }}" class="text-decoration-none">Help Center</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Faq</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- faq 카테고리 필터 --}}
    <div class="py-3">
        <div class="container">
            @if($categories && $categories->count() > 0)
            <div class="row mb-6">
                <div class="offset-md-2 col-md-8 col-12">
                    <div class="mb-4">
                        <h3 class="mb-3">카테고리별 보기</h3>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ url('/help/faq') }}" class="btn btn-sm {{ !$selectedCategory ? 'btn-primary' : 'btn-outline-primary' }}">전체</a>
                            @foreach($categories as $category)
                            <a href="{{ url('/help/faq?category=' . $category->code) }}" class="btn btn-sm {{ $selectedCategory && $selectedCategory->code === $category->code ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $category->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>


    {{-- faq 내용 --}}
    <section class="py-8">
        <div class="container">
            @if($faqs && $faqs->count() > 0)
            <div class="row mb-6">
                <div class="offset-md-2 col-md-8 col-12">
                    <div class="d-flex flex-column gap-4">
                        <div class="">
                            <h2 class="mb-0 fw-semibold">
                                @if($selectedCategory)
                                    {{ $selectedCategory->title }} - 자주 묻는 질문
                                @else
                                    자주 묻는 질문
                                @endif
                            </h2>
                            <p class="text-muted">{{ $faqs->total() }}개의 질문이 있습니다.</p>
                        </div>
                        <div class="accordion accordion-flush" id="faqAccordion">
                            @foreach($faqs as $index => $faq)
                            <div class="border p-3 rounded-3 mb-2" id="faqHeading{{ $faq->id }}">
                                <h3 class="mb-0 fs-4">
                                    <a href="#" class="d-flex align-items-center text-inherit" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}" aria-expanded="false" aria-controls="faqCollapse{{ $faq->id }}">
                                        <span class="me-auto">{{ $faq->question }}</span>
                                        <span class="collapse-toggle ms-4">
                                            <i class="fe fe-chevron-down"></i>
                                        </span>
                                    </a>
                                </h3>
                                <div id="faqCollapse{{ $faq->id }}" class="collapse" aria-labelledby="faqHeading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                    <div class="pt-2">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 페이지네이션 -->
            <div class="row">
                <div class="offset-md-2 col-md-8 col-12">
                    {{ $faqs->links() }}
                </div>
            </div>
            @else
            <div class="row">
                <div class="offset-md-2 col-md-8 col-12">
                    <div class="text-center py-8">
                        <h3>FAQ가 없습니다</h3>
                        <p class="text-muted">아직 등록된 FAQ가 없습니다.</p>
                        <a href="{{ url('/help') }}" class="btn btn-primary">도움말 센터로 돌아가기</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>


    {{-- 인기 FAQ --}}
    <section class="py-8">
        <div class="container">
            @if(isset($popularFaqs) && $popularFaqs->count() > 0)
            <div class="row mt-8">
                <div class="offset-md-2 col-md-8 col-12">
                    <div class="border-top pt-6">
                        <h3 class="mb-4">인기 FAQ</h3>
                        <div class="list-group">
                            @foreach($popularFaqs as $faq)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" data-bs-toggle="collapse" data-bs-target="#popularFaq{{ $faq->id }}">
                                <div class="ms-2 me-auto">
                                    <div class="fw-semibold">{{ $faq->question }}</div>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $faq->views ?? 0 }}</span>
                            </a>
                            <div class="collapse" id="popularFaq{{ $faq->id }}">
                                <div class="card card-body">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection
