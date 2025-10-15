<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Images;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Images 순서 변경 컨트롤러
 */
class ReorderController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_images',
        ];
    }

    public function __invoke(Request $request, $productId)
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

        // 유효성 검사
        $request->validate([
            'order' => 'required|array|min:1',
            'order.*.id' => 'required|integer|exists:site_product_images,id',
            'order.*.pos' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $orders = $request->input('order');

            foreach ($orders as $orderItem) {
                // 해당 이미지가 현재 상품에 속하는지 확인
                $imageExists = DB::table($this->config['table'])
                    ->where('id', $orderItem['id'])
                    ->where('product_id', $productId)
                    ->whereNull('deleted_at')
                    ->exists();

                if (!$imageExists) {
                    throw new \Exception("이미지 ID {$orderItem['id']}는 이 상품에 속하지 않습니다.");
                }

                // 위치 업데이트
                DB::table($this->config['table'])
                    ->where('id', $orderItem['id'])
                    ->where('product_id', $productId)
                    ->update([
                        'pos' => $orderItem['pos'],
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '이미지 순서가 성공적으로 변경되었습니다.',
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => '이미지 순서 변경 중 오류가 발생했습니다: ' . $e->getMessage(),
            ], 500);
        }
    }
}