@extends('jiny-site::layouts.about')

@section('title', '회사 연혁')

@push('head')
<style>
    /* Main timeline container */
    .timeline-wrapper {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline:before {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 24px;
        width: 3px;
        content: "";
        background: linear-gradient(to bottom, #3b82f6, #1e40af);
        border-radius: 2px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
    }

    /* Year sections */
    .year-section {
        margin-bottom: 5rem;
        position: relative;
    }

    .year-header {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 3rem;
        text-align: center;
        position: relative;
        padding: 1rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .year-header:before {
        content: "";
        position: absolute;
        top: 50%;
        left: -40px;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: #3b82f6;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0 0 3px #3b82f6, 0 4px 8px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    /* Year divider */
    .year-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #9ca3af, transparent);
        margin: 4rem 0;
        position: relative;
    }

    .year-divider:before {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 12px;
        height: 12px;
        background: #9ca3af;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #9ca3af;
    }

    /* Timeline items */
    .timeline-item {
        position: relative;
        margin-bottom: 3rem;
        padding-left: 70px;
        opacity: 0;
        transform: translateX(-30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .timeline-item:nth-child(even) {
        animation-delay: 0.1s;
    }

    .timeline-item:nth-child(odd) {
        animation-delay: 0.2s;
    }

    .timeline-item:before {
        content: "";
        position: absolute;
        top: 12px;
        left: 13px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: 4px solid #fff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3), 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 10;
        transition: all 0.3s ease;
    }

    .timeline-item:hover:before {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.4), 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Timeline content */
    .timeline-content {
        background: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
    }

    .timeline-content:before {
        content: "";
        position: absolute;
        left: -8px;
        top: 20px;
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 8px solid #fff;
    }

    .timeline-content:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #6366f1;
        margin-bottom: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        background: rgba(99, 102, 241, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
    }

    .timeline-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #1e293b;
        line-height: 1.4;
    }

    .timeline-subtitle {
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
        margin: 0;
    }

    /* Animation */
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .timeline-wrapper {
            max-width: 100%;
            padding: 0 1rem;
        }

        .timeline:before {
            left: 18px;
            width: 2px;
        }

        .timeline-item {
            padding-left: 55px;
            margin-bottom: 2.5rem;
        }

        .timeline-item:before {
            left: 8px;
            width: 18px;
            height: 18px;
            top: 10px;
        }

        .timeline-content {
            padding: 1.25rem;
        }

        .timeline-content:before {
            left: -6px;
            top: 16px;
            border-right-width: 6px;
            border-top-width: 6px;
            border-bottom-width: 6px;
        }

        .year-header {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding: 0.75rem;
        }

        .year-header:before {
            left: -30px;
            width: 16px;
            height: 16px;
            border-width: 3px;
        }

        .timeline-title {
            font-size: 1.1rem;
        }

        .timeline-date {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .timeline-item {
            padding-left: 45px;
        }

        .timeline-item:before {
            left: 6px;
            width: 14px;
            height: 14px;
        }

        .timeline:before {
            left: 13px;
        }

        .year-header:before {
            left: -25px;
            width: 12px;
            height: 12px;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="about-page-header">
    <h1 class="about-page-title">회사 연혁</h1>
    <p class="about-page-description">혁신과 성장으로 이어온 우리의 발자취를 소개합니다.</p>


@if($histories->count() > 0)
    <div class="timeline-wrapper">
        <!-- Timeline by Year -->
        @if(isset($historiesByYear) && $historiesByYear->count() > 0)
            @foreach($historiesByYear->sortKeysDesc() as $year => $yearHistories)
                <div class="year-section">
                    <h2 class="year-header">{{ $year }}</h2>

                    <div class="timeline">
                        @foreach($yearHistories->sortBy('sort_order')->sortByDesc('event_date') as $history)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-date">
                                        {{ $history->event_date ? date('m.d', strtotime($history->event_date)) : '' }}
                                    </div>

                                    <h3 class="timeline-title">{{ $history->title ?? 'Untitled' }}</h3>

                                    @if(!empty($history->subtitle))
                                        <div class="timeline-subtitle">
                                            {!! nl2br(e($history->subtitle)) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Year Divider (except for the last year) -->
                @if(!$loop->last)
                    <div class="year-divider"></div>
                @endif
            @endforeach
        @endif
    </div>
@else
    <!-- Empty State -->
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-clock-history display-1 text-muted"></i>
        </div>
        <h3 class="text-muted mb-3">등록된 연혁이 없습니다</h3>
        <p class="text-muted">곧 회사의 소중한 역사를 공유하겠습니다.</p>
    </div>
@endif

</div>
@endsection

@push('about-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
