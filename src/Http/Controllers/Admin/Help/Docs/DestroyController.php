<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help 문서 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help',
            'title' => 'Help 문서 관리',
            'subtitle' => '도움말 문서를 관리합니다.',
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        DB::table($this->config['table'])
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return redirect()->route('admin.cms.help.docs.index')
            ->with('success', 'Help 문서가 성공적으로 삭제되었습니다.');
    }
}