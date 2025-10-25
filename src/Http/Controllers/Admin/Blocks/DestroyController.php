<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * 블록 삭제 컨트롤러
 *
 * @description
 * 기존 블록 파일을 삭제합니다.
 */
class DestroyController extends Controller
{
    /**
     * 블록 삭제 (서브폴더 지원)
     */
    public function __invoke(Request $request, $pathParam)
    {
        try {
            // 경로 파라미터를 실제 경로로 변환
            $fullPath = str_replace('.', '/', $pathParam);
            $pathParts = explode('/', $fullPath);
            $filename = array_pop($pathParts);
            $folder = implode('/', $pathParts);

            // 파일명 유효성 검사
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $filename)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '유효하지 않은 파일명입니다.'
                    ], 400);
                }
                abort(400, '유효하지 않은 파일명입니다.');
            }

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

            // 파일 삭제 전 백업 (선택사항)
            $backupPath = $blocksPath . '/backup';
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // 백업 파일명에 폴더 정보도 포함
            $backupFileName = ($folder ? str_replace('/', '_', $folder) . '_' : '') . $filename . '_' . date('Ymd_His') . '.blade.php.bak';
            $backupFilePath = $backupPath . '/' . $backupFileName;
            File::copy($filePath, $backupFilePath);

            // 파일 삭제
            File::delete($filePath);

            // JSON 요청인 경우
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "블록 '{$fullPath}'이 성공적으로 삭제되었습니다.",
                    'backup_path' => $backupFilePath
                ]);
            }

            // 원래 폴더로 리디렉션
            $redirectRoute = $folder
                ? route('admin.cms.blocks.folder', ['folder' => str_replace('/', '.', $folder)])
                : route('admin.cms.blocks.index');

            return redirect($redirectRoute)
                ->with('success', "블록 '{$fullPath}'이 성공적으로 삭제되었습니다. 백업 파일이 생성되었습니다.");

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '블록 삭제 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['message' => '블록 삭제 중 오류가 발생했습니다: ' . $e->getMessage()]);
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