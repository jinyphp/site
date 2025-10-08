<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 게시글 상세보기 컨트롤러
 */
class ShowController extends Controller
{
    use BoardPermissions;

    protected $viewPath = 'jiny-site::www.board';

    public function __invoke($code, $idOrUuid)
    {
        // JWT 또는 세션 기반 인증 설정 (Request는 전역에서 가져옴)
        $this->setupAuth(request());

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

        // ID 또는 UUID로 게시글 조회
        if (is_numeric($idOrUuid)) {
            // 숫자면 ID로 조회
            $post = DB::table($table)->find($idOrUuid);
            $postId = $idOrUuid;
        } else {
            // UUID로 조회
            $post = $this->findPostByUuid($table, $idOrUuid);
            $postId = $post ? $post->id : null;
        }

        if (!$post) {
            abort(404, '게시글을 찾을 수 없습니다.');
        }

        // 조회수 증가
        $this->incrementViews($code, $postId);

        // 부모 글 정보 조회 (현재 글이 답글인 경우)
        $parentPost = null;
        if ($post->parent_id) {
            $parentPost = DB::table($table)->find($post->parent_id);
        }

        // 하위글 목록 조회 (parent_id는 항상 숫자 ID 사용)
        $children = DB::table($table)
            ->where('parent_id', $postId)
            ->orderBy('created_at', 'asc')
            ->get();

        // 코멘트 목록 조회
        $commentTable = $table . "_comments";
        $comments = [];
        if (Schema::hasTable($commentTable)) {
            $comments = DB::table($commentTable)
                ->where('post_id', $postId)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // 평가 데이터 조회
        $ratingTable = $table . "_ratings";
        $ratingData = [
            'like_count' => 0,
            'rating_count' => 0,
            'rating_average' => 0,
            'user_like' => false,
            'user_rating' => null,
        ];

        if (Schema::hasTable($ratingTable)) {
            // 좋아요 수 계산
            $ratingData['like_count'] = DB::table($ratingTable)
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

            $ratingData['rating_count'] = $ratingStats->count ?? 0;
            $ratingData['rating_average'] = $ratingData['rating_count'] > 0
                ? round($ratingStats->average, 1) : 0;

            // 현재 사용자의 평가 상태 확인
            $user = Auth::user();
            if ($user) {
                // 로그인한 사용자의 좋아요 상태
                $userLike = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('user_id', $user->id)
                    ->where('type', 'like')
                    ->first();

                $ratingData['user_like'] = $userLike ? $userLike->is_like : false;

                // 로그인한 사용자의 별점
                $userRating = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('user_id', $user->id)
                    ->where('type', 'rating')
                    ->first();

                $ratingData['user_rating'] = $userRating ? $userRating->rating : null;
            } else {
                // 비회원의 경우 IP 기반으로 확인
                $clientIp = request()->ip();

                $userLike = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('ip_address', $clientIp)
                    ->where('type', 'like')
                    ->whereNull('user_id')
                    ->first();

                $ratingData['user_like'] = $userLike ? $userLike->is_like : false;

                $userRating = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('ip_address', $clientIp)
                    ->where('type', 'rating')
                    ->whereNull('user_id')
                    ->first();

                $ratingData['user_rating'] = $userRating ? $userRating->rating : null;
            }
        }

        return view("{$this->viewPath}.show", [
            'board' => $board,
            'post' => $post,
            'parentPost' => $parentPost, // 부모 글 정보 추가
            'children' => $children,
            'comments' => $comments,
            'ratingData' => $ratingData, // 평가 데이터 추가
            'code' => $code,
            'isOwner' => $this->isOwner($post),
            'canEdit' => $this->hasPostPermission($board, $post, 'edit'),
            'canDelete' => $this->hasPostPermission($board, $post, 'delete'),
            'canCreate' => $this->hasPermission($board, 'create'),
            'canComment' => $this->hasPermission($board, 'create'), // 코멘트 작성 권한
        ]);
    }
}