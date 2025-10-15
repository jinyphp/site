<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 통계 컨트롤러 (Admin - Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request)
 * ├── SiteSupport::count() - 전체 지원 요청 수 조회
 * ├── SiteSupport::where('status', 'pending')->count() - 대기중 요청 수
 * ├── SiteSupport::where('status', 'in_progress')->count() - 처리중 요청 수
 * ├── SiteSupport::where('status', 'resolved')->count() - 해결됨 요청 수
 * ├── SiteSupport::where('status', 'closed')->count() - 종료됨 요청 수
 * └── view() - 통계 페이지 뷰 반환
 *
 * 진입 경로:
 * Route::get('/admin/support/statistics') → StatisticsController::__invoke()
 *
 * 주요 기능:
 * - 지원 요청 상태별 통계 정보 제공
 * - 관리자 대시보드용 데이터 집계
 *
 * 권한:
 * - admin 미들웨어 적용 (관리자만 접근 가능)
 *
 * 의존성:
 * - SiteSupport 모델
 * - Admin 미들웨어
 */
class StatisticsController extends Controller
{
    /**
     * 생성자
     *
     * Single Action Controller이므로 미들웨어는 라우트에서 적용됩니다.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * Single Action Controller 메인 메소드 - 지원 요청 통계 조회
     *
     * 지원 요청의 상태별 통계 정보를 집계하여 관리자 페이지에 표시합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\View\View 통계 페이지 뷰
     */
    public function __invoke(Request $request)
    {
        // 상태별 지원 요청 통계 집계
        $statistics = [
            'total' => SiteSupport::count(),                                           // 전체 요청 수
            'pending' => SiteSupport::where('status', 'pending')->count(),            // 대기중 요청 수
            'in_progress' => SiteSupport::where('status', 'in_progress')->count(),    // 처리중 요청 수
            'resolved' => SiteSupport::where('status', 'resolved')->count(),          // 해결됨 요청 수
            'closed' => SiteSupport::where('status', 'closed')->count(),              // 종료됨 요청 수
        ];

        // 관리자 통계 페이지 뷰 반환
        return view('jiny-site::admin.support.statistics', [
            'statistics' => $statistics,
        ]);
    }
}