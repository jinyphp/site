<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Product Image 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_images',
            'soft_delete' => true, // 소프트 삭제 사용
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

            if ($this->config['soft_delete']) {
                // 소프트 삭제
                DB::table($this->config['table'])
                    ->where('id', $imageId)
                    ->where('product_id', $productId)
                    ->update([
                        'deleted_at' => now(),
                        'updated_at' => now(),
                    ]);

                $message = '이미지가 성공적으로 삭제되었습니다 (복구 가능).';
            } else {
                // 물리적 삭제
                DB::table($this->config['table'])
                    ->where('id', $imageId)
                    ->where('product_id', $productId)
                    ->delete();

                // 실제 파일도 삭제
                $this->deletePhysicalFiles($image);

                $message = '이미지가 완전히 삭제되었습니다.';
            }

            // 대표 이미지였다면 다른 이미지를 대표로 설정
            if ($image->is_featured) {
                $this->reassignFeaturedImage($productId);
            }

            // 위치 정렬
            $this->reorderPositions($productId);

            DB::commit();

            // JSON 응답
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                ]);
            }

            // 일반 응답
            return redirect()
                ->route('admin.site.products.images.index', $productId)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미지 삭제 중 오류가 발생했습니다: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', '이미지 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 실제 파일 삭제
     */
    private function deletePhysicalFiles($image)
    {
        try {
            // 원본 파일 삭제
            if ($image->image_url) {
                $imagePath = str_replace('/storage/', '', $image->image_url);
                Storage::disk('public')->delete($imagePath);
            }

            // 썸네일 파일 삭제
            if ($image->thumbnail_url) {
                $thumbnailPath = str_replace('/storage/', '', $image->thumbnail_url);
                Storage::disk('public')->delete($thumbnailPath);
            }
        } catch (\Exception $e) {
            // 파일 삭제 실패해도 데이터베이스 삭제는 진행
        }
    }

    /**
     * 대표 이미지 재설정
     */
    private function reassignFeaturedImage($productId)
    {
        // 활성화된 첫 번째 이미지를 대표로 설정
        $firstImage = DB::table($this->config['table'])
            ->where('product_id', $productId)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('created_at')
            ->first();

        if ($firstImage) {
            DB::table($this->config['table'])
                ->where('id', $firstImage->id)
                ->update(['is_featured' => true]);
        }
    }

    /**
     * 위치 재정렬
     */
    private function reorderPositions($productId)
    {
        $images = DB::table($this->config['table'])
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('created_at')
            ->get();

        foreach ($images as $index => $image) {
            DB::table($this->config['table'])
                ->where('id', $image->id)
                ->update(['pos' => $index + 1]);
        }
    }
}