<div class="row">
    <!-- -->
    <div class="col-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            <a href="/admin/site/info">
                            사이트정보
                            </a>
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트의 기본적인 정보를 관리합니다.
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

                <a href="/admin/site/header">
                    <x-badge-secondary>상단정보</x-badge-secondary>
                </a>

                <a href="/admin/site/footer">
                    <x-badge-secondary>하단정보</x-badge-secondary>
                </a>

            </div>
        </div>
    </div>

    <!-- 사이트관리자 -->
    <div class="col-3 mb-4">
        <div class="card h-100">
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
                <a href="#">
                    <x-badge-secondary>관리자</x-badge-secondary>
                </a>

                <a href="#">
                    <x-badge-secondary>역할</x-badge-secondary>
                </a>

                <a href="#">
                    <x-badge-secondary>작업기록</x-badge-secondary>
                </a>

            </div>
        </div>
    </div>

    <!-- -->
    <div class="col-3 mb-4">
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
                <a href="/admin/site/routes">
                    <x-badge-secondary>라우트</x-badge-secondary>
                </a>

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
