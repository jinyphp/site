<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * Location 생성 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/about/location/create') → CreateController::__invoke()
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
            'view' => 'jiny-site::admin.about.location.create',
            'title' => 'Location 추가',
            'subtitle' => '새로운 위치를 추가합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        return view($this->config['view'], [
            'config' => $this->config,
        ]);
    }
}