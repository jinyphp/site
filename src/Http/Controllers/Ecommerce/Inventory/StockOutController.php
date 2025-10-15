<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 재고 출고 관리 컨트롤러
 */
class StockOutController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'inventory',
            'view' => 'jiny-site::ecommerce.inventory.stock-out',
            'title' => '재고 출고',
            'subtitle' => '상품 재고 출고를 관리합니다.',
            'per_page' => 15,
        ];
    }

    /**
     * 재고 출고 목록 또는 출고 페이지 표시
     */
    public function __invoke(Request $request)
    {
        // 최근 출고 내역 조회
        $stockOutHistory = $this->getStockOutHistory();

        // 재고가 있는 상품 목록 (출고할 상품 선택용)
        $inventories = $this->getAvailableInventories();

        // 통계 정보
        $stats = $this->getStockOutStats();

        return view($this->config['view'], [
            'stockOutHistory' => $stockOutHistory,
            'inventories' => $inventories,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    /**
     * 재고 출고 처리
     */
    public function process(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // 현재 재고 확인
            $inventory = DB::table('inventory')
                ->where('id', $request->inventory_id)
                ->first();

            if (!$inventory) {
                return redirect()->back()->with('error', '재고 정보를 찾을 수 없습니다.');
            }

            if ($inventory->quantity_on_hand < $request->quantity) {
                return redirect()->back()->with('error', '출고하려는 수량이 현재 재고보다 많습니다. (현재 재고: ' . $inventory->quantity_on_hand . ')');
            }

            $previousQuantity = $inventory->quantity_on_hand;
            $newQuantity = $previousQuantity - $request->quantity;

            // 재고 차감
            DB::table('inventory')
                ->where('id', $request->inventory_id)
                ->update([
                    'quantity_on_hand' => $newQuantity,
                    'last_updated_at' => now(),
                    'last_updated_by' => auth()->user()->name ?? 'System',
                    'updated_at' => now(),
                ]);

            // 출고 내역 기록
            DB::table('inventory_transactions')->insert([
                'product_id' => $inventory->product_id,
                'inventory_item_id' => $request->inventory_id,
                'type' => 'outbound',
                'reason' => $request->reason,
                'quantity' => $request->quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'unit_cost' => $inventory->last_cost ?? 0,
                'total_cost' => ($inventory->last_cost ?? 0) * $request->quantity,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', '재고 출고가 완료되었습니다.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '재고 출고 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 최근 출고 내역 조회
     */
    protected function getStockOutHistory()
    {
        return DB::table('inventory_transactions')
            ->leftJoin('inventory', 'inventory_transactions.inventory_item_id', '=', 'inventory.id')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->leftJoin('users', 'inventory_transactions.created_by', '=', 'users.id')
            ->where('inventory_transactions.type', 'outbound')
            ->select(
                'inventory_transactions.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'inventory.location',
                'users.name as created_by_name'
            )
            ->orderBy('inventory_transactions.created_at', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * 출고 가능한 재고 목록 조회
     */
    protected function getAvailableInventories()
    {
        return DB::table('inventory')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->where('inventory.quantity_on_hand', '>', 0)
            ->select(
                'inventory.id',
                'inventory.quantity_on_hand as quantity',
                'inventory.location',
                'products.name as product_name',
                'products.sku as product_sku'
            )
            ->orderBy('products.name')
            ->get();
    }

    /**
     * 출고 통계 정보
     */
    protected function getStockOutStats()
    {
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');

        return [
            'today_count' => DB::table('inventory_transactions')
                ->where('type', 'outbound')
                ->whereDate('created_at', $today)
                ->count(),
            'today_quantity' => DB::table('inventory_transactions')
                ->where('type', 'outbound')
                ->whereDate('created_at', $today)
                ->sum('quantity'),
            'month_count' => DB::table('inventory_transactions')
                ->where('type', 'outbound')
                ->where('created_at', 'like', $thisMonth . '%')
                ->count(),
            'month_quantity' => DB::table('inventory_transactions')
                ->where('type', 'outbound')
                ->where('created_at', 'like', $thisMonth . '%')
                ->sum('quantity'),
            'reasons' => DB::table('inventory_transactions')
                ->where('type', 'outbound')
                ->where('created_at', 'like', $thisMonth . '%')
                ->select('reason', DB::raw('COUNT(*) as count'), DB::raw('SUM(quantity) as total_quantity'))
                ->groupBy('reason')
                ->orderBy('count', 'desc')
                ->get(),
        ];
    }
}