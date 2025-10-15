<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 하위 글 작성 폼 컨트롤러
 */
class CreateChildController extends Controller
{
    use BoardPermissions;

    protected $viewPath = 'jiny-site::www.board';

    public function __invoke(Request $request, $code, $id)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            abort(404, '게시판을 찾을 수 없습니다.');
        }

        // 글쓰기 권한 확인
        if (!$this->hasPermission($board, 'create')) {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', '로그인이 필요합니다.');
            }
            return redirect()->route('board.index', $code)
                ->with('error', '글쓰기 권한이 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            abort(404, '게시판 테이블이 존재하지 않습니다.');
        }

        $parent = DB::table($table)->find($id);

        if (!$parent) {
            return redirect()->route('board.index', $code)
                ->with('error', '부모 게시글을 찾을 수 없습니다.');
        }

        return view("{$this->viewPath}.reply", [
            'board' => $board,
            'code' => $code,
            'parent' => $parent,
            'user' => $user, // JWT 사용자 정보 전달
        ]);
    }
}