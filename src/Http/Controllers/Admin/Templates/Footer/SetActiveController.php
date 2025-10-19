<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class SetActiveController extends Controller
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

            // 푸터가 활성화 상태인지 확인
            if (!($footer['enable'] ?? true)) {
                return response()->json([
                    'success' => false,
                    'error' => '비활성화된 푸터는 사용할 수 없습니다.'
                ], 400);
            }

            $success = $this->footerService->setActiveFooter((int) $id);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => '활성 푸터가 성공적으로 설정되었습니다.',
                    'footer_id' => (int) $id
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => '활성 푸터 설정 중 오류가 발생했습니다.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => '서버 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}