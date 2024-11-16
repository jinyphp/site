<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteImages extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        //$this->actions['view']['main'] = "jiny-site::admin.files.main";
        $this->actions['title'] = "이미지 갤러리";
        $this->actions['subtitle'] = "이미지 파일 관리";
    }

    public function index(Request $request)
    {
        // 기본 이미지 디렉토리 경로 설정
        $baseImagePath = public_path('images');

        // URL에서 전달된 경로 파라미터 처리
        $subPath = $request->path ?? '';
        $currentPath = $baseImagePath . '/' . $subPath;

        // 상대 경로 보안 검사
        if (strpos(realpath($currentPath), realpath($baseImagePath)) !== 0) {
            abort(403, '잘못된 경로입니다.');
        }

        // 디렉토리와 이미지 정보를 저장할 배열
        $data = [
            'directories' => [],
            'images' => [],
            'current_path' => '/images/' . $subPath,
            'parent_path' => dirname('/images/' . $subPath)
        ];

        if (is_dir($currentPath)) {
            // 디렉토리 스캔
            $items = scandir($currentPath);

            foreach ($items as $item) {
                if ($item != '.' && $item != '..') {
                    $fullPath = $currentPath . '/' . $item;
                    $relativePath = trim($subPath . '/' . $item, '/');

                    if (is_dir($fullPath)) {
                        $data['directories'][] = [
                            'name' => $item,
                            'path' => $relativePath
                        ];
                    } else {
                        // 이미지 파일 확장자 체크
                        $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $data['images'][] = [
                                'name' => $item,
                                'path' => '/images/' . $relativePath,
                                'size' => filesize($fullPath),
                                'modified' => filemtime($fullPath)
                            ];
                        }
                    }
                }
            }
        }

        // 뷰 반환
        $data['path'] = $subPath;
        $data['actions'] = $this->actions;
        return view('jiny-site::admin.images.index', $data);
    }

    public function delete(Request $request)
    {
        // 기본 이미지 경로 설정
        $baseImagePath = public_path('images');

        // 삭제할 파일 경로 가져오기
        $filePath = $request->path;
        if (!$filePath) {
            return response()->json([
                'success' => false,
                'message' => '삭제할 파일 경로가 지정되지 않았습니다.'
            ], 400);
        }

        // 실제 파일 경로 생성
        $fullPath = public_path($filePath);

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath($fullPath), realpath($baseImagePath)) !== 0) {
            return response()->json([
                'success' => false,
                'message' => '잘못된 파일 경로입니다.'
            ], 403);
        }

        // 파일 존재 여부 확인
        if (!file_exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => '파일을 찾을 수 없습니다.'
            ], 404);
        }

        try {
            // 파일 삭제
            unlink($fullPath);

            return response()->json([
                'success' => true,
                'message' => '파일이 성공적으로 삭제되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '파일 삭제 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }



}
