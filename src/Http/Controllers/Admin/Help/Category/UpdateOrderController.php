<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 순서 업데이트 컨트롤러
 */
class UpdateOrderController extends Controller
{
    protected $service;
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help_cate',
        ];

        $this->service = new CategoryService($this->config);
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $result = $this->service->updateOrder($request->input('items', []));

        return response()->json($result);
    }
}