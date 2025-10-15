<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help 문서 상세 조회 컨트롤러
 */
class ShowController extends Controller
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
        $help = DB::table($this->config['table'])
            ->leftJoin('site_help_cate', 'site_help.category', '=', 'site_help_cate.code')
            ->select('site_help.*', 'site_help_cate.title as category_title')
            ->where('site_help.id', $id)
            ->whereNull('site_help.deleted_at')
            ->first();

        if (!$help) {
            return redirect()->route('admin.cms.help.docs.index')
                ->with('error', 'Help 문서를 찾을 수 없습니다.');
        }

        return view('jiny-site::admin.helps.documents.show', [
            'help' => $help,
            'config' => $this->config,
        ]);
    }
}