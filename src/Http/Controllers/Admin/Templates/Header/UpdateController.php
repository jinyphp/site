<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;

class UpdateController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    public function __invoke(Request $request, $id)
    {
        // 새로운 구조와 기존 구조 모두 지원
        $request->validate([
            'path' => 'required_without:header_key|string|max:255',
            'header_key' => 'required_without:path|string|max:255',
            'title' => 'required_without:name|string|max:255',
            'name' => 'required_without:title|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'enable' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'default' => 'nullable|boolean',
        ]);

        $header = $this->headerService->getHeaderById((int) $id);

        if (!$header) {
            abort(404, 'Header not found');
        }

        // 새로운 구조 우선, 기존 구조 호환
        $path = $request->path ?? $request->header_key;
        $title = $request->title ?? $request->name;

        // 중복 경로 체크 (자기 자신 제외)
        if ($this->headerService->isDuplicatePath($path, (int) $id - 1)) {
            $errorKey = $request->has('path') ? 'path' : 'header_key';
            return back()->withErrors([$errorKey => '이미 존재하는 헤더 경로입니다.'])->withInput();
        }

        // 헤더 데이터 준비
        $headerData = [
            'path' => $path,
            'title' => $title,
            'description' => $request->description ?? '',
            'enable' => $request->boolean('enable', $header['enable'] ?? true),
            'active' => $request->boolean('active', $header['active'] ?? false),
            'default' => $request->boolean('default', $header['default'] ?? false),
        ];

        // 기존 구조 호환성
        if ($request->has('template')) {
            $headerData['template'] = $request->template;
        }
        if ($request->has('navbar')) {
            $headerData['navbar'] = $request->boolean('navbar');
        }
        if ($request->has('logo')) {
            $headerData['logo'] = $request->boolean('logo');
        }
        if ($request->has('search')) {
            $headerData['search'] = $request->boolean('search');
        }

        $success = $this->headerService->updateHeader((int) $id, $headerData);

        if ($success) {
            return redirect()->route('admin.cms.templates.header.index')
                ->with('success', '헤더가 성공적으로 수정되었습니다.');
        }

        return back()->with('error', '헤더 수정에 실패했습니다.');
    }
}