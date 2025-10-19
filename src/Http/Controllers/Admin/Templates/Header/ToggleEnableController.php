<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;

class ToggleEnableController extends Controller
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

        $success = $this->headerService->toggleHeaderEnable((int) $id);

        if ($success) {
            // Get updated header info
            $updatedHeader = $this->headerService->getHeaderById((int) $id);
            $isEnabled = isset($updatedHeader['enable']) ? $updatedHeader['enable'] : true;

            $message = $isEnabled ? '헤더가 활성화되었습니다.' : '헤더가 비활성화되었습니다.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'header' => $updatedHeader,
                    'enabled' => $isEnabled
                ]);
            }

            return redirect()->route('admin.cms.templates.header.index')
                ->with('success', $message);
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => '헤더 상태 변경에 실패했습니다.'], 500);
        }

        return back()->with('error', '헤더 상태 변경에 실패했습니다.');
    }
}