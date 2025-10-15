<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Footer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\FooterService;
use Jiny\Site\Facades\Footer;

class IndexController extends Controller
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function __invoke(Request $request)
    {
        // 푸터 템플릿 목록
        $footers = $this->footerService->getAllFooters();

        // 배열 인덱스를 ID로 변환 (1부터 시작)
        foreach ($footers as $index => &$footer) {
            $footer['id'] = $index + 1;
        }

        // 전체 푸터 설정 정보 (회사 정보, 소셜 링크, 메뉴 섹션 등)
        $footerConfig = [
            'copyright' => Footer::getCopyright(),
            'logo' => Footer::getLogo(),
            'company' => Footer::getCompany(),
            'social' => Footer::getSocial(),
            'menu_sections' => Footer::getMenuSections(),
        ];

        // 통계 정보
        $stats = [
            'total_templates' => count($footers),
            'has_company_info' => !empty($footerConfig['company']),
            'social_links_count' => count($footerConfig['social']),
            'menu_sections_count' => count($footerConfig['menu_sections']),
        ];

        return view('jiny-site::admin.templates.footer.index', compact('footers', 'footerConfig', 'stats'));
    }
}