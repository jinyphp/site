<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 생성 컨트롤러
 */
class StoreController extends BaseController
{
    /**
     * 상담 유형 생성
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        try {
            SiteContactType::create([
                'name' => $request->name,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'enable' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => '상담 유형이 생성되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상담 유형 생성에 실패했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}