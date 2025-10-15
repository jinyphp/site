<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Contact 타입 업데이트 컨트롤러
 *
 * 진입 경로:
 * Route::put('/admin/cms/contact/types/{id}') → UpdateController::__invoke()
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
            'table' => 'site_contact_type',
            'redirect_route' => 'admin.cms.contact.types.index',
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

        $updated = $this->updateType($request, $id);

        if (!$updated) {
            return redirect()->back()
                ->with('error', '타입을 찾을 수 없습니다.')
                ->withInput();
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'Contact 타입이 성공적으로 수정되었습니다.');
    }

    protected function validateRequest(Request $request, $id)
    {
        return Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:site_contact_type,code,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pos' => 'nullable|integer|min:0',
            'enable' => 'boolean',
        ]);
    }

    protected function updateType(Request $request, $id)
    {
        $data = $request->only(['code', 'title', 'description', 'pos']);
        $data['enable'] = $request->boolean('enable');
        $data['updated_at'] = now();

        return DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);
    }
}