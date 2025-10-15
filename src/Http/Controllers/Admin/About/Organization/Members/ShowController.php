<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use App\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request, $organization_id, $id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 팀원 정보 확인
        $member = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->findOrFail($id);

        return view('jiny-site::admin.about.organization.members.show', compact(
            'organization',
            'member'
        ));
    }
}