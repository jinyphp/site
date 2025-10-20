<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Jiny\Site\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, $organization_id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 기본 페이지네이션
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $position = $request->get('position');
        $status = $request->get('status');

        // 쿼리 빌더
        $query = SiteAboutOrganizationMember::where('organization_id', $organization_id);

        // 검색 조건
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 직책 필터
        if ($position) {
            $query->where('position', 'like', "%{$position}%");
        }

        // 상태 필터
        if ($status !== null) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');

        if (in_array($sortBy, ['name', 'email', 'position', 'sort_order', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // 기본 정렬 추가
        if ($sortBy !== 'sort_order') {
            $query->orderBy('sort_order', 'asc');
        }
        if ($sortBy !== 'name') {
            $query->orderBy('name', 'asc');
        }

        $members = $query->paginate($perPage);

        // 통계 데이터
        $stats = [
            'total' => SiteAboutOrganizationMember::where('organization_id', $organization_id)->count(),
            'active' => SiteAboutOrganizationMember::where('organization_id', $organization_id)->where('is_active', true)->count(),
            'inactive' => SiteAboutOrganizationMember::where('organization_id', $organization_id)->where('is_active', false)->count(),
        ];

        // 직책 옵션
        $positionOptions = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->whereNotNull('position')
            ->where('position', '!=', '')
            ->distinct()
            ->pluck('position')
            ->sort();

        return view('jiny-site::admin.about.organization.members.index', compact(
            'organization',
            'members',
            'stats',
            'positionOptions',
            'search',
            'position',
            'status',
            'sortBy',
            'sortDirection',
            'perPage'
        ));
    }
}