<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * FAQ 카테고리 업데이트 컨트롤러
 *
 * 진입 경로:
 * Route::put('/admin/cms/faq/categories/{id}') → UpdateController::__invoke()
 */
class UpdateController extends Controller
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

    public function __invoke(Request $request, $id)
    {
        $validator = $this->validateRequest($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updated = $this->updateCategory($request, $id);

        if (!$updated) {
            return redirect()->back()
                ->with('error', '카테고리를 찾을 수 없습니다.')
                ->withInput();
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'FAQ 카테고리가 성공적으로 수정되었습니다.');
    }

    protected function validateRequest(Request $request, $id)
    {
        return Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_faq_cate,code,' . $id,
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function updateCategory(Request $request, $id)
    {
        $data = $request->only(['code', 'title', 'content', 'icon', 'image', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['updated_at'] = now();

        return DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);
    }
}