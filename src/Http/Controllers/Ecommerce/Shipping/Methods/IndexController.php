<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping\Methods;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배송 방식 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = DB::table('site_shipping_methods as sm')
            ->leftJoin('site_shipping_rates as sr', 'sm.id', '=', 'sr.shipping_method_id')
            ->select(
                'sm.id',
                'sm.name',
                'sm.name_ko',
                'sm.code',
                'sm.description',
                'sm.delivery_time',
                'sm.max_weight as weight_limit',
                DB::raw('CONCAT(sm.max_length, "x", sm.max_width, "x", sm.max_height, "cm") as size_limit'),
                'sm.trackable as is_trackable',
                'sm.requires_signature as is_signature_required',
                'sm.insured as is_insurance_available',
                'sm.enable',
                'sm.order',
                'sm.created_at',
                'sm.updated_at',
                DB::raw('COUNT(sr.id) as rate_count'),
                DB::raw('COALESCE(MIN(sr.base_cost), 0) as min_cost'),
                DB::raw('COALESCE(MAX(sr.base_cost), 0) as max_cost'),
                DB::raw('COALESCE(AVG(sr.base_cost), 0) as avg_cost')
            )
            ->groupBy(
                'sm.id', 'sm.name', 'sm.name_ko', 'sm.code', 'sm.description',
                'sm.delivery_time', 'sm.max_weight', 'sm.max_length', 'sm.max_width', 'sm.max_height',
                'sm.trackable', 'sm.requires_signature', 'sm.insured', 'sm.enable', 'sm.order',
                'sm.created_at', 'sm.updated_at'
            );

        // 검색 필터
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('sm.name', 'LIKE', "%{$search}%")
                  ->orWhere('sm.name_ko', 'LIKE', "%{$search}%")
                  ->orWhere('sm.code', 'LIKE', "%{$search}%")
                  ->orWhere('sm.description', 'LIKE', "%{$search}%");
            });
        }

        // 상태 필터
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('sm.enable', true);
            } elseif ($status === 'inactive') {
                $query->where('sm.enable', false);
            }
        }

        // 특성 필터
        if ($request->filled('trackable')) {
            $query->where('sm.trackable', $request->get('trackable') === '1');
        }

        if ($request->filled('signature')) {
            $query->where('sm.requires_signature', $request->get('signature') === '1');
        }

        if ($request->filled('insurance')) {
            $query->where('sm.insured', $request->get('insurance') === '1');
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSortColumns = ['order', 'name', 'name_ko', 'code', 'delivery_time', 'rate_count', 'min_cost', 'max_cost', 'created_at'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('sm.order', 'asc');
        }

        // 페이지네이션
        $perPage = $request->get('per_page', 15);
        $methods = $query->paginate($perPage)->appends($request->query());

        // 전체 통계
        $stats = $this->getMethodStats();

        // 페이지 설정
        $config = [
            'title' => '배송 방식 관리',
            'description' => '배송 방식별 설정을 관리하세요',
        ];

        return view('jiny-site::ecommerce.shipping.methods.index', [
            'config' => $config,
            'methods' => $methods,
            'stats' => $stats,
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'trackable' => $request->get('trackable'),
            'signature' => $request->get('signature'),
            'insurance' => $request->get('insurance'),
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage,
        ]);
    }

    /**
     * 배송 방식 통계
     */
    private function getMethodStats(): array
    {
        $totalMethods = DB::table('site_shipping_methods')->count();
        $activeMethods = DB::table('site_shipping_methods')->where('enable', true)->count();
        $trackableMethods = DB::table('site_shipping_methods')->where('trackable', true)->count();
        $signatureMethods = DB::table('site_shipping_methods')->where('requires_signature', true)->count();

        return [
            'total' => $totalMethods,
            'active' => $activeMethods,
            'inactive' => $totalMethods - $activeMethods,
            'trackable' => $trackableMethods,
            'signature_required' => $signatureMethods,
        ];
    }
}