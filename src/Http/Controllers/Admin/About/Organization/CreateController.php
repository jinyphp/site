<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        // 상위 조직 목록 (계층 구조로 표시)
        $parentOptions = SiteAboutOrganization::orderBy('level')
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

        // 선택된 상위 조직 (URL 파라미터에서)
        $selectedParentId = $request->get('parent_id');
        $selectedParent = null;

        if ($selectedParentId) {
            $selectedParent = SiteAboutOrganization::find($selectedParentId);
        }

        // 다음 정렬 순서 계산
        $nextSortOrder = 1;
        if ($selectedParentId) {
            $nextSortOrder = SiteAboutOrganization::where('parent_id', $selectedParentId)
                ->max('sort_order') + 1;
        } else {
            $nextSortOrder = SiteAboutOrganization::whereNull('parent_id')
                ->max('sort_order') + 1;
        }

        // 다음 레벨 계산
        $nextLevel = 0;
        if ($selectedParent) {
            $nextLevel = $selectedParent->level + 1;
        }

        return view('jiny-site::admin.about.organization.create', compact(
            'parentOptions',
            'selectedParentId',
            'selectedParent',
            'nextSortOrder',
            'nextLevel'
        ));
    }
}