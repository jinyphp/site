<!-- Gallery Section -->
<section class="py-8 bg-white">
    <div class="container my-lg-4">
        <!-- Gallery Grid -->
        <div class="gallery mb-8">
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--1 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-1.jpg') }}" alt="팀워크"
                    class="gallery__img rounded-3">
            </figure>
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--2 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-2.jpg') }}" alt="협업"
                    class="gallery__img rounded-3">
            </figure>
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--3 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-3.jpg') }}" alt="혁신"
                    class="gallery__img rounded-3">
            </figure>
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--4 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-4.jpg') }}" alt="성장"
                    class="gallery__img rounded-3">
            </figure>
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--5 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-5.jpg') }}" alt="성과"
                    class="gallery__img rounded-3">
            </figure>
            <!-- gallery-item -->
            <figure class="gallery__item gallery__item--6 mb-0">
                <img src="{{ asset('assets/images/about/geeksui-img-6.jpg') }}" alt="미래"
                    class="gallery__img rounded-3">
            </figure>
        </div>
    </div>
</section>

<style>
    /* Gallery Grid CSS */
    .gallery {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        grid-template-rows: repeat(8, 5vw);
        grid-gap: 15px;
    }

    .gallery__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery__item--1 {
        grid-column-start: 1;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 3;
    }

    .gallery__item--2 {
        grid-column-start: 3;
        grid-column-end: 5;
        grid-row-start: 1;
        grid-row-end: 3;
    }

    .gallery__item--3 {
        grid-column-start: 5;
        grid-column-end: 9;
        grid-row-start: 1;
        grid-row-end: 6;
    }

    .gallery__item--4 {
        grid-column-start: 1;
        grid-column-end: 5;
        grid-row-start: 3;
        grid-row-end: 6;
    }

    .gallery__item--5 {
        grid-column-start: 1;
        grid-column-end: 5;
        grid-row-start: 6;
        grid-row-end: 9;
    }

    .gallery__item--6 {
        grid-column-start: 5;
        grid-column-end: 9;
        grid-row-start: 6;
        grid-row-end: 9;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .gallery {
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(12, 8vw);
        }

        .gallery__item--1 {
            grid-column: 1 / 3;
            grid-row: 1 / 3;
        }

        .gallery__item--2 {
            grid-column: 3 / 5;
            grid-row: 1 / 3;
        }

        .gallery__item--3 {
            grid-column: 1 / 5;
            grid-row: 3 / 6;
        }

        .gallery__item--4 {
            grid-column: 1 / 3;
            grid-row: 6 / 8;
        }

        .gallery__item--5 {
            grid-column: 3 / 5;
            grid-row: 6 / 8;
        }

        .gallery__item--6 {
            grid-column: 1 / 5;
            grid-row: 8 / 11;
        }
    }
</style>