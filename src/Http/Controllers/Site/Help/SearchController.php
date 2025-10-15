<?php

namespace Jiny\Site\Http\Controllers\Site\Help;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 도움말 검색 컨트롤러
 *
 * 진입 경로:
 * Route::get('/help/search') → SearchController::__invoke()
 */
class SearchController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_help',
            'view' => config('site.help.search_view', 'jiny-site::www.help.search'),
            'per_page' => config('site.help.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $request->input('q', '');
        $category = $request->input('category', '');

        $helps = collect();
        $categories = DB::table('site_help_cate')
            ->where('enable', true)
            ->orderBy('order')
            ->get();

        if (!empty($query)) {
            $helpQuery = DB::table($this->config['table'])
                ->where('enable', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('content', 'like', '%' . $query . '%');
                });

            if (!empty($category)) {
                $helpQuery->where('category', $category);
            }

            $helps = $helpQuery
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->paginate($this->config['per_page']);

            // 검색 결과에 페이지네이션 파라미터 추가
            $helps->appends($request->only(['q', 'category']));
        }

        return view($this->config['view'], [
            'helps' => $helps,
            'categories' => $categories,
            'query' => $query,
            'selectedCategory' => $category,
            'config' => $this->config,
        ]);
    }
}