<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 지원 요청 성공 페이지 컨트롤러 (Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request)
 * ├── session('support_id') - 세션에서 지원 요청 ID 조회
 * ├── session('success') - 세션에서 성공 메시지 조회
 * └── view() - 성공 페이지 뷰 반환
 *
 * 진입 경로:
 * Route::get('/help/support/success') → SuccessController::__invoke()
 * (일반적으로 IndexController에서 지원 요청 제출 후 리다이렉트됨)
 *
 * 주요 기능:
 * - 지원 요청 제출 성공 페이지 표시
 * - 제출된 지원 요청 ID 및 성공 메시지 표시
 * - 세션 기반 데이터 전달 (일회성)
 *
 * 데이터 소스:
 * - support_id: IndexController에서 set한 세션 데이터
 * - success: IndexController에서 set한 성공 메시지
 *
 * 의존성:
 * - Laravel Session 시스템
 */
class SuccessController extends Controller
{
    protected $config;

    /**
     * 생성자 - 설정 로드
     *
     * @return void
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * 컨트롤러 설정 로드
     *
     * 성공 페이지와 관련된 설정값들을 로드합니다.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => config('site.support.success_view', 'jiny-site::www.help.support.success'), // 성공 페이지 뷰 템플릿
        ];
    }

    /**
     * Single Action Controller 메인 메소드 - 지원 요청 성공 페이지 표시
     *
     * 지원 요청 제출 후 성공 페이지를 표시합니다.
     * 세션에 저장된 지원 요청 ID와 성공 메시지를 가져와서 사용자에게 보여줍니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\View\View 성공 페이지 뷰
     */
    public function __invoke(Request $request)
    {
        // 세션에서 지원 요청 ID 조회 (IndexController에서 설정한 값)
        $supportId = session('support_id');

        // 세션에서 성공 메시지 조회 (기본 메시지 제공)
        $message = session('success', '지원 요청이 성공적으로 접수되었습니다.');

        // 성공 페이지 뷰 렌더링
        return view($this->config['view'], [
            'supportId' => $supportId,    // 제출된 지원 요청 ID
            'message' => $message,        // 성공 메시지
            'config' => $this->config,    // 컨트롤러 설정
        ]);
    }
}