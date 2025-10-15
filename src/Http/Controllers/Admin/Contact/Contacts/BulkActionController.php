<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 대량 작업 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/contact/contacts/bulk-action') → BulkActionController::__invoke()
 */
class BulkActionController extends Controller
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
        $action = $request->get('action');
        $ids = $request->get('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', '선택된 항목이 없습니다.');
        }

        $message = $this->performBulkAction($action, $ids);

        if (!$message) {
            return redirect()->back()->with('error', '올바르지 않은 작업입니다.');
        }

        return redirect()->back()->with('success', $message);
    }

    protected function performBulkAction($action, $ids)
    {
        switch ($action) {
            case 'delete':
                DB::table($this->config['table'])
                    ->whereIn('id', $ids)
                    ->delete();
                return '선택된 문의가 삭제되었습니다.';

            case 'read':
                DB::table($this->config['table'])
                    ->whereIn('id', $ids)
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
                return '선택된 문의가 읽음 처리되었습니다.';

            case 'pending':
                DB::table($this->config['table'])
                    ->whereIn('id', $ids)
                    ->update(['status' => 'pending']);
                return '선택된 문의가 대기 상태로 변경되었습니다.';

            case 'replied':
                DB::table($this->config['table'])
                    ->whereIn('id', $ids)
                    ->update(['status' => 'replied']);
                return '선택된 문의가 답변 완료 상태로 변경되었습니다.';

            case 'closed':
                DB::table($this->config['table'])
                    ->whereIn('id', $ids)
                    ->update(['status' => 'closed']);
                return '선택된 문의가 종료 상태로 변경되었습니다.';

            default:
                return null;
        }
    }
}