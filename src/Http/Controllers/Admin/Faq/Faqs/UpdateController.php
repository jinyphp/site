<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * FAQ 업데이트 컨트롤러
 *
 * 진입 경로:
 * Route::put('/admin/cms/faq/faqs/{id}') → UpdateController::__invoke()
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
            'table' => 'site_faq',
            'redirect_route' => 'admin.cms.faq.faqs.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updated = $this->updateFaq($request, $id);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'FAQ를 찾을 수 없습니다.')
                ->withInput();
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'FAQ가 성공적으로 수정되었습니다.');
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'cate' => 'nullable|string|exists:site_faq_cate,code',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function updateFaq(Request $request, $id)
    {
        $data = $request->only(['question', 'answer', 'cate', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['updated_at'] = now();

        return DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);
    }
}