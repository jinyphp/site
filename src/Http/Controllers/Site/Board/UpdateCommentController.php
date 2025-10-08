<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 코멘트 수정 컨트롤러
 */
class UpdateCommentController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code, $postId, $commentId)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            return response()->json(['error' => '게시판을 찾을 수 없습니다.'], 404);
        }

        $commentTable = "site_board_" . $code . "_comments";

        // 코멘트 테이블 존재 확인
        if (!Schema::hasTable($commentTable)) {
            return response()->json(['error' => '코멘트 테이블이 존재하지 않습니다.'], 404);
        }

        // 코멘트 조회
        $comment = DB::table($commentTable)->where('id', $commentId)->first();

        if (!$comment) {
            return response()->json(['error' => '코멘트를 찾을 수 없습니다.'], 404);
        }

        // 수정 권한 확인 (작성자만 수정 가능)
        $canEdit = false;

        if ($user) {
            // 로그인한 사용자의 경우
            $canEdit = ($comment->user_id == $user->id) ||
                      ($comment->email == $user->email) ||
                      in_array($user->utype ?? '', ['admin', 'super']);
        }

        if (!$canEdit) {
            return response()->json(['error' => '코멘트를 수정할 권한이 없습니다.'], 403);
        }

        // 입력 검증
        $request->validate([
            'content' => 'required|max:1000',
        ], [
            'content.required' => '코멘트 내용을 입력해주세요.',
            'content.max' => '코멘트는 1000자를 초과할 수 없습니다.',
        ]);

        try {
            // 코멘트 수정
            $updated = DB::table($commentTable)
                ->where('id', $commentId)
                ->update([
                    'content' => $request->content,
                    'updated_at' => now(),
                ]);

            if ($updated) {
                return response()->json([
                    'success' => '코멘트가 수정되었습니다.',
                    'content' => $request->content,
                    'updated_at' => now()->format('Y-m-d H:i')
                ]);
            } else {
                return response()->json(['error' => '코멘트 수정에 실패했습니다.'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Comment update failed', [
                'error' => $e->getMessage(),
                'comment_id' => $commentId,
                'table' => $commentTable,
            ]);

            return response()->json(['error' => '코멘트 수정 중 오류가 발생했습니다.'], 500);
        }
    }
}