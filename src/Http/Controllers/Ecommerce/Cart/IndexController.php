<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 관리자 장바구니 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 검색 및 필터링 파라미터
        $search = $request->get('search');
        $user_type = $request->get('user_type'); // guest, member
        $item_type = $request->get('item_type'); // product, service
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $perPage = $request->get('per_page', 20);

        // 베이스 쿼리
        $query = DB::table('site_cart')
            ->leftJoin('site_products', function($join) {
                $join->on('site_cart.item_id', '=', 'site_products.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->leftJoin('site_services', function($join) {
                $join->on('site_cart.item_id', '=', 'site_services.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->leftJoin('site_product_pricing', function($join) {
                $join->on('site_cart.pricing_option_id', '=', 'site_product_pricing.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->leftJoin('site_service_pricing', function($join) {
                $join->on('site_cart.pricing_option_id', '=', 'site_service_pricing.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->leftJoin('users', 'site_cart.user_id', '=', 'users.id')
            ->select(
                'site_cart.*',
                // 상품 정보
                'site_products.title as product_title',
                'site_products.price as product_price',
                'site_products.sale_price as product_sale_price',
                // 서비스 정보
                'site_services.title as service_title',
                'site_services.price as service_price',
                'site_services.sale_price as service_sale_price',
                // 가격 옵션 정보
                'site_product_pricing.name as product_pricing_name',
                'site_product_pricing.price as product_pricing_price',
                'site_service_pricing.name as service_pricing_name',
                'site_service_pricing.price as service_pricing_price',
                // 사용자 정보
                'users.name as user_name',
                'users.email as user_email'
            )
            ->whereNull('site_cart.deleted_at');

        // 필터링 적용
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('site_products.title', 'like', "%{$search}%")
                  ->orWhere('site_services.title', 'like', "%{$search}%")
                  ->orWhere('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('site_cart.session_id', 'like', "%{$search}%");
            });
        }

        if ($user_type === 'guest') {
            $query->whereNull('site_cart.user_id');
        } elseif ($user_type === 'member') {
            $query->whereNotNull('site_cart.user_id');
        }

        if ($item_type) {
            $query->where('site_cart.item_type', $item_type);
        }

        if ($dateFrom) {
            $query->where('site_cart.created_at', '>=', $dateFrom . ' 00:00:00');
        }

        if ($dateTo) {
            $query->where('site_cart.created_at', '<=', $dateTo . ' 23:59:59');
        }

        // 정렬 및 페이지네이션
        $cartItems = $query->orderBy('site_cart.created_at', 'desc')
                          ->paginate($perPage);

        // 각 아이템의 정보 정리
        $cartItems->getCollection()->transform(function($item) {
            if ($item->item_type === 'product') {
                $item->item_title = $item->product_title;
                $item->base_price = $item->product_price;
                $item->sale_price = $item->product_sale_price;
                $item->pricing_name = $item->product_pricing_name;
                $item->pricing_price = $item->product_pricing_price;
            } else {
                $item->item_title = $item->service_title;
                $item->base_price = $item->service_price;
                $item->sale_price = $item->service_sale_price;
                $item->pricing_name = $item->service_pricing_name;
                $item->pricing_price = $item->service_pricing_price;
            }

            // 최종 가격 계산
            $item->final_price = $item->pricing_price ?: ($item->sale_price ?: $item->base_price);
            $item->total_price = $item->final_price * $item->quantity;

            // 사용자 타입 결정
            $item->user_type = $item->user_id ? 'member' : 'guest';
            $item->user_display = $item->user_id
                ? ($item->user_name ?: $item->user_email)
                : '비회원 (' . substr($item->session_id, 0, 8) . '...)';

            return $item;
        });

        // 통계 데이터
        $stats = $this->getCartStats();

        // 추가 인사이트 데이터
        $insights = $this->getCartInsights();
        $popularItems = $this->getPopularItems();
        $longTermInterests = $this->getLongTermInterests();

        return view('jiny-site::ecommerce.cart.index', [
            'cartItems' => $cartItems,
            'stats' => $stats,
            'insights' => $insights,
            'popularItems' => $popularItems,
            'longTermInterests' => $longTermInterests,
            'filters' => [
                'search' => $search,
                'user_type' => $user_type,
                'item_type' => $item_type,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'per_page' => $perPage,
            ]
        ]);
    }

    /**
     * 장바구니 통계 데이터 조회
     */
    private function getCartStats()
    {
        $today = now()->startOfDay();
        $weekAgo = now()->subWeek()->startOfDay();
        $monthAgo = now()->subMonth()->startOfDay();

        return [
            'total_items' => DB::table('site_cart')->whereNull('deleted_at')->count(),
            'total_quantity' => DB::table('site_cart')->whereNull('deleted_at')->sum('quantity'),
            'total_users' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->distinct()
                ->count(DB::raw('COALESCE(user_id, session_id)')),
            'today_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->where('created_at', '>=', $today)
                ->count(),
            'week_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->where('created_at', '>=', $weekAgo)
                ->count(),
            'month_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->where('created_at', '>=', $monthAgo)
                ->count(),
            'member_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->whereNotNull('user_id')
                ->count(),
            'guest_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->whereNull('user_id')
                ->count(),
            'product_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->where('item_type', 'product')
                ->count(),
            'service_items' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->where('item_type', 'service')
                ->count(),
        ];
    }

    /**
     * 장바구니 인사이트 데이터 조회
     */
    private function getCartInsights()
    {
        $sevenDaysAgo = now()->subDays(7);
        $thirtyDaysAgo = now()->subDays(30);

        return [
            // 평균 장바구니 보관 기간
            'avg_cart_duration' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->selectRaw('AVG(JULIANDAY("now") - JULIANDAY(created_at)) as avg_days')
                ->value('avg_days'),

            // 회원별 평균 장바구니 아이템 수
            'avg_items_per_user' => DB::table('site_cart')
                ->whereNull('deleted_at')
                ->whereNotNull('user_id')
                ->selectRaw('AVG(quantity) as avg_quantity')
                ->value('avg_quantity'),

            // 최근 7일 vs 이전 7일 증감률
            'week_growth_rate' => $this->calculateGrowthRate($sevenDaysAgo, 7),

            // 고가 상품 관심도 (10만원 이상)
            'high_value_interest' => DB::table('site_cart')
                ->leftJoin('site_products', function($join) {
                    $join->on('site_cart.item_id', '=', 'site_products.id')
                         ->where('site_cart.item_type', '=', 'product');
                })
                ->leftJoin('site_services', function($join) {
                    $join->on('site_cart.item_id', '=', 'site_services.id')
                         ->where('site_cart.item_type', '=', 'service');
                })
                ->whereNull('site_cart.deleted_at')
                ->where(function($query) {
                    $query->where('site_products.price', '>=', 100000)
                          ->orWhere('site_services.price', '>=', 100000);
                })
                ->count(),
        ];
    }

    /**
     * 인기 상품/서비스 목록 조회
     */
    private function getPopularItems()
    {
        // 상품 인기 순위
        $popularProducts = DB::table('site_cart')
            ->leftJoin('site_products', function($join) {
                $join->on('site_cart.item_id', '=', 'site_products.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->whereNull('site_cart.deleted_at')
            ->where('site_cart.item_type', 'product')
            ->whereNotNull('site_products.title')
            ->selectRaw('
                site_cart.item_id,
                site_products.title,
                site_products.price,
                COUNT(*) as cart_count,
                SUM(site_cart.quantity) as total_quantity,
                COUNT(DISTINCT COALESCE(site_cart.user_id, site_cart.session_id)) as unique_users
            ')
            ->groupBy('site_cart.item_id', 'site_products.title', 'site_products.price')
            ->orderByDesc('cart_count')
            ->limit(10)
            ->get();

        // 서비스 인기 순위
        $popularServices = DB::table('site_cart')
            ->leftJoin('site_services', function($join) {
                $join->on('site_cart.item_id', '=', 'site_services.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->whereNull('site_cart.deleted_at')
            ->where('site_cart.item_type', 'service')
            ->whereNotNull('site_services.title')
            ->selectRaw('
                site_cart.item_id,
                site_services.title,
                site_services.price,
                COUNT(*) as cart_count,
                SUM(site_cart.quantity) as total_quantity,
                COUNT(DISTINCT COALESCE(site_cart.user_id, site_cart.session_id)) as unique_users
            ')
            ->groupBy('site_cart.item_id', 'site_services.title', 'site_services.price')
            ->orderByDesc('cart_count')
            ->limit(10)
            ->get();

        return [
            'products' => $popularProducts,
            'services' => $popularServices
        ];
    }

    /**
     * 장기간 관심 상품 분석 (30일 이상 장바구니에 보관)
     */
    private function getLongTermInterests()
    {
        $thirtyDaysAgo = now()->subDays(30);

        return DB::table('site_cart')
            ->leftJoin('site_products', function($join) {
                $join->on('site_cart.item_id', '=', 'site_products.id')
                     ->where('site_cart.item_type', '=', 'product');
            })
            ->leftJoin('site_services', function($join) {
                $join->on('site_cart.item_id', '=', 'site_services.id')
                     ->where('site_cart.item_type', '=', 'service');
            })
            ->leftJoin('users', 'site_cart.user_id', '=', 'users.id')
            ->whereNull('site_cart.deleted_at')
            ->where('site_cart.created_at', '<=', $thirtyDaysAgo)
            ->selectRaw('
                site_cart.*,
                COALESCE(site_products.title, site_services.title) as item_title,
                COALESCE(site_products.price, site_services.price) as item_price,
                users.name as user_name,
                users.email as user_email,
                JULIANDAY("now") - JULIANDAY(site_cart.created_at) as days_in_cart
            ')
            ->orderByDesc('days_in_cart')
            ->limit(20)
            ->get();
    }

    /**
     * 증감률 계산
     */
    private function calculateGrowthRate($periodStart, $days)
    {
        $currentPeriod = DB::table('site_cart')
            ->whereNull('deleted_at')
            ->where('created_at', '>=', $periodStart)
            ->count();

        $previousPeriodStart = $periodStart->copy()->subDays($days);
        $previousPeriod = DB::table('site_cart')
            ->whereNull('deleted_at')
            ->where('created_at', '>=', $previousPeriodStart)
            ->where('created_at', '<', $periodStart)
            ->count();

        if ($previousPeriod == 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }

        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 1);
    }
}