<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Guide;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 가이드 목록 표시 컨트롤러 (Help 섹션 내)
 *
 * 진입 경로:
 * Route::get('/help/guide') → IndexController::__invoke()
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_guide',
            'category_table' => 'site_guide_cate',
            'view' => config('site.help.guide_view', 'jiny-site::www.help.guide.index'),
            'per_page' => config('site.guide.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $category = $request->input('category', '');

        // 가이드 카테고리 목록
        $categories = DB::table($this->config['category_table'])
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        // 각 카테고리별 가이드 개수와 함께 데이터 준비
        $categoriesWithCounts = $categories->map(function ($category) {
            $guideCount = DB::table($this->config['table'])
                ->where('category', $category->code)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->count();

            $category->guide_count = $guideCount;

            // 각 카테고리의 최근 가이드 5개 가져오기
            $category->guides = DB::table($this->config['table'])
                ->where('category', $category->code)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return $category;
        });

        // 인기 가이드 (조회수 기준)
        $popularGuides = DB::table($this->config['table'])
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return view($this->config['view'], [
            'categories' => $categoriesWithCounts,
            'popularGuides' => $popularGuides,
            'config' => $this->config,
        ]);
    }
}
