<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Products 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::ecommerce.products.create',
            'title' => 'Product 추가',
            'subtitle' => '새로운 상품을 추가합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        // 활성화된 카테고리 목록 조회
        $categories = DB::table('site_product_categories')
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        // 계층 구조로 카테고리 정리
        $categoriesHierarchy = $this->buildCategoryHierarchy($categories);

        return view($this->config['view'], [
            'config' => $this->config,
            'categories' => $categoriesHierarchy,
        ]);
    }

    /**
     * 카테고리를 계층 구조로 정리
     */
    private function buildCategoryHierarchy($categories, $parentId = null, $level = 0)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->level = $level;
                $category->display_title = str_repeat('└ ', $level) . $category->title;

                $result[] = $category;

                // 하위 카테고리 재귀 호출
                $children = $this->buildCategoryHierarchy($categories, $category->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }
}