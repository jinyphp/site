<?php

namespace Jiny\Site\Http\Controllers\Site\Terms;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\TermsService;

/**
 * 약관 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/terms/{any?}') → ShowController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. parseTermsType() - 약관 타입 파싱
 *     ├─ 3. loadTermsData() - 약관 데이터 로드
 *     └─ 4. renderView() - 뷰 렌더링
 */
class ShowController extends Controller
{
    protected $termsService;
    protected $config;

    /**
     * 생성자
     *
     * @param TermsService $termsService
     */
    public function __construct(TermsService $termsService)
    {
        $this->termsService = $termsService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'default_view' => config('site.terms.default_view', 'jiny-site::site.terms.show'),
            'enabled' => config('site.terms.enabled', true),
        ];
    }

    /**
     * 약관 표시 (메인 진입점)
     *
     * @param Request $request
     * @param string|null $any
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $any = null)
    {
        // 약관 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: 약관 타입 파싱
        $type = $this->parseTermsType($any);

        // 2단계: 약관 데이터 로드
        $termsData = $this->loadTermsData($type);

        // 3단계: 뷰 렌더링
        return $this->renderView($termsData);
    }

    /**
     * [1단계] 약관 타입 파싱
     *
     * @param string|null $any
     * @return string
     */
    protected function parseTermsType($any)
    {
        // 기본값: 이용약관
        if (empty($any)) {
            return 'use';
        }

        // URL에서 약관 타입 추출
        $parts = explode('/', $any);
        return $parts[0] ?? 'use';
    }

    /**
     * [2단계] 약관 데이터 로드
     *
     * @param string $type
     * @return array
     */
    protected function loadTermsData($type)
    {
        return $this->termsService->getTermsByType($type);
    }

    /**
     * [3단계] 뷰 렌더링
     *
     * @param array $termsData
     * @return \Illuminate\View\View
     */
    protected function renderView($termsData)
    {
        return view($this->config['default_view'], [
            'terms' => $termsData,
            'config' => $this->config,
        ]);
    }
}
