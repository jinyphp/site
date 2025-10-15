<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;
use App\Models\User;

/**
 * 지원 요청 유형 생성 컨트롤러
 */
class CreateController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 생성 폼 표시
     */
    public function __invoke(Request $request)
    {
        // 관리자 목록
        $assignees = User::where('isAdmin', true)
            ->select('id', 'name', 'email')
            ->get();

        // 다음 정렬 순서
        $nextSortOrder = SiteSupportType::getNextSortOrder();

        // 기본 필수 필드 목록
        $defaultRequiredFields = SiteSupportType::getDefaultRequiredFields();

        // 사용 가능한 아이콘 목록
        $availableIcons = SiteSupportType::getAvailableIcons();

        // 기본 색상 목록
        $defaultColors = SiteSupportType::getDefaultColors();

        return view('jiny-site::admin.support.types.create', [
            'assignableUsers' => $assignees,
            'nextSortOrder' => $nextSortOrder,
            'defaultRequiredFields' => $defaultRequiredFields,
            'availableIcons' => $availableIcons,
            'defaultColors' => $defaultColors,
        ]);
    }
}