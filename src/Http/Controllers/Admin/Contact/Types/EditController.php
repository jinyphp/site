<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 타입 수정 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/types/{id}/edit') → EditController::__invoke()
 */
class EditController extends Controller
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
            'view' => 'jiny-site::admin.contact.types.edit',
            'title' => 'Contact 타입 수정',
            'subtitle' => '문의 타입 정보를 수정합니다.',
            'redirect_route' => 'admin.cms.contact.types.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $type = $this->getType($id);

        if (!$type) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '타입을 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'type' => $type,
            'config' => $this->config,
        ]);
    }

    protected function getType($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->first();
    }
}