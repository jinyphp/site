<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_inventory',
            'redirect_route' => 'admin.site.ecommerce.inventory.index',
        ];
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:site_products,id',
            'variant_id' => 'nullable|exists:site_product_variants,id',
            'quantity' => 'required|integer|min:0',
            'reserved_quantity' => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'warehouse' => 'nullable|string|max:255',
            'bin_location' => 'nullable|string|max:255',
            'unit_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'enable' => 'boolean',
        ]);

        // 중복 재고 항목 체크 (같은 상품, 변형, 위치)
        $exists = DB::table($this->config['table'])
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'] ?? null)
            ->where('location', $validated['location'] ?? '')
            ->where('warehouse', $validated['warehouse'] ?? '')
            ->where('bin_location', $validated['bin_location'] ?? '')
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['duplicate' => '동일한 상품/변형과 위치에 대한 재고 항목이 이미 존재합니다.']);
        }

        // 기본값 설정
        $validated['reserved_quantity'] = $validated['reserved_quantity'] ?? 0;
        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 0;
        $validated['unit_cost'] = $validated['unit_cost'] ?? 0;

        // 사용 가능한 수량 계산
        $validated['available_quantity'] = $validated['quantity'] - $validated['reserved_quantity'];

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table($this->config['table'])->insertGetId($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', '재고 항목이 성공적으로 생성되었습니다.');
    }
}