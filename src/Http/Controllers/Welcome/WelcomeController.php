<?php
/**
 * Welcome 페이지 컨트롤러
 *
 * @package    Jiny\Site
 * @subpackage Controllers\Welcome
 * @author     Jiny Framework
 * @copyright  Copyright (c) Jiny Framework
 * @license    MIT License
 *
 * @description
 * 사이트의 메인 페이지(홈페이지/웰컴 페이지)를 처리하는 단일 액션 컨트롤러입니다.
 * 방문 로그 기록, 뷰 우선순위 해석, 설정 기반 렌더링 기능을 제공합니다.
 *
 * @route
 * Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class)->name('home');
 *
 * @example
 * // 브라우저에서 접근
 * http://yourdomain.com/
 *
 * @see /vendor/jiny/site/routes/web.php
 * @see /vendor/jiny/site/src/Http/Controllers/Welcome/Welcome.md (상세 문서)
 */

namespace Jiny\Site\Http\Controllers\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Jiny\Site\Services\SiteService;
use Jiny\Site\Models\Banner;
use Jiny\Site\Models\SiteWelcome;
use Jiny\Site\Facades\Header;
use Jiny\Site\Facades\Footer;

/**
 * Class WelcomeController
 *
 * 홈페이지(Welcome 페이지) 표시 컨트롤러
 *
 * @description
 * 단일 액션 컨트롤러(Single Action Controller)로 __invoke() 메서드를 사용합니다.
 * 라우트에서 컨트롤러 클래스를 직접 지정하면 자동으로 __invoke()가 호출됩니다.
 *
 * @workflow
 * Route::get('/')
 *     ↓
 * __construct(SiteService $siteService)
 *     ↓ loadConfig()
 * __invoke(Request $request)
 *     ├─ 1. incrementVisitLog()  ← 방문 로그 기록
 *     ├─ 2. resolveView()        ← 뷰 우선순위 해석
 *     └─ 3. renderView()         ← 뷰 렌더링 및 반환
 *
 * @property SiteService $siteService 사이트 관련 서비스 (의존성 주입)
 * @property array       $config      사이트 설정 배열
 */
class WelcomeController extends Controller
{
    /**
     * 사이트 서비스 인스턴스
     *
     * @var SiteService
     */
    protected $siteService;

    /**
     * 사이트 설정 배열
     *
     * @var array{layout: string, theme: ?string, slot: ?string, log_enabled: bool}
     */
    protected $config;

