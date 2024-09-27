<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">
                                        <a href="/admin/auth">
                                            회원정보
                                        </a>
                                    </h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck align-middle"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">
                                {{user_count()}} 명
                            </h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-primary-light">-3.65%</span>
                                <span class="text-muted">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">
                                        <a href="/admin/site/contact">
                                        Contacts
                                        </a>
                                    </h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">
                                {{table_count("site_contact")}} 건
                            </h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-success-light">5.25%</span>
                                <span class="text-muted">Since last week</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
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
                                {{-- <span class="badge badge-danger-light">-2.25%</span>
                                <span class="text-muted">Since last week</span> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">
                                        <a href="/admin/site/log">
                                            방문자
                                        </a>
                                    </h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">
                                전체 : {{site_log_sum()}}
                            </h1>
                            <div class="mb-0">
                                {{-- <span class="badge badge-success-light">6.65%</span>
                                <span class="text-muted">Since last week</span> --}}

                                <x-badge-primary>
                                    년 {{site_log_sum(date("Y"))}}
                                </x-badge-primary>

                                <x-badge-info>
                                     월 {{site_log_sum(date("Y"), date("m"))}}
                                </x-badge-info>

                                <x-badge-secondary>
                                    일 {{site_log_sum(date("Y"), date("m"), date("d"))}}
                               </x-badge-secondary>
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
