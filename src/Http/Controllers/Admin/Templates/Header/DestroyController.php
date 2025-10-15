<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;

class DestroyController extends Controller
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
            abort(404, 'Header not found');
        }

        $success = $this->headerService->deleteHeader((int) $id);

        if ($success) {
            return redirect()->route('admin.cms.templates.header.index')
                ->with('success', '헤더가 성공적으로 삭제되었습니다.');
        }

        return back()->with('error', '헤더 삭제에 실패했습니다.');
    }
}