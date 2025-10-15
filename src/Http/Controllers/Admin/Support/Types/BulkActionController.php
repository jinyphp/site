<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 유형 벌크 작업 컨트롤러
 */
class BulkActionController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 벌크 작업 처리
     */
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:delete,enable,disable,update_priority,update_assignee',
            'selected_ids' => 'required|string',
            'priority' => 'nullable|in:low,normal,high,urgent',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $selectedIds = explode(',', $validatedData['selected_ids']);
        $selectedIds = array_filter($selectedIds, 'is_numeric');

        if (empty($selectedIds)) {
            return response()->json(['success' => false, 'message' => '선택된 항목이 없습니다.'], 400);
        }

        $types = SiteSupportType::whereIn('id', $selectedIds)->get();
        $processedCount = 0;
        $errors = [];

        foreach ($types as $type) {
            try {
                switch ($validatedData['action']) {
                    case 'delete':
                        // 관련 지원 요청이 있는지 확인
                        $relatedCount = $type->supportRequests()->count();
                        if ($relatedCount > 0) {
                            $errors[] = "'{$type->name}': 관련 지원 요청 {$relatedCount}개가 있어 삭제할 수 없습니다.";
                            continue 2;
                        }
                        $type->delete();
                        $processedCount++;
                        break;

                    case 'enable':
                        $type->update(['enable' => true]);
                        $processedCount++;
                        break;

                    case 'disable':
                        $type->update(['enable' => false]);
                        $processedCount++;
                        break;

                    case 'update_priority':
                        if (isset($validatedData['priority'])) {
                            $type->update(['default_priority' => $validatedData['priority']]);
                            $processedCount++;
                        }
                        break;

                    case 'update_assignee':
                        $type->update(['default_assignee_id' => $validatedData['assignee_id']]);
                        $processedCount++;
                        break;
                }
            } catch (\Exception $e) {
                $errors[] = "'{$type->name}': " . $e->getMessage();
            }
        }

        // 로그 기록
        \Log::info('Support types bulk action performed', [
            'action' => $validatedData['action'],
            'processed_count' => $processedCount,
            'total_selected' => count($selectedIds),
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name,
            'errors' => $errors
        ]);

        $message = "총 {$processedCount}개 항목이 처리되었습니다.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . "개 항목에서 오류가 발생했습니다.";
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'processed_count' => $processedCount,
                'errors' => $errors
            ]);
        }

        $sessionMessage = $message;
        if (!empty($errors)) {
            $sessionMessage .= ' 오류 내용: ' . implode(', ', $errors);
        }

        return redirect()->route('admin.cms.support.types.index')
            ->with('success', $sessionMessage);
    }
}