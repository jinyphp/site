<?php
namespace Jiny\Site\Http\Controllers\Admin\Seo;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'total_pages' => DB::table('site_log')->distinct('uri')->count('uri'),
            'total_visits' => DB::table('site_log')->sum('cnt'),
            'today_visits' => DB::table('site_log')->whereDate('created_at', today())->sum('cnt'),
        ];

        return view('jiny-site::admin.seo.index', [
            'stats' => $stats,
            'config' => ['title' => 'SEO 분석', 'subtitle' => 'SEO 및 검색 최적화를 관리합니다.'],
        ]);
    }
}
