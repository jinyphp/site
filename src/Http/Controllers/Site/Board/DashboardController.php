<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 게시판 대시보드 컨트롤러
 * 모든 게시판 목록과 통계를 보여주는 메인 대시보드
 */
class DashboardController extends Controller
{
    use BoardPermissions;

    protected $viewPath = 'jiny-site::www.board';

    public function __invoke(Request $request)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        // 모든 게시판 정보 조회
        $boards = DB::table('site_board')
            ->where('enable', true)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $boardData = [];
        $allPopularPosts = [];
        $allLatestPosts = [];
        $allTopRatedPosts = [];

        foreach ($boards as $board) {
            // 각 게시판에 대한 접근 권한 확인
            $canRead = $this->hasPermission($board, 'read');

            if (!$canRead) {
                continue; // 읽기 권한이 없으면 목록에서 제외
            }

            $table = "site_board_" . $board->code;

            // 테이블이 존재하는지 확인
            if (!Schema::hasTable($table)) {
                continue;
            }

            // 게시판 기본 정보
            $boardInfo = [
                'board' => $board,
                'canCreate' => $this->hasPermission($board, 'create'),
                'totalPosts' => DB::table($table)->whereNull('parent_id')->count(),
            ];

            $boardData[] = $boardInfo;

            // 전체 인기 게시글 수집 (조회수 기준)
            $popularPosts = DB::table($table)
                ->whereNull('parent_id')
                ->where('click', '>', 0)
                ->orderBy('click', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'name', 'created_at', 'click']);

            foreach ($popularPosts as $post) {
                $post->board_code = $board->code;
                $post->board_title = $board->title;
                $allPopularPosts[] = $post;
            }

            // 최신 게시글 수집
            $latestPosts = DB::table($table)
                ->whereNull('parent_id')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'name', 'created_at', 'click']);

            foreach ($latestPosts as $post) {
                $post->board_code = $board->code;
                $post->board_title = $board->title;
                $allLatestPosts[] = $post;
            }

            // 평가가 높은 게시글 수집
            $topRatedPosts = $this->getTopRatedPosts($board->code, $table);
            foreach ($topRatedPosts as $post) {
                $post->board_code = $board->code;
                $post->board_title = $board->title;
                $allTopRatedPosts[] = $post;
            }
        }

        // 전체 데이터에서 상위 항목들만 선별
        $topPopularPosts = collect($allPopularPosts)
            ->sortByDesc('click')
            ->take(10)
            ->values();

        $topLatestPosts = collect($allLatestPosts)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        $topRatedPosts = collect($allTopRatedPosts)
            ->sortByDesc('rating_average')
            ->take(10)
            ->values();

        return view("{$this->viewPath}.dashboard", [
            'boards' => $boardData,
            'popularPosts' => $topPopularPosts,
            'latestPosts' => $topLatestPosts,
            'topRatedPosts' => $topRatedPosts,
            'user' => $user,
            'totalBoards' => count($boardData),
        ]);
    }

    /**
     * 평가가 높은 게시글 조회
     */
    private function getTopRatedPosts($code, $table)
    {
        $ratingTable = $table . "_ratings";

        if (!Schema::hasTable($ratingTable)) {
            return collect();
        }

        // 좋아요와 별점을 종합한 점수로 상위 게시글 선택
        $topRatedPosts = DB::table($table . ' as p')
            ->leftJoin($ratingTable . ' as r', 'p.id', '=', 'r.post_id')
            ->whereNull('p.parent_id')
            ->select('p.id', 'p.title', 'p.name', 'p.created_at', 'p.click')
            ->selectRaw('
                COUNT(CASE WHEN r.type = "like" AND r.is_like = 1 THEN 1 END) as like_count,
                COUNT(CASE WHEN r.type = "rating" AND r.rating IS NOT NULL THEN 1 END) as rating_count,
                AVG(CASE WHEN r.type = "rating" AND r.rating IS NOT NULL THEN r.rating END) as rating_average,
                (COUNT(CASE WHEN r.type = "like" AND r.is_like = 1 THEN 1 END) * 1 +
                 COALESCE(AVG(CASE WHEN r.type = "rating" AND r.rating IS NOT NULL THEN r.rating END), 0) * 2) as total_score
            ')
            ->groupBy('p.id', 'p.title', 'p.name', 'p.created_at', 'p.click')
            ->having('total_score', '>', 0)
            ->orderBy('total_score', 'desc')
            ->limit(5)
            ->get();

        foreach ($topRatedPosts as $post) {
            $post->rating_average = $post->rating_average ? round($post->rating_average, 1) : 0;
        }

        return $topRatedPosts;
    }

    /**
     * 게시판 통계 계산
     */
    private function calculateBoardStats($code, $table)
    {
        // 기본 게시글 통계
        $totalPosts = DB::table($table)->count();
        $originalPosts = DB::table($table)->whereNull('parent_id')->count();
        $replyPosts = DB::table($table)->whereNotNull('parent_id')->count();

        // 최근 게시글 (7일 이내)
        $recentPosts = DB::table($table)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // 총 조회수
        $totalViews = DB::table($table)->sum('click') ?? 0;

        // 최신 게시글 3개
        $latestPosts = DB::table($table)
            ->whereNull('parent_id') // 원본 게시글만
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get(['id', 'title', 'name', 'created_at', 'click']);

        // 인기 게시글 3개 (조회수 기준)
        $popularPosts = DB::table($table)
            ->whereNull('parent_id') // 원본 게시글만
            ->orderBy('click', 'desc')
            ->limit(3)
            ->get(['id', 'title', 'name', 'created_at', 'click']);

        // 코멘트 통계 (테이블이 있는 경우)
        $commentTable = $table . "_comments";
        $totalComments = 0;
        if (Schema::hasTable($commentTable)) {
            $totalComments = DB::table($commentTable)->count();
        }

        // 평가 통계 (테이블이 있는 경우)
        $ratingTable = $table . "_ratings";
        $totalLikes = 0;
        $totalRatings = 0;
        $averageRating = 0;

        if (Schema::hasTable($ratingTable)) {
            $totalLikes = DB::table($ratingTable)
                ->where('type', 'like')
                ->where('is_like', true)
                ->count();

            $ratingStats = DB::table($ratingTable)
                ->where('type', 'rating')
                ->whereNotNull('rating')
                ->selectRaw('COUNT(*) as count, AVG(rating) as average')
                ->first();

            $totalRatings = $ratingStats->count ?? 0;
            $averageRating = $totalRatings > 0 ? round($ratingStats->average, 1) : 0;
        }

        return [
            'total_posts' => $totalPosts,
            'original_posts' => $originalPosts,
            'reply_posts' => $replyPosts,
            'recent_posts' => $recentPosts,
            'total_views' => $totalViews,
            'total_comments' => $totalComments,
            'total_likes' => $totalLikes,
            'total_ratings' => $totalRatings,
            'average_rating' => $averageRating,
            'latest_posts' => $latestPosts,
            'popular_posts' => $popularPosts,
        ];
    }
}