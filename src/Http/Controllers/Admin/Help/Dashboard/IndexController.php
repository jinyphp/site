<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help Center 대시보드 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::admin.helps.dashboard.index',
            'title' => 'Help Center 대시보드',
            'subtitle' => '도움말 센터 현황을 한눈에 확인하세요.',
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 가이드 문서 통계
        $guideStats = [
            'total' => DB::table('site_guide')->whereNull('deleted_at')->count(),
            'published' => DB::table('site_guide')->where('enable', true)->whereNull('deleted_at')->count(),
            'draft' => DB::table('site_guide')->where('enable', false)->whereNull('deleted_at')->count(),
            'total_views' => DB::table('site_guide')->whereNull('deleted_at')->sum('views') ?? 0,
            'total_likes' => DB::table('site_guide')->whereNull('deleted_at')->sum('likes') ?? 0,
        ];

        // FAQ 통계
        $faqStats = [
            'total' => DB::table('site_faq')->count(),
            'published' => DB::table('site_faq')->where('enable', true)->count(),
            'draft' => DB::table('site_faq')->where('enable', false)->count(),
            'total_views' => DB::table('site_faq')->sum('views') ?? 0,
        ];


        // Support 통계 (기존 support 모듈의 통계를 통합)
        $supportStats = [
            'total' => DB::table('site_support')->count(),
            'pending' => DB::table('site_support')->where('status', 'pending')->count(),
            'in_progress' => DB::table('site_support')->where('status', 'in_progress')->count(),
            'resolved' => DB::table('site_support')->where('status', 'resolved')->count(),
            'closed' => DB::table('site_support')->where('status', 'closed')->count(),
        ];

        // 카테고리 통계
        $categoryStats = [
            'guide_categories' => DB::table('site_guide_cate')->where('enable', true)->count(),
            'faq_categories' => DB::table('site_faq_cate')->where('enable', true)->count(),
            'support_types' => DB::table('site_support_types')->where('enable', true)->count(),
        ];

        // 최근 가이드 문서 (5개)
        $recentGuides = DB::table('site_guide')
            ->select('id', 'title', 'views', 'likes', 'enable', 'created_at')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 최근 FAQ (5개)
        $recentFaqs = DB::table('site_faq')
            ->select('id', 'question', 'views', 'enable', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        // 주간 통계 (최근 7일)
        $weeklyStats = [
            'guide_created' => DB::table('site_guide')
                ->where('created_at', '>=', now()->subDays(7))
                ->whereNull('deleted_at')
                ->count(),
            'faq_created' => DB::table('site_faq')
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
            'support_received' => DB::table('site_support')
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
        ];

        // 인기 가이드 문서 (조회수 기준)
        $popularGuides = DB::table('site_guide')
            ->select('id', 'title', 'views', 'likes', 'created_at')
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view($this->config['view'], [
            'config' => $this->config,
            'guideStats' => $guideStats,
            'faqStats' => $faqStats,
            'supportStats' => $supportStats,
            'categoryStats' => $categoryStats,
            'recentGuides' => $recentGuides,
            'recentFaqs' => $recentFaqs,
            'weeklyStats' => $weeklyStats,
            'popularGuides' => $popularGuides,
        ]);
    }
}