<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // POST 요청인 경우 설정 저장 처리
        if ($request->isMethod('post')) {
            return $this->handleConfigSave($request);
        }

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

        // 헤더/푸터 설정 로드
        $headers = $this->loadConfig('headers.json');
        $footers = $this->loadConfig('footers.json');

        return view('jiny-site::admin.pages.index', compact('pages', 'stats', 'headers', 'footers'));
    }

    /**
     * 설정 파일 로드
     */
    private function loadConfig($filename)
    {
        $configPath = base_path("vendor/jiny/site/config/{$filename}");

        if (file_exists($configPath)) {
            $content = file_get_contents($configPath);
            return json_decode($content, true);
        }

        return [];
    }

    /**
     * 설정 저장 처리
     */
    private function handleConfigSave(Request $request)
    {
        $action = $request->input('action');
        $config = $request->input('config');

        if ($action === 'save_header_config') {
            $this->saveConfig('headers.json', $config);
        } elseif ($action === 'save_footer_config') {
            $this->saveConfig('footers.json', $config);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid action']);
        }

        return response()->json(['success' => true]);
    }

    /**
     * 설정 파일 저장
     */
    private function saveConfig($filename, $config)
    {
        $configPath = base_path("vendor/jiny/site/config/{$filename}");
        $jsonData = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($configPath, $jsonData);
    }
}