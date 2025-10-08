<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 게시글 평가(좋아요/별점) 저장 컨트롤러
 */
class StoreRatingController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code, $postId)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            return response()->json(['error' => '게시판을 찾을 수 없습니다.'], 404);
        }

        // 읽기 권한 확인 (평가도 읽기 권한이 있어야 가능)
        if (!$this->hasPermission($board, 'read')) {
            return response()->json(['error' => '게시판에 접근할 권한이 없습니다.'], 403);
        }

        $table = "site_board_" . $code;
        $ratingTable = $table . "_ratings";

        // 테이블 존재 확인
        if (!Schema::hasTable($table) || !Schema::hasTable($ratingTable)) {
            return response()->json(['error' => '테이블이 존재하지 않습니다.'], 404);
        }

        // 게시글 존재 확인
        $post = DB::table($table)->find($postId);
        if (!$post) {
            return response()->json(['error' => '게시글을 찾을 수 없습니다.'], 404);
        }

        // 입력 검증
        $request->validate([
            'type' => 'required|in:like,rating',
            'rating' => 'nullable|integer|min:1|max:5', // 별점일 때만
            'is_like' => 'nullable|boolean', // 좋아요일 때만
        ], [
            'type.required' => '평가 유형을 선택해주세요.',
            'type.in' => '올바른 평가 유형을 선택해주세요.',
            'rating.integer' => '별점은 숫자여야 합니다.',
            'rating.min' => '별점은 1점 이상이어야 합니다.',
            'rating.max' => '별점은 5점 이하여야 합니다.',
        ]);

        $type = $request->type;
        $clientIp = $request->ip();

        try {
            // 기존 평가 확인
            $existingRating = null;

            if ($user) {
                // 로그인한 사용자
                $existingRating = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('user_id', $user->id)
                    ->where('type', $type)
                    ->first();
            } else {
                // 비회원 - IP 기반
                $existingRating = DB::table($ratingTable)
                    ->where('post_id', $postId)
                    ->where('ip_address', $clientIp)
                    ->where('type', $type)
                    ->whereNull('user_id')
                    ->first();
            }

            $ratingData = [
                'post_id' => $postId,
                'type' => $type,
                'ip_address' => $clientIp,
                'updated_at' => now(),
            ];

            // 사용자 정보 추가
            if ($user) {
                $ratingData['user_id'] = $user->id;
                $ratingData['name'] = $user->name ?? $user->email;
                $ratingData['email'] = $user->email;
            }

            if ($type === 'like') {
                // 좋아요 처리
                $isLike = $request->boolean('is_like', true);
                $ratingData['is_like'] = $isLike;

                if ($existingRating) {
                    // 기존 좋아요가 있으면 토글
                    $newLikeState = !$existingRating->is_like;

                    DB::table($ratingTable)
                        ->where('id', $existingRating->id)
                        ->update([
                            'is_like' => $newLikeState,
                            'updated_at' => now(),
                        ]);

                    $result = $newLikeState ? 'liked' : 'unliked';
                } else {
                    // 새 좋아요 추가
                    $ratingData['created_at'] = now();

                    DB::table($ratingTable)->insert($ratingData);
                    $result = 'liked';
                }

            } else {
                // 별점 처리
                $rating = $request->integer('rating');

                if (!$rating || $rating < 1 || $rating > 5) {
                    return response()->json(['error' => '올바른 별점(1-5)을 입력해주세요.'], 400);
                }

                $ratingData['rating'] = $rating;
                $ratingData['is_like'] = false; // 별점은 좋아요와 별개

                if ($existingRating) {
                    // 기존 별점 수정
                    DB::table($ratingTable)
                        ->where('id', $existingRating->id)
                        ->update([
                            'rating' => $rating,
                            'updated_at' => now(),
                        ]);

                    $result = 'updated';
                } else {
                    // 새 별점 추가
                    $ratingData['created_at'] = now();

                    DB::table($ratingTable)->insert($ratingData);
                    $result = 'added';
                }
            }

            // 통계 업데이트
            $stats = $this->updatePostStats($ratingTable, $postId);

            return response()->json([
                'success' => true,
                'result' => $result,
                'type' => $type,
                'stats' => $stats,
                'message' => $this->getSuccessMessage($type, $result),
            ]);

        } catch (\Exception $e) {
            \Log::error('Rating store failed', [
                'error' => $e->getMessage(),
                'post_id' => $postId,
                'type' => $type,
                'table' => $ratingTable,
            ]);

            return response()->json(['error' => '평가 저장 중 오류가 발생했습니다.'], 500);
        }
    }

    /**
     * 게시글 통계 업데이트 및 반환
     */
    private function updatePostStats($ratingTable, $postId)
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
            ->selectRaw('COUNT(*) as count, AVG(rating) as average, SUM(rating) as total')
            ->first();

        $ratingCount = $ratingStats->count ?? 0;
        $ratingAverage = $ratingCount > 0 ? round($ratingStats->average, 1) : 0;

        return [
            'like_count' => $likeCount,
            'rating_count' => $ratingCount,
            'rating_average' => $ratingAverage,
        ];
    }

    /**
     * 성공 메시지 생성
     */
    private function getSuccessMessage($type, $result)
    {
        if ($type === 'like') {
            return $result === 'liked' ? '좋아요가 추가되었습니다.' : '좋아요가 취소되었습니다.';
        } else {
            return $result === 'added' ? '별점이 등록되었습니다.' : '별점이 수정되었습니다.';
        }
    }
}