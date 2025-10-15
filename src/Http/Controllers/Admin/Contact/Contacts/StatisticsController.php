<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 통계 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/contacts/statistics') → StatisticsController::__invoke()
 */
class StatisticsController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_contact',
            'view' => 'jiny-site::admin.contact.contacts.statistics',
            'title' => 'Contact 통계',
            'subtitle' => '문의 통계를 확인합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        $period = $request->get('period', '7days');
        $startDate = $this->getStartDate($period);

        $stats = [
            'total_by_period' => $this->getTotalByPeriod($startDate),
            'by_status' => $this->getStatsByStatus($startDate),
            'by_type' => $this->getStatsByType($startDate),
            'daily_trend' => $this->getDailyTrend($startDate),
            'response_time' => $this->getResponseTimeStats($startDate),
        ];

        return view($this->config['view'], [
            'stats' => $stats,
            'period' => $period,
            'config' => $this->config,
        ]);
    }

    protected function getStartDate($period)
    {
        return match($period) {
            '7days' => now()->subDays(7),
            '30days' => now()->subDays(30),
            '3months' => now()->subMonths(3),
            '1year' => now()->subYear(),
            default => now()->subDays(7),
        };
    }

    protected function getTotalByPeriod($startDate)
    {
        return DB::table($this->config['table'])
            ->where('created_at', '>=', $startDate)
            ->count();
    }

    protected function getStatsByStatus($startDate)
    {
        return DB::table($this->config['table'])
            ->select('status', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('status')
            ->get();
    }

    protected function getStatsByType($startDate)
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_contact_type', 'site_contact.type', '=', 'site_contact_type.code')
            ->select('site_contact_type.title', DB::raw('count(*) as count'))
            ->where('site_contact.created_at', '>=', $startDate)
            ->groupBy('site_contact_type.title')
            ->get();
    }

    protected function getDailyTrend($startDate)
    {
        return DB::table($this->config['table'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    protected function getResponseTimeStats($startDate)
    {
        return DB::table($this->config['table'])
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, replied_at)) as avg_response_hours'),
                DB::raw('COUNT(CASE WHEN replied_at IS NOT NULL THEN 1 END) as replied_count'),
                DB::raw('COUNT(*) as total_count')
            )
            ->where('created_at', '>=', $startDate)
            ->first();
    }
}