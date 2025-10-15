<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 기본 페이지네이션
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $parent_id = $request->get('parent_id');
        $level = $request->get('level');

        // 쿼리 빌더
        $query = SiteAboutOrganization::query();

        // 검색 조건
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 상위 조직 필터
        if ($parent_id !== null) {
            if ($parent_id === 'null' || $parent_id === '') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $parent_id);
            }
        }

        // 레벨 필터
        if ($level !== null) {
            $query->where('level', $level);
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'code', 'level', 'sort_order', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // 기본 정렬 추가
        if ($sortBy !== 'sort_order') {
            $query->orderBy('sort_order', 'asc');
        }
        if ($sortBy !== 'name') {
            $query->orderBy('name', 'asc');
        }

        // 관계 로드
        $query->with(['parent', 'children', 'teamMembers'])
              ->withCount('teamMembers');

        $organizations = $query->paginate($perPage);

        // 통계 데이터
        $stats = [
            'total' => SiteAboutOrganization::count(),
            'active' => SiteAboutOrganization::where('is_active', true)->count(),
            'inactive' => SiteAboutOrganization::where('is_active', false)->count(),
            'roots' => SiteAboutOrganization::whereNull('parent_id')->count(),
            'with_members' => SiteAboutOrganization::has('teamMembers')->count(),
        ];

        // 트리 구조용 루트 조직들
        $rootOrganizations = SiteAboutOrganization::whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // 필터 옵션용 데이터
        $parentOptions = SiteAboutOrganization::orderBy('level')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function($org) {
                return [
                    'id' => $org->id,
                    'name' => str_repeat('└ ', $org->level) . $org->name,
                    'level' => $org->level
                ];
            });

        return view('jiny-site::admin.about.organization.index', compact(
            'organizations',
            'stats',
            'rootOrganizations',
            'parentOptions',
            'search',
            'parent_id',
            'level',
            'sortBy',
            'sortDirection',
            'perPage'
        ));
    }
}