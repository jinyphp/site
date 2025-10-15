<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Image 상세 조회 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_images',
        ];
    }

    public function __invoke(Request $request, $productId, $imageId)
    {
        // 상품 존재 확인
        $product = DB::table('site_products')
            ->where('id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product를 찾을 수 없습니다.'
            ], 404);
        }

        // 이미지 조회
        $image = DB::table($this->config['table'])
            ->where('id', $imageId)
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => '이미지를 찾을 수 없습니다.'
            ], 404);
        }

        // JSON 응답인 경우
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $image,
            ]);
        }

        // 일반 요청인 경우 이미지 상세 페이지로 리다이렉트 또는 갤러리 페이지로 이동
        return redirect()
            ->route('admin.site.products.images.index', $productId)
            ->with('success', '이미지 상세 정보를 확인하세요.');
    }
}