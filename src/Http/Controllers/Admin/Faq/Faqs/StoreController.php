<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * FAQ 저장 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/faq/faqs/') → StoreController::__invoke()
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
            'table' => 'site_faq',
            'redirect_route' => 'admin.cms.faq.faqs.index',
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

        $this->storeFaq($request);

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'FAQ가 성공적으로 생성되었습니다.');
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|exists:site_faq_cate,code',
            'order' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function storeFaq(Request $request)
    {
        $data = $request->only(['question', 'answer', 'category', 'order']);
        $data['enable'] = $request->boolean('enable');
        $data['views'] = 0;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // order가 없으면 마지막 순서로 설정
        if (!isset($data['order'])) {
            $data['order'] = DB::table($this->config['table'])->max('order') + 1;
        }

        DB::table($this->config['table'])->insert($data);
    }
}