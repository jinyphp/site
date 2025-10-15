<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    public function __construct()
    {
        // Middleware applied in routes
    }

    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|in:delete,assign,status_change,priority_change',
            'selected_ids' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'nullable|in:pending,in_progress,resolved,closed',
            'priority' => 'nullable|in:low,normal,high,urgent',
        ]);

        $selectedIds = explode(',', $validatedData['selected_ids']);
        $selectedIds = array_filter($selectedIds, 'is_numeric');

        if (empty($selectedIds)) {
            return response()->json(['success' => false, 'message' => '선택된 항목이 없습니다.'], 400);
        }

        $supports = SiteSupport::whereIn('id', $selectedIds)->get();
        $processedCount = 0;
        $errors = [];

        foreach ($supports as $support) {
            try {
                switch ($validatedData['action']) {
                    case 'delete':
                        $support->delete();
                        $processedCount++;
                        break;

                    case 'assign':
                        if (isset($validatedData['assigned_to'])) {
                            $support->update([
                                'assigned_to' => $validatedData['assigned_to'],
                                'status' => $support->status === 'pending' ? 'in_progress' : $support->status
                            ]);
                            $processedCount++;
                        }
                        break;

                    case 'status_change':
                        if (isset($validatedData['status'])) {
                            $updateData = ['status' => $validatedData['status']];

                            // 상태별 추가 처리
                            if ($validatedData['status'] === 'resolved' && $support->status !== 'resolved') {
                                $updateData['resolved_at'] = now();
                            }

                            if ($validatedData['status'] === 'closed' && $support->status !== 'closed') {
                                $updateData['closed_at'] = now();
                            }

                            $support->update($updateData);
                            $processedCount++;
                        }
                        break;

                    case 'priority_change':
                        if (isset($validatedData['priority'])) {
                            $support->update(['priority' => $validatedData['priority']]);
                            $processedCount++;
                        }
                        break;
                }
            } catch (\Exception $e) {
                $errors[] = "ID {$support->id}: " . $e->getMessage();
            }
        }

        // 로그 기록
        \Log::info('Bulk action performed', [
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

        return redirect()->route('admin.cms.support.index')
            ->with('success', $sessionMessage);
    }
}