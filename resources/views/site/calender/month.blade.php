<div>
    <style>
        .calendar-header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .month-title {
            font-size: 1.1rem;
            /* font-weight: bold; */
        }

        .month-nav-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #ddd;
            border: 1px solid #ddd;
        }

        .calendar-header-cell,
        .calendar-day {
            background-color: #fff;
            padding: 0.5rem;
            text-align: center;
        }

        .calendar-header-cell {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 1rem 0.5rem;
        }

        .calendar-day {
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0.5rem;
        }

        .other-month {
            color: #ccc !important;
        }

        .today {
            background-color: #e3f2fd;
            font-weight: bold;
        }

        .sun,
        th.sun {
            color: #ff0000;
        }

        .sat,
        th.sat {
            color: #0066cc;
        }

        .day-name {
            font-size: 0.8em;
            color: #666;
            margin-top: 0.2rem;
        }

        @media (max-width: 640px) {
            .calendar-day {
                height: 60px;
                font-size: 0.875rem;
            }

            .month-title {
                font-size: 1.25rem;
            }
        }
    </style>

    {{-- 달력 헤더 --}}
    <div class="calendar-header" style="align-items: center; gap: 1rem;">
        <button wire:click="previousMonth" class="month-nav-btn"
            style="border: none; background: none; font-size: 1.2rem; cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
            </svg>
        </button>
        <h2 class="month-title" style="margin: 0;">{{ $year }}년 {{ $month }}월</h2>
        <button wire:click="nextMonth" class="month-nav-btn"
            style="border: none; background: none; font-size: 1.2rem; cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753"/>
            </svg>
        </button>
    </div>

    {{-- 달력 그리드 --}}
    <div class="calendar-grid">
        {{-- 요일 헤더 --}}
        <div class="calendar-header-cell sun">일</div>
        <div class="calendar-header-cell">월</div>
        <div class="calendar-header-cell">화</div>
        <div class="calendar-header-cell">수</div>
        <div class="calendar-header-cell">목</div>
        <div class="calendar-header-cell">금</div>
        <div class="calendar-header-cell sat">토</div>

        {{-- 날짜 출력 --}}
        {{-- @php
            // 6주 x 7일 = 42개의 날짜 데이터를 주 단위로 분할
            $weeks = array_chunk($calendar, 7);
        @endphp --}}

        @foreach ($weeks as $weekIndex => $week)
            @foreach ($week as $dayIndex => $day)
                <div
                    class="calendar-day
                    {{ !$day['current_month'] ? 'other-month' : '' }}
                    {{ $day['is_today'] ? 'today' : '' }}
                    {{ $dayIndex == 0 ? 'sun' : '' }}
                    {{ $dayIndex == 6 ? 'sat' : '' }}">

                    <div>{{ $day['day'] }}</div>

                </div>
            @endforeach
        @endforeach
    </div>
</div>
