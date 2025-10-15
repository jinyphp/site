<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Guide;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 가이드 단일 페이지 표시 컨트롤러 (Help 섹션 내)
 *
 * 진입 경로:
 * Route::get('/help/guide/{id}') → ShowController::__invoke()
 */
class ShowController extends Controller
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
            'view' => config('site.help.guide_single_view', 'jiny-site::www.help.guide.single'),
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 가이드 상세 정보 조회
        $guide = DB::table($this->config['table'])
            ->leftJoin($this->config['category_table'], 'site_guide.category', '=', 'site_guide_cate.code')
            ->select(
                'site_guide.*',
                'site_guide_cate.title as category_title'
            )
            ->where('site_guide.id', $id)
            ->where('site_guide.enable', true)
            ->whereNull('site_guide.deleted_at')
            ->first();

        if (!$guide) {
            abort(404, '가이드를 찾을 수 없습니다.');
        }

        // 조회수 증가
        DB::table($this->config['table'])
            ->where('id', $id)
            ->increment('views');

        // 같은 카테고리의 관련 가이드 (현재 가이드 제외)
        $relatedGuides = collect();
        if ($guide->category) {
            $relatedGuides = DB::table($this->config['table'])
                ->where('category', $guide->category)
                ->where('id', '!=', $id)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->orderBy('order')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // 이전/다음 가이드 (같은 카테고리 내에서)
        $previousGuide = null;
        $nextGuide = null;

        if ($guide->category) {
            $previousGuide = DB::table($this->config['table'])
                ->where('category', $guide->category)
                ->where('order', '<', $guide->order ?: 999999)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->orderBy('order', 'desc')
                ->first();

            $nextGuide = DB::table($this->config['table'])
                ->where('category', $guide->category)
                ->where('order', '>', $guide->order ?: 0)
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->orderBy('order', 'asc')
                ->first();
        }

        // 사용자의 좋아요 상태 확인
        $userLike = DB::table('site_guide_likes')
            ->where('guide_id', $id)
            ->where('user_ip', $request->ip())
            ->first();

        return view($this->config['view'], [
            'guide' => $guide,
            'relatedGuides' => $relatedGuides,
            'previousGuide' => $previousGuide,
            'nextGuide' => $nextGuide,
            'userLike' => $userLike,
            'config' => $this->config,
        ]);
    }
}
