<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class SetDefaultController extends Controller
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

            $success = $this->footerService->setDefaultFooter((int) $id);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => '기본 푸터가 성공적으로 설정되었습니다.',
                    'footer_id' => (int) $id
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => '기본 푸터 설정 중 오류가 발생했습니다.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => '서버 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}