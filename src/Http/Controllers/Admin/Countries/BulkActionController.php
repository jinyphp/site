<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;
use Illuminate\Support\Facades\DB;

/**
 * 국가 일괄 작업 컨트롤러
 */
class BulkActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,enable,disable',
            'ids' => 'required|array',
            'ids.*' => 'exists:site_country,id'
        ]);

        $action = $request->get('action');
        $ids = $request->get('ids');

        try {
            $result = DB::transaction(function () use ($action, $ids) {
                return $this->executeAction($action, $ids);
            });

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data'] ?? null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '일괄 작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 일괄 작업 실행
     *
     * @param string $action
     * @param array $ids
     * @return array
     */
    private function executeAction($action, $ids)
    {
        $countrys = SiteCountry::whereIn('id', $ids)->get();
        $count = $countrys->count();

        switch ($action) {
            case 'delete':
                return $this->bulkDelete($countrys);

            case 'enable':
                return $this->bulkEnable($countrys);

            case 'disable':
                return $this->bulkDisable($countrys);

            default:
                throw new \InvalidArgumentException('지원하지 않는 작업입니다.');
        }
    }

    /**
     * 일괄 삭제
     *
     * @param $countrys
     * @return array
     */
    private function bulkDelete($countrys)
    {
        $count = $countrys->count();

        // 기본 국가는 삭제할 수 없음
        $defaultLanguages = $countrys->where('is_default', true);
        if ($defaultLanguages->isNotEmpty()) {
            throw new \Exception('기본 국가는 삭제할 수 없습니다.');
        }

        // 활성화된 국가가 모두 삭제되는지 확인
        $activeLanguages = SiteCountry::where('enable', true)->count();
        $deletingActiveCount = $countrys->where('enable', true)->count();

        if ($activeLanguages <= $deletingActiveCount) {
            throw new \Exception('최소 하나의 활성화된 국가가 있어야 합니다.');
        }

        SiteCountry::whereIn('id', $countrys->pluck('id'))->delete();

        return [
            'message' => "{$count}개의 국가가 삭제되었습니다.",
            'data' => ['deleted_count' => $count]
        ];
    }

    /**
     * 일괄 활성화
     *
     * @param $countrys
     * @return array
     */
    private function bulkEnable($countrys)
    {
        $count = $countrys->count();

        SiteCountry::whereIn('id', $countrys->pluck('id'))
            ->update(['enable' => true]);

        return [
            'message' => "{$count}개의 국가가 활성화되었습니다.",
            'data' => ['enabled_count' => $count]
        ];
    }

    /**
     * 일괄 비활성화
     *
     * @param $countrys
     * @return array
     */
    private function bulkDisable($countrys)
    {
        $count = $countrys->count();

        // 기본 국가는 비활성화할 수 없음
        $defaultLanguages = $countrys->where('is_default', true);
        if ($defaultLanguages->isNotEmpty()) {
            throw new \Exception('기본 국가는 비활성화할 수 없습니다.');
        }

        // 모든 활성화된 국가가 비활성화되는지 확인
        $activeLanguages = SiteCountry::where('enable', true)->count();
        $disablingCount = $countrys->where('enable', true)->count();

        if ($activeLanguages <= $disablingCount) {
            throw new \Exception('최소 하나의 활성화된 국가가 있어야 합니다.');
        }

        SiteCountry::whereIn('id', $countrys->pluck('id'))
            ->update(['enable' => false]);

        return [
            'message' => "{$count}개의 국가가 비활성화되었습니다.",
            'data' => ['disabled_count' => $count]
        ];
    }
}