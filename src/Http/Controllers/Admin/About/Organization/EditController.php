<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $organization = SiteAboutOrganization::with(['parent', 'children', 'teamMembers'])->findOrFail($id);

        // 상위 조직 목록 (자기 자신과 하위 조직들은 제외)
        $parentOptions = SiteAboutOrganization::where('id', '!=', $organization->id)
            ->whereNotIn('id', $this->getAllChildrenIds($organization))
            ->orderBy('level')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function($org) {
                return [
                    'id' => $org->id,
                    'name' => str_repeat('└ ', $org->level) . $org->name,
                    'level' => $org->level,
                    'code' => $org->code
                ];
            });

        // 팀 멤버 수
        $teamMembersCount = $organization->teamMembers->count();

        // 하위 조직 수
        $childrenCount = $organization->children->count();

        return view('jiny-site::admin.about.organization.edit', compact(
            'organization',
            'parentOptions',
            'teamMembersCount',
            'childrenCount'
        ));
    }

    /**
     * 모든 하위 조직 ID를 재귀적으로 가져오기
     */
    private function getAllChildrenIds(SiteAboutOrganization $organization)
    {
        $childrenIds = [];

        foreach ($organization->children as $child) {
            $childrenIds[] = $child->id;
            $childrenIds = array_merge($childrenIds, $this->getAllChildrenIds($child));
        }

        return $childrenIds;
    }
}