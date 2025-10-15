<?php

namespace Jiny\Site\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $page = SitePage::findOrFail($id);

        // 사용 가능한 템플릿 목록
        $templates = $this->getAvailableTemplates();

        // 사용 가능한 레이아웃 목록
        $layouts = $this->getAvailableLayouts();

        // 사용 가능한 헤더 목록
        $headers = $this->getAvailableHeaders();

        // 사용 가능한 푸터 목록
        $footers = $this->getAvailableFooters();

        // 사용 가능한 사이드바 목록
        $sidebars = $this->getAvailableSidebars();

        return view('jiny-site::admin.pages.edit', compact('page', 'templates', 'layouts', 'headers', 'footers', 'sidebars'));
    }

    private function getAvailableTemplates()
    {
        return [
            'default' => '기본 템플릿',
            'page' => '일반 페이지',
            'landing' => '랜딩 페이지',
            'about' => '회사 소개',
            'contact' => '연락처',
            'privacy' => '개인정보처리방침',
            'terms' => '이용약관',
        ];
    }

    private function getAvailableLayouts()
    {
        return [
            'jiny-site::layouts.default' => '기본 레이아웃',
            'jiny-site::layouts.app' => '앱 레이아웃',
            'jiny-site::layouts.about' => '회사소개 레이아웃',
            'jiny-site::layouts.landing' => '랜딩 레이아웃',
            'jiny-site::layouts.full-width' => '전체 너비 레이아웃',
        ];
    }

    private function getAvailableHeaders()
    {
        return [
            'jiny-site::partials.headers.header-default' => '기본 헤더',
            'jiny-site::partials.headers.header-transparent' => '투명 헤더',
            'jiny-site::partials.headers.header-minimal' => '미니멀 헤더',
            'jiny-site::partials.headers.header-landing' => '랜딩 헤더',
        ];
    }

    private function getAvailableFooters()
    {
        return [
            'jiny-site::partials.footers.footer' => '기본 푸터',
            'jiny-site::partials.footers.footer-minimal' => '미니멀 푸터',
            'jiny-site::partials.footers.footer-corporate' => '기업용 푸터',
        ];
    }

    private function getAvailableSidebars()
    {
        return [
            'jiny-site::partials.about-side' => '회사소개 사이드바',
            'jiny-site::partials.sidebar-default' => '기본 사이드바',
            'jiny-site::partials.sidebar-navigation' => '네비게이션 사이드바',
        ];
    }
}