<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $service;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help_cate',
            'view' => 'jiny-site::admin.helps.categories.form',
            'title' => 'Help 카테고리 생성',
            'subtitle' => '새로운 Help 카테고리를 생성합니다.',
            'route_prefix' => 'admin.cms.help.categories',
        ];

        $this->service = new CategoryService($this->config);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view($this->config['view'], [
            'config' => $this->config,
            'mode' => 'create',
        ]);
    }
}