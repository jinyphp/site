@php
    use Jiny\Site\Facades\Footer;

    // Footer 설정 정보 가져오기
    $footerConfig = Footer::getConfig();
    $footerLinks = Footer::getLinks();
    $copyright = Footer::getCopyright();
@endphp

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center g-0 border-top py-2">
            <!-- Desc -->
            <div class="col-md-6 col-12 text-center text-md-start">
                <span>
                    ©
                    <span id="copyright">
                        <script>
                            document.getElementById("copyright").appendChild(document.createTextNode(new Date().getFullYear()));
                        </script>
                    </span>
                    @if ($copyright)
                        {{ $copyright }}
                    @else
                        Geeks. All Rights Reserved.
                    @endif
                </span>
            </div>
            <!-- Links -->
            <div class="col-12 col-md-6">
                <nav class="nav nav-footer justify-content-center justify-content-md-end">
                    @if (!empty($footerLinks))
                        @foreach ($footerLinks as $link)
                            @if (!empty($link['title']) && !empty($link['href']))
                                <a class="nav-link" href="{{ $link['href'] }}">{{ $link['title'] }}</a>
                            @endif
                        @endforeach
                    @else
                        <!-- Default links if no links are configured -->
                        <a class="nav-link active ps-0" href="#!">개인정보</a>
                        <a class="nav-link" href="/terms">이용약관</a>
                        <a class="nav-link" href="#!">피드백</a>
                        <a class="nav-link" href="/help">지원</a>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</footer>
