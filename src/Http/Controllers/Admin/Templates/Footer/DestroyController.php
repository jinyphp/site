<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class DestroyController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request, $id)
    {
        $footerId = (int) $id;

        // 푸터 존재 확인
        if (!$this->footerService->getFooterById($footerId)) {
            abort(404, 'Footer not found');
        }

        $success = $this->footerService->deleteFooter($footerId);

        if (!$success) {
            return redirect()->route('admin.cms.templates.footer.index')
                ->with('error', '푸터 삭제 중 오류가 발생했습니다.');
        }

        return redirect()->route('admin.cms.templates.footer.index')
            ->with('success', '푸터가 성공적으로 삭제되었습니다.');
    }
}
