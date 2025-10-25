<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

/**
 * 블록 상세 보기 컨트롤러
 */
class ShowController extends Controller
{
    /**
     * 블록 미리보기 표시 (서브폴더 지원)
     */
    public function __invoke(Request $request, $pathParam)
    {
        // 경로 파라미터를 실제 경로로 변환
        $fullPath = str_replace('.', '/', $pathParam);
        $pathParts = explode('/', $fullPath);
        $filename = array_pop($pathParts);
        $folder = implode('/', $pathParts);

        // 블록 파일 경로
        $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
        $currentPath = $folder ? $blocksPath . '/' . $folder : $blocksPath;
        $filePath = $currentPath . '/' . $filename . '.blade.php';
        $blockExists = file_exists($filePath);

        // 경로 보안 검사
        if (!$this->isValidPath($currentPath, $blocksPath)) {
            $blockExists = false;
        }

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

        $originalContent = '';
        $renderedContent = null;
        $renderError = null;

        if ($blockExists) {
            $originalContent = File::get($filePath);

            // 블록 렌더링 시도
            try {
                $renderedContent = $this->renderBlock($fullPath, $sampleData);
            } catch (\Exception $e) {
                $renderError = $e->getMessage();
            }
        }

        return view('jiny-site::admin.blocks.show', [
            'filename' => $filename,
            'full_path' => $fullPath,
            'folder' => $folder,
            'path_param' => $pathParam,
            'exists' => $blockExists,
            'viewName' => 'jiny-site::www.blocks.' . str_replace('/', '.', $fullPath),
            'sampleData' => $sampleData,
            'originalContent' => $originalContent,
            'renderedContent' => $renderedContent,
            'renderError' => $renderError
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

            // 뷰가 존재하는지 확인
            if (!View::exists($viewName)) {
                throw new \Exception("뷰 '{$viewName}'를 찾을 수 없습니다.");
            }

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