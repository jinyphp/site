<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('/admin/cms/contact/contacts/{id}') → DestroyController::__invoke()
 */
class DestroyController extends Controller
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
            'redirect_route' => 'admin.cms.contact.contacts.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $deleted = $this->deleteContact($id);

        if (!$deleted) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '문의를 찾을 수 없습니다.');
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', '문의가 성공적으로 삭제되었습니다.');
    }

    protected function deleteContact($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();
    }
}