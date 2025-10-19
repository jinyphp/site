<div class="container border-bottom mt-2 pb-2">
    <div class="row">
        <div class="col">
            <div class="d-flex align-items-center gap-4">
                <div class="d-flex gap-2 align-items-center lh-0 d-none d-md-block">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                            class="bi bi-clock-history" viewBox="0 0 16 16">
                            <path
                                d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                            <path
                                d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </span>
                    <span class="fs-6 fw-medium">Time: {{ Site::businessHours() }}</span>
                </div>
                <div class="d-flex gap-2 align-items-center lh-0">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                            class="bi bi-telephone-forward" viewBox="0 0 16 16">
                            <path
                                d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708" />
                        </svg>
                    </span>
                    <span class="fs-6 fw-medium">{{ Site::phone() }}</span>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex align-items-center gap-4">
                {{-- 회원가입 --}}
                <x-register-text>회원가입</x-register-text>

                {{-- 로그인 --}}
                <x-login-text>로그인</x-login-text>

            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg bg-white">
    <div class="container px-0">
        <a class="navbar-brand" href="/">
            <img src="{{ asset(Site::logo()) }}" alt="{{ Site::brand() }}" />
        </a>

        <!-- Mobile view nav wrap -->
        <div class="ms-auto d-flex align-items-center order-lg-3">
            <a href="#" class="btn btn-primary">Enquire now</a>
        </div>

        <div>
            <!-- Button -->
            <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
        </div>

        {{-- 상단 메뉴 --}}
        @include('jiny-site::partials.navs.nav-classic.top')
    </div>
</nav>

<!-- Modal -->
{{-- <div class="modal fade" id="langaugeModal" tabindex="-1" aria-labelledby="langaugeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="modal-title" id="langaugeModalLabel">Choose a language</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                    <a class="text-inherit fw-semibold active" href="#!">English</a>
                    <a class="text-inherit fw-semibold" href="#!">Deutsch</a>
                    <a class="text-inherit fw-semibold" href="#!">Español</a>
                    <a class="text-inherit fw-semibold" href="#!">Français</a>
                    <a class="text-inherit fw-semibold" href="#!">Indonesia</a>
                    <a class="text-inherit fw-semibold" href="#!">Italiano</a>
                    <a class="text-inherit fw-semibold" href="#!">日本語</a>
                    <a class="text-inherit fw-semibold" href="#!">한국어</a>
                    <a class="text-inherit fw-semibold" href="#!">Nederlands</a>
                    <a class="text-inherit fw-semibold" href="#!">Polski</a>
                    <a class="text-inherit fw-semibold" href="#!">Português</a>
                    <a class="text-inherit fw-semibold" href="#!">Română</a>
                    <a class="text-inherit fw-semibold" href="#!">Русский</a>
                    <a class="text-inherit fw-semibold" href="#!">ภาษาไทย</a>
                    <a class="text-inherit fw-semibold" href="#!">Türkçe</a>
                    <a class="text-inherit fw-semibold" href="#!">Tiếng Việt</a>
                    <a class="text-inherit fw-semibold" href="#!">中文(简体)</a>
                    <a class="text-inherit fw-semibold" href="#!">中文(繁體)</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
