<?php
namespace Jiny\Site\Http\Controllers\Admin\Sliders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $sliders = DB::table('site_sliders')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('order', 'asc')
            ->paginate(15);

        return view('jiny-site::admin.sliders.index', [
            'sliders' => $sliders,
            'config' => ['title' => 'Sliders 관리', 'subtitle' => '메인 슬라이더를 관리합니다.'],
        ]);
    }
}
