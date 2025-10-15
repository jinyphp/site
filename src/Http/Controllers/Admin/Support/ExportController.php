<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 지원 요청 데이터 내보내기 컨트롤러 (Admin - Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request)
 * └── response()->json() - JSON 응답 반환 (추후 구현 예정)
 *
 * 진입 경로:
 * Route::get('/admin/support/export') → ExportController::__invoke()
 *
 * 주요 기능:
 * - 지원 요청 데이터 내보내기 (CSV, Excel 등)
 * - 관리자용 데이터 백업 및 분석
 *
 * 구현 예정 기능:
 * - CSV 형태로 지원 요청 데이터 내보내기
 * - 날짜 범위별 필터링
 * - 상태별 필터링
 * - Excel 형태 내보내기
 *
 * 권한:
 * - admin 미들웨어 적용 (관리자만 접근 가능)
 *
 * 의존성:
 * - SiteSupport 모델
 * - Admin 미들웨어
 * - Laravel Excel (추후 추가 예정)
 */
class ExportController extends Controller
{
    /**
     * 생성자
     *
     * Single Action Controller이므로 미들웨어는 라우트에서 적용됩니다.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * Single Action Controller 메인 메소드 - 지원 요청 데이터 내보내기
     *
     * 지원 요청 데이터를 다양한 형태로 내보내는 기능을 제공합니다.
     * 현재는 플레이스홀더 구현이며, 추후 실제 내보내기 기능이 구현될 예정입니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\Http\JsonResponse JSON 응답
     */
    public function __invoke(Request $request)
    {
        $format = $request->get('format', 'csv');
        $fileName = 'support_requests_' . now()->format('Y-m-d_H-i-s');

        // 필터 적용
        $query = SiteSupport::with(['user', 'assignedTo']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $supports = $query->orderBy('created_at', 'desc')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($supports, $fileName);
        } elseif ($format === 'json') {
            return $this->exportToJson($supports, $fileName);
        }

        // 기본적으로 CSV 내보내기
        return $this->exportToCsv($supports, $fileName);
    }

    /**
     * CSV 형태로 내보내기
     */
    private function exportToCsv($supports, $fileName)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}.csv\"",
        ];

        $callback = function () use ($supports) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM 추가 (엑셀에서 한글 깨짐 방지)
            fwrite($file, "\xEF\xBB\xBF");

            // 헤더 작성
            fputcsv($file, [
                'ID',
                '제목',
                '유형',
                '우선순위',
                '상태',
                '요청자명',
                '요청자이메일',
                '담당자',
                '등록일',
                '해결일',
                '응답시간(시간)',
                '내용'
            ]);

            // 데이터 작성
            foreach ($supports as $support) {
                $responseTime = '';
                if ($support->resolved_at && $support->created_at) {
                    $responseTime = $support->created_at->diffInHours($support->resolved_at);
                }

                fputcsv($file, [
                    $support->id,
                    $support->subject,
                    $this->getTypeLabel($support->type),
                    $this->getPriorityLabel($support->priority),
                    $this->getStatusLabel($support->status),
                    $support->user ? $support->user->name : ($support->name ?? '익명'),
                    $support->user ? $support->user->email : ($support->email ?? ''),
                    $support->assignedTo ? $support->assignedTo->name : '미배정',
                    $support->created_at ? $support->created_at->format('Y-m-d H:i:s') : '',
                    $support->resolved_at ? $support->resolved_at->format('Y-m-d H:i:s') : '',
                    $responseTime,
                    strip_tags($support->content)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * JSON 형태로 내보내기
     */
    private function exportToJson($supports, $fileName)
    {
        $data = $supports->map(function ($support) {
            $responseTime = null;
            if ($support->resolved_at && $support->created_at) {
                $responseTime = $support->created_at->diffInHours($support->resolved_at);
            }

            return [
                'id' => $support->id,
                'subject' => $support->subject,
                'type' => $support->type,
                'type_label' => $this->getTypeLabel($support->type),
                'priority' => $support->priority,
                'priority_label' => $this->getPriorityLabel($support->priority),
                'status' => $support->status,
                'status_label' => $this->getStatusLabel($support->status),
                'requester_name' => $support->user ? $support->user->name : ($support->name ?? '익명'),
                'requester_email' => $support->user ? $support->user->email : ($support->email ?? ''),
                'assignee' => $support->assignedTo ? $support->assignedTo->name : null,
                'content' => $support->content,
                'admin_reply' => $support->admin_reply,
                'created_at' => $support->created_at ? $support->created_at->toISOString() : null,
                'resolved_at' => $support->resolved_at ? $support->resolved_at->toISOString() : null,
                'response_time_hours' => $responseTime,
                'attachments' => $support->attachments,
            ];
        });

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$fileName}.json\"",
        ];

        return response()->json([
            'export_date' => now()->toISOString(),
            'total_records' => $supports->count(),
            'data' => $data
        ], 200, $headers);
    }

    /**
     * 유형 라벨 반환
     */
    private function getTypeLabel($type)
    {
        $labels = [
            'technical' => '기술 지원',
            'billing' => '결제 문의',
            'general' => '일반 문의',
            'bug_report' => '버그 리포트',
        ];

        return $labels[$type] ?? $type;
    }

    /**
     * 우선순위 라벨 반환
     */
    private function getPriorityLabel($priority)
    {
        $labels = [
            'urgent' => '긴급',
            'high' => '높음',
            'normal' => '보통',
            'low' => '낮음',
        ];

        return $labels[$priority] ?? $priority;
    }

    /**
     * 상태 라벨 반환
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => '대기중',
            'in_progress' => '처리중',
            'resolved' => '해결완료',
            'closed' => '종료',
        ];

        return $labels[$status] ?? $status;
    }
}