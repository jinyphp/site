<?php

namespace Jiny\Site\Http\Controllers\Site\Help;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 도움말 카테고리별 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/help/category/{code}') → CategoryController::__invoke()
 */
class CategoryController extends Controller
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
            'view' => config('site.help.category_view', 'jiny-site::www.help.category'),
            'per_page' => config('site.help.per_page', 20),
        ];
    }

    public function __invoke(Request $request, $code)
    {
        // 카테고리 정보 조회
        $category = DB::table('site_help_cate')
            ->where('code', $code)
            ->where('enable', true)
            ->first();

        if (!$category) {
            abort(404, 'Help category not found');
        }

        // 해당 카테고리의 도움말 목록 조회
        $helps = DB::table($this->config['table'])
            ->where('category', $code)
            ->where('enable', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($this->config['per_page']);

        // 모든 카테고리 목록 (사이드바용)
        $categories = DB::table('site_help_cate')
            ->where('enable', true)
            ->orderBy('order')
            ->get();

        return view($this->config['view'], [
            'category' => $category,
            'helps' => $helps,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }
}