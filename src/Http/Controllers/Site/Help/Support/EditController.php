<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 수정 컨트롤러 (Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request, $id)
 * ├── Auth::user() - 현재 사용자 정보 조회
 * ├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
 * ├── SiteSupport::where() - 해당 ID와 사용자 ID로 지원 요청 조회
 * ├── isEditable() - 수정 가능 상태 확인
 * ├── GET 요청 시: showEditForm($support)
 * │   └── view() - 수정 폼 뷰 반환
 * └── POST 요청 시: handleUpdate(Request $request, $support)
 *     ├── validateRequest(Request $request)
 *     │   └── Validator::make() - 입력 데이터 유효성 검증
 *     ├── updateSupport(Request $request, $support)
 *     │   └── $support->update() - 지원 요청 데이터 업데이트
 *     └── redirect() - 내 지원 요청 목록으로 리다이렉트
 *
 * 진입 경로:
 * Route::get('/help/support/{id}/edit') → EditController::__invoke()
 * Route::post('/help/support/{id}/edit') → EditController::__invoke()
 *
 * 주요 기능:
 * - 지원 요청 수정 폼 표시 (GET)
 * - 지원 요청 데이터 수정 처리 (POST)
 * - 수정 권한 확인 (본인 요청 + 수정 가능 상태)
 * - 유효성 검증 및 에러 처리
 *
 * 비즈니스 규칙:
 * - 본인이 작성한 요청만 수정 가능
 * - pending 상태의 요청만 수정 가능
 * - 처리중(in_progress) 이상의 상태는 수정 불가
 *
 * 의존성:
 * - SiteSupport 모델
 * - Laravel Auth 시스템
 * - Laravel Validation
 */
