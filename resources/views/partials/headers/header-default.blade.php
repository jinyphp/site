{{-- navbar --}}
<nav class="navbar navbar-expand-lg">
    <div class="container px-0">

        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset(Site::logo()) }}" alt="{{ Site::brand() }}" />
        </a>

        <!-- Mobile view nav wrap -->
        <div class="ms-auto d-flex align-items-center order-lg-3">
            <div class="d-flex gap-2 align-items-center">
                @if(\Jiny\Site\Facades\Header::getSearch() === 'enabled' || \Jiny\Site\Facades\Header::getSearch() === 'true' || \Jiny\Site\Facades\Header::getSearch() === '1')
                    <!-- Search Icon -->
                    <a href="#" class="text-inherit me-2" title="검색">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-search text-gray-500" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </a>
                @endif

                <a href="#langaugeModal" class="text-inherit me-2" data-bs-toggle="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-globe text-gray-500" viewBox="0 0 16 16">
                        <path
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                    </svg>
                </a>

                <!-- Cart Icon -->
                <a href="/cart" class="text-inherit me-2 position-relative" id="cartIcon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-cart text-gray-500" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <span
                        class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                        style="font-size: 0.7rem; display: none;">
                        0
                    </span>
                </a>
                <a href="/login" class="btn btn-outline-dark">로그인</a>
                <a href="/register" class="btn btn-dark d-none d-md-block">회원가입</a>
            </div>
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

        <!-- Collapse -->
        @includeIf('jiny-site::partials.navs.nav-default.top', [
            'menuItems' => Site::menuItems('default'),
            'alignment' => 'center'
        ])


    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="langaugeModal" tabindex="-1" aria-labelledby="langaugeModalLabel" aria-hidden="true">
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
</div>
