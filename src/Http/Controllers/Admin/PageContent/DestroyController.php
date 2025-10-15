<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePageContent;

class DestroyController extends Controller
{
    /**
     * 블럭 삭제
     */
    public function __invoke(Request $request, $pageId, $contentId)
    {
        $content = SitePageContent::where('page_id', $pageId)
            ->findOrFail($contentId);

        $content->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '블럭이 성공적으로 삭제되었습니다.'
            ]);
        }

        return redirect()->route('admin.cms.pages.show', $pageId)
            ->with('success', '블럭이 성공적으로 삭제되었습니다.');
    }
}