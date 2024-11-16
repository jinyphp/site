<div class="row">
    <div class="col-12 col-md-6 mb-3">
        @includeIf('jiny-site-board::admin.dashboard.post')
    </div>

    <div class="col-12 col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            <a href="/admin/site/board">
                                계시판
                            </a>

                            <span>
                                ( {{table_count("site_board")}} )
                            </span>
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            계시판을 관리합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>제목</th>
                        <th width="100px">작성글</th>
                        <th width="100px">생성일자</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (getBoards(5) as $item)
                    <tr>
                        <td>{{$item->title}}</td>
                        <td width="100px">{{$item->post}}</td>
                        <td width="100px">{{substr($item->created_at,0,10)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            마케팅
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트 활성화를 위한 컨덴츠를 관리합니다.
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

                <a href="/admin/site/banner">
                    <x-badge-secondary>베너</x-badge-secondary>
                </a>



                <a href="/admin/site/event">
                    <x-badge-secondary>Event</x-badge-secondary>
                </a>






            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            알람 및 메시징
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            회원 대상으로 알람 및 메시징을 관리합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">

                <a href="/admin/site/notification">
                    <x-badge-secondary>notification</x-badge-secondary>
                </a>

                <a href="/admin/site/subscribe">
                    <x-badge-secondary>구독</x-badge-secondary>
                </a>



            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            고객지원
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            고객과의 소통을 통하여 문제를 해결합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">

                <a href="/admin/site/contact">
                    <x-badge-secondary>Contact</x-badge-secondary>
                </a>

                <a href="/admin/site/help">
                    <x-badge-secondary>Help</x-badge-secondary>
                </a>

                <a href="/admin/site/faq">
                    <x-badge-secondary>FAQ</x-badge-secondary>
                </a>


            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <x-flex-between>
                    <div>
                        <h5 class="card-title">
                            분석
                        </h5>
                        <h6 class="card-subtitle text-muted">
                            사이트 활동을 분석합니다.
                        </h6>
                    </div>
                    <div>
                        @icon("info-circle.svg")
                    </div>
                </x-flex-between>
            </div>
            <div class="card-body">

                <a href="/admin/site/seo">
                    <x-badge-secondary>Seo분석</x-badge-secondary>
                </a>

                <a href="/admin/site/log">
                    <x-badge-secondary>로그분석</x-badge-secondary>
                </a>


            </div>
        </div>
    </div>

</div>
