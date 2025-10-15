<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 코멘트 삭제 컨트롤러
 */
class DestroyCommentController extends Controller
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

        // 삭제 권한 확인 (작성자만 삭제 가능)
        $canDelete = false;

        if ($user) {
            // 로그인한 사용자의 경우
            $canDelete = ($comment->user_id == $user->id) ||
                        ($comment->email == $user->email) ||
                        in_array($user->utype ?? '', ['admin', 'super']);
        }

        if (!$canDelete) {
            return response()->json(['error' => '코멘트를 삭제할 권한이 없습니다.'], 403);
        }

        try {
            // 코멘트 삭제
            $deleted = DB::table($commentTable)->where('id', $commentId)->delete();

            if ($deleted) {
                return response()->json(['success' => '코멘트가 삭제되었습니다.']);
            } else {
                return response()->json(['error' => '코멘트 삭제에 실패했습니다.'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Comment deletion failed', [
                'error' => $e->getMessage(),
                'comment_id' => $commentId,
                'table' => $commentTable,
            ]);

            return response()->json(['error' => '코멘트 삭제 중 오류가 발생했습니다.'], 500);
        }
    }
}