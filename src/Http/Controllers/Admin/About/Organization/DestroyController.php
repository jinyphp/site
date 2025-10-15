<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $organization = SiteAboutOrganization::with(['children', 'teamMembers'])->findOrFail($id);

        // 하위 조직이 있는지 확인
        if ($organization->children->count() > 0) {
            return redirect()->back()
                ->with('error', '하위 조직이 있는 조직은 삭제할 수 없습니다. 먼저 하위 조직을 삭제하거나 이동해주세요.');
        }

        // 팀 멤버가 있는지 확인
        if ($organization->teamMembers->count() > 0) {
            return redirect()->back()
                ->with('error', '팀 멤버가 있는 조직은 삭제할 수 없습니다. 먼저 팀 멤버를 다른 조직으로 이동하거나 삭제해주세요.');
        }

        try {
            $organizationName = $organization->name;
            $organization->delete();

            return redirect()
                ->route('admin.cms.about.organization.index')
                ->with('success', "조직 '{$organizationName}'이 성공적으로 삭제되었습니다.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '조직 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}