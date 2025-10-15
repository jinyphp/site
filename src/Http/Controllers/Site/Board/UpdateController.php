<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 글 수정 컨트롤러
 */
class UpdateController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code, $id)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        // 디버깅 로그 - 시작
        \Log::info('UpdateController START', [
            'code' => $code,
            'id' => $id,
            'method' => $request->method(),
            'url' => $request->url(),
            'user' => $user ? $user->email : 'anonymous',
            'auth_check' => Auth::check(),
        ]);

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

        // 수정 권한 확인
        $hasPermission = $this->hasPostPermission($board, $post, 'edit');
        \Log::info('UpdateController permission check', [
            'has_permission' => $hasPermission,
            'post_user_id' => $post->user_id ?? null,
            'post_email' => $post->email ?? null,
            'current_user_id' => Auth::id(),
            'current_user_email' => $user ? $user->email : null,
        ]);

        if (!$hasPermission) {
            if (!Auth::check()) {
                \Log::info('UpdateController - redirecting to login');
                return redirect()->route('login')
                    ->with('error', '로그인이 필요합니다.');
            }
            \Log::info('UpdateController - no permission, redirecting to show');
            return redirect()->route('board.show', [$code, $id])
                ->with('error', '게시글을 수정할 권한이 없습니다.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->only(['title', 'content']);
        $data['updated_at'] = now();

        DB::table($table)
            ->where('id', $id)
            ->update($data);

        // 디버깅 로그
        \Log::info('UpdateController redirect', [
            'code' => $code,
            'id' => $id,
            'redirect_url' => route('board.show', [$code, $id]),
            'user' => $user ? $user->email : 'anonymous',
        ]);

        return redirect()->route('board.show', [$code, $id])
            ->with('success', '게시글이 수정되었습니다.');
    }
}