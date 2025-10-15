<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Export;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 내보내기 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query = SiteSupport::with(['user', 'assignedTo']);

        // 필터 적용
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $supports = $query->orderBy('created_at', 'desc')->get();

        switch ($format) {
            case 'csv':
                return $this->exportCsv($supports);
            case 'excel':
                return $this->exportExcel($supports);
            case 'json':
                return $this->exportJson($supports);
            default:
                return $this->exportCsv($supports);
        }
    }

    private function exportCsv($supports)
    {
        $filename = 'support_requests_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($supports) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM 추가 (Excel에서 한글 깨짐 방지)
            fwrite($file, "\xEF\xBB\xBF");

            // 헤더 작성
            $headers = [
                'ID', '제목', '내용', '상태', '우선순위', '유형',
                '요청자명', '요청자이메일', '담당자명', '생성일시', '수정일시', '해결일시'
            ];
            fputcsv($file, $headers);

            // 데이터 작성
            foreach ($supports as $support) {
                $row = [
                    $support->id,
                    $support->title ?? $support->subject,
                    $support->content,
                    $this->getStatusLabel($support->status),
                    $this->getPriorityLabel($support->priority),
                    $this->getTypeLabel($support->type),
                    $support->user ? $support->user->name : '익명',
                    $support->user ? $support->user->email : $support->email,
                    $support->assignedTo ? $support->assignedTo->name : '미배정',
                    $support->created_at ? $support->created_at->format('Y-m-d H:i:s') : '',
                    $support->updated_at ? $support->updated_at->format('Y-m-d H:i:s') : '',
                    $support->resolved_at ? $support->resolved_at->format('Y-m-d H:i:s') : '',
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportJson($supports)
    {
        $filename = 'support_requests_' . date('Y-m-d_H-i-s') . '.json';

        $data = $supports->map(function($support) {
            return [
                'id' => $support->id,
                'title' => $support->title ?? $support->subject,
                'content' => $support->content,
                'status' => $support->status,
                'status_label' => $this->getStatusLabel($support->status),
                'priority' => $support->priority,
                'priority_label' => $this->getPriorityLabel($support->priority),
                'type' => $support->type,
                'type_label' => $this->getTypeLabel($support->type),
                'user_name' => $support->user ? $support->user->name : '익명',
                'user_email' => $support->user ? $support->user->email : $support->email,
                'assignee_name' => $support->assignedTo ? $support->assignedTo->name : null,
                'created_at' => $support->created_at ? $support->created_at->toISOString() : null,
                'updated_at' => $support->updated_at ? $support->updated_at->toISOString() : null,
                'resolved_at' => $support->resolved_at ? $support->resolved_at->toISOString() : null,
            ];
        });

        return response()->json($data)
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    private function exportExcel($supports)
    {
        // Excel 내보내기는 별도 패키지 필요 (예: maatwebsite/excel)
        // 현재는 CSV로 대체
        return $this->exportCsv($supports);
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => '대기중',
            'in_progress' => '처리중',
            'resolved' => '해결완료',
            'closed' => '종료'
        ];

        return $labels[$status] ?? $status;
    }

    private function getPriorityLabel($priority)
    {
        $labels = [
            'low' => '낮음',
            'normal' => '보통',
            'high' => '높음',
            'urgent' => '긴급'
        ];

        return $labels[$priority] ?? $priority;
    }

    private function getTypeLabel($type)
    {
        $labels = [
            'technical' => '기술지원',
            'billing' => '결제문의',
            'general' => '일반문의',
            'bug_report' => '버그리포트',
            'account' => '계정지원'
        ];

        return $labels[$type] ?? $type;
    }
}