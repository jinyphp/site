<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 유형 순서 변경 컨트롤러
 */
class UpdateOrderController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 지원 요청 유형 순서 업데이트
     */
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:site_support_types,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        $updatedCount = 0;
        $errors = [];

        foreach ($validatedData['items'] as $item) {
            try {
                SiteSupportType::where('id', $item['id'])
                    ->update(['sort_order' => $item['sort_order']]);
                $updatedCount++;
            } catch (\Exception $e) {
                $errors[] = "ID {$item['id']}: " . $e->getMessage();
            }
        }

        // 로그 기록
        \Log::info('Support types order updated', [
            'updated_count' => $updatedCount,
            'total_items' => count($validatedData['items']),
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name,
            'errors' => $errors
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $updatedCount > 0,
                'message' => "{$updatedCount}개 항목의 순서가 업데이트되었습니다.",
                'updated_count' => $updatedCount,
                'errors' => $errors
            ]);
        }

        $message = "{$updatedCount}개 항목의 순서가 업데이트되었습니다.";
        if (!empty($errors)) {
            $message .= ' 일부 오류가 발생했습니다: ' . implode(', ', $errors);
        }

        return redirect()->route('admin.cms.support.types.index')
            ->with('success', $message);
    }
}