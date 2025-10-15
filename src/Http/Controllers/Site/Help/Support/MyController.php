<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;

/**
 * 내 지원 요청 목록 컨트롤러 (Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request)
 * ├── Auth::user() - 현재 사용자 정보 조회
 * ├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
 * ├── SiteSupport 쿼리 빌더 생성
 * │   ├── where('user_id', $user->id) - 사용자별 필터링
 * │   └── orderBy('created_at', 'desc') - 최신순 정렬
 * ├── 요청 파라미터에 따른 필터링
 * │   ├── status 필터 (요청 시)
 * │   ├── type 필터 (요청 시)
 * │   └── search() - 검색 기능 (요청 시)
 * ├── paginate() - 페이지네이션 적용
 * ├── 상태별 카운트 조회
 * │   ├── all - 전체 요청 수
 * │   ├── pending - 대기중 요청 수
 * │   ├── in_progress - 처리중 요청 수
 * │   ├── resolved - 해결됨 요청 수
 * │   └── closed - 종료됨 요청 수
 * └── view() - 목록 뷰 반환
 *
 * 진입 경로:
 * Route::get('/help/support/my') → MyController::__invoke()
 *
 * 주요 기능:
 * - 로그인한 사용자의 지원 요청 목록 표시
 * - 상태별, 유형별 필터링
 * - 키워드 검색 기능
 * - 페이지네이션
 * - 상태별 통계 정보 제공
 *
 * 의존성:
 * - SiteSupport 모델
 * - Laravel Auth 시스템
 * - Laravel Pagination
 */
class MyController extends Controller
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
     * 내 지원 요청 목록과 관련된 설정값들을 로드합니다.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => config('site.support.my_view', 'jiny-site::www.help.support.my'), // 목록 뷰 템플릿
            'per_page' => config('site.support.per_page', 10),                          // 페이지당 표시할 항목 수
        ];
    }

    /**
     * Single Action Controller 메인 메소드 - 내 지원 요청 목록 표시
     *
     * 로그인한 사용자의 지원 요청 목록을 조회하고 필터링/검색 기능을 제공합니다.
     * 상태별 통계 정보와 함께 페이지네이션된 목록을 반환합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // 인증 확인 - 로그인하지 않은 경우 로그인 페이지로 리다이렉트
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        // 기본 쿼리 - 현재 사용자의 지원 요청만 조회, 최신순 정렬
        $query = SiteSupport::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // 상태 필터 적용 (pending, in_progress, resolved, closed)
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // 지원 유형 필터 적용 (technical, inquiry, bug_report, etc.)
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // 키워드 검색 적용 (제목, 내용에서 검색)
        if ($request->has('search') && $request->search) {
            $query->search($request->search); // SiteSupport 모델의 search 스코프 사용
        }

        // 페이지네이션 적용하여 결과 조회
        $supports = $query->paginate($this->config['per_page']);

        // 상태별 통계 정보 생성 - 사용자별 필터 탭 표시용
        $statusCounts = [
            'all' => SiteSupport::where('user_id', $user->id)->count(),                                    // 전체
            'pending' => SiteSupport::where('user_id', $user->id)->where('status', 'pending')->count(),        // 대기중
            'in_progress' => SiteSupport::where('user_id', $user->id)->where('status', 'in_progress')->count(), // 처리중
            'resolved' => SiteSupport::where('user_id', $user->id)->where('status', 'resolved')->count(),       // 해결됨
            'closed' => SiteSupport::where('user_id', $user->id)->where('status', 'closed')->count(),           // 종료됨
        ];

        // 뷰에 데이터 전달하여 렌더링
        return view($this->config['view'], [
            'supports' => $supports,                   // 페이지네이션된 지원 요청 목록
            'statusCounts' => $statusCounts,           // 상태별 통계
            'currentStatus' => $request->status,       // 현재 선택된 상태 필터
            'currentType' => $request->type,           // 현재 선택된 유형 필터
            'searchKeyword' => $request->search,       // 현재 검색 키워드
            'config' => $this->config,                 // 컨트롤러 설정
        ]);
    }
}