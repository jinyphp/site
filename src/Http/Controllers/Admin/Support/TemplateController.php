<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 지원 요청 템플릿 관리 컨트롤러
 */
class TemplateController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 템플릿 목록 조회
     */
    public function index(Request $request)
    {
        $templates = $this->getTemplates();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'templates' => $templates
            ]);
        }

        return view('jiny-site::admin.support.templates.index', [
            'templates' => $templates
        ]);
    }

    /**
     * 특정 템플릿 조회
     */
    public function show(Request $request, $templateKey)
    {
        $templates = $this->getTemplates();

        if (!isset($templates[$templateKey])) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => '템플릿을 찾을 수 없습니다.'], 404);
            }
            abort(404);
        }

        $template = $templates[$templateKey];

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'template' => $template
            ]);
        }

        return response($template['content'], 200, [
            'Content-Type' => 'text/plain; charset=utf-8'
        ]);
    }

    /**
     * 템플릿 내용 처리 (변수 치환)
     */
    public function process(Request $request)
    {
        $request->validate([
            'template_key' => 'required|string',
            'variables' => 'array'
        ]);

        $templates = $this->getTemplates();
        $templateKey = $request->template_key;

        if (!isset($templates[$templateKey])) {
            return response()->json(['success' => false, 'message' => '템플릿을 찾을 수 없습니다.'], 404);
        }

        $template = $templates[$templateKey];
        $content = $template['content'];
        $variables = $request->variables ?? [];

        // 기본 변수들
        $defaultVariables = [
            '{{customer_name}}' => $variables['customer_name'] ?? '고객님',
            '{{support_id}}' => $variables['support_id'] ?? '#{지원요청번호}',
            '{{subject}}' => $variables['subject'] ?? '{제목}',
            '{{date}}' => now()->format('Y년 m월 d일'),
            '{{time}}' => now()->format('H:i'),
            '{{company_name}}' => config('app.name', 'Jiny Site'),
            '{{support_email}}' => config('mail.support_email', 'support@example.com'),
            '{{website_url}}' => config('app.url'),
        ];

        // 추가 변수들과 병합
        $allVariables = array_merge($defaultVariables, $variables);

        // 변수 치환
        $processedContent = str_replace(
            array_keys($allVariables),
            array_values($allVariables),
            $content
        );

        return response()->json([
            'success' => true,
            'processed_content' => $processedContent,
            'original_content' => $content,
            'variables_used' => $allVariables
        ]);
    }

    /**
     * 미리보기 생성
     */
    public function preview(Request $request, $templateKey)
    {
        $templates = $this->getTemplates();

        if (!isset($templates[$templateKey])) {
            return response()->json(['success' => false, 'message' => '템플릿을 찾을 수 없습니다.'], 404);
        }

        $template = $templates[$templateKey];

        // 샘플 데이터로 미리보기 생성
        $sampleVariables = [
            '{{customer_name}}' => '홍길동',
            '{{support_id}}' => '#12345',
            '{{subject}}' => '로그인 문제 해결 요청',
            '{{date}}' => now()->format('Y년 m월 d일'),
            '{{time}}' => now()->format('H:i'),
            '{{company_name}}' => config('app.name', 'Jiny Site'),
            '{{support_email}}' => 'support@example.com',
            '{{website_url}}' => config('app.url'),
        ];

        $previewContent = str_replace(
            array_keys($sampleVariables),
            array_values($sampleVariables),
            $template['content']
        );

        return response()->json([
            'success' => true,
            'preview_content' => $previewContent,
            'template_info' => [
                'key' => $templateKey,
                'title' => $template['title'],
                'description' => $template['description'] ?? '',
                'category' => $template['category'] ?? 'general'
            ]
        ]);
    }

    /**
     * 템플릿 검색
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');

        $templates = $this->getTemplates();
        $results = [];

        foreach ($templates as $key => $template) {
            $matchesQuery = empty($query) ||
                           str_contains(strtolower($template['title']), strtolower($query)) ||
                           str_contains(strtolower($template['content']), strtolower($query));

            $matchesCategory = empty($category) ||
                              ($template['category'] ?? 'general') === $category;

            if ($matchesQuery && $matchesCategory) {
                $results[$key] = $template;
            }
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'total_count' => count($results),
            'query' => $query,
            'category' => $category
        ]);
    }

    /**
     * 템플릿 목록 정의
     */
    private function getTemplates()
    {
        return [
            'resolved' => [
                'title' => '해결완료 알림',
                'category' => 'status',
                'description' => '지원 요청이 해결되었을 때 사용하는 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n문의해 주신 내용에 대해 검토를 완료하였습니다.\n\n[해결 방법 또는 답변 내용을 여기에 입력하세요]\n\n문제가 해결되었는지 확인 부탁드리며, 추가 문의사항이 있으시면 언제든지 연락 주시기 바랍니다.\n\n감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ],

            'investigating' => [
                'title' => '조사중 알림',
                'category' => 'status',
                'description' => '문제를 조사 중일 때 사용하는 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n{{subject}} 건에 대해 문의해 주신 내용을 확인하였습니다.\n\n현재 관련 부서에서 해당 사항에 대해 조사 중이며, 조사가 완료되는 대로 빠른 시일 내에 답변 드리겠습니다.\n\n조금 더 시간이 필요할 수 있으니 양해 부탁드립니다.\n\n진행 상황에 대해서는 추가로 연락드리겠습니다.\n\n감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ],

            'more_info_needed' => [
                'title' => '추가정보 요청',
                'category' => 'inquiry',
                'description' => '고객에게 추가 정보가 필요할 때 사용하는 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n{{subject}} 건에 대해 문의해 주신 내용을 확인하였습니다.\n\n정확한 답변을 위해 다음 정보를 추가로 제공해 주시기 바랍니다:\n\n1. [필요한 정보 1을 구체적으로 기술]\n2. [필요한 정보 2를 구체적으로 기술]\n3. [필요한 정보 3을 구체적으로 기술]\n\n위 정보를 회신해 주시면 빠른 시일 내에 정확한 답변 드리겠습니다.\n\n감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ],

            'technical_support' => [
                'title' => '기술지원 안내',
                'category' => 'technical',
                'description' => '기술적인 문제 해결을 위한 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n기술적인 문제에 대해 문의해 주셔서 감사합니다.\n\n문제 해결을 위해 다음 단계를 따라해 보시기 바랍니다:\n\n1. [해결 단계 1을 상세히 기술]\n2. [해결 단계 2를 상세히 기술]\n3. [해결 단계 3을 상세히 기술]\n\n위 방법으로도 문제가 해결되지 않으시면 다음 정보를 함께 보내주세요:\n- 사용 중인 브라우저 및 버전\n- 오류 메시지 스크린샷\n- 문제 발생 시점 및 재현 단계\n\n추가 도움이 필요하시면 언제든지 연락주세요.\n\n감사합니다.\n\n{{company_name}} 기술지원팀\n{{support_email}}"
            ],

            'billing_inquiry' => [
                'title' => '결제 문의 답변',
                'category' => 'billing',
                'description' => '결제 관련 문의에 대한 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n결제 관련 문의해 주신 내용을 확인하였습니다.\n\n[결제 관련 답변 내용을 구체적으로 작성]\n\n결제와 관련된 추가 문의사항이나 도움이 필요하시면:\n- 고객지원 이메일: {{support_email}}\n- 결제 관련 FAQ: {{website_url}}/faq\n\n언제든지 연락 주시기 바랍니다.\n\n감사합니다.\n\n{{company_name}} 결제지원팀\n{{support_email}}"
            ],

            'account_support' => [
                'title' => '계정 지원',
                'category' => 'account',
                'description' => '계정 관련 문제 해결을 위한 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n계정 관련 문의해 주신 내용을 확인하였습니다.\n\n보안을 위해 본인 확인이 필요한 경우가 있으니 양해 부탁드립니다.\n\n[계정 관련 답변 또는 해결 방법을 기술]\n\n계정 보안을 위한 추가 권장사항:\n- 정기적인 비밀번호 변경\n- 2단계 인증 활성화\n- 의심스러운 활동 즉시 신고\n\n계정 관련 추가 도움이 필요하시면 연락 주시기 바랍니다.\n\n감사합니다.\n\n{{company_name}} 계정지원팀\n{{support_email}}"
            ],

            'feedback_thanks' => [
                'title' => '피드백 감사',
                'category' => 'feedback',
                'description' => '고객 피드백에 대한 감사 메시지',
                'content' => "안녕하세요, {{customer_name}}님!\n\n소중한 피드백을 보내주셔서 진심으로 감사드립니다.\n\n고객님의 의견은 저희 서비스 개선에 큰 도움이 됩니다.\n\n[피드백에 대한 구체적인 응답 내용]\n\n앞으로도 더 나은 서비스 제공을 위해 노력하겠습니다.\n\n추가 의견이나 제안사항이 있으시면 언제든지 연락 주시기 바랍니다.\n\n감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ],

            'urgent_escalation' => [
                'title' => '긴급 사안 에스컬레이션',
                'category' => 'urgent',
                'description' => '긴급한 문제를 상위 담당자에게 에스컬레이션할 때 사용',
                'content' => "안녕하세요, {{customer_name}}님!\n\n긴급 사안으로 분류된 {{subject}} 건에 대해 연락드립니다.\n\n해당 사안의 중요성을 인지하고 있으며, 즉시 담당 팀장에게 전달하여 우선 처리하도록 하겠습니다.\n\n예상 해결 시간: [구체적인 시간 명시]\n진행 상황 업데이트: [업데이트 주기 명시]\n\n처리 과정에서 추가 연락을 드릴 수 있으니 양해 부탁드립니다.\n\n긴급 연락이 필요한 경우: {{support_email}}\n\n신속한 해결을 위해 최선을 다하겠습니다.\n\n{{company_name}} 고객지원팀\n지원 요청 번호: {{support_id}}"
            ],

            'followup' => [
                'title' => '후속 조치 안내',
                'category' => 'followup',
                'description' => '문제 해결 후 후속 조치를 안내하는 템플릿',
                'content' => "안녕하세요, {{customer_name}}님!\n\n지난번 {{subject}} 건이 해결된 이후 서비스 이용에 문제가 없으신지 확인차 연락드립니다.\n\n해결된 사항:\n- [해결된 내용 1]\n- [해결된 내용 2]\n- [해결된 내용 3]\n\n혹시 동일하거나 관련된 문제가 다시 발생하시면 즉시 연락 주시기 바랍니다.\n\n고객님의 만족도 향상을 위해 간단한 피드백을 남겨주시면 감사하겠습니다.\n\n앞으로도 {{company_name}}를 이용해 주셔서 감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ]
        ];
    }
}