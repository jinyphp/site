<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 유형 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 지원 요청 유형 삭제
     */
    public function __invoke(Request $request, $id)
    {
        $supportType = SiteSupportType::findOrFail($id);

        // 관련 지원 요청이 있는지 확인
        $relatedRequestsCount = $supportType->supportRequests()->count();

        if ($relatedRequestsCount > 0) {
            return redirect()->route('admin.cms.support.types.index')
                ->with('error', '이 유형을 사용하는 지원 요청이 ' . $relatedRequestsCount . '개 있어 삭제할 수 없습니다. 먼저 관련 요청을 처리하거나 다른 유형으로 변경해주세요.');
        }

        // 삭제 전 정보 저장 (로깅용)
        $typeInfo = [
            'id' => $supportType->id,
            'name' => $supportType->name,
            'code' => $supportType->code,
        ];

        // 삭제 수행
        $supportType->delete();

        // 삭제 로그 기록
        \Log::info('Support type deleted', [
            'deleted_type' => $typeInfo,
            'admin_id' => $request->user()->id,
            'admin_name' => $request->user()->name,
        ]);

        return redirect()->route('admin.cms.support.types.index')
            ->with('success', '지원 요청 유형이 성공적으로 삭제되었습니다.');
    }
}