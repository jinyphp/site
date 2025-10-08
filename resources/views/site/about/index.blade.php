@extends('jiny-site::layouts.app')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="py-8 bg-white">
        <div class="container my-lg-4">
            <div class="row">
                <div class="offset-lg-2 col-lg-8 col-md-12 col-12 mb-8">
                    <!-- caption-->
                    <h1 class="display-2 fw-bold mb-3">
                        안녕하세요, 저희는
                        <span class="text-primary">Jiny Recruit</span>
                        입니다
                    </h1>
                    <!-- para -->
                    <p class="h2 mb-3">
                        우리는 채용자와 구직자를 연결하는 차세대 인터랙티브 채용 플랫폼을 구축하고 있습니다.
                    </p>
                    <p class="mb-0 h4 text-body lh-lg">
                        Jiny Recruit는 깔끔하고 일관된 채용 프로세스를 제공하여 아름다운 채용 경험을 만들어줍니다.
                        기능이 풍부한 컴포넌트와 아름답게 디자인된 페이지로 최고의 채용 플랫폼을 제공합니다.
                    </p>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery mb-8">
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--1 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-1.jpg') }}" alt="팀워크" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--2 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-2.jpg') }}" alt="협업" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--3 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-3.jpg') }}" alt="혁신" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--4 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-4.jpg') }}" alt="성장" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--5 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-5.jpg') }}" alt="성과" class="gallery__img rounded-3">
                </figure>
                <!-- gallery-item -->
                <figure class="gallery__item gallery__item--6 mb-0">
                    <img src="{{ asset('assets/images/about/geeksui-img-6.jpg') }}" alt="미래" class="gallery__img rounded-3">
                </figure>
            </div>

            <!-- Statistics Section -->
            <div class="row">
                <!-- row -->
                <div class="col-md-6 offset-right-md-6">
                    <!-- heading -->
                    <h1 class="display-4 fw-bold mb-3">우리의 글로벌 영향력</h1>
                    <!-- para -->
                    <p class="lead">Jiny Recruit는 수백만 명의 구직자와 기업을 연결하여 성공적인 채용을 이끌어내는 선도적인 글로벌 채용 플랫폼입니다.</p>
                </div>

                <!-- Stat 1 -->
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="border-top pt-4 mt-6 mb-5">
                        <h1 class="display-3 fw-bold mb-0">10K+</h1>
                        <p class="text-uppercase">구직자</p>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="border-top pt-4 mt-6 mb-5">
                        <h1 class="display-3 fw-bold mb-0">500+</h1>
                        <p class="text-uppercase">파트너 기업</p>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="border-top pt-4 mt-6 mb-5">
                        <h1 class="display-3 fw-bold mb-0">1.2K+</h1>
                        <p class="text-uppercase">채용공고</p>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="border-top pt-4 mt-6 mb-5">
                        <h1 class="display-3 fw-bold mb-0">5K+</h1>
                        <p class="text-uppercase">성공적 매칭</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-8">
        <div class="container my-lg-8">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mb-6">
                    <!-- caption -->
                    <h2 class="display-4 mb-3 fw-bold">우리의 핵심 가치</h2>
                    <p class="lead">우리의 핵심 가치는 채용 생태계의 모든 참여자가 올바른 선택을 할 수 있도록 돕는 기본 신념입니다.</p>
                </div>
            </div>
            <div class="row">
                <!-- Value 1 -->
                <div class="col-md-4 col-12">
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-5">
                            <!-- icon -->
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-mortarboard text-primary" viewBox="0 0 16 16">
                                    <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                                    <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z" />
                                </svg>
                            </div>
                            <h3 class="mb-2">인재 발굴의 혁신</h3>
                            <p class="mb-0">AI와 데이터 분석을 통해 기업과 구직자의 완벽한 매칭을 실현하여 모든 이에게 최적의 기회를 제공합니다.</p>
                        </div>
                    </div>
                </div>

                <!-- Value 2 -->
                <div class="col-md-4 col-12">
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-5">
                            <!-- icon -->
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-people-fill text-primary" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                            </div>
                            <h3 class="mb-2">함께 성장하기</h3>
                            <p class="mb-0">구직자의 성장과 기업의 발전을 함께 도모하는 상생의 채용 생태계를 만들어갑니다.</p>
                        </div>
                    </div>
                </div>

                <!-- Value 3 -->
                <div class="col-md-4 col-12">
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-5">
                            <!-- icon -->
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-graph-up-arrow text-primary" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z" />
                                </svg>
                            </div>
                            <h3 class="mb-2">투명한 채용 프로세스</h3>
                            <p class="mb-0">공정하고 투명한 채용 프로세스로 모든 참여자가 신뢰할 수 있는 플랫폼을 제공합니다.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-8 bg-white">
        <div class="container my-lg-8">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12 mb-8">
                    <!-- heading -->
                    <h2 class="display-4 mb-3 fw-bold">우리 팀</h2>
                    <!-- lead -->
                    <p class="lead mb-5">
                        전 세계 최고의 인재들과 함께 일하며 모든 기업이 사랑하는 도구를 만들고 싶으신가요?
                        Jiny Recruit 팀에 합류하여 채용의 미래를 함께 만들어가세요.
                    </p>
                    <!-- btn -->
                    <a href="#" class="btn btn-primary">채용 공고 보기</a>
                </div>
            </div>

            <!-- Team Members Grid -->
            <div class="row">
                @php
                $teamMembers = [
                    ['name' => '김민수', 'position' => 'CEO', 'avatar' => 'avatar-1.jpg'],
                    ['name' => '이서연', 'position' => 'CTO', 'avatar' => 'avatar-2.jpg'],
                    ['name' => '박준호', 'position' => 'Head of Product', 'avatar' => 'avatar-3.jpg'],
                    ['name' => '최유진', 'position' => 'Head of Engineering', 'avatar' => 'avatar-4.jpg'],
                    ['name' => '정태현', 'position' => 'Head of Design', 'avatar' => 'avatar-5.jpg'],
                    ['name' => '한소영', 'position' => 'Head of Marketing', 'avatar' => 'avatar-6.jpg'],
                    ['name' => '조성민', 'position' => 'Senior Developer', 'avatar' => 'avatar-7.jpg'],
                    ['name' => '윤지혜', 'position' => 'UX Designer', 'avatar' => 'avatar-8.jpg'],
                    ['name' => '강동욱', 'position' => 'Data Scientist', 'avatar' => 'avatar-9.jpg'],
                    ['name' => '임채영', 'position' => 'HR Manager', 'avatar' => 'avatar-10.jpg'],
                    ['name' => '신준영', 'position' => 'Backend Developer', 'avatar' => 'avatar-11.jpg'],
                    ['name' => '오혜림', 'position' => 'Frontend Developer', 'avatar' => 'avatar-12.jpg']
                ];
                @endphp

                @foreach($teamMembers as $member)
                <div class="col-md-2 col-3">
                    <div class="p-xl-5 p-lg-3 mb-3 mb-lg-0">
                        <!-- avatar -->
                        <img src="{{ asset('assets/images/avatar/' . $member['avatar']) }}"
                             alt="{{ $member['name'] }}"
                             class="imgtooltip img-fluid rounded-circle"
                             data-bs-toggle="tooltip"
                             data-bs-placement="top"
                             title="{{ $member['name'] }} - {{ $member['position'] }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-primary">
        <div class="container">
            <!-- row -->
            <div class="row align-items-center g-0">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <!-- heading -->
                    <div class="pt-6 pt-lg-0">
                        <h1 class="text-white display-4 fw-bold pe-lg-8">
                            Jiny Recruit 팀에 합류하여 채용의 미래를 만들어가세요
                        </h1>
                        <!-- text -->
                        <p class="text-white-50 mb-4 lead">
                            열정이 있고 도전할 준비가 되어 있다면, 저희와 만나고 싶습니다.
                            우리는 직원들의 전문적 발전과 복지를 지원하는 데 전념하고 있습니다.
                        </p>
                        <!-- btn -->
                        <a href="#" class="btn btn-dark">채용 기회 보기</a>
                    </div>
                </div>
                <!-- img -->
                <div class="col-xl-6 col-lg-6 col-md-12 text-lg-end text-center pt-6">
                    <img src="{{ asset('assets/images/hero/hero-img.png') }}" alt="heroimg" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Gallery Grid CSS */
