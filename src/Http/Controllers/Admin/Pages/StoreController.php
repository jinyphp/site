<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:site_pages,slug',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'status' => 'required|in:published,draft,private',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'template' => 'nullable|string|max:100',
            'layout' => 'nullable|string|max:255',
            'header' => 'nullable|string|max:255',
            'footer' => 'nullable|string|max:255',
            'sidebar' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'custom_fields' => 'nullable|array',
        ]);

        // slug가 비어있으면 title에서 자동 생성
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // 발행 상태일 때 published_at이 없으면 현재 시간으로 설정
        if ($validated['status'] === SitePage::STATUS_PUBLISHED && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // sort_order가 비어있으면 마지막 순서로 설정
        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = SitePage::max('sort_order') + 1;
        }

        $page = SitePage::create($validated);

        return redirect()->route('admin.cms.pages.show', $page->id)
                        ->with('success', '페이지가 성공적으로 생성되었습니다.');
    }
}