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
        }

        // 통계 정보 생성
        $stats = [
            'total_templates' => count($headers),
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