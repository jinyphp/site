@extends('jiny-site::layouts.app')

@section('title', 'Course Lead | Geeks - Bootstrap 5 Template')

@push('styles')
    <link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/landings/course-lead.html" />
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/dist/css/glightbox.min.css') }}" />
@endpush

@section('content')
    @includeIf('jiny-site::www.blocks.hero01_main')
    @includeIf('jiny-site::www.blocks.hero01_features')
    @includeIf('jiny-site::www.blocks.hero01_description')
    @includeIf('jiny-site::www.blocks.hero01_instructor')
    @includeIf('jiny-site::www.blocks.hero01_brands')
    @includeIf('jiny-site::www.blocks.hero01_testimonials')
    @includeIf('jiny-site::www.blocks.hero01_faq')
    @includeIf('jiny-site::www.blocks.hero01_cta')
    </main>

    <!-- Course Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 align-items-lg-center">
                    <div class="d-lg-flex">
                        <div class="mb-3 mb-lg-0">
                            <img src="@@webRoot/assets/images/svg/feature-icon-1.svg" alt=""
                                class="bg-primary icon-shape icon-xxl rounded-circle" />
                        </div>
                        <div class="ms-lg-4">
                            <h2 class="fw-bold mb-md-1 mb-3">
                                Introduction to JavaScript
                                <span class="badge bg-warning ms-2">Free</span>
                            </h2>
                            <p class="text-uppercase fs-6 fw-semibold mb-0">
                                <span class="text-dark">Courses - 1</span>
                                <span class="ms-3">6 Lessons</span>
                                <span class="ms-3">1 Hour 12 Min</span>
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>In this course you will learn:</h3>
                    <p class="fs-4">Vanilla JS is a fast, lightweight, cross-platform framework for building incredible,
                        powerful JavaScript applications.</p>
                    <ul class="list-group list-group-flush">
                        <!-- List group item -->
                        <li class="list-group-item ps-0">
                            <a href="#" class="d-flex justify-content-between align-items-center text-inherit">
                                <div class="text-truncate">
                                    <span class="icon-shape bg-light text-primary icon-sm rounded-circle me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-play-fill text-primary" viewBox="0 0 16 16">
                                            <path
                                                d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span>Introduction</span>
                                </div>
                                <div class="text-truncate">
                                    <span>1m 7s</span>
                                </div>
                            </a>
                        </li>
                        <!-- List group item -->
                        <li class="list-group-item ps-0">
                            <a href="#" class="d-flex justify-content-between align-items-center text-inherit">
                                <div class="text-truncate">
                                    <span class="icon-shape bg-light text-primary icon-sm rounded-circle me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-play-fill text-primary" viewBox="0 0 16 16">
                                            <path
                                                d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span>Installing Development Software</span>
                                </div>
                                <div class="text-truncate">
                                    <span>3m 11s</span>
                                </div>
                            </a>
                        </li>
                        <!-- List group item -->
                        <li class="list-group-item ps-0">
                            <a href="#" class="d-flex justify-content-between align-items-center text-inherit">
                                <div class="text-truncate">
                                    <span class="icon-shape bg-light text-primary icon-sm rounded-circle me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-play-fill text-primary" viewBox="0 0 16 16">
                                            <path
                                                d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span>Hello World Project from GitHub</span>
                                </div>
                                <div class="text-truncate">
                                    <span>2m 33s</span>
                                </div>
                            </a>
                        </li>
                        <!-- List group item -->
                        <li class="list-group-item ps-0">
                            <a href="#" class="d-flex justify-content-between align-items-center text-inherit">
                                <div class="text-truncate">
                                    <span class="icon-shape bg-light text-primary icon-sm rounded-circle me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-play-fill text-primary" viewBox="0 0 16 16">
                                            <path
                                                d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span>Our Sample Javascript Files</span>
                                </div>
                                <div class="text-truncate">
                                    <span>22m 30s</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/libs/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/glight.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
@endpush
