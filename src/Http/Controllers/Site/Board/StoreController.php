<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;
use Jiny\Auth\Services\JwtService;

/**
 * 글 저장 컨트롤러
 */
class StoreController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code)
    {
        // JWT 또는 세션 기반 인증 설정 (맨 처음에 처리)
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

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            abort(404, '게시판 테이블이 존재하지 않습니다.');
        }

        // JWT 인증 디버깅
        \Log::info('StoreController Debug', [
            'auth_check' => Auth::check(),
            'auth_id' => Auth::id(),
            'user' => $user,
            'jwt_token' => $request->bearerToken(),
            'access_token_cookie' => $request->cookie('access_token'),
            'hidden_jwt_token' => $request->input('_jwt_token') ? substr($request->input('_jwt_token'), 0, 50) . '...' : null,
            'all_cookies' => array_keys($request->cookies->all()),
            'session_id' => session()->getId(),
            'guards' => array_keys(config('auth.guards', [])),
        ]);

        $data = $request->only(['title', 'content']);
        $data['code'] = $code;

        // user_id 컬럼이 있는 경우에만 추가
        if (Schema::hasColumn($table, 'user_id')) {
            $data['user_id'] = Auth::id();
        }

        // UUID 컬럼이 있는 경우 UUID 생성
        if (Schema::hasColumn($table, 'uuid')) {
            $data['uuid'] = (string) Str::uuid();
        }

        // 사용자 UUID 처리 (사용자가 로그인한 경우)
        if (Schema::hasColumn($table, 'user_uuid') && $user) {
            // 사용자 테이블에서 UUID를 가져오거나, 없으면 user_id 기반으로 생성
            $data['user_uuid'] = $user->uuid ?? $this->generateUserUuid($user->id);
        }

        // 샤드 ID 처리
        if (Schema::hasColumn($table, 'shard_id')) {
            $data['shard_id'] = $this->getShardId($code, $user);
        }

        $data['name'] = $user ? $user->name : '익명';
        $data['email'] = $user ? $user->email : '';
        $data['click'] = 0;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // parent_id가 있으면 하위 글, level 계산
        if ($request->has('parent_id') && $request->parent_id) {
            $parent = DB::table($table)->find($request->parent_id);
            if ($parent) {
                $data['parent_id'] = $request->parent_id;
                $data['level'] = ($parent->level ?? 0) + 1;
            } else {
                $data['level'] = 0;
                $data['parent_id'] = null;
            }
        } else {
            $data['level'] = 0;
            $data['parent_id'] = null;
        }

        DB::table($table)->insert($data);

        return redirect()->route('board.index', $code)
            ->with('success', '게시글이 등록되었습니다.');
    }

    /**
     * 사용자 UUID 생성
     */
    private function generateUserUuid($userId)
    {
        // 사용자 ID 기반으로 일관된 UUID 생성
        return (string) Str::uuid();
    }

    /**
     * 샤드 ID 계산
     */
    private function getShardId($code, $user = null)
    {
        // 기본 샤드 계산 로직
        // 실제 환경에서는 더 복잡한 샤딩 알고리즘을 사용할 수 있습니다

        if ($user && $user->id) {
            // 사용자 ID 기반 샤딩
            return $user->id % 10; // 10개 샤드로 분산
        }

        // 게시판 코드 기반 샤딩 (익명 사용자의 경우)
        return abs(crc32($code)) % 10;
    }

}