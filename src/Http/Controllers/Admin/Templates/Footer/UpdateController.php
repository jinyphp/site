<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;

class UpdateController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request, $id)
    {
        // 새로운 구조와 기존 구조 모두 지원
        $request->validate([
            'path' => 'required_without:footer_key|string|max:255',
            'footer_key' => 'required_without:path|string|max:255',
            'title' => 'required_without:name|string|max:255',
            'name' => 'required_without:title|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'enable' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'default' => 'nullable|boolean',
        ]);

        $footer = $this->footerService->getFooterById((int) $id);

        if (!$footer) {
            abort(404, 'Footer not found');
        }

        // 새로운 구조 우선, 기존 구조 호환
        $path = $request->path ?? $request->footer_key;
        $title = $request->title ?? $request->name;

        // 중복 경로 체크 (자기 자신 제외)
        if ($this->footerService->isDuplicatePath($path, (int) $id - 1)) {
            $errorKey = $request->has('path') ? 'path' : 'footer_key';
            return back()->withErrors([$errorKey => '이미 존재하는 푸터 경로입니다.'])->withInput();
        }

        // 푸터 데이터 준비
        $footerData = [
            'path' => $path,
            'title' => $title,
            'description' => $request->description ?? '',
            'enable' => $request->boolean('enable', $footer['enable'] ?? true),
            'active' => $request->boolean('active', $footer['active'] ?? false),
            'default' => $request->boolean('default', $footer['default'] ?? false),
        ];

        // 기존 구조 호환성
        if ($request->has('template')) {
            $footerData['template'] = $request->template;
        }

        $success = $this->footerService->updateFooter((int) $id, $footerData);

        if ($success) {
            return redirect()->route('admin.cms.templates.footer.index')
                ->with('success', '푸터가 성공적으로 수정되었습니다.');
        }

        return back()->with('error', '푸터 수정에 실패했습니다.');
    }
}