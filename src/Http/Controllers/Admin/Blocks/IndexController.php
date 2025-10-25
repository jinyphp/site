<?php

namespace Jiny\Site\Http\Controllers\Admin\Blocks;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * 블록 목록 컨트롤러
 *
 * @description
 * blocks 디렉토리의 블레이드 파일들을 목록으로 표시합니다.
 */
class IndexController extends Controller
{
    /**
     * 블록 목록 조회 (서브폴더 지원)
     */
    public function __invoke(Request $request, $folder = null)
    {
        try {
            // 실제 블록 파일들이 있는 경로
            $blocksPath = __DIR__.'/../../../../../../resources/views/www/blocks';

            // 대체 경로들 확인
            if (!is_dir($blocksPath)) {
                $blocksPath = resource_path('views/vendor/jiny-site/www/blocks');
            }
            if (!is_dir($blocksPath)) {
                $blocksPath = base_path('vendor/jiny/site/resources/views/www/blocks');
            }

            // 현재 폴더 경로 설정
            $currentPath = $blocksPath;
            $currentFolder = '';
            if ($folder) {
                $currentFolder = str_replace('.', '/', $folder);
                $currentPath = $blocksPath . '/' . $currentFolder;

                // 경로 보안 검사
                if (!$this->isValidPath($currentPath, $blocksPath)) {
                    return back()->withErrors(['message' => '유효하지 않은 경로입니다.']);
                }
            }

            $blocks = [];
            $folders = [];
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');
            $category = $request->get('category');

            if (is_dir($currentPath)) {
                // 현재 디렉토리의 파일과 폴더 스캔
                $files = File::files($currentPath);
                $directories = File::directories($currentPath);

                // 서브폴더 정보 수집
                foreach ($directories as $dir) {
                    $folderName = basename($dir);
                    $folderPath = $currentFolder ? $currentFolder . '/' . $folderName : $folderName;
                    $folderPathParam = str_replace('/', '.', $folderPath);

                    $folderInfo = [
                        'name' => $folderName,
                        'path' => $folderPath,
                        'param' => $folderPathParam,
                        'file_count' => count(File::allFiles($dir)),
                        'url' => route('admin.cms.blocks.folder', ['folder' => $folderPathParam])
                    ];
                    $folders[] = $folderInfo;
                }

                // 현재 폴더의 블록 파일들 처리
                foreach ($files as $file) {
                    if ($file->getExtension() === 'php' && str_ends_with($file->getFilename(), '.blade.php')) {
                        $filename = str_replace('.blade.php', '', $file->getFilename());
                        $content = File::get($file->getPathname());

                        // 전체 경로 포함한 파일명 생성
                        $fullPath = $currentFolder ? $currentFolder . '/' . $filename : $filename;
                        $pathParam = str_replace('/', '.', $fullPath);

                        // 파일 정보 수집
                        $fileInfo = [
                            'filename' => $filename,
                            'full_path' => $fullPath,
                            'path_param' => $pathParam,
                            'folder' => $currentFolder,
                            'path' => $file->getPathname(),
                            'size' => $file->getSize(),
                            'modified' => filemtime($file->getPathname()),
                            'category' => $this->getBlockCategory($filename),
                            'description' => $this->extractDescription($content),
                            'preview_url' => route('admin.cms.blocks.preview', $pathParam),
                            'edit_url' => route('admin.cms.blocks.edit', $pathParam),
                        ];

                        // 검색 필터
                        if ($search && !str_contains(strtolower($fullPath), strtolower($search))) {
                            continue;
                        }

                        // 카테고리 필터
                        if ($category && $fileInfo['category'] !== $category) {
                            continue;
                        }

                        $blocks[] = $fileInfo;
                    }
                }

                // 정렬 (폴더 먼저, 그 다음 최근 수정된 파일)
                usort($folders, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });

                usort($blocks, function($a, $b) {
                    return $b['modified'] - $a['modified'];
                });
            }

            // 수동 페이지네이션
            $total = count($blocks);
            $currentPage = $request->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $pagedBlocks = array_slice($blocks, $offset, $perPage);

            // 카테고리 목록
            $categories = array_unique(array_column($blocks, 'category'));
            sort($categories);

            // JSON 요청인 경우
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'blocks' => $pagedBlocks,
                    'pagination' => [
                        'current_page' => $currentPage,
                        'last_page' => ceil($total / $perPage),
                        'per_page' => $perPage,
                        'total' => $total
                    ],
                    'categories' => $categories
                ]);
            }

            // 통계 정보
            $stats = [
                'total_blocks' => $total,
                'hero_blocks' => count(array_filter($blocks, fn($b) => str_starts_with($b['filename'], 'hero'))),
                'about_blocks' => count(array_filter($blocks, fn($b) => str_starts_with($b['filename'], 'about'))),
                'other_blocks' => count(array_filter($blocks, fn($b) => !str_starts_with($b['filename'], 'hero') && !str_starts_with($b['filename'], 'about')))
            ];

            // 브레드크럼 생성
            $breadcrumbs = $this->generateBreadcrumbs($currentFolder);

            return view('jiny-site::admin.blocks.index', [
                'blocks' => $pagedBlocks,
                'folders' => $folders,
                'stats' => $stats,
                'categories' => $categories,
                'currentFolder' => $currentFolder,
                'breadcrumbs' => $breadcrumbs,
                'currentFilters' => [
                    'search' => $search,
                    'category' => $category,
                    'per_page' => $perPage,
                    'folder' => $folder
                ],
                'pagination' => [
                    'current_page' => $currentPage,
                    'last_page' => ceil($total / $perPage),
                    'total' => $total
                ]
            ]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '블록 목록 조회 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['message' => '블록 목록 조회 중 오류가 발생했습니다.']);
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
     * 파일에서 설명 추출
     */
    private function extractDescription($content)
    {
        // 파일 상단의 주석에서 설명 추출
        if (preg_match('/{{--\s*(.+?)\s*--}}/s', $content, $matches)) {
            return trim($matches[1]);
        }

        // HTML 주석에서 설명 추출
        if (preg_match('/<!--\s*(.+?)\s*-->/s', $content, $matches)) {
            return trim($matches[1]);
        }

        // 첫 번째 div의 class에서 유추
        if (preg_match('/<div[^>]*class="([^"]*)"/', $content, $matches)) {
            $classes = $matches[1];
            if (str_contains($classes, 'hero')) return 'Hero Section';
            if (str_contains($classes, 'feature')) return 'Features Section';
            if (str_contains($classes, 'about')) return 'About Section';
            if (str_contains($classes, 'testimonial')) return 'Testimonials Section';
            if (str_contains($classes, 'cta')) return 'Call to Action';
            if (str_contains($classes, 'pricing')) return 'Pricing Section';
        }

        return 'Block template';
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

    /**
     * 브레드크럼 생성
     */
    private function generateBreadcrumbs($currentFolder)
    {
        $breadcrumbs = [
            [
                'name' => 'Blocks',
                'url' => route('admin.cms.blocks.index'),
                'active' => empty($currentFolder)
            ]
        ];

        if ($currentFolder) {
            $parts = explode('/', $currentFolder);
            $path = '';

            foreach ($parts as $i => $part) {
                $path .= ($path ? '/' : '') . $part;
                $pathParam = str_replace('/', '.', $path);
                $isLast = ($i === count($parts) - 1);

                $breadcrumbs[] = [
                    'name' => ucfirst($part),
                    'url' => route('admin.cms.blocks.folder', ['folder' => $pathParam]),
                    'active' => $isLast
                ];
            }
        }

        return $breadcrumbs;
    }
}