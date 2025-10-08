<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * 대시보드 서비스
 */
class DashboardService
{
    /**
     * 전체 방문 수 조회
     *
     * @return int
     */
    public function getTotalVisits()
    {
        return DB::table('site_log')
            ->sum('cnt');
    }

    /**
     * 오늘 방문 수 조회
     *
     * @return int
     */
    public function getTodayVisits()
    {
        $date = explode('-', date('Y-m-d'));

        $log = DB::table('site_log')
            ->where('year', $date[0])
            ->where('month', $date[1])
            ->where('day', $date[2])
            ->first();

        return $log ? $log->cnt : 0;
    }

    /**
     * 전체 페이지 수 조회
     *
     * @return int
     */
    public function getTotalPages()
    {
        return DB::table('jiny_route')
            ->where('enabled', true)
            ->count();
    }

    /**
     * 전체 메뉴 수 조회
     *
     * @return int
     */
    public function getTotalMenus()
    {
        return DB::table('site_menus')
            ->count();
    }

    /**
     * 최근 로그 조회
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRecentLogs($limit = 10)
    {
        return DB::table('site_log')
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
