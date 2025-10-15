<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $organization = SiteAboutOrganization::findOrFail($id);

        // 유효성 검사
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:site_about_organization,code,' . $id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:site_about_organization,id',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'manager_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        // 상위 조직 순환 참조 검사
        if ($request->parent_id) {
            if ($request->parent_id == $id) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('parent_id', '자기 자신을 상위 조직으로 설정할 수 없습니다.');
                });
            } else {
                // 하위 조직을 상위 조직으로 설정하는지 검사
                $childrenIds = $this->getAllChildrenIds($organization);
                if (in_array($request->parent_id, $childrenIds)) {
                    $validator->after(function ($validator) {
                        $validator->errors()->add('parent_id', '하위 조직을 상위 조직으로 설정할 수 없습니다.');
                    });
                }
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // 상위 조직 변경 시 레벨 재계산
        if ($data['parent_id'] != $organization->parent_id) {
            if ($data['parent_id']) {
                $parent = SiteAboutOrganization::find($data['parent_id']);
                $data['level'] = $parent ? $parent->level + 1 : 0;
            } else {
                $data['parent_id'] = null;
                $data['level'] = 0;
            }

            // 하위 조직들의 레벨도 재계산
            $this->updateChildrenLevels($organization, $data['level']);
        }

        // boolean 값 처리
        $data['is_active'] = $request->has('is_active');

        try {
            $organization->update($data);

            return redirect()
                ->route('admin.cms.about.organization.index')
                ->with('success', '조직이 성공적으로 수정되었습니다.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '조직 수정 중 오류가 발생했습니다: ' . $e->getMessage())
                ->withInput();
        }
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

    /**
     * 하위 조직들의 레벨을 재귀적으로 업데이트
     */
    private function updateChildrenLevels(SiteAboutOrganization $organization, $newParentLevel)
    {
        foreach ($organization->children as $child) {
            $child->update(['level' => $newParentLevel + 1]);
            $this->updateChildrenLevels($child, $newParentLevel + 1);
        }
    }
}