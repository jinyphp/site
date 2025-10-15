<?php

namespace Jiny\Site\Http\Controllers\Site\Help;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 도움말 상세 페이지 컨트롤러
 *
 * 진입 경로:
 * Route::get('/help/{id}') → DetailController::__invoke()
 */
class DetailController extends Controller
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
            'view' => config('site.help.detail_view', 'jiny-site::www.help.detail'),
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 도움말 상세 정보 조회
        $help = DB::table($this->config['table'])
            ->where('id', $id)
            ->where('enable', true)
            ->first();

        if (!$help) {
            abort(404, 'Help article not found');
        }

        // 관련 도움말 조회 (같은 카테고리)
        $relatedHelps = collect();
        if ($help->category) {
            $relatedHelps = DB::table($this->config['table'])
                ->where('category', $help->category)
                ->where('id', '!=', $id)
                ->where('enable', true)
                ->orderBy('order')
                ->limit(5)
                ->get();
        }

        // 카테고리 정보 조회
        $category = null;
        if ($help->category) {
            $category = DB::table('site_help_cate')
                ->where('code', $help->category)
                ->where('enable', true)
                ->first();
        }

        return view($this->config['view'], [
            'help' => $help,
            'category' => $category,
            'relatedHelps' => $relatedHelps,
            'config' => $this->config,
        ]);
    }
}