<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Products 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_products',
            'redirect_route' => 'admin.site.products.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $product = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Product를 찾을 수 없습니다.');
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
            ->with('success', 'Product가 성공적으로 삭제되었습니다.');
    }
}