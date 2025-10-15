<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Contacts;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 상세 조회 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/contacts/{id}') → ShowController::__invoke()
 */
class ShowController extends Controller
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
            'view' => 'jiny-site::admin.contact.contacts.show',
            'title' => 'Contact 상세',
            'subtitle' => '문의 상세 정보를 확인합니다.',
            'redirect_route' => 'admin.cms.contact.contacts.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $contact = $this->getContact($id);

        if (!$contact) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '문의를 찾을 수 없습니다.');
        }

        // 읽음 처리
        $this->markAsRead($id);

        return view($this->config['view'], [
            'contact' => $contact,
            'config' => $this->config,
        ]);
    }

    protected function getContact($id)
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_contact_type', 'site_contact.type', '=', 'site_contact_type.code')
            ->select(
                'site_contact.*',
                'site_contact_type.title as type_title'
            )
            ->where('site_contact.id', $id)
            ->first();
    }

    protected function markAsRead($id)
    {
        DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}