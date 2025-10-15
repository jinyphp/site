<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Image 대표 이미지 토글 컨트롤러
 */
class ToggleFeaturedController extends Controller
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

        // 이미지 존재 확인
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

        try {
            DB::beginTransaction();

            $newFeaturedStatus = !$image->is_featured;

            if ($newFeaturedStatus) {
                // 대표 이미지로 설정하는 경우, 기존 대표 이미지 해제
                DB::table($this->config['table'])
                    ->where('product_id', $productId)
                    ->where('id', '!=', $imageId)
                    ->update(['is_featured' => false]);
            }

            // 현재 이미지 상태 변경
            DB::table($this->config['table'])
                ->where('id', $imageId)
                ->where('product_id', $productId)
                ->update([
                    'is_featured' => $newFeaturedStatus,
                    'updated_at' => now(),
                ]);

            DB::commit();

            $message = $newFeaturedStatus ? '대표 이미지로 설정되었습니다.' : '대표 이미지 설정이 해제되었습니다.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_featured' => $newFeaturedStatus,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => '대표 이미지 설정 변경 중 오류가 발생했습니다: ' . $e->getMessage(),
            ], 500);
        }
    }
}