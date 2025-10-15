<?php

namespace Jiny\Site\Http\Controllers\Admin\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jiny\Site\Models\SiteMenu;
use Jiny\Site\Models\SiteMenuItem;

/**
 * 메뉴 관리 컨트롤러
 * 트리 구조 메뉴 생성, 수정, 삭제 및 드래그 앤 드롭 지원
 */
class MenuController extends Controller
{
    /**
     * 메뉴 관리 메인 페이지
     */
    public function index(Request $request)
    {
        $query = SiteMenu::query();

        // 검색 기능
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('blade', 'like', "%{$search}%")
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

        $allowedSorts = ['id', 'code', 'enable', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $order);
        }

        $menus = $query->get();

        return view('jiny-site::admin.menu.index', compact('menus'));
    }

    /**
     * 특정 메뉴의 아이템들을 트리 구조로 표시
     */
    public function show($menuId)
    {
        $menu = SiteMenu::findOrFail($menuId);
        $menuItems = SiteMenuItem::getTree($menuId);

        return view('jiny-site::admin.menu.show', compact('menu', 'menuItems'));
    }

    /**
     * 새 메뉴 생성
     */
    public function createMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:site_menus',
            'description' => 'nullable|string',
            'blade' => 'nullable|string',
            'manager' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $menu = SiteMenu::create([
            'code' => $request->code,
            'description' => $request->description,
            'blade' => $request->blade,
            'manager' => $request->manager,
            'enable' => $request->enable ?? true,
        ]);

        return response()->json([
            'success' => true,
            'menu' => $menu
        ]);
    }

    /**
     * 메뉴 수정
     */
    public function updateMenu(Request $request, $menuId)
    {
        $menu = SiteMenu::findOrFail($menuId);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:site_menus,code,' . $menuId,
            'description' => 'nullable|string',
            'blade' => 'nullable|string',
            'manager' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $menu->update($request->only(['code', 'description', 'blade', 'manager', 'enable']));

        return response()->json([
            'success' => true,
            'menu' => $menu
        ]);
    }

    /**
     * 메뉴 삭제
     */
    public function deleteMenu($menuId)
    {
        DB::beginTransaction();
        try {
            // 메뉴에 속한 모든 아이템 먼저 삭제
            SiteMenuItem::where('menu_id', $menuId)->delete();

            // 메뉴 삭제
            SiteMenu::findOrFail($menuId)->delete();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 아이템 생성
     */
    public function createMenuItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:site_menus,id',
            'title' => 'required|string|max:255',
            'href' => 'nullable|string',
            'ref' => 'nullable|integer',
        ]);

        // ref가 0이 아닌 경우에만 존재하는지 검증
        if ($request->ref && $request->ref != 0) {
            $parentExists = SiteMenuItem::where('id', $request->ref)
                ->where('menu_id', $request->menu_id)
                ->exists();

            if (!$parentExists) {
                return response()->json([
                    'success' => false,
                    'errors' => ['ref' => ['선택한 부모 메뉴 아이템이 존재하지 않습니다.']]
                ], 422);
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '입력 데이터가 올바르지 않습니다.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $ref = $request->ref ?? 0;
            $level = $ref == 0 ? 0 : (SiteMenuItem::find($ref)->level + 1);
            $pos = SiteMenuItem::getNextPosition($ref, $request->menu_id);

            $menuItem = SiteMenuItem::create([
                'menu_id' => $request->menu_id,
                'code' => $request->code,
                'enable' => $request->enable ?? true,
                'header' => $request->header,
                'title' => $request->title,
                'name' => $request->name,
                'icon' => $request->icon,
                'href' => $request->href,
                'target' => $request->target,
                'selected' => $request->selected,
                'submenu' => $request->submenu,
                'ref' => $ref,
                'level' => $level,
                'pos' => $pos,
                'description' => $request->description,
                'user_id' => auth()->id() ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'menuItem' => $menuItem->load('children')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '메뉴 아이템 생성 중 오류가 발생했습니다.',
                'error' => app()->hasDebugModeEnabled() ? $e->getMessage() : '시스템 오류'
            ], 500);
        }
    }

    /**
     * 메뉴 아이템 수정
     */
    public function updateMenuItem(Request $request, $itemId)
    {
        $menuItem = SiteMenuItem::findOrFail($itemId);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'href' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $menuItem->update($request->only([
            'code', 'enable', 'header', 'title', 'name', 'icon',
            'href', 'target', 'selected', 'submenu', 'description'
        ]));

        return response()->json([
            'success' => true,
            'menuItem' => $menuItem
        ]);
    }

    /**
     * 메뉴 아이템 삭제
     */
    public function deleteMenuItem($itemId)
    {
        DB::beginTransaction();
        try {
            $menuItem = SiteMenuItem::findOrFail($itemId);

            // 자식 아이템들도 함께 삭제 (재귀적)
            $this->deleteChildrenRecursively($itemId);

            // 현재 아이템 삭제
            $menuItem->delete();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 아이템 삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 드래그 앤 드롭으로 메뉴 구조 업데이트
     */
    public function updateMenuStructure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:site_menu_items,id',
            'items.*.ref' => 'nullable|integer',
            'items.*.pos' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                $menuItem = SiteMenuItem::find($item['id']);
                if ($menuItem) {
                    $ref = $item['ref'] ?? 0;
                    $level = $ref == 0 ? 0 : (SiteMenuItem::find($ref)->level + 1);

                    $menuItem->update([
                        'ref' => $ref,
                        'level' => $level,
                        'pos' => $item['pos']
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => '메뉴 구조 업데이트 중 오류가 발생했습니다.'
            ], 500);
        }
    }

    /**
     * 메뉴 아이템의 자식들을 재귀적으로 삭제
     */
    private function deleteChildrenRecursively($parentId)
    {
        $children = SiteMenuItem::where('ref', $parentId)->get();

        foreach ($children as $child) {
            $this->deleteChildrenRecursively($child->id);
            $child->delete();
        }
    }

    /**
     * 메뉴 트리 데이터를 JSON으로 반환 (AJAX 요청용)
     */
    public function getMenuTree($menuId)
    {
        $menuItems = SiteMenuItem::getTree($menuId);
        return response()->json($menuItems);
    }
}