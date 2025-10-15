<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

class DeleteController extends Controller
{
    public function __construct()
    {
        // Middleware applied in routes
    }

    public function __invoke(Request $request, $id)
    {
        $support = SiteSupport::findOrFail($id);
        $support->delete();

        return redirect()->route('admin.cms.support.index')
            ->with('success', '지원 요청이 삭제되었습니다.');
    }
}