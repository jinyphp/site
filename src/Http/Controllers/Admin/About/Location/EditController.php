<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Location 수정 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/about/location/{id}/edit') → EditController::__invoke()
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
            'view' => 'jiny-site::admin.about.location.edit',
            'title' => 'Location 수정',
            'subtitle' => '위치 정보를 수정합니다.',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $location = DB::table('site_location')->find($id);

        if (!$location) {
            return redirect()->route('admin.cms.about.location.index')
                ->with('error', '해당 Location을 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'location' => $location,
            'config' => $this->config,
        ]);
    }
}