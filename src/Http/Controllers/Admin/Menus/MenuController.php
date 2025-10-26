<?php

namespace Jiny\Site\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Models\SiteMenu;

/**
 * 메뉴 목록 관리 컨트롤러
 * 메뉴 코드별 관리 및 JSON 파일 연동
 */
class MenuController extends Controller
{
    /**
     * 메뉴 목록 페이지
     */
    public function index(Request $request)
    {
        $query = SiteMenu::query();

        // 검색 기능
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('menu_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('manager', 'like', "%{$search}%");
            });
        }

        // 활성화 상태 필터
        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', (bool) $request->get('enable'));
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'created_at');
        $order = $request->get('order', 'desc');

        $allowedSorts = ['id', 'menu_code', 'enable', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $order);
        }

        $menus = $query->paginate(10);

        // JSON 파일과 동기화
        foreach ($menus as $menu) {
            $menu->syncWithJsonFile();
        }

        // 전체 통계 계산 (페이지네이션과 별개로)
        $totalMenus = SiteMenu::count();
        $activeMenus = SiteMenu::where('enable', true)->count();
        $inactiveMenus = SiteMenu::where('enable', false)->count();

        return view('jiny-site::admin.menu.index', compact('menus', 'totalMenus', 'activeMenus', 'inactiveMenus'));
    }

    /**
     * 새 메뉴 생성
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_code' => 'required|string|max:100|unique:site_menus,menu_code',
            'description' => 'nullable|string',
            'manager' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $menu = SiteMenu::create([
                'menu_code' => $request->menu_code,
                'code' => $request->menu_code, // 기존 호환성
                'description' => $request->description,
                'manager' => $request->manager,
                'enable' => $request->enable ?? true,
                'menu_data' => [], // 빈 메뉴로 시작
                'json_updated_at' => now(),
            ]);

            // 초기 JSON 파일 생성
            $menu->saveJsonData([]);

            DB::commit();

            return response()->json([
                'success' => true,
                'menu' => $menu,
                'message' => '메뉴가 성공적으로 생성되었습니다.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 생성 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 수정
     */
    public function update(Request $request, $id)
    {
        $menu = SiteMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'menu_code' => 'required|string|max:100|unique:site_menus,menu_code,' . $id,
            'description' => 'nullable|string',
            'manager' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // 메뉴 코드가 변경되면 JSON 파일도 이동
            if ($menu->menu_code !== $request->menu_code) {
                $oldPath = $menu->getJsonFilePath();
                $menu->menu_code = $request->menu_code;
                $newPath = $menu->getJsonFilePath();

                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }
            }

            $menu->update([
                'menu_code' => $request->menu_code,
                'code' => $request->menu_code, // 기존 호환성
                'description' => $request->description,
                'manager' => $request->manager,
                'enable' => $request->enable ?? $menu->enable,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'menu' => $menu,
                'message' => '메뉴가 성공적으로 수정되었습니다.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 수정 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 삭제
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $menu = SiteMenu::findOrFail($id);

            // JSON 파일을 백업 폴더로 이동
            if ($menu->hasJsonFile()) {
                $backupPath = resource_path('menu/backups');
                if (!file_exists($backupPath)) {
                    mkdir($backupPath, 0755, true);
                }
                $backupFile = $backupPath . '/' . $menu->menu_code . '_deleted_' . date('Y-m-d_H-i-s') . '.json';
                rename($menu->getJsonFilePath(), $backupFile);
            }

            $menu->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '메뉴가 성공적으로 삭제되었습니다.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 활성화/비활성화 토글
     */
    public function toggle(Request $request, $id)
    {
        try {
            $menu = SiteMenu::findOrFail($id);
            $menu->update(['enable' => $request->enable]);

            return response()->json([
                'success' => true,
                'enable' => $menu->enable,
                'message' => $menu->enable ? '메뉴가 활성화되었습니다.' : '메뉴가 비활성화되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상태 변경 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 기존 JSON 파일들을 site_menus 테이블에 등록
     */
    public function registerJsonFiles(Request $request)
    {
        try {
            $results = SiteMenu::registerExistingJsonFiles();

            return response()->json([
                'success' => true,
                'results' => $results,
                'message' => 'JSON 파일 등록이 완료되었습니다.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'JSON 파일 등록 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * JSON 파일들을 업로드하고 site_menus 테이블에 등록
     */
    public function uploadJsonFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'json_files' => 'required|array',
            'json_files.*' => 'required|file|mimes:json|max:2048',
            'description' => 'nullable|string',
            'manager' => 'nullable|string',
            'enable' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $results = [
                'uploaded' => [],
                'skipped' => [],
                'errors' => []
            ];

            $menuDir = resource_path('menu');
            if (!file_exists($menuDir)) {
                mkdir($menuDir, 0755, true);
            }

            foreach ($request->file('json_files') as $file) {
                $originalName = $file->getClientOriginalName();
                $menuCode = pathinfo($originalName, PATHINFO_FILENAME);

                try {
                    // JSON 형식 검증
                    $jsonContent = file_get_contents($file->getPathname());
                    $jsonData = json_decode($jsonContent, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $results['errors'][] = "{$originalName}: 올바른 JSON 형식이 아닙니다";
                        continue;
                    }

                    // 이미 존재하는 메뉴 코드인지 확인
                    if (SiteMenu::where('menu_code', $menuCode)->exists()) {
                        $results['skipped'][] = "{$originalName}: 이미 존재하는 메뉴 코드입니다";
                        continue;
                    }

                    // 파일을 resources/menu 디렉토리에 저장
                    $targetPath = $menuDir . '/' . $originalName;
                    if (file_exists($targetPath)) {
                        // 파일이 이미 존재하면 백업
                        $backupPath = $menuDir . '/backups';
                        if (!file_exists($backupPath)) {
                            mkdir($backupPath, 0755, true);
                        }
                        $backupFile = $backupPath . '/' . pathinfo($originalName, PATHINFO_FILENAME) . '_backup_' . date('Y-m-d_H-i-s') . '.json';
                        rename($targetPath, $backupFile);
                    }

                    move_uploaded_file($file->getPathname(), $targetPath);

                    // site_menus 테이블에 등록
                    $menu = SiteMenu::create([
                        'menu_code' => $menuCode,
                        'code' => $menuCode, // 기존 호환성
                        'description' => $request->description ?: "업로드된 메뉴: {$menuCode}",
                        'manager' => $request->manager,
                        'enable' => $request->enable ?? true,
                        'menu_data' => $jsonData,
                        'json_updated_at' => now(),
                    ]);

                    $results['uploaded'][] = $originalName;

                } catch (\Exception $e) {
                    $results['errors'][] = "{$originalName}: " . $e->getMessage();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'results' => $results,
                'message' => 'JSON 파일 업로드가 완료되었습니다.',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'JSON 파일 업로드 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}