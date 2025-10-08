<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * Sitemap 서비스
 */
class SitemapService
{
    /**
     * Sitemap XML 생성
     *
     * @return string
     */
    public function generateXml()
    {
        $urls = $this->collectUrls();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . $url['loc'] . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * URL 수집
     *
     * @return array
     */
    protected function collectUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');

        // 홈페이지
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 동적 페이지
        $pages = DB::table('jiny_route')
            ->where('enabled', true)
            ->get();

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => $baseUrl . '/' . $page->uri,
                'lastmod' => $page->updated_at ?? $page->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        return $urls;
    }
}
