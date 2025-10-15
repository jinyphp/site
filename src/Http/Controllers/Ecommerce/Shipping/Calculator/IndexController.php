<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping\Calculator;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배송비 계산기 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 계산 결과
        $calculationResult = null;

        // POST 요청 시 배송비 계산
        if ($request->isMethod('post')) {
            $calculationResult = $this->calculateShipping($request);
        }

        // 필터 옵션을 위한 데이터
        $zones = $this->getZones();
        $methods = $this->getMethods();
        $countries = $this->getCountries();

        // 페이지 설정
        $config = [
            'title' => '배송비 계산기',
            'description' => '배송비를 미리 계산하고 시뮬레이션하세요',
        ];

        return view('jiny-site::ecommerce.shipping.calculator.index', [
            'config' => $config,
            'zones' => $zones,
            'methods' => $methods,
            'countries' => $countries,
            'calculation_result' => $calculationResult,
            'input' => $request->all(),
        ]);
    }

    /**
     * 배송비 계산
     */
    private function calculateShipping(Request $request): array
    {
        $countryCode = $request->get('country_code');
        $weight = (float) $request->get('weight', 0);
        $orderAmount = (float) $request->get('order_amount', 0);
        $methodId = $request->get('method_id');
        $zoneId = $request->get('zone_id');

        try {
            // 국가에서 지역 찾기 (지정하지 않은 경우)
            if (!$zoneId && $countryCode) {
                $zoneId = $this->getZoneByCountry($countryCode);
            }

            if (!$zoneId) {
                return [
                    'success' => false,
                    'message' => '해당 국가에 대한 배송 지역을 찾을 수 없습니다.',
                    'rates' => []
                ];
            }

            // 배송 요금 조회
            $ratesQuery = DB::table('site_shipping_rates as sr')
                ->leftJoin('site_shipping_zones as sz', 'sr.shipping_zone_id', '=', 'sz.id')
                ->leftJoin('site_shipping_methods as sm', 'sr.shipping_method_id', '=', 'sm.id')
                ->where('sr.shipping_zone_id', $zoneId)
                ->where('sr.enable', true)
                ->where('sz.enable', true)
                ->where('sm.enable', true);

            // 특정 배송 방식이 지정된 경우
            if ($methodId) {
                $ratesQuery->where('sr.shipping_method_id', $methodId);
            }

            // 최소/최대 주문 금액 체크
            if ($orderAmount > 0) {
                $ratesQuery->where(function($q) use ($orderAmount) {
                    $q->where(function($subQ) use ($orderAmount) {
                        $subQ->whereNull('sr.min_order_amount')
                             ->orWhere('sr.min_order_amount', '<=', $orderAmount);
                    })
                    ->where(function($subQ) use ($orderAmount) {
                        $subQ->whereNull('sr.max_order_amount')
                             ->orWhere('sr.max_order_amount', '>=', $orderAmount);
                    });
                });
            }

            $rates = $ratesQuery->select(
                'sr.*',
                'sz.name as zone_name',
                'sz.name_ko as zone_name_ko',
                'sm.name as method_name',
                'sm.name_ko as method_name_ko',
                'sm.code as method_code',
                'sm.delivery_time'
            )->get();

            if ($rates->isEmpty()) {
                return [
                    'success' => false,
                    'message' => '해당 조건에 맞는 배송 방식을 찾을 수 없습니다.',
                    'rates' => []
                ];
            }

            // 각 요금에 대해 배송비 계산
            $calculatedRates = [];
            foreach ($rates as $rate) {
                $calculatedRate = $this->calculateRate($rate, $weight, $orderAmount);
                $calculatedRates[] = $calculatedRate;
            }

            // 배송비 기준으로 정렬
            usort($calculatedRates, function($a, $b) {
                return $a['final_cost'] <=> $b['final_cost'];
            });

            return [
                'success' => true,
                'message' => count($calculatedRates) . '개의 배송 방식을 찾았습니다.',
                'rates' => $calculatedRates,
                'input' => [
                    'country_code' => $countryCode,
                    'weight' => $weight,
                    'order_amount' => $orderAmount,
                    'zone_id' => $zoneId,
                    'method_id' => $methodId,
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '배송비 계산 중 오류가 발생했습니다: ' . $e->getMessage(),
                'rates' => []
            ];
        }
    }

    /**
     * 개별 요금 계산
     */
    private function calculateRate($rate, float $weight, float $orderAmount): array
    {
        $baseCost = (float) $rate->base_cost;
        $perKgCost = (float) $rate->per_kg_cost;
        $freeShippingThreshold = (float) $rate->free_shipping_threshold;

        // 기본 배송비
        $shippingCost = $baseCost;

        // 무게별 추가 비용
        if ($weight > 0 && $perKgCost > 0) {
            $shippingCost += $weight * $perKgCost;
        }

        // 무료 배송 체크
        $isFreeShipping = false;
        if ($freeShippingThreshold > 0 && $orderAmount >= $freeShippingThreshold) {
            $isFreeShipping = true;
            $shippingCost = 0;
        }

        $finalCost = max(0, $shippingCost); // 음수 방지

        return [
            'rate_id' => $rate->id,
            'zone_name' => $rate->zone_name_ko ?: $rate->zone_name,
            'method_name' => $rate->method_name_ko ?: $rate->method_name,
            'method_code' => $rate->method_code,
            'delivery_time' => $rate->delivery_time,
            'base_cost' => $baseCost,
            'per_kg_cost' => $perKgCost,
            'weight_cost' => $weight * $perKgCost,
            'final_cost' => $finalCost,
            'currency' => $rate->currency,
            'is_free_shipping' => $isFreeShipping,
            'free_shipping_threshold' => $freeShippingThreshold,
            'calculation_details' => [
                'base_cost' => $baseCost,
                'weight' => $weight,
                'per_kg_cost' => $perKgCost,
                'weight_cost' => $weight * $perKgCost,
                'subtotal' => $baseCost + ($weight * $perKgCost),
                'free_shipping_applied' => $isFreeShipping,
                'final_cost' => $finalCost,
            ]
        ];
    }

    /**
     * 국가 코드로 배송 지역 찾기
     */
    private function getZoneByCountry(string $countryCode): ?int
    {
        $result = DB::table('site_shipping_zone_countries')
            ->where('country_code', $countryCode)
            ->where('enable', true)
            ->first();

        return $result ? $result->shipping_zone_id : null;
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
            ->get(['id', 'name', 'name_ko', 'code', 'delivery_time']);
    }

    /**
     * 배송 가능한 국가 목록
     */
    private function getCountries()
    {
        return DB::table('site_shipping_zone_countries as szc')
            ->leftJoin('site_shipping_zones as sz', 'szc.shipping_zone_id', '=', 'sz.id')
            ->leftJoin('site_countries as sc', 'szc.country_code', '=', 'sc.code')
            ->where('szc.enable', true)
            ->where('sz.enable', true)
            ->orderBy('szc.country_code')
            ->get(['szc.country_code', 'sc.name as country_name', 'sz.name as zone_name', 'sz.name_ko as zone_name_ko']);
    }
}