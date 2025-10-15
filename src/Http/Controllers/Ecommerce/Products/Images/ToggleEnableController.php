<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Image 활성/비활성 토글 컨트롤러
 */
class ToggleEnableController extends Controller
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

            $newEnableStatus = !$image->enable;

            // 이미지 상태 변경
            DB::table($this->config['table'])
                ->where('id', $imageId)
                ->where('product_id', $productId)
                ->update([
                    'enable' => $newEnableStatus,
                    'updated_at' => now(),
                ]);

            // 비활성화하는 경우, 대표 이미지였다면 다른 이미지를 대표로 설정
            if (!$newEnableStatus && $image->is_featured) {
                // 현재 이미지의 대표 설정 해제
                DB::table($this->config['table'])
                    ->where('id', $imageId)
                    ->update(['is_featured' => false]);

                // 다른 활성화된 이미지 중 첫 번째를 대표로 설정
                $nextFeaturedImage = DB::table($this->config['table'])
                    ->where('product_id', $productId)
                    ->where('id', '!=', $imageId)
                    ->where('enable', true)
                    ->whereNull('deleted_at')
                    ->orderBy('pos')
                    ->orderBy('created_at')
                    ->first();

                if ($nextFeaturedImage) {
                    DB::table($this->config['table'])
                        ->where('id', $nextFeaturedImage->id)
                        ->update(['is_featured' => true]);
                }
            }

            DB::commit();

            $message = $newEnableStatus ? '이미지가 활성화되었습니다.' : '이미지가 비활성화되었습니다.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'enable' => $newEnableStatus,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => '이미지 상태 변경 중 오류가 발생했습니다: ' . $e->getMessage(),
            ], 500);
        }
    }
}