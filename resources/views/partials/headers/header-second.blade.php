{{-- navbar --}}
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-0">

        <div class="d-flex">
            <a class="navbar-brand" href="/">
                <img src="{{ asset(Site::logo()) }}" alt="{{ Site::brand() }}" />
            </a>

            <div class="dropdown d-none d-md-block">
                <button class="btn btn-light-primary text-primary" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fe fe-list me-2 align-middle"></i>
                    Category
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li class="dropdown-submenu dropend">
                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Web
                            Development</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Bootstrap</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">React</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">GraphQl</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Gatsby</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Grunt</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Svelte</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Meteor</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">HTML5</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Angular</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu dropend">
                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Design</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Graphic Design</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Illustrator</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">UX / UI Design</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Figma Design</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Adobe XD</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Sketch</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Icon Design</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Photoshop</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Mobile App</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">IT Software</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Marketing</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Music</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Life Style</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Business</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item">Photography</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="order-lg-3">
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
                        aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                        <i class="bi theme-icon-active"></i>
                        <span class="visually-hidden bs-theme-text">Toggle theme</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="light" aria-pressed="false">
                                <i class="bi theme-icon bi-sun-fill"></i>
                                <span class="ms-2">Light</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="dark" aria-pressed="false">
                                <i class="bi theme-icon bi-moon-stars-fill"></i>
                                <span class="ms-2">Dark</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active"
                                data-bs-theme-value="auto" aria-pressed="true">
                                <i class="bi theme-icon bi-circle-half"></i>
                                <span class="ms-2">Auto</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <a href="#" class="btn btn-icon btn-light rounded-circle d-none d-md-inline-flex ms-2">
                    <i
                        class="fe fe-shopping-cart align-middle"></i>
                </a>

                <x-login class="btn btn-outline-primary ms-2 d-none d-lg-block">로그인</x-login>
                <x-register class="btn btn-primary ms-2 d-none d-lg-block">회원가입</x-register>

                <!-- Button -->
                <button class="navbar-toggler collapsed ms-2 ms-lg-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="icon-bar top-bar mt-0"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
            </div>
        </div>

        @includeIf('jiny-site::partials.navs.second.top', ['menuItems' => Site::menuItems('second')])
    </div>
</nav>
