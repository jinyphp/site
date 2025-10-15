<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/cms/language') → IndexController::__invoke()
 */
class IndexController extends BaseController
{

    /**
     * 언어 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 통계 데이터 생성
        $stats = $this->generateStats();

        // 필터링된 언어 목록 조회
        $languages = $this->getFilteredLanguages($request);

        $indexConfig = $this->getConfig('index', []);

        return view($indexConfig['view'] ?? 'jiny-site::admin.languages.index', [
            'languages' => $languages,
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
        return [
            'total' => SiteLanguage::count(),
            'active' => SiteLanguage::where('enable', true)->count(),
            'inactive' => SiteLanguage::where('enable', false)->count(),
            'default' => SiteLanguage::where('is_default', true)->count(),
        ];
    }

    /**
     * 필터링된 언어 목록 조회
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredLanguages(Request $request)
    {
        $query = SiteLanguage::query();

        // 검색 필터
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('native_name', 'like', "%{$search}%")
                  ->orWhere('lang', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 활성화 상태 필터
        if ($request->has('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', $request->get('enable') == '1');
        }

        // 기본 언어 필터
        if ($request->has('is_default') && $request->get('is_default') !== 'all') {
            $query->where('is_default', $request->get('is_default') == '1');
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
