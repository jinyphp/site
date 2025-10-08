<?php
namespace Jiny\Site\Http\Controllers\Admin\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin Board Trend Controller
 *
 * 트렌드글을 관리하는 컨트롤러입니다.
 */
class AdminBoardTrend extends Controller
{
    /**
     * 테이블명
     */
    protected $table = 'site_board_trend';

    /**
     * 뷰 경로
     */
    protected $viewPath = 'jiny-site::admin.board_trend';

    /**
     * 페이지 설정
     */
    protected $config = [
        'title' => '트렌드글',
        'subtitle' => '계시물과 연관된 트렌드글을 관리합니다.',
    ];

    /**
     * 목록 표시
     */
    public function index(Request $request)
    {
        $rows = DB::table($this->table)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view("{$this->viewPath}.list", [
            'rows' => $rows,
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 생성 폼 표시
     */
    public function create()
    {
        return view("{$this->viewPath}.form", [
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 데이터 저장
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table($this->table)->insert($data);

        return redirect()->route('admin.cms.board.trend')
            ->with('success', '트렌드글이 생성되었습니다.');
    }

    /**
     * 수정 폼 표시
     */
    public function edit($id)
    {
        $item = DB::table($this->table)->find($id);

        return view("{$this->viewPath}.form", [
            'item' => $item,
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 데이터 수정
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $data['updated_at'] = now();

        // 코드는 변경이 불가능합니다.
        unset($data['code']);

        DB::table($this->table)
            ->where('id', $id)
            ->update($data);

        return redirect()->route('admin.cms.board.trend')
            ->with('success', '트렌드글이 수정되었습니다.');
    }

    /**
     * 데이터 삭제
     */
    public function destroy($id)
    {
        DB::table($this->table)->where('id', $id)->delete();

        return redirect()->route('admin.cms.board.trend')
            ->with('success', '트렌드글이 삭제되었습니다.');
    }
}
