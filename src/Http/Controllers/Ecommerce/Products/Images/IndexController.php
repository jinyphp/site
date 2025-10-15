<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Images 관리 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_images',
            'view' => 'jiny-site::ecommerce.products.images.index',
            'title' => 'Product 이미지 갤러리',
            'subtitle' => '상품 이미지를 관리합니다.',
        ];
    }

    public function __invoke(Request $request, $productId)
    {
        // 상품 정보 조회 (카테고리 포함)
        $product = DB::table('site_products')
            ->leftJoin('site_product_categories', 'site_products.category_id', '=', 'site_product_categories.id')
            ->select(
                'site_products.*',
                'site_product_categories.title as category_name'
            )
            ->where('site_products.id', $productId)
            ->whereNull('site_products.deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route('admin.site.products.index')
                ->with('error', 'Product를 찾을 수 없습니다.');
        }

        // 이미지 목록 조회
        $images = DB::table($this->config['table'])
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('created_at')
            ->get()
            ->map(function ($image) {
                // 이미지 타입 라벨 추가
                $typeLabels = [
                    'main' => '메인',
                    'detail' => '상세',
                    'lifestyle' => '라이프스타일',
                    'tech_spec' => '기술 사양',
                    'packaging' => '패키징',
                    'comparison' => '비교',
                    'installation' => '설치 가이드',
                    'accessories' => '액세서리',
                ];
                $image->image_type_label = $typeLabels[$image->image_type] ?? '기타';

                // 파일 크기 포맷
                if ($image->file_size) {
                    $bytes = (int) $image->file_size;
                    if ($bytes >= 1048576) {
                        $image->formatted_file_size = round($bytes / 1048576, 1) . ' MB';
                    } elseif ($bytes >= 1024) {
                        $image->formatted_file_size = round($bytes / 1024, 1) . ' KB';
                    } else {
                        $image->formatted_file_size = $bytes . ' B';
                    }
                } else {
                    $image->formatted_file_size = null;
                }

                return $image;
            });

        // 통계
        $stats = [
            'total' => $images->count(),
            'enabled' => $images->where('enable', true)->count(),
            'featured' => $images->where('is_featured', true)->count(),
        ];

        return view($this->config['view'], [
            'product' => $product,
            'images' => $images,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }
}