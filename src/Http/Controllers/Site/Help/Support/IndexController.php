<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 페이지 컨트롤러 (Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request)
 * ├── GET 요청 시: showForm(Request $request)
 * │   ├── Auth::user() - 현재 사용자 정보 조회
 * │   └── view() - 지원 요청 폼 뷰 반환
 * └── POST 요청 시: handleSubmit(Request $request)
 *     ├── validateRequest(Request $request)
 *     │   └── Validator::make() - 입력 데이터 유효성 검증
 *     ├── createSupportRequest(Request $request)
 *     │   ├── Auth::user() - 사용자 정보 조회
 *     │   ├── 파일 업로드 처리 (첨부파일이 있는 경우)
 *     │   │   └── $file->storeAs() - 파일 저장
 *     │   └── SiteSupport::create() - 지원 요청 데이터베이스 저장
 *     └── redirect() - 성공 페이지로 리다이렉트
 *
 * 진입 경로:
 * Route::get('/help/support') → IndexController::__invoke()
 * Route::post('/help/support') → IndexController::__invoke()
 *
 * 주요 기능:
 * - 지원 요청 폼 표시 (GET)
 * - 지원 요청 데이터 처리 및 저장 (POST)
 * - 파일 첨부 기능 지원
 * - 사용자 인증 상태에 따른 처리
 * - 유효성 검증 및 에러 처리
 *
 * 의존성:
 * - SiteSupport 모델
 * - Laravel Auth 시스템
 * - 파일 저장소 (Storage)
 */
