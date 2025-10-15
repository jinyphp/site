<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 재고 알림 관리 컨트롤러
 */
class AlertsController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'inventory',
            'view' => 'jiny-site::ecommerce.inventory.alerts',
            'title' => '재고 알림',
            'subtitle' => '재고 부족 및 과다 재고 알림을 관리합니다.',
            'per_page' => 15,
        ];
    }

    /**
     * 재고 알림 목록 표시
     */
    public function __invoke(Request $request)
    {
        // 재고 부족 상품
        $lowStockItems = $this->getLowStockItems();

        // 재고 없는 상품
        $outOfStockItems = $this->getOutOfStockItems();

        // 과다 재고 상품
        $overStockItems = $this->getOverStockItems();

        // 최근 재고 변동 내역
        $recentTransactions = $this->getRecentTransactions();

        // 알림 통계
        $stats = $this->getAlertStats();

        return view($this->config['view'], [
            'lowStockItems' => $lowStockItems,
            'outOfStockItems' => $outOfStockItems,
            'overStockItems' => $overStockItems,
            'recentTransactions' => $recentTransactions,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    /**
     * 재고 부족 상품 조회
     */
    protected function getLowStockItems()
    {
        return DB::table('inventory')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->whereRaw('inventory.quantity_on_hand > 0 AND inventory.quantity_on_hand <= inventory.reorder_point')
            ->select(
                'inventory.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'inventory.quantity_on_hand as quantity',
                'inventory.reorder_point as low_stock_threshold',
                DB::raw('(inventory.reorder_point - inventory.quantity_on_hand) as shortage')
            )
            ->orderBy('shortage', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * 재고 없는 상품 조회
     */
    protected function getOutOfStockItems()
    {
        return DB::table('inventory')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->where('inventory.quantity_on_hand', '<=', 0)
            ->select(
                'inventory.*',
                'products.name as product_name',
                'products.sku as product_sku'
            )
            ->orderBy('inventory.updated_at', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * 과다 재고 상품 조회 (재고가 임계값의 3배 이상인 경우)
     */
    protected function getOverStockItems()
    {
        return DB::table('inventory')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->whereRaw('inventory.quantity_on_hand >= (inventory.reorder_point * 3)')
            ->where('inventory.reorder_point', '>', 0)
            ->select(
                'inventory.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'inventory.quantity_on_hand as quantity',
                'inventory.reorder_point as low_stock_threshold',
                DB::raw('(inventory.quantity_on_hand - inventory.reorder_point * 3) as excess')
            )
            ->orderBy('excess', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * 최근 재고 변동 내역
     */
    protected function getRecentTransactions()
    {
        return DB::table('inventory_transactions')
            ->leftJoin('inventory', 'inventory_transactions.inventory_item_id', '=', 'inventory.id')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->leftJoin('users', 'inventory_transactions.created_by', '=', 'users.id')
            ->select(
                'inventory_transactions.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'inventory.location',
                'users.name as created_by_name'
            )
            ->orderBy('inventory_transactions.created_at', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * 알림 통계 정보
     */
    protected function getAlertStats()
    {
        return [
            'low_stock_count' => DB::table('inventory')
                ->whereRaw('quantity_on_hand > 0 AND quantity_on_hand <= reorder_point')
                ->count(),
            'out_of_stock_count' => DB::table('inventory')
                ->where('quantity_on_hand', '<=', 0)
                ->count(),
            'over_stock_count' => DB::table('inventory')
                ->whereRaw('quantity_on_hand >= (reorder_point * 3)')
                ->where('reorder_point', '>', 0)
                ->count(),
            'total_items' => DB::table('inventory')
                ->count(),
            'total_value' => DB::table('inventory')
                ->selectRaw('SUM(quantity_on_hand * COALESCE(last_cost, 0)) as total')
                ->value('total') ?? 0,
            'low_stock_value' => DB::table('inventory')
                ->whereRaw('quantity_on_hand > 0 AND quantity_on_hand <= reorder_point')
                ->selectRaw('SUM(quantity_on_hand * COALESCE(last_cost, 0)) as total')
                ->value('total') ?? 0,
        ];
    }

    /**
     * 재고 임계값 업데이트
     */
    public function updateThreshold(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'reorder_point' => 'required|integer|min:0',
        ]);

        DB::table('inventory')
            ->where('id', $request->inventory_id)
            ->update([
                'reorder_point' => $request->reorder_point,
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', '재고 임계값이 업데이트되었습니다.');
    }

    /**
     * 알림 설정 업데이트
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'notification_frequency' => 'required|in:immediate,daily,weekly',
        ]);

        // 알림 설정을 데이터베이스나 설정 파일에 저장
        // 여기서는 예시로 세션에 저장
        session([
            'inventory_alert_settings' => [
                'email_notifications' => $request->boolean('email_notifications'),
                'sms_notifications' => $request->boolean('sms_notifications'),
                'notification_frequency' => $request->notification_frequency,
            ]
        ]);

        return redirect()->back()->with('success', '알림 설정이 업데이트되었습니다.');
    }
}