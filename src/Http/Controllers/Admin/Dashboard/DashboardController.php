<?php
/**
 * CMS Dashboard 컨트롤러
 *
 * @package    Jiny\Site
 * @subpackage Controllers\Admin\Dashboard
 * @author     Jiny Framework
 * @copyright  Copyright (c) Jiny Framework
 * @license    MIT License
 *
 * @description
 * CMS 관리 대시보드를 표시하는 단일 액션 컨트롤러입니다.
 * 게시판, 마케팅, 고객지원, 분석 등 CMS 관련 메뉴와 통계를 제공합니다.
 *
 * @route
 * Route::get('/admin/cms', \Jiny\Site\Http\Controllers\Admin\Dashboard\DashboardController::class)
 *     ->name('admin.cms.dashboard');
 *
 * @layout
 * jiny-site::layouts.admin.sidebar
 *
 * @view
 * jiny-site::admin.dashboard.cms
 */

namespace Jiny\Site\Http\Controllers\Admin\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * CMS 관리 대시보드 표시 컨트롤러
 *
 * @description
 * 단일 액션 컨트롤러(Single Action Controller)로 __invoke() 메서드를 사용합니다.
 * CMS 관련 주요 기능들의 대시보드를 표시합니다.
 *
 * @workflow
 * Route::get('/admin/cms')
 *     ↓
 * __construct()
 *     ↓ loadConfig()
 * __invoke(Request $request)
 *     ├─ 1. loadDashboardData()  ← 대시보드 데이터 로드
 *     └─ 2. renderView()         ← 뷰 렌더링 및 반환
 *
 * @features
 * - 게시판 관리
 * - 마케팅 (슬라이더, 배너, 이벤트)
 * - 고객지원 (Contact, Help, FAQ)
 * - 분석 (SEO, 로그)
 */
class DashboardController extends Controller
{
    /**
     * 사이트 설정 배열
     *
     * @var array{layout: string, view: string, title: string}
     */
    protected $config;

    /**
     * 생성자 - 설정 초기화
     *
     * @description
     * 컨트롤러 생성 시 CMS 대시보드 관련 설정을 로드합니다.
     *
     * @return void
     *
     * @workflow
     * Laravel Container → new DashboardController()
     *                     → loadConfig()
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * [초기화 단계] CMS 대시보드 설정값 로드
     *
     * @description
     * CMS 대시보드 표시에 필요한 설정값을 로드합니다.
     *
     * @return void
     *
     * @config
     * - layout : 사용할 레이아웃 뷰 경로
     * - view   : 사용할 콘텐츠 뷰 경로
     * - title  : 페이지 타이틀
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => 'jiny-site::admin.dashboard.cms_index',
            'title' => 'CMS 대시보드',
        ];
    }

    /**
     * CMS 대시보드 표시 (메인 진입점) - 단일 액션 메서드
     *
     * @description
     * CMS 관리를 위한 대시보드 페이지를 렌더링합니다.
     * 게시판, 마케팅, 고객지원, 분석 섹션을 포함합니다.
     *
     * @param Request $request HTTP 요청 객체
     *
     * @return \Illuminate\View\View 렌더링된 뷰 객체
     *
     * @workflow
     * 1단계: loadDashboardData() - CMS 대시보드 데이터 로드
     * 2단계: renderView()        - 레이아웃과 함께 뷰 렌더링
     *
     * @sections CMS 대시보드 섹션
     * 1. 게시판 관리
     *    - 게시판 목록 및 게시글 수
     *
     * 2. 마케팅
     *    - 슬라이더 관리
     *    - 배너 관리
     *    - 이벤트 관리
     *
     * 3. 알람 및 메시징
     *    - Notification 관리
     *    - 구독 관리
     *
     * 4. 고객지원
     *    - Contact 관리
     *    - Help 관리
     *    - FAQ 관리
     *
     * 5. 분석
     *    - SEO 분석
     *    - 로그 분석
     *
     * @see loadDashboardData() 대시보드 데이터 로드
     * @see renderView()        뷰 렌더링
     */
    public function __invoke(Request $request)
    {
        // [1단계] CMS 대시보드 데이터 로드
        $data = $this->loadDashboardData();

        // [2단계] 뷰 렌더링 및 반환
        return $this->renderView($data);
    }

    /**
     * [1단계] CMS 대시보드 데이터 로드
     *
     * @description
     * CMS 대시보드에 표시할 데이터를 준비합니다.
     * 현재는 기본 설정만 반환하지만, 필요시 통계 데이터를 추가할 수 있습니다.
     *
     * @return array 대시보드 데이터 배열
     *
     * @example 확장 예시
     * return [
     *     'config' => $this->config,
     *     'board_count' => DB::table('site_board')->count(),
     *     'post_count' => DB::table('site_posts')->count(),
     *     'recent_posts' => DB::table('site_posts')->latest()->take(5)->get(),
     * ];
     *
     * @future_enhancement
     * - 게시판 통계 추가
     * - 최근 활동 로그 추가
     * - 알람 및 메시지 통계 추가
     * - SEO 스코어 추가
     */
    protected function loadDashboardData()
    {
        return [
            'config' => $this->config,
        ];
    }

    /**
     * [2단계] 뷰 렌더링 및 데이터 전달
     *
     * @description
     * sidebar 레이아웃을 사용하여 CMS 대시보드 뷰를 렌더링합니다.
     * jiny-site:: 리소스 힌트를 사용합니다.
     *
     * @param array $data 뷰로 전달할 데이터
     *
     * @return \Illuminate\View\View Laravel 뷰 객체
     *
     * @layout_structure
     * jiny-site::layouts.admin.sidebar
     *     ├─ @yield('title')   : CMS 대시보드
     *     └─ @yield('content') : jiny-site::admin.dashboard.cms
     *
     * @passed_data 뷰로 전달되는 데이터
     * - $config['layout'] : string - 레이아웃 뷰 경로
     * - $config['view']   : string - 콘텐츠 뷰 경로
     * - $config['title']  : string - 페이지 타이틀
     *
     * @example 뷰 파일에서 사용 예시
     * // resources/views/admin/dashboard/cms.blade.php
     * <div class="row">
     *     <div class="col-12">
     *         <h1>{{ $config['title'] }}</h1>
     *     </div>
     * </div>
     *
     * @note
     * - 리소스 힌트 'jiny-site::'는 vendor/jiny/site/resources/views를 가리킵니다
     * - sidebar.blade.php는 관리자 사이드바 레이아웃을 제공합니다
     * - cms.blade.php는 CMS 대시보드 콘텐츠를 포함합니다
     */
    protected function renderView($data)
    {
        // cms_index.blade.php 뷰 렌더링 (레이아웃 상속 포함)
        return view($this->config['view'], $data);
    }
}
