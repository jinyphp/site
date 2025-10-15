<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $service;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help_cate',
            'route_prefix' => 'admin.cms.help.categories',
        ];

        $this->service = new CategoryService($this->config);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $result = $this->service->store($request);

        if ($result['success']) {
            return redirect()->route('admin.cms.help.categories.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->back()
                ->withErrors($result['errors'])
                ->withInput();
        }
    }
}