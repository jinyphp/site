<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

/**
 * 블록 저장 컨트롤러
 *
 * @description
 * 새로운 블록 파일을 생성하여 저장합니다.
 */
class StoreController extends Controller
{
    /**
     * 새 블록 저장 (서브폴더 지원)
     */
    public function __invoke(Request $request)
    {
        try {
            // 폴더 정보 추출
            $folder = $request->input('folder', '');
            $currentFolder = '';
            if ($folder) {
                $currentFolder = str_replace('.', '/', $folder);
            }

            // 유효성 검사
            $validator = Validator::make($request->all(), [
                'filename' => [
                    'required',
                    'string',
                    'max:100',
                    'regex:/^[a-zA-Z0-9_-]+$/',
                    function ($attribute, $value, $fail) use ($currentFolder) {
                        // 실제 블록 파일들이 있는 경로
                        $blocksPath = __DIR__.'/../../../../../../resources/views/www/blocks';

                        // 대체 경로들 확인
                        if (!is_dir($blocksPath)) {
                            $blocksPath = resource_path('views/vendor/jiny-site/www/blocks');
                        }
                        if (!is_dir($blocksPath)) {
                            $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
                        }

                        $currentPath = $currentFolder ? $blocksPath . '/' . $currentFolder : $blocksPath;
                        $filePath = $currentPath . '/' . $value . '.blade.php';

                        if (file_exists($filePath)) {
                            $fail('이미 존재하는 파일명입니다.');
                        }
                    }
                ],
                'folder' => 'nullable|string|regex:/^[a-zA-Z0-9._-]*$/',
                'content' => 'required|string',
                'description' => 'nullable|string|max:500'
            ], [
                'filename.required' => '파일명을 입력해주세요.',
                'filename.regex' => '파일명은 영문, 숫자, 언더스코어, 하이픈만 사용 가능합니다.',
                'folder.regex' => '폴더명은 영문, 숫자, 점, 언더스코어, 하이픈만 사용 가능합니다.',
                'content.required' => '블록 내용을 입력해주세요.',
            ]);

            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '입력값이 올바르지 않습니다.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                return back()->withErrors($validator)->withInput();
            }

            $filename = $request->input('filename');
            $content = $request->input('content');
            $description = $request->input('description');

            // 실제 블록 파일들이 있는 경로
            $blocksPath = __DIR__.'/../../../../../../resources/views/www/blocks';

            // 대체 경로들 확인
            if (!is_dir($blocksPath)) {
                $blocksPath = resource_path('views/vendor/jiny-site/www/blocks');
            }
            if (!is_dir($blocksPath)) {
                $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
            }

            if (!is_dir($blocksPath)) {
                throw new \Exception('블록 디렉토리를 찾을 수 없습니다.');
            }

            // 서브폴더 경로 설정
            $currentPath = $currentFolder ? $blocksPath . '/' . $currentFolder : $blocksPath;

            // 경로 보안 검사 (폴더가 존재하지 않는 경우는 상위 폴더로 검사)
            $pathToCheck = $currentPath;
            if (!is_dir($currentPath) && $currentFolder) {
                // 폴더가 존재하지 않으면 상위 폴더들을 체크
                $pathParts = explode('/', $currentFolder);
                $checkPath = $blocksPath;
                foreach ($pathParts as $part) {
                    $checkPath .= '/' . $part;
                    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $part)) {
                        throw new \Exception('유효하지 않은 폴더명입니다.');
                    }
                }
                $pathToCheck = $blocksPath; // 기본 경로로 검사
            }

            if (!$this->isValidPath($pathToCheck, $blocksPath)) {
                throw new \Exception('유효하지 않은 경로입니다.');
            }

            // 서브폴더가 없으면 생성
            if ($currentFolder && !is_dir($currentPath)) {
                if (!File::makeDirectory($currentPath, 0755, true)) {
                    throw new \Exception('폴더 생성에 실패했습니다.');
                }
            }

            // 설명이 있으면 파일 상단에 주석으로 추가
            if ($description) {
                $content = "{{-- " . $description . " --}}\n" . $content;
            }

            // 파일 저장
            $filePath = $currentPath . '/' . $filename . '.blade.php';
            File::put($filePath, $content);

            // 전체 경로와 path param 생성
            $fullPath = $currentFolder ? $currentFolder . '/' . $filename : $filename;
            $pathParam = str_replace('/', '.', $fullPath);

            // JSON 요청인 경우
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '블록이 성공적으로 생성되었습니다.',
                    'filename' => $filename,
                    'full_path' => $fullPath,
                    'edit_url' => route('admin.cms.blocks.edit', $pathParam),
                    'preview_url' => route('admin.cms.blocks.preview', $pathParam)
                ]);
            }

            return redirect()
                ->route('admin.cms.blocks.edit', $pathParam)
                ->with('success', "블록 '{$fullPath}'이 성공적으로 생성되었습니다.");

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '블록 생성 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()
                ->withErrors(['message' => '블록 생성 중 오류가 발생했습니다: ' . $e->getMessage()])
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