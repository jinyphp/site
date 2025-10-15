<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 삭제 컨트롤러
 */
class DeleteController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $support = SiteSupport::findOrFail($id);

        try {
            // 연관된 파일들 삭제 처리 (필요시)
            // $this->deleteAssociatedFiles($support);

            $support->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '지원 요청이 성공적으로 삭제되었습니다.'
                ]);
            }

            return redirect()
                ->route('admin.cms.support.requests.index')
                ->with('success', '지원 요청이 성공적으로 삭제되었습니다.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '삭제 중 오류가 발생했습니다: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', '삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    private function deleteAssociatedFiles($support)
    {
        // 첨부 파일 삭제 로직
        // if ($support->attachments) {
        //     foreach ($support->attachments as $attachment) {
        //         Storage::delete($attachment->file_path);
        //         $attachment->delete();
        //     }
        // }
    }
}