<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Categories 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_categories',
            'redirect_route' => 'admin.site.products.categories.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $category = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$category) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Product Category를 찾을 수 없습니다.');
        }

        // 하위 카테고리가 있는지 확인
        $hasChildren = DB::table($this->config['table'])
            ->where('parent_id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($hasChildren) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', '하위 카테고리가 있는 카테고리는 삭제할 수 없습니다. 먼저 하위 카테고리를 삭제하거나 이동시켜 주세요.');
        }

        // 이 카테고리를 사용하는 상품이 있는지 확인
        $hasProducts = DB::table('site_products')
            ->where('category_id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($hasProducts) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', '이 카테고리에 속한 상품이 있어 삭제할 수 없습니다. 먼저 상품들의 카테고리를 변경해 주세요.');
        }

        // Soft delete
        DB::table($this->config['table'])
            ->where('id', $id)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Product Category가 성공적으로 삭제되었습니다.');
    }
}