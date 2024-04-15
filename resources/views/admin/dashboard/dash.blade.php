@setTheme("admin.sidebar")
<x-theme theme="admin.sidebar">
    <x-theme-layout>

        <div class="d-flex justify-content-between my-2">
            <div class="">
                <h3>
                @if(isset($actions['title']))
                    {{$actions['title']}}
                @endif
                </h3>
                <div class="lead text-center" style="font-size: 1rem;">
                @if(isset($actions['subtitle']))
                    {{$actions['subtitle']}}
                @endif
                </div>
            </div>
            <div class="flex justify-content-end align-items-top">

                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Admin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/admin/site">Site</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Dashbaord
                    </li>
                </ol>

            </div>
        </div>




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
                        <a href="/admin/module/site/info">
                            <x-badge-secondary>정보설정</x-badge-secondary>
                        </a>

                        <a href="/admin/module/site/setting">
                            <x-badge-secondary>환경설정</x-badge-secondary>
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


                        <a href="/admin/module/site/header">
                            <x-badge-secondary>상단설정</x-badge-secondary>
                        </a>

                        <a href="/admin/module/site/footer">
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
                                    <a href="/admin/module/site/posts">포스트</a>

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

                    </div>
                </div>
            </div>

        </div>


        {{-- --}}
        <div class="row">
            <!-- -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/module/site/routes">라우팅</a>

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

                    </div>
                </div>
            </div>
        </div>



    </x-theme-layout>
</x-theme>

