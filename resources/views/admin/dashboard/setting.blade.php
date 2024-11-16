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
                <a href="/admin/site/manager">
                    <x-badge-secondary>관리자</x-badge-secondary>
                </a>

                <a href="/admin/site/roles">
                    <x-badge-secondary>역할</x-badge-secondary>
                </a>

                {{--
                <a href="#">
                    <x-badge-secondary>작업기록</x-badge-secondary>
                </a>
                --}}

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
                            로케일 설정

                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트 운영에 필요한 국가 및 지역정보를 관리합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">
                <a href="/admin/site/language">
                    <x-badge-secondary>언어</x-badge-secondary>
                </a>

                <a href="/admin/site/country">
                    <x-badge-secondary>국가</x-badge-secondary>
                </a>

                <a href="/admin/site/location">
                    <x-badge-secondary>지역</x-badge-secondary>
                </a>



            </div>
        </div>
    </div>


</div>
