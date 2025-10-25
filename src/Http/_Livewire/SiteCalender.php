<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiteCalender extends Component
{
    public $year;
    public $month;
    public $calendar = [];
    public $currentDate;

    public function mount()
    {
        // 현재 년월일 설정
        $this->currentDate = now()->day;
        $this->year = now()->year;
        $this->month = now()->month;

        $this->generateCalendar();
    }

    // 이전 달로 이동
    public function previousMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = $date->year;
        $this->month = $date->month;
        $this->generateCalendar();
    }

    // 다음 달로 이동
    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = $date->year;
        $this->month = $date->month;
        $this->generateCalendar();
    }

    // 달력 데이터 생성
    private function generateCalendar()
    {
        $this->calendar = [];

        $date = Carbon::create($this->year, $this->month, 1);
        $daysInMonth = $date->daysInMonth;

        // 첫 주의 시작일까지 이전 달의 날짜로 채우기
        $firstDayOfWeek = $date->dayOfWeek;
        if ($firstDayOfWeek > 0) {
            $prevMonth = Carbon::create($this->year, $this->month, 1)->subMonth();
            $prevMonthDays = $prevMonth->daysInMonth;
            for ($i = $firstDayOfWeek - 1; $i >= 0; $i--) {
                $this->calendar[] = [
                    'day' => $prevMonthDays - $i,
                    'current_month' => false,
                    'is_today' => false,
                    'year' => $prevMonth->year,
                    'month' => $prevMonth->month
                ];
            }
        }

        // 현재 달의 날짜 채우기
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $this->calendar[] = [
                'day' => $day,
                'current_month' => true,
                'is_today' => ($day == $this->currentDate &&
                             $this->year == now()->year &&
                             $this->month == now()->month),
                'year' => $this->year,
                'month' => $this->month
            ];
        }

        // 마지막 주 남은 칸을 다음 달의 날짜로 채우기
        $remainingDays = 42 - count($this->calendar); // 6주 x 7일 = 42
        for ($day = 1; $day <= $remainingDays; $day++) {
            $this->calendar[] = [
                'day' => $day,
                'current_month' => false,
                'is_today' => false,
                'year' => $date->year,
                'month' => $date->month
            ];
        }
    }

    public function render()
    {
        $viewFile = 'jiny-site::site.calender.month';
        return view($viewFile, [
            //'calendar' => array_chunk($this->calendar, 7) // 7일씩 나누어 주 단위로 표시
            'weeks' => array_chunk($this->calendar, 7) // 7일씩 나누어 주 단위로 표시
        ]);
    }
}
