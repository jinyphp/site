<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help 문서 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help',
            'view' => 'jiny-site::admin.helps.documents.form',
            'title' => 'Help 문서 관리',
            'subtitle' => '도움말 문서를 관리합니다.',
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $help = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$help) {
            return redirect()->route('admin.cms.help.docs.index')
                ->with('error', 'Help 문서를 찾을 수 없습니다.');
        }

        $categories = DB::table('site_help_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        // 이전 페이지의 쿼리 파라미터 정보 보존
        $returnParams = $request->only(['page', 'search', 'category', 'enable']);

        return view($this->config['view'], [
            'help' => $help,
            'categories' => $categories,
            'config' => $this->config,
            'mode' => 'edit',
            'returnParams' => $returnParams,
        ]);
    }
}