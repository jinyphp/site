<?php

namespace Jiny\Site\Http\Controllers\Site\Faq;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 메인 페이지 컨트롤러
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
            'view' => config('site.faq.view', 'jiny-site::www.faq.index'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $categories = $this->getCategories();
        $faqs = $this->getFaqs($request);

        return view($this->config['view'], [
            'categories' => $categories,
            'faqs' => $faqs,
            'config' => $this->config,
        ]);
    }

    protected function getCategories()
    {
        return DB::table('site_faq_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();
    }

    protected function getFaqs(Request $request)
    {
        $query = DB::table($this->config['table'])
            ->where('enable', true);

        if ($request->filled('category')) {
            $query->where('cate', $request->get('category'));
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('pos')
            ->paginate($this->config['per_page']);
    }
}