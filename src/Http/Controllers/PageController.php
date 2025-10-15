<?php

namespace Jiny\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class PageController extends Controller
{
    /**
     * 정적 페이지 표시
     */
    public function show(Request $request, $slug)
    {
        try {
            $page = SitePage::where('slug', $slug)
                           ->published()
                           ->firstOrFail();

            // 조회수 증가
            $page->incrementViewCount();

            // 템플릿 결정
            $template = $this->getTemplate($page);

            // SEO 메타 데이터 설정
            $this->setSeoData($page);

            // 레이아웃 정보를 뷰에 전달
            $layout = $page->layout ?: null;
            $header = $page->header ?: null;
            $footer = $page->footer ?: null;
            $sidebar = $page->sidebar ?: null;

            return view($template, compact('page', 'layout', 'header', 'footer', 'sidebar'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 페이지를 찾을 수 없는 경우 404 반환
            abort(404, '페이지를 찾을 수 없습니다.');
        } catch (\InvalidArgumentException $e) {
            // 뷰나 컴포넌트를 찾을 수 없는 경우도 404로 처리
            abort(404, '페이지를 표시할 수 없습니다: ' . $e->getMessage());
        } catch (\Exception $e) {
            // 기타 예외의 경우 로그를 남기고 404 반환
            \Log::error('PageController show error: ' . $e->getMessage(), [
                'slug' => $slug,
                'trace' => $e->getTraceAsString()
            ]);
            abort(404, '페이지를 표시할 수 없습니다.');
        }
    }

    /**
     * 템플릿 파일 결정
     */
    private function getTemplate(SitePage $page)
    {
        $template = $page->template ?: 'index';

        // 템플릿 파일 우선순위
        $templates = [
            "jiny-site::www.pages.{$template}",  // 패키지의 www.pages 템플릿
            "jiny-site::pages.{$template}",  // 패키지의 pages 템플릿
            "pages.{$template}",  // 프로젝트의 커스텀 템플릿
            'jiny-site::www.pages.index',  // 기본 www.pages.index 템플릿
            'jiny-site::pages.default',  // 기본 페이지 템플릿
        ];

        // 존재하는 첫 번째 템플릿 반환
        foreach ($templates as $tmpl) {
            try {
                if (view()->exists($tmpl)) {
                    return $tmpl;
                }
            } catch (\InvalidArgumentException $e) {
                // 템플릿 이름이 잘못된 경우 스킵하고 다음으로 진행
                continue;
            }
        }

        // 모든 템플릿이 없으면 기본 템플릿 사용
        return 'jiny-site::www.pages.index';
    }

    /**
     * SEO 메타 데이터 설정
     */
    private function setSeoData(SitePage $page)
    {
        // 기본 메타 태그 설정
        if (function_exists('seo')) {
            seo()
                ->title($page->meta_title ?: $page->title)
                ->description($page->meta_description ?: $page->excerpt)
                ->keywords($page->meta_keywords)
                ->canonical(url($page->url));

            // Open Graph 설정
            if ($page->og_title || $page->og_description || $page->og_image) {
                seo()
                    ->opengraph('title', $page->og_title ?: $page->meta_title ?: $page->title)
                    ->opengraph('description', $page->og_description ?: $page->meta_description ?: $page->excerpt)
                    ->opengraph('url', url($page->url))
                    ->opengraph('type', 'article');

                if ($page->og_image) {
                    seo()->opengraph('image', $page->og_image);
                }
            }

            // Twitter Card 설정
            seo()
                ->twitter('card', 'summary_large_image')
                ->twitter('title', $page->og_title ?: $page->meta_title ?: $page->title)
                ->twitter('description', $page->og_description ?: $page->meta_description ?: $page->excerpt);

            if ($page->og_image) {
                seo()->twitter('image', $page->og_image);
            }
        }

        // View Composer를 통한 메타 데이터 전달
        view()->share([
            'metaTitle' => $page->meta_title ?: $page->title,
            'metaDescription' => $page->meta_description ?: $page->excerpt,
            'metaKeywords' => $page->meta_keywords,
            'ogTitle' => $page->og_title ?: $page->meta_title ?: $page->title,
            'ogDescription' => $page->og_description ?: $page->meta_description ?: $page->excerpt,
            'ogImage' => $page->og_image,
            'ogUrl' => url($page->url),
        ]);
    }

    /**
     * 모든 발행된 페이지 목록 (사이트맵 등에 사용)
     */
    public function index(Request $request)
    {
        $pages = SitePage::published()
                        ->ordered()
                        ->paginate(20);

        return view('jiny-site::pages.index', compact('pages'));
    }

    /**
     * 추천 페이지 목록
     */
    public function featured(Request $request)
    {
        $pages = SitePage::published()
                        ->featured()
                        ->ordered()
                        ->get();

        return view('jiny-site::pages.featured', compact('pages'));
    }

    /**
     * 페이지 검색
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $pages = collect();

        if ($query) {
            $pages = SitePage::published()
                            ->where(function ($q) use ($query) {
                                $q->where('title', 'like', "%{$query}%")
                                  ->orWhere('content', 'like', "%{$query}%")
                                  ->orWhere('excerpt', 'like', "%{$query}%");
                            })
                            ->ordered()
                            ->paginate(20)
                            ->withQueryString();
        }

        return view('jiny-site::pages.search', compact('pages', 'query'));
    }

    /**
     * 사이트맵 XML 생성
     */
    public function sitemap(Request $request)
    {
        $pages = SitePage::published()
                        ->select(['slug', 'updated_at', 'created_at'])
                        ->get();

        return response()
            ->view('jiny-site::pages.sitemap', compact('pages'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * RSS 피드 생성
     */
    public function rss(Request $request)
    {
        $pages = SitePage::published()
                        ->orderBy('published_at', 'desc')
                        ->limit(20)
                        ->get();

        return response()
            ->view('jiny-site::pages.rss', compact('pages'))
            ->header('Content-Type', 'application/rss+xml');
    }
}