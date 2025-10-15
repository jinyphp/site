<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 글 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code, $id)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            abort(404, '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            abort(404, '게시판 테이블이 존재하지 않습니다.');
        }

        $post = DB::table($table)->find($id);

        if (!$post) {
            abort(404, '게시글을 찾을 수 없습니다.');
        }

        // 삭제 권한 확인
        if (!$this->hasPostPermission($board, $post, 'delete')) {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', '로그인이 필요합니다.');
            }
            return redirect()->route('board.show', [$code, $id])
                ->with('error', '게시글을 삭제할 권한이 없습니다.');
        }

        // 하위글이 있는지 확인
        $childCount = DB::table($table)->where('parent_id', $id)->count();

        if ($childCount > 0) {
            return redirect()->route('board.show', [$code, $id])
                ->with('error', '하위글이 있는 게시글은 삭제할 수 없습니다.');
        }

        DB::table($table)->where('id', $id)->delete();

        return redirect()->route('board.index', $code)
            ->with('success', '게시글이 삭제되었습니다.');
    }
}