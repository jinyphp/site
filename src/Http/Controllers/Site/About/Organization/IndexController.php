<?php

namespace Jiny\Site\Http\Controllers\Site\About\Organization;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // 조직 트리 구조 가져오기
        $organizations = SiteAboutOrganization::getOrganizationTree();

        // 전체 조직 수
        $totalOrganizations = SiteAboutOrganization::active()->count();

        // 전체 팀 멤버 수
        $totalMembers = 0;
        $totalManagers = 0;

        foreach ($organizations as $org) {
            $totalMembers += $org->teamMembers->count();
            $totalManagers += $org->managers->count();

            // 하위 조직들의 멤버도 포함
            $this->countMembersRecursively($org->allChildren, $totalMembers, $totalManagers);
        }

        // 페이지 설정
        $config = [
            'title' => 'Our Organization',
            'subtitle' => 'Meet our team and organizational structure',
            'description' => 'Discover our organizational hierarchy and the talented individuals who make up our team.',
        ];

        return view('jiny-site::www.about.organization.index', compact(
            'organizations',
            'totalOrganizations',
            'totalMembers',
            'totalManagers',
            'config'
        ));
    }

    /**
     * 재귀적으로 하위 조직의 멤버 수 계산
     */
    private function countMembersRecursively($organizations, &$totalMembers, &$totalManagers)
    {
        foreach ($organizations as $org) {
            $totalMembers += $org->teamMembers->count();
            $totalManagers += $org->managers->count();

            if ($org->allChildren->count() > 0) {
                $this->countMembersRecursively($org->allChildren, $totalMembers, $totalManagers);
            }
        }
    }
}