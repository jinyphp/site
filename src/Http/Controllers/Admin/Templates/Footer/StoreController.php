<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class StoreController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'footer_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
        ]);

        // 중복 키 체크
        if ($this->footerService->isDuplicateKey($request->footer_key)) {
            return back()->withErrors(['footer_key' => '이미 존재하는 푸터 키입니다.'])->withInput();
        }

        $success = $this->footerService->addFooter($request->all());

        if (!$success) {
            return back()->withErrors(['error' => '푸터 생성 중 오류가 발생했습니다.'])->withInput();
        }

        return redirect()->route('admin.cms.templates.footer.index')
            ->with('success', '푸터가 성공적으로 생성되었습니다.');
    }
}
