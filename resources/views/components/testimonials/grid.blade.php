{{-- Testimonials Grid Component --}}
@props([
    'testimonials' => collect(),
    'title' => 'The reviews speak for themselves',
    'subtitle' => 'From critical skills to technical topics, our platform supports your professional development.',
    'showRating' => true,
    'showLikes' => true,
    'showControls' => false,
    'columns' => 3,
    'limit' => null,
    'featured' => null
])

@php
    // Filter testimonials if needed
    if ($featured !== null) {
        $testimonials = $testimonials->where('featured', $featured);
    }

    // Limit testimonials if specified
    if ($limit) {
        $testimonials = $testimonials->take($limit);
    }

    // Calculate average rating
    $averageRating = $testimonials->avg('rating') ?: 0;
    $totalCount = $testimonials->count();

    // Determine grid classes
    $gridClass = match($columns) {
        2 => 'col-lg-6',
        3 => 'col-lg-4',
        4 => 'col-lg-3',
        default => 'col-lg-4'
    };
@endphp

<section class="testimonials-section py-5">
    <div class="container">
        <!-- Header -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 mb-3">{{ $title }}</h2>
                <p class="lead text-muted">{{ $subtitle }}</p>

                @if($showRating && $totalCount > 0)
                    <div class="rating-summary mt-4">
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <div class="stars me-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="h5 mb-0 me-2">{{ number_format($averageRating, 1) }}/5</span>
                            <span class="text-primary">{{ number_format($totalCount) }}+ reviews</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Testimonials Grid -->
        @if($testimonials->count() > 0)
            <div class="row">
                @foreach($testimonials as $testimonial)
                    <div class="{{ $gridClass }} mb-4">
                        <div class="testimonial-card card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <!-- Rating -->
                                @if($showRating)
                                    <div class="rating mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2 small text-muted">{{ $testimonial->rating }}/5</span>
                                    </div>
                                @endif

                                <!-- Headline -->
                                <h5 class="testimonial-headline mb-3">{{ $testimonial->headline }}</h5>

                                <!-- Content -->
                                <p class="testimonial-content text-muted mb-4">
                                    "{{ Str::limit($testimonial->content, 150) }}"
                                </p>

                                <!-- Author Info -->
                                <div class="author-info d-flex align-items-center">
                                    @if($testimonial->avatar)
                                        <img src="{{ $testimonial->avatar }}"
                                             alt="{{ $testimonial->name }}"
                                             class="author-avatar rounded-circle me-3"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="author-avatar rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                             style="width: 50px; height: 50px;">
                                            <i class="fe fe-user text-muted"></i>
                                        </div>
                                    @endif

                                    <div class="author-details">
                                        <h6 class="author-name mb-0">{{ $testimonial->name }}</h6>
                                        @if($testimonial->title || $testimonial->company)
                                            <small class="author-title text-muted">
                                                @if($testimonial->title){{ $testimonial->title }}@endif
                                                @if($testimonial->title && $testimonial->company), @endif
                                                @if($testimonial->company){{ $testimonial->company }}@endif
                                            </small>
                                        @endif
                                        @if($testimonial->verified)
                                            <span class="badge bg-success badge-sm mt-1">인증됨</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                @if($showLikes || $showControls)
                                    <div class="testimonial-actions mt-3 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($showLikes)
                                                <button type="button"
                                                        class="btn btn-link btn-sm p-0 like-btn"
                                                        data-testimonial-id="{{ $testimonial->id }}">
                                                    <i class="fe fe-heart me-1"></i>
                                                    <span class="likes-count">{{ number_format($testimonial->likes_count) }}</span>
                                                </button>
                                            @endif

                                            @if($showControls)
                                                <div class="controls">
                                                    <!-- Add any additional controls here -->
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Featured Badge -->
                                @if($testimonial->featured)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-warning">추천</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fe fe-message-square text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">아직 후기가 없습니다</h4>
                        <p class="text-muted">첫 번째 리뷰를 남겨보세요!</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.testimonial-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.testimonial-headline {
    color: #2c3e50;
    font-weight: 600;
}

.testimonial-content {
    line-height: 1.6;
}

.author-name {
    color: #2c3e50;
    font-weight: 600;
}

.author-title {
    color: #6c757d;
}

.rating .fas.fa-star,
.rating .fas.fa-star-half-alt {
    color: #ffc107;
}

.rating .far.fa-star {
    color: #e9ecef;
}

.like-btn {
    color: #6c757d;
    transition: color 0.3s ease;
}

.like-btn:hover {
    color: #dc3545;
}

.like-btn.liked {
    color: #dc3545;
}

.rating-summary {
    font-size: 1.1em;
}

@media (max-width: 768px) {
    .testimonial-card {
        margin-bottom: 2rem;
    }

    .rating-summary {
        font-size: 1em;
    }
}
</style>
@endpush

@if($showLikes)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle like buttons
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const testimonialId = this.dataset.testimonialId;
            const likesCountElement = this.querySelector('.likes-count');
            const heartIcon = this.querySelector('.fe-heart');

            fetch(`/testimonials/${testimonialId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.liked) {
                    this.classList.add('liked');
                    heartIcon.classList.remove('fe-heart');
                    heartIcon.classList.add('fe-heart');
                } else {
                    this.classList.remove('liked');
                    heartIcon.classList.remove('fe-heart');
                    heartIcon.classList.add('fe-heart');
                }

                likesCountElement.textContent = data.likes_count.toLocaleString();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endpush
@endif