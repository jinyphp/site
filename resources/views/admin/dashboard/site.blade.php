<div class="row">
    <!-- -->
    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            메뉴 및 사이트구조
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트의 메뉴구조를 관리합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">

                <a href="/admin/site/menu">
                    <x-badge-secondary>메뉴</x-badge-secondary>
                </a>

                <a href="/admin/site/sitemap">
                    <x-badge-secondary>sitemap</x-badge-secondary>
                </a>

                <a href="/admin/site/routes">
                    <x-badge-secondary>라우트</x-badge-secondary>
                </a>



            </div>
        </div>
    </div>

    <!-- -->
    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            디자인 및 레이아웃
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트 디자인 및 레이아웃을 관리합니다.
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

                <a href="/admin/site/layout">
                    <x-badge-secondary>레이아웃</x-badge-secondary>
                </a>

                <a href="/admin/site/partials">
                    <x-badge-secondary>partials</x-badge-secondary>
                </a>

            </div>
        </div>
    </div>



    <!-- -->
    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            템플릿 및 위젯
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트를 구성할 수 있는 다양한 템플릿 목록 입니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">
                <a href="/admin/site/template">
                    <x-badge-secondary>템플릿</x-badge-secondary>
                </a>

                <a href="/admin/site/widget">
                    <x-badge-secondary>위젯</x-badge-secondary>
                </a>

            </div>
        </div>
    </div>


    <!-- -->
    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            리소스

                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트 정적 리소스 및 설정을 관리합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">


                <a href="/admin/site/resources">
                    <x-badge-secondary>리소스</x-badge-secondary>
                </a>

                <a href="/admin/site/actions">
                    <x-badge-secondary>Actions</x-badge-secondary>
                </a>

                <a href="/admin/site/images">
                    <x-badge-secondary>images</x-badge-secondary>
                </a>

            </div>
        </div>
    </div>





</div>
