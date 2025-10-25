<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * 블록 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    /**
     * 블록 업데이트 (서브폴더 지원)
     */
    public function __invoke(Request $request, $pathParam)
    {
        // 유효성 검사
        $request->validate([
            'content' => 'required|string',
        ]);

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
            $redirectRoute = $folder
                ? route('admin.cms.blocks.folder', ['folder' => str_replace('/', '.', $folder)])
                : route('admin.cms.blocks.index');

            return redirect($redirectRoute)
                ->with('error', '블록 파일을 찾을 수 없습니다: ' . $fullPath);
        }

        try {
            // 파일 내용 저장
            File::put($filePath, $request->input('content'));

            return redirect()->route('admin.cms.blocks.edit', $pathParam)
                ->with('success', '블록이 성공적으로 저장되었습니다.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['message' => '파일 저장 중 오류가 발생했습니다: ' . $e->getMessage()])
                ->withInput();
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