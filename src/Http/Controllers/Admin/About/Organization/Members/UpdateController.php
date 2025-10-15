<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use App\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $organization_id, $id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 팀원 정보 확인
        $member = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'linkedin_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // 사진 업로드 처리
        if ($request->hasFile('photo')) {
            // 기존 사진 삭제
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $path = $request->file('photo')->store('organization/members', 'public');
            $data['photo'] = $path;
        }

        $member->update($data);

        return redirect()
            ->route('admin.cms.about.organization.members.index', $organization_id)
            ->with('success', '팀원 정보가 성공적으로 수정되었습니다.');
    }
}