.gallery {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    grid-template-rows: repeat(8, 5vw);
    grid-gap: 15px;
}

.gallery__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gallery__item--1 {
    grid-column-start: 1;
    grid-column-end: 3;
    grid-row-start: 1;
    grid-row-end: 3;
}

.gallery__item--2 {
    grid-column-start: 3;
    grid-column-end: 5;
    grid-row-start: 1;
    grid-row-end: 3;
}

.gallery__item--3 {
    grid-column-start: 5;
    grid-column-end: 9;
    grid-row-start: 1;
    grid-row-end: 6;
}

.gallery__item--4 {
    grid-column-start: 1;
    grid-column-end: 5;
    grid-row-start: 3;
    grid-row-end: 6;
}

.gallery__item--5 {
    grid-column-start: 1;
    grid-column-end: 5;
    grid-row-start: 6;
    grid-row-end: 9;
}

.gallery__item--6 {
    grid-column-start: 5;
    grid-column-end: 9;
    grid-row-start: 6;
    grid-row-end: 9;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .gallery {
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(12, 8vw);
    }

    .gallery__item--1 {
        grid-column: 1 / 3;
        grid-row: 1 / 3;
    }

    .gallery__item--2 {
        grid-column: 3 / 5;
        grid-row: 1 / 3;
    }

    .gallery__item--3 {
        grid-column: 1 / 5;
        grid-row: 3 / 6;
    }

    .gallery__item--4 {
        grid-column: 1 / 3;
        grid-row: 6 / 8;
    }

    .gallery__item--5 {
        grid-column: 3 / 5;
        grid-row: 6 / 8;
    }

    .gallery__item--6 {
        grid-column: 1 / 5;
        grid-row: 8 / 11;
    }
}
</style>

<!-- Initialize tooltips -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection