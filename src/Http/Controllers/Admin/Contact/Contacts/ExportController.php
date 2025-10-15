<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 엑셀 내보내기 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/contacts/export') → ExportController::__invoke()
 */
class ExportController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_contact',
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $contacts = $query->orderBy('site_contact.created_at', 'desc')->get();

        return $this->exportToCsv($contacts);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_contact_type', 'site_contact.type', '=', 'site_contact_type.code')
            ->select(
                'site_contact.*',
                'site_contact_type.title as type_title'
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('type') && $request->get('type') !== 'all') {
            $query->where('site_contact.type', $request->get('type'));
        }

        if ($request->filled('status') && $request->get('status') !== 'all') {
            $query->where('site_contact.status', $request->get('status'));
        }

        if ($request->filled('start_date')) {
            $query->where('site_contact.created_at', '>=', $request->get('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('site_contact.created_at', '<=', $request->get('end_date'));
        }

        return $query;
    }

    protected function exportToCsv($contacts)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');

            // BOM 추가 (한글 깨짐 방지)
            fwrite($file, "\xEF\xBB\xBF");

            // 헤더 작성
            fputcsv($file, [
                'ID', '이름', '이메일', '전화번호', '제목', '내용',
                '타입', '상태', '생성일', '읽음일', '답변일', '답변자'
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->email,
                    $contact->phone ?? '',
                    $contact->subject,
                    strip_tags($contact->message),
                    $contact->type_title ?? $contact->type,
                    $this->getStatusText($contact->status),
                    $contact->created_at,
                    $contact->read_at,
                    $contact->replied_at,
                    $contact->replied_by ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    protected function getStatusText($status)
    {
        return match($status) {
            'pending' => '대기',
            'replied' => '답변완료',
            'closed' => '종료',
            default => $status,
        };
    }
}