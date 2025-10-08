<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 게시판 목록 컨트롤러
 */
class IndexController extends Controller
{
    use BoardPermissions;

    protected $viewPath = 'jiny-site::www.board';

    public function __invoke(Request $request, $code)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        // JWT 인증 디버깅 (IndexController)
        \Log::info('IndexController Debug', [
            'auth_check' => Auth::check(),
            'auth_id' => Auth::id(),
            'user' => $user,
            'access_token_cookie' => $request->cookie('access_token'),
            'all_cookies' => array_keys($request->cookies->all()),
        ]);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            abort(404, '게시판을 찾을 수 없습니다.');
        }

        // 읽기 권한 확인
        if (!$this->hasPermission($board, 'read')) {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', '로그인이 필요합니다.');
            }
            abort(403, '게시판에 접근할 권한이 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            abort(404, '게시판 테이블이 존재하지 않습니다.');
        }

        // 페이지당 게시물 수 (기본값: 게시판 설정값 또는 10)
        $defaultPerPage = $board->per_page ?? 10;
        $perPage = $request->get('perPage', $defaultPerPage);
        $perPage = in_array($perPage, [5, 10, 20, 50, 100]) ? $perPage : $defaultPerPage;

        // 검색 기능
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query = DB::table($table);

            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });

            // 검색 시에는 평탄한 목록으로 표시 (계층구조 유지)
            $searchResults = $query->orderBy('created_at', 'desc')->get();

            // 검색된 결과를 배열로 변환
            $items = $searchResults->toArray();

            // 페이지네이션을 위한 처리
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;
            $paginatedItems = array_slice($items, $offset, $perPage);

            // 수동으로 페이지네이터 생성
            $rows = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedItems,
                count($items),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $rows->appends(['search' => $search, 'perPage' => $perPage]);

            // 댓글 개수와 코멘트 개수, 평가 데이터는 검색 시에도 계산
            $childCounts = [];
            $commentCounts = [];
            $ratingCounts = [];
            $commentTable = $table . "_comments";
            $ratingTable = $table . "_ratings";

            foreach ($paginatedItems as $item) {
                // 모든 게시글에 대해 평가 데이터 조회 (원본글/하위글 구분 없이)
                if (Schema::hasTable($ratingTable)) {
                    $ratingCounts[$item->id] = $this->getRatingStats($ratingTable, $item->id);
                } else {
                    $ratingCounts[$item->id] = ['like_count' => 0, 'rating_count' => 0, 'rating_average' => 0];
                }

                // 원본 게시글인 경우에만 하위글/코멘트 개수 계산
                if ($item->parent_id === null) {
                    // 하위글(답글) 개수
                    $childCounts[$item->id] = DB::table($table)
                        ->where('parent_id', $item->id)
                        ->count();

                    // 코멘트 개수 (테이블이 존재하는 경우만)
                    if (Schema::hasTable($commentTable)) {
                        $commentCounts[$item->id] = DB::table($commentTable)
                            ->where('post_id', $item->id)
                            ->count();
                    } else {
                        $commentCounts[$item->id] = 0;
                    }
                }
            }
        } else {
            // 검색이 없을 때는 계층적 트리 구조로 표시
            $allItems = $this->buildHierarchy($table);

            // 페이지네이션을 위한 처리
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $items = array_slice($allItems, $offset, $perPage);

            // 댓글 개수, 코멘트 개수, 평가 데이터 계산 (페이지네이션된 결과에서 원본 게시글에만 적용)
            $childCounts = [];
            $commentCounts = [];
            $ratingCounts = [];
            $commentTable = $table . "_comments";
            $ratingTable = $table . "_ratings";

            foreach ($items as $item) {
                // 모든 게시글에 대해 평가 데이터 조회 (원본글/하위글 구분 없이)
                if (Schema::hasTable($ratingTable)) {
                    $ratingCounts[$item->id] = $this->getRatingStats($ratingTable, $item->id);
                } else {
                    $ratingCounts[$item->id] = ['like_count' => 0, 'rating_count' => 0, 'rating_average' => 0];
                }

                // 원본 게시글 (level 0)인 경우에만 하위글/코멘트 개수 계산
                if ($item->level === 0) {
                    // 하위글(답글) 개수
                    $childCounts[$item->id] = DB::table($table)
                        ->where('parent_id', $item->id)
                        ->count();

                    // 코멘트 개수 (테이블이 존재하는 경우만)
                    if (Schema::hasTable($commentTable)) {
                        $commentCounts[$item->id] = DB::table($commentTable)
                            ->where('post_id', $item->id)
                            ->count();
                    } else {
                        $commentCounts[$item->id] = 0;
                    }
                }
            }

            // 수동으로 페이지네이터 생성
            $rows = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                count($allItems),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view("{$this->viewPath}.index", [
            'board' => $board,
            'rows' => $rows,
            'code' => $code,
            'childCounts' => $childCounts,
            'commentCounts' => $commentCounts ?? [],
            'ratingCounts' => $ratingCounts ?? [],
            'perPage' => $perPage,
            'canCreate' => $this->hasPermission($board, 'create'),
        ]);
    }

    /**
     * 게시글의 평가 통계 조회
     */
    private function getRatingStats($ratingTable, $postId)
    {
        // 좋아요 수 계산
        $likeCount = DB::table($ratingTable)
            ->where('post_id', $postId)
            ->where('type', 'like')
            ->where('is_like', true)
            ->count();

        // 별점 통계 계산
        $ratingStats = DB::table($ratingTable)
            ->where('post_id', $postId)
            ->where('type', 'rating')
            ->whereNotNull('rating')
            ->selectRaw('COUNT(*) as count, AVG(rating) as average')
            ->first();

        $ratingCount = $ratingStats->count ?? 0;
        $ratingAverage = $ratingCount > 0 ? round($ratingStats->average, 1) : 0;

        return [
            'like_count' => $likeCount,
            'rating_count' => $ratingCount,
            'rating_average' => $ratingAverage,
        ];
    }
}