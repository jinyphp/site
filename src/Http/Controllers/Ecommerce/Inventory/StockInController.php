<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 재고 입고 관리 컨트롤러
 */
class StockInController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'inventory',
            'view' => 'jiny-site::ecommerce.inventory.stock-in',
            'title' => '재고 입고',
            'subtitle' => '상품 재고 입고를 관리합니다.',
            'per_page' => 15,
        ];
    }

    /**
     * 재고 입고 목록 또는 입고 페이지 표시
     */
    public function __invoke(Request $request)
    {
        // 최근 입고 내역 조회
        $stockInHistory = $this->getStockInHistory();

        // 상품 목록 (입고할 상품 선택용)
        $products = $this->getProducts();

        // 통계 정보
        $stats = $this->getStockInStats();

        return view($this->config['view'], [
            'stockInHistory' => $stockInHistory,
            'products' => $products,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    /**
     * 재고 입고 처리
     */
    public function process(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // 기존 재고 확인
            $inventory = DB::table('inventory')
                ->where('product_id', $request->product_id)
                ->where('location', $request->location ?? 'main_warehouse')
                ->first();

            $previousQuantity = $inventory ? $inventory->quantity_on_hand : 0;
            $newQuantity = $previousQuantity + $request->quantity;

            if ($inventory) {
                // 기존 재고 업데이트
                DB::table('inventory')
                    ->where('id', $inventory->id)
                    ->update([
                        'quantity_on_hand' => $newQuantity,
                        'last_cost' => $request->unit_cost ?? $inventory->last_cost,
                        'last_updated_at' => now(),
                        'last_updated_by' => auth()->user()->name ?? 'System',
                        'updated_at' => now(),
                    ]);
                $inventoryId = $inventory->id;
            } else {
                // 새 재고 생성
                $inventoryId = DB::table('inventory')->insertGetId([
                    'product_id' => $request->product_id,
                    'location' => $request->location ?? 'main_warehouse',
                    'quantity_on_hand' => $request->quantity,
                    'quantity_reserved' => 0,
                    'reorder_point' => 10, // 기본값
                    'reorder_quantity' => 50, // 기본값
                    'last_cost' => $request->unit_cost ?? 0,
                    'last_updated_at' => now(),
                    'last_updated_by' => auth()->user()->name ?? 'System',
                    'notes' => $request->notes,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 입고 내역 기록
            DB::table('inventory_transactions')->insert([
                'product_id' => $request->product_id,
                'inventory_item_id' => $inventoryId,
                'type' => 'inbound',
                'reason' => 'stock_in',
                'quantity' => $request->quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'unit_cost' => $request->unit_cost ?? 0,
                'total_cost' => ($request->unit_cost ?? 0) * $request->quantity,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', '재고 입고가 완료되었습니다.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '재고 입고 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 최근 입고 내역 조회
     */
    protected function getStockInHistory()
    {
        return DB::table('inventory_transactions')
            ->leftJoin('inventory', 'inventory_transactions.inventory_item_id', '=', 'inventory.id')
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->leftJoin('users', 'inventory_transactions.created_by', '=', 'users.id')
            ->where('inventory_transactions.type', 'inbound')
            ->where('inventory_transactions.reason', 'stock_in')
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
     * 상품 목록 조회
     */
    protected function getProducts()
    {
        return DB::table('products')
            ->select('id', 'name', 'sku')
            ->orderBy('name')
            ->get();
    }

    /**
     * 입고 통계 정보
     */
    protected function getStockInStats()
    {
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');

        return [
            'today_count' => DB::table('inventory_transactions')
                ->where('type', 'inbound')
                ->where('reason', 'stock_in')
                ->whereDate('created_at', $today)
                ->count(),
            'today_quantity' => DB::table('inventory_transactions')
                ->where('type', 'inbound')
                ->where('reason', 'stock_in')
                ->whereDate('created_at', $today)
                ->sum('quantity'),
            'month_count' => DB::table('inventory_transactions')
                ->where('type', 'inbound')
                ->where('reason', 'stock_in')
                ->where('created_at', 'like', $thisMonth . '%')
                ->count(),
            'month_quantity' => DB::table('inventory_transactions')
                ->where('type', 'inbound')
                ->where('reason', 'stock_in')
                ->where('created_at', 'like', $thisMonth . '%')
                ->sum('quantity'),
        ];
    }
}