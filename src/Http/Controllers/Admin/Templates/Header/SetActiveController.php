<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;

class SetActiveController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    public function __invoke(Request $request, $id)
    {
        $header = $this->headerService->getHeaderById((int) $id);

        if (!$header) {
            return response()->json(['error' => 'Header not found'], 404);
        }

        // Check if header is enabled
        $isEnabled = isset($header['enable']) ? $header['enable'] : true;
        if (!$isEnabled) {
            if ($request->expectsJson()) {
                return response()->json(['error' => '비활성화된 헤더는 활성화할 수 없습니다.'], 400);
            }
            return back()->with('error', '비활성화된 헤더는 활성화할 수 없습니다.');
        }

        $success = $this->headerService->setActiveHeader((int) $id);

        if ($success) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '활성 헤더가 성공적으로 설정되었습니다.',
                    'active_header' => $header
                ]);
            }

            return redirect()->route('admin.cms.templates.header.index')
                ->with('success', '활성 헤더가 성공적으로 설정되었습니다.');
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => '활성 헤더 설정에 실패했습니다.'], 500);
        }

        return back()->with('error', '활성 헤더 설정에 실패했습니다.');
    }
}