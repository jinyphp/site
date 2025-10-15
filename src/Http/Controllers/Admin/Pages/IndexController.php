<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = SitePage::with(['creator', 'updater'])
            ->withCount(['contents as blocks_count' => function ($query) {
                $query->where('is_active', true);
            }]);

        // 검색
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // 상태 필터
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // 추천 페이지 필터
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if ($sortBy === 'order') {
            $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $pages = $query->paginate(20)->withQueryString();

        // 통계 데이터
        $stats = [
            'total' => SitePage::count(),
            'published' => SitePage::where('status', SitePage::STATUS_PUBLISHED)->count(),
            'draft' => SitePage::where('status', SitePage::STATUS_DRAFT)->count(),
            'private' => SitePage::where('status', SitePage::STATUS_PRIVATE)->count(),
            'featured' => SitePage::where('is_featured', true)->count(),
        ];

        return view('jiny-site::admin.pages.index', compact('pages', 'stats'));
    }
}