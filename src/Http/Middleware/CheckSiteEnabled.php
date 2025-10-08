<?php

namespace Jiny\Site\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * 사이트 활성화 확인 미들웨어
 *
 * config('site.enable') 설정에 따라 사이트 접근을 제어합니다.
 */
class CheckSiteEnabled
{
    /**
     * 요청 처리
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 사이트가 비활성화된 경우
        if (!config('site.enable', true)) {
            // 유지보수 모드 확인
            if (config('site.maintenance_mode', false)) {
                // 제외 IP 확인
                $excludeIps = config('site.maintenance_exclude_ips', []);
                if (!in_array($request->ip(), $excludeIps)) {
                    return response()->view('jiny-site::maintenance', [
                        'message' => config('site.maintenance_message', '사이트 유지보수 중입니다.'),
                    ], 503);
                }
            } else {
                return response()->view('jiny-site::disabled', [
                    'message' => '사이트가 일시적으로 비활성화되었습니다.',
                ], 503);
            }
        }

        return $next($request);
    }
}
