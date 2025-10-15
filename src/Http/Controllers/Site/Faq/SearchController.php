<?php

namespace Jiny\Site\Http\Controllers\Site\Faq;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 검색 컨트롤러
 *
 * 진입 경로:
 * Route::get('/faq/search') → SearchController::__invoke()
 */
class SearchController extends Controller
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
            'view' => config('site.faq.search_view', 'jiny-site::www.faq.search'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $search = $request->get('q', '');
        $results = collect();

        if (strlen($search) >= 2) {
            $results = $this->searchFaqs($search);
        }

        return view($this->config['view'], [
            'search' => $search,
            'results' => $results,
            'config' => $this->config,
        ]);
    }

    protected function searchFaqs($search)
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_faq_cate', 'site_faq.cate', '=', 'site_faq_cate.code')
            ->select(
                'site_faq.*',
                'site_faq_cate.title as category_title'
            )
            ->where('site_faq.enable', true)
            ->where(function ($q) use ($search) {
                $q->where('site_faq.question', 'like', "%{$search}%")
                  ->orWhere('site_faq.answer', 'like', "%{$search}%");
            })
            ->orderBy('site_faq.pos')
            ->paginate($this->config['per_page'])
            ->withQueryString();
    }
}