class EditController extends Controller
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
     * 지원 요청 수정과 관련된 설정값들을 로드합니다.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => config('site.support.edit_view', 'jiny-site::www.help.support.edit'), // 수정 폼 뷰 템플릿
        ];
    }

    /**
     * Single Action Controller 메인 메소드 - 지원 요청 수정
     *
     * 지원 요청의 수정 권한을 확인하고, GET 요청 시 수정 폼을, POST 요청 시 수정 처리를 담당합니다.
     * 본인이 작성한 요청이며 수정 가능한 상태(pending)인 경우에만 수정을 허용합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @param int $id 수정할 지원 요청 ID
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        $user = Auth::user();

        // 인증 확인 - 로그인하지 않은 경우 로그인 페이지로 리다이렉트
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        // 지원 요청 조회 - 해당 ID이면서 현재 사용자가 작성한 요청만 조회
        // firstOrFail() 사용으로 해당하는 요청이 없으면 404 예외 발생
        $support = SiteSupport::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // 수정 가능 상태 확인 - pending 상태만 수정 가능
        if (!$support->isEditable()) {
            return redirect()->route('help.support.my')
                ->with('error', '이미 처리 중이거나 완료된 요청은 수정할 수 없습니다.');
        }

        // HTTP 메소드에 따른 처리 분기
        if ($request->isMethod('GET')) {
            return $this->showEditForm($support);    // GET: 수정 폼 표시
        }

        return $this->handleUpdate($request, $support);  // POST: 수정 처리
    }

    /**
     * 수정 폼 표시 (GET 요청 처리)
     *
     * 기존 지원 요청의 데이터를 폼에 채워서 수정 화면을 보여줍니다.
     * 지원 유형 목록과 함께 기존 데이터가 미리 채워진 폼을 제공합니다.
     *
     * @param SiteSupport $support 수정할 지원 요청 객체
     * @return \Illuminate\View\View 수정 폼 뷰
     */
    protected function showEditForm($support)
    {
        // 지원 유형 목록 정의 - 드롭다운 선택 옵션용
        $supportTypes = [
            'technical' => '기술 지원',
            'inquiry' => '일반 문의',
            'bug_report' => '버그 신고',
            'feature_request' => '기능 요청',
            'account' => '계정 관련',
            'other' => '기타',
        ];

        return view($this->config['view'], [
            'support' => $support,               // 수정할 지원 요청 데이터
            'supportTypes' => $supportTypes,     // 지원 유형 선택 옵션
            'config' => $this->config,           // 컨트롤러 설정
        ]);
    }

    /**
     * 지원 요청 수정 데이터 처리 (POST 요청 처리)
     *
     * 사용자가 제출한 수정 데이터를 검증하고 데이터베이스에 반영합니다.
     * 성공 시 내 지원 요청 목록으로 리다이렉트하고, 실패 시 에러와 함께 폼으로 돌아갑니다.
     *
     * @param Request $request HTTP 요청 객체 (POST 데이터 포함)
     * @param SiteSupport $support 수정할 지원 요청 객체
     * @return \Illuminate\Http\RedirectResponse 처리 결과에 따른 리다이렉트
     */
    protected function handleUpdate(Request $request, $support)
    {
        // 1단계: 입력 데이터 유효성 검증
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)  // 유효성 검증 에러 메시지
                ->withInput();           // 사용자 입력 데이터 유지
        }

        try {
            // 2단계: 지원 요청 데이터 업데이트
            $this->updateSupport($request, $support);

            // 3단계: 성공 시 내 지원 요청 목록으로 리다이렉트
            return redirect()->route('help.support.my')
                ->with('success', '지원 요청이 성공적으로 수정되었습니다.');

        } catch (\Exception $e) {
            // 예외 발생 시 에러 처리
            return back()
                ->with('error', '수정 중 오류가 발생했습니다. 다시 시도해 주세요.')
                ->withInput(); // 사용자 입력 데이터 유지
        }
    }

    /**
     * 지원 요청 수정 데이터 유효성 검증
     *
     * 사용자가 제출한 수정 폼 데이터의 유효성을 검증합니다.
     * 새로운 지원 요청과 동일한 검증 규칙을 적용하지만, 첨부파일은 제외됩니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\Validation\Validator 유효성 검증 객체
     */
    protected function validateRequest(Request $request)
    {
        // 유효성 검증 규칙 정의 (수정 시에는 첨부파일 제외)
        $rules = [
            'name' => 'required|string|max:255',                                                    // 이름: 필수, 문자열, 최대 255자
            'email' => 'required|email|max:255',                                                    // 이메일: 필수, 이메일 형식, 최대 255자
            'phone' => 'nullable|string|max:20',                                                    // 전화번호: 선택, 문자열, 최대 20자
            'company' => 'nullable|string|max:255',                                                 // 회사명: 선택, 문자열, 최대 255자
            'type' => 'required|string|in:technical,inquiry,bug_report,feature_request,account,other', // 지원 유형: 필수, 정해진 값 중 선택
            'subject' => 'required|string|max:255',                                                 // 제목: 필수, 문자열, 최대 255자
            'content' => 'required|string|min:10',                                                  // 내용: 필수, 문자열, 최소 10자
            'priority' => 'nullable|string|in:urgent,high,normal,low',                              // 우선순위: 선택, 정해진 값 중 선택
        ];

        // 커스텀 에러 메시지 정의 (한글)
        $messages = [
            'name.required' => '이름을 입력해 주세요.',
            'email.required' => '이메일을 입력해 주세요.',
            'email.email' => '올바른 이메일 형식을 입력해 주세요.',
            'type.required' => '지원 유형을 선택해 주세요.',
            'subject.required' => '제목을 입력해 주세요.',
            'content.required' => '내용을 입력해 주세요.',
            'content.min' => '내용은 최소 10자 이상 입력해 주세요.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * 지원 요청 데이터 업데이트 실행
     *
     * 유효성 검증을 통과한 데이터로 기존 지원 요청을 업데이트합니다.
     * 첨부파일과 상태는 수정하지 않고, 기본 정보만 업데이트합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @param SiteSupport $support 업데이트할 지원 요청 객체
     * @return SiteSupport 업데이트된 지원 요청 객체
     */
    protected function updateSupport(Request $request, $support)
    {
        // 지원 요청 기본 정보 업데이트
        $support->update([
            'name' => $request->name,                            // 신청자 이름
            'email' => $request->email,                          // 신청자 이메일
            'phone' => $request->phone,                          // 신청자 전화번호
            'company' => $request->company,                      // 신청자 회사명
            'type' => $request->type,                            // 지원 유형
            'subject' => $request->subject,                      // 제목
            'content' => $request->content,                      // 내용
            'priority' => $request->priority ?: 'normal',        // 우선순위 (기본값: normal)
        ]);

        // 업데이트된 객체 반환
        return $support;
    }
}