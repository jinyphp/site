<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;
use Jiny\Site\Models\SitePageContent;

class IndexController extends Controller
{
    /**
     * 페이지 블럭 목록 조회
     */
    public function __invoke(Request $request, $pageId)
    {
        $page = SitePage::findOrFail($pageId);

        $contents = SitePageContent::where('page_id', $pageId)
            ->ordered()
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $contents->map(function ($content) {
                    return [
                        'id' => $content->id,
                        'title' => $content->title,
                        'block_type' => $content->block_type,
                        'block_type_name' => $content->block_type_name,
                        'block_type_icon' => $content->block_type_icon,
                        'content' => $content->content,
                        'content_preview' => \Illuminate\Support\Str::limit(strip_tags($content->rendered_content), 100),
                        'css_class' => $content->css_class,
                        'settings' => $content->settings,
                        'sort_order' => $content->sort_order,
                        'is_active' => $content->is_active,
                        'created_at' => $content->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $content->updated_at->format('Y-m-d H:i:s'),
                    ];
                })
            ]);
        }

        return view('jiny-site::admin.page-content.index', compact('page', 'contents'));
    }
}