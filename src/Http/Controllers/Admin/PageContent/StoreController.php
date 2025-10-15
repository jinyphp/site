<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;
use Jiny\Site\Models\SitePageContent;

class StoreController extends Controller
{
    /**
     * 새 블럭 생성
     */
    public function __invoke(Request $request, $pageId)
    {
        $page = SitePage::findOrFail($pageId);

        $request->validate([
            'block_type' => 'required|string|max:50',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'css_class' => 'nullable|string|max:255',
            'settings' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
            'hide_title' => 'nullable',
        ]);

        // settings JSON 문자열을 배열로 변환
        $settings = [];
        if ($request->settings) {
            $settingsString = trim($request->settings);
            if (!empty($settingsString) && $settingsString !== '{}') {
                try {
                    $settings = json_decode($settingsString, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $settings = [];
                    }
                } catch (\Exception $e) {
                    $settings = [];
                }
            }
        }

        // sort_order가 없으면 자동으로 다음 순서 설정
        $sortOrder = $request->sort_order;
        if (empty($sortOrder)) {
            $sortOrder = SitePageContent::where('page_id', $pageId)->max('sort_order') + 1;
        }

        // 구분선 블럭의 경우 자동으로 제목 숨김
        $hideTitle = $request->has('hide_title') ? true : false;
        if ($request->block_type === 'divider') {
            $hideTitle = true;
        }

        $content = SitePageContent::create([
            'page_id' => $pageId,
            'block_type' => $request->block_type,
            'title' => $request->title,
            'content' => $request->content,
            'css_class' => $request->css_class,
            'settings' => $settings,
            'sort_order' => $sortOrder,
            'is_active' => $request->has('is_active') ? true : false,
            'hide_title' => $hideTitle,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '블럭이 성공적으로 생성되었습니다.',
                'data' => [
                    'id' => $content->id,
                    'title' => $content->title,
                    'block_type' => $content->block_type,
                    'block_type_name' => $content->block_type_name,
                    'block_type_icon' => $content->block_type_icon,
                    'sort_order' => $content->sort_order,
                    'is_active' => $content->is_active,
                ]
            ]);
        }

        return redirect()->route('admin.cms.pages.show', $pageId)
            ->with('success', '블럭이 성공적으로 생성되었습니다.');
    }
}