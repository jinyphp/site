<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Header;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\HeaderService;
use Jiny\Site\Facades\Header;

class IndexController extends Controller
{
    private HeaderService $headerService;

    public function __construct(HeaderService $headerService)
    {
        $this->headerService = $headerService;
    }

    public function __invoke(Request $request)
    {
        $headers = $this->headerService->getAllHeaders();

        // 배열 인덱스를 ID로 변환 (1부터 시작)
        foreach ($headers as $index => &$header) {
            $header['id'] = $index + 1;

            // 새로운 구조와 기존 구조 호환성 보장
            // 새로운 구조(path, title, description, default)에서 기존 구조로 매핑
            if (!isset($header['title']) && isset($header['name'])) {
                $header['title'] = $header['name'];
            }
            if (!isset($header['name']) && isset($header['title'])) {
                $header['name'] = $header['title'];
            }
            if (!isset($header['path']) && isset($header['header_key'])) {
                $header['path'] = $header['header_key'];
            }
            if (!isset($header['header_key']) && isset($header['path'])) {
                $header['header_key'] = $header['path'];
            }
            if (!isset($header['default'])) {
                $header['default'] = false;
            }
            // 새로운 필드들 기본값 설정
            if (!isset($header['enable'])) {
                $header['enable'] = true;
            }
            if (!isset($header['active'])) {
                $header['active'] = false;
            }
            // 기존 필드들도 기본값 설정
            if (!isset($header['navbar'])) {
                $header['navbar'] = false;
            }
            if (!isset($header['logo'])) {
                $header['logo'] = false;
            }
            if (!isset($header['search'])) {
                $header['search'] = false;
            }
        }

        // 새로운 템플릿 통계 사용
        $templateStats = $this->headerService->getTemplateStats();

        // 통계 정보 생성 (기존 호환성 유지)
        $stats = [
            'total_templates' => $templateStats['total_templates'],
            'default_template' => $templateStats['default_template'],
            'default_path' => $templateStats['default_path'],
            'templates_with_description' => $templateStats['templates_with_description'],
            'has_logo' => !empty(Header::getLogo()),
            'has_brand_name' => !empty(Header::getBrandName()),
            'primary_nav_count' => count(Header::getPrimaryNavigation()),
            'secondary_nav_count' => count(Header::getSecondaryNavigation()),
        ];

        // Header 설정 정보
        $headerConfig = [
            'logo' => Header::getLogo(),
            'brand_name' => Header::getBrandName(),
            'brand_tagline' => Header::getBrandTagline(),
            'navigation' => Header::getNavigation(),
            'settings' => Header::getSettings(),
        ];

        return view('jiny-site::admin.templates.header.index', compact('headers', 'stats', 'headerConfig'));
    }
}