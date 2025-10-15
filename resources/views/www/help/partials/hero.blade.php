<!-- help hero -->
<section class="py-8 bg-light">
    <div class="container my-lg-8">
        <div class="row align-items-center justify-content-center gy-2">
            <div class="col-md-6 col-12">
                <!-- caption-->
                <div class="d-flex flex-column gap-5">
                    <div class="d-flex flex-column gap-1">
                        <h1 class="fw-bold mb-0 display-3">도움이 필요하신가요?</h1>
                        <!-- para -->
                        <p class="mb-0 text-dark">궁금한 것이 있으시면 도움말 센터를 검색해보세요</p>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <div class="pe-md-6">
                            <!-- input  -->
                            <form class="d-flex align-items-center" action="{{ url('/help/search') }}" method="GET">
                                <span class="position-absolute ps-3">
                                    <i class="fe fe-search"></i>
                                </span>
                                <label for="SearchHelp" class="visually-hidden">도움말 검색</label>
                                <!-- input  -->
                                <input type="search" id="SearchHelp" name="q" class="form-control ps-6 border-0 py-3 smooth-shadow-md" placeholder="질문, 주제 또는 키워드를 입력하세요" />
                            </form>
                        </div>
                        <span class="d-block">...또는 카테고리를 선택하여 필요한 도움말을 빠르게 찾아보세요</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- img  -->
                    <img src="{{ asset('assets/images/png/3d-girl.png') }}" alt="도움말" class="text-center img-fluid" />
                </div>
            </div>
        </div>
    </div>
</section>
