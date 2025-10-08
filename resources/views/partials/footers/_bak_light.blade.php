<!-- Dark Footer with multiple columns -->
<footer class="footer bg-dark py-8 text-white">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                <div>
                    <img src="{{ asset('assets/images/brand/logo/logo-light.svg') }}" alt="Jiny" class="mb-3">
                    <p class="text-white-50">
                        Nascetur nibh feugiat vulputate urna mauris tincidunt porttitor ultricies. Et dis augue praesent congue.
                    </p>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fe fe-globe me-2"></i>English
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="#">English</a></li>
                            <li><a class="dropdown-item" href="#">Français</a></li>
                            <li><a class="dropdown-item" href="#">Deutsch</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Company Links -->
            <div class="col-lg-2 col-md-6 col-12 mb-4 mb-lg-0">
                <h5 class="text-white mb-3">Company</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-white-50 text-decoration-none">About us</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">Contact us</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">News and Blogs</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Career</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Investors</a></li>
                </ul>
            </div>

            <!-- Community Links -->
            <div class="col-lg-2 col-md-6 col-12 mb-4 mb-lg-0">
                <h5 class="text-white mb-3">Community</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Help and Support</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Affiliate</a></li>
                    <li class="mb-2"><a href="{{ route('blog') }}" class="text-white-50 text-decoration-none">Blog</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Jiny Business</a></li>
                </ul>
            </div>

            <!-- Teaching Links -->
            <div class="col-lg-2 col-md-6 col-12 mb-4 mb-lg-0">
                <h5 class="text-white mb-3">Teaching</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Become a teacher</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">How to guide</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Documentation</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-12 col-12">
                <h5 class="text-white mb-3">Contact</h5>
                <p class="text-white-50 mb-2">Toll free: +1234 567 890</p>
                <p class="text-white-50 mb-2">Time: 9AM to 8:PM IST</p>
                <p class="text-white-50 mb-4">Email: example@gmail.com</p>
                <div class="d-flex gap-2">
                    <a href="#" class="me-2">
                        <img src="{{ asset('assets/images/svg/appstore.svg') }}" alt="App Store" class="img-fluid">
                    </a>
                    <a href="#">
                        <img src="{{ asset('assets/images/svg/playstore.svg') }}" alt="Google Play" class="img-fluid">
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-5 opacity-10">

        <!-- Bottom Bar -->
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center">
                    <span class="text-white-50 me-4">© 2025 JinyTheme. Powered Codescandy</span>
                    <nav class="nav nav-footer">
                        <a class="nav-link text-white-50" href="#">Terms of use</a>
                        <a class="nav-link text-white-50" href="#">Cookies Settings</a>
                        <a class="nav-link text-white-50" href="#">Privacy policy</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>