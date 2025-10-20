<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Jiny\Site\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;

class ToggleController extends Controller
{
    public function __invoke(Request $request, $organization_id, $id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 팀원 정보 확인
        $member = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->findOrFail($id);

        $member->is_active = !$member->is_active;
        $member->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $member->is_active,
                'message' => $member->is_active ? '팀원이 활성화되었습니다.' : '팀원이 비활성화되었습니다.'
            ]);
        }

        return redirect()
            ->route('admin.cms.about.organization.members.index', $organization_id)
            ->with('success', $member->is_active ? '팀원이 활성화되었습니다.' : '팀원이 비활성화되었습니다.');
    }
}