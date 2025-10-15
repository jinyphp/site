<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Image 수정 컨트롤러
 */
class UpdateController extends Controller
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

        // 유효성 검사
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'image_type' => 'nullable|string|in:main,detail,lifestyle,tech_spec,packaging,comparison,installation,accessories',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'enable' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // 대표 이미지 설정 처리
            if ($request->boolean('is_featured')) {
                // 기존 대표 이미지 해제
                DB::table($this->config['table'])
                    ->where('product_id', $productId)
                    ->where('id', '!=', $imageId)
                    ->update(['is_featured' => false]);
            }

            // 이미지 정보 업데이트
            $updateData = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'alt_text' => $request->input('alt_text'),
                'image_type' => $request->input('image_type', 'main'),
                'tags' => $request->input('tags'),
                'is_featured' => $request->boolean('is_featured'),
                'enable' => $request->boolean('enable', true),
                'updated_at' => now(),
            ];

            DB::table($this->config['table'])
                ->where('id', $imageId)
                ->where('product_id', $productId)
                ->update($updateData);

            DB::commit();

            // JSON 응답
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '이미지 정보가 성공적으로 수정되었습니다.',
                ]);
            }

            // 일반 응답
            return redirect()
                ->route('admin.site.products.images.index', $productId)
                ->with('success', '이미지 정보가 성공적으로 수정되었습니다.');

        } catch (\Exception $e) {
            DB::rollback();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미지 수정 중 오류가 발생했습니다: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', '이미지 수정 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}