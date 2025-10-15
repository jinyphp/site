<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 수정 컨트롤러
 */
class UpdateController extends BaseController
{
    /**
     * 상담 유형 수정
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'enable' => 'boolean'
        ]);

        try {
            $type = SiteContactType::findOrFail($id);

            $type->update([
                'name' => $request->name,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'enable' => $request->has('enable') ? $request->enable : $type->enable
            ]);

            return response()->json([
                'success' => true,
                'message' => '상담 유형이 수정되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상담 유형 수정에 실패했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}