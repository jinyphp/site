<!-- FAQ Hero -->
<section class="py-4 bg-light">
    <div class="container my-lg-4">
        <div class="row align-items-center justify-content-center gy-2">
            <div class="col-md-6 col-12">
                <!-- caption-->
                <div class="d-flex flex-column gap-5">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="fw-bold mb-0 display-3">자주 묻는 질문</h1>
                        <!-- para -->
                        <p class="mb-0 text-dark">가장 자주 묻는 질문들에 대한 답변을 확인하고, 빠르게 해결책을 찾아보세요</p>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        {{-- <div class="pe-md-6">
                            <!-- FAQ 검색 입력 -->
                            <form class="d-flex align-items-center" action="{{ url('/help/faq') }}" method="GET">
                                <span class="position-absolute ps-3">
                                    <i class="fe fe-search"></i>
                                </span>
                                <label for="SearchFaq" class="visually-hidden">FAQ 검색</label>
                                <!-- input  -->
                                <input type="search"
                                       id="SearchFaq"
                                       name="search"
                                       class="form-control ps-6 border-0 py-3 smooth-shadow-md"
                                       placeholder="FAQ에서 검색하세요..."
                                       value="{{ request('search') }}" />
                            </form>
                        </div> --}}
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <a href="{{ url('/help') }}" class="btn btn-outline-primary">
                                <i class="fe fe-help-circle me-2"></i>
                                도움말 센터
                            </a>
                            <a href="{{ url('/help/guide') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-book me-2"></i>
                                가이드 보기
                            </a>
                        </div>
                        {{-- <span class="d-block">카테고리별로 분류된 FAQ를 확인하거나 키워드로 검색해보세요</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- FAQ 전용 일러스트 -->
                    <div class="position-relative">
                        <svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="img-fluid">
                            <!-- Background shapes -->
                            <circle cx="320" cy="70" r="50" fill="#e3f2fd" opacity="0.7" />
                            <circle cx="80" cy="200" r="35" fill="#f3e5f5" opacity="0.7" />
                            <circle cx="350" cy="180" r="25" fill="#e8f5e8" opacity="0.6" />

                            <!-- Question marks floating -->
                            <circle cx="300" cy="50" r="20" fill="#2196f3" />
                            <text x="300" y="58" text-anchor="middle" fill="white" font-size="18" font-weight="bold">?</text>

                            <circle cx="100" cy="80" r="15" fill="#ff9800" />
                            <text x="100" y="87" text-anchor="middle" fill="white" font-size="14" font-weight="bold">?</text>

                            <circle cx="320" cy="150" r="12" fill="#4caf50" />
                            <text x="320" y="156" text-anchor="middle" fill="white" font-size="10" font-weight="bold">?</text>

                            <!-- Central FAQ illustration -->
                            <rect x="150" y="100" width="100" height="80" rx="12" fill="#1976d2" />
                            <rect x="160" y="115" width="80" height="3" rx="1.5" fill="rgba(255,255,255,0.8)" />
                            <rect x="160" y="125" width="60" height="2" rx="1" fill="rgba(255,255,255,0.6)" />
                            <rect x="160" y="135" width="70" height="2" rx="1" fill="rgba(255,255,255,0.6)" />
                            <rect x="160" y="145" width="50" height="2" rx="1" fill="rgba(255,255,255,0.6)" />
                            <rect x="160" y="155" width="65" height="2" rx="1" fill="rgba(255,255,255,0.6)" />

                            <!-- Answer checkmarks -->
                            <circle cx="80" cy="150" r="10" fill="#4caf50" />
                            <path d="M75 150 L78 153 L85 146" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" />

                            <circle cx="330" cy="220" r="8" fill="#4caf50" />
                            <path d="M327 220 L329 222 L333 218" stroke="white" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" />

                            <!-- Speech bubbles -->
                            <ellipse cx="60" cy="120" rx="25" ry="15" fill="white" stroke="#e0e0e0" stroke-width="1" />
                            <text x="60" y="125" text-anchor="middle" fill="#666" font-size="8" font-weight="bold">FAQ</text>

                            <ellipse cx="340" cy="120" rx="20" ry="12" fill="white" stroke="#e0e0e0" stroke-width="1" />
                            <circle cx="335" cy="120" r="1.5" fill="#666" />
                            <circle cx="340" cy="120" r="1.5" fill="#666" />
                            <circle cx="345" cy="120" r="1.5" fill="#666" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
