<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Templates;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 지원 요청 템플릿 목록 컨트롤러
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
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
                'content' => "안녕하세요, {{customer_name}}님!\n\n{{subject}} 건에 대해 문의해 주신 내용을 확인하였습니다.\n\n보다 정확한 답변을 드리기 위해 다음과 같은 추가 정보가 필요합니다:\n\n[필요한 정보들을 여기에 나열하세요]\n\n위 정보를 제공해 주시면 빠른 시일 내에 정확한 답변을 드리겠습니다.\n\n감사합니다.\n\n{{company_name}} 고객지원팀\n{{support_email}}"
            ],
        ];
    }
}