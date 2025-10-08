<?php

namespace Jiny\Site\Http\Controllers\Site\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 도움말 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/help') → IndexController::__invoke()
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
            'table' => 'site_help',
            'view' => config('site.help.view', 'jiny-site::site.help.index'),
            'per_page' => config('site.help.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $categories = DB::table('site_help_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        $helps = DB::table($this->config['table'])
            ->where('enable', true)
            ->orderBy('pos')
            ->paginate($this->config['per_page']);

        return view($this->config['view'], [
            'categories' => $categories,
            'helps' => $helps,
            'config' => $this->config,
        ]);
    }
}
