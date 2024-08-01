@setTheme("admin.sidebar")
<x-theme theme="admin.sidebar">
    <x-theme-layout>
        <x-flex-between>
            <div class="page-title-box">
                <x-flex class="align-items-center gap-2">
                    <h1 class="align-middle h3 d-inline">
                        @if (isset($actions['title']))
                        {{$actions['title']}}
                        @endif
                    </h1>
                    {{-- <x-badge-info>Admin</x-badge-info> --}}
                </x-flex>
                <p>
                    @if (isset($actions['subtitle']))
                        {{$actions['subtitle']}}
                    @endif
                </p>
            </div>

            <div class="page-title-box">
                <x-breadcrumb-item>
                    {{$actions['route']['uri']}}
                </x-breadcrumb-item>

                <div class="mt-2 d-flex justify-content-end gap-2">
                    <x-btn-video>
                        Video
                    </x-btn-video>

                    <x-btn-manual>
                        Manual
                    </x-btn-manual>
                </div>
            </div>

        </x-flex-between>

        <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Sales</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">2.382</h1>
                                    <div class="mb-0">
                                        <span class="badge badge-primary-light">-3.65%</span>
                                        <span class="text-muted">Since last week</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">방문자</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">14.212</h1>
                                    <div class="mb-0">
                                        <span class="badge badge-success-light">5.25%</span>
                                        <span class="text-muted">Since last week</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">회원</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">0</h1>
                                    <div class="mb-0">
                                        <span class="badge badge-success-light">6.65%</span>
                                        <span class="text-muted">Since last week</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">
                                                <a href="/admin/site/subscribe">구독관리</a>
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">
                                        {{table_count("site_subscribe")}}명
                                    </h1>
                                    <div class="mb-0">
                                        <span class="badge badge-danger-light">-2.25%</span>
                                        <span class="text-muted">Since last week</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="float-end">
                            <form class="row g-2">
                                <div class="col-auto">
                                    <select class="form-select form-select-sm bg-light border-0">
                                        <option>Jan</option>
                                        <option value="1">Feb</option>
                                        <option value="2">Mar</option>
                                        <option value="3">Apr</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm bg-light rounded-2 border-0" style="width: 100px;" placeholder="Search..">
                                </div>
                            </form>
                        </div>
                        <h5 class="card-title mb-0">Recent Movement</h5>
                    </div>
                    <div class="card-body pt-2 pb-3">
                        <div class="chart chart-sm"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="chartjs-dashboard-line" width="737" height="250" style="display: block; width: 737px; height: 250px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content-->
        <div class="row">
            <div class="col-4">
                <div class="card h-100">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    CMS
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    컨덴츠를 관리합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/site/sliders">
                            <x-badge-secondary>슬라이더</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-4">
                <div class="card h-100">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    글 관리
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    다양한 형식의 계시물을 관리할 수 있습니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <x-badge-secondary>
                            <a href="/admin/site/posts">포스트</a>
                        </x-badge-secondary>

                        <x-badge-secondary>
                            <a href="/admin/module/site/board">계시판</a>
                        </x-badge-secondary>


                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-4">
                <div class="card h-100">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">


                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    뉴스등의 정보를 구독 관리합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">



                    </div>
                </div>
            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/site/slot">
                                    슬롯
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    슬롯을 통하여 복수의 사이트 디자인을 관리할 수 있습니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/site/slot">
                            <x-badge-secondary>slot</x-badge-secondary>
                        </a>

                        <a href="/admin/site/userslot">
                            <x-badge-secondary>userslot</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div>



            <!-- -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/site">
                                    레아아웃
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    첫화면 | 로그인후 화면 | 레이아웃 | 블로그 | post | 페이지
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">


                        <a href="/admin/site/header">
                            <x-badge-secondary>상단설정</x-badge-secondary>
                        </a>

                        <a href="/admin/site/footer">
                            <x-badge-secondary>하단설정</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/site/routes">라우팅</a>

                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    ...
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/site/resources">리소스</a>
                    </div>
                </div>
            </div>

        </div>


        <hr>
        {{-- --}}
        <div class="row">

            <!-- 설정 -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/site">
                                    설정
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    사이트의 정보를 설정합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/site/info">
                            <x-badge-secondary>정보설정</x-badge-secondary>
                        </a>

                        <a href="/admin/site/setting">
                            <x-badge-secondary>환경설정</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div>

            <!-- 사이트관리자 -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/site/manager">사이트 관리자</a>

                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    사이트를 관리할 수 있는 직원을 지정합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>



    </x-theme-layout>
</x-theme>