class IndexController extends Controller
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
     * 컨피그 파일(config/site.php)에서 지원 요청 관련 설정을 로드합니다.
     * 기본값이 제공되어 설정이 없어도 동작합니다.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => config('site.support.view', 'jiny-site::www.help.support.index'),
            'success_view' => config('site.support.success_view', 'jiny-site::www.help.support.success'),
            'redirect_after_submit' => config('site.support.redirect_after_submit', '/help/support/success'),
        ];
    }

    /**
     * Single Action Controller 메인 메소드
     *
     * HTTP 메소드에 따라 적절한 처리 메소드로 분기합니다.
     * - GET: 지원 요청 폼 표시
     * - POST: 지원 요청 데이터 처리
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')) {
            return $this->showForm($request);
        }

        return $this->handleSubmit($request);
    }

    /**
     * 지원 요청 폼 표시 (GET 요청 처리)
     *
     * 사용자에게 지원 요청 폼을 보여줍니다.
     * 로그인한 사용자의 경우 일부 정보가 자동으로 채워집니다.
     * 활성화된 지원 유형을 데이터베이스에서 동적으로 로드합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\View\View 지원 요청 폼 뷰
     */
    protected function showForm(Request $request)
    {
        $user = Auth::user();

        // 데이터베이스에서 활성화된 지원 유형 목록 조회
        $supportTypesFromDb = SiteSupportType::where('enable', true)
            ->orderBy('sort_order')
            ->get();

        // 지원 유형 배열 구성 (code => name)
        $supportTypes = [];
        foreach ($supportTypesFromDb as $type) {
            $supportTypes[$type->code] = $type->name;
        }

        // 데이터베이스에 유형이 없는 경우 기본 유형 사용
        if (empty($supportTypes)) {
            $supportTypes = [
                'technical' => '기술 지원',
                'inquiry' => '일반 문의',
                'bug_report' => '버그 신고',
                'feature_request' => '기능 요청',
                'account' => '계정 관련',
                'other' => '기타',
            ];
        }

        return view($this->config['view'], [
            'user' => $user,                     // 현재 로그인한 사용자 정보
            'supportTypes' => $supportTypes,     // 지원 유형 목록 (동적)
            'supportTypesData' => $supportTypesFromDb, // 지원 유형 상세 데이터
            'config' => $this->config,           // 컨트롤러 설정
        ]);
    }

    /**
     * 지원 요청 데이터 처리 (POST 요청 처리)
     *
     * 사용자가 제출한 지원 요청 데이터를 검증하고 저장합니다.
     * 성공 시 성공 페이지로 리다이렉트하고, 실패 시 에러와 함께 폼으로 돌아갑니다.
     *
     * @param Request $request HTTP 요청 객체 (POST 데이터 포함)
     * @return \Illuminate\Http\RedirectResponse 처리 결과에 따른 리다이렉트
     */
    protected function handleSubmit(Request $request)
    {
        // 1단계: 입력 데이터 유효성 검증
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)  // 유효성 검증 에러 메시지
                ->withInput();           // 사용자 입력 데이터 유지
        }

        try {
            // 2단계: 지원 요청 데이터 생성 및 저장
            $support = $this->createSupportRequest($request);

            // 3단계: 성공 페이지로 리다이렉트
            return redirect($this->config['redirect_after_submit'])
                ->with('success', '지원 요청이 성공적으로 접수되었습니다.')
                ->with('support_id', $support->id); // 생성된 지원 요청 ID

        } catch (\Exception $e) {
            // 예외 발생 시 에러 처리
            return back()
                ->with('error', '지원 요청 처리 중 오류가 발생했습니다. 다시 시도해 주세요.')
                ->withInput(); // 사용자 입력 데이터 유지
        }
    }

    /**
     * 지원 요청 데이터 유효성 검증
     *
     * 사용자가 제출한 폼 데이터의 유효성을 검증합니다.
     * Laravel Validator를 사용하여 각 필드별 규칙을 적용합니다.
     * 활성화된 지원 유형에 대해서만 검증을 수행합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return \Illuminate\Validation\Validator 유효성 검증 객체
     */
    protected function validateRequest(Request $request)
    {
        // 데이터베이스에서 활성화된 지원 유형 코드들을 가져옴
        $validTypeCodes = SiteSupportType::where('enable', true)
            ->pluck('code')
            ->toArray();

        // 활성화된 유형이 없으면 기본 유형 사용
        if (empty($validTypeCodes)) {
            $validTypeCodes = ['technical', 'inquiry', 'bug_report', 'feature_request', 'account', 'other'];
        }

        // 유효성 검증 규칙 정의
        $rules = [
            'name' => 'required|string|max:255',                                                    // 이름: 필수, 문자열, 최대 255자
            'email' => 'required|email|max:255',                                                    // 이메일: 필수, 이메일 형식, 최대 255자
            'phone' => 'nullable|string|max:20',                                                    // 전화번호: 선택, 문자열, 최대 20자
            'company' => 'nullable|string|max:255',                                                 // 회사명: 선택, 문자열, 최대 255자
            'type' => 'required|string|in:' . implode(',', $validTypeCodes),                        // 지원 유형: 필수, 활성화된 유형 중 선택
            'subject' => 'required|string|max:255',                                                 // 제목: 필수, 문자열, 최대 255자
            'content' => 'required|string|min:10',                                                  // 내용: 필수, 문자열, 최소 10자
            'priority' => 'nullable|string|in:urgent,high,normal,low',                              // 우선순위: 선택, 정해진 값 중 선택
            'attachments.*' => 'nullable|file|max:10240',                                           // 첨부파일: 선택, 파일, 최대 10MB
        ];

        // 선택된 지원 유형의 필수 필드 동적 추가
        if ($request->has('type') && in_array($request->type, $validTypeCodes)) {
            $supportType = SiteSupportType::where('code', $request->type)->first();
            if ($supportType && $supportType->required_fields) {
                foreach ($supportType->required_fields as $field) {
                    switch ($field) {
                        case 'phone':
                            $rules['phone'] = 'required|string|max:20';
                            break;
                        case 'company':
                            $rules['company'] = 'required|string|max:255';
                            break;
                        case 'department':
                            $rules['department'] = 'required|string|max:255';
                            break;
                        case 'urgency':
                            $rules['urgency'] = 'required|string|in:urgent,high,normal,low';
                            break;
                        case 'attachment':
                            $rules['attachments'] = 'required|array|min:1';
                            break;
                        case 'environment':
                            $rules['environment'] = 'required|string|max:500';
                            break;
                    }
                }
            }
        }

        // 커스텀 에러 메시지 정의 (한글)
        $messages = [
            'name.required' => '이름을 입력해 주세요.',
            'email.required' => '이메일을 입력해 주세요.',
            'email.email' => '올바른 이메일 형식을 입력해 주세요.',
            'type.required' => '지원 유형을 선택해 주세요.',
            'type.in' => '올바른 지원 유형을 선택해 주세요.',
            'subject.required' => '제목을 입력해 주세요.',
            'content.required' => '내용을 입력해 주세요.',
            'content.min' => '내용은 최소 10자 이상 입력해 주세요.',
            'attachments.*.max' => '첨부파일은 10MB 이하로 업로드해 주세요.',
            'phone.required' => '전화번호를 입력해 주세요.',
            'company.required' => '회사명을 입력해 주세요.',
            'department.required' => '부서를 입력해 주세요.',
            'urgency.required' => '긴급도를 선택해 주세요.',
            'attachments.required' => '첨부파일을 업로드해 주세요.',
            'environment.required' => '사용 환경을 입력해 주세요.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * 지원 요청 데이터 생성 및 저장
     *
     * 유효성 검증을 통과한 데이터로 새로운 지원 요청을 생성합니다.
     * 첨부파일이 있는 경우 파일 업로드도 함께 처리합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @return SiteSupport 생성된 지원 요청 모델 인스턴스
     */
    protected function createSupportRequest(Request $request)
    {
        $user = Auth::user();
        $attachments = [];

        // 첨부파일 업로드 처리
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // 고유한 파일명 생성 (타임스탬프 + 원본 파일명)
                $filename = time() . '_' . $file->getClientOriginalName();

                // 파일을 public/support/attachments 디렉토리에 저장
                $path = $file->storeAs('support/attachments', $filename, 'public');

                // 첨부파일 정보 배열에 추가
                $attachments[] = [
                    'original_name' => $file->getClientOriginalName(), // 원본 파일명
                    'filename' => $filename,                           // 저장된 파일명
                    'path' => $path,                                   // 저장 경로
                    'size' => $file->getSize(),                        // 파일 크기
                    'mime_type' => $file->getMimeType(),               // MIME 타입
                ];
            }
        }

        // 지원 요청 데이터 생성 및 데이터베이스 저장
        return SiteSupport::create([
            'enable' => true,                                    // 활성화 상태
            'user_id' => $user ? $user->id : null,              // 사용자 ID (로그인한 경우)
            'name' => $request->name,                            // 신청자 이름
            'email' => $request->email,                          // 신청자 이메일
            'phone' => $request->phone,                          // 신청자 전화번호
            'company' => $request->company,                      // 신청자 회사명
            'type' => $request->type,                            // 지원 유형
            'subject' => $request->subject,                      // 제목
            'content' => $request->content,                      // 내용
            'priority' => $request->priority ?: 'normal',        // 우선순위 (기본값: normal)
            'attachments' => $attachments,                       // 첨부파일 정보 (JSON)
            'status' => 'pending',                               // 초기 상태: 대기중
            'ip_address' => $request->ip(),                      // 요청자 IP 주소
            'user_agent' => $request->userAgent(),               // 요청자 브라우저 정보
            'referrer' => $request->header('referer'),           // 리퍼러 URL
        ]);
    }
}