{{-- Hero section sample --}}
<section class="hero bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1>{{ $title ?? "Sample Hero Title" }}</h1>
                <p class="lead">{{ $description ?? "This is a sample hero section." }}</p>
                <a href="{{ $link ?? "#" }}" class="btn btn-light btn-lg">{{ $button_text ?? "Get Started" }}</a>
            </div>
        </div>
    </div>
</section>
