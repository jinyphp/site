<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배송 관리 메인 대시보드 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 페이지 설정
        $config = [
            'title' => '배송 관리',
            'description' => '배송 지역, 방식, 요금을 통합 관리하세요',
        ];

        // 배송 관련 통계 수집
        $stats = $this->getShippingStats();

        // 최근 배송 요금 변경 이력 (향후 구현)
        $recentChanges = collect([]);

        // 배송 지역별 통계
        $zoneStats = $this->getZoneStats();

        // 배송 방식별 통계
        $methodStats = $this->getMethodStats();

        // 뷰에서 필요한 추가 데이터
        $countries = $this->getCountriesForFilter();
        $shippingMethods = $this->getShippingMethodsForFilter();
        $shippingRates = $this->getShippingRatesForList($request);

        return view('jiny-site::ecommerce.shipping.index', [
            'config' => $config,
            'stats' => $stats,
            'recent_changes' => $recentChanges,
            'zone_stats' => $zoneStats,
            'method_stats' => $methodStats,
            'countries' => $countries,
            'shippingMethods' => $shippingMethods,
            'shippingRates' => $shippingRates,
        ]);
    }

    /**
     * 배송 관련 전체 통계
     */
    private function getShippingStats(): array
    {
        $totalZones = DB::table('site_shipping_zones')->where('enable', true)->count();
        $totalMethods = DB::table('site_shipping_methods')->where('enable', true)->count();
        $totalRates = DB::table('site_shipping_rates')->where('enable', true)->count();
        $totalCountries = DB::table('site_shipping_zone_countries')->where('enable', true)->count();

        // 평균 배송비 계산 (KRW 기준)
        $avgShippingCost = DB::table('site_shipping_rates')
            ->where('enable', true)
            ->where('currency', 'KRW')
            ->avg('base_cost') ?: 0;

        // 뷰에서 요구하는 추가 통계들
        $countriesCovered = $totalCountries; // 배송 가능 국가 수
        $avgDeliveryDays = '3-5'; // 평균 배송일 (임시값)
        $shippingRevenue = 1250000; // 배송비 수익 (임시값)

        return [
            'total_zones' => $totalZones,
            'total_methods' => $totalMethods,
            'total_rates' => $totalRates,
            'total_countries' => $totalCountries,
            'avg_shipping_cost' => round($avgShippingCost, 2),

            // 뷰 호환성을 위한 추가 데이터
            'countries_covered' => $countriesCovered,
            'avg_delivery_days' => $avgDeliveryDays,
            'shipping_revenue' => $shippingRevenue,
        ];
    }

    /**
     * 배송 지역별 통계
     */
    private function getZoneStats()
    {
        return DB::table('site_shipping_zones as sz')
            ->leftJoin('site_shipping_zone_countries as szc', 'sz.id', '=', 'szc.shipping_zone_id')
            ->leftJoin('site_shipping_rates as sr', 'sz.id', '=', 'sr.shipping_zone_id')
            ->select(
                'sz.id',
                'sz.name',
                'sz.name_ko',
                'sz.enable',
                DB::raw('COUNT(DISTINCT szc.country_code) as country_count'),
                DB::raw('COUNT(DISTINCT sr.id) as rate_count'),
                DB::raw('COALESCE(AVG(sr.base_cost), 0) as avg_cost')
            )
            ->groupBy('sz.id', 'sz.name', 'sz.name_ko', 'sz.enable')
            ->orderBy('sz.order')
            ->get();
    }

    /**
     * 배송 방식별 통계
     */
    private function getMethodStats()
    {
        return DB::table('site_shipping_methods as sm')
            ->leftJoin('site_shipping_rates as sr', 'sm.id', '=', 'sr.shipping_method_id')
            ->select(
                'sm.id',
                'sm.name',
                'sm.name_ko',
                'sm.code',
                'sm.delivery_time',
                'sm.enable',
                DB::raw('COUNT(sr.id) as rate_count'),
                DB::raw('COALESCE(AVG(sr.base_cost), 0) as avg_cost'),
                DB::raw('COALESCE(MIN(sr.base_cost), 0) as min_cost'),
                DB::raw('COALESCE(MAX(sr.base_cost), 0) as max_cost')
            )
            ->groupBy('sm.id', 'sm.name', 'sm.name_ko', 'sm.code', 'sm.delivery_time', 'sm.enable')
            ->orderBy('sm.order')
            ->get();
    }

    /**
     * 필터용 국가 목록 조회
     */
    private function getCountriesForFilter()
    {
        return DB::table('site_shipping_zone_countries as szc')
            ->leftJoin('site_shipping_zones as sz', 'szc.shipping_zone_id', '=', 'sz.id')
            ->leftJoin('site_countries as sc', 'szc.country_code', '=', 'sc.code')
            ->where('szc.enable', true)
            ->where('sz.enable', true)
            ->select('szc.country_code as code', 'sc.name')
            ->orderBy('sc.name')
            ->get();
    }

    /**
     * 필터용 배송 방식 목록 조회
     */
    private function getShippingMethodsForFilter()
    {
        $methods = DB::table('site_shipping_methods')
            ->where('enable', true)
            ->orderBy('order')
            ->get(['id', 'name', 'name_ko', 'code']);

        $result = [];
        foreach ($methods as $method) {
            $result[$method->code] = [
                'label' => $method->name_ko ?: $method->name,
                'color' => $this->getMethodColor($method->code),
                'icon' => $this->getMethodIcon($method->code),
            ];
        }

        return $result;
    }

    /**
     * 배송 요금 목록 조회 (페이지네이션)
     */
    private function getShippingRatesForList($request)
    {
        $query = DB::table('site_shipping_rates as sr')
            ->leftJoin('site_shipping_zones as sz', 'sr.shipping_zone_id', '=', 'sz.id')
            ->leftJoin('site_shipping_methods as sm', 'sr.shipping_method_id', '=', 'sm.id')
            ->leftJoin('site_shipping_zone_countries as szc', 'sz.id', '=', 'szc.shipping_zone_id')
            ->leftJoin('site_countries as sc', 'szc.country_code', '=', 'sc.code')
            ->select(
                'sr.*',
                'sz.name as zone_name',
                'sz.name_ko as zone_name_ko',
                'sm.name as method_name',
                'sm.name_ko as method_name_ko',
                'sm.code as method_code',
                'szc.country_code',
                'sc.name as country_name'
            )
            ->where('sr.enable', true);

        // 필터 적용
        if ($request->filled('country') && $request->get('country') !== 'all') {
            $query->where('szc.country_code', $request->get('country'));
        }

        if ($request->filled('method') && $request->get('method') !== 'all') {
            $query->where('sm.code', $request->get('method'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('sr.enable', $request->get('enable') === '1');
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('sz.name', 'LIKE', "%{$search}%")
                  ->orWhere('sz.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sm.name', 'LIKE', "%{$search}%")
                  ->orWhere('sm.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sc.name', 'LIKE', "%{$search}%");
            });
        }

        // 실제 데이터 조회
        $rates = $query->get();

        // 뷰용 데이터 포맷팅
        $formattedRates = collect($rates)->map(function($rate) {
            return [
                'id' => $rate->id,
                'name' => ($rate->zone_name_ko ?: $rate->zone_name) . ' - ' . ($rate->method_name_ko ?: $rate->method_name),
                'country_code' => $rate->country_code ?: 'ALL',
                'country_name' => $rate->country_name ?: '모든 국가',
                'method' => $rate->method_code,
                'base_rate' => $rate->base_cost,
                'per_kg_rate' => $rate->per_kg_cost,
                'free_shipping_threshold' => $rate->free_shipping_threshold,
                'estimated_days' => '2-5', // 기본값, 실제로는 배송 방식에서 가져와야 함
                'currency' => $rate->currency,
                'enable' => $rate->enable,
            ];
        });

        // 간단한 페이지네이션 시뮬레이션
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $formattedRates->take(10), // 현재 페이지 아이템
            $formattedRates->count(), // 전체 아이템 수
            10, // 페이지당 아이템 수
            1, // 현재 페이지
            [
                'path' => $request->url(),
                'pageName' => 'page',
            ]
        );
    }

    /**
     * 배송 방식별 색상 반환
     */
    private function getMethodColor($code)
    {
        $colors = [
            'STANDARD' => 'primary',
            'EXPRESS' => 'success',
            'OVERNIGHT' => 'warning',
            'ECONOMY' => 'info',
            'FREE' => 'secondary',
        ];

        return $colors[$code] ?? 'secondary';
    }

    /**
     * 배송 방식별 아이콘 반환
     */
    private function getMethodIcon($code)
    {
        $icons = [
            'STANDARD' => 'truck',
            'EXPRESS' => 'zap',
            'OVERNIGHT' => 'clock',
            'ECONOMY' => 'package',
            'FREE' => 'gift',
        ];

        return $icons[$code] ?? 'circle';
    }
}