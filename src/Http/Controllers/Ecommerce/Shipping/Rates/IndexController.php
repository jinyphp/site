<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping\Rates;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배송 요금 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = DB::table('site_shipping_rates as sr')
            ->leftJoin('site_shipping_zones as sz', 'sr.shipping_zone_id', '=', 'sz.id')
            ->leftJoin('site_shipping_methods as sm', 'sr.shipping_method_id', '=', 'sm.id')
            ->select(
                'sr.id',
                'sr.shipping_zone_id',
                'sr.shipping_method_id',
                'sr.base_cost',
                'sr.per_kg_cost',
                'sr.free_shipping_threshold',
                'sr.currency',
                'sr.min_order_amount',
                'sr.max_order_amount',
                'sr.enable',
                'sr.created_at',
                'sr.updated_at',
                'sz.name as zone_name',
                'sz.name_ko as zone_name_ko',
                'sm.name as method_name',
                'sm.name_ko as method_name_ko',
                'sm.code as method_code',
                'sm.delivery_time as method_delivery_time'
            );

        // 검색 필터
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('sz.name', 'LIKE', "%{$search}%")
                  ->orWhere('sz.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sm.name', 'LIKE', "%{$search}%")
                  ->orWhere('sm.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sm.code', 'LIKE', "%{$search}%");
            });
        }

        // 지역 필터
        if ($request->filled('zone_id')) {
            $query->where('sr.shipping_zone_id', $request->get('zone_id'));
        }

        // 배송 방식 필터
        if ($request->filled('method_id')) {
            $query->where('sr.shipping_method_id', $request->get('method_id'));
        }

        // 통화 필터
        if ($request->filled('currency')) {
            $query->where('sr.currency', $request->get('currency'));
        }

        // 상태 필터
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('sr.enable', true);
            } elseif ($status === 'inactive') {
                $query->where('sr.enable', false);
            }
        }

        // 무료 배송 필터
        if ($request->filled('free_shipping')) {
            if ($request->get('free_shipping') === 'yes') {
                $query->whereNotNull('sr.free_shipping_threshold')
                      ->where('sr.free_shipping_threshold', '>', 0);
            } elseif ($request->get('free_shipping') === 'no') {
                $query->where(function($q) {
                    $q->whereNull('sr.free_shipping_threshold')
                      ->orWhere('sr.free_shipping_threshold', '<=', 0);
                });
            }
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'zone_name');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSortColumns = [
            'zone_name', 'method_name', 'base_cost', 'per_kg_cost',
            'free_shipping_threshold', 'currency', 'created_at'
        ];

        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('sz.name', 'asc')->orderBy('sm.order', 'asc');
        }

        // 페이지네이션
        $perPage = $request->get('per_page', 20);
        $rates = $query->paginate($perPage)->appends($request->query());

        // 필터 옵션을 위한 데이터
        $zones = $this->getZones();
        $methods = $this->getMethods();
        $currencies = $this->getCurrencies();
        $stats = $this->getRateStats();

        // 페이지 설정
        $config = [
            'title' => '배송 요금 관리',
            'description' => '배송 요금 정책을 관리하세요',
        ];

        return view('jiny-site::ecommerce.shipping.rates.index', [
            'config' => $config,
            'rates' => $rates,
            'zones' => $zones,
            'methods' => $methods,
            'currencies' => $currencies,
            'stats' => $stats,
            'search' => $request->get('search'),
            'zone_id' => $request->get('zone_id'),
            'method_id' => $request->get('method_id'),
            'currency' => $request->get('currency'),
            'status' => $request->get('status'),
            'free_shipping' => $request->get('free_shipping'),
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage,
        ]);
    }

    /**
     * 배송 지역 목록
     */
    private function getZones()
    {
        return DB::table('site_shipping_zones')
            ->where('enable', true)
            ->orderBy('order')
            ->get(['id', 'name', 'name_ko']);
    }

    /**
     * 배송 방식 목록
     */
    private function getMethods()
    {
        return DB::table('site_shipping_methods')
            ->where('enable', true)
            ->orderBy('order')
            ->get(['id', 'name', 'name_ko', 'code']);
    }

    /**
     * 사용 중인 통화 목록
     */
    private function getCurrencies()
    {
        return DB::table('site_shipping_rates')
            ->select('currency')
            ->distinct()
            ->whereNotNull('currency')
            ->orderBy('currency')
            ->pluck('currency');
    }

    /**
     * 배송 요금 통계
     */
    private function getRateStats(): array
    {
        $totalRates = DB::table('site_shipping_rates')->count();
        $activeRates = DB::table('site_shipping_rates')->where('enable', true)->count();

        $freeShippingRates = DB::table('site_shipping_rates')
            ->whereNotNull('free_shipping_threshold')
            ->where('free_shipping_threshold', '>', 0)
            ->count();

        $avgBaseCost = DB::table('site_shipping_rates')
            ->where('enable', true)
            ->where('currency', 'KRW')
            ->avg('base_cost') ?: 0;

        $currencies = DB::table('site_shipping_rates')
            ->select('currency')
            ->distinct()
            ->whereNotNull('currency')
            ->count();

        return [
            'total' => $totalRates,
            'active' => $activeRates,
            'inactive' => $totalRates - $activeRates,
            'free_shipping' => $freeShippingRates,
            'avg_base_cost' => round($avgBaseCost, 2),
            'currencies' => $currencies,
        ];
    }
}