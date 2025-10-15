<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $service;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help_cate',
            'view' => 'jiny-site::admin.helps.categories.form',
            'title' => 'Help 카테고리 수정',
            'subtitle' => 'Help 카테고리 정보를 수정합니다.',
            'route_prefix' => 'admin.cms.help.categories',
        ];

        $this->service = new CategoryService($this->config);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $category = $this->service->getCategory($id);

        if (!$category) {
            return redirect()->route('admin.cms.help.categories.index')
                ->with('error', '카테고리를 찾을 수 없습니다.');
        }

        // 이전 페이지의 쿼리 파라미터 정보 보존
        $returnParams = $request->only(['page', 'search']);

        return view($this->config['view'], [
            'config' => $this->config,
            'category' => $category,
            'mode' => 'edit',
            'returnParams' => $returnParams,
        ]);
    }
}