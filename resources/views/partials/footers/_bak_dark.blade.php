<footer class="footer bg-dark-stable py-8">
  <div class="container">
    <div class="row gy-6 gy-xl-0 pb-8">
      <div class="col-xl-3 col-lg-12 col-md-6 col-12">
        <div class="d-flex flex-column gap-4">
          <div>
            <img src="{{ asset('assets/images/svg/geeks-logo.svg') }}" alt="geeks logo" />
          </div>
          <p class="mb-0">Nascetur nibh feugiat vulputate urna mauris tincidunt porttitor ultricies. Et dis augue praesent congue.</p>
          <div class="d-flex gap-2">
            <a href="#languageModal" class="btn btn-outline-secondary" data-bs-toggle="modal">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                  <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                </svg>
              </span>
              <span class="ms-2">English</span>
            </a>
            <div class="dropdown">
              <button
                class="btn btn-outline-secondary btn-icon rounded-circle d-flex align-items-center"
                type="button"
                aria-expanded="false"
                data-bs-toggle="dropdown"
                aria-label="Toggle theme (auto)">
                <i class="bi theme-icon-active"></i>
                <span class="visually-hidden bs-theme-text">Toggle theme</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text" data-bs-theme="dark">
                <li>
                  <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <i class="bi theme-icon bi-sun-fill"></i>
                    <span class="ms-2">Light</span>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <i class="bi theme-icon bi-moon-stars-fill"></i>
                    <span class="ms-2">Dark</span>
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <i class="bi theme-icon bi-circle-half"></i>
                    <span class="ms-2">Auto</span>
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-6">
        <div class="d-flex flex-column gap-3">
          <span class="text-white-stable">Company</span>
          <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
            <li>
              <a href="#!" class="nav-link">About us</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Contact us</a>
            </li>
            <li>
              <a href="#!" class="nav-link">News and Blogs</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Career</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Investors</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-6">
        <div class="d-flex flex-column gap-3">
          <span class="text-white-stable">Community</span>
          <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
            <li>
              <a href="#!" class="nav-link">Help and Support</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Affiliate</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Blog</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Jiny Business</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-xl-2 col-md-3 col-12">
        <div class="d-flex flex-column gap-3">
          <span class="text-white-stable">Teaching</span>
          <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
            <li>
              <a href="#!" class="nav-link">Become a teacher</a>
            </li>
            <li>
              <a href="#!" class="nav-link">How to guide</a>
            </li>
            <li>
              <a href="#!" class="nav-link">Documentation</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-6 col-12">
        <div class="d-flex flex-column gap-5">
          <div class="d-flex flex-column gap-3">
            <span class="text-white-stable">Contact</span>
            <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
              <li>
                Toll free:
                <span class="fw-semibold">+1234 567 890</span>
              </li>
              <li>
                Time:
                <span class="fw-semibold">9AM to 8:PM IST</span>
              </li>
              <li>
                Email:
                <span class="fw-semibold">example@gmail.com</span>
              </li>
            </ul>
          </div>
          <div class="d-flex flex-row gap-2">
            <a href="#"><img src="{{ asset('assets/images/svg/appstore.svg') }}" alt="" class="img-fluid" /></a>
            <a href="#"><img src="{{ asset('assets/images/svg/playstore.svg') }}" alt="" class="img-fluid" /></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row align-items-center g-0 border-top border-gray-800 pt-3 flex-column gap-1 flex-lg-row gap-lg-0">
      <!-- Desc -->
      <div class="col-lg-6 col-12 text-center text-md-start">
        <span>
          ©
          <span id="copyright">
            <script>
              document.getElementById("copyright").appendChild(document.createTextNode(new Date().getFullYear()));
            </script>
          </span>
          JinyTheme. Powered Codescandy
        </span>
      </div>
      <!-- Links -->
      <div class="col-12 col-lg-6">
        <nav class="nav nav-footer justify-content-center justify-content-md-start justify-content-lg-end">
          <a class="nav-link active" href="#!">Terms of use</a>
          <a class="nav-link" href="#!">Cookies Settings</a>
          <a class="nav-link" href="#!">Privacy policy</a>
        </nav>
      </div>
    </div>
  </div>
</footer>
