<?php

namespace Jiny\Site\Http\Controllers\Site\Faq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/faq') → IndexController::__invoke()
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
            'table' => 'site_faq',
            'view' => config('site.faq.view', 'jiny-site::site.faq.index'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $categories = DB::table('site_faq_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        $faqs = DB::table($this->config['table'])
            ->where('enable', true)
            ->orderBy('pos')
            ->paginate($this->config['per_page']);

        return view($this->config['view'], [
            'categories' => $categories,
            'faqs' => $faqs,
            'config' => $this->config,
        ]);
    }
}
