<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePageContent;

class ShowController extends Controller
{
    /**
     * 개별 블럭 정보 조회
     */
    public function __invoke(Request $request, $pageId, $contentId)
    {
        $content = SitePageContent::where('page_id', $pageId)
            ->findOrFail($contentId);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $content->id,
                    'title' => $content->title,
                    'content' => $content->content,
                    'block_type' => $content->block_type,
                    'block_type_name' => $content->block_type_name,
                    'block_type_icon' => $content->block_type_icon,
                    'css_class' => $content->css_class,
                    'settings' => $content->settings,
                    'sort_order' => $content->sort_order,
                    'is_active' => $content->is_active,
                    'created_at' => $content->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $content->updated_at->format('Y-m-d H:i:s'),
                ]
            ]);
        }

        return view('jiny-site::admin.page-content.show', compact('content'));
    }
}