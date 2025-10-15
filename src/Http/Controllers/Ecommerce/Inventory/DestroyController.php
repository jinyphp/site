<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_inventory',
            'redirect_route' => 'admin.site.ecommerce.inventory.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $inventory = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$inventory) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', '해당 재고 항목을 찾을 수 없습니다.');
        }

        // 소프트 삭제 수행
        DB::table($this->config['table'])
            ->where('id', $id)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);

        // 재고 이동 내역 기록
        $this->recordMovement($id, $inventory->quantity, 0, 'removal');

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', '재고 항목이 성공적으로 삭제되었습니다.');
    }

    protected function recordMovement($inventoryId, $oldQuantity, $newQuantity, $type = 'removal')
    {
        $movement = [
            'inventory_id' => $inventoryId,
            'type' => $type,
            'quantity_before' => $oldQuantity,
            'quantity_after' => $newQuantity,
            'quantity_change' => $newQuantity - $oldQuantity,
            'notes' => '재고 항목 삭제',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('site_inventory_movements')->insert($movement);
    }
}