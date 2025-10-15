<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;
use App\Models\User;

/**
 * 지원 요청 유형 수정 컨트롤러
 */
class EditController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 수정 폼 표시
     */
    public function __invoke(Request $request, $id)
    {
        $supportType = SiteSupportType::with('defaultAssignee')->findOrFail($id);

        // 관리자 목록
        $assignees = User::where('isAdmin', true)
            ->select('id', 'name', 'email')
            ->get();

        // 기본 필수 필드 목록
        $defaultRequiredFields = SiteSupportType::getDefaultRequiredFields();

        // 사용 가능한 아이콘 목록
        $availableIcons = SiteSupportType::getAvailableIcons();

        // 기본 색상 목록
        $defaultColors = SiteSupportType::getDefaultColors();

        // 현재 필수 필드를 배열로 변환
        $currentRequiredFields = $supportType->required_fields ?? [];

        return view('jiny-site::admin.support.types.edit', [
            'supportType' => $supportType,
            'assignableUsers' => $assignees,
            'defaultRequiredFields' => $defaultRequiredFields,
            'availableIcons' => $availableIcons,
            'defaultColors' => $defaultColors,
            'currentRequiredFields' => $currentRequiredFields,
        ]);
    }
}