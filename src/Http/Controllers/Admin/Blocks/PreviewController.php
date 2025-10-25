<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

/**
 * 블록 미리보기 컨트롤러
 *
 * @description
 * 블록을 실제 렌더링하여 미리보기를 제공합니다.
 */
class PreviewController extends Controller
{
    /**
     * 블록 미리보기 (서브폴더 지원)
     */
    public function __invoke(Request $request, $pathParam)
    {
        try {
            // 경로 파라미터를 실제 경로로 변환
            $fullPath = str_replace('.', '/', $pathParam);
            $pathParts = explode('/', $fullPath);
            $filename = array_pop($pathParts);
            $folder = implode('/', $pathParts);

            // 실제 블록 파일들이 있는 경로
            $blocksPath = __DIR__.'/../../../../../../resources/views/www/blocks';

            // 대체 경로들 확인
            if (!is_dir($blocksPath)) {
                $blocksPath = resource_path('views/vendor/jiny-site/www/blocks');
            }
            if (!is_dir($blocksPath)) {
                $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
            }

            $currentPath = $folder ? $blocksPath . '/' . $folder : $blocksPath;
            $filePath = $currentPath . '/' . $filename . '.blade.php';

            // 경로 보안 검사
            if (!$this->isValidPath($currentPath, $blocksPath)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '유효하지 않은 경로입니다.'
                    ], 403);
                }
                abort(403, '유효하지 않은 경로입니다.');
            }

            if (!file_exists($filePath)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '블록 파일을 찾을 수 없습니다.'
                    ], 404);
                }

                // 404 페이지로 처리
                abort(404, '블록 파일을 찾을 수 없습니다.');
            }

            // 블록 내용 읽기
            $blockContent = File::get($filePath);

            // 미리보기 모드 확인
            $mode = $request->get('mode', 'full'); // full, raw, iframe

            if ($mode === 'raw') {
                // JSON으로 원본 내용 반환
                return response()->json([
                    'success' => true,
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'content' => $blockContent,
                    'rendered' => $this->renderBlock($fullPath)
                ]);
            }

            if ($mode === 'iframe' || $request->get('standalone') === 'true') {
                // 독립적인 미리보기 페이지 (iframe용)
                try {
                    $renderedContent = $this->renderBlock($fullPath);

                    return view('jiny-site::admin.blocks.preview-standalone', [
                        'filename' => $filename,
                        'full_path' => $fullPath,
                        'content' => $renderedContent,
                        'original_content' => $blockContent
                    ]);
                } catch (\Exception $e) {
                    return view('jiny-site::admin.blocks.preview-error', [
                        'filename' => $filename,
                        'full_path' => $fullPath,
                        'error' => $e->getMessage(),
                        'original_content' => $blockContent
                    ]);
                }
            }

            // 관리자 인터페이스 내에서 미리보기
            try {
                $renderedContent = $this->renderBlock($fullPath);

                return view('jiny-site::admin.blocks.preview', [
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'folder' => $folder,
                    'path_param' => $pathParam,
                    'rendered_content' => $renderedContent,
                    'original_content' => $blockContent,
                    'file_info' => [
                        'size' => filesize($filePath),
                        'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
                        'category' => $this->getBlockCategory($filename)
                    ]
                ]);

            } catch (\Exception $e) {
                return view('jiny-site::admin.blocks.preview', [
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'folder' => $folder,
                    'path_param' => $pathParam,
                    'rendered_content' => null,
                    'original_content' => $blockContent,
                    'render_error' => $e->getMessage(),
                    'file_info' => [
                        'size' => filesize($filePath),
                        'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
                        'category' => $this->getBlockCategory($filename)
                    ]
                ]);
            }

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '블록 미리보기 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            abort(500, '블록 미리보기 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 블록 렌더링 (안전한 방식, 서브폴더 지원)
     */
    private function renderBlock($fullPath)
    {
        try {
            // 블록 뷰 경로 생성 (서브폴더 지원)
            $viewName = 'jiny-site::www.blocks.' . str_replace('/', '.', $fullPath);

            // 뷰가 존재하는지 확인
            if (!View::exists($viewName)) {
                throw new \Exception("뷰 '{$viewName}'를 찾을 수 없습니다.");
            }

            // 샘플 데이터 제공 (블록이 변수를 사용하는 경우를 위해)
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

            // 블록 렌더링 시도 (Blade 문법 오류 처리)
            try {
                return View::make($viewName, $sampleData)->render();
            } catch (\ParseError $e) {
                throw new \Exception('Blade 문법 오류: ' . $e->getMessage());
            } catch (\ErrorException $e) {
                throw new \Exception('렌더링 오류: ' . $e->getMessage());
            } catch (\Throwable $e) {
                throw new \Exception('예상치 못한 오류: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            throw $e;
        }
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