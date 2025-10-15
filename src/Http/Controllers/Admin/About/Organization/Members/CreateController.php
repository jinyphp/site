<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization\Members;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use App\Models\SiteAboutOrganizationMember;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request, $organization_id)
    {
        // 조직 정보 확인
        $organization = SiteAboutOrganization::findOrFail($organization_id);

        // 다음 정렬 순서 계산
        $nextSortOrder = SiteAboutOrganizationMember::where('organization_id', $organization_id)
            ->max('sort_order') + 1;

        return view('jiny-site::admin.about.organization.members.create', compact(
            'organization',
            'nextSortOrder'
        ));
    }
}