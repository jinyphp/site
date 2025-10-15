<?php
namespace Jiny\Site\Http\Controllers\Admin\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Site Board Dashboard Controller
 *
 * 게시판 관리 대시보드를 표시하는 단일 액션 컨트롤러입니다.
 */
class AdminSiteBoardDashboard extends Controller
{
    /**
     * 대시보드 설정
     *
     * @var array
     */
    protected $config;

    /**
     * 생성자 - 설정 초기화
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * 설정값 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => 'jiny-site::admin.board.dashboard.dash',
            'title' => 'Site Board',
            'subtitle' => '사이트 계시물을 관리합니다.',
        ];
    }

    /**
     * 대시보드 표시 (단일 액션 메서드)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 대시보드 데이터 로드
        $data = $this->loadDashboardData();

        // 뷰 렌더링 및 반환
        return $this->renderView($data);
    }

    /**
     * 대시보드 데이터 로드
     *
     * @return array
     */
    protected function loadDashboardData()
    {
        // 모든 게시판 조회 (캐시된 통계 포함)
        $boards = DB::table('site_board')->get();

        // 캐시된 통계에서 집계
        $total_posts = $boards->sum('post') ?? 0;
        $total_views = $boards->sum('total_views') ?? 0;

        // 오늘 작성된 게시물 수는 실시간 조회 (가벼운 쿼리)
        $today_posts = 0;
        $recent_posts = collect();
        $popular_posts = collect();

        foreach ($boards as $board) {
            $table = "site_board_" . $board->code;

            // 테이블이 존재하는지 확인
            if (DB::getSchemaBuilder()->hasTable($table)) {
                // 오늘 작성된 게시물 수만 실시간 조회
                $today_posts += DB::table($table)
                    ->whereDate('created_at', today())
                    ->count();

                // 최근 게시글 수집 (상위 10개만)
                $recent = DB::table($table)
                    ->select('*', DB::raw("'{$board->code}' as board_code"), DB::raw("'{$board->title}' as board_title"))
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                $recent_posts = $recent_posts->merge($recent);

                // 인기 게시글 수집 (상위 10개만)
                $popular = DB::table($table)
                    ->select('*', DB::raw("'{$board->code}' as board_code"), DB::raw("'{$board->title}' as board_title"))
                    ->orderBy('click', 'desc')
                    ->limit(10)
                    ->get();
                $popular_posts = $popular_posts->merge($popular);
            }
        }

        // 최근 게시글 정렬 및 제한
        $recent_posts = $recent_posts->sortByDesc('created_at')->take(5);

        // 인기 게시글 정렬 및 제한
        $popular_posts = $popular_posts->sortByDesc('click')->take(5);

        // 통계 데이터
        $stats = [
            'total_boards' => $boards->count(),
            'total_posts' => $total_posts,
            'total_related' => DB::table('site_board_related')->count(),
            'total_trend' => DB::table('site_board_trend')->count(),
            'today_posts' => $today_posts,
            'total_views' => $total_views,
        ];

        // 게시판별 통계 (캐시된 통계 사용)
        $board_stats = $boards->map(function($board) {
            $board->post_count = $board->post ?? 0;
            return $board;
        });

        return [
            'config' => $this->config,
            'actions' => [
                'title' => $this->config['title'],
                'subtitle' => $this->config['subtitle'],
            ],
            'stats' => $stats,
            'recent_posts' => $recent_posts,
            'popular_posts' => $popular_posts,
            'board_stats' => $board_stats,
        ];
    }

    /**
     * 뷰 렌더링
     *
     * @param array $data
     * @return \Illuminate\View\View
     */
    protected function renderView($data)
    {
        return view($this->config['view'], $data);
    }
}
