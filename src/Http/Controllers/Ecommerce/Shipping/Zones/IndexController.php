<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping\Zones;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배송 지역 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = DB::table('site_shipping_zones as sz')
            ->leftJoin('site_shipping_zone_countries as szc', 'sz.id', '=', 'szc.shipping_zone_id')
            ->leftJoin('site_shipping_rates as sr', 'sz.id', '=', 'sr.shipping_zone_id')
            ->select(
                'sz.id',
                'sz.name',
                'sz.name_ko',
                'sz.description',
                'sz.enable',
                'sz.is_default',
                'sz.order',
                'sz.created_at',
                'sz.updated_at',
                DB::raw('COUNT(DISTINCT szc.country_code) as country_count'),
                DB::raw('COUNT(DISTINCT sr.id) as rate_count')
            )
            ->groupBy('sz.id', 'sz.name', 'sz.name_ko', 'sz.description', 'sz.enable', 'sz.is_default', 'sz.order', 'sz.created_at', 'sz.updated_at');

        // 검색 필터
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('sz.name', 'LIKE', "%{$search}%")
                  ->orWhere('sz.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sz.description', 'LIKE', "%{$search}%");
            });
        }

        // 상태 필터
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('sz.enable', true);
            } elseif ($status === 'inactive') {
                $query->where('sz.enable', false);
            }
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSortColumns = ['order', 'name', 'name_ko', 'country_count', 'rate_count', 'created_at'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('sz.order', 'asc');
        }

        // 페이지네이션
        $perPage = $request->get('per_page', 15);
        $zones = $query->paginate($perPage)->appends($request->query());

        // 페이지 설정
        $config = [
            'title' => '배송 지역 관리',
            'description' => '배송 지역별 설정을 관리하세요',
        ];

        return view('jiny-site::ecommerce.shipping.zones.index', [
            'config' => $config,
            'zones' => $zones,
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage,
        ]);
    }
}