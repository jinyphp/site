<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('/admin/cms/faq/faqs/{id}') → DestroyController::__invoke()
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_faq',
            'redirect_route' => 'admin.cms.faq.faqs.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        try {
            $deleted = $this->deleteFaq($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'FAQ를 찾을 수 없습니다.'
                    ], 404);
                }

                return redirect()->route($this->config['redirect_route'])
                    ->with('error', 'FAQ를 찾을 수 없습니다.');
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ가 성공적으로 삭제되었습니다.',
                    'id' => $id
                ]);
            }

            return redirect()->route($this->config['redirect_route'])
                ->with('success', 'FAQ가 성공적으로 삭제되었습니다.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'FAQ 삭제 중 오류가 발생했습니다: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route($this->config['redirect_route'])
                ->with('error', 'FAQ 삭제 중 오류가 발생했습니다.');
        }
    }

    protected function deleteFaq($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();
    }
}