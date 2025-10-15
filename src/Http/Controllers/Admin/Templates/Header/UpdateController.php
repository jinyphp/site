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
        $request->validate([
            'header_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
        ]);

        $header = $this->headerService->getHeaderById((int) $id);

        if (!$header) {
            abort(404, 'Header not found');
        }

        // 중복 키 체크 (자기 자신 제외)
        if ($this->headerService->isDuplicateKey($request->header_key, (int) $id)) {
            return back()->withErrors(['header_key' => '이미 존재하는 헤더 키입니다.'])->withInput();
        }

        $success = $this->headerService->updateHeader((int) $id, [
            'header_key' => $request->header_key,
            'name' => $request->name,
            'description' => $request->description ?? '',
            'template' => $request->template ?? '',
            'navbar' => $request->boolean('navbar'),
            'logo' => $request->boolean('logo'),
            'search' => $request->boolean('search'),
        ]);

        if ($success) {
            return redirect()->route('admin.cms.templates.header.index')
                ->with('success', '헤더가 성공적으로 수정되었습니다.');
        }

        return back()->with('error', '헤더 수정에 실패했습니다.');
    }
}