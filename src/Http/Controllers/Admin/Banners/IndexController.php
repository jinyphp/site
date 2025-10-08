<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 배너 관리 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/banners') → IndexController::__invoke()
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_banner',
            'view' => config('site.admin.banners.view', 'jiny-site::admin.banners.index'),
            'title' => '배너 관리',
            'subtitle' => '사이트 상단에 알림 배너를 관리합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        $banners = DB::table($this->config['table'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view($this->config['view'], [
            'banners' => $banners,
            'config' => $this->config,
        ]);
    }
}
