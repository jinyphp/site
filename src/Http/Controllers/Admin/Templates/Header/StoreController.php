<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;

class StoreController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'header_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
        ]);

        // 중복 키 체크
        if ($this->headerService->isDuplicateKey($request->header_key)) {
            return back()->withErrors(['header_key' => '이미 존재하는 헤더 키입니다.'])->withInput();
        }

        $success = $this->headerService->createHeader([
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
                ->with('success', '헤더가 성공적으로 생성되었습니다.');
        }

        return back()->with('error', '헤더 생성에 실패했습니다.');
    }
}