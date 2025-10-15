<?php

namespace Jiny\Site\Observers;

use Jiny\Site\Models\SiteSupport;

/**
 * 기술지원 요청 Observer
 */
class SiteSupportObserver
{
    /**
     * 새로운 지원 요청이 생성된 후 호출
     */
    public function created(SiteSupport $support)
    {
        // 자동 할당 시도
        if ($support->enable && !$support->assigned_to) {
            $this->attemptAutoAssignment($support);
        }
    }

    /**
     * 자동 할당 시도
     */
    private function attemptAutoAssignment(SiteSupport $support)
    {
        try {
            $support->autoAssign();
        } catch (\Exception $e) {
            // 자동 할당 실패 시 로그 기록 (선택사항)
            \Log::warning('Auto assignment failed for support request', [
                'support_id' => $support->id,
                'type' => $support->type,
                'priority' => $support->priority,
                'error' => $e->getMessage()
            ]);
        }
    }
}