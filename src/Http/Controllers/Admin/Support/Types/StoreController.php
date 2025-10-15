<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 유형 저장 컨트롤러
 */
class StoreController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 새 지원 요청 유형 저장
     */
    public function __invoke(Request $request)
    {
        // 유효성 검사
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|alpha_dash|unique:site_support_types,code',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'sort_order' => 'required|integer|min:0',
            'default_priority' => 'required|in:low,normal,high,urgent',
            'default_assignee_id' => 'nullable|exists:users,id',
            'expected_resolution_hours' => 'required|integer|min:1|max:8760', // 최대 1년
            'customer_instructions' => 'nullable|string',
            'required_fields' => 'array',
            'enable' => 'boolean',
        ]);

        // 필수 필드 처리
        $requiredFields = [];
        if ($request->has('required_fields') && is_array($request->required_fields)) {
            $requiredFields = array_filter($request->required_fields);
        }

        // 데이터 저장
        $supportType = SiteSupportType::create([
            'name' => $validatedData['name'],
            'code' => strtolower($validatedData['code']),
            'description' => $validatedData['description'],
            'icon' => $validatedData['icon'],
            'color' => $validatedData['color'],
            'sort_order' => $validatedData['sort_order'],
            'default_priority' => $validatedData['default_priority'],
            'default_assignee_id' => $validatedData['default_assignee_id'],
            'expected_resolution_hours' => $validatedData['expected_resolution_hours'],
            'customer_instructions' => $validatedData['customer_instructions'],
            'required_fields' => $requiredFields,
            'enable' => $request->has('enable'),
        ]);

        // 활동 로그 기록
        \Log::info('Support type created', [
            'type_id' => $supportType->id,
            'type_name' => $supportType->name,
            'type_code' => $supportType->code,
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name,
        ]);

        return redirect()->route('admin.cms.support.types.index')
            ->with('success', '지원 요청 유형이 성공적으로 생성되었습니다.');
    }
}