    /**
     * 생성자 - 의존성 주입 및 설정 초기화
     *
     * @description
     * Laravel의 서비스 컨테이너를 통해 SiteService가 자동으로 주입됩니다.
     * 생성 시점에 설정값을 미리 로드하여 매 요청마다 config()를 호출하는 오버헤드를 줄입니다.
     *
     * @param SiteService $siteService 사이트 관련 서비스 (자동 주입)
     *
     * @return void
     *
     * @workflow
     * Laravel Container → new WelcomeController($siteService)
     *                     → loadConfig()
     */
    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
        $this->loadConfig();
    }

    /**
     * [초기화 단계] 사이트 설정값을 배열로 로드
     *
     * @description
     * config/site.php 파일의 설정값을 읽어 $this->config 배열에 저장합니다.
     * 이후 뷰 해석(resolveView) 및 렌더링(renderView)에서 사용됩니다.
     *
     * @return void
     *
     * @config
     * - site.layout      : 레이아웃 타입 (기본값: 'index')
     * - site.theme       : 테마 이름 (뷰 우선순위 3번에서 사용)
     * - site.slot        : 슬롯 이름 (뷰 우선순위 1번에서 사용)
     * - site.log.enabled : 방문 로그 활성화 여부 (기본값: true)
     *
     * @see config/site.php
     */
    protected function loadConfig()
    {
        $this->config = [
            'layout' => config('site.layout', 'index'),
            'theme' => config('site.theme'),
            'slot' => config('site.slot'),
            'log_enabled' => config('site.log.enabled', true),
        ];
    }

    /**
     * 홈페이지 표시 (메인 진입점) - 단일 액션 메서드
     *
     * @description
     * 라우트에서 컨트롤러 클래스를 직접 지정하면 자동으로 이 메서드가 호출됩니다.
     * 방문 로그 기록 → 뷰 해석 → 렌더링의 3단계 프로세스로 동작합니다.
     *
     * @param Request $request HTTP 요청 객체
     *
     * @return \Illuminate\View\View 렌더링된 뷰 객체
     *
     * @workflow
     * 1단계: incrementVisitLog()  - 방문 로그 기록 (site_log 테이블)
     * 2단계: resolveView()        - 뷰 우선순위에 따라 뷰 경로 결정
     * 3단계: renderView()         - 뷰 렌더링 및 데이터 전달
     *
     * @example
     * // 라우트 정의
     * Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class);
     *
     * @see incrementVisitLog() 방문 로그 기록
     * @see resolveView()       뷰 우선순위 해석
     * @see renderView()        뷰 렌더링
     */
    public function __invoke(Request $request)
    {
        // [1단계] 방문 로그 기록
        // config('site.log.enabled')가 true일 때만 실행
        if ($this->config['log_enabled']) {
            $this->incrementVisitLog();
        }

        // [1.5단계] 베너 데이터 가져오기
        // 활성화되고 유효한 베너들을 가져옴
        $banners = $this->getBanners($request);

        // [1.7단계] 헤더 경로 가져오기
        // headers.json에서 기본 헤더 경로를 읽어옴
        $header = Header::getDefaultHeaderPath();

        // [1.7.5단계] 헤더 메뉴코드 가져오기
        // headers.json에서 기본 헤더의 메뉴코드를 읽어옴
        $headerMenuCode = Header::getDefaultMenuCode();
        //dd($headerMenuCode);

        // [1.8단계] 푸터 경로 가져오기
        // footers.json에서 기본 푸터 경로를 읽어옴
        $footer = Footer::getDefaultFooterPath();

        // [1.9단계] Welcome 블록 데이터 가져오기
        // 데이터베이스에서 활성화된 블록들을 순서대로 가져옴 (미리보기 모드 체크 포함)
        $welcomeBlocks = $this->getWelcomeBlocks($request);

        // [2단계] 뷰 우선순위 해석
        // 설정에 따라 가장 적합한 뷰 경로를 결정
        $viewPath = $this->resolveView();
        //dd($viewPath);

        // [3단계] 뷰 렌더링 및 반환
        // 결정된 뷰에 $config 데이터, 베너 데이터, 헤더 경로, 푸터 경로, 웰컴 블록, 헤더 메뉴코드를 전달하여 렌더링
        return $this->renderView($viewPath, $banners, $header, $footer, $welcomeBlocks, $headerMenuCode);
    }

    /**
     * [1.5단계] 활성화된 베너 데이터 가져오기
     *
     * @description
     * 메인 페이지에 표시할 베너들을 가져옵니다.
     * 쿠키를 확인하여 사용자가 이미 닫은 베너는 제외합니다.
     *
     * @param Request $request HTTP 요청 객체 (쿠키 확인용)
     *
     * @return \Illuminate\Database\Eloquent\Collection 표시할 베너 컬렉션
     *
     * @conditions 베너 표시 조건
     * - enable = true (활성화됨)
     * - 현재 시점이 start_date ~ end_date 범위 내
     * - 사용자가 쿠키로 닫지 않은 베너
     *
     * @workflow
     * 1. 활성화되고 유효한 베너 조회
     * 2. 쿠키로 닫힌 베너 필터링
     * 3. 표시 순서로 정렬하여 반환
     */
    protected function getBanners(Request $request)
    {
        // 활성화되고 현재 유효한 베너들을 가져옴
        $banners = Banner::active()
            ->valid()
            ->ordered()
            ->get();

        // 쿠키로 닫힌 베너들을 필터링
        $visibleBanners = $banners->filter(function ($banner) use ($request) {
            $cookieName = "banner_closed_{$banner->id}";
            return !$request->cookie($cookieName);
        });

        return $visibleBanners;
    }

    /**
     * [1.9단계] Welcome 블록 데이터 가져오기
     *
     * @description
     * 데이터베이스에서 활성화된 블록들을 순서대로 가져옵니다.
     * 미리보기 모드와 스케줄링 기능을 지원합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return array 블록 배열 (order 순으로 정렬)
     *
     * @features
     * - 활성화된 그룹의 블록들 자동 조회
     * - 미리보기 모드 지원 (?preview=group_name)
     * - 스케줄된 그룹 자동 배포
     * - 블록별 활성화/비활성화 필터링
     *
     * @workflow
     * 1. 미리보기 모드 확인
     * 2. 스케줄된 그룹 자동 배포 체크
     * 3. 블록 데이터 조회 (그룹별 또는 활성화된 그룹)
     * 4. 블록 데이터를 배열 형태로 변환
     * 5. 정렬된 블록 배열 반환
     */
    protected function getWelcomeBlocks(Request $request)
    {
        try {
            // 스케줄된 그룹 자동 배포 체크
            SiteWelcome::deployScheduledGroups();

            // 미리보기 모드 체크
            $previewGroup = $request->get('preview');

            if ($previewGroup && $this->isPreviewAllowed($request)) {
                // 미리보기 모드: 지정된 그룹의 블록들
                $blocks = SiteWelcome::getPreviewBlocks($previewGroup);

                // 미리보기 헤더 정보 추가 (개발 모드에서만)
                if (config('app.debug')) {
                    \Log::info("Welcome blocks preview mode: {$previewGroup}");
                }

                // 관리자 미리보기 모드에서는 비활성화된 블록도 표시할지 결정
                // ?preview=default&show_disabled=true 파라미터로 제어 가능
                $showDisabled = $request->get('show_disabled', 'false') === 'true' && auth()->check();

                if (!$showDisabled) {
                    // 일반 미리보기: 활성화된 블록만 표시
                    $blocks = $blocks->filter(function ($block) {
                        return $block->is_enabled;
                    });
                }
            } else {
                // 일반 모드: 현재 활성화된 그룹의 활성화된 블록들만
                $blocks = SiteWelcome::getCurrentBlocks();
            }

            // 모델 데이터를 배열 형태로 변환 (기존 JSON 구조와 호환)
            return $blocks->map(function ($block) {
                return [
                    'id' => $block->id,
                    'name' => $block->block_name,
                    'view' => $block->view_template,
                    'enabled' => $block->is_enabled,
                    'order' => $block->order,
                    'config' => $block->config ?? [],
                    // 추가 메타 정보
                    'group_name' => $block->group_name,
                    'deploy_status' => $block->deploy_status,
                    'is_active' => $block->is_active,
                ];
            })->toArray();

        } catch (\Exception $e) {
            // 데이터베이스 오류 또는 기타 오류 발생 시 빈 배열 반환
            \Log::warning('Failed to load welcome blocks from database: ' . $e->getMessage());

            // 폴백으로 JSON 파일 시도 (마이그레이션 전 호환성)
            return $this->getWelcomeBlocksFromJson();
        }
    }

    /**
     * 미리보기 권한 확인
     *
     * @description
     * 미리보기 기능 사용 권한을 확인합니다.
     * 관리자 권한이 있거나 개발 환경일 때만 허용됩니다.
     *
     * @param Request $request
     * @return bool
     */
    protected function isPreviewAllowed(Request $request): bool
    {
        // 개발 환경에서는 항상 허용
        if (config('app.debug')) {
            return true;
        }

        // 관리자 로그인 체크 (관리자 미들웨어 로직 재사용)
        if (auth()->check()) {
            $user = auth()->user();
            return $user->isAdmin ?? false;
        }

        return false;
    }

    /**
     * JSON 파일에서 블록 데이터 가져오기 (폴백용)
     *
     * @description
     * 데이터베이스 마이그레이션 전 호환성을 위한 폴백 메서드입니다.
     * 기존 Welcome.json 파일이 있으면 해당 데이터를 사용합니다.
     *
     * @return array
     */
    protected function getWelcomeBlocksFromJson(): array
    {
        $configPath = __DIR__ . '/Welcome.json';

        if (!File::exists($configPath)) {
            return [];
        }

        try {
            $content = File::get($configPath);
            $data = json_decode($content, true);

            if (!$data || !isset($data['blocks']) || !is_array($data['blocks'])) {
                return [];
            }

            // 활성화된 블록만 필터링
            $enabledBlocks = array_filter($data['blocks'], function($block) {
                return isset($block['enabled']) && $block['enabled'] === true;
            });

            // order 기준으로 정렬
            usort($enabledBlocks, function($a, $b) {
                $orderA = $a['order'] ?? 0;
                $orderB = $b['order'] ?? 0;
                return $orderA - $orderB;
            });

            return $enabledBlocks;

        } catch (\Exception $e) {
            \Log::warning('Failed to load welcome blocks from JSON fallback: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * [1단계] 방문 로그 기록 및 카운트 증가
     *
     * @description
     * site_log 테이블에 일별 방문 기록을 저장합니다.
     * 해당 날짜의 레코드가 존재하면 cnt를 1 증가시키고,
     * 없으면 새로운 레코드를 생성합니다.
     *
     * @return void
     *
     * @database site_log 테이블 구조
     * - id          : AUTO INCREMENT PRIMARY KEY
     * - year        : VARCHAR(4)  - 방문 연도
     * - month       : VARCHAR(2)  - 방문 월
     * - day         : VARCHAR(2)  - 방문 일
     * - uri         : VARCHAR(255) - 방문 URI (기본: "/")
     * - cnt         : INTEGER     - 방문 횟수
     * - created_at  : DATETIME    - 최초 생성 시각
     * - updated_at  : DATETIME    - 마지막 업데이트 시각
     *
     * @workflow
     * 1. 현재 날짜를 년/월/일로 분리
     * 2. 해당 날짜의 로그 레코드 조회
     * 3-a. 존재하면: cnt를 1 증가, updated_at 갱신
     * 3-b. 없으면: 새 레코드 생성 (cnt=1)
     *
     * @example
     * // 2025-10-08 첫 방문 시
     * INSERT INTO site_log (year='2025', month='10', day='08', cnt=1, ...)
     *
     * // 같은 날 재방문 시
     * UPDATE site_log SET cnt=cnt+1, updated_at=NOW() WHERE year='2025' AND month='10' AND day='08'
     */
    protected function incrementVisitLog()
    {
        // 현재 날짜를 년-월-일로 분리
        $date = explode('-', date("Y-m-d"));

        // 해당 날짜의 로그 레코드 조회
        $log = DB::table('site_log')
            ->where('year', $date[0])    // 년도
            ->where('month', $date[1])   // 월
            ->where('day', $date[2])     // 일
            ->first();

        if ($log) {
            // 레코드가 존재하면 cnt를 1 증가시킴
            DB::table('site_log')
                ->where('year', $date[0])
                ->where('month', $date[1])
                ->where('day', $date[2])
                ->increment('cnt', 1, ['updated_at' => date("Y-m-d H:i:s")]);
        } else {
            // 레코드가 없으면 새로 생성 (cnt=1)
            DB::table('site_log')->insert([
                'year' => $date[0],
                'month' => $date[1],
                'day' => $date[2],
                'uri' => "/",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'cnt' => 1
            ]);
        }
    }

    /**
     * [2단계] 뷰 우선순위 해석 - Welcome 페이지 뷰 결정
     *
     * @description
     * 우선순위에 따라 존재하는 뷰를 순차적으로 검색하여 첫 번째로 발견된 뷰를 반환합니다.
     * 이 시스템을 통해 패키지를 수정하지 않고도 커스텀 뷰를 사용할 수 있습니다.
     *
     * @return string 렌더링할 뷰의 경로
     *
     * ============================================================================
     * 뷰 우선순위 (높은 순서대로)
     * ============================================================================
     *
     * [우선순위 1] Slot 기반 커스텀 뷰 (가장 높은 우선순위)
     * ────────────────────────────────────────────────────────────────
     * 뷰 경로: www::{slot}.index
     * 파일 위치: resources/views/www/{slot}/index.blade.php
     * 설정 방법: config/site.php에서 'slot' => '원하는슬롯명' 설정
     *
     * @example
     * // config/site.php
     * 'slot' => 'main',  // www::main.index 사용
     *
     * // 파일 생성
     * resources/views/www/main/index.blade.php
     *
     * @usecase
     * - 프로젝트별 완전히 독립된 커스텀 디자인
     * - 여러 슬롯을 만들어 동적으로 전환 가능
     * - A/B 테스트, 시즌별 디자인 변경 등
     *
     * ────────────────────────────────────────────────────────────────
     *
     * [우선순위 2] 기본 www 뷰
     * ────────────────────────────────────────────────────────────────
     * 뷰 경로: www::index
     * 파일 위치: resources/views/www/index.blade.php
     * 설정 방법: 파일만 생성하면 자동 인식
     *
     * @example
     * // 파일 생성
     * resources/views/www/index.blade.php
     *
     * @usecase
     * - 가장 간단한 커스터마이징 방법
     * - 프로젝트 전용 기본 홈페이지
     * - slot 설정 없이도 커스텀 뷰 사용
     *
     * ────────────────────────────────────────────────────────────────
     *
     * [우선순위 3] 테마 기반 뷰
     * ────────────────────────────────────────────────────────────────
     * 뷰 경로: theme::{theme}.index
     * 파일 위치: resources/views/theme/{theme}/index.blade.php
     * 설정 방법: config/site.php에서 'theme' => '테마명' 설정
     *
     * @example
     * // config/site.php
     * 'theme' => 'corporate',  // theme::corporate.index 사용
     *
     * // 파일 생성
     * resources/views/theme/corporate/index.blade.php
     *
     * @usecase
     * - 재사용 가능한 테마 시스템
     * - 여러 프로젝트에서 같은 테마 공유
     * - 테마 전환으로 전체 디자인 변경
     *
     * ────────────────────────────────────────────────────────────────
     *
     * [우선순위 4] Laravel 기본 welcome 뷰
     * ────────────────────────────────────────────────────────────────
     * 뷰 경로: welcome
     * 파일 위치: resources/views/welcome.blade.php
     * 설정 방법: Laravel 설치 시 기본 제공
     *
     * @example
     * // Laravel 기본 파일
     * resources/views/welcome.blade.php
     *
     * @usecase
     * - Laravel 기본 환영 페이지 사용
     * - 간단한 랜딩 페이지
     * - 개발 초기 단계 임시 페이지
     *
     * ────────────────────────────────────────────────────────────────
     *
     * [우선순위 5] 패키지 기본 뷰 (최종 폴백)
     * ────────────────────────────────────────────────────────────────
     * 뷰 경로: jiny-site::site.home.index
     * 파일 위치: vendor/jiny/site/resources/views/site/home/index.blade.php
     * 설정 방법: 항상 존재 (패키지 기본 제공)
     *
     * @example
     * // 패키지 내부 파일
     * vendor/jiny/site/resources/views/site/home/index.blade.php
     *
     * @usecase
     * - 위의 모든 뷰가 없을 때 사용되는 안전장치
     * - 패키지 기본 디자인
     *
     * ============================================================================
     *
     * @tip 출력 순서 변경 방법
     * ────────────────────────────────────────────────────────────────
     * 1. 가장 높은 우선순위를 원하면: Slot 방식 사용
     *    → config/site.php에서 'slot' => 'premium' 설정
     *    → resources/views/www/premium/index.blade.php 생성
     *
     * 2. 간단한 커스터마이징: www 방식 사용
     *    → resources/views/www/index.blade.php 생성
     *
     * 3. 테마 시스템 활용: theme 방식 사용
     *    → config/site.php에서 'theme' => 'modern' 설정
     *    → resources/views/theme/modern/index.blade.php 생성
     *
     * @note
     * - 여러 뷰가 동시에 존재하면 우선순위가 높은 것이 사용됩니다
     * - 뷰가 존재하는지 view()->exists()로 확인 후 사용합니다
     * - 모든 뷰가 없으면 패키지 기본 뷰가 반드시 표시됩니다
     */
    protected function resolveView()
    {
        // ====================================================================
        // [우선순위 1] Slot 기반 뷰 (최우선)
        // ====================================================================
        if ($this->config['slot']) {
            $view = "www::" . $this->config['slot'] . ".index";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // ====================================================================
        // [우선순위 2] 기본 www 뷰
        // ====================================================================
        $view = "www::index";
        if (view()->exists($view)) {
            return $view;
        }

        // ====================================================================
        // [우선순위 3] 테마 기반 뷰
        // ====================================================================
        if ($this->config['theme']) {
            $view = "theme::" . $this->config['theme'] . ".index";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // ====================================================================
        // [우선순위 4] Laravel 기본 welcome 뷰
        // ====================================================================
        $view = "welcome";
        if (view()->exists($view)) {
            return $view;
        }

        // ====================================================================
        // [우선순위 5] 패키지 기본 뷰 (최종 폴백)
        // ====================================================================
        // 위의 모든 뷰가 없을 때 사용되는 안전장치
        return "jiny-site::www.welcome.index";
    }

    /**
     * [3단계] 뷰 렌더링 및 데이터 전달
     *
     * @description
     * resolveView()에서 결정된 뷰 경로를 사용하여 실제 뷰를 렌더링합니다.
     * 뷰 파일에서 사용할 수 있도록 설정 데이터, 베너 데이터, 헤더 경로, 푸터 경로, 웰컴 블록, 헤더 메뉴코드를 함께 전달합니다.
     *
     * @param string $viewPath 렌더링할 뷰 경로
     * @param \Illuminate\Database\Eloquent\Collection $banners 표시할 베너 컬렉션
     * @param string $header 기본 헤더 경로
     * @param string $footer 기본 푸터 경로
     * @param array $welcomeBlocks 웰컴 페이지 블록 배열
     * @param string $headerMenuCode 헤더 메뉴코드
     *
     * @return \Illuminate\View\View Laravel 뷰 객체
     *
     * @passed_data 뷰로 전달되는 데이터
     * - $config['layout']      : string  - 레이아웃 타입
     * - $config['theme']       : ?string - 테마 이름
     * - $config['slot']        : ?string - 슬롯 이름
     * - $config['log_enabled'] : bool    - 로그 활성화 여부
     * - $banners              : Collection - 표시할 베너 컬렉션
     * - $header               : string - 기본 헤더 경로 (headers.json에서 읽음)
     * - $footer               : string - 기본 푸터 경로 (footers.json에서 읽음)
     * - $welcomeBlocks        : array - Welcome.json에서 읽은 블록 배열
     * - $headerMenuCode       : string - 헤더에서 사용할 메뉴코드
     *
     * @example 뷰 파일에서 사용 예시
     * // resources/views/www/index.blade.php
     * <!DOCTYPE html>
     * <html>
     * <head>
     *     <title>{{ config('app.name') }}</title>
     * </head>
     * <body>
     *     <!-- 베너 표시 영역 -->
     *     @if($banners->count() > 0)
     *         @foreach($banners as $banner)
     *             <div class="alert alert-{{ $banner->type }} banner-notification"
     *                  data-banner-id="{{ $banner->id }}"
     *                  data-cookie-days="{{ $banner->cookie_days }}"
     *                  @if($banner->style) style="{{ $banner->style }}" @endif>
     *                 <div class="container d-flex align-items-center">
     *                     @if($banner->icon)
     *                         <i class="{{ $banner->icon }} me-2"></i>
     *                     @endif
     *                     <div class="flex-grow-1">
     *                         <strong>{{ $banner->title }}</strong>
     *                         <span class="ms-2">{{ $banner->message }}</span>
     *                         @if($banner->link_url)
     *                             <a href="{{ $banner->link_url }}" class="btn btn-sm btn-outline-light ms-3">
     *                                 {{ $banner->link_text ?: '자세히 보기' }}
     *                             </a>
     *                         @endif
     *                     </div>
     *                     @if($banner->is_closable)
     *                         <button type="button" class="btn-close btn-close-white"
     *                                 onclick="closeBanner({{ $banner->id }}, {{ $banner->cookie_days }})"
     *                                 aria-label="Close"></button>
     *                     @endif
     *                 </div>
     *             </div>
     *         @endforeach
     *     @endif
     *
     *     <div class="layout-{{ $config['layout'] }}">
     *         @if($config['theme'])
     *             <p>현재 테마: {{ $config['theme'] }}</p>
     *         @endif
     *
     *         @if($config['slot'])
     *             <p>현재 슬롯: {{ $config['slot'] }}</p>
     *         @endif
     *
     *         <h1>환영합니다!</h1>
     *     </div>
     *
     *     <script>
     *     function closeBanner(bannerId, cookieDays) {
     *         // 베너를 숨김
     *         const banner = document.querySelector(`[data-banner-id="${bannerId}"]`);
     *         if (banner) {
     *             banner.style.display = 'none';
     *         }
     *
     *         // 쿠키 설정
     *         const expires = new Date();
     *         expires.setDate(expires.getDate() + cookieDays);
     *         document.cookie = `banner_closed_${bannerId}=1; expires=${expires.toUTCString()}; path=/`;
     *     }
     *     </script>
     * </body>
     * </html>
     *
     * @workflow
     * view($viewPath, ['config' => $this->config, 'banners' => $banners, 'header' => $header, 'footer' => $footer])
     *     ↓
     * Laravel View Factory
     *     ↓
     * Blade 템플릿 컴파일
     *     ↓
     * HTML 응답 반환
     *
     * @example 웰컴 블록 사용 예시
     * // resources/views/www/welcome/index.blade.php
     * @if(!empty($welcomeBlocks))
     *     @foreach($welcomeBlocks as $block)
     *         <section class="welcome-block" data-block-id="{{ $block['id'] }}">
     *             @include($block['view'], [
     *                 'blockConfig' => $block['config'] ?? [],
     *                 'blockName' => $block['name']
     *             ])
     *         </section>
     *     @endforeach
     * @endif
     */
    protected function renderView($viewPath, $banners, $header, $footer, $welcomeBlocks = [], $headerMenuCode = 'default')
    {
        // 뷰 경로와 설정 데이터, 베너 데이터, 헤더 경로, 푸터 경로, 웰컴 블록, 헤더 메뉴코드를 함께 전달하여 렌더링
        return view($viewPath, [
            'config' => $this->config,
            'banners' => $banners,
            'header' => $header,
            'footer' => $footer,
            'welcomeBlocks' => $welcomeBlocks,
            'headerMenuCode' => $headerMenuCode,
        ]);
    }
}
