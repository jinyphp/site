<!-- Simple Footer - Light background with minimal info -->
<footer class="py-lg-8 py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-7">
                <div class="text-center text-md-start">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Jiny" class="mb-3">
                    </a>
                    <div class="mt-4">
                        <p>
                            Geek is feature rich components and beautifully Bootstrap 5 template<br />
                            for developers, built with bootstrap responsive framework.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-5 mt-4 mt-md-0">
                <div class="text-center text-md-end">
                    <nav class="nav nav-footer justify-content-center justify-content-md-end">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                        <a class="nav-link" href="#">Careers</a>
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                        <a class="nav-link" href="#">Affiliate</a>
                        <a class="nav-link" href="#">Help</a>
                        <a class="nav-link" href="#">Investors</a>
                    </nav>
                </div>
            </div>
        </div>
        <hr class="my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span>© Jiny-UI, Inc. All Rights Reserved</span>
            </div>
            <div class="col-md-6">
                <div class="text-center text-md-end">
                    <a href="#" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-muted me-3">Cookie Notice</a>
                    <a href="#" class="text-muted">Terms of Use</a>
                    <a href="#" class="text-primary ms-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-primary ms-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-primary ms-3"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>