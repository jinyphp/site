<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePageContent;

class UpdateOrderController extends Controller
{
    /**
     * 블럭 순서 변경 (드래그 앤 드롭)
     */
    public function __invoke(Request $request, $pageId)
    {
        $request->validate([
            'content_ids' => 'required|array',
            'content_ids.*' => 'required|integer|exists:site_page_content,id',
        ]);

        $contentIds = $request->content_ids;

        // 각 블럭의 순서를 업데이트
        foreach ($contentIds as $index => $contentId) {
            SitePageContent::where('id', $contentId)
                ->where('page_id', $pageId)
                ->update(['sort_order' => $index + 1]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '블럭 순서가 성공적으로 변경되었습니다.'
            ]);
        }

        return redirect()->route('admin.cms.pages.content.index', $pageId)
            ->with('success', '블럭 순서가 성공적으로 변경되었습니다.');
    }
}