<?php

namespace Jiny\Site\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Models\SiteMenu;

/**
 * 메뉴 트리 관리 컨트롤러
 * JSON 기반 드래그 앤 드롭 트리 구조 관리
 */
class MenuTreeController extends Controller
{
    /**
     * 메뉴 트리 페이지
     */
    public function show($id)
    {
        $menu = SiteMenu::findOrFail($id);

        // JSON 파일과 동기화
        $menu->syncWithJsonFile();

        $rawMenuData = $menu->menu_data ?: [];

        // 복잡한 메뉴 구조를 트리 관리용 단순 구조로 변환
        $menuData = $this->convertToTreeStructure($rawMenuData);
        $menuStats = $this->calculateTreeStats($menuData);

        return view('jiny-site::admin.menu.tree', compact('menu', 'menuData', 'menuStats'));
    }

    /**
     * 메뉴 아이템 추가
     */
    public function addItem(Request $request, $id)
    {
        $menu = SiteMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'href' => 'nullable|string',
            'icon' => 'nullable|string',
            'target' => 'nullable|string|in:_self,_blank,_parent,_top',
            'parent_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $menuData = $menu->menu_data ?: [];

            // 복잡한 메뉴 구조를 트리 구조로 변환
            $treeData = $this->convertToTreeStructure($menuData);

            $newItem = [
                'id' => uniqid('menu_'),
                'title' => $request->title,
                'href' => $request->href ?: '#',
                'icon' => $request->icon ?: '',
                'target' => $request->target ?: '_self',
                'children' => []
            ];

            // 부모가 지정된 경우 하위에 추가, 아니면 최상위에 추가
            if ($request->parent_id) {
                $this->addItemToParent($treeData, $request->parent_id, $newItem);
            } else {
                $treeData[] = $newItem;
            }

            // 트리 구조를 원래 복잡한 구조로 변환
            $convertedData = $this->convertTreeToOriginalStructure($treeData, $menu->menu_data);

            // JSON 파일 저장
            $menu->saveJsonData($convertedData);

            return response()->json([
                'success' => true,
                'item' => $newItem,
                'message' => '메뉴 아이템이 추가되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '메뉴 아이템 추가 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 아이템 수정
     */
    public function updateItem(Request $request, $id, $itemId)
    {
        $menu = SiteMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'href' => 'nullable|string',
            'icon' => 'nullable|string',
            'target' => 'nullable|string|in:_self,_blank,_parent,_top',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $menuData = $menu->menu_data ?: [];

            // 복잡한 메뉴 구조를 트리 구조로 변환
            $treeData = $this->convertToTreeStructure($menuData);

            $updated = $this->updateItemInTree($treeData, $itemId, [
                'title' => $request->title,
                'href' => $request->href ?: '#',
                'icon' => $request->icon ?: '',
                'target' => $request->target ?: '_self',
            ]);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => '메뉴 아이템을 찾을 수 없습니다.'
                ], 404);
            }

            // 트리 구조를 원래 복잡한 구조로 변환
            $convertedData = $this->convertTreeToOriginalStructure($treeData, $menu->menu_data);

            // JSON 파일 저장
            $saveResult = $menu->saveJsonData($convertedData);

            if (!$saveResult) {
                return response()->json([
                    'success' => false,
                    'message' => 'JSON 파일 저장에 실패했습니다. 파일 권한을 확인하세요.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => '메뉴 아이템이 수정되었습니다.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Menu item update failed', [
                'menu_id' => $id,
                'item_id' => $itemId,
                'request_data' => $request->all(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => '메뉴 아이템 수정 중 오류가 발생했습니다.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * 메뉴 아이템 삭제
     */
    public function deleteItem(Request $request, $id, $itemId)
    {
        $menu = SiteMenu::findOrFail($id);

        try {
            $menuData = $menu->menu_data ?: [];

            // 복잡한 메뉴 구조를 트리 구조로 변환
            $treeData = $this->convertToTreeStructure($menuData);

            $deleted = $this->deleteItemFromTree($treeData, $itemId);

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => '메뉴 아이템을 찾을 수 없습니다.'
                ], 404);
            }

            // 트리 구조를 원래 복잡한 구조로 변환
            $convertedData = $this->convertTreeToOriginalStructure($treeData, $menu->menu_data);

            // JSON 파일 저장
            $menu->saveJsonData($convertedData);

            return response()->json([
                'success' => true,
                'message' => '메뉴 아이템이 삭제되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '메뉴 아이템 삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 구조 업데이트 (드래그 앤 드롭)
     */
    public function updateStructure(Request $request, $id)
    {
        $menu = SiteMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'menu_data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 트리 구조를 원래 복잡한 구조로 변환
            $convertedData = $this->convertTreeToOriginalStructure($request->menu_data, $menu->menu_data);

            // JSON 파일 저장
            $menu->saveJsonData($convertedData);

            return response()->json([
                'success' => true,
                'message' => '메뉴 구조가 업데이트되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '메뉴 구조 업데이트 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 트리 데이터 가져오기 (AJAX)
     */
    public function getTreeData($id)
    {
        $menu = SiteMenu::findOrFail($id);
        $menu->syncWithJsonFile();

        $rawMenuData = $menu->menu_data ?: [];
        $menuData = $this->convertToTreeStructure($rawMenuData);
        $stats = $this->calculateTreeStats($menuData);

        return response()->json([
            'success' => true,
            'menu_data' => $menuData,
            'stats' => $stats
        ]);
    }

    /**
     * 부모 메뉴에 아이템 추가 (재귀)
     */
    private function addItemToParent(array &$items, string $parentId, array $newItem): bool
    {
        foreach ($items as &$item) {
            // id 키가 존재하는지 확인
            if (isset($item['id']) && $item['id'] === $parentId) {
                if (!isset($item['children'])) {
                    $item['children'] = [];
                }
                $item['children'][] = $newItem;
                return true;
            }

            if (isset($item['children']) && $this->addItemToParent($item['children'], $parentId, $newItem)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 트리에서 아이템 업데이트 (재귀)
     */
    private function updateItemInTree(array &$items, string $itemId, array $updateData): bool
    {
        foreach ($items as &$item) {
            // id 키가 존재하는지 확인
            if (isset($item['id']) && $item['id'] === $itemId) {
                $item = array_merge($item, $updateData);
                return true;
            }

            if (isset($item['children']) && $this->updateItemInTree($item['children'], $itemId, $updateData)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 트리에서 아이템 삭제 (재귀)
     */
    private function deleteItemFromTree(array &$items, string $itemId): bool
    {
        foreach ($items as $index => $item) {
            // id 키가 존재하는지 확인
            if (isset($item['id']) && $item['id'] === $itemId) {
                unset($items[$index]);
                $items = array_values($items); // 인덱스 재정렬
                return true;
            }

            if (isset($item['children']) && $this->deleteItemFromTree($items[$index]['children'], $itemId)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 복잡한 메뉴 구조를 트리 관리용 단순 구조로 변환
     */
    private function convertToTreeStructure(array $rawData): array
    {
        if (empty($rawData)) {
            return [];
        }

        // main_menu 키가 있는 경우 (기존 구조)
        if (isset($rawData['main_menu'])) {
            return $this->convertNavMenuToTree($rawData['main_menu']);
        }

        // 이미 트리 구조인 경우
        if ($this->isSimpleTreeStructure($rawData)) {
            return $rawData;
        }

        // 기타 복잡한 구조를 단순화
        return $this->convertComplexToTree($rawData);
    }

    /**
     * 네비게이션 메뉴를 트리 구조로 변환
     */
    private function convertNavMenuToTree(array $navItems): array
    {
        $treeItems = [];

        foreach ($navItems as $item) {
            $treeItem = [
                'id' => $item['id'] ?? uniqid('item_'),
                'title' => $item['title'] ?? 'Untitled',
                'href' => $item['url'] ?? '#',
                'icon' => $this->extractIcon($item),
                'target' => $item['target'] ?? '_self',
                'children' => []
            ];

            // children 처리
            if (isset($item['children']) && is_array($item['children'])) {
                $treeItem['children'] = $this->convertNavMenuToTree($item['children']);
            }

            $treeItems[] = $treeItem;
        }

        return $treeItems;
    }

    /**
     * 아이콘 추출 (CSS 클래스에서)
     */
    private function extractIcon(array $item): string
    {
        // 직접적인 icon 필드
        if (isset($item['icon'])) {
            return $item['icon'];
        }

        // CSS 클래스에서 아이콘 추출
        $cssClass = $item['css_class'] ?? '';

        // fe fe-* 패턴 찾기
        if (preg_match('/fe fe-[\w-]+/', $cssClass, $matches)) {
            return $matches[0];
        }

        // ti ti-* 패턴 찾기
        if (preg_match('/ti ti-[\w-]+/', $cssClass, $matches)) {
            return $matches[0];
        }

        // bi bi-* 패턴 찾기
        if (preg_match('/bi bi-[\w-]+/', $cssClass, $matches)) {
            return $matches[0];
        }

        return '';
    }

    /**
     * 단순 트리 구조인지 확인
     */
    private function isSimpleTreeStructure(array $data): bool
    {
        if (empty($data)) {
            return true;
        }

        // 첫 번째 요소 확인
        $firstItem = reset($data);

        return is_array($firstItem) &&
               isset($firstItem['id']) &&
               isset($firstItem['title']);
    }

    /**
     * 복잡한 구조를 단순 트리로 변환
     */
    private function convertComplexToTree(array $data): array
    {
        $treeItems = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $treeItem = [
                    'id' => uniqid('item_'),
                    'title' => is_string($key) ? ucfirst($key) : 'Item ' . ($key + 1),
                    'href' => '#',
                    'icon' => '',
                    'target' => '_self',
                    'children' => $this->convertComplexToTree($value)
                ];

                $treeItems[] = $treeItem;
            }
        }

        return $treeItems;
    }

    /**
     * 트리 구조를 원래 복잡한 구조로 변환
     */
    private function convertTreeToOriginalStructure(array $treeData, ?array $originalData): array
    {
        // 원본 데이터가 main_menu 구조를 가지고 있는 경우
        if ($originalData && isset($originalData['main_menu'])) {
            $originalData['main_menu'] = $this->convertTreeToNavMenu($treeData);
            return $originalData;
        }

        // 단순 트리 구조인 경우
        return $treeData;
    }

    /**
     * 트리 구조를 네비게이션 메뉴 구조로 변환
     */
    private function convertTreeToNavMenu(array $treeItems): array
    {
        $navItems = [];

        foreach ($treeItems as $item) {
            $navItem = [
                'id' => $item['id'] ?? uniqid('item_'),
                'title' => $item['title'] ?? 'Untitled',
                'url' => $item['href'] ?? '#',
                'target' => $item['target'] ?? '_self',
                'css_class' => 'nav-link'
            ];

            // 아이콘이 있으면 추가
            if (!empty($item['icon'])) {
                $navItem['icon'] = $item['icon'];
            }

            // 타입 결정
            if (isset($item['children']) && count($item['children']) > 0) {
                $navItem['type'] = 'dropdown';
                $navItem['css_class'] = 'nav-link dropdown-toggle';
                $navItem['dropdown_class'] = 'dropdown-menu';
                $navItem['children'] = $this->convertTreeToNavMenu($item['children']);
            } else {
                $navItem['type'] = 'link';
            }

            $navItems[] = $navItem;
        }

        return $navItems;
    }

    /**
     * 트리 통계 계산
     */
    private function calculateTreeStats(array $treeData): array
    {
        $stats = [
            'total_items' => 0,
            'max_depth' => 0,
            'top_level_items' => count($treeData),
            'items_with_children' => 0,
        ];

        $this->countTreeItems($treeData, $stats, 0);

        return $stats;
    }

    /**
     * 트리 아이템 수 계산 (재귀)
     */
    private function countTreeItems(array $items, array &$stats, int $level): void
    {
        foreach ($items as $item) {
            $stats['total_items']++;
            $stats['max_depth'] = max($stats['max_depth'], $level);

            if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
                $stats['items_with_children']++;
                $this->countTreeItems($item['children'], $stats, $level + 1);
            }
        }
    }
}