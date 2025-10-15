<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Category;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\CategoryService;

/**
 * Help 카테고리 업데이트 컨트롤러
 */
class UpdateController extends Controller
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
    public function __invoke(Request $request, $id)
    {
        $result = $this->service->update($request, $id);

        if ($result['success']) {
            // 이전 페이지 정보로 리다이렉트
            $returnParams = $request->only(['page', 'search']);
            $returnUrl = route('admin.cms.help.categories.index');

            if (!empty(array_filter($returnParams))) {
                $returnUrl .= '?' . http_build_query($returnParams);
            }

            return redirect($returnUrl)
                ->with('success', $result['message']);
        } else {
            return redirect()->back()
                ->withErrors($result['errors'])
                ->withInput();
        }
    }
}