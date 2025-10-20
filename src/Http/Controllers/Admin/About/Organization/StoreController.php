<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use Jiny\Site\Models\SiteAboutOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        // 유효성 검사
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:site_about_organization,code',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:site_about_organization,id',
            'sort_order' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'manager_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // 상위 조직이 선택된 경우 레벨 자동 계산
        if ($data['parent_id']) {
            $parent = SiteAboutOrganization::find($data['parent_id']);
            if ($parent) {
                $data['level'] = $parent->level + 1;
            }
        } else {
            $data['parent_id'] = null;
            $data['level'] = 0;
        }

        // boolean 값 처리
        $data['is_active'] = $request->has('is_active');

        try {
            $organization = SiteAboutOrganization::create($data);

            return redirect()
                ->route('admin.cms.about.organization.index')
                ->with('success', '조직이 성공적으로 생성되었습니다.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '조직 생성 중 오류가 발생했습니다: ' . $e->getMessage())
                ->withInput();
        }
    }
}