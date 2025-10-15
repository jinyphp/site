<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use App\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BulkActionController extends Controller
{
    public function __invoke(Request $request, $organization_id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:site_about_organization_members,id'
        ]);

        $action = $request->input('action');
        $ids = $request->input('ids');

        // 해당 조직의 팀원들만 필터링
        $members = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->whereIn('id', $ids);

        $count = $members->count();

        switch ($action) {
            case 'activate':
                $members->update(['is_active' => true]);
                $message = "{$count}명의 팀원이 활성화되었습니다.";
                break;

            case 'deactivate':
                $members->update(['is_active' => false]);
                $message = "{$count}명의 팀원이 비활성화되었습니다.";
                break;

            case 'delete':
                // 삭제 전 사진 파일들 삭제
                $membersToDelete = $members->get();
                foreach ($membersToDelete as $member) {
                    if ($member->photo) {
                        Storage::disk('public')->delete($member->photo);
                    }
                }
                $members->delete();
                $message = "{$count}명의 팀원이 삭제되었습니다.";
                break;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()
            ->route('admin.cms.about.organization.members.index', $organization_id)
            ->with('success', $message);
    }
}