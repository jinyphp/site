<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 이커머스 대시보드 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 페이지 설정
        $config = [
            'title' => '이커머스 대시보드',
            'description' => '온라인 상점 운영 현황을 한눈에 확인하세요',
        ];

        // 대시보드 통계 데이터
        $stats = $this->getDashboardStats();

        // 최근 주문 데이터
        $recentOrders = $this->getRecentOrders();

        // 매출 차트 데이터
        $salesChart = $this->getSalesChartData();

        // 차트 데이터 (기존 템플릿 호환)
        $chartData = [
            'daily_stats' => $salesChart
        ];

        return view('jiny-site::ecommerce.dashboard.index', compact(
            'config',
            'stats',
            'recentOrders',
            'salesChart',
            'chartData'
        ));
    }

    /**
     * 대시보드 통계 데이터 조회
     */
    private function getDashboardStats()
    {
        try {
            // 주문 관련 통계 (실제 주문 테이블이 있다면 조정 필요)
            $totalOrders = DB::table('site_cart')->count();
            $todayOrders = DB::table('site_cart')
                ->whereDate('created_at', today())
                ->count();

            // 매출 통계 (임시 데이터)
            $totalSales = DB::table('site_cart')
                ->sum(DB::raw('CAST(price AS DECIMAL(10,2))')) ?? 0;

            $todaySales = DB::table('site_cart')
                ->whereDate('created_at', today())
                ->sum(DB::raw('CAST(price AS DECIMAL(10,2))')) ?? 0;

            // 이번 달 매출 (임시 계산)
            $thisMonthSales = $totalSales * 0.3; // 실제로는 이번 달 데이터를 조회해야 함

            // 성장률 (임시 계산)
            $growthRate = 15.8; // 실제로는 전월 대비 계산

            // 배송 통계
            $processingOrders = round($totalOrders * 0.2);
            $shippedOrders = round($totalOrders * 0.5);
            $deliveredOrders = round($totalOrders * 0.25);
            $cancelledOrders = round($totalOrders * 0.05);

            // 고객 통계 (임시 데이터)
            $totalCustomers = max(100, $totalOrders * 0.7); // 최소 100명
            $activeCustomers = round($totalCustomers * 0.6);

            // 상품 통계 (임시 데이터)
            $totalProducts = 50; // 기본값
            $activeProducts = 45;
            $outOfStockProducts = 3;
            $lowStockProducts = 7;

            // 통화 정보
            $activeCurrencies = 3; // KRW, USD, EUR
            $lastExchangeUpdate = true; // 최근 업데이트됨

            return [
                // 매출 정보
                'revenue' => [
                    'this_month' => round($thisMonthSales),
                    'growth_rate' => $growthRate,
                ],

                // 주문 정보
                'orders' => [
                    'total' => $totalOrders,
                    'today' => $todayOrders,
                    'processing' => $processingOrders,
                    'shipped' => $shippedOrders,
                    'delivered' => $deliveredOrders,
                    'cancelled' => $cancelledOrders,
                ],

                // 고객 정보
                'customers' => [
                    'total' => round($totalCustomers),
                    'active' => $activeCustomers,
                ],

                // 상품 정보
                'products' => [
                    'total' => $totalProducts,
                    'active' => $activeProducts,
                    'out_of_stock' => $outOfStockProducts,
                    'low_stock' => $lowStockProducts,
                ],

                // 통화 정보
                'currency' => [
                    'active_currencies' => $activeCurrencies,
                    'last_exchange_update' => $lastExchangeUpdate,
                ],

                // 레거시 호환
                'total_orders' => $totalOrders,
                'today_orders' => $todayOrders,
                'total_sales' => $totalSales,
                'today_sales' => $todaySales,
                'pending_shipments' => $processingOrders,
                'shipped_orders' => $shippedOrders,
            ];
        } catch (\Exception $e) {
            // 테이블이 없는 경우 기본값 반환
            return [
                'revenue' => [
                    'this_month' => 0,
                    'growth_rate' => 0,
                ],
                'orders' => [
                    'total' => 0,
                    'today' => 0,
                    'processing' => 0,
                    'shipped' => 0,
                    'delivered' => 0,
                    'cancelled' => 0,
                ],
                'customers' => [
                    'total' => 0,
                    'active' => 0,
                ],
                'products' => [
                    'total' => 0,
                    'active' => 0,
                    'out_of_stock' => 0,
                    'low_stock' => 0,
                ],
                'currency' => [
                    'active_currencies' => 0,
                    'last_exchange_update' => false,
                ],
                // 레거시 호환
                'total_orders' => 0,
                'today_orders' => 0,
                'total_sales' => 0,
                'today_sales' => 0,
                'pending_shipments' => 0,
                'shipped_orders' => 0,
            ];
        }
    }

    /**
     * 최근 주문 데이터 조회
     */
    private function getRecentOrders()
    {
        try {
            return DB::table('site_cart')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($order, $index) {
                    // 주문 상태 랜덤 생성
                    $statuses = ['processing', 'shipped', 'delivered', 'processing'];
                    $statusIndex = $index % count($statuses);

                    // 고객명 생성 (임시)
                    $customerNames = [
                        '김철수', '이영희', '박민수', '최정은', '홍길동',
                        '송지은', '정수현', '강민우', '윤서연', '임도현'
                    ];
                    $customerName = $customerNames[$index % count($customerNames)];

                    return [
                        'id' => $order->id ?? "ORD-" . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                        'customer_name' => $customerName,
                        'product' => $order->title ?? '상품명 없음',
                        'amount' => $order->price ?? rand(10000, 100000),
                        'currency' => 'KRW',
                        'price' => $order->price ?? 0, // 레거시 호환
                        'created_at' => \Carbon\Carbon::parse($order->created_at ?? now()),
                        'status' => $statuses[$statusIndex],
                    ];
                });
        } catch (\Exception $e) {
            // 기본 데이터 반환
            $dummyOrders = collect();
            for ($i = 0; $i < 5; $i++) {
                $statuses = ['processing', 'shipped', 'delivered'];
                $customerNames = ['김철수', '이영희', '박민수', '최정은', '홍길동'];

                $dummyOrders->push([
                    'id' => "ORD-" . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                    'customer_name' => $customerNames[$i % count($customerNames)],
                    'product' => '샘플 상품 ' . ($i + 1),
                    'amount' => rand(20000, 80000),
                    'currency' => 'KRW',
                    'price' => rand(20000, 80000),
                    'created_at' => \Carbon\Carbon::now()->subMinutes($i * 30),
                    'status' => $statuses[$i % count($statuses)],
                ]);
            }
            return $dummyOrders;
        }
    }

    /**
     * 매출 차트 데이터 조회
     */
    private function getSalesChartData()
    {
        try {
            // 최근 7일간 매출 데이터
            $salesData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $sales = DB::table('site_cart')
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->sum(DB::raw('CAST(price AS DECIMAL(10,2))')) ?? 0;

                $salesData[] = [
                    'date' => $date->format('m/d'),
                    'sales' => $sales,
                ];
            }

            return $salesData;
        } catch (\Exception $e) {
            // 기본 데이터 반환
            $salesData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $salesData[] = [
                    'date' => $date->format('m/d'),
                    'sales' => rand(50000, 200000),
                ];
            }
            return $salesData;
        }
    }
}