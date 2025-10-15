<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteContactType;
use Jiny\Site\Models\SiteContact;

/**
 * 상담 유형 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/cms/contact/types') → IndexController::__invoke()
 */
class IndexController extends BaseController
{

    /**
     * 상담 유형 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 통계 데이터 생성
        $stats = $this->generateStats();

        // 필터링된 상담 유형 목록 조회
        $types = $this->getFilteredTypes($request);

        $indexConfig = $this->getConfig('index', []);

        return view($indexConfig['view'] ?? 'jiny-site::admin.contact.types', [
            'types' => $types,
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
            'total' => SiteContactType::count(),
            'active' => SiteContactType::where('enable', true)->count(),
            'inactive' => SiteContactType::where('enable', false)->count(),
            'in_use' => SiteContactType::whereExists(function($query) {
                $query->select(\DB::raw(1))
                      ->from('site_contacts')
                      ->whereColumn('site_contacts.contact_type_id', 'site_contact_types.id');
            })->count(),
        ];
    }

    /**
     * 필터링된 상담 유형 목록 조회
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredTypes(Request $request)
    {
        $query = SiteContactType::query();

        // 검색 필터
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 활성화 상태 필터
        if ($request->has('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', $request->get('enable') == '1');
        }

        // JSON 설정에서 기본 정렬 정보 가져오기
        $defaultSort = $this->getConfig('table.sort', ['column' => 'sort_order', 'order' => 'asc']);
        $sortBy = $request->get('sort_by', $defaultSort['column']);
        $order = $request->get('order', $defaultSort['order']);

        $query->orderBy($sortBy, $order);

        // JSON 설정에서 페이지당 항목 수 가져오기
        $perPage = $this->getConfig('index.pagination.per_page', 15);
        $types = $query->paginate($perPage);

        // 각 타입별 contacts 개수 계산
        foreach ($types as $type) {
            $type->contacts_count = SiteContact::where('contact_type_id', $type->id)->count();
        }

        return $types;
    }
}