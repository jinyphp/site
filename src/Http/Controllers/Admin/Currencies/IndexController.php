<?php

namespace Jiny\Site\Http\Controllers\Admin\Currencies;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 통화 관리 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_currencies',
            'view' => 'jiny-site::admin.currencies.index',
            'title' => '통화 관리',
            'subtitle' => '다중 통화 시스템을 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $currencies = $query->orderBy('site_currencies.order', 'asc')
            ->orderBy('site_currencies.created_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $exchangeRateStats = $this->getExchangeRateStatistics();

        return view($this->config['view'], [
            'currencies' => $currencies,
            'stats' => $stats,
            'exchange_rate_stats' => $exchangeRateStats,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->select('site_currencies.*');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_currencies.code', 'like', "%{$search}%")
                  ->orWhere('site_currencies.name', 'like', "%{$search}%")
                  ->orWhere('site_currencies.symbol', 'like', "%{$search}%");
            });
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_currencies.enable', $request->get('enable') === '1');
        }

        if ($request->filled('is_base') && $request->get('is_base') !== 'all') {
            $query->where('site_currencies.is_base', $request->get('is_base') === '1');
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'enabled' => DB::table($table)->where('enable', true)->count(),
            'disabled' => DB::table($table)->where('enable', false)->count(),
            'base_currency' => DB::table($table)->where('is_base', true)->value('code') ?? 'None',
        ];
    }

    protected function getExchangeRateStatistics()
    {
        $now = now();

        return [
            'total_rates' => DB::table('site_exchange_rates')->count(),
            'active_rates' => DB::table('site_exchange_rates')
                ->where('is_active', true)
                ->count(),
            'expired_rates' => DB::table('site_exchange_rates')
                ->where('is_active', true)
                ->where('expires_at', '<=', $now)
                ->count(),
            'recent_updates' => DB::table('site_exchange_rate_logs')
                ->where('created_at', '>=', $now->subDays(7))
                ->count(),
            'last_update' => DB::table('site_exchange_rates')
                ->where('is_active', true)
                ->max('updated_at'),
        ];
    }
}