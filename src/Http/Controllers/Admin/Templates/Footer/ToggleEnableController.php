<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class ToggleEnableController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request, $id)
    {
        try {
            $footer = $this->footerService->getFooterById((int) $id);

            if (!$footer) {
                return response()->json([
                    'success' => false,
                    'error' => '푸터를 찾을 수 없습니다.'
                ], 404);
            }

            $success = $this->footerService->toggleFooterEnable((int) $id);

            if ($success) {
                $updatedFooter = $this->footerService->getFooterById((int) $id);
                $newStatus = $updatedFooter['enable'] ?? true;

                return response()->json([
                    'success' => true,
                    'message' => $newStatus ? '푸터가 활성화되었습니다.' : '푸터가 비활성화되었습니다.',
                    'footer_id' => (int) $id,
                    'new_enable_status' => $newStatus,
                    'new_active_status' => $updatedFooter['active'] ?? false,
                    'new_default_status' => $updatedFooter['default'] ?? false
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => '푸터 상태 변경 중 오류가 발생했습니다.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => '서버 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}