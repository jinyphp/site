<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 새 글 작성 폼 컨트롤러
 */
class CreateController extends Controller
{
    use BoardPermissions;

    protected $viewPath = 'jiny-site::www.board';

    public function __invoke(Request $request, $code)
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

        return view("{$this->viewPath}.form", [
            'board' => $board,
            'code' => $code,
            'user' => $user, // JWT 사용자 정보 전달
        ]);
    }
}