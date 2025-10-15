<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $service;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help_cate',
            'view' => 'jiny-site::admin.helps.categories.index',
            'title' => 'Help 카테고리 관리',
            'subtitle' => 'Help 카테고리를 관리합니다.',
            'route_prefix' => 'admin.cms.help.categories',
            'per_page' => 15,
        ];

        $this->service = new CategoryService($this->config);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = $this->service->getCategories($request);
        $stats = $this->service->getStats();

        return view($this->config['view'], [
            'categories' => $categories,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }
}