<?php

namespace Jiny\Site\Http\Controllers\Admin\Log;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 사이트 방문 로그 목록 및 그래프 표시
     */
    public function index(Request $request)
    {
        // 기간 필터 (기본: 최근 30일)
        $days = $request->input('days', 30);

        // 최근 N일간의 로그 조회 (uri 필드 포함) - 페이지네이션 적용
        $logs = DB::table('site_log')
            ->select('year', 'month', 'day', 'uri', 'cnt', 'created_at', 'updated_at')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->paginate(20);

        // 그래프용 데이터 준비 - 전체 데이터에서 최근 30일
        $chartLogs = DB::table('site_log')
            ->select('year', 'month', 'day', 'cnt')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->limit(30)
            ->get();
        $chartData = $this->prepareChartData($chartLogs);

        // 통계 계산 - 전체 데이터 기준
        $stats = $this->calculateStats($chartLogs);

        // 페이지 설정
        $config = [
            'title' => '사이트 접속 로그'
        ];

        return view('jiny-site::admin.log.index', [
            'logs' => $logs,
            'chartData' => $chartData,
            'stats' => $stats,
            'days' => $days,
            'config' => $config
        ]);
    }

    /**
     * 그래프 데이터 준비
     */
    protected function prepareChartData($logs)
    {
        $labels = [];
        $data = [];

        // 역순으로 정렬하여 시간순으로 표시
        foreach ($logs->reverse() as $log) {
            $labels[] = sprintf('%s-%s-%s', $log->year, $log->month, $log->day);
            $data[] = $log->cnt;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * 통계 계산
     */
    protected function calculateStats($logs)
    {
        $totalVisits = $logs->sum('cnt');
        $avgVisits = $logs->count() > 0 ? round($logs->avg('cnt'), 1) : 0;
        $maxVisits = $logs->max('cnt') ?? 0;
        $minVisits = $logs->min('cnt') ?? 0;

        // 오늘 방문자
        $today = date('Y-m-d');
        $todayParts = explode('-', $today);
        $todayLog = DB::table('site_log')
            ->where('year', $todayParts[0])
            ->where('month', $todayParts[1])
            ->where('day', $todayParts[2])
            ->first();

        $todayVisits = $todayLog ? $todayLog->cnt : 0;

        // 이번달 방문자
        $thisMonth = date('Y-m');
        $thisMonthParts = explode('-', $thisMonth);
        $thisMonthVisits = DB::table('site_log')
            ->where('year', $thisMonthParts[0])
            ->where('month', $thisMonthParts[1])
            ->sum('cnt');

        return [
            'total' => $totalVisits,
            'average' => $avgVisits,
            'max' => $maxVisits,
            'min' => $minVisits,
            'today' => $todayVisits,
            'this_month' => $thisMonthVisits
        ];
    }

    /**
     * API: 차트 데이터 반환 (대시보드용)
     */
    public function chartData(Request $request)
    {
        $days = $request->input('days', 30);

        $logs = DB::table('site_log')
            ->select('year', 'month', 'day', 'cnt')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->limit($days)
            ->get();

        $chartData = $this->prepareChartData($logs);

        return response()->json($chartData);
    }
}
