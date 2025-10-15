<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteCountry;

/**
 * 국가 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/cms/country') → IndexController::__invoke()
 */
class IndexController extends BaseController
{

    /**
     * 국가 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 통계 데이터 생성
        $stats = $this->generateStats();

        // 필터링된 국가 목록 조회
        $countries = $this->getFilteredCountries($request);

        $indexConfig = $this->getConfig('index', []);

        return view($indexConfig['view'] ?? 'jiny-site::admin.countries.index', [
            'countries' => $countries,
            'config' => $indexConfig,
            'stats' => $stats,
        ]);
    }

    /**
     * 통계 데이터 생성
     *
     * @return array
     */
    protected function generateStats()
    {
        $avgTaxRate = DB::table('site_countries')
            ->where('enable', true)
            ->avg('tax_rate');

        $maxTaxRate = DB::table('site_countries')
            ->where('enable', true)
            ->max('tax_rate');

        $minTaxRate = DB::table('site_countries')
            ->where('enable', true)
            ->min('tax_rate');

        return [
            'total' => SiteCountry::count(),
            'active' => SiteCountry::where('enable', true)->count(),
            'inactive' => SiteCountry::where('enable', false)->count(),
            'default' => SiteCountry::where('is_default', true)->count(),
            'currencies_count' => DB::table('site_countries')
                ->whereNotNull('currency_code')
                ->distinct('currency_code')
                ->count(),
            'tax_rates' => [
                'average' => $avgTaxRate ? round($avgTaxRate * 100, 2) . '%' : '0%',
                'highest' => $maxTaxRate ? round($maxTaxRate * 100, 2) . '%' : '0%',
                'lowest' => $minTaxRate ? round($minTaxRate * 100, 2) . '%' : '0%',
            ],
        ];
    }

    /**
     * 필터링된 국가 목록 조회
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredCountries(Request $request)
    {
        $query = SiteCountry::query();

        // 검색 필터
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('native_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('capital', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 활성화 상태 필터
        if ($request->has('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', $request->get('enable') == '1');
        }

        // 기본 국가 필터
        if ($request->has('is_default') && $request->get('is_default') !== 'all') {
            $query->where('is_default', $request->get('is_default') == '1');
        }

        // 통화 필터
        if ($request->has('currency_code') && $request->get('currency_code') !== 'all') {
            $query->where('currency_code', $request->get('currency_code'));
        }

        // 대륙 필터
        if ($request->has('continent') && $request->get('continent') !== 'all') {
            $query->where('continent', $request->get('continent'));
        }

        // JSON 설정에서 기본 정렬 정보 가져오기
        $defaultSort = $this->getConfig('table.sort', ['column' => 'order', 'order' => 'asc']);
        $sortBy = $request->get('sort_by', $defaultSort['column']);
        $order = $request->get('order', $defaultSort['order']);

        $query->orderBy($sortBy, $order);

        // JSON 설정에서 페이지당 항목 수 가져오기
        $perPage = $this->getConfig('index.pagination.per_page', 15);
        return $query->paginate($perPage);
    }
}
