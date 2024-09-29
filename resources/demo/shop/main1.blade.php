<x-theme name="boot/cartzilla">
    <!-- Navigation bar (Page header) -->
    <header class="navbar navbar-expand-lg bg-body navbar-sticky sticky-top px-0" data-sticky-element>
        <div class="container flex-nowrap">

          <!-- Mobile offcanvas menu toggler (Hamburger) -->
          <button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar brand (Logo) -->
          <a href="index.html" class="navbar-brand py-1 py-md-2 py-xl-1">
            <span class="d-none d-sm-flex flex-shrink-0 text-primary me-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"><path d="M36 18.01c0 8.097-5.355 14.949-12.705 17.2a18.12 18.12 0 0 1-5.315.79C9.622 36 2.608 30.313.573 22.611.257 21.407.059 20.162 0 18.879v-1.758c.02-.395.059-.79.099-1.185.099-.908.277-1.817.514-2.686C2.687 5.628 9.682 0 18 0c5.572 0 10.551 2.528 13.871 6.517 1.502 1.797 2.648 3.91 3.359 6.201.494 1.659.771 3.436.771 5.292z" fill="currentColor"/><g fill="#fff"><path d="M17.466 21.624c-.514 0-.988-.316-1.146-.829-.198-.632.138-1.303.771-1.501l7.666-2.469-1.205-8.254-13.317 4.621a1.19 1.19 0 0 1-1.521-.75 1.19 1.19 0 0 1 .751-1.521l13.89-4.818c.553-.197 1.166-.138 1.64.158a1.82 1.82 0 0 1 .85 1.284l1.344 9.183c.138.987-.494 1.994-1.482 2.33l-7.864 2.528-.375.04zm7.31.138c-.178-.632-.85-1.007-1.482-.81l-5.177 1.58c-2.331.79-3.28.02-3.418-.099l-6.56-8.412a4.25 4.25 0 0 0-4.406-1.758l-3.122.987c-.237.889-.415 1.777-.514 2.686l4.228-1.363a1.84 1.84 0 0 1 1.857.81l6.659 8.551c.751.948 2.015 1.323 3.359 1.323.909 0 1.857-.178 2.687-.474l5.078-1.54c.632-.178 1.008-.829.81-1.481z"/><use href="#czlogo"/><use href="#czlogo" x="8.516" y="-2.172"/></g><defs><path id="czlogo" d="M18.689 28.654a1.94 1.94 0 0 1-1.936 1.935 1.94 1.94 0 0 1-1.936-1.935 1.94 1.94 0 0 1 1.936-1.935 1.94 1.94 0 0 1 1.936 1.935z"/></defs></svg>
            </span>
            Cartzilla
          </a>

          <!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
          <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header py-3">
              <h5 class="offcanvas-title" id="navbarNavLabel">Browse Cartzilla</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
              <ul class="navbar-nav position-relative">
                <li class="nav-item dropdown py-lg-2 me-lg-n1 me-xl-0">
                  <a class="nav-link dropdown-toggle active" aria-current="page" href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Home</a>
                  <ul class="dropdown-menu" style="--cz-dropdown-spacer: .875rem">
                    <li class="hover-effect-opacity px-2 mx-n2">
                      <a class="dropdown-item d-block mb-0" href="home-electronics.html">
                        <span class="fw-medium">Electronics Store</span>
                        <span class="d-block fs-xs text-body-secondary">Megamenu + Hero slider</span>
                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2" style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                          <img class="position-relative z-2 d-none-dark" src="/assets/img/mega-menu/demo-preview/electronics-light.jpg" alt="Electronics Store">
                          <img class="position-relative z-2 d-none d-block-dark" src="/assets/img/mega-menu/demo-preview/electronics-dark.jpg" alt="Electronics Store">
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark" style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark" style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                        </div>
                      </a>
                    </li>
                    <li class="hover-effect-opacity px-2 mx-n2">
                      <a class="dropdown-item d-block mb-0" href="home-fashion-v1.html">
                        <span class="fw-medium">Fashion Store v.1</span>
                        <span class="d-block fs-xs text-body-secondary">Hero promo slider</span>
                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2" style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                          <img class="position-relative z-2 d-none-dark" src="/assets/img/mega-menu/demo-preview/fashion-1-light.jpg" alt="Fashion Store v.1">
                          <img class="position-relative z-2 d-none d-block-dark" src="/assets/img/mega-menu/demo-preview/fashion-1-dark.jpg" alt="Fashion Store v.1">
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark" style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark" style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                        </div>
                      </a>
                    </li>
                    <li class="hover-effect-opacity px-2 mx-n2">
                      <a class="dropdown-item d-block mb-0" href="home-fashion-v2.html">
                        <span class="fw-medium">Fashion Store v.2</span>
                        <span class="d-block fs-xs text-body-secondary">Hero banner with hotspots</span>
                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2" style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                          <img class="position-relative z-2 d-none-dark" src="/assets/img/mega-menu/demo-preview/fashion-2-light.jpg" alt="Fashion Store v.2">
                          <img class="position-relative z-2 d-none d-block-dark" src="/assets/img/mega-menu/demo-preview/fashion-2-dark.jpg" alt="Fashion Store v.2">
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark" style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark" style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                        </div>
                      </a>
                    </li>
                    <li class="hover-effect-opacity px-2 mx-n2">
                      <a class="dropdown-item d-block mb-0" href="home-furniture.html">
                        <span class="fw-medium">Furniture Store</span>
                        <span class="d-block fs-xs text-body-secondary">Fancy product carousel</span>
                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2" style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                          <img class="position-relative z-2 d-none-dark" src="/assets/img/mega-menu/demo-preview/furniture-light.jpg" alt="Furniture Store">
                          <img class="position-relative z-2 d-none d-block-dark" src="/assets/img/mega-menu/demo-preview/furniture-dark.jpg" alt="Furniture Store">
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark" style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark" style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                        </div>
                      </a>
                    </li>
                    <li class="hover-effect-opacity px-2 mx-n2">
                      <a class="dropdown-item d-block mb-0" href="home-grocery.html">
                        <span class="fw-medium">Grocery Store</span>
                        <span class="d-block fs-xs text-body-secondary">Hero slider + Category cards</span>
                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2" style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                          <img class="position-relative z-2 d-none-dark" src="/assets/img/mega-menu/demo-preview/grocery-light.jpg" alt="Grocery Store">
                          <img class="position-relative z-2 d-none d-block-dark" src="/assets/img/mega-menu/demo-preview/grocery-dark.jpg" alt="Grocery Store">
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark" style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                          <span class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark" style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item dropdown position-static py-lg-2 me-lg-n1 me-xl-0">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Shop</a>
                  <div class="dropdown-menu rounded-4 p-4" style="--cz-dropdown-spacer: .875rem">
                    <div class="d-flex flex-column flex-lg-row gap-4">
                      <div style="min-width: 190px">
                        <div class="h6 mb-2">Electronics Store</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-categories-electronics.html">Categories Page</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-catalog-electronics.html">Catalog with Side Filters</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-general-electronics.html">Product General Info</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-details-electronics.html">Product Details</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-reviews-electronics.html">Product Reviews</a>
                          </li>
                        </ul>
                        <div class="h6 pt-4 mb-2">Fashion Store</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-catalog-fashion.html">Catalog with Side Filters</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-fashion.html">Product Page</a>
                          </li>
                        </ul>
                        <div class="h6 pt-4 mb-2">Furniture Store</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-catalog-furniture.html">Catalog with Top Filters</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-furniture.html">Product Page</a>
                          </li>
                        </ul>
                      </div>
                      <div style="min-width: 190px">
                        <div class="h6 mb-2">Grocery Store</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-catalog-grocery.html">Catalog with Side Filters</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="shop-product-grocery.html">Product Page</a>
                          </li>
                        </ul>
                        <div class="h6 pt-4 mb-2">Checkout v.1</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-cart.html">Shopping Cart</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-delivery-1.html">Delivery Info (Step 1)</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-delivery-2.html">Delivery Info (Step 2)</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-shipping.html">Shipping Address</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-payment.html">Payment</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v1-thankyou.html">Thank You Page</a>
                          </li>
                        </ul>
                      </div>
                      <div style="min-width: 190px">
                        <div class="h6 mb-2">Checkout v.2</div>
                        <ul class="nav flex-column gap-2 mt-0">
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v2-cart.html">Shopping Cart</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v2-delivery.html">Delivery Info</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v2-pickup.html">Pickup from Store</a>
                          </li>
                          <li class="d-flex w-100 pt-1">
                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="checkout-v2-thankyou.html">Thank You Page</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="nav-item dropdown py-lg-2 me-lg-n1 me-xl-0">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-auto-close="outside" aria-expanded="false">Account</a>
                  <ul class="dropdown-menu" style="--cz-dropdown-spacer: .875rem">
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Auth Pages</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="account-signin.html">Sign In</a></li>
                        <li><a class="dropdown-item" href="account-signup.html">Sign Up</a></li>
                        <li><a class="dropdown-item" href="account-password-recovery.html">Password Recovery</a></li>
                      </ul>
                    </li>
                    <li><a class="dropdown-item" href="account-orders.html">Orders History</a></li>
                    <li><a class="dropdown-item" href="account-wishlist.html">Wishlist</a></li>
                    <li><a class="dropdown-item" href="account-payment.html">Payment Methods</a></li>
                    <li><a class="dropdown-item" href="account-reviews.html">My Reviews</a></li>
                    <li><a class="dropdown-item" href="account-info.html">Personal Info</a></li>
                    <li><a class="dropdown-item" href="account-addresses.html">Addresses</a></li>
                    <li><a class="dropdown-item" href="account-notifications.html">Notifications</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown py-lg-2 me-lg-n1 me-xl-0">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-auto-close="outside" aria-expanded="false">Pages</a>
                  <ul class="dropdown-menu" style="--cz-dropdown-spacer: .875rem">
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">About</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="about-v1.html">About v.1</a></li>
                        <li><a class="dropdown-item" href="about-v2.html">About v.2</a></li>
                      </ul>
                    </li>
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Blog</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="blog-grid-v1.html">Grid View v.1</a></li>
                        <li><a class="dropdown-item" href="blog-grid-v2.html">Grid View v.2</a></li>
                        <li><a class="dropdown-item" href="blog-list.html">List View</a></li>
                        <li><a class="dropdown-item" href="blog-single-v1.html">Single Post v.1</a></li>
                        <li><a class="dropdown-item" href="blog-single-v2.html">Single Post v.2</a></li>
                      </ul>
                    </li>
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Contact</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="contact-v1.html">Contact v.1</a></li>
                        <li><a class="dropdown-item" href="contact-v2.html">Contact v.2</a></li>
                        <li><a class="dropdown-item" href="contact-v3.html">Contact v.3</a></li>
                      </ul>
                    </li>
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">Help Center</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="help-topics-v1.html">Help Topics v.1</a></li>
                        <li><a class="dropdown-item" href="help-topics-v2.html">Help Topics v.2</a></li>
                        <li><a class="dropdown-item" href="help-single-article-v1.html">Help Single Article v.1</a></li>
                        <li><a class="dropdown-item" href="help-single-article-v2.html">Help Single Article v.2</a></li>
                      </ul>
                    </li>
                    <li class="dropend">
                      <a class="dropdown-item dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown" data-bs-trigger="hover" aria-expanded="false">404 Error</a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="404-electronics.html">404 Electronics</a></li>
                        <li><a class="dropdown-item" href="404-fashion.html">404 Fashion</a></li>
                        <li><a class="dropdown-item" href="404-furniture.html">404 Furniture</a></li>
                        <li><a class="dropdown-item" href="404-grocery.html">404 Grocery</a></li>
                      </ul>
                    </li>
                    <li><a class="dropdown-item" href="terms-and-conditions.html">Terms &amp; Conditions</a></li>
                  </ul>
                </li>
                <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                  <a class="nav-link" href="docs/installation.html">Docs</a>
                </li>
                <li class="nav-item py-lg-2 me-lg-n2 me-xl-0">
                  <a class="nav-link" href="docs/typography.html">Components</a>
                </li>
              </ul>
            </div>
          </nav>

          <!-- Button group -->
          <div class="d-flex gap-3 gap-sm-4">

            <!-- Theme switcher (light/dark/auto) -->
            <div class="dropdown">
              <button type="button" class="theme-switcher btn btn-icon btn-secondary fs-lg rounded-circle animate-scale" data-bs-toggle="dropdown" data-bs-display="dynamic" aria-expanded="false" aria-label="Toggle theme (light)">
                <span class="theme-icon-active d-flex animate-target">
                  <i class="ci-sun"></i>
                </span>
              </button>
              <ul class="dropdown-menu start-50 translate-middle-x" style="--cz-dropdown-min-width: 9rem; --cz-dropdown-spacer: .5rem">
                <li>
                  <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                    <span class="theme-icon d-flex fs-base me-2">
                      <i class="ci-sun"></i>
                    </span>
                    <span class="theme-label">Light</span>
                    <i class="item-active-indicator ci-check ms-auto"></i>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                    <span class="theme-icon d-flex fs-base me-2">
                      <i class="ci-moon"></i>
                    </span>
                    <span class="theme-label">Dark</span>
                    <i class="item-active-indicator ci-check ms-auto"></i>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                    <span class="theme-icon d-flex fs-base me-2">
                      <i class="ci-auto"></i>
                    </span>
                    <span class="theme-label">Auto</span>
                    <i class="item-active-indicator ci-check ms-auto"></i>
                  </button>
                </li>
              </ul>
            </div>

            <!-- Buy button  -->
            <a class="btn btn-primary animate-slide-end" href="https://themes.getbootstrap.com/product/cartzilla-bootstrap-e-commerce-template-ui-kit/" target="_blank" rel="noreferrer">
              <i class="ci-shopping-cart fs-base animate-target ms-n1 me-2"></i>
              Buy now
            </a>
          </div>
        </div>
      </header>


      <!-- Page content -->
      <main class="content-wrapper">

        <!-- Hero (Demos) -->
        <section class="pt-4 pt-sm-5 mt-3 mt-sm-0">

          <!-- Title -->
          <div class="container text-center pt-lg-2 pt-xl-3 mx-auto pb-4 pb-sm-0 mb-3 mb-sm-5" style="max-width: 680px">
            <h1 class="display-5 pb-md-2">Multipurpose <span class="text-nowrap">Bootstrap 5</span> <span class="text-nowrap">E-Commerce</span> Template</h1>
            <p class="fs-lg mb-0">Unlock the potential of your online business with our premium e-commerce front-end template, carefully crafted on the latest Bootstrap framework.</p>
          </div>

          <!-- Grid -->
          <div class="container-fluid d-flex flex-column gap-4" style="max-width: 1456px">
            <div class="d-flex flex-column flex-md-row gap-4">

              <!-- Furniture store -->
              <div class="hover-effect-scale ratio" id="furniture" style="--cz-transform-scale: 1.03; --cz-transition-duration: .3s">
                <div class="nav flex-column position-absolute top-0 start-0 w-100 h-100 z-2 pt-4 pt-xl-5 px-4 ps-xl-5 mt-lg-2 ms-lg-2 m-xl-0">
                  <h2 class="h3 d-none d-lg-block pb-2 mb-1">Furniture Store</h2>
                  <h2 class="h4 d-lg-none mb-2">Furniture Store</h2>
                  <p class="fs-xs mb-2 mb-xl-3 d-none d-sm-block d-md-none d-lg-block" style="max-width: 250px">Explore a curated collection of stylish and modern furniture for every room.</p>
                  <a class="nav-link animate-underline stretched-link text-dark-emphasis py-1 px-0" href="home-furniture.html">
                    <span class="animate-target">View demo</span>
                    <i class="ci-chevron-right fs-base mt-1 ms-1"></i>
                  </a>
                </div>
                <div class="hover-effect-target d-flex align-items-end h-100 overflow-hidden rounded-5">
                  <div class="position-relative z-1 rtl-flip">
                    <img src="/assets/img/intro/demos/furniture-light.png" class="hover-effect-target d-none-dark" width="773" alt="Furniture Store">
                    <img src="/assets/img/intro/demos/furniture-dark.png" class="hover-effect-target d-none d-block-dark" width="773" alt="Furniture Store">
                  </div>
                  <span class="bg-body-secondary position-absolute top-0 start-0 w-100 h-100 d-none-dark"></span>
                  <span class="bg-dark position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark"></span>
                </div>
              </div>

              <!-- Grocery store -->
              <div class="hover-effect-scale ratio" id="grocery" style="--cz-transform-scale: 1.03; --cz-transition-duration: .3s">
                <div class="nav flex-column position-absolute top-0 start-0 w-100 h-100 z-2 pt-4 pt-xl-5 px-4 ps-xl-5 mt-lg-2 ms-lg-2 m-xl-0">
                  <h2 class="h3 text-white d-none d-lg-block pb-2 mb-1">Grocery Store</h2>
                  <h2 class="h4 text-white d-lg-none mb-2">Grocery Store</h2>
                  <p class="text-white opacity-75 fs-xs mb-2 mb-xl-3 d-none d-sm-block d-md-none d-lg-block" style="max-width: 250px">Fresh, organic, and local groceries delivered right to your doorstep.</p>
                  <a class="nav-link animate-underline stretched-link text-white py-1 px-0" href="home-grocery.html">
                    <span class="animate-target">View demo</span>
                    <i class="ci-chevron-right fs-base mt-1 ms-1"></i>
                  </a>
                </div>
                <div class="hover-effect-target d-flex align-items-end justify-content-end h-100 overflow-hidden rounded-5">
                  <div class="position-relative z-1 rtl-flip">
                    <img src="/assets/img/intro/demos/grocery-light.png" class="hover-effect-target d-none-dark" width="627" alt="Grocery Store">
                    <img src="/assets/img/intro/demos/grocery-dark.png" class="hover-effect-target d-none d-block-dark" width="627" alt="Grocery Store">
                  </div>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark" style="background-color: #708b88;"></span>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark" style="background-color: #49595a;"></span>
                </div>
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4">

              <!-- Fashion store v.1 -->
              <div class="hover-effect-scale ratio" id="fashion-1" style="--cz-transform-scale: 1.03; --cz-transition-duration: .3s">
                <div class="nav flex-column position-absolute top-0 start-0 w-100 h-100 z-2 pt-4 pt-xl-5 px-4 ps-xl-5 mt-lg-2 ms-lg-2 m-xl-0">
                  <h2 class="h3 text-white d-none d-lg-block pb-2 mb-1">Fashion Store v.1</h2>
                  <h2 class="h4 text-white d-lg-none mb-2">Fashion Store v.1</h2>
                  <p class="text-white opacity-75 fs-xs mb-2 mb-xl-3 d-none d-sm-block d-md-none d-lg-block" style="max-width: 250px">Discover the newest trends in fashion with our exclusive designer wear.</p>
                  <a class="nav-link animate-underline stretched-link text-white py-1 px-0" href="home-fashion-v1.html">
                    <span class="animate-target">View demo</span>
                    <i class="ci-chevron-right fs-base mt-1 ms-1"></i>
                  </a>
                </div>
                <div class="hover-effect-target d-flex align-items-end justify-content-end h-100 overflow-hidden rounded-5">
                  <div class="position-relative z-1 rtl-flip">
                    <img src="/assets/img/intro/demos/fashion-1-light.png" class="hover-effect-target d-none-dark" width="370" alt="Fashion Store v.1">
                    <img src="/assets/img/intro/demos/fashion-1-dark.png" class="hover-effect-target d-none d-block-dark" width="370" alt="Fashion Store v.1">
                  </div>
                  <span class="position-absolute top-0 start-0 w-100 h-100" style="background-color: #333d4c;"></span>
                </div>
              </div>

              <!-- Electronics store -->
              <div class="hover-effect-scale ratio" id="electronics" style="--cz-transform-scale: 1.03; --cz-transition-duration: .3s">
                <div class="nav flex-column position-absolute top-0 start-0 w-100 h-100 z-2 pt-4 pt-xl-5 px-4 ps-xl-5 mt-lg-2 ms-lg-2 m-xl-0">
                  <h2 class="h3 d-none d-lg-block pb-2 mb-1">Electronics Store</h2>
                  <h2 class="h4 d-lg-none mb-2">Electronics Store</h2>
                  <p class="fs-xs mb-2 mb-xl-3 d-none d-sm-block d-md-none d-lg-block" style="max-width: 250px">Your one-stop shop for the latest in tech gadgets and electronics.</p>
                  <a class="nav-link animate-underline stretched-link text-dark-emphasis py-1 px-0" href="home-electronics.html">
                    <span class="animate-target">View demo</span>
                    <i class="ci-chevron-right fs-base mt-1 ms-1"></i>
                  </a>
                </div>
                <div class="hover-effect-target d-flex align-items-end justify-content-end h-100 overflow-hidden rounded-5">
                  <div class="position-relative z-1 rtl-flip">
                    <img src="/assets/img/intro/demos/electronics-light.png" class="hover-effect-target d-none-dark" width="540" alt="Electronics Store">
                    <img src="/assets/img/intro/demos/electronics-dark.png" class="hover-effect-target d-none d-block-dark" width="540" alt="Electronics Store">
                  </div>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark" style="background-color: #ccdff5;"></span>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark" style="background-color: #212c3d;"></span>
                </div>
              </div>

              <!-- Fashion store v.2 -->
              <div class="hover-effect-scale ratio" id="fashion-2" style="--cz-transform-scale: 1.03; --cz-transition-duration: .3s">
                <div class="nav flex-column position-absolute top-0 start-0 w-100 h-100 z-2 pt-4 pt-xl-5 px-4 ps-xl-5 mt-lg-2 ms-lg-2 m-xl-0">
                  <h2 class="h3 d-none d-lg-block pb-2 mb-1">Fashion Store v.2</h2>
                  <h2 class="h4 d-lg-none mb-2">Fashion Store v.2</h2>
                  <p class="fs-xs mb-2 mb-xl-3 d-none d-sm-block d-md-none d-lg-block" style="max-width: 250px">Unleash your style with our versatile and affordable fashion finds.</p>
                  <a class="nav-link animate-underline stretched-link text-dark-emphasis py-1 px-0" href="home-fashion-v2.html">
                    <span class="animate-target">View demo</span>
                    <i class="ci-chevron-right fs-base mt-1 ms-1"></i>
                  </a>
                </div>
                <div class="hover-effect-target d-flex align-items-end justify-content-end h-100 overflow-hidden rounded-5">
                  <div class="position-relative z-1 rtl-flip">
                    <img src="/assets/img/intro/demos/fashion-2-light.png" class="hover-effect-target d-none-dark" width="466" alt="Fashion Store v.2">
                    <img src="/assets/img/intro/demos/fashion-2-dark.png" class="hover-effect-target d-none d-block-dark" width="466" alt="Fashion Store v.2">
                  </div>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none-dark" style="background-color: #f3eef3;"></span>
                  <span class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark" style="background-color: #35313a;"></span>
                </div>
              </div>
            </div>
          </div>
        </section>


        <!-- Front-end solution -->
        <section class="container py-5 mt-2 mb-3 my-sm-3 my-md-4 my-lg-5">
          <h2 class="h1 text-center pt-xl-4 mt-xxl-2">Complete E-Commerce Front-end Solution</h2>
          <p class="fs-lg text-center pb-4 pb-md-5 mb-0 mb-lg-2 mb-xl-4">All you need for your next e-commerce project</p>
          <div class="row align-items-center justify-content-center pb-xl-4 mb-xxl-2">
            <div class="col-10 col-sm-8 col-md-6 order-md-2 pb-4 pb-md-0 mb-3 mb-md-0">
              <div class="position-relative w-100 mx-auto" style="max-width: 533px">
                <div class="ratio" style="--cz-aspect-ratio: calc(383 / 533 * 100%)"></div>
                <div class="position-absolute ratio ratio-1x1 z-2 bg-primary rounded-5" style="top: 41%; right: 38%; width: 20%">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 110" fill="none"><path d="M34.183 59.818c-1.606 0-3.038-.295-4.295-.886-1.25-.591-2.242-1.405-2.977-2.443s-1.117-2.227-1.148-3.568h4.773a2.9 2.9 0 0 0 1.136 2.193c.704.561 1.542.841 2.511.841.773 0 1.455-.17 2.046-.511A3.66 3.66 0 0 0 37.626 54c.341-.621.511-1.333.511-2.136 0-.818-.174-1.538-.523-2.159-.341-.621-.814-1.106-1.42-1.455s-1.299-.526-2.08-.534c-.682 0-1.345.14-1.989.421-.636.28-1.133.663-1.489 1.148l-4.375-.784 1.102-12.273h14.227v4.023h-10.17l-.602 5.83h.136c.409-.576 1.027-1.053 1.852-1.432s1.75-.568 2.773-.568c1.401 0 2.651.33 3.75.989s1.966 1.564 2.602 2.716c.636 1.144.951 2.462.943 3.954.008 1.568-.356 2.962-1.091 4.182-.727 1.212-1.746 2.167-3.057 2.864-1.303.689-2.818 1.034-4.546 1.034zm21.25.193c-1.954-.008-3.636-.489-5.045-1.443-1.401-.955-2.481-2.337-3.239-4.148-.75-1.811-1.121-3.989-1.114-6.534 0-2.538.375-4.701 1.125-6.489.758-1.788 1.837-3.148 3.239-4.08 1.409-.939 3.087-1.409 5.034-1.409s3.621.47 5.023 1.409c1.409.939 2.492 2.303 3.25 4.091.757 1.78 1.132 3.939 1.125 6.477 0 2.553-.379 4.735-1.136 6.545-.75 1.811-1.826 3.193-3.227 4.148s-3.08 1.432-5.034 1.432zm0-4.08c1.333 0 2.398-.67 3.193-2.011s1.189-3.352 1.182-6.034c0-1.765-.182-3.235-.545-4.409-.356-1.174-.864-2.057-1.523-2.648a3.32 3.32 0 0 0-2.307-.886c-1.326 0-2.386.663-3.182 1.989s-1.197 3.311-1.204 5.955c0 1.788.178 3.28.534 4.477.364 1.189.875 2.083 1.534 2.682a3.36 3.36 0 0 0 2.318.886zm19.861.023V39.864h4.068v16.091h-4.068zm-6.011-6.011v-4.068h16.091v4.068H69.283zM39.6 79.955v-9h.972v1.04h.119l.307-.435c.133-.179.324-.338.571-.477s.588-.213 1.014-.213c.551 0 1.037.138 1.457.413a2.75 2.75 0 0 1 .984 1.172c.236.506.354 1.102.354 1.79 0 .693-.118 1.294-.354 1.803a2.79 2.79 0 0 1-.98 1.176c-.418.276-.899.413-1.445.413-.42 0-.757-.07-1.01-.209s-.447-.303-.584-.482l-.315-.452h-.085v3.46H39.6zm.989-5.727c0 .494.072.93.217 1.308s.356.669.635.882.619.315 1.023.315c.42 0 .771-.111 1.053-.332s.497-.526.639-.903.217-.804.217-1.27c0-.46-.071-.875-.213-1.244s-.351-.666-.635-.882-.635-.328-1.061-.328c-.409 0-.753.104-1.031.311s-.489.492-.631.861-.213.794-.213 1.283zm8.25 3.426a2.66 2.66 0 0 1-1.129-.234 1.94 1.94 0 0 1-.805-.686c-.199-.301-.298-.665-.298-1.091 0-.375.074-.679.222-.912s.345-.42.592-.554.52-.233.818-.298l.908-.162.967-.115c.25-.028.432-.075.545-.141s.175-.179.175-.341v-.034c0-.42-.115-.747-.345-.98s-.572-.349-1.036-.349c-.48 0-.856.105-1.129.315s-.465.435-.575.673l-.955-.341c.17-.398.398-.707.682-.929s.599-.381.938-.469.676-.136 1.006-.136a3.99 3.99 0 0 1 .724.077 2.32 2.32 0 0 1 .797.303c.259.153.473.385.644.695s.256.724.256 1.244V77.5h-1.006v-.886h-.051c-.068.142-.182.294-.341.456s-.371.3-.635.413-.587.17-.967.17zm.153-.903c.398 0 .733-.078 1.006-.234s.483-.358.622-.605a1.54 1.54 0 0 0 .213-.78v-.921c-.043.051-.136.098-.281.141s-.307.075-.494.107l-.541.077-.422.051c-.261.034-.506.09-.733.166s-.406.186-.545.337-.205.349-.205.605c0 .349.129.614.388.793s.592.264.993.264zm7.324 3.341c-.486 0-.903-.062-1.253-.187s-.641-.284-.874-.486-.413-.412-.55-.639l.801-.562a6.36 6.36 0 0 0 .345.409 1.75 1.75 0 0 0 .571.405c.244.117.564.175.959.175.528 0 .965-.128 1.308-.383s.516-.656.516-1.202V76.29h-.085c-.074.119-.179.267-.315.443s-.327.328-.579.464-.588.2-1.014.2a2.73 2.73 0 0 1-1.423-.375 2.63 2.63 0 0 1-.993-1.091c-.241-.477-.362-1.057-.362-1.739 0-.671.118-1.254.354-1.751a2.73 2.73 0 0 1 .984-1.159c.421-.276.906-.413 1.457-.413.426 0 .764.071 1.014.213s.446.298.58.477l.315.435h.102v-1.04h.972v6.733c0 .563-.128 1.02-.384 1.372s-.594.615-1.023.78-.901.251-1.423.251zm-.034-3.597c.403 0 .744-.092 1.023-.277s.49-.45.635-.797.217-.761.217-1.244a3.39 3.39 0 0 0-.213-1.249c-.142-.361-.352-.644-.631-.848s-.622-.307-1.031-.307c-.426 0-.781.108-1.065.324s-.493.506-.635.869a3.36 3.36 0 0 0-.209 1.21c0 .455.071.857.213 1.206s.358.619.639.818.636.294 1.057.294zm7.449 1.142c-.631 0-1.175-.139-1.632-.418s-.805-.673-1.053-1.176-.367-1.094-.367-1.764.122-1.261.367-1.773a2.89 2.89 0 0 1 1.031-1.202c.443-.29.96-.435 1.551-.435a3.1 3.1 0 0 1 1.01.171 2.5 2.5 0 0 1 .908.554c.273.253.49.588.652 1.006s.243.932.243 1.543v.426h-5.045v-.869h4.023c0-.369-.074-.699-.222-.989a1.67 1.67 0 0 0-.622-.686c-.267-.168-.582-.251-.946-.251-.401 0-.747.1-1.04.298a1.96 1.96 0 0 0-.669.767c-.156.315-.234.653-.234 1.014v.579c0 .494.085.913.256 1.257s.413.601.72.78a2.11 2.11 0 0 0 1.07.264c.264 0 .503-.037.716-.111a1.53 1.53 0 0 0 .558-.341c.156-.153.277-.344.362-.571l.972.273c-.102.329-.274.619-.516.869s-.54.44-.895.579-.754.205-1.197.205zm8.876-5.216l-.903.256a1.68 1.68 0 0 0-.251-.439 1.22 1.22 0 0 0-.443-.358c-.187-.094-.428-.141-.72-.141-.401 0-.734.092-1.001.277s-.396.413-.396.695c0 .25.091.448.273.592s.466.266.852.362l.972.239c.585.142 1.021.359 1.308.652s.43.663.43 1.121a1.66 1.66 0 0 1-.324 1.006c-.213.296-.511.528-.895.699s-.83.256-1.338.256c-.668 0-1.22-.145-1.658-.435s-.715-.713-.831-1.27l.954-.239c.091.352.263.617.516.793s.59.264 1.001.264c.469 0 .841-.099 1.116-.298s.418-.443.418-.724a.76.76 0 0 0-.239-.571c-.159-.156-.403-.273-.733-.349l-1.091-.256c-.599-.142-1.04-.362-1.321-.66s-.418-.678-.418-1.129a1.62 1.62 0 0 1 .311-.98c.21-.284.496-.507.856-.669s.776-.243 1.236-.243c.648 0 1.156.142 1.526.426s.636.659.793 1.125z" fill="#fff"/></svg>
                </div>
                <img src="/assets/img/intro/pages-light.jpg" class="position-absolute top-0 start-0 w-100 h-100 d-none-dark" alt="E-Commerce Front-end">
                <img src="/assets/img/intro/pages-dark.png" class="position-absolute top-0 start-0 w-100 h-100 d-none d-block-dark" alt="E-Commerce Front-end">
              </div>
            </div>
            <div class="col-sm-9 col-md-6 col-lg-5 offset-lg-1 order-md-1">
              <ul class="list-unstyled gap-3 mb-0">
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Multiple Shop Layout Options</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Multiple Product Page Variations</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Complete Order Workflow: Cart + Checkout</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Shop Customer Account Pages</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Dashboard (CMS) Pages <span class="fs-sm text-body-tertiary">(Coming soon)</span></span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Electronics, Fashion, Grocery and Furniture Demos</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Blog Pages: Blog Layouts + Single Articles</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Help Center / Support Pages</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>Secondary Pages: About, Contacts, 404, etc.</span>
                </li>
                <li class="d-flex">
                  <svg class="text-primary mt-2 me-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none"><circle cx="5" cy="5" r="4.125" stroke="currentColor" stroke-width="1.75"/></svg>
                  <span>60+ Flexible Components (UI Kit)</span>
                </li>
              </ul>
            </div>
          </div>
        </section>


        <!-- Light / Dark mode (Comparison slider) -->
        <section class="d-flex w-100 position-relative overflow-hidden">
          <div class="position-relative flex-xxl-shrink-0 z-2 start-50 translate-middle-x my-n2" style="max-width: 1920px;">
            <div class="mx-n2 mx-sm-n5 mx-xxl-0">
              <div class="mx-lg-n5 mx-xxl-0">
                <img-comparison-slider class="focus-none text-primary mx-n5 mx-xxl-0" style="--divider-width: .125rem; --divider-color: currentColor">
                  <img slot="first" src="/assets/img/intro/dark-mode.jpg" alt="Dark Mode">
                  <img slot="second" src="/assets/img/intro/light-mode.jpg" alt="Light Mode">
                  <div slot="handle" style="width: 42px;">
                    <svg class="text-primary rounded-circle" width="42" height="42" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg">
                      <g>
                        <circle fill="currentColor" cx="21" cy="21" r="21"></circle>
                      </g>
                      <path fill="white" d="M25.5019 19.7494H15.9147V15.9146L11.1211 20.7081L15.9147 25.5017V21.6669H25.5019V25.5017L30.2955 20.7081L25.5019 15.9146V19.7494Z"></path>
                    </svg>
                  </div>
                </img-comparison-slider>
              </div>
            </div>
          </div>
          <div class="position-absolute top-0 start-0 w-50 h-100" style="background-color: #131920"></div>
          <div class="position-absolute top-0 end-0 w-50 h-100" style="background-color: #f5f7fa"></div>
        </section>


        <!-- Features -->
        <section class="container py-5 mt-2 mb-sm-2 mt-sm-3 my-md-4 my-lg-5">
          <h2 class="h1 text-center pb-3 pb-sm-4 pb-lg-2 pb-xl-3 pt-xl-4 mt-xxl-2 mb-lg-5">Cartzilla Feature Highlights</h2>
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 g-lg-5 pb-xl-2 pb-xxl-4">
            <div class="col text-center">
              <img src="/assets/img/intro/features/bootstrap.png" width="56" class="d-inline-flex mb-3" alt="Bootstrap">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Built with Latest Bootstrap</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Cartzilla is the powerful e-commerce front-end solution based on Bootstrap 5 - the world's most popular responsive, mobile-first front-end component library.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/sass.png" width="48" class="d-inline-flex mb-3" alt="Sass">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Easy to Customize with Sass</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Cartzilla is built using Sass, allowing for effortless customization of colors, typography, and beyond. It is the most mature, stable, and powerful CSS extension language in the world.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/npm.png" width="56" class="d-inline-flex mb-3" alt="Npm">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Kick-start Your Development</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Start your development process fast and easy with included Npm scripts setup, full tasks automation and local server hot reload. The configuration files are included in the download package.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/js.png" width="48" class="d-inline-flex mb-3" alt="JavaScript">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Future-proof JavaScript</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Cartzilla's core scripts, along with all dependencies, are meticulously crafted in vanilla JS (ES6 modules), ensuring optimal performance and compatibility across various platforms.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/html5.png" width="48" class="d-inline-flex mb-3" alt="HTML5">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">W3C Valid HTML Code</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">As you likely know, ensuring 100% valid code through W3C validation for all HTML files is crucial. Invalid HTML imposes restrictions on innovation, yet Cartzilla remains innovative at its core.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/figma.png" width="48" class="d-inline-flex mb-3" alt="Figma">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Premium Figma File Included</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">A well-crafted Figma design file is included in the download package. It offers a visually stunning and thoroughly organized layout, utilizing Figma's components and styles.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/touch.png" width="48" class="d-inline-flex mb-3" alt="Touch UI">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Touch-enabled Sliders</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">In the era of touch screens it is important to ensure great user experience on handheld devices, especially when it comes to such frequently used interface component as slider.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/google-fonts.png" width="48" class="d-inline-flex mb-3" alt="Google Fonts">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Google Fonts</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Cartzilla uses preloaded variable Google font (Inter) which is free, fast to load and of very high quality. Currently Google fonts library includes 1600+ font families to choose from.</p>
            </div>
            <div class="col text-center">
              <img src="/assets/img/intro/features/vector.png" width="48" class="d-inline-flex mb-3" alt="Vector Icons">
              <h3 class="h5 pt-sm-1 pb-2 mb-1">Vector Based HD-ready Icons</h3>
              <p class="mb-2 mb-sm-3 mb-lg-0">Cartzilla is equiped with font-based icon pack and svg icons to ensure that infographics and interface icons look sharp on any device with any screen resolution and pixel density.</p>
            </div>
          </div>
        </section>


        <!-- Mobile friendly (PWA) -->
        <section class="position-relative">
          <div class="bg-body-tertiary position-absolute top-50 start-0 w-100 translate-middle-y overflow-hidden d-none d-xl-block" style="height: 78%;">
            <div class="bg-white opacity-75 d-none-dark" style="width: 699px; height: 728px; border-radius: 728px; filter: blur(151px)"></div>
            <div class="bg-body opacity-75 d-none d-block-dark" style="width: 699px; height: 728px; border-radius: 728px; filter: blur(151px)"></div>
          </div>
          <div class="bg-body-tertiary position-absolute top-0 start-0 w-100 h-100 overflow-hidden d-xl-none">
            <div class="position-absolute ps-xl-4 ms-xxl-5 mt-n2">
              <div class="bg-white opacity-75 d-none-dark" style="width: 699px; height: 728px; border-radius: 728px; filter: blur(151px)"></div>
              <div class="bg-body opacity-75 d-none d-block-dark" style="width: 699px; height: 728px; border-radius: 728px; filter: blur(151px)"></div>
            </div>
          </div>
          <div class="container position-relative z-2 pb-5 pt-4 pt-md-5 py-xl-0">
            <div class="row align-items-center justify-content-center pb-2 pb-sm-3 pb-md-0">
              <div class="col-9 col-sm-7 col-md-6 mb-3 mb-sm-4 mb-md-0">
                <div class="ratio rtl-flip" style="max-width: 585px; --cz-aspect-ratio: calc(821 / 585 * 100%);">
                  <img src="/assets/img/intro/mobile-light.png" class="d-none-dark" alt="Mobile screens">
                  <img src="/assets/img/intro/mobile-dark.png" class="d-none d-block-dark" alt="Mobile screens">
                </div>
              </div>
              <div class="col-md-6 col-xl-5 offset-xl-1 text-center">
                <div class="ps-4 ps-xl-0">
                  <h2 class="h1">Mobile Friendly Interface. PWA ready</h2>
                  <p class="fs-lg mb-4">Cartzilla ensures seamless interactions across all devices. With progressive web app (PWA) compatibility, users can enjoy the app-like experiences on their mobile browsers.</p>
                  <p class="fs-sm fw-medium text-body-emphasis mb-4">Scan QR code below to test on your device:</p>
                  <img src="/assets/img/intro/qr-light.png" class="d-none-dark rtl-flip" width="120" alt="QR code">
                  <img src="/assets/img/intro/qr-dark.png" class="d-none d-inline-block-dark rtl-flip" width="120" alt="QR code">
                </div>
              </div>
            </div>
          </div>
        </section>


        <!-- Customizer -->
        <section class="container pt-5 pb-4 pb-sm-5 my-2 mt-md-3 mt-xxl-4 mb-sm-0 mb-lg-4 mb-xl-5">
          <h2 class="h1 text-center pt-lg-3 pt-xl-0 pb-md-2 pb-lg-3 pb-xl-4">Theme Customizer</h2>

          <!-- Colors -->
          <div class="row align-items-center justify-content-center py-4">
            <div class="col-9 col-sm-7 col-md-6 order-md-2 offset-lg-1">
              <div class="ratio" style="max-width: 593px; --cz-aspect-ratio: calc(542 / 593 * 100%)">
                <img src="/assets/img/intro/customizer/colors-light.jpg" class="d-none-dark" alt="Colors">
                <img src="/assets/img/intro/customizer/colors-dark.png" class="d-none d-block-dark" alt="Colors">
              </div>
            </div>
            <div class="col-md-6 col-lg-5 order-md-1 text-center text-md-start mt-3 mt-md-n5">
              <span class="badge fs-sm bg-primary-subtle text-primary mb-3 mb-md-4">Colors</span>
              <h2 class="h3 mb-md-4">Change theme brand colors quickly and easily</h2>
              <p class="mb-0">Customize theme colors to match your brand palette using the color picker or just type in the color hex. Supported colors: primary, warning, success, info, danger.</p>
            </div>
          </div>

          <hr class="d-md-none my-3 my-sm-4">

          <!-- Typography -->
          <div class="row align-items-center justify-content-center py-4">
            <div class="col-10 col-sm-7 col-md-6 col-lg-7">
              <div class="ratio" style="max-width: 668px; --cz-aspect-ratio: calc(510 / 668 * 100%)">
                <img src="/assets/img/intro/customizer/typography-light.jpg" class="d-none-dark" alt="Typography">
                <img src="/assets/img/intro/customizer/typography-dark.png" class="d-none d-block-dark" alt="Typography">
              </div>
            </div>
            <div class="col-md-6 col-lg-5 text-center text-md-start mt-3 mt-md-n5">
              <span class="badge fs-sm bg-info-subtle text-info mb-3 mb-md-4">Typography</span>
              <h2 class="h3 mb-md-4">Set up fonts from the huge Google font collection</h2>
              <p class="mb-0">Easily change the font to your liking. Choose the font from Google Fonts library of 1,600+ open source font families. Update headings and body font sizes right from customizer.</p>
            </div>
          </div>

          <hr class="d-md-none my-3 my-sm-4">

          <!-- Borders -->
          <div class="row align-items-center justify-content-center py-4">
            <div class="col-10 col-sm-7 col-md-6 col-lg-7 order-md-2 d-flex justify-content-end">
              <div class="ratio" style="max-width: 668px; --cz-aspect-ratio: calc(428 / 668 * 100%)">
                <img src="/assets/img/intro/customizer/borders-light.jpg" class="d-none-dark" alt="Borders">
                <img src="/assets/img/intro/customizer/borders-dark.png" class="d-none d-block-dark" alt="Borders">
              </div>
            </div>
            <div class="col-md-6 col-lg-5 order-md-1 text-center text-md-start mt-4 mt-md-0">
              <span class="badge fs-sm bg-success-subtle text-success mb-3 mb-md-4">Borders</span>
              <h2 class="h3 mb-md-4">Rounded or square? Customize borders as you wish</h2>
              <p class="mb-0">It's up to you to make your website soft and friendly with increased border radius or add business vibes with less rounded shapes. Additionally, you can adjust the border width.</p>
            </div>
          </div>
        </section>
      </main>


      <!-- Page footer -->
      <footer class="footer pt-xxl-2">
        <div class="container">
          <div class="position-relative py-5 px-4 p-sm-5">
            <div class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background: linear-gradient(102deg, #dad4ec 0%, #f3e7e9 80.43%);"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background: linear-gradient(102deg, #38314b 0%, #3f353a 100%);"></div>
            <div class="position-relative z-1 text-center py-md-3 my-lg-3">
              <p class="fs-xl pb-2 mb-1">Still not convinced?</p>
              <h2 class="pb-2 pb-sm-3">Add premium support and lifetime updates to this.</h2>
              <a class="btn btn-lg btn-primary animate-slide-end" href="https://themes.getbootstrap.com/product/cartzilla-bootstrap-e-commerce-template-ui-kit/" target="_blank" rel="noreferrer">
                <i class="ci-shopping-cart fs-base animate-target ms-n1 me-2"></i>
                Buy now
              </a>
            </div>
          </div>
          <div class="fs-sm text-center py-4 py-lg-5 my-sm-2 my-md-3 my-lg-0">
            &copy; All rights reserved. Made by <span class="animate-underline"><a class="animate-target text-dark-emphasis text-decoration-none" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></span>
          </div>
        </div>
      </footer>


      <!-- Back to top button -->
      <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
        <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
          Top
          <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
          <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
          <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"/>
          </svg>
        </a>
      </div>
</x-theme>
