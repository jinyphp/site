@php
    use Jiny\Site\Facades\Footer;

    // Footer 설정 정보 가져오기
    $company = Footer::getCompany();
    $copyright = Footer::getCopyright();
    $logo = Footer::getLogo();
    $companySection = Footer::getMenuSection('company');
    $communitySection = Footer::getMenuSection('community');
    $educationSection = Footer::getMenuSection('education');
    $social = Footer::getSocial();
@endphp

<!-- footer -->
<footer class="pt-5 pb-3">
    <div class="container">
        <div class="row justify-content-center text-center align-items-center">
            <div class="col-12 col-md-12 col-xxl-6 px-0">
                <div class="mb-4">
                    @if ($logo)
                        <a href="/">
                            <img src="{{ asset($logo) }}" alt="{{ $company['name'] ?? 'Logo' }}"
                                class="mb-4 logo-inverse" />
                        </a>
                    @else
                        <a href="/">
                            <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Geeks"
                                class="mb-4 logo-inverse" />
                        </a>
                    @endif
                    <p class="lead">
                        {{ $company['description'] ?? 'Geek은 Bootstrap 반응형 프레임워크로 제작된 개발자를 위한 풍부한 기능과 아름다운 Bootstrap 5 템플릿입니다.' }}
                    </p>
                </div>

                <!-- Navigation Links -->
                <nav class="nav nav-footer justify-content-center">
                    @if (!empty($companySection['links']))
                        @foreach ($companySection['links'] as $index => $link)
                            <a class="nav-link" href="{{ $link['href'] }}">{{ $link['title'] }}</a>
                            @if ($index < count($companySection['links']) - 1)
                                <span class="my-2 vr opacity-50"></span>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback navigation links -->
                        <a class="nav-link" href="/about">회사소개</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/jobs">채용</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/contact">문의</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="#">가격</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/blog">블로그</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/partners">제휴</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/help">도움말</a>
                        <span class="my-2 vr opacity-50"></span>
                        <a class="nav-link" href="/investors">투자자</a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Social Media Section -->
        @if (!empty($social))
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center gap-3">
                        @foreach ($social as $socialLink)
                            <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener" class="text-muted">
                                <i class="bi {{ $socialLink['icon'] }} fs-4"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Copyright Section -->
        <div class="row justify-content-center text-center mt-4">
            <div class="col-12">
                <span class="text-muted">
                    ©
                    <span id="copyright">
                        <script>
                            document.getElementById("copyright").appendChild(document.createTextNode(new Date().getFullYear()));
                        </script>
                    </span>
                    {{ $copyright ?: 'Geeks. All Rights Reserved' }}
                </span>
            </div>
        </div>
    </div>
</footer>
