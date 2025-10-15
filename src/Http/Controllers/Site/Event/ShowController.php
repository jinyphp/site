<?php

namespace Jiny\Site\Http\Controllers\Site\Event;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 사이트 이벤트 상세보기 컨트롤러
 *
 * 일반 사용자가 볼 수 있는 이벤트 상세 정보를 표시합니다.
 * ID 또는 slug(code)로 접근 가능합니다.
 */
class ShowController extends Controller
{
    /**
     * 이벤트 상세보기
     *
     * @param Request $request
     * @param string $identifier ID 또는 slug(code)
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $identifier)
    {
        // ID인지 slug인지 판단하여 이벤트 조회
        $event = $this->findEvent($identifier);

        // 이벤트가 없거나 비활성화된 경우 404
        if (!$event || !$event->enable) {
            abort(404, '이벤트를 찾을 수 없습니다.');
        }

        // 조회수 증가 (중복 방지를 위해 IP 전달)
        $event->incrementViewCount($request->ip());

        // 관련 이벤트 조회 (같은 상태의 다른 이벤트)
        $relatedEvents = SiteEvent::active()
            ->where('enable', true)
            ->where('status', $event->status)
            ->where('id', '!=', $event->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // 이전/다음 이벤트
        $prevEvent = SiteEvent::active()
            ->where('enable', true)
            ->where('created_at', '<', $event->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        $nextEvent = SiteEvent::active()
            ->where('enable', true)
            ->where('created_at', '>', $event->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        return view('jiny-site::site.event.show', [
            'event' => $event,
            'relatedEvents' => $relatedEvents,
            'prevEvent' => $prevEvent,
            'nextEvent' => $nextEvent,
        ]);
    }

    /**
     * ID 또는 slug로 이벤트 찾기
     *
     * @param string $identifier
     * @return SiteEvent|null
     */
    protected function findEvent($identifier)
    {
        // 숫자인 경우 ID로 조회
        if (is_numeric($identifier)) {
            return SiteEvent::active()
                ->where('enable', true)
                ->find($identifier);
        }

        // 문자열인 경우 code(slug)로 조회
        return SiteEvent::active()
            ->where('enable', true)
            ->where('code', $identifier)
            ->first();
    }

    /**
     * 이벤트의 올바른 URL 생성
     *
     * @param SiteEvent $event
     * @return string
     */
    public static function getEventUrl(SiteEvent $event)
    {
        // code가 있으면 slug 사용, 없으면 ID 사용
        if ($event->code) {
            return route('event.show', $event->code);
        }

        return route('event.show', $event->id);
    }
}