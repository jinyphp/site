<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Jiny\Site\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $organization_id, $id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 팀원 정보 확인
        $member = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->findOrFail($id);

        // 사진 파일 삭제
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '팀원이 성공적으로 삭제되었습니다.'
            ]);
        }

        return redirect()
            ->route('admin.cms.about.organization.members.index', $organization_id)
            ->with('success', '팀원이 성공적으로 삭제되었습니다.');
    }
}