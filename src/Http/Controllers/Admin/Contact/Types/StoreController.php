<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Contact 타입 저장 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/contact/types/') → StoreController::__invoke()
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
            'table' => 'site_contact_type',
            'redirect_route' => 'admin.cms.contact.types.index',
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

        $this->storeType($request);

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'Contact 타입이 성공적으로 생성되었습니다.');
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_contact_type,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function storeType(Request $request)
    {
        $data = $request->only(['code', 'title', 'description', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // pos가 없으면 마지막 순서로 설정
        if (!isset($data['pos'])) {
            $data['pos'] = DB::table($this->config['table'])->max('pos') + 1;
        }

        DB::table($this->config['table'])->insert($data);
    }
}