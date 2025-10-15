<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Categories 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_categories',
            'view' => 'jiny-site::ecommerce.products.categories.show',
            'title' => 'Product Category 상세보기',
            'subtitle' => '상품 카테고리의 상세 정보를 확인합니다.',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 카테고리 조회 (부모 정보 포함)
        $category = DB::table($this->config['table'])
            ->leftJoin('site_product_categories as parent', 'site_product_categories.parent_id', '=', 'parent.id')
            ->select(
                'site_product_categories.*',
                'parent.title as parent_title',
                'parent.id as parent_id_data'
            )
            ->where('site_product_categories.id', $id)
            ->whereNull('site_product_categories.deleted_at')
            ->first();

        if (!$category) {
            return redirect()
                ->route('admin.site.products.categories.index')
                ->with('error', 'Product Category를 찾을 수 없습니다.');
        }

        // 부모 객체 생성 (존재하는 경우)
        if ($category->parent_id) {
            $category->parent = (object) [
                'id' => $category->parent_id,
                'title' => $category->parent_title,
            ];
        }

        // 하위 카테고리들 조회
        $subCategories = DB::table($this->config['table'])
            ->where('parent_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        // 이 카테고리에 속한 상품들 조회
        $products = DB::table('site_products')
            ->where('category_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(10) // 최근 10개만
            ->get();

        return view($this->config['view'], [
            'category' => $category,
            'subCategories' => $subCategories,
            'products' => $products,
            'config' => $this->config,
        ]);
    }
}