<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * FAQ 카테고리 저장 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/faq/categories/') → StoreController::__invoke()
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_faq_cate',
            'redirect_route' => 'admin.cms.faq.categories.index',
        ];
    }

    public function __invoke(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->storeCategory($request);

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'FAQ 카테고리가 성공적으로 생성되었습니다.');
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_faq_cate,code',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function storeCategory(Request $request)
    {
        $data = $request->only(['code', 'title', 'content', 'icon', 'image', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['manager'] = auth()->user()->email ?? 'system';
        $data['like'] = 0;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // pos가 없으면 마지막 순서로 설정
        if (!isset($data['pos'])) {
            $data['pos'] = DB::table($this->config['table'])->max('pos') + 1;
        }

        DB::table($this->config['table'])->insert($data);
    }
}