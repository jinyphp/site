<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 타입 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('/admin/cms/contact/types/{id}') → DestroyController::__invoke()
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
            'table' => 'site_contact_type',
            'redirect_route' => 'admin.cms.contact.types.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 해당 타입을 사용하는 contact가 있는지 확인
        $contactCount = $this->getContactCount($id);

        if ($contactCount > 0) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '이 타입을 사용하는 문의가 있어 삭제할 수 없습니다.');
        }

        $deleted = $this->deleteType($id);

        if (!$deleted) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '타입을 찾을 수 없습니다.');
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'Contact 타입이 성공적으로 삭제되었습니다.');
    }

    protected function getContactCount($id)
    {
        return DB::table('site_contact')
            ->where('type', function($query) use ($id) {
                $query->select('code')
                    ->from('site_contact_type')
                    ->where('id', $id);
            })
            ->count();
    }

    protected function deleteType($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();
    }
}