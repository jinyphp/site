<!-- Guide Hero -->
<section class="py-4 bg-light">
    <div class="container my-lg-4">
        <div class="row align-items-center justify-content-center gy-2">
            <div class="col-md-6 col-12">
                <!-- caption-->
                <div class="d-flex flex-column gap-5">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="fw-bold mb-0 display-3">가이드 & 자료</h1>
                        <!-- para -->
                        <p class="mb-0 text-dark">단계별 가이드와 유용한 자료를 통해 서비스를 효과적으로 활용하는 방법을 알아보세요</p>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        {{-- <div class="pe-md-6">
                            <!-- 가이드 검색 입력 -->
                            <form class="d-flex align-items-center" action="{{ url('/help/guide') }}" method="GET">
                                <span class="position-absolute ps-3">
                                    <i class="fe fe-search"></i>
                                </span>
                                <label for="SearchGuide" class="visually-hidden">가이드 검색</label>
                                <!-- input  -->
                                <input type="search"
                                       id="SearchGuide"
                                       name="search"
                                       class="form-control ps-6 border-0 py-3 smooth-shadow-md"
                                       placeholder="가이드에서 검색하세요..."
                                       value="{{ request('search') }}" />
                            </form>
                        </div> --}}
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <a href="{{ url('/help') }}" class="btn btn-primary">
                                <i class="fe fe-book me-2"></i>
                                도움말
                            </a>
                            <a href="{{ url('/help/faq') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-help-circle me-2"></i>
                                FAQ 보기
                            </a>
                        </div>
                        {{-- <span class="d-block">카테고리별로 정리된 가이드를 확인하고 필요한 정보를 빠르게 찾아보세요</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- 가이드 전용 일러스트 -->
                    <div class="position-relative">
                        <svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="img-fluid">
                            <!-- Background shapes -->
                            <circle cx="320" cy="70" r="50" fill="#e3f2fd" opacity="0.7" />
                            <circle cx="80" cy="200" r="35" fill="#f3e5f5" opacity="0.7" />
                            <circle cx="350" cy="180" r="25" fill="#e8f5e8" opacity="0.6" />

                            <!-- 메인 가이드북 스택 -->
                            <rect x="140" y="100" width="120" height="90" rx="12" fill="#1976d2" />
                            <rect x="135" y="95" width="120" height="90" rx="12" fill="#2196f3" />
                            <rect x="130" y="90" width="120" height="90" rx="12" fill="#42a5f5" />

                            <!-- 책 표지 디테일 -->
                            <rect x="145" y="105" width="90" height="4" rx="2" fill="rgba(255,255,255,0.9)" />
                            <rect x="145" y="115" width="70" height="3" rx="1.5" fill="rgba(255,255,255,0.7)" />
                            <rect x="145" y="125" width="80" height="2" rx="1" fill="rgba(255,255,255,0.6)" />
                            <rect x="145" y="135" width="60" height="2" rx="1" fill="rgba(255,255,255,0.6)" />

                            <!-- 책 아이콘 -->
                            <rect x="200" y="150" width="20" height="15" rx="2" fill="rgba(255,255,255,0.8)" />
                            <rect x="203" y="153" width="14" height="1" rx="0.5" fill="#1976d2" />
                            <rect x="203" y="156" width="10" height="1" rx="0.5" fill="#1976d2" />
                            <rect x="203" y="159" width="12" height="1" rx="0.5" fill="#1976d2" />

                            <!-- 플로팅 가이드 아이콘들 -->
                            <circle cx="300" cy="50" r="18" fill="#4caf50" />
                            <path d="M293 50 L297 54 L307 44" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" />

                            <circle cx="100" cy="80" r="15" fill="#ff9800" />
                            <rect x="95" y="75" width="10" height="10" rx="1" fill="white" />
                            <rect x="97" y="77" width="6" height="1" rx="0.5" fill="#ff9800" />
                            <rect x="97" y="79" width="4" height="1" rx="0.5" fill="#ff9800" />
                            <rect x="97" y="81" width="5" height="1" rx="0.5" fill="#ff9800" />

                            <circle cx="320" cy="150" r="12" fill="#9c27b0" />
                            <circle cx="317" cy="147" r="1" fill="white" />
                            <circle cx="320" cy="147" r="1" fill="white" />
                            <circle cx="323" cy="147" r="1" fill="white" />
                            <rect x="315" y="150" width="10" height="4" rx="2" fill="white" />

                            <!-- 화살표와 연결선 -->
                            <path d="M80 160 Q 110 140 140 130" stroke="#42a5f5" stroke-width="2" fill="none" stroke-dasharray="5,5" opacity="0.6" />
                            <path d="M280 60 Q 260 80 250 100" stroke="#4caf50" stroke-width="2" fill="none" stroke-dasharray="5,5" opacity="0.6" />

                            <!-- 작은 별점들 -->
                            <circle cx="60" cy="120" r="3" fill="#ffc107" />
                            <circle cx="70" cy="115" r="2" fill="#ffc107" />
                            <circle cx="340" cy="120" r="3" fill="#ffc107" />
                            <circle cx="350" cy="125" r="2" fill="#ffc107" />

                            <!-- 지식 전파 효과 -->
                            <circle cx="200" cy="50" r="25" fill="none" stroke="#e3f2fd" stroke-width="2" opacity="0.4" />
                            <circle cx="200" cy="50" r="35" fill="none" stroke="#e3f2fd" stroke-width="1" opacity="0.3" />
                            <circle cx="200" cy="50" r="45" fill="none" stroke="#e3f2fd" stroke-width="1" opacity="0.2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
