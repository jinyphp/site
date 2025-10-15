<?php

namespace Jiny\Site\Http\Controllers\Admin\ExchangeRates;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Jiny\Site\Services\ExchangeRateService;

/**
 * 환율 관리 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;
    protected $exchangeRateService;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_exchange_rates',
            'view' => 'jiny-site::admin.exchange-rates.index',
            'title' => '환율 관리',
            'subtitle' => '실시간 환율 정보를 관리합니다.',
            'per_page' => 15,
        ];

        // Try to initialize the service
        try {
            $this->exchangeRateService = app(ExchangeRateService::class);
        } catch (\Exception $e) {
            $this->exchangeRateService = null;
        }
    }

    public function __invoke(Request $request)
    {
        try {
            // Check if tables exist
            if (!$this->checkTablesExist()) {
                $emptyPaginator = new LengthAwarePaginator(
                    collect(),
                    0,
                    $this->config['per_page'],
                    1,
                    ['path' => request()->url(), 'pageName' => 'page']
                );

                return view($this->config['view'], [
                    'exchangeRates' => $emptyPaginator,
                    'stats' => $this->getDefaultStats(),
                    'currencies' => collect(),
                    'recentChanges' => collect(),
                    'config' => $this->config,
                    'tablesNotExist' => true,
                ]);
            }

            $query = $this->buildQuery();
            $query = $this->applyFilters($query, $request);

            $exchangeRates = $query->orderBy('site_exchange_rates.rate_date', 'desc')
                ->orderBy('site_exchange_rates.created_at', 'desc')
                ->paginate($this->config['per_page'])
                ->withQueryString();

            $stats = $this->getStatistics();
            $currencies = $this->getActiveCurrencies();
            $recentLogs = $this->getRecentLogs();

            return view($this->config['view'], [
                'exchangeRates' => $exchangeRates,
                'stats' => $stats,
                'currencies' => $currencies,
                'recentChanges' => $recentLogs,
                'config' => $this->config,
            ]);
        } catch (\Exception $e) {
            $emptyPaginator = new LengthAwarePaginator(
                collect(),
                0,
                $this->config['per_page'],
                1,
                ['path' => request()->url(), 'pageName' => 'page']
            );

            return view($this->config['view'], [
                'exchangeRates' => $emptyPaginator,
                'stats' => $this->getDefaultStats(),
                'currencies' => collect(),
                'recentChanges' => collect(),
                'config' => $this->config,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_currencies as from_curr', 'site_exchange_rates.from_currency', '=', 'from_curr.code')
            ->leftJoin('site_currencies as to_curr', 'site_exchange_rates.to_currency', '=', 'to_curr.code')
            ->select(
                'site_exchange_rates.*',
                'from_curr.name as from_currency_name',
                'from_curr.symbol as from_currency_symbol',
                'to_curr.name as to_currency_name',
                'to_curr.symbol as to_currency_symbol'
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_exchange_rates.from_currency', 'like', "%{$search}%")
                  ->orWhere('site_exchange_rates.to_currency', 'like', "%{$search}%")
                  ->orWhere('from_curr.name', 'like', "%{$search}%")
                  ->orWhere('to_curr.name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_currency') && $request->get('from_currency') !== 'all') {
            $query->where('site_exchange_rates.from_currency', $request->get('from_currency'));
        }

        if ($request->filled('to_currency') && $request->get('to_currency') !== 'all') {
            $query->where('site_exchange_rates.to_currency', $request->get('to_currency'));
        }

        if ($request->filled('source') && $request->get('source') !== 'all') {
            $query->where('site_exchange_rates.source', $request->get('source'));
        }

        if ($request->filled('is_active') && $request->get('is_active') !== 'all') {
            $query->where('site_exchange_rates.is_active', $request->get('is_active') === '1');
        }

        if ($request->filled('expired')) {
            if ($request->get('expired') === '1') {
                $query->where('site_exchange_rates.expires_at', '<=', now());
            } else {
                $query->where(function ($q) {
                    $q->whereNull('site_exchange_rates.expires_at')
                      ->orWhere('site_exchange_rates.expires_at', '>', now());
                });
            }
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];
        $now = now();

        return [
            'total_rates' => DB::table($table)->count(),
            'active_rates' => DB::table($table)->where('is_active', true)->count(),
            'expired_rates' => DB::table($table)
                ->where('is_active', true)
                ->where('expires_at', '<=', $now)
                ->count(),
            'recent_updates' => DB::table('site_exchange_rate_logs')
                ->where('created_at', '>=', $now->subDays(7))
                ->count(),
            'api_sources' => DB::table($table)->where('source', 'api')->count(),
            'manual_sources' => DB::table($table)->where('source', 'manual')->count(),
            'last_update' => DB::table($table)->max('updated_at'),
            'providers' => DB::table($table)
                ->select('provider')
                ->distinct()
                ->whereNotNull('provider')
                ->pluck('provider')
                ->toArray(),
        ];
    }

    protected function getActiveCurrencies()
    {
        return DB::table('site_currencies')
            ->where('enable', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();
    }

    protected function getRecentLogs()
    {
        return DB::table('site_exchange_rate_logs')
            ->leftJoin('site_currencies as from_curr', 'site_exchange_rate_logs.from_currency', '=', 'from_curr.code')
            ->leftJoin('site_currencies as to_curr', 'site_exchange_rate_logs.to_currency', '=', 'to_curr.code')
            ->select(
                'site_exchange_rate_logs.*',
                'from_curr.name as from_currency_name',
                'from_curr.symbol as from_currency_symbol',
                'to_curr.name as to_currency_name',
                'to_curr.symbol as to_currency_symbol'
            )
            ->orderBy('site_exchange_rate_logs.created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * 환율 수동 업데이트
     */
    public function updateRates(Request $request)
    {
        $validated = $request->validate([
            'from_currency' => 'nullable|string|size:3',
            'to_currency' => 'nullable|string|size:3',
            'provider' => 'nullable|string|in:exchangerate,fixer,currencylayer',
        ]);

        try {
            if ($validated['from_currency'] && $validated['to_currency']) {
                // 특정 통화 쌍 업데이트
                $result = $this->exchangeRateService->updateRate(
                    $validated['from_currency'],
                    $validated['to_currency']
                );

                if ($result['success']) {
                    return response()->json([
                        'success' => true,
                        'message' => "환율 업데이트 완료: {$validated['from_currency']}/{$validated['to_currency']} = {$result['rate']}",
                        'data' => $result
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message']
                    ], 400);
                }
            } else {
                // 모든 활성화된 통화 업데이트
                $results = $this->exchangeRateService->updateAllRates();
                $successCount = collect($results)->where('success', true)->count();
                $totalCount = count($results);

                return response()->json([
                    'success' => true,
                    'message' => "환율 업데이트 완료: {$successCount}/{$totalCount} 성공",
                    'data' => $results
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '환율 업데이트 실패: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 만료된 환율 확인 및 업데이트
     */
    public function checkExpired(Request $request)
    {
        try {
            $results = $this->exchangeRateService->checkAndUpdateExpiredRates();
            $updatedCount = count($results);

            return response()->json([
                'success' => true,
                'message' => "만료된 환율 확인 완료: {$updatedCount}개 업데이트됨",
                'data' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '만료된 환율 확인 실패: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 필요한 테이블들이 존재하는지 확인
     */
    protected function checkTablesExist()
    {
        try {
            return DB::connection()->getSchemaBuilder()->hasTable('site_exchange_rates') &&
                   DB::connection()->getSchemaBuilder()->hasTable('site_currencies') &&
                   DB::connection()->getSchemaBuilder()->hasTable('site_exchange_rate_logs');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 기본 통계 반환 (테이블이 없을 때)
     */
    protected function getDefaultStats()
    {
        return [
            'total_rates' => 0,
            'active_rates' => 0,
            'expired_rates' => 0,
            'recent_updates' => 0,
            'api_sources' => 0,
            'manual_sources' => 0,
            'last_update' => null,
            'providers' => [],
        ];
    }
}