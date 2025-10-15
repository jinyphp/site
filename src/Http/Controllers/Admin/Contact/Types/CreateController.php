<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * Contact 타입 생성 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/types/create') → CreateController::__invoke()
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'view' => 'jiny-site::admin.contact.types.create',
            'title' => 'Contact 타입 생성',
            'subtitle' => '새로운 문의 타입을 작성합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        return view($this->config['view'], [
            'config' => $this->config,
        ]);
    }
}