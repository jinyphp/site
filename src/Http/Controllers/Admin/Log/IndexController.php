<?php
namespace Jiny\Site\Http\Controllers\Admin\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $logs = DB::table('site_log')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $stats = [
            'total' => DB::table('site_log')->sum('cnt'),
            'today' => DB::table('site_log')->whereDate('created_at', today())->sum('cnt'),
            'this_month' => DB::table('site_log')->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->sum('cnt'),
        ];

        return view('jiny-site::admin.log.index', [
            'logs' => $logs,
            'stats' => $stats,
            'config' => ['title' => 'Log 분석', 'subtitle' => '사이트 방문 로그를 분석합니다.'],
        ]);
    }
}
