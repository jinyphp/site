<?php
namespace Jiny\Site\Http\Controllers\Admin\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Admin Board Post Controller
 *
 * 특정 게시판의 게시글을 관리하는 컨트롤러입니다.
 */
class AdminBoardPost extends Controller
{
    /**
     * 뷰 경로
     */
    protected $viewPath = 'jiny-site::admin.board_post';

    /**
     * 게시판 정보 조회
     */
    protected function getBoardInfo($code)
    {
        return DB::table('site_board')->where('code', $code)->first();
    }

    /**
     * 게시판 통계 업데이트
     */
    protected function updateBoardStats($code)
    {
        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return;
        }

        // 게시물 수 계산
        $postCount = DB::table($table)->count();

        // 전체 조회수 계산
        $totalViews = DB::table($table)->sum('click') ?? 0;

        // 마지막 게시글 작성일
        $lastPost = DB::table($table)->orderBy('created_at', 'desc')->first();
        $lastPostAt = $lastPost ? $lastPost->created_at : null;

        // site_board 테이블 업데이트
        DB::table('site_board')
            ->where('code', $code)
            ->update([
                'post' => $postCount,
                'total_views' => $totalViews,
                'last_post_at' => $lastPostAt,
                'updated_at' => now(),
            ]);
    }

    /**
     * 특정 게시판의 글 목록 표시
     */
    public function index(Request $request, $code)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        // 계층 구조를 위한 정렬: parent_id가 null인 것부터, 그 다음 id 순서
        $rows = DB::table($table)
            ->orderByRaw('COALESCE(parent_id, id) ASC, parent_id IS NOT NULL, id ASC')
            ->paginate(15);

        // 각 게시물의 하위글 개수 계산
        $childCounts = [];
        foreach ($rows as $row) {
            $childCounts[$row->id] = DB::table($table)
                ->where('parent_id', $row->id)
                ->count();
        }

        return view("{$this->viewPath}.list", [
            'board' => $board,
            'rows' => $rows,
            'code' => $code,
            'childCounts' => $childCounts,
            'config' => [
                'title' => $board->title . ' - 게시글 관리',
                'subtitle' => $board->subtitle ?? '',
            ]
        ]);
    }

    /**
     * 새 글 작성 폼 표시
     */
    public function create($code)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        return view("{$this->viewPath}.form", [
            'board' => $board,
            'code' => $code,
            'config' => [
                'title' => '새 글 작성 - ' . $board->title,
                'subtitle' => $board->subtitle ?? '',
            ]
        ]);
    }

    /**
     * 하위 글 작성 폼 표시
     */
    public function createChild($code, $id)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        $parent = DB::table($table)->find($id);

        if (!$parent) {
            return redirect()->route('admin.cms.board.posts', $code)
                ->with('error', '부모 게시글을 찾을 수 없습니다.');
        }

        return view("{$this->viewPath}.form", [
            'board' => $board,
            'code' => $code,
            'parent' => $parent,
            'config' => [
                'title' => '하위 글 작성 - ' . $board->title,
                'subtitle' => '부모 글: ' . $parent->title,
            ]
        ]);
    }

    /**
     * 글 저장
     */
    public function store(Request $request, $code)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        $data = $request->except(['_token', '_method']);
        $data['code'] = $code;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // parent_id가 있으면 하위 글, level 계산
        if (isset($data['parent_id']) && $data['parent_id']) {
            $parent = DB::table($table)->find($data['parent_id']);
            if ($parent) {
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

        // 게시판 통계 업데이트
        $this->updateBoardStats($code);

        return redirect()->route('admin.cms.board.posts', $code)
            ->with('success', '게시글이 등록되었습니다.');
    }

    /**
     * 글 수정 폼 표시
     */
    public function edit($code, $id)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        $item = DB::table($table)->find($id);

        if (!$item) {
            return redirect()->route('admin.cms.board.posts', $code)
                ->with('error', '게시글을 찾을 수 없습니다.');
        }

        return view("{$this->viewPath}.form", [
            'board' => $board,
            'item' => $item,
            'code' => $code,
            'config' => [
                'title' => '글 수정 - ' . $board->title,
                'subtitle' => $board->subtitle ?? '',
            ]
        ]);
    }

    /**
     * 글 수정
     */
    public function update(Request $request, $code, $id)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        $data = $request->except(['_token', '_method']);
        $data['updated_at'] = now();

        DB::table($table)
            ->where('id', $id)
            ->update($data);

        // 게시판 통계 업데이트
        $this->updateBoardStats($code);

        return redirect()->route('admin.cms.board.posts', $code)
            ->with('success', '게시글이 수정되었습니다.');
    }

    /**
     * 글 삭제
     */
    public function destroy($code, $id)
    {
        $board = $this->getBoardInfo($code);

        if (!$board) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판을 찾을 수 없습니다.');
        }

        $table = "site_board_" . $code;

        if (!Schema::hasTable($table)) {
            return redirect()->route('admin.cms.board.list')
                ->with('error', '게시판 테이블이 존재하지 않습니다.');
        }

        DB::table($table)->where('id', $id)->delete();

        // 게시판 통계 업데이트
        $this->updateBoardStats($code);

        return redirect()->route('admin.cms.board.posts', $code)
            ->with('success', '게시글이 삭제되었습니다.');
    }
}
