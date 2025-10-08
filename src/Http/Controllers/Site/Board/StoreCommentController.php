<?php

namespace Jiny\Site\Http\Controllers\Site\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jiny\Site\Http\Controllers\Site\Board\BoardPermissions;

/**
 * 코멘트 저장 컨트롤러
 */
class StoreCommentController extends Controller
{
    use BoardPermissions;

    public function __invoke(Request $request, $code, $postId)
    {
        // JWT 또는 세션 기반 인증 설정
        $user = $this->setupAuth($request);

        $board = $this->getBoardInfo($code);

        if (!$board) {
            abort(404, '게시판을 찾을 수 없습니다.');
        }

        // 댓글 작성 권한 확인
        if (!$this->hasPermission($board, 'create')) {
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', '로그인이 필요합니다.');
            }
            abort(403, '댓글을 작성할 권한이 없습니다.');
        }

        $postTable = "site_board_" . $code;
        $commentTable = "site_board_" . $code . "_comments";

        // 게시글 테이블과 코멘트 테이블 존재 확인
        if (!Schema::hasTable($postTable) || !Schema::hasTable($commentTable)) {
            abort(404, '게시판 테이블이 존재하지 않습니다.');
        }

        // 원본 게시글 존재 확인
        $post = DB::table($postTable)->where('id', $postId)->first();
        if (!$post) {
            abort(404, '게시글을 찾을 수 없습니다.');
        }

        // 입력 검증
        $request->validate([
            'content' => 'required|max:1000', // 코멘트는 1000자 제한
        ], [
            'content.required' => '코멘트 내용을 입력해주세요.',
            'content.max' => '코멘트는 1000자를 초과할 수 없습니다.',
        ]);

        // 코멘트 데이터 준비
        $data = [
            'post_id' => $postId,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // 사용자 정보 설정
        if ($user) {
            $data['user_id'] = $user->id;
            $data['name'] = $user->name;
            $data['email'] = $user->email;

            // 샤딩 지원
            if (Schema::hasColumn($commentTable, 'user_uuid')) {
                $data['user_uuid'] = $user->uuid ?? (string) Str::uuid();
            }

            if (Schema::hasColumn($commentTable, 'shard_id')) {
                $data['shard_id'] = $this->getShardId($code, $user);
            }
        } else {
            // 비회원 처리
            $data['name'] = $request->name ?? '익명';
            $data['email'] = $request->email ?? '';

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }
        }

        // UUID 지원
        if (Schema::hasColumn($commentTable, 'post_uuid') && isset($post->uuid)) {
            $data['post_uuid'] = $post->uuid;
        }

        try {
            // 코멘트 저장
            DB::table($commentTable)->insert($data);

            return redirect()->route('board.show', [$code, $postId])
                ->with('success', '코멘트가 등록되었습니다.');
        } catch (\Exception $e) {
            \Log::error('Comment creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
                'table' => $commentTable,
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', '코멘트 등록에 실패했습니다.');
        }
    }

    /**
     * 샤드 ID 계산
     */
    private function getShardId($code, $user = null)
    {
        if ($user && $user->id) {
            return $user->id % 10; // 사용자 ID 기반 샤딩
        }
        return abs(crc32($code)) % 10; // 게시판 코드 기반 샤딩
    }
}