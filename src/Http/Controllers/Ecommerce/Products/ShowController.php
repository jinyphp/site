<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Products 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_products',
            'view' => 'jiny-site::ecommerce.products.show',
            'title' => 'Product 상세보기',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 상품 정보 조회 (카테고리 포함)
        $product = DB::table($this->config['table'])
            ->leftJoin('site_product_categories', 'site_products.category_id', '=', 'site_product_categories.id')
            ->select(
                'site_products.id',
                'site_products.slug',
                'site_products.title',
                'site_products.description',
                'site_products.content',
                'site_products.price',
                'site_products.sale_price',
                'site_products.image',
                'site_products.images',
                'site_products.features',
                'site_products.specifications',
                'site_products.tags',
                'site_products.meta_title',
                'site_products.meta_description',
                'site_products.enable',
                'site_products.featured',
                'site_products.category_id',
                'site_products.view_count',
                'site_products.created_at',
                'site_products.updated_at',
                'site_product_categories.title as category_name',
                'site_product_categories.slug as category_slug'
            )
            ->where('site_products.id', $id)
            ->whereNull('site_products.deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route('admin.site.products.index')
                ->with('error', 'Product를 찾을 수 없습니다.');
        }

        // 가격 옵션 조회
        $pricingOptions = DB::table('site_product_pricing')
            ->where('product_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('price')
            ->get();

        // 이미지 갤러리 조회
        $images = DB::table('site_product_images')
            ->where('product_id', $id)
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('featured', 'desc')
            ->orderBy('pos')
            ->get();

        return view($this->config['view'], [
            'product' => $product,
            'pricingOptions' => $pricingOptions,
            'images' => $images,
            'config' => $this->config,
        ]);
    }
}