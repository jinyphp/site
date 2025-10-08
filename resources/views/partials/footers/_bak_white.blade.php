<!-- White Footer with extensive links -->
<footer class="footer bg-white py-lg-8 py-5">
    <div class="container">
        <div class="row">
            <!-- Logo and description -->
            <div class="col-lg-4 col-md-6 col-12">
                <div>
                    <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Jiny" class="mb-4">
                    <p class="text-body mb-4">
                        Geek is feature-rich components and beautifully Bootstrap UIKit for developers,
                        built with bootstrap responsive framework.
                    </p>
                    <div class="fs-4">
                        <a href="#" class="me-2 text-body"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-2 text-body"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-body"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>

            <!-- Company -->
            <div class="col-lg-2 col-md-3 col-6 mt-4 mt-lg-0">
                <h5 class="mb-3">Company</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-body-secondary text-decoration-none">About</a></li>
                    <li class="mb-2"><a href="{{ route('pricing') }}" class="text-body-secondary text-decoration-none">Pricing</a></li>
                    <li class="mb-2"><a href="{{ route('blog') }}" class="text-body-secondary text-decoration-none">Blog</a></li>
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">Careers</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-body-secondary text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-lg-2 col-md-3 col-6 mt-4 mt-lg-0">
                <h5 class="mb-3">Support</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">Help and Support</a></li>
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">Become Instructor</a></li>
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">Get the app</a></li>
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">FAQ's</a></li>
                    <li class="mb-2"><a href="#" class="text-body-secondary text-decoration-none">Tutorial</a></li>
                </ul>
            </div>

            <!-- Get in touch -->
            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                <h5 class="mb-3">Get in touch</h5>
                <p class="text-body mb-2">339 McDermott Points Hettingerhaven, NV 15283</p>
                <p class="text-body mb-2">
                    Email: <a href="mailto:support@geeksui.com" class="text-primary">support@geeksui.com</a>
                </p>
                <p class="text-body mb-4">
                    Phone: <span class="fw-semibold text-dark">(000) 123 456 789</span>
                </p>
                <div class="d-flex mt-3">
                    <a href="#" class="me-2"><img src="{{ asset('assets/images/svg/appstore.svg') }}" alt="App Store" class="img-fluid" /></a>
                    <a href="#"><img src="{{ asset('assets/images/svg/playstore.svg') }}" alt="Google Play" class="img-fluid" /></a>
                </div>
            </div>
        </div>

        <div class="row align-items-center g-0 border-top py-2 mt-6">
            <div class="col-md-10 col-12">
                <div class="d-lg-flex align-items-center">
                    <div class="me-4">
                        <span>© {{ date('Y') }} Jiny-UI</span>
                    </div>
                    <div>
                        <nav class="nav nav-footer">
                            <a class="nav-link ps-0" href="#">Privacy Policy</a>
                            <a class="nav-link px-2 px-md-3" href="#">Cookie Notice</a>
                            <a class="nav-link d-none d-lg-block" href="#">Do Not Sell My Personal Information</a>
                            <a class="nav-link" href="#">Terms of Use</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2 d-md-flex justify-content-end">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-body" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-globe me-2 align-middle"></i>Language
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="me-2">🇬🇧</span>English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="me-2">🇫🇷</span>Français
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="me-2">🇩🇪</span>Deutsch
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>