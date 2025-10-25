<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

/**
 * 블록 편집 컨트롤러 (미리보기 통합)
 */
class EditController extends Controller
{
    /**
     * 블록 편집/미리보기 페이지 표시 (서브폴더 지원)
     */
    public function __invoke(Request $request, $pathParam)
    {
        // 경로 파라미터를 실제 경로로 변환
        $fullPath = str_replace('.', '/', $pathParam);
        $pathParts = explode('/', $fullPath);
        $filename = array_pop($pathParts);
        $folder = implode('/', $pathParts);

        // 파일명 유효성 검사
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $filename)) {
            return redirect()->route('admin.cms.blocks.index')
                ->with('error', '유효하지 않은 파일명입니다: ' . $filename);
        }

        // 폴더명 유효성 검사
        if ($folder) {
            $folderParts = explode('/', $folder);
            foreach ($folderParts as $part) {
                if (!preg_match('/^[a-zA-Z0-9_-]+$/', $part)) {
                    return redirect()->route('admin.cms.blocks.index')
                        ->with('error', '유효하지 않은 폴더명입니다: ' . $part);
                }
            }
        }

        // 블록 파일 경로
        $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
        $currentPath = $folder ? $blocksPath . '/' . $folder : $blocksPath;
        $filePath = $currentPath . '/' . $filename . '.blade.php';

        // 경로 보안 검사
        if (!$this->isValidPath($currentPath, $blocksPath)) {
            return redirect()->route('admin.cms.blocks.index')
                ->with('error', '유효하지 않은 경로입니다.');
        }

        // 파일 존재 여부 확인
        if (!file_exists($filePath)) {
            // 새 파일 생성 옵션 제공
            if ($request->get('create') === 'true') {
                // 기본 템플릿으로 새 파일 생성
                $defaultContent = $this->getDefaultBlockTemplate($filename);
                File::put($filePath, $defaultContent);
            } else {
                return redirect()->route('admin.cms.blocks.index', $folder ? ['folder' => str_replace('/', '.', $folder)] : [])
                    ->with('error', '블록 파일을 찾을 수 없습니다: ' . $fullPath . '.blade.php');
            }
        }

        // 파일 내용 읽기
        $originalContent = File::get($filePath);

        // 샘플 데이터
        $sampleData = [
            'title' => 'Sample Title',
            'subtitle' => 'Sample Subtitle',
            'description' => 'This is a sample description for preview purposes.',
            'image' => 'https://via.placeholder.com/600x400/007bff/ffffff?text=Sample+Image',
            'link' => '#',
            'button_text' => 'Sample Button',
            'items' => [
                ['title' => 'Sample Item 1', 'description' => 'Sample description 1'],
                ['title' => 'Sample Item 2', 'description' => 'Sample description 2'],
                ['title' => 'Sample Item 3', 'description' => 'Sample description 3'],
            ]
        ];

        // 미리보기 모드 확인 (standalone, iframe 등)
        $mode = $request->get('mode', 'full');

        if ($mode === 'standalone' || $request->get('standalone') === 'true') {
            // 독립적인 미리보기 페이지 (iframe용)
            try {
                $renderedContent = $this->renderBlock($fullPath, $sampleData);
                return view('jiny-site::admin.blocks.preview-standalone', [
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'content' => $renderedContent,
                    'original_content' => $originalContent
                ]);
            } catch (\Exception $e) {
                return view('jiny-site::admin.blocks.preview-error', [
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'error' => $e->getMessage(),
                    'original_content' => $originalContent
                ]);
            }
        }

        // 블록 렌더링 시도 (안전 모드)
        $renderedContent = null;
        $renderError = null;

        // standalone 모드가 아닐 때만 렌더링 시도
        if ($mode !== 'standalone' && $originalContent && trim($originalContent) !== '') {
            // 기본 HTML 태그가 있는지 간단히 확인
            if (strpos($originalContent, '<') !== false) {
                try {
                    $renderedContent = $this->renderBlock($fullPath, $sampleData);
                } catch (\Exception $e) {
                    $renderError = $e->getMessage();
                }
            } else {
                $renderError = '유효한 HTML 또는 Blade 템플릿이 아닙니다.';
            }
        } elseif (!$originalContent || trim($originalContent) === '') {
            $renderError = '블록 내용이 비어있습니다.';
        }

        // 파일 정보
        $fileInfo = new \SplFileInfo($filePath);

        return view('jiny-site::admin.blocks.edit', [
            'filename' => $filename,
            'full_path' => $fullPath,
            'folder' => $folder,
            'path_param' => $pathParam,
            'content' => $originalContent,
            'originalContent' => $originalContent,
            'renderedContent' => $renderedContent,
            'renderError' => $renderError,
            'sampleData' => $sampleData,
            'errors' => session()->get('errors', collect()),
            'fileInfo' => [
                'size' => $fileInfo->getSize(),
                'modified' => date('Y-m-d H:i:s', $fileInfo->getMTime()),
                'category' => $this->getBlockCategory($filename),
                'path' => $filePath
            ]
        ]);
    }

    /**
     * 블록 렌더링 (안전한 방식, 서브폴더 지원)
     */
    private function renderBlock($fullPath, $sampleData = [])
    {
        try {
            // 블록 뷰 경로 생성 (서브폴더 지원)
            $viewName = 'jiny-site::www.blocks.' . str_replace('/', '.', $fullPath);

            // Laravel의 뷰 캐시 클리어 (수정된 파일 반영)
            if (app()->environment('local')) {
                View::flushFinderCache();
            }

            // 뷰가 존재하는지 확인
            if (!View::exists($viewName)) {
                throw new \Exception("뷰 '{$viewName}'를 찾을 수 없습니다.");
            }

            // 에러 리포팅 레벨 임시 변경
            $oldErrorReporting = error_reporting(E_ERROR | E_PARSE);

            try {
                // 출력 버퍼링으로 에러 캐치
                ob_start();

                // 뷰 컴파일 및 렌더링
                $view = View::make($viewName, $sampleData);
                $rendered = $view->render();

                ob_end_clean();
                error_reporting($oldErrorReporting);

                return $rendered;

            } catch (\Illuminate\Contracts\View\ViewCompilationException $e) {
                ob_end_clean();
                error_reporting($oldErrorReporting);
                throw new \Exception('Blade 컴파일 오류: ' . $this->cleanErrorMessage($e->getMessage()));
            } catch (\ParseError $e) {
                ob_end_clean();
                error_reporting($oldErrorReporting);
                throw new \Exception('Blade 구문 분석 오류: ' . $this->cleanErrorMessage($e->getMessage()));
            } catch (\ErrorException $e) {
                ob_end_clean();
                error_reporting($oldErrorReporting);
                throw new \Exception('렌더링 오류: ' . $this->cleanErrorMessage($e->getMessage()));
            } catch (\Exception $e) {
                ob_end_clean();
                error_reporting($oldErrorReporting);
                throw new \Exception('템플릿 오류: ' . $this->cleanErrorMessage($e->getMessage()));
            } catch (\Throwable $e) {
                ob_end_clean();
                error_reporting($oldErrorReporting);
                throw new \Exception('예상치 못한 오류: ' . $this->cleanErrorMessage($e->getMessage()));
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 에러 메시지 정리
     */
    private function cleanErrorMessage($message)
    {
        // 파일 경로 제거하여 간결한 메시지 생성
        $message = preg_replace('/\(View: .+?\)/', '', $message);
        $message = preg_replace('/in \/.*?\.blade\.php/', '', $message);

        return trim($message);
    }

    /**
     * 블록 카테고리 추출
     */
    private function getBlockCategory($filename)
    {
        if (str_starts_with($filename, 'hero01')) return 'Hero 01';
        if (str_starts_with($filename, 'hero02')) return 'Hero 02';
        if (str_starts_with($filename, 'hero03')) return 'Hero 03';
        if (str_starts_with($filename, 'hero04')) return 'Hero 04';
        if (str_starts_with($filename, 'hero05')) return 'Hero 05';
        if (str_starts_with($filename, 'hero06')) return 'Hero 06';
        if (str_starts_with($filename, 'hero07')) return 'Hero 07';
        if (str_starts_with($filename, 'hero08')) return 'Hero 08';
        if (str_starts_with($filename, 'hero_')) return 'Hero';
        if (str_starts_with($filename, 'hero')) return 'Hero';
        if (str_starts_with($filename, 'about')) return 'About';
        if (str_contains($filename, 'cta')) return 'CTA';
        if (str_contains($filename, 'feature')) return 'Features';
        if (str_contains($filename, 'testimonial')) return 'Testimonials';
        if (str_contains($filename, 'pricing')) return 'Pricing';
        if (str_contains($filename, 'course')) return 'Courses';

        return 'Other';
    }

    /**
     * 기본 블록 템플릿 생성
     */
    private function getDefaultBlockTemplate($filename)
    {
        return <<<EOD
{{-- $filename 블록 --}}
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{{ \$title ?? 'Sample Title' }}</h2>
                <p>{{ \$description ?? 'Sample description for $filename block.' }}</p>
            </div>
        </div>
    </div>
</section>
EOD;
    }

    /**
     * 경로 유효성 검사
     */
    private function isValidPath($path, $basePath)
    {
        $realPath = realpath($path);
        $realBasePath = realpath($basePath);

        if (!$realPath || !$realBasePath) {
            return false;
        }

        return str_starts_with($realPath, $realBasePath);
    }
}