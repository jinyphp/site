<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Categories 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_categories',
            'view' => 'jiny-site::ecommerce.products.categories.edit',
            'title' => 'Product Category 수정',
            'subtitle' => '상품 카테고리 정보를 수정합니다.',
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
        } else {
            $category->parent = null;
        }

        // 부모 카테고리 목록 조회 (자기 자신과 하위 카테고리 제외)
        $parentCategories = DB::table($this->config['table'])
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->where('id', '!=', $id)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        // 하위 카테고리 조회
        $subCategories = DB::table($this->config['table'])
            ->where('parent_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('title')
            ->get();

        return view($this->config['view'], [
            'category' => $category,
            'parentCategories' => $parentCategories,
            'subCategories' => $subCategories,
            'config' => $this->config,
        ]);
    }
}