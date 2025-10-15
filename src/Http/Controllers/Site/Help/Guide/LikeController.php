<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Guide;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 가이드 좋아요/싫어요 기능 컨트롤러
 *
 * 진입 경로:
 * Route::post('/help/guide/{id}/like') → LikeController::__invoke()
 */
class LikeController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'guide_table' => 'site_guide',
            'likes_table' => 'site_guide_likes',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $type = $request->input('type');
        $userIp = $request->ip();
        $userId = auth()->id(); // 로그인한 사용자 ID (옵션)

        // 가이드 존재 확인
        $guide = DB::table($this->config['guide_table'])
            ->where('id', $id)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->first();

        if (!$guide) {
            return response()->json(['error' => '가이드를 찾을 수 없습니다.'], 404);
        }

        try {
            DB::beginTransaction();

            // 기존 좋아요/싫어요 확인 (IP 기준)
            $existingLike = DB::table($this->config['likes_table'])
                ->where('guide_id', $id)
                ->where('user_ip', $userIp)
                ->first();

            if ($existingLike) {
                if ($existingLike->type === $type) {
                    // 같은 타입이면 취소 (삭제)
                    DB::table($this->config['likes_table'])
                        ->where('id', $existingLike->id)
                        ->delete();

                    // 카운트 감소
                    $column = $type === 'like' ? 'likes' : 'dislikes';
                    DB::table($this->config['guide_table'])
                        ->where('id', $id)
                        ->decrement($column);

                    $action = 'removed';
                } else {
                    // 다른 타입이면 변경
                    DB::table($this->config['likes_table'])
                        ->where('id', $existingLike->id)
                        ->update([
                            'type' => $type,
                            'updated_at' => now(),
                        ]);

                    // 이전 타입 감소, 새 타입 증가
                    $oldColumn = $existingLike->type === 'like' ? 'likes' : 'dislikes';
                    $newColumn = $type === 'like' ? 'likes' : 'dislikes';

                    DB::table($this->config['guide_table'])
                        ->where('id', $id)
                        ->decrement($oldColumn);

                    DB::table($this->config['guide_table'])
                        ->where('id', $id)
                        ->increment($newColumn);

                    $action = 'changed';
                }
            } else {
                // 새로운 좋아요/싫어요 추가
                DB::table($this->config['likes_table'])->insert([
                    'guide_id' => $id,
                    'user_ip' => $userIp,
                    'user_id' => $userId,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 카운트 증가
                $column = $type === 'like' ? 'likes' : 'dislikes';
                DB::table($this->config['guide_table'])
                    ->where('id', $id)
                    ->increment($column);

                $action = 'added';
            }

            // 업데이트된 카운트 조회
            $updatedGuide = DB::table($this->config['guide_table'])
                ->select('likes', 'dislikes')
                ->where('id', $id)
                ->first();

            // 사용자의 현재 좋아요 상태 확인
            $userLike = DB::table($this->config['likes_table'])
                ->where('guide_id', $id)
                ->where('user_ip', $userIp)
                ->first();

            DB::commit();

            return response()->json([
                'success' => true,
                'action' => $action,
                'type' => $type,
                'likes' => $updatedGuide->likes,
                'dislikes' => $updatedGuide->dislikes,
                'userLike' => $userLike ? $userLike->type : null,
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => '처리 중 오류가 발생했습니다.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}