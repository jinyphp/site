<?php

namespace Jiny\Site\Http\Controllers\Site\Page;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\PageService;

/**
 * 동적 페이지 표시 컨트롤러 (Fallback)
 *
 * 진입 경로:
 * Route::get('/{slug}') → ShowController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. loadPage() - 페이지 데이터 로드
 *     ├─ 3. resolveView() - 뷰 우선순위 확인
 *     └─ 4. renderView() - 뷰 렌더링
 */
class ShowController extends Controller
{
    protected $pageService;
    protected $config;

    /**
     * 생성자
     *
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'theme' => config('site.theme'),
            'enabled' => config('site.dynamic_pages.enabled', true),
        ];
    }

    /**
     * 설정 파일 로드
     */
    private function loadConfigFile($filename)
    {
        $configPath = base_path("vendor/jiny/site/config/{$filename}");

        if (file_exists($configPath)) {
            $content = file_get_contents($configPath);
            return json_decode($content, true);
        }

        return [];
    }

    /**
     * 페이지별 템플릿 설정 로드
     */
    protected function loadTemplateData($page)
    {
        $templateData = [
            'headers' => $this->loadConfigFile('headers.json'),
            'footers' => $this->loadConfigFile('footers.json'),
            'selectedHeader' => null,
            'selectedFooter' => null,
        ];

        // 페이지별 헤더/푸터 설정이 있는 경우
        if ($page) {
            // 페이지에 지정된 헤더 템플릿 찾기
            if (!empty($page['header_template'])) {
                $templateData['selectedHeader'] = $this->findTemplateByPath(
                    $templateData['headers']['template'] ?? [],
                    $page['header_template']
                );
            }

            // 페이지에 지정된 푸터 템플릿 찾기
            if (!empty($page['footer_template'])) {
                $templateData['selectedFooter'] = $this->findTemplateByPath(
                    $templateData['footers']['template'] ?? [],
                    $page['footer_template']
                );
            }
        }

        // 기본 템플릿 설정이 없으면 기본값 사용
        if (!$templateData['selectedHeader']) {
            $templateData['selectedHeader'] = $this->findDefaultTemplate(
                $templateData['headers']['template'] ?? []
            );
        }

        if (!$templateData['selectedFooter']) {
            $templateData['selectedFooter'] = $this->findDefaultTemplate(
                $templateData['footers']['template'] ?? []
            );
        }

        return $templateData;
    }

    /**
     * 경로로 템플릿 찾기
     */
    private function findTemplateByPath($templates, $path)
    {
        foreach ($templates as $template) {
            if ($template['path'] === $path && $template['enable']) {
                return $template;
            }
        }
        return null;
    }

    /**
     * 기본 템플릿 찾기
     */
    private function findDefaultTemplate($templates)
    {
        foreach ($templates as $template) {
            if ($template['default'] && $template['enable']) {
                return $template;
            }
        }

        // 기본값이 없으면 첫 번째 활성화된 템플릿 반환
        foreach ($templates as $template) {
            if ($template['enable']) {
                return $template;
            }
        }

        return null;
    }

    /**
     * 동적 페이지 표시 (메인 진입점)
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $slug)
    {
        // 동적 페이지 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: 페이지 데이터 로드
        $page = $this->loadPage($slug);

        // dd($page);

        // 2단계: 뷰 해석
        $viewPath = $this->resolveView($slug);

        // 3단계: 뷰 렌더링
        return $this->renderView($viewPath, $page);
    }

    /**
     * [1단계] 페이지 데이터 로드
     *
     * @param string $slug
     * @return array|null
     */
    protected function loadPage($slug)
    {
        // site_pages 테이블에서 페이지 조회
        $page = \Jiny\Site\Models\SitePage::where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->first();

        return $page ? $page->toArray() : null;
    }

    /**
     * 페이지 조회수 증가
     *
     * @param int $pageId
     * @return void
     */
    protected function incrementPageViewCount($pageId)
    {
        try {
            \Jiny\Site\Models\SitePage::where('id', $pageId)->increment('view_count');
        } catch (\Exception $e) {
            // 조회수 증가 실패는 무시 (로그에만 기록)
            \Log::warning('Failed to increment page view count', [
                'page_id' => $pageId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * [2단계] 뷰 해석 (우선순위)
     *
     * 우선순위:
     * 1. www::{slug}
     * 2. theme::{theme}.{slug}
     * 3. jiny-site::site.page.show
     *
     * @param string $slug
     * @return string
     */
    protected function resolveView($slug)
    {
        // 슬러그 정리 (슬래시를 점으로 변환)
        $viewSlug = str_replace('/', '.', $slug);

        // 우선순위 1: www 뷰
        $view = "www::" . $viewSlug;
        if (view()->exists($view)) {
            return $view;
        }

        // 우선순위 2: 테마 뷰
        if ($this->config['theme']) {
            $view = "theme::" . $this->config['theme'] . "." . $viewSlug;
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 우선순위 3: 패키지 기본 뷰
        return "jiny-site::site.page.show";
    }

    /**
     * [3단계] 뷰 렌더링
     *
     * @param string $viewPath
     * @param array|null $page
     * @return \Illuminate\View\View
     */
    protected function renderView($viewPath, $page)
    {
        // 페이지가 없으면 404
        if (!$page && !view()->exists($viewPath)) {
            abort(404);
        }

        // 템플릿 데이터 로드
        $templateData = $this->loadTemplateData($page);

        // 조회수 증가 (페이지가 있는 경우)
        if ($page && isset($page['id'])) {
            $this->incrementPageViewCount($page['id']);
        }

        return view($viewPath, [
            'page' => $page,
            'config' => $this->config,
            'headers' => $templateData['headers'],
            'footers' => $templateData['footers'],
            'selectedHeader' => $templateData['selectedHeader'],
            'selectedFooter' => $templateData['selectedFooter'],
            'headerTemplate' => $templateData['selectedHeader']['path'] ?? null,
            'footerTemplate' => $templateData['selectedFooter']['path'] ?? null,
        ]);
    }
}
