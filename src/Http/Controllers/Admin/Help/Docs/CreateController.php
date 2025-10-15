<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help 문서 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::admin.helps.documents.form',
            'title' => 'Help 문서 생성',
            'subtitle' => '새로운 Help 문서를 생성합니다.',
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = DB::table('site_help_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        return view($this->config['view'], [
            'categories' => $categories,
            'config' => $this->config,
            'mode' => 'create',
        ]);
    }
}