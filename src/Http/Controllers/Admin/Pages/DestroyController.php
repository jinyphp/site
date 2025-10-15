<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $page = SitePage::findOrFail($id);

        $page->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '페이지가 성공적으로 삭제되었습니다.'
            ]);
        }

        return redirect()->route('admin.cms.pages.index')
                        ->with('success', '페이지가 성공적으로 삭제되었습니다.');
    }
}