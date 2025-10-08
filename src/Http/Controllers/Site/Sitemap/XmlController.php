<?php

namespace Jiny\Site\Http\Controllers\Site\Sitemap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\SitemapService;

/**
 * Sitemap XML 생성 컨트롤러
 *
 * 진입 경로:
 * Route::get('/sitemap.xml') → XmlController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. generateSitemap() - Sitemap 생성
 *     └─ 3. responseXml() - XML 응답
 */
class XmlController extends Controller
{
    protected $sitemapService;
    protected $config;

    /**
     * 생성자
     *
     * @param SitemapService $sitemapService
     */
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'enabled' => config('site.sitemap.enabled', true),
            'cache_enabled' => config('site.sitemap.cache_enabled', true),
            'cache_ttl' => config('site.sitemap.cache_ttl', 3600),
        ];
    }

    /**
     * Sitemap XML 생성 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Sitemap 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: Sitemap 생성
        $xml = $this->generateSitemap();

        // 2단계: XML 응답
        return $this->responseXml($xml);
    }

    /**
     * [1단계] Sitemap 생성
     *
     * @return string
     */
    protected function generateSitemap()
    {
        // 캐시 사용 여부 확인
        if ($this->config['cache_enabled']) {
            return cache()->remember('sitemap_xml', $this->config['cache_ttl'], function () {
                return $this->sitemapService->generateXml();
            });
        }

        return $this->sitemapService->generateXml();
    }

    /**
     * [2단계] XML 응답
     *
     * @param string $xml
     * @return \Illuminate\Http\Response
     */
    protected function responseXml($xml)
    {
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
