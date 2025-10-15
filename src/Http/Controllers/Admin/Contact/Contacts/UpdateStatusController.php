<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Contact 상태 변경 컨트롤러
 *
 * 진입 경로:
 * Route::put('/admin/cms/contact/contacts/{id}/status') → UpdateStatusController::__invoke()
 */
class UpdateStatusController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_contact',
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

        $updated = $this->updateStatus($request, $id);

        if (!$updated) {
            return redirect()->back()
                ->with('error', '문의를 찾을 수 없습니다.')
                ->withInput();
        }

        return redirect()->back()
            ->with('success', '문의 상태가 성공적으로 변경되었습니다.');
    }

    protected function validateRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'status' => 'required|string|in:pending,replied,closed',
            'reply' => 'nullable|string',
        ]);
    }

    protected function updateStatus(Request $request, $id)
    {
        $data = [
            'status' => $request->get('status'),
            'updated_at' => now(),
        ];

        if ($request->filled('reply')) {
            $data['reply'] = $request->get('reply');
            $data['replied_at'] = now();
            $data['replied_by'] = auth()->user()->email ?? 'system';
        }

        return DB::table($this->config['table'])
            ->where('id', $id)
            ->update($data);
    